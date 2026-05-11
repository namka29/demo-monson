<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Quản trị viên',
            self::Editor => 'Biên tập viên',
        };
    }

    public function canAccessPanel(): bool
    {
        return match ($this) {
            self::Admin, self::Editor => true,
        };
    }
}
