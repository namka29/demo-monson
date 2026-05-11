@php
    use App\Enums\AccommodationType;
@endphp

@extends('layouts.site')

@section('title', 'Lưu trú · '.config('app.name'))

@section('content')
    <div class="mb-8">
        <h1 class="section-title">Nơi lưu trú</h1>
        <p class="section-sub mt-2">
            Khách sạn, homestay, resort và các loại hình lưu trú địa phương — tham khảo phân nhóm tương tự cổng du lịch cấp tỉnh (ví dụ khu «Nơi ở»).
        </p>
        <div class="mt-6 flex flex-wrap gap-2">
            <a
                href="{{ route('accommodations.index') }}"
                class="rounded-full border px-3 py-1.5 text-sm font-medium transition {{ filled($filterType) ? 'border-stone-200 bg-white text-stone-700 hover:bg-stone-50' : 'border-brand-600 bg-brand-50 text-brand-900' }}"
            >
                Tất cả
            </a>
            @foreach (AccommodationType::cases() as $type)
                <a
                    href="{{ route('accommodations.index', ['loai' => $type->value]) }}"
                    class="rounded-full border px-3 py-1.5 text-sm font-medium transition {{ $filterType === $type->value ? 'border-brand-600 bg-brand-50 text-brand-900' : 'border-stone-200 bg-white text-stone-700 hover:bg-stone-50' }}"
                >
                    {{ $type->label() }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($accommodations as $accommodation)
            <article class="card-elevated flex flex-col overflow-hidden p-0">
                @if ($accommodation->image_url)
                    <a href="{{ route('accommodations.show', $accommodation) }}" class="block shrink-0" tabindex="-1" aria-hidden="true">
                        <img
                            src="{{ $accommodation->image_url }}"
                            alt=""
                            class="aspect-[16/10] w-full object-cover transition hover:opacity-95"
                            loading="lazy"
                            width="640"
                            height="400"
                        >
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">
                        {{ $accommodation->accommodation_type->label() }}
                    </p>
                    <h2 class="mt-1 text-lg font-bold text-brand-950">
                        <a href="{{ route('accommodations.show', $accommodation) }}" class="hover:text-brand-700 hover:underline">
                            {{ $accommodation->name }}
                        </a>
                    </h2>
                    @if ($accommodation->price_hint)
                        <p class="mt-2 text-sm font-medium text-stone-700">{{ $accommodation->price_hint }}</p>
                    @endif
                    @if ($accommodation->description)
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-stone-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($accommodation->description), 140) }}
                        </p>
                    @endif
                    <p class="mt-4">
                        <a href="{{ route('accommodations.show', $accommodation) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-900">Chi tiết →</a>
                    </p>
                </div>
            </article>
        @empty
            <p class="col-span-full text-stone-500">Chưa có cơ sở lưu trú hoặc không khớp bộ lọc.</p>
        @endforelse
    </div>
    <div class="mt-10">
        {{ $accommodations->links() }}
    </div>
@endsection
