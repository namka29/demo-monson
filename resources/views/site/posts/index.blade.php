@extends('layouts.site')

@section('title', 'Tin tức · '.config('app.name'))

@section('content')
    <div class="mb-10">
        <h1 class="section-title">Tin tức</h1>
        <p class="section-sub mt-2">Thông tin mới về du lịch, văn hóa và hoạt động địa phương.</p>
    </div>
    <ul class="space-y-6">
        @forelse ($posts as $post)
            <li class="card-elevated overflow-hidden p-0">
                <div class="flex flex-col gap-4 sm:flex-row sm:gap-0">
                    @if ($post->image_url)
                        <a href="{{ route('posts.show', $post) }}" class="block shrink-0 sm:w-56 lg:w-72" tabindex="-1" aria-hidden="true">
                            <img
                                src="{{ $post->image_url }}"
                                alt=""
                                class="aspect-[16/10] h-full w-full object-cover sm:aspect-auto sm:min-h-[11rem]"
                                loading="lazy"
                                width="640"
                                height="400"
                            >
                        </a>
                    @endif
                    <div class="flex flex-1 flex-col p-6">
                        <h2 class="text-xl font-bold text-brand-950">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-brand-700 hover:underline">{{ $post->title }}</a>
                        </h2>
                        @if ($post->published_at)
                            <p class="mt-2 text-xs font-medium uppercase tracking-wide text-stone-500">{{ $post->published_at->timezone(config('app.timezone'))->format('d/m/Y') }}</p>
                        @endif
                        @if ($post->excerpt)
                            <p class="mt-3 text-sm leading-relaxed text-stone-600">{{ $post->excerpt }}</p>
                        @endif
                        <p class="mt-4">
                            <a href="{{ route('posts.show', $post) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Đọc tiếp →</a>
                        </p>
                    </div>
                </div>
            </li>
        @empty
            <li class="text-stone-500">Chưa có bài viết.</li>
        @endforelse
    </ul>
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection
