<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminTrustedDevice;
use App\Support\TotpAuthenticator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminTotpController extends Controller
{
    public function __construct(
        protected TotpAuthenticator $totp,
    ) {
    }

    public function showChallenge(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return redirect()->route('filament.admin.auth.login');
        }

        if (! $user->hasTotpEnabled()) {
            return redirect()->route('admin.totp.setup');
        }

        return view('admin.totp.challenge', [
            'trustedDeviceDays' => max(1, (int) config('tourist.security.trusted_device_days', 30)),
            'trustDeviceDefault' => (bool) $request->session()->get('admin_totp_trust_device', false),
        ]);
    }

    public function verifyChallenge(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return redirect()->route('filament.admin.auth.login');
        }

        $key = $this->attemptKey('challenge', $request);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'code' => 'Bạn nhập sai quá nhiều lần. Vui lòng chờ 1 phút rồi thử lại.',
            ]);
        }

        $data = $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'trust_device' => ['nullable', 'boolean'],
        ]);

        $valid = false;
        $secret = (string) ($user->two_factor_secret ?? '');
        if ($secret !== '') {
            $valid = $this->totp->verifyCode($secret, preg_replace('/\s+/', '', $data['code']) ?? '');
        }

        if (! $valid) {
            RateLimiter::hit($key, 60);

            return back()->withErrors([
                'code' => 'Mã xác thực không đúng.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->put('admin_totp_verified_user_id', (int) $user->id);

        $response = redirect()->intended('/admin');
        $trustDevice = (bool) ($data['trust_device'] ?? $request->session()->get('admin_totp_trust_device', false));
        if ($trustDevice) {
            $this->issueTrustedDeviceCookie($request, $response, $user->id);
        }
        $request->session()->forget('admin_totp_trust_device');

        return $response;
    }

    public function showSetup(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return redirect()->route('filament.admin.auth.login');
        }

        if ($user->hasTotpEnabled()) {
            return redirect()->route('admin.totp.challenge');
        }

        $pendingSecret = (string) $request->session()->get('admin_totp_pending_secret');
        if ($pendingSecret === '') {
            $pendingSecret = $this->totp->generateSecret();
            $request->session()->put('admin_totp_pending_secret', $pendingSecret);
        }

        $issuer = config('app.name', 'Tourist Admin');
        $otpAuthUri = $this->totp->makeOtpAuthUri($pendingSecret, (string) $user->email, $issuer);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data='.rawurlencode($otpAuthUri);

        return view('admin.totp.setup', [
            'secret' => $pendingSecret,
            'otpAuthUri' => $otpAuthUri,
            'qrUrl' => $qrUrl,
            'recoveryCodes' => $request->session()->pull('admin_totp_recovery_codes', []),
        ]);
    }

    public function confirmSetup(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return redirect()->route('filament.admin.auth.login');
        }

        $key = $this->attemptKey('setup', $request);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'code' => 'Bạn nhập sai quá nhiều lần. Vui lòng chờ 1 phút rồi thử lại.',
            ]);
        }

        $data = $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $pendingSecret = (string) $request->session()->get('admin_totp_pending_secret');
        if ($pendingSecret === '') {
            return redirect()->route('admin.totp.setup')
                ->withErrors(['code' => 'Phiên thiết lập đã hết hạn. Vui lòng quét lại mã QR.']);
        }

        $valid = $this->totp->verifyCode($pendingSecret, preg_replace('/\s+/', '', $data['code']) ?? '');
        if (! $valid) {
            RateLimiter::hit($key, 60);

            return back()->withErrors([
                'code' => 'Mã xác thực không đúng.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->forget('admin_totp_pending_secret');

        $recoveryCodes = collect(range(1, 8))
            ->map(fn (): string => Str::upper(Str::random(4)).'-'.Str::upper(Str::random(4)))
            ->values()
            ->all();

        $user->forceFill([
            'two_factor_secret' => $pendingSecret,
            'two_factor_recovery_codes' => json_encode(array_map(fn (string $code): string => Hash::make($code), $recoveryCodes), JSON_THROW_ON_ERROR),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $request->session()->put('admin_totp_verified_user_id', (int) $user->id);
        $request->session()->put('admin_totp_recovery_codes', $recoveryCodes);

        return redirect()->route('admin.totp.setup')
            ->with('status', 'Đã bật xác thực 2 lớp thành công.');
    }

    public function useRecoveryCode(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return redirect()->route('filament.admin.auth.login');
        }

        $data = $request->validate([
            'recovery_code' => ['required', 'string', 'max:32'],
            'trust_device' => ['nullable', 'boolean'],
        ]);

        $code = strtoupper(trim($data['recovery_code']));
        $hashedCodes = $user->getRecoveryCodes();

        foreach ($hashedCodes as $index => $hashedCode) {
            if (Hash::check($code, $hashedCode)) {
                unset($hashedCodes[$index]);
                $user->forceFill([
                    'two_factor_recovery_codes' => json_encode(array_values($hashedCodes), JSON_THROW_ON_ERROR),
                ])->save();

                $request->session()->put('admin_totp_verified_user_id', (int) $user->id);

                $response = redirect()->intended('/admin');
                $trustDevice = (bool) ($data['trust_device'] ?? $request->session()->get('admin_totp_trust_device', false));
                if ($trustDevice) {
                    $this->issueTrustedDeviceCookie($request, $response, $user->id);
                }
                $request->session()->forget('admin_totp_trust_device');

                return $response;
            }
        }

        return back()->withErrors([
            'recovery_code' => 'Mã khôi phục không hợp lệ.',
        ]);
    }

    protected function attemptKey(string $action, Request $request): string
    {
        return sprintf(
            'totp:%s:%d:%s',
            $action,
            (int) optional($request->user())->id,
            (string) $request->ip(),
        );
    }

    protected function issueTrustedDeviceCookie(Request $request, RedirectResponse $response, int $userId): void
    {
        $rawToken = Str::random(64);
        $expiresDays = max(1, (int) config('tourist.security.trusted_device_days', 30));
        $expiresAt = now()->addDays($expiresDays);

        $device = AdminTrustedDevice::query()->create([
            'user_id' => $userId,
            'token_hash' => hash('sha256', $rawToken),
            'device_name' => Str::limit((string) $request->userAgent(), 120, '...'),
            'ip_address' => (string) $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'last_used_at' => now(),
            'expires_at' => $expiresAt,
        ]);

        Cookie::queue(
            Cookie::make(
                name: 'admin_trusted_device',
                value: $device->id.'|'.$rawToken,
                minutes: $expiresDays * 24 * 60,
                path: '/',
                domain: null,
                secure: (bool) config('session.secure'),
                httpOnly: true,
                raw: false,
                sameSite: 'lax',
            ),
        );
    }
}
