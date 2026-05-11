<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\TourSuggestionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\TourSuggestion;
use Illuminate\View\View;

class TourSuggestionController extends Controller
{
    public function __construct(
        protected TourSuggestionRepositoryInterface $tourSuggestions,
    ) {}

    public function index(): View
    {
        return view('site.tour_suggestions.index', [
            'tours' => $this->tourSuggestions->paginatePublishedByUpdatedAtDesc(12),
        ]);
    }

    public function show(TourSuggestion $tourSuggestion): View
    {
        return view('site.tour_suggestions.show', ['tour' => $tourSuggestion]);
    }
}
