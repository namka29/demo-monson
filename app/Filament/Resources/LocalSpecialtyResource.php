<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Support\RichContentEditorTabs;
use App\Enums\SpecialtyCategory;
use App\Filament\Resources\LocalSpecialtyResource\Pages;
use App\Models\LocalSpecialty;
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

class LocalSpecialtyResource extends Resource
{
    protected static ?string $model = LocalSpecialty::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 7;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-gift';

    public static function getModelLabel(): string
    {
        return 'Đặc sản';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Đặc sản địa phương';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Đặc sản / quà địa phương')
                ->description('Ẩm thực, OCOP, làng nghề… hiển thị tại /dac-san khi «Đã xuất bản».')
                ->schema([
                    TextInput::make('name')
                        ->label('Tên')
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
                    Select::make('category')
                        ->label('Nhóm')
                        ->options(collect(SpecialtyCategory::cases())->mapWithKeys(fn (SpecialtyCategory $c) => [$c->value => $c->label()]))
                        ->required()
                        ->native(false),
                    RichContentEditorTabs::make(
                        'description',
                        'local-specialties',
                        'Giới thiệu',
                        required: false,
                    ),
                    TextInput::make('origin_hint')
                        ->label('Xuất xứ / làng nghề (gợi ý)')
                        ->maxLength(255)
                        ->columnSpanFull(),
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
                CreateAction::make()->label('Thêm đặc sản'),
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
                TextColumn::make('category')
                    ->label('Nhóm')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof SpecialtyCategory
                        ? $state->label()
                        : SpecialtyCategory::from((string) $state)->label()),
                TextColumn::make('origin_hint')
                    ->label('Xuất xứ')
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
                SelectFilter::make('category')
                    ->label('Nhóm')
                    ->options(collect(SpecialtyCategory::cases())->mapWithKeys(fn (SpecialtyCategory $c) => [$c->value => $c->label()])),
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
            'index' => Pages\ListLocalSpecialties::route('/'),
            'create' => Pages\CreateLocalSpecialty::route('/create'),
            'edit' => Pages\EditLocalSpecialty::route('/{record}/edit'),
        ];
    }
}
