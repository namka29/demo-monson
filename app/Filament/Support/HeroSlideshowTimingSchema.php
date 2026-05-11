<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;

/**
 * Form (Schema) và chuẩn hoá dữ liệu cho autoplay slideshow — một nơi dùng lại trong admin.
 */
final class HeroSlideshowTimingSchema
{
    public static function section(): Section
    {
        return Section::make('Thời gian chuyển slide')
            ->description('Áp dụng khi có từ 2 slide trong slideshow. Giới hạn: 0 đến 600 giây (10 phút).')
            ->schema([
                Select::make('timing_preset')
                    ->label('Chọn nhanh')
                    ->native(false)
                    ->dehydrated(false)
                    ->options([
                        '__custom__' => 'Tự nhập số giây bên dưới',
                        '0' => 'Không tự đổi — khách chọn chấm dưới banner',
                        '5' => '5 giây',
                        '6.5' => '6,5 giây (mặc định hay dùng)',
                        '10' => '10 giây',
                        '15' => '15 giây',
                        '30' => '30 giây',
                        '60' => '1 phút',
                        '120' => '2 phút',
                        '300' => '5 phút',
                        '600' => '10 phút (tối đa)',
                    ])
                    ->default('__custom__')
                    ->live()
                    ->afterStateUpdated(static function (Set $set, ?string $state): void {
                        if ($state === null || $state === '__custom__') {
                            return;
                        }

                        $set('autoplay_interval_seconds', $state === '0' ? 0.0 : (float) $state);
                    }),
                TextInput::make('autoplay_interval_seconds')
                    ->label('Số giây giữa hai lần đổi slide')
                    ->helperText('0 = chỉ đổi khi khách bấm chấm điều hướng. Thập phân được (ví dụ 7,25).')
                    ->numeric()
                    ->default(fn (): float => round((float) config('tourist.hero_slide_autoplay_ms', 6500) / 1000, 3))
                    ->minValue(0)
                    ->maxValue(600)
                    ->step(0.001)
                    ->suffix('giây')
                    ->rule('numeric')
                    ->rule('min:0')
                    ->rule('max:600')
                    ->required(),
            ])
            ->columns(1);
    }

    /**
     * Chuẩn hoá fill form từ bản ghi hero_slideshow_settings.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateFormDataBeforeFill(array $data): array
    {
        $ms = isset($data['autoplay_interval_ms'])
            ? max(0, min(600_000, (int) $data['autoplay_interval_ms']))
            : max(0, min(600_000, (int) config('tourist.hero_slide_autoplay_ms', 6500)));

        $data['autoplay_interval_ms'] = $ms;
        $seconds = $ms === 0 ? 0.0 : round($ms / 1000, 3);
        $data['autoplay_interval_seconds'] = $seconds;

        $presets = ['0', '5', '6.5', '10', '15', '30', '60', '120', '300', '600'];
        $preset = '__custom__';
        foreach ($presets as $p) {
            if (abs($seconds - (float) $p) < 1e-5) {
                $preset = $p;
                break;
            }
        }
        $data['timing_preset'] = $preset;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function mutateFormDataBeforeSave(array $data): array
    {
        $sec = isset($data['autoplay_interval_seconds'])
            ? (float) $data['autoplay_interval_seconds']
            : 0.0;
        $sec = max(0.0, min(600.0, $sec));

        unset($data['autoplay_interval_seconds'], $data['timing_preset']);

        $data['autoplay_interval_ms'] = (int) round($sec * 1000);

        return $data;
    }
}
