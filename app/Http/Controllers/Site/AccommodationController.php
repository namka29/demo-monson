<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\AccommodationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccommodationController extends Controller
{
    public function __construct(
        protected AccommodationRepositoryInterface $accommodations,
    ) {}

    public function index(Request $request): View
    {
        $type = $request->query('loai');

        return view('site.accommodations.index', [
            'accommodations' => $this->accommodations->paginatePublishedFiltered(
                filled($type) ? (string) $type : null,
                12,
            ),
            'filterType' => $type,
        ]);
    }

    public function show(Accommodation $accommodation): View
    {
        return view('site.accommodations.show', compact('accommodation'));
    }
}
