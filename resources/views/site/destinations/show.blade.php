@extends('layouts.site')

@section('title', $destination->name.' · '.config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($destination->description ?? ''), 155))
@section('canonical', route('destinations.show', $destination->slug))
@section('og_image', $destination->image_url ?: asset('favicon.ico'))

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'TouristAttraction',
            'name' => $destination->name,
            'description' => \Illuminate\Support\Str::limit(strip_tags($destination->description ?? ''), 155),
            'url' => route('destinations.show', $destination->slug),
            'image' => $destination->image_url ?: null,
            'geo' => \App\Support\TouristMaps::canEmbedIframe($destination->latitude, $destination->longitude) ? [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $destination->latitude,
                'longitude' => (float) $destination->longitude,
            ] : null,
        ], static fn ($v) => $v !== null && $v !== '' && $v !== []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@section('content')
    <article class="mx-auto max-w-3xl">
        @if ($destination->image_url)
            <div class="overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $destination->image_url }}"
                    alt="{{ $destination->name }}"
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        <h1 class="mt-8 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl lg:mt-10">{{ $destination->name }}</h1>
        @if ($destination->description)
            <div class="article-content mt-8">@include('partials.purified-body', ['html' => $destination->description])</div>
        @endif
        @include('partials.site-coordinate-map', [
            'mapHeadingId' => 'destination-map-heading',
            'placeTitle' => $destination->name,
            'latitude' => $destination->latitude,
            'longitude' => $destination->longitude,
        ])
        <p class="mt-10">
            <a href="{{ route('destinations.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả điểm đến</a>
        </p>
    </article>
@endsection
