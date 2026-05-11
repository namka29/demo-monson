<?php

namespace App\Enums;

enum HeroBannerMediaType: string
{
    case ImageUrl = 'image_url';
    case ImageUpload = 'image_upload';
    case VideoUrl = 'video_url';
    case VideoUpload = 'video_upload';
    case Youtube = 'youtube';

    public function label(): string
    {
        return match ($this) {
            self::ImageUrl => 'Ảnh — URL ngoài',
            self::ImageUpload => 'Ảnh — tải lên máy chủ',
            self::VideoUrl => 'Video — URL (MP4…)',
            self::VideoUpload => 'Video — tải lên (MP4)',
            self::Youtube => 'YouTube — nhúng video',
        };
    }

    public function isVideo(): bool
    {
        return match ($this) {
            self::VideoUrl, self::VideoUpload, self::Youtube => true,
            default => false,
        };
    }
}
