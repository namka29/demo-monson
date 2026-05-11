<?php

use Stevebauman\Purify\Definitions\Html5Definition;

return [

    /*
    |--------------------------------------------------------------------------
    | Default config
    |--------------------------------------------------------------------------
    |
    | When Purify::clean() không chỉ định config, set «default» dưới đây được dùng.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Config sets
    |--------------------------------------------------------------------------
    |
    | Tài liệu: http://htmlpurifier.org/live/configdoc/plain.html
    |
    */

    'configs' => [

        'default' => [
            'Core.Encoding' => 'utf-8',
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => implode(',', [
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'b', 'u', 'strong', 'i', 'em', 's', 'del', 'sub', 'sup',
                'a[href|title|rel|target]',
                'ul', 'ol', 'li',
                'p[style]',
                'br',
                'span[style]',
                // Không dùng loading trên img — HTMLPurifier (kể cả Html5Definition) không đăng ký attribute này và sẽ ném lỗi khi khai trong HTML.Allowed.
                'img[src|alt|width|height|class]',
                'blockquote',
                'pre',
                'code',
                'figure[class]',
                'figcaption[class]',
                'hr',
                'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
            ]),
            'HTML.ForbiddenElements' => '',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => false,
        ],

    ],

    'definitions' => Html5Definition::class,

    'css-definitions' => null,

    /*
     * Với Laravel cache «database», HTMLPurifier có thể lỗi unserialize — dùng file disk (mặc định v6).
     */
    'serializer' => [
        'disk' => env('FILESYSTEM_DISK', 'local'),
        'path' => 'purify',
        'cache' => \Stevebauman\Purify\Cache\FilesystemDefinitionCache::class,
    ],

];
