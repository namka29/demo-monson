<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\Pages\CreateRecordWide;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecordWide
{
    protected static string $resource = UserResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (blank($data['password'] ?? null)) {
            throw ValidationException::withMessages([
                'data.password' => 'Vui lòng nhập mật khẩu cho tài khoản mới.',
            ]);
        }

        return $data;
    }
}
