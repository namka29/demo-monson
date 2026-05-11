<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\LocalSpecialtyRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\LocalSpecialty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocalSpecialtyController extends Controller
{
    public function __construct(
        protected LocalSpecialtyRepositoryInterface $localSpecialties,
    ) {}

    public function index(Request $request): View
    {
        $category = $request->query('nhom');

        return view('site.local_specialties.index', [
            'specialties' => $this->localSpecialties->paginatePublishedFiltered(
                filled($category) ? (string) $category : null,
                12,
            ),
            'filterCategory' => $category,
        ]);
    }

    public function show(LocalSpecialty $localSpecialty): View
    {
        return view('site.local_specialties.show', compact('localSpecialty'));
    }
}
