<?php

namespace App\Filament\Support;

use App\Support\TouristMaps;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\HtmlString;

final class GoogleMapCoordinatePreview
{
    public static function filamentField(): Html
    {
        return Html::make(static function (Get $get): HtmlString {
            return self::toHtmlString($get('latitude'), $get('longitude'));
        })->columnSpanFull();
    }

    public static function toHtmlString(mixed $latitude, mixed $longitude): HtmlString
    {
        if (! TouristMaps::canEmbedIframe($latitude, $longitude)) {
            return new HtmlString(
                '<div class="space-y-2">'
                .'<p class="text-sm font-medium text-gray-950 dark:text-white">Xem trước bản đồ</p>'
                .'<p class="text-sm text-gray-500 dark:text-gray-400">Nhập đủ vĩ độ và kinh độ hợp lệ (WGS84; vĩ độ −90…90°, kinh độ −180…180°) để xem trước bản đồ Google Maps.</p>'
                .'</div>'
            );
        }

        $lat = (float) $latitude;
        $lng = (float) $longitude;
        $iframeSrc = TouristMaps::googleIframeSrc($lat, $lng);
        $externalUrl = TouristMaps::googleMapsExternalUrl($lat, $lng);

        return new HtmlString(
            '<div class="space-y-3">'
            .'<p class="text-sm font-medium text-gray-950 dark:text-white">Xem trước bản đồ</p>'
            .'<div class="overflow-hidden rounded-xl ring-1 ring-gray-950/10 dark:ring-white/15">'
            .'<iframe class="block h-[20rem] w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen src="'.e($iframeSrc).'" title="Xem trước vị trí trên bản đồ"></iframe>'
            .'</div>'
            .'<p class="text-sm text-gray-500 dark:text-gray-400">Tọa độ hiện tại: <span class="font-mono text-gray-700 dark:text-gray-200">'.e((string) $lat).', '.e((string) $lng).'</span> — <a class="font-medium text-primary-600 underline hover:text-primary-500" href="'.e($externalUrl).'" target="_blank" rel="noopener noreferrer">Mở trên Google Maps</a></p>'
            .'</div>'
        );
    }
}
