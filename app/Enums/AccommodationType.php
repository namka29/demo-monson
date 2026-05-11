<?php

namespace App\Enums;

enum AccommodationType: string
{
    case Resort = 'resort';
    case Hotel = 'hotel';
    case Homestay = 'homestay';
    case Bungalow = 'bungalow';
    case GuestHouse = 'guest_house';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Resort => 'Resort',
            self::Hotel => 'Khách sạn',
            self::Homestay => 'Homestay',
            self::Bungalow => 'Bungalow',
            self::GuestHouse => 'Nhà nghỉ / nhà khách',
            self::Other => 'Khác',
        };
    }
}
