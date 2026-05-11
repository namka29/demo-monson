<?php

namespace App\Filament\Resources;

use App\Contracts\Repositories\HeroBannerRepositoryInterface;
use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Enums\HeroBannerMediaType;
use App\Filament\Resources\HeroBannerResource\Pages;
use App\Models\HeroBanner;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema as SchemaFacade;
use Illuminate\Validation\ValidationException;

use function Filament\Support\original_request;

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Trang chủ';

    protected static ?int $navigationSort = 0;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    public static function getModelLabel(): string
    {
        return 'Slide banner';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Slide banner trang chủ';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Slide banner')
                ->description(
                    'Bật «Trong slideshow» để đưa slide lên trang chủ — có thể bật nhiều slide; thứ tự được lưu ở cột sort_order và kéo-thả trong danh sách (nút «Sắp xếp sau»). Không autoplay trong admin là bình thường.'
                )
                ->schema([
                    TextInput::make('name')
                        ->label('Tên gợi nhớ')
                        ->placeholder('Ví dụ: Tết 2026, Hè xanh…')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('sort_order')
                        ->label('Thứ tự')
                        ->numeric()
                        ->default(fn (): int => app(HeroBannerRepositoryInterface::class)->nextDefaultSortOrder())
                        ->minValue(0)
                        ->maxValue(65535)
                        ->helperText('Số nhỏ hiển thị trước trong slide. Khuyên kéo-thả trong bảng để chỉnh tự động.'),
                    Select::make('media_type')
                        ->label('Loại media')
                        ->options(collect(HeroBannerMediaType::cases())->mapWithKeys(
                            fn (HeroBannerMediaType $t) => [$t->value => $t->label()]
                        ))
                        ->required()
                        ->native(false)
                        ->live(),
                    TextInput::make('image_url')
                        ->label('URL ảnh')
                        ->url()
                        ->maxLength(2048)
                        ->visible(fn ($get) => $get('media_type') === HeroBannerMediaType::ImageUrl->value)
                        ->required(fn ($get) => $get('media_type') === HeroBannerMediaType::ImageUrl->value),
                    FileUpload::make('image_disk_path')
                        ->label('Ảnh tải lên')
                        ->disk('public')
                        ->directory('hero-banners/images')
                        ->visibility('public')
                        ->maxFiles(1)
                        ->acceptedFileTypes([
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif',
                            'image/avif',
                            'image/svg+xml',
                        ])
                        ->maxSize(20480)
                        ->helperText('JPEG, PNG, WebP, GIF, AVIF, SVG — tối đa ~20MB (cần đồng bộ PHP/nginx: upload_max_filesize / client_max_body_size).')
                        ->visible(fn ($get) => $get('media_type') === HeroBannerMediaType::ImageUpload->value)
                        ->required(function ($get, ?HeroBanner $record): bool {
                            if ($get('media_type') !== HeroBannerMediaType::ImageUpload->value) {
                                return false;
                            }

                            return blank($record?->image_disk_path);
                        }),
                    TextInput::make('video_url')
                        ->label('URL video (MP4 / WebM…) — đường dẫn trực tiếp tới file')
                        ->url()
                        ->maxLength(2048)
                        ->visible(fn ($get) => $get('media_type') === HeroBannerMediaType::VideoUrl->value)
                        ->required(fn ($get) => $get('media_type') === HeroBannerMediaType::VideoUrl->value),
                    FileUpload::make('video_disk_path')
                        ->label('File video tải lên')
                        ->disk('public')
                        ->directory('hero-banners/videos')
                        ->visibility('public')
                        ->maxFiles(1)
                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                        ->maxSize(102400)
                        ->visible(fn ($get) => $get('media_type') === HeroBannerMediaType::VideoUpload->value)
                        ->required(function ($get, ?HeroBanner $record): bool {
                            if ($get('media_type') !== HeroBannerMediaType::VideoUpload->value) {
                                return false;
                            }

                            return blank($record?->video_disk_path);
                        }),
                    TextInput::make('youtube_video_id')
                        ->label('YouTube — URL hoặc ID video')
                        ->placeholder('https://www.youtube.com/watch?v=… hoặc dQw4w9WgXcQ')
                        ->maxLength(512)
                        ->visible(fn ($get) => $get('media_type') === HeroBannerMediaType::Youtube->value)
                        ->required(fn ($get) => $get('media_type') === HeroBannerMediaType::Youtube->value),
                    TextInput::make('video_poster_url')
                        ->label('URL ảnh poster (tùy chọn — hiển thị trước khi video chạy)')
                        ->url()
                        ->maxLength(2048)
                        ->visible(fn ($get) => in_array($get('media_type'), [
                            HeroBannerMediaType::VideoUrl->value,
                            HeroBannerMediaType::VideoUpload->value,
                            HeroBannerMediaType::Youtube->value,
                        ], true)),
                    FileUpload::make('video_poster_disk_path')
                        ->label('Ảnh poster tải lên')
                        ->disk('public')
                        ->directory('hero-banners/posters')
                        ->visibility('public')
                        ->maxFiles(1)
                        ->acceptedFileTypes([
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif',
                            'image/avif',
                        ])
                        ->maxSize(8192)
                        ->visible(fn ($get) => in_array($get('media_type'), [
                            HeroBannerMediaType::VideoUrl->value,
                            HeroBannerMediaType::VideoUpload->value,
                            HeroBannerMediaType::Youtube->value,
                        ], true)),
                    Toggle::make('is_active')
                        ->label('Trong slideshow trang chủ')
                        ->helperText('Có thể bật nhiều slide; thứ tự theo # và kéo-thả trong bảng. Thời gian chuyển slide: menu «Slide banner» → «Thời gian slideshow» hoặc nút cùng tên đầu trang danh sách (env TOURISM_HERO_SLIDE_AUTOPLAY_MS chỉ là dự phòng).')
                        ->default(false),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm slide'),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Trên trang chủ')
                    ->options([
                        '1' => 'Đang bật',
                        '0' => 'Đang tắt',
                    ])
                    ->native(false),
            ])
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('media_type')
                    ->label('Loại')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        $t = $state instanceof HeroBannerMediaType
                            ? $state
                            : HeroBannerMediaType::from((string) $state);

                        return $t->label();
                    }),
                ToggleColumn::make('is_active')
                    ->label('Trình chiếu')
                    ->onIcon('heroicon-o-play')
                    ->offIcon('heroicon-o-stop'),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()->label('Sửa'),
                DeleteAction::make()->label('Xóa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('slideshowOn')
                        ->label('Bật trình chiếu')
                        ->icon('heroicon-o-play')
                        ->requiresConfirmation(false)
                        ->action(function (\Illuminate\Support\Collection $records): void {
                            $records->each(fn (HeroBanner $b) => $b->update(['is_active' => true]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('slideshowOff')
                        ->label('Tắt trình chiếu')
                        ->icon('heroicon-o-stop')
                        ->action(function (\Illuminate\Support\Collection $records): void {
                            $records->each(fn (HeroBanner $b) => $b->update(['is_active' => false]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make()->label('Xóa đã chọn'),
                ]),
            ]);
    }

    /**
     * @return array<int, NavigationItem>
     */
    public static function getNavigationItems(): array
    {
        if (! static::hasPage('index')) {
            return [];
        }

        $label = static::getPluralModelLabel();
        $group = static::getNavigationGroup();
        $routeBaseName = static::getRouteBaseName();
        $listPattern = $routeBaseName . '.*';
        $timingRouteName = $routeBaseName . '.slideshow-timing';
        $sort = static::getNavigationSort();

        $items = [
            NavigationItem::make($label)
                ->group($group)
                ->parentItem(static::getNavigationParentItem())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(fn (): bool => original_request()->routeIs($listPattern)
                    && ! original_request()->routeIs($timingRouteName))
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->badgeTooltip(static::getNavigationBadgeTooltip())
                ->sort($sort)
                ->url(static::getNavigationUrl()),
        ];

        if (SchemaFacade::hasTable('hero_slideshow_settings')) {
            $slideshowRow = app(HeroSlideshowSettingRepositoryInterface::class)->firstOrNull();
            if ($slideshowRow !== null && Gate::allows('update', $slideshowRow)) {
                $items[] = NavigationItem::make('Thời gian slideshow')
                    ->group($group)
                    ->parentItem($label)
                    ->icon('heroicon-o-clock')
                    ->isActiveWhen(fn (): bool => original_request()->routeIs($timingRouteName))
                    ->sort($sort !== null ? $sort + 1 : null)
                    ->url(static::getUrl('slideshow-timing'));
            }
        }

        return $items;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroBanners::route('/'),
            'slideshow-timing' => Pages\ManageBannerSlideshowTiming::route('/slideshow-timing'),
            'create' => Pages\CreateHeroBanner::route('/create'),
            'edit' => Pages\EditHeroBanner::route('/{record}/edit'),
        ];
    }

    /**
     * Chuẩn hoá & kiểm tra YouTube trước khi lưu (gọi từ trang Create/Edit).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function validateYoutubeInFormData(array $data): array
    {
        if (($data['media_type'] ?? null) !== HeroBannerMediaType::Youtube->value) {
            return $data;
        }

        $raw = $data['youtube_video_id'] ?? null;
        $id = is_string($raw) ? HeroBanner::normalizeYoutubeInput($raw) : null;
        if ($id === null) {
            throw ValidationException::withMessages([
                'youtube_video_id' => ['Nhập đúng link YouTube hoặc mã video (11 ký tự).'],
            ]);
        }
        $data['youtube_video_id'] = $id;

        return $data;
    }
}
