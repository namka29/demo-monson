<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function __construct(
        protected DestinationRepositoryInterface $destinations,
    ) {}

    public function index(): View
    {
        return view(
            'site.destinations.index',
            ['destinations' => $this->destinations->paginatePublishedByName(12)],
        );
    }

    public function show(Destination $destination): View
    {
        return view('site.destinations.show', compact('destination'));
    }
}
