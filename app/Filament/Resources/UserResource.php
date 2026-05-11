<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Quản trị';

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return 'Tài khoản';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tài khoản cán bộ';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Thông tin đăng nhập')
                ->description('Chỉ quản trị viên quản lý tài khoản. Tài khoản «Không hoạt động» không đăng nhập được admin.')
                ->schema([
                    TextInput::make('name')
                        ->label('Họ và tên')
                        ->placeholder('Nguyễn Văn A')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email đăng nhập')
                        ->placeholder('canbo@xa.gov.vn')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Mỗi email chỉ gắn một tài khoản.'),
                    TextInput::make('password')
                        ->label('Mật khẩu')
                        ->password()
                        ->revealable()
                        ->maxLength(255)
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? $state : null)
                        ->placeholder('••••••••')
                        ->helperText('Khi sửa: để trống nếu giữ nguyên mật khẩu hiện tại.'),
                    Select::make('role')
                        ->label('Vai trò')
                        ->options(collect(UserRole::cases())->mapWithKeys(fn (UserRole $r) => [$r->value => $r->label()]))
                        ->required()
                        ->native(false)
                        ->helperText('Quản trị viên: toàn quyền gồm xóa nội dung và quản lý tài khoản. Biên tập viên: tạo/sửa nội dung, không xóa.'),
                    Toggle::make('is_active')
                        ->label('Đang hoạt động')
                        ->helperText('Tắt khi cán bộ nghỉ việc hoặc cần khóa đăng nhập tạm thời.')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm tài khoản'),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Họ tên')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Vai trò')
                    ->formatStateUsing(function ($state): string {
                        $r = $state instanceof UserRole ? $state : UserRole::from((string) $state);

                        return $r->label();
                    }),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Hoạt động'),
                IconColumn::make('two_factor_confirmed_at')
                    ->label('2FA')
                    ->boolean()
                    ->getStateUsing(fn (User $record): bool => $record->hasTotpEnabled()),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->label('Sửa'),
                Action::make('reset2fa')
                    ->label('Reset 2FA')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('warning')
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false)
                    ->requiresConfirmation()
                    ->modalHeading('Reset xác thực 2 lớp')
                    ->modalDescription('Xoá secret TOTP và mã khôi phục. Người dùng sẽ cần thiết lập lại 2FA khi đăng nhập.')
                    ->action(function (User $record): void {
                        DB::transaction(function () use ($record): void {
                            $record->trustedDevices()->whereNull('revoked_at')->update(['revoked_at' => now()]);
                            $record->forceFill([
                                'two_factor_secret' => null,
                                'two_factor_recovery_codes' => null,
                                'two_factor_confirmed_at' => null,
                            ])->save();
                        });
                    })
                    ->successNotificationTitle('Đã reset 2FA và thu hồi thiết bị tin cậy'),
                Action::make('revokeTrustedDevices')
                    ->label('Revoke thiết bị tin cậy')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->color('gray')
                    ->visible(fn (User $record): bool => ($record->trustedDevices()->whereNull('revoked_at')->count() > 0) && (auth()->user()?->isAdmin() ?? false))
                    ->requiresConfirmation()
                    ->modalHeading('Thu hồi thiết bị tin cậy')
                    ->modalDescription('Thiết bị tin cậy của tài khoản này sẽ bị thu hồi ngay. Lần đăng nhập tiếp theo sẽ yêu cầu mã 2FA.')
                    ->action(function (User $record): void {
                        $record->trustedDevices()->whereNull('revoked_at')->update(['revoked_at' => now()]);
                    })
                    ->successNotificationTitle('Đã thu hồi toàn bộ thiết bị tin cậy'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
