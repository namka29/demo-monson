<?php

namespace App\Providers;

use App\Contracts\Repositories\AccommodationRepositoryInterface;
use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use App\Contracts\Repositories\HeroBannerRepositoryInterface;
use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Contracts\Repositories\LocalSpecialtyRepositoryInterface;
use App\Contracts\Repositories\PageRepositoryInterface;
use App\Contracts\Repositories\PostRepositoryInterface;
use App\Contracts\Repositories\TourSuggestionRepositoryInterface;
use App\Repositories\EloquentAccommodationRepository;
use App\Repositories\EloquentDestinationRepository;
use App\Repositories\EloquentEventRepository;
use App\Repositories\EloquentHeroBannerRepository;
use App\Repositories\EloquentHeroSlideshowSettingRepository;
use App\Repositories\EloquentLocalSpecialtyRepository;
use App\Repositories\EloquentPageRepository;
use App\Repositories\EloquentPostRepository;
use App\Repositories\EloquentTourSuggestionRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repos = [
            DestinationRepositoryInterface::class => EloquentDestinationRepository::class,
            EventRepositoryInterface::class => EloquentEventRepository::class,
            PageRepositoryInterface::class => EloquentPageRepository::class,
            PostRepositoryInterface::class => EloquentPostRepository::class,
            AccommodationRepositoryInterface::class => EloquentAccommodationRepository::class,
            TourSuggestionRepositoryInterface::class => EloquentTourSuggestionRepository::class,
            LocalSpecialtyRepositoryInterface::class => EloquentLocalSpecialtyRepository::class,
            HeroBannerRepositoryInterface::class => EloquentHeroBannerRepository::class,
            HeroSlideshowSettingRepositoryInterface::class => EloquentHeroSlideshowSettingRepository::class,
        ];

        foreach ($repos as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureLivewireUploadLimits();

        Paginator::defaultView('vendor.pagination.tailwind');

        Route::bind('destination', fn (string $slug) => app(DestinationRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('event', fn (string $slug) => app(EventRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('page', fn (string $slug) => app(PageRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('post', fn (string $slug) => app(PostRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('accommodation', fn (string $slug) => app(AccommodationRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('tour_suggestion', fn (string $slug) => app(TourSuggestionRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('local_specialty', fn (string $slug) => app(LocalSpecialtyRepositoryInterface::class)->firstPublishedBySlugOrFail($slug));

        Route::bind('previewDestination', fn (string $slug) => app(DestinationRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewEvent', fn (string $slug) => app(EventRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewPost', fn (string $slug) => app(PostRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewPage', fn (string $slug) => app(PageRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewAccommodation', fn (string $slug) => app(AccommodationRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewTourSuggestion', fn (string $slug) => app(TourSuggestionRepositoryInterface::class)->firstBySlugOrFail($slug));

        Route::bind('previewLocalSpecialty', fn (string $slug) => app(LocalSpecialtyRepositoryInterface::class)->firstBySlugOrFail($slug));
    }

    /**
     * Livewire 4: upload tạm + payload mặc định (1MB) dễ chặn Filament FileUpload.
     * Đồng bộ với HeroBannerResource maxSize / PHP (upload_max_filesize) / nginx (client_max_body_size).
     */
    protected function configureLivewireUploadLimits(): void
    {
        $maxKb = max(1, (int) env('LIVEWIRE_TEMP_UPLOAD_MAX_KB', 20480));
        config()->set('livewire.temporary_file_upload.rules', [
            'required',
            'file',
            "max:{$maxKb}",
        ]);

        $payloadBytes = env('LIVEWIRE_PAYLOAD_MAX_BYTES');
        if ($payloadBytes !== null && $payloadBytes !== '') {
            config()->set('livewire.payload.max_size', max(0, (int) $payloadBytes));
        } else {
            config()->set('livewire.payload.max_size', 10 * 1024 * 1024);
        }
    }
}
