@extends('layouts.site')

@section('title', $event->title.' · '.config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 155))
@section('canonical', route('events.show', $event->slug))
@section('og_type', 'event')
@section('og_image', $event->image_url ?: asset('favicon.ico'))

@section('content')
    <article class="mx-auto max-w-3xl">
        @if ($event->image_url)
            <div class="overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $event->image_url }}"
                    alt="{{ $event->title }}"
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        <h1 class="mt-8 text-3xl font-bold tracking-tight text-brand-950 sm:mt-10 sm:text-4xl">{{ $event->title }}</h1>
        @if ($event->starts_at)
            <p class="mt-4 text-sm text-stone-600">
                {{ $event->starts_at->timezone(config('app.timezone'))->format('d/m/Y · H:i') }}
                @if ($event->ends_at)
                    – {{ $event->ends_at->timezone(config('app.timezone'))->format('d/m/Y · H:i') }}
                @endif
            </p>
        @endif
        @if ($event->location)
            <p class="mt-2 text-sm font-semibold text-brand-900">{{ $event->location }}</p>
        @endif
        @if ($event->description)
            <div class="article-content mt-10">@include('partials.purified-body', ['html' => $event->description])</div>
        @endif
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả sự kiện</a>
        </p>
    </article>
@endsection
