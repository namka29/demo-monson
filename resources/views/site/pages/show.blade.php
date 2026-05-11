@extends('layouts.site')

@section('title', $page->title.' · '.config('app.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($page->body ?? ''), 155))
@section('canonical', route('pages.show', $page->slug))

@section('content')
    <article class="mx-auto max-w-3xl">
        <h1 class="text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">{{ $page->title }}</h1>
        <div class="article-content mt-10">@include('partials.purified-body', ['html' => $page->body])</div>
        <p class="mt-12 border-t border-stone-200 pt-8">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">&larr; Về trang chủ</a>
        </p>
    </article>
@endsection
