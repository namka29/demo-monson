@extends('layouts.site')

@section('title', 'Hệ thống đang bận')
@section('meta_description', 'Đã có lỗi xảy ra trong quá trình xử lý. Vui lòng thử lại sau.')

@section('content')
    <section class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Lỗi {{ $statusCode ?? 500 }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">Hệ thống đang bận</h1>
            <p class="mt-4 text-base leading-relaxed text-stone-600">
                Đã xảy ra lỗi trong quá trình xử lý yêu cầu. Đội ngũ kỹ thuật đã được ghi nhận qua log hệ thống.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="inline-flex items-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800">
                    Về trang chủ
                </a>
                <a href="{{ url()->previous() }}" class="inline-flex items-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">
                    Quay lại
                </a>
            </div>
        </div>
    </section>
@endsection
