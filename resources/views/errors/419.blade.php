@extends('layouts.site')

@section('title', 'Phiên làm việc đã hết hạn')
@section('meta_description', 'Phiên làm việc của bạn đã hết hạn. Vui lòng tải lại trang và thử lại.')

@section('content')
    <section class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Lỗi {{ $statusCode ?? 419 }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">Phiên làm việc đã hết hạn</h1>
            <p class="mt-4 text-base leading-relaxed text-stone-600">
                Yêu cầu không hợp lệ do phiên bảo mật đã hết hạn. Vui lòng tải lại trang rồi gửi lại biểu mẫu.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ url()->current() }}" class="inline-flex items-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800">
                    Tải lại trang
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">
                    Về trang chủ
                </a>
            </div>
        </div>
    </section>
@endsection
