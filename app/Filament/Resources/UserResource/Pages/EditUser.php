<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\Pages\EditRecordWide;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;

class EditUser extends EditRecordWide
{
    protected static string $resource = UserResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['password'], $data['remember_token']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset2fa')
                ->label('Reset 2FA')
                ->icon('heroicon-o-shield-exclamation')
                ->color('warning')
                ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false)
                ->requiresConfirmation()
                ->modalHeading('Reset xác thực 2 lớp')
                ->modalDescription('Xoá secret TOTP, mã khôi phục và toàn bộ thiết bị tin cậy của tài khoản này.')
                ->action(function (): void {
                    DB::transaction(function (): void {
                        $this->record->trustedDevices()->whereNull('revoked_at')->update(['revoked_at' => now()]);
                        $this->record->forceFill([
                            'two_factor_secret' => null,
                            'two_factor_recovery_codes' => null,
                            'two_factor_confirmed_at' => null,
                        ])->save();
                    });
                })
                ->successNotificationTitle('Đã reset 2FA'),
            Action::make('revokeTrustedDevices')
                ->label('Revoke thiết bị tin cậy')
                ->icon('heroicon-o-device-phone-mobile')
                ->color('gray')
                ->visible(fn (): bool => ($this->record->trustedDevices()->whereNull('revoked_at')->count() > 0) && (auth()->user()?->isAdmin() ?? false))
                ->requiresConfirmation()
                ->modalHeading('Thu hồi thiết bị tin cậy')
                ->modalDescription('Tài khoản này sẽ phải nhập lại mã 2FA ở lần đăng nhập tiếp theo trên thiết bị đã tin cậy.')
                ->action(function (): void {
                    $this->record->trustedDevices()->whereNull('revoked_at')->update(['revoked_at' => now()]);
                })
                ->successNotificationTitle('Đã thu hồi thiết bị tin cậy'),
        ];
    }
}
