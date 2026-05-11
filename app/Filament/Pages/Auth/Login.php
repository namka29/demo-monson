<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                Checkbox::make('trust_device')
                    ->label('Tin cậy thiết bị này (ghi nhớ cho bước xác thực 2 lớp)')
                    ->helperText('Nếu chọn, tùy chọn này sẽ được áp dụng sẵn ở màn nhập mã OTP.')
                    ->default(false),
            ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if ($response) {
            // Chỉ đọc form sau khi parent xử lý đăng nhập, tránh làm lệch state (ví dụ remember me).
            $state = $this->form->getState();
            session()->put(
                'admin_totp_trust_device',
                (bool) ($state['trust_device'] ?? false),
            );
        }

        return $response;
    }
}
