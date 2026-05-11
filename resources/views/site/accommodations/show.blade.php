@extends('layouts.site')

@section('title', $accommodation->name.' · '.config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($accommodation->description ?? ''), 155))
@section('canonical', route('accommodations.show', $accommodation->slug))
@section('og_image', $accommodation->image_url ?: asset('favicon.ico'))

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => $accommodation->name,
            'description' => \Illuminate\Support\Str::limit(strip_tags($accommodation->description ?? ''), 155),
            'url' => route('accommodations.show', $accommodation->slug),
            'image' => $accommodation->image_url ?: null,
            'telephone' => $accommodation->contact_phone ?: null,
            'address' => $accommodation->address ? ['@type' => 'PostalAddress', 'streetAddress' => strip_tags((string) $accommodation->address)] : null,
            'geo' => \App\Support\TouristMaps::canEmbedIframe($accommodation->latitude, $accommodation->longitude) ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $accommodation->latitude,
                'longitude' => (float) $accommodation->longitude,
            ] : null,
        ], static fn ($v) => $v !== null && $v !== '' && $v !== []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@section('content')
    <article class="mx-auto max-w-3xl">
        @if ($accommodation->image_url)
            <div class="overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $accommodation->image_url }}"
                    alt="{{ $accommodation->name }}"
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $accommodation->accommodation_type->label() }}</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">{{ $accommodation->name }}</h1>
        @if ($accommodation->address)
            <p class="mt-4 text-sm text-stone-600">{{ $accommodation->address }}</p>
        @endif
        <div class="mt-4 flex flex-wrap gap-4 text-sm">
            @if ($accommodation->price_hint)
                <span class="font-semibold text-brand-900">{{ $accommodation->price_hint }}</span>
            @endif
            @if ($accommodation->contact_phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $accommodation->contact_phone) }}" class="font-medium text-brand-700 hover:text-brand-900">
                    {{ $accommodation->contact_phone }}
                </a>
            @endif
        </div>
        @if ($accommodation->description)
            <div class="article-content mt-10">@include('partials.purified-body', ['html' => $accommodation->description])</div>
        @endif
        @include('partials.site-coordinate-map', [
            'mapHeadingId' => 'accommodation-map-heading',
            'placeTitle' => $accommodation->name,
            'latitude' => $accommodation->latitude,
            'longitude' => $accommodation->longitude,
        ])
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('accommodations.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả lưu trú</a>
        </p>
    </article>
@endsection
