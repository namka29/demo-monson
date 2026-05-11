@php
    use App\Enums\SpecialtyCategory;
@endphp

@extends('layouts.site')

@section('title', 'Đặc sản địa phương · '.config('app.name'))

@section('content')
    <div class="mb-8">
        <h1 class="section-title">Đặc sản địa phương</h1>
        <p class="section-sub mt-2">
            Ẩm thực, đặc sản ăn uống, sản phẩm OCOP và làng nghề — khu «Đặc sản» / «Ăn uống» trên các cổng như <a href="https://dulichphutho.com.vn" class="font-medium text-brand-700 underline hover:text-brand-900" rel="noopener noreferrer">Du lịch Phú Thọ</a> là tham khảo về phân nhóm.
        </p>
        <div class="mt-6 flex flex-wrap gap-2">
            <a
                href="{{ route('local_specialties.index') }}"
                class="rounded-full border px-3 py-1.5 text-sm font-medium transition {{ filled($filterCategory) ? 'border-stone-200 bg-white text-stone-700 hover:bg-stone-50' : 'border-brand-600 bg-brand-50 text-brand-900' }}"
            >
                Tất cả
            </a>
            @foreach (SpecialtyCategory::cases() as $cat)
                <a
                    href="{{ route('local_specialties.index', ['nhom' => $cat->value]) }}"
                    class="rounded-full border px-3 py-1.5 text-sm font-medium transition {{ $filterCategory === $cat->value ? 'border-brand-600 bg-brand-50 text-brand-900' : 'border-stone-200 bg-white text-stone-700 hover:bg-stone-50' }}"
                >
                    {{ $cat->label() }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($specialties as $item)
            <article class="card-elevated flex flex-col overflow-hidden p-0">
                @if ($item->image_url)
                    <a href="{{ route('local_specialties.show', $item) }}" class="block shrink-0" tabindex="-1" aria-hidden="true">
                        <img
                            src="{{ $item->image_url }}"
                            alt=""
                            class="aspect-[16/10] w-full object-cover transition hover:opacity-95"
                            loading="lazy"
                            width="640"
                            height="400"
                        >
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $item->category->label() }}</p>
                    <h2 class="mt-1 text-lg font-bold text-brand-950">
                        <a href="{{ route('local_specialties.show', $item) }}" class="hover:text-brand-700 hover:underline">
                            {{ $item->name }}
                        </a>
                    </h2>
                    @if ($item->origin_hint)
                        <p class="mt-2 text-sm text-stone-500">{{ $item->origin_hint }}</p>
                    @endif
                    @if ($item->description)
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 140) }}
                        </p>
                    @endif
                    <p class="mt-4">
                        <a href="{{ route('local_specialties.show', $item) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Chi tiết →</a>
                    </p>
                </div>
            </article>
        @empty
            <p class="col-span-full text-stone-500">Chưa có đặc sản hoặc không khớp bộ lọc.</p>
        @endforelse
    </div>
    <div class="mt-10">
        {{ $specialties->links() }}
    </div>
@endsection
