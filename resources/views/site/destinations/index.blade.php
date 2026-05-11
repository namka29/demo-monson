@extends('layouts.site')

@section('title', 'Điểm đến · '.config('app.name'))

@section('content')
    <div class="mb-10">
        <h1 class="section-title">Điểm đến</h1>
        <p class="section-sub mt-2">Khám phá địa điểm, di sản và trải nghiệm tại địa phương.</p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($destinations as $destination)
            <article class="card-elevated flex flex-col overflow-hidden p-0">
                @if ($destination->image_url)
                    <a href="{{ route('destinations.show', $destination) }}" class="block shrink-0" tabindex="-1" aria-hidden="true">
                        <img
                            src="{{ $destination->image_url }}"
                            alt=""
                            class="aspect-[16/10] w-full object-cover transition hover:opacity-95"
                            loading="lazy"
                            width="640"
                            height="400"
                        >
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6">
                <h2 class="text-lg font-bold text-brand-950">
                    <a href="{{ route('destinations.show', $destination) }}" class="hover:text-brand-700 hover:underline">
                        {{ $destination->name }}
                    </a>
                </h2>
                @if ($destination->description)
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600">
                        {{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 160) }}
                    </p>
                @endif
                <p class="mt-4">
                    <a href="{{ route('destinations.show', $destination) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Chi tiết →</a>
                </p>
                </div>
            </article>
        @empty
            <p class="col-span-full text-stone-500">Chưa có điểm đến.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $destinations->links() }}
    </div>
@endsection
