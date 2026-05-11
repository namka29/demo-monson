@extends('layouts.site')

@section('title', 'Không tìm thấy trang')
@section('meta_description', 'Trang bạn truy cập không tồn tại hoặc đã được chuyển sang địa chỉ khác.')

@section('content')
    <section class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Lỗi {{ $statusCode ?? 404 }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">Không tìm thấy trang</h1>
            <p class="mt-4 text-base leading-relaxed text-stone-600">
                Liên kết có thể đã cũ, nội dung đã được gỡ, hoặc bạn nhập sai địa chỉ.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="inline-flex items-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800">
                    Về trang chủ
                </a>
                <a href="{{ route('posts.index') }}" class="inline-flex items-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">
                    Xem tin tức
                </a>
            </div>
        </div>
    </section>
@endsection
