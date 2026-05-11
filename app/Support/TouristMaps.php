<?php

namespace App\Support;

final class TouristMaps
{
    /**
     * Cho phép nhúng iframe khi có cặp tọa độ số nằm trong phạm vi WGS84 thông thường.
     */
    public static function canEmbedIframe(mixed $latitude, mixed $longitude): bool
    {
        if ($latitude === null || $longitude === null) {
            return false;
        }

        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            return false;
        }

        $lat = (float) $latitude;
        $lng = (float) $longitude;

        if ($lat < -90.0 || $lat > 90.0 || $lng < -180.0 || $lng > 180.0) {
            return false;
        }

        return true;
    }

    /**
     * Chỉ dùng Leaflet/OSM khi maps_driver = leaflet.
     * Mặc định: Google Maps qua iframe (không cần API key).
     */
    public static function showLeaflet(): bool
    {
        return (string) config('tourist.maps_driver', 'google') === 'leaflet';
    }

    /**
     * URL iframe Google Maps: nhúng tìm kiếm theo tọa độ (output=embed), không dùng Maps Platform key.
     */
    public static function googleIframeSrc(float|string $lat, float|string $lng): string
    {
        return 'https://maps.google.com/maps?'.http_build_query([
            'q' => "{$lat},{$lng}",
            'z' => 14,
            'output' => 'embed',
            'hl' => 'vi',
        ]);
    }

    /**
     * Mở Google Maps (tab mới) tại tọa độ.
     */
    public static function googleMapsExternalUrl(float|string $lat, float|string $lng): string
    {
        return 'https://www.google.com/maps?q='.urlencode("{$lat},{$lng}").'&hl=vi';
    }
}
