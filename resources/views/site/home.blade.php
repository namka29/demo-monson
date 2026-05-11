@extends('layouts.site')

@section('title', config('tourist.site_title'))

@section('meta_description', config('tourist.hero_tagline'))

@push('hero')
    @include('site.partials.home-hero-banner')
@endpush

@section('content')
    <div class="mb-12 text-center lg:mb-16 lg:text-left">
        <h2 class="section-title">Dành cho chuyến đi của bạn</h2>
        <p class="section-sub mx-auto lg:mx-0">
            Điểm đến nổi bật, lịch sự kiện và tin mới — cập nhật từ ban quản trị địa phương.
        </p>
    </div>

    <div class="grid gap-10 lg:grid-cols-3">
        <section class="card-elevated">
            <div class="flex items-center gap-3 border-b border-stone-100 pb-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-brand-950">Điểm đến</h2>
            </div>
            <ul class="mt-5 space-y-3 text-sm">
                @forelse ($destinations as $destination)
                    <li class="flex gap-3 border-b border-stone-100 pb-3 last:border-0 last:pb-0">
                        @if ($destination->image_url)
                            <a href="{{ route('destinations.show', $destination) }}" class="shrink-0" tabindex="-1" aria-hidden="true">
                                <img
                                    src="{{ $destination->image_url }}"
                                    alt=""
                                    class="h-16 w-20 rounded-lg object-cover ring-1 ring-stone-200"
                                    loading="lazy"
                                    width="80"
                                    height="64"
                                >
                            </a>
                        @endif
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('destinations.show', $destination) }}" class="font-semibold text-brand-800 hover:text-brand-600 hover:underline">
                                {{ $destination->name }}
                            </a>
                            @if ($destination->description)
                                <p class="mt-1 line-clamp-2 text-stone-600">{{ strip_tags(\Illuminate\Support\Str::limit($destination->description, 120)) }}</p>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="text-stone-500">Chưa có điểm đến.</li>
                @endforelse
            </ul>
            <p class="mt-6">
                <a href="{{ route('destinations.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Xem tất cả điểm đến →</a>
            </p>
        </section>

        <section class="card-elevated">
            <div class="flex items-center gap-3 border-b border-stone-100 pb-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-brand-950">Sự kiện &amp; lễ hội</h2>
            </div>
            <ul class="mt-5 space-y-4 text-sm">
                @forelse ($events as $event)
                    <li>
                        <a href="{{ route('events.show', $event) }}" class="font-semibold text-brand-800 hover:text-brand-600 hover:underline">
                            {{ $event->title }}
                        </a>
                        @if ($event->starts_at)
                            <div class="mt-1 text-xs text-stone-500">{{ $event->starts_at->timezone(config('app.timezone'))->format('d/m/Y · H:i') }}</div>
                        @endif
                    </li>
                @empty
                    <li class="text-stone-500">Chưa có sự kiện.</li>
                @endforelse
            </ul>
            <p class="mt-6">
                <a href="{{ route('events.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Xem lịch sự kiện →</a>
            </p>
        </section>

        <section class="card-elevated">
            <div class="flex items-center gap-3 border-b border-stone-100 pb-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-100 text-cyan-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 20.25V18h.375c.621 0 1.125-.504 1.125-1.125V13.5c0-.621-.504-1.125-1.125-1.125H16.5m0 3.75h.375c.621 0 1.125-.504 1.125-1.125V10.875c0-.621-.504-1.125-1.125-1.125H16.5m0 6.75h.375c.621 0 1.125-.504 1.125-1.125v-3.75c0-.621-.504-1.125-1.125-1.125H16.5Z" />
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-brand-950">Tin tức</h2>
            </div>
            <ul class="mt-5 space-y-4 text-sm">
                @forelse ($posts as $post)
                    <li>
                        <a href="{{ route('posts.show', $post) }}" class="font-semibold text-brand-800 hover:text-brand-600 hover:underline">
                            {{ $post->title }}
                        </a>
                        @if ($post->published_at)
                            <div class="mt-1 text-xs text-stone-500">{{ $post->published_at->timezone(config('app.timezone'))->format('d/m/Y') }}</div>
                        @endif
                    </li>
                @empty
                    <li class="text-stone-500">Chưa có bài viết.</li>
                @endforelse
            </ul>
            <p class="mt-6">
                <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Đọc thêm tin tức →</a>
            </p>
        </section>
    </div>
@endsection
