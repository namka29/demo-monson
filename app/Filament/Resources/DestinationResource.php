<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Support\GoogleMapCoordinatePreview;
use App\Filament\Support\RichContentEditorTabs;
use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
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

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    public static function getModelLabel(): string
    {
        return 'Điểm đến';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Điểm đến';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Thông tin điểm đến')
                ->description('Điền tên và mô tả hiển thị trên website công khai khi trạng thái là «Đã xuất bản».')
                ->schema([
                    TextInput::make('name')
                        ->label('Tên điểm đến')
                        ->placeholder('Ví dụ: Đền thờ Làng X, Khu di tích Y…')
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
                        ->placeholder('vi-du-diem-den')
                        ->maxLength(255)
                        ->helperText('Để trống để hệ thống tự tạo từ tên khi lưu. Chỉ nên dùng chữ thường, số và dấu gạch ngang.'),
                    RichContentEditorTabs::make(
                        'description',
                        'destinations',
                        'Mô tả chi tiết',
                        required: false,
                    ),
                    TextInput::make('image_url')
                        ->label('Ảnh đại diện (URL)')
                        ->url()
                        ->maxLength(2048)
                        ->placeholder('https://…')
                        ->helperText('Địa chỉ ảnh HTTPS hiển thị trên danh sách và trang chi tiết (ví dụ ảnh từ Unsplash hoặc CDN).')
                        ->columnSpanFull(),
                    TextInput::make('latitude')
                        ->label('Vĩ độ')
                        ->numeric()
                        ->live(onBlur: true)
                        ->placeholder('21.0285')
                        ->helperText('Tùy chọn. Dùng cho bản đồ sau này (định dạng số thập phân).'),
                    TextInput::make('longitude')
                        ->label('Kinh độ')
                        ->numeric()
                        ->live(onBlur: true)
                        ->placeholder('105.8542')
                        ->helperText('Tùy chọn. Đi cùng vĩ độ để đặt vị trí trên bản đồ.'),
                    GoogleMapCoordinatePreview::filamentField(),
                    Select::make('status')
                        ->label('Trạng thái')
                        ->options(collect(PublicationStatus::cases())->mapWithKeys(fn (PublicationStatus $s) => [$s->value => $s->label()]))
                        ->required()
                        ->native(false)
                        ->helperText('«Bản nháp» chỉ thấy trong admin; «Đã xuất bản» hiển thị trên website.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm điểm đến'),
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
                TextColumn::make('slug')
                    ->label('Slug')
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
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
