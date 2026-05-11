<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Support\RichContentEditorTabs;
use App\Filament\Resources\EventResource\Pages;
use App\Models\Event as EventRecord;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
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

class EventResource extends Resource
{
    protected static ?string $model = EventRecord::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    public static function getModelLabel(): string
    {
        return 'Sự kiện';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sự kiện';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Thông tin sự kiện')
                ->description('Lễ hội, hoạt động du lịch. Website chỉ hiển thị khi trạng thái là «Đã xuất bản».')
                ->schema([
                    TextInput::make('title')
                        ->label('Tiêu đề')
                        ->placeholder('Ví dụ: Lễ hội làng…, Hội chợ OCOP…')
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
                        ->placeholder('le-hoi-lang-vi-du')
                        ->maxLength(255)
                        ->helperText('Để trống để hệ thống tự tạo từ tiêu đề khi lưu.'),
                    RichContentEditorTabs::make(
                        'description',
                        'events',
                        'Nội dung / giới thiệu',
                        required: false,
                    ),
                    TextInput::make('image_url')
                        ->label('Ảnh đại diện (URL)')
                        ->url()
                        ->maxLength(2048)
                        ->placeholder('https://…')
                        ->helperText('Hiển thị trên danh sách và trang sự kiện.')
                        ->columnSpanFull(),
                    DateTimePicker::make('starts_at')
                        ->label('Bắt đầu')
                        ->seconds(false)
                        ->native(false)
                        ->helperText('Thời điểm bắt đầu sự kiện (theo giờ máy chủ / múi giờ ứng dụng).'),
                    DateTimePicker::make('ends_at')
                        ->label('Kết thúc')
                        ->seconds(false)
                        ->native(false)
                        ->helperText('Tùy chọn. Để trống nếu chỉ có một mốc thời gian.'),
                    TextInput::make('location')
                        ->label('Địa điểm')
                        ->placeholder('Ví dụ: Sân vận động xã, Nhà văn hóa…')
                        ->maxLength(255),
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
                CreateAction::make()
                    ->label('Thêm sự kiện'),
            ])
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->height(40)
                    ->square()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->label('Bắt đầu')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Địa điểm')
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
            ->defaultSort('starts_at', 'desc')
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
