@extends('layouts.site')

@section('title', $post->title.' · '.config('app.name'))
@section('meta_description', $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 155))
@section('canonical', route('posts.show', $post->slug))
@section('og_type', 'article')
@section('og_image', $post->image_url ?: asset('favicon.ico'))

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 155),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'mainEntityOfPage' => route('posts.show', $post->slug),
            'image' => $post->image_url ? [$post->image_url] : null,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@section('content')
    <article class="mx-auto max-w-3xl">
        <h1 class="text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">{{ $post->title }}</h1>
        @if ($post->published_at)
            <p class="mt-3 text-sm text-stone-500">{{ $post->published_at->timezone(config('app.timezone'))->format('d/m/Y') }}</p>
        @endif
        @if ($post->image_url)
            <div class="mt-8 overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $post->image_url }}"
                    alt="{{ $post->title }}"
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        @if ($post->excerpt)
            <p class="mt-8 text-lg leading-relaxed text-stone-700">{{ $post->excerpt }}</p>
        @endif
        <div class="article-content mt-10">@include('partials.purified-body', ['html' => $post->body])</div>
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả tin tức</a>
        </p>
    </article>
@endsection
