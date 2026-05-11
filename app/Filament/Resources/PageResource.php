<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Support\RichContentEditorTabs;
use App\Models\Page;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 4;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function getModelLabel(): string
    {
        return 'Trang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Trang tĩnh';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Trang nội dung cố định')
                ->description('Ví dụ: Giới thiệu, Quy định, Liên hệ. Đường dẫn /trang/{slug} trên website công khai.')
                ->schema([
                    TextInput::make('title')
                        ->label('Tiêu đề trang')
                        ->placeholder('Ví dụ: Giới thiệu du lịch xã')
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
                        ->placeholder('gioi-thieu')
                        ->maxLength(255)
                        ->helperText('Để trống để hệ thống tự tạo từ tiêu đề. Slug dùng trong URL, nên ngắn gọn, không dấu.'),
                    RichContentEditorTabs::make(
                        'body',
                        'pages',
                        'Nội dung trang',
                        required: true,
                        helperText: 'Đây là HTML xuất hiện trong trang công khai /trang/{slug}.',
                    ),
                    Select::make('status')
                        ->label('Trạng thái')
                        ->options(collect(PublicationStatus::cases())->mapWithKeys(fn (PublicationStatus $s) => [$s->value => $s->label()]))
                        ->required()
                        ->native(false)
                        ->helperText('Chỉ trang «Đã xuất bản» mới xem được trên website.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm trang'),
            ])
            ->columns([
                TextColumn::make('title')
                    ->label('Tiêu đề')
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
