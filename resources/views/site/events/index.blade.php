@extends('layouts.site')

@section('title', 'Sự kiện · '.config('app.name'))

@section('content')
    <div class="mb-10">
        <h1 class="section-title">Sự kiện &amp; lễ hội</h1>
        <p class="section-sub mt-2">Lịch hoạt động văn hóa, lễ hội truyền thống và sự kiện du lịch.</p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2">
        @forelse ($events as $event)
            <article class="card-elevated flex flex-col overflow-hidden p-0">
                @if ($event->image_url)
                    <a href="{{ route('events.show', $event) }}" class="block shrink-0" tabindex="-1" aria-hidden="true">
                        <img
                            src="{{ $event->image_url }}"
                            alt=""
                            class="aspect-[16/9] w-full object-cover transition hover:opacity-95"
                            loading="lazy"
                            width="640"
                            height="360"
                        >
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6">
                    <h2 class="text-lg font-bold text-brand-950">
                        <a href="{{ route('events.show', $event) }}" class="hover:text-brand-700 hover:underline">{{ $event->title }}</a>
                    </h2>
                    @if ($event->starts_at)
                        <div class="mt-2 text-sm text-stone-600">
                            {{ $event->starts_at->timezone(config('app.timezone'))->format('d/m/Y · H:i') }}
                            @if ($event->ends_at)
                                – {{ $event->ends_at->timezone(config('app.timezone'))->format('d/m/Y · H:i') }}
                            @endif
                        </div>
                    @endif
                    @if ($event->location)
                        <div class="mt-2 text-sm text-stone-600">{{ $event->location }}</div>
                    @endif
                    <p class="mt-4">
                        <a href="{{ route('events.show', $event) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Chi tiết →</a>
                    </p>
                </div>
            </article>
        @empty
            <p class="col-span-full text-center text-stone-500 sm:col-span-2">Chưa có sự kiện.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $events->links() }}
    </div>
@endsection
