<?php

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Support\RichContentEditorTabs;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    public static function getModelLabel(): string
    {
        return 'Tin bài';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tin bài';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Nội dung tin bài')
                ->description('Tin hiển thị công khai khi «Đã xuất bản» và (nếu có) đã đến thời điểm đăng.')
                ->schema([
                    TextInput::make('title')
                        ->label('Tiêu đề')
                        ->placeholder('Ví dụ: Xã tổ chức lễ khai hội…')
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
                        ->placeholder('tin-khai-hoi-2025')
                        ->maxLength(255)
                        ->helperText('Để trống để hệ thống tự tạo từ tiêu đề khi lưu.'),
                    Textarea::make('excerpt')
                        ->label('Tóm tắt (mở đầu)')
                        ->placeholder('2–3 dòng tóm tắt, hiển thị ở danh sách tin.')
                        ->rows(3)
                        ->columnSpanFull(),
                    TextInput::make('image_url')
                        ->label('Ảnh đại diện (URL)')
                        ->url()
                        ->maxLength(2048)
                        ->placeholder('https://…')
                        ->helperText('Ảnh hiển thị trong danh sách tin; có thể trùng ảnh trong nội dung HTML.')
                        ->columnSpanFull(),
                    RichContentEditorTabs::make('body', 'posts', 'Nội dung đầy đủ', required: true),
                    DateTimePicker::make('published_at')
                        ->label('Thời điểm đăng')
                        ->seconds(false)
                        ->native(false)
                        ->helperText('Tùy chọn. Để trống: coi như đăng ngay khi chọn «Đã xuất bản». Nếu đặt sau «hôm nay», tin chỉ lên web đến đúng thời điểm đó.'),
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
                    ->label('Thêm tin'),
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
                TextColumn::make('published_at')
                    ->label('Đăng lúc')
                    ->dateTime('d/m/Y H:i')
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
            ->defaultSort('published_at', 'desc')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
