<?php

namespace App\Enums;

enum SpecialtyCategory: string
{
    case Food = 'food';
    case Beverage = 'beverage';
    case Ocop = 'ocop';
    case Craft = 'craft';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Food => 'Ẩm thực / đặc sản ăn',
            self::Beverage => 'Đồ uống',
            self::Ocop => 'Sản phẩm OCOP',
            self::Craft => 'Làng nghề / thủ công',
            self::Other => 'Khác',
        };
    }
}
