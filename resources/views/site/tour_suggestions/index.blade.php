@extends('layouts.site')

@section('title', 'Gợi ý tour · '.config('app.name'))

@section('content')
    <div class="mb-10">
        <h1 class="section-title">Gợi ý tour</h1>
        <p class="section-sub mt-2">
            Tuyến tham quan gợi ý, có thể kết hợp điểm đến và lịch trình theo số ngày — mô hình tương tự mục «Gợi ý tour» trên các cổng du lịch địa phương.
        </p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($tours as $tour)
            <article class="card-elevated flex flex-col overflow-hidden p-0">
                @if ($tour->image_url)
                    <a href="{{ route('tour_suggestions.show', $tour) }}" class="block shrink-0" tabindex="-1" aria-hidden="true">
                        <img
                            src="{{ $tour->image_url }}"
                            alt=""
                            class="aspect-[16/10] w-full object-cover transition hover:opacity-95"
                            loading="lazy"
                            width="640"
                            height="400"
                        >
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6">
                    @if ($tour->duration_days)
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $tour->duration_days }} ngày (gợi ý)</p>
                    @endif
                    <h2 class="mt-1 text-lg font-bold text-brand-950">
                        <a href="{{ route('tour_suggestions.show', $tour) }}" class="hover:text-brand-700 hover:underline">
                            {{ $tour->title }}
                        </a>
                    </h2>
                    @if ($tour->summary)
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($tour->summary), 160) }}
                        </p>
                    @endif
                    <p class="mt-4">
                        <a href="{{ route('tour_suggestions.show', $tour) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Xem chi tiết →</a>
                    </p>
                </div>
            </article>
        @empty
            <p class="col-span-full text-stone-500">Chưa có gợi ý tour.</p>
        @endforelse
    </div>
    <div class="mt-10">
        {{ $tours->links() }}
    </div>
@endsection
