@extends('layouts.site')

@section('title', 'Không có quyền truy cập')
@section('meta_description', 'Bạn không có quyền truy cập nội dung này.')

@section('content')
    <section class="mx-auto max-w-3xl">
        <div class="rounded-3xl border border-stone-200 bg-white p-8 shadow-sm sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-brand-700">Lỗi {{ $statusCode ?? 403 }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">Không có quyền truy cập</h1>
            <p class="mt-4 text-base leading-relaxed text-stone-600">
                Bạn chưa có quyền xem nội dung này. Vui lòng đăng nhập bằng tài khoản phù hợp hoặc liên hệ quản trị viên.
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
