<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlideshowSetting extends Model
{
    /** @inheritDoc */
    protected $fillable = [
        'autoplay_interval_ms',
    ];

    protected static function booted(): void
    {
        static::saving(static function (HeroSlideshowSetting $model): void {
            $model->autoplay_interval_ms = max(0, min(600_000, (int) $model->autoplay_interval_ms));
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'autoplay_interval_ms' => 'integer',
        ];
    }

}
