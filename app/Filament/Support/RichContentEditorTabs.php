<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\HtmlString;
use Stevebauman\Purify\Facades\Purify;

/**
 * Tabs Soạn thảo (RichEditor + ảnh đính kèm public disk) và Xem trước (HTML đã làm sạch như trên website).
 */
final class RichContentEditorTabs
{
    public static function make(
        string $name,
        string $storageSubdir,
        string $label,
        bool $required = true,
        ?string $helperText = null,
    ): Tabs {
        $dir = 'rich-content/'.trim($storageSubdir, '/');

        return Tabs::make()
            ->columnSpanFull()
            ->tabs([
                Tab::make('Soạn thảo')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        RichEditor::make($name)
                            ->label($label)
                            ->required($required)
                            ->helperText($helperText ?? 'Định dạng đậm/nghiêng/tiêu đề/danh sách/link; chèn ảnh từ nút trong thanh công cụ. Hiển thị công khai qua Purify như các trang chi tiết.')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory($dir)
                            ->fileAttachmentsAcceptedFileTypes([
                                'image/png',
                                'image/jpeg',
                                'image/gif',
                                'image/webp',
                                'image/avif',
                            ])
                            ->fileAttachmentsMaxSize(10240)
                            ->debounce(400)
                            ->columnSpanFull(),
                    ]),
                Tab::make('Xem trước')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Html::make(
                            static function (Get $get) use ($name): HtmlString {
                                $html = $get($name);
                                $html = is_string($html) ? $html : '';

                                if (trim($html) === '') {
                                    return new HtmlString(
                                        '<p class="text-sm italic text-gray-500 dark:text-gray-400">Chưa có nội dung.</p>'
                                    );
                                }

                                $clean = Purify::clean($html);

                                return new HtmlString(
                                    '<div class="filament-rich-preview ring-1 ring-gray-950/10 dark:ring-white/15 rounded-xl bg-white dark:bg-gray-950 p-4 text-[15px] leading-relaxed text-gray-950 dark:text-gray-100 max-h-[min(70vh,36rem)] overflow-y-auto [&_img]:max-w-full [&_img]:h-auto [&_p]:my-2 [&_ul]:my-2 [&_ol]:my-2 [&_h1]:text-2xl [&_h2]:text-xl [&_h3]:text-lg [&_a]:underline [&_blockquote]:border-l-4 [&_blockquote]:border-gray-300 [&_blockquote]:pl-4">'
                                        .$clean
                                        .'</div>'
                                );
                            }
                        )->columnSpanFull(),
                    ]),
            ]);
    }
}
