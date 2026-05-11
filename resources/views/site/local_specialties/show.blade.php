@extends('layouts.site')

@section('title', $localSpecialty->name.' · '.config('app.name'))

@section('content')
    <article class="mx-auto max-w-3xl">
        @if ($localSpecialty->image_url)
            <div class="overflow-hidden rounded-2xl shadow-md ring-1 ring-black/5">
                <img
                    src="{{ $localSpecialty->image_url }}"
                    alt=""
                    class="aspect-[21/9] w-full object-cover sm:aspect-[2/1]"
                    loading="eager"
                    width="1200"
                    height="600"
                >
            </div>
        @endif
        <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $localSpecialty->category->label() }}</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">{{ $localSpecialty->name }}</h1>
        @if ($localSpecialty->origin_hint)
            <p class="mt-4 text-sm text-stone-600">{{ $localSpecialty->origin_hint }}</p>
        @endif
        @if ($localSpecialty->description)
            <div class="article-content mt-10">@include('partials.purified-body', ['html' => $localSpecialty->description])</div>
        @endif
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('local_specialties.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Tất cả đặc sản</a>
        </p>
    </article>
@endsection
