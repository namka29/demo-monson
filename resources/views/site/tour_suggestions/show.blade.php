@extends('layouts.site')

@section('title', $tour->title.' · '.config('app.name'))

@section('content')
    <article class="mx-auto max-w-3xl">
        @if ($tour->image_url)
            <div class="overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $tour->image_url }}"
                    alt=""
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        <h1 class="mt-8 text-3xl font-bold tracking-tight text-brand-950 sm:mt-10 sm:text-4xl">{{ $tour->title }}</h1>
        @if ($tour->duration_days)
            <p class="mt-4 text-sm font-medium text-stone-600">Thời lượng gợi ý: <span class="text-brand-900">{{ $tour->duration_days }} ngày</span></p>
        @endif
        @if ($tour->summary)
            <p class="mt-6 text-lg leading-relaxed text-stone-700">{{ $tour->summary }}</p>
        @endif
        @if ($tour->highlights)
            <div class="mt-8 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-500">Điểm nhấn</h2>
                <ul class="mt-4 list-inside list-disc space-y-2 text-stone-700">
                    @foreach (preg_split("/\r\n|\n|\r/", trim($tour->highlights)) as $line)
                        @if (filled(trim($line)))
                            <li>{{ trim($line) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($tour->body)
            <div class="article-content mt-10">@include('partials.purified-body', ['html' => $tour->body])</div>
        @endif
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('tour_suggestions.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả gợi ý tour</a>
        </p>
    </article>
@endsection
