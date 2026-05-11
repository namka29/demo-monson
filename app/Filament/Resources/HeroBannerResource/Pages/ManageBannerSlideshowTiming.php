<?php

namespace App\Filament\Resources\HeroBannerResource\Pages;

use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Filament\Resources\HeroBannerResource;
use App\Filament\Support\HeroSlideshowTimingSchema;
use App\Models\HeroSlideshowSetting;
use Filament\Actions\Action;
use Filament\Support\Facades\FilamentView;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;

/**
 * Trang chỉnh autoplay slideshow (model HeroSlideshowSetting) trong resource Slide banner để không tách hai nơi quản trị.
 */
class ManageBannerSlideshowTiming extends Page
{
    use HasUnsavedDataChangesAlert;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $resource = HeroBannerResource::class;

    protected ?string $subheading = 'Cùng khu «Slide banner trang chủ» — thao tác nhanh trong menu hoặc nút đầu danh sách slide.';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /** @var HeroSlideshowSetting|null */
    public ?HeroSlideshowSetting $slideshowSetting = null;

    public function mount(): void
    {
        static::authorizeResourceAccess();

        abort_unless(static::getResource()::canViewAny(), 403);

        $settings = app(HeroSlideshowSettingRepositoryInterface::class);
        $this->slideshowSetting = $settings->getOrCreateSingleton();
        Gate::authorize('update', $this->slideshowSetting);

        $this->form->fill(
            HeroSlideshowTimingSchema::mutateFormDataBeforeFill(
                $this->slideshowSetting->attributesToArray(),
            ),
        );
    }

    public function getTitle(): string
    {
        return 'Thời gian slideshow';
    }

    protected function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->model($this->slideshowSetting)
            ->operation('edit')
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            HeroSlideshowTimingSchema::section(),
        ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    protected function hasFormWrapper(): bool
    {
        return true;
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler($this->getSubmitFormLivewireMethodName())
            ->footer([
                $this->getFormActionsContentComponent(),
            ]);
    }

    public function getFormActionsContentComponent(): SchemaActions
    {
        return SchemaActions::make($this->getFormActions())
            ->alignment($this->getFormActionsAlignment())
            ->fullWidth(false)
            ->sticky($this->areFormActionsSticky())
            ->key('form-actions');
    }

    /**
     * @return array<\Filament\Actions\Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu')
                ->submit($this->getSubmitFormLivewireMethodName())
                ->keyBindings(['mod+s']),
            Action::make('cancel')
                ->label('Về danh sách slide')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
        ];
    }

    protected function getSubmitFormLivewireMethodName(): string
    {
        return 'save';
    }

    public function save(): void
    {
        Gate::authorize('update', $this->slideshowSetting);

        $setting = app(HeroSlideshowSettingRepositoryInterface::class)->getOrCreateSingleton();
        $data = $this->form->getState();
        $saved = HeroSlideshowTimingSchema::mutateFormDataBeforeSave($data);
        $setting->fill([
            'autoplay_interval_ms' => $saved['autoplay_interval_ms'],
        ]);
        $setting->save();
        $this->slideshowSetting = $setting;
        $this->rememberData();

        Notification::make()
            ->title('Đã lưu thời gian slideshow')
            ->success()
            ->send();

        $redirectUrl = static::getResource()::getUrl('index');
        $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode($redirectUrl));
    }
}
