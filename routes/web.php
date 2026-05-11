<?php

use App\Http\Controllers\Admin\AdminTotpController;
use App\Http\Controllers\Site\AccommodationController;
use App\Http\Controllers\Site\DestinationController;
use App\Http\Controllers\Site\EventController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\LocalSpecialtyController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\PostController;
use App\Http\Controllers\Site\PreviewController;
use App\Http\Controllers\Site\TourSuggestionController;
use App\Models\Accommodation;
use App\Models\Destination;
use App\Models\Event;
use App\Models\LocalSpecialty;
use App\Models\Page;
use App\Models\Post;
use App\Models\TourSuggestion;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin/totp')->name('admin.totp.')->group(function (): void {
    Route::get('/challenge', [AdminTotpController::class, 'showChallenge'])->name('challenge');
    Route::post('/challenge', [AdminTotpController::class, 'verifyChallenge'])->name('verify');
    Route::get('/setup', [AdminTotpController::class, 'showSetup'])->name('setup');
    Route::post('/setup', [AdminTotpController::class, 'confirmSetup'])->name('confirm');
    Route::post('/recovery', [AdminTotpController::class, 'useRecoveryCode'])->name('recovery');
});

Route::get('/', HomeController::class)->name('home');

Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => route('home'), 'lastmod' => now()->toDateString()],
        ['loc' => route('destinations.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('events.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('posts.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('accommodations.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('tour_suggestions.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('local_specialties.index'), 'lastmod' => now()->toDateString()],
    ])
        ->merge(Destination::query()->published()->get(['slug', 'updated_at'])->map(
            fn (Destination $item): array => ['loc' => route('destinations.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(Event::query()->published()->get(['slug', 'updated_at'])->map(
            fn (Event $item): array => ['loc' => route('events.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(Post::query()->published()->get(['slug', 'updated_at'])->map(
            fn (Post $item): array => ['loc' => route('posts.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(Page::query()->published()->get(['slug', 'updated_at'])->map(
            fn (Page $item): array => ['loc' => route('pages.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(Accommodation::query()->published()->get(['slug', 'updated_at'])->map(
            fn (Accommodation $item): array => ['loc' => route('accommodations.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(TourSuggestion::query()->published()->get(['slug', 'updated_at'])->map(
            fn (TourSuggestion $item): array => ['loc' => route('tour_suggestions.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->merge(LocalSpecialty::query()->published()->get(['slug', 'updated_at'])->map(
            fn (LocalSpecialty $item): array => ['loc' => route('local_specialties.show', $item->slug), 'lastmod' => optional($item->updated_at)->toDateString()],
        ))
        ->values();

    return response()
        ->view('sitemap.xml', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Đường dẫn tiếng Việt không dấu (slug) — thân thiện người dùng & SEO
Route::get('/diem-den', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/diem-den/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/su-kien', [EventController::class, 'index'])->name('events.index');
Route::get('/su-kien/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
Route::get('/tin-tuc/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/luu-tru', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/luu-tru/{accommodation}', [AccommodationController::class, 'show'])->name('accommodations.show');

Route::get('/goi-y-tour', [TourSuggestionController::class, 'index'])->name('tour_suggestions.index');
Route::get('/goi-y-tour/{tour_suggestion}', [TourSuggestionController::class, 'show'])->name('tour_suggestions.show');

Route::get('/dac-san', [LocalSpecialtyController::class, 'index'])->name('local_specialties.index');
Route::get('/dac-san/{local_specialty}', [LocalSpecialtyController::class, 'show'])->name('local_specialties.show');

Route::get('/trang/{page}', [PageController::class, 'show'])->name('pages.show');

// Xem trước (cả bản nháp) — chỉ cán bộ đã đăng nhập
Route::middleware(['auth', 'preview.staff'])->prefix('xem-truoc')->group(function (): void {
    Route::get('/diem-den/{previewDestination}', [PreviewController::class, 'destination'])->name('preview.destinations.show');
    Route::get('/su-kien/{previewEvent}', [PreviewController::class, 'event'])->name('preview.events.show');
    Route::get('/tin-tuc/{previewPost}', [PreviewController::class, 'post'])->name('preview.posts.show');
    Route::get('/trang/{previewPage}', [PreviewController::class, 'page'])->name('preview.pages.show');
    Route::get('/luu-tru/{previewAccommodation}', [PreviewController::class, 'accommodation'])->name('preview.accommodations.show');
    Route::get('/goi-y-tour/{previewTourSuggestion}', [PreviewController::class, 'tourSuggestion'])->name('preview.tour_suggestions.show');
    Route::get('/dac-san/{previewLocalSpecialty}', [PreviewController::class, 'localSpecialty'])->name('preview.local_specialties.show');
});

// Chuyển hướng URL tiếng Anh cũ (SEO / bookmark)
Route::permanentRedirect('/destinations', '/diem-den');
Route::permanentRedirect('/destinations/{destination}', '/diem-den/{destination}');
Route::permanentRedirect('/events', '/su-kien');
Route::permanentRedirect('/events/{event}', '/su-kien/{event}');
Route::permanentRedirect('/posts', '/tin-tuc');
Route::permanentRedirect('/posts/{post}', '/tin-tuc/{post}');
Route::permanentRedirect('/pages/{page}', '/trang/{page}');
