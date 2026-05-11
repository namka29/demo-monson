<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Support\RichContentEditorTabs;
use App\Filament\Resources\TourSuggestionResource\Pages;
use App\Models\TourSuggestion;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TourSuggestionResource extends Resource
{
    protected static ?string $model = TourSuggestion::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 6;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    public static function getModelLabel(): string
    {
        return 'Gợi ý tour';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Gợi ý tour';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Tuyến / gói gợi ý')
                ->description('Hiển thị tại /goi-y-tour khi «Đã xuất bản». Tab «Soạn thảo» + «Xem trước» cho phần nội dung chi tiết.')
                ->schema([
                    TextInput::make('title')
                        ->label('Tiêu đề')
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
                    Textarea::make('summary')
                        ->label('Tóm tắt')
                        ->rows(2)
                        ->columnSpanFull(),
                    TextInput::make('duration_days')
                        ->label('Số ngày gợi ý')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(30)
                        ->suffix('ngày'),
                    Textarea::make('highlights')
                        ->label('Điểm nhấn (mỗi dòng một ý)')
                        ->rows(4)
                        ->columnSpanFull(),
                    RichContentEditorTabs::make(
                        'body',
                        'tour-suggestions',
                        'Nội dung chi tiết',
                        required: false,
                    ),
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
                CreateAction::make()->label('Thêm gợi ý'),
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
                TextColumn::make('duration_days')
                    ->label('Ngày')
                    ->sortable(),
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
            'index' => Pages\ListTourSuggestions::route('/'),
            'create' => Pages\CreateTourSuggestion::route('/create'),
            'edit' => Pages\EditTourSuggestion::route('/{record}/edit'),
        ];
    }
}
