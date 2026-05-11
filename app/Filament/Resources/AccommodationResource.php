<?php

namespace App\Filament\Resources;

use App\Enums\AccommodationType;
use App\Filament\Support\GoogleMapCoordinatePreview;
use App\Filament\Support\RichContentEditorTabs;
use App\Enums\PublicationStatus;
use App\Filament\Resources\AccommodationResource\Pages;
use App\Models\Accommodation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AccommodationResource extends Resource
{
    protected static ?string $model = Accommodation::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 5;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    public static function getModelLabel(): string
    {
        return 'Lưu trú';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Lưu trú';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Cơ sở lưu trú')
                ->description('Khách sạn, homestay, resort… hiển thị tại /luu-tru khi «Đã xuất bản».')
                ->schema([
                    TextInput::make('name')
                        ->label('Tên cơ sở')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set, $get): void {
                            if (filled($get('slug'))) {
                                return;
                            }
                            $set('slug', Str::slug((string) $state));
                        }),
                    TextInput::make('slug')
                        ->label('Đường dẫn (slug)')
                        ->maxLength(255),
                    Select::make('accommodation_type')
                        ->label('Loại hình')
                        ->options(collect(AccommodationType::cases())->mapWithKeys(fn (AccommodationType $t) => [$t->value => $t->label()]))
                        ->required()
                        ->native(false),
                    RichContentEditorTabs::make(
                        'description',
                        'accommodations',
                        'Giới thiệu',
                        required: false,
                    ),
                    TextInput::make('address')
                        ->label('Địa chỉ')
                        ->maxLength(512)
                        ->columnSpanFull(),
                    TextInput::make('latitude')
                        ->label('Vĩ độ')
                        ->numeric()
                        ->live(onBlur: true)
                        ->placeholder('21.0285')
                        ->helperText('Tùy chọn. Dùng cho bản đồ nhúng khi đăng cùng kinh độ (WGS84).'),
                    TextInput::make('longitude')
                        ->label('Kinh độ')
                        ->numeric()
                        ->live(onBlur: true)
                        ->placeholder('105.8542')
                        ->helperText('Tùy chọn. Đi cùng vĩ độ để hiển thị iframe Google Maps trên website và xem trước ở đây.'),
                    GoogleMapCoordinatePreview::filamentField(),
                    TextInput::make('price_hint')
                        ->label('Khoảng giá (gợi ý)')
                        ->placeholder('Ví dụ: 800.000đ – 1.500.000đ / đêm')
                        ->maxLength(128),
                    TextInput::make('contact_phone')
                        ->label('Điện thoại liên hệ')
                        ->tel()
                        ->maxLength(32),
                    TextInput::make('image_url')
                        ->label('Ảnh đại diện (URL)')
                        ->url()
                        ->maxLength(2048)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label('Trạng thái')
                        ->options(collect(PublicationStatus::cases())->mapWithKeys(fn (PublicationStatus $s) => [$s->value => $s->label()]))
                        ->required()
                        ->native(false),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()->label('Thêm cơ sở'),
            ])
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->height(40)
                    ->square()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('accommodation_type')
                    ->label('Loại')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof AccommodationType
                        ? $state->label()
                        : AccommodationType::from((string) $state)->label()),
                TextColumn::make('price_hint')
                    ->label('Giá gợi ý')
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(function ($state): string {
                        $s = $state instanceof PublicationStatus
                            ? $state
                            : PublicationStatus::from((string) $state);

                        return $s->label();
                    }),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(collect(PublicationStatus::cases())->mapWithKeys(fn (PublicationStatus $s) => [$s->value => $s->label()])),
                SelectFilter::make('accommodation_type')
                    ->label('Loại hình')
                    ->options(collect(AccommodationType::cases())->mapWithKeys(fn (AccommodationType $t) => [$t->value => $t->label()])),
            ])
            ->defaultSort('updated_at', 'desc')
            ->recordActions([
                EditAction::make()->label('Sửa'),
                DeleteAction::make()->label('Xóa'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Xóa đã chọn'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccommodations::route('/'),
            'create' => Pages\CreateAccommodation::route('/create'),
            'edit' => Pages\EditAccommodation::route('/{record}/edit'),
        ];
    }
}
