<?php

namespace App\Http\Controllers\Site;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected EventRepositoryInterface $events,
    ) {}

    public function index(): View
    {
        return view('site.events.index', [
            'events' => $this->events->paginatePublishedByStartsAtDesc(12),
        ]);
    }

    public function show(Event $event): View
    {
        return view('site.events.show', compact('event'));
    }
}
