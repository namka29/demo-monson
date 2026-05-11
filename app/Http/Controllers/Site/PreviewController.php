<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Destination;
use App\Models\Event as EventModel;
use App\Models\LocalSpecialty;
use App\Models\Page;
use App\Models\Post;
use App\Models\TourSuggestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class PreviewController extends Controller
{
    public function destination(Destination $previewDestination): View
    {
        return $this->renderPreview(
            'site.destinations.show',
            ['destination' => $previewDestination],
            $previewDestination,
        );
    }

    public function event(EventModel $previewEvent): View
    {
        return $this->renderPreview(
            'site.events.show',
            ['event' => $previewEvent],
            $previewEvent,
        );
    }

    public function post(Post $previewPost): View
    {
        return $this->renderPreview(
            'site.posts.show',
            ['post' => $previewPost],
            $previewPost,
        );
    }

    public function page(Page $previewPage): View
    {
        return $this->renderPreview(
            'site.pages.show',
            ['page' => $previewPage],
            $previewPage,
        );
    }

    public function accommodation(Accommodation $previewAccommodation): View
    {
        return $this->renderPreview(
            'site.accommodations.show',
            ['accommodation' => $previewAccommodation],
            $previewAccommodation,
        );
    }

    public function tourSuggestion(TourSuggestion $previewTourSuggestion): View
    {
        return $this->renderPreview(
            'site.tour_suggestions.show',
            ['tour' => $previewTourSuggestion],
            $previewTourSuggestion,
        );
    }

    public function localSpecialty(LocalSpecialty $previewLocalSpecialty): View
    {
        return $this->renderPreview(
            'site.local_specialties.show',
            ['localSpecialty' => $previewLocalSpecialty],
            $previewLocalSpecialty,
        );
    }

    /**
     * @param  array<string, mixed>  $viewData  Dữ liệu view (thêm cờ preview).
     */
    protected function renderPreview(string $view, array $viewData, Model $record): View
    {
        $this->authorize('view', $record);

        return view($view, [
            ...$viewData,
            'preview' => true,
        ]);
    }
}
