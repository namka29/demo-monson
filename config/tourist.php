<?php

$tourismHeadlineLine1 = env('TOURISM_HEADLINE_LINE1', 'Cổng thông tin du lịch');
$tourismHeadlineLine2 = env('TOURISM_HEADLINE_LINE2', 'xã Môn Sơn, Nghệ An');

return [

    /*
    |--------------------------------------------------------------------------
    | Public contact line (optional)
    |--------------------------------------------------------------------------
    |
    | Shown in the top bar, similar to official tourism portals.
    |
    */

    'hotline' => env('TOURISM_HOTLINE'),

    'hotline_hours' => env('TOURISM_HOTLINE_HOURS', 'Các ngày trong tuần 09:00 ~ 18:00'),

    'support_email' => env('TOURISM_SUPPORT_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Masthead công khai (2 dòng) + tiêu đề dạng một chuỗi (footer ©, Filament, <title> mặc định)
    |--------------------------------------------------------------------------
    |
    | TOURISM_SITE_TITLE — ghi đè chuỗi đơn khi cần; mặc định ghép từ 2 headline.
    |
    */

    'headline_line1' => $tourismHeadlineLine1,

    'headline_line2' => $tourismHeadlineLine2,

    'site_title' => env(
        'TOURISM_SITE_TITLE',
        "{$tourismHeadlineLine1} — {$tourismHeadlineLine2}",
    ),

    /*
    |--------------------------------------------------------------------------
    | Marketing copy
    |--------------------------------------------------------------------------
    */

    'hero_tagline' => env('TOURISM_HERO_TAGLINE', 'Vùng đất địa linh nhân kiệt — thiên nhiên hùng vĩ, lịch sử hào hùng và văn hóa đậm đà bản sắc'),

    /*
    | Ảnh nền banner trang chủ (URL tuyệt đối). Mặc định: ảnh minh họa (Unsplash).
    */
    'hero_background_url' => env(
        'TOURISM_HERO_IMAGE_URL',
        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80',
    ),

    /*
    | Thời gian mỗi slide (ms). `0` để chỉ đổi slide bằng nút.
    */
    /*
    | 0 = chỉ đổi slide khi khách dùng chấm. Tối đa tương đương 10 phút (600 000 ms). Admin có form đầy đủ trong «Slideshow banner».
    */
    'hero_slide_autoplay_ms' => max(
        0,
        min(600_000, (int) env('TOURISM_HERO_SLIDE_AUTOPLAY_MS', 6500)),
    ),

    /*
    |--------------------------------------------------------------------------
    | Bản đồ điểm đến (trang chi tiết)
    |--------------------------------------------------------------------------
    |
    | Mặc định: Google Maps (iframe, nhúng output=embed — không cần API key).
    | TOURISM_MAPS_DRIVER=leaflet — dùng OpenStreetMap + Leaflet thay vì Google.
    |
    */

    'maps_driver' => env('TOURISM_MAPS_DRIVER', 'google'),

    /*
    |--------------------------------------------------------------------------
    | Security settings for admin panel
    |--------------------------------------------------------------------------
    */
    'security' => [
        'trusted_device_days' => max(1, (int) env('TOURISM_TRUSTED_DEVICE_DAYS', 30)),
    ],

];
