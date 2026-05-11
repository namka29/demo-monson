<?php

namespace App\Http\Middleware;

use App\Models\AdminTrustedDevice;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminTotpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdminPanel()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();
        $allowedRoutes = [
            'admin.totp.challenge',
            'admin.totp.verify',
            'admin.totp.setup',
            'admin.totp.confirm',
            'admin.totp.recovery',
            'filament.admin.auth.logout',
        ];

        if ($routeName && in_array($routeName, $allowedRoutes, true)) {
            return $next($request);
        }

        if (! $user->hasTotpEnabled()) {
            return redirect()->route('admin.totp.setup');
        }

        $verifiedFor = (int) $request->session()->get('admin_totp_verified_user_id', 0);
        if ($verifiedFor !== (int) $user->id) {
            if ($this->restoreFromTrustedDevice($request, (int) $user->id)) {
                return $next($request);
            }

            return redirect()->guest(route('admin.totp.challenge'));
        }

        return $next($request);
    }

    protected function restoreFromTrustedDevice(Request $request, int $userId): bool
    {
        $cookie = (string) $request->cookie('admin_trusted_device', '');
        if ($cookie === '' || ! str_contains($cookie, '|')) {
            return false;
        }

        [$deviceId, $rawToken] = explode('|', $cookie, 2);
        $deviceId = (int) $deviceId;
        if ($deviceId <= 0 || $rawToken === '') {
            return false;
        }

        $device = AdminTrustedDevice::query()
            ->where('id', $deviceId)
            ->where('user_id', $userId)
            ->whereNull('revoked_at')
            ->first();

        if (! $device) {
            return false;
        }

        if ($device->expires_at?->isPast()) {
            $device->update(['revoked_at' => now()]);

            return false;
        }

        $tokenHash = hash('sha256', $rawToken);
        if (! hash_equals($device->token_hash, $tokenHash)) {
            return false;
        }

        $device->forceFill([
            'last_used_at' => now(),
            'ip_address' => (string) $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ])->save();

        $request->session()->put('admin_totp_verified_user_id', $userId);

        return true;
    }
}
