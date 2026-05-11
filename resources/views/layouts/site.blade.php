<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $seoTitle = trim($__env->yieldContent('title', config('tourist.site_title')));
        $seoDescription = trim($__env->yieldContent('meta_description', config('tourist.hero_tagline')));
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoImage = trim($__env->yieldContent('og_image', asset('favicon.ico')));
        $seoType = trim($__env->yieldContent('og_type', 'website'));
        $seoRobots = trim($__env->yieldContent('meta_robots', 'index,follow'));
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <link rel="canonical" href="{{ $seoCanonical }}">

    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <title>{{ $seoTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:400,500,600,700&display=swap" rel="stylesheet" />
    @stack('structured_data')
</head>
<body class="flex min-h-screen flex-col bg-stone-50 font-sans text-stone-800 antialiased">
    @if (config('tourist.hotline'))
        <div class="bg-brand-950 text-[13px] text-stone-300">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-2 px-4 py-2 sm:px-6 lg:px-8">
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-accent-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <span><span class="font-semibold text-white">{{ config('tourist.hotline') }}</span>
                        @if (config('tourist.hotline_hours'))
                            <span class="text-stone-500"> · {{ config('tourist.hotline_hours') }}</span>
                        @endif
                    </span>
                </span>
                @if (config('tourist.support_email'))
                    <a href="mailto:{{ config('tourist.support_email') }}" class="font-medium text-accent-400 hover:text-accent-300">
                        {{ config('tourist.support_email') }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <header class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/90 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-cyan-700 text-sm font-bold tracking-tight text-white shadow-md ring-2 ring-white">
                    DL
                </span>
                <span class="flex min-w-0 flex-col">
                    <span class="text-base font-bold leading-tight text-brand-950 group-hover:text-brand-800 sm:text-lg">
                        {{ config('tourist.headline_line1') }}
                    </span>
                    <span class="text-xs font-semibold leading-tight text-stone-600 sm:text-sm">{{ config('tourist.headline_line2') }}</span>
                </span>
            </a>

            <nav class="hidden flex-1 flex-wrap items-center justify-end gap-x-0.5 gap-y-1 md:flex lg:gap-x-1" aria-label="Chính">
                <a href="{{ route('home') }}" class="site-nav-link {{ request()->routeIs('home') ? 'site-nav-link-active' : '' }}">Trang chủ</a>
                <a href="{{ route('pages.show', ['page' => 'gioi-thieu']) }}" class="site-nav-link {{ request()->routeIs('pages.show') && ((data_get(request()->route('page'), 'slug') ?? request()->route('page')) === 'gioi-thieu') ? 'site-nav-link-active' : '' }}">Giới thiệu</a>
                <a href="{{ route('destinations.index') }}" class="site-nav-link {{ request()->routeIs('destinations.*') ? 'site-nav-link-active' : '' }}">Điểm đến</a>
                <a href="{{ route('accommodations.index') }}" class="site-nav-link {{ request()->routeIs('accommodations.*') ? 'site-nav-link-active' : '' }}">Lưu trú</a>
                <a href="{{ route('tour_suggestions.index') }}" class="site-nav-link {{ request()->routeIs('tour_suggestions.*') ? 'site-nav-link-active' : '' }}">Gợi ý tour</a>
                <a href="{{ route('local_specialties.index') }}" class="site-nav-link {{ request()->routeIs('local_specialties.*') ? 'site-nav-link-active' : '' }}">Đặc sản</a>
                <a href="{{ route('events.index') }}" class="site-nav-link {{ request()->routeIs('events.*') ? 'site-nav-link-active' : '' }}">Sự kiện &amp; lễ hội</a>
                <a href="{{ route('posts.index') }}" class="site-nav-link {{ request()->routeIs('posts.*') ? 'site-nav-link-active' : '' }}">Tin tức</a>
            </nav>

            <button
                type="button"
                id="site-nav-toggle"
                class="inline-flex items-center justify-center rounded-xl border border-stone-200 bg-white p-2.5 text-stone-700 shadow-sm hover:bg-stone-50 md:hidden"
                aria-controls="site-nav-mobile"
                aria-expanded="false"
                aria-label="Mở menu"
            >
                <svg id="site-nav-icon-open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="site-nav-icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="site-nav-mobile" class="hidden border-t border-stone-100 bg-white md:hidden">
            <nav class="flex flex-col gap-1 px-4 py-4 sm:px-6" aria-label="Di động">
                <a href="{{ route('home') }}" class="site-nav-link {{ request()->routeIs('home') ? 'site-nav-link-active' : '' }}">Trang chủ</a>
                <a href="{{ route('pages.show', ['page' => 'gioi-thieu']) }}" class="site-nav-link {{ request()->routeIs('pages.show') && ((data_get(request()->route('page'), 'slug') ?? request()->route('page')) === 'gioi-thieu') ? 'site-nav-link-active' : '' }}">Giới thiệu</a>
                <a href="{{ route('destinations.index') }}" class="site-nav-link {{ request()->routeIs('destinations.*') ? 'site-nav-link-active' : '' }}">Điểm đến</a>
                <a href="{{ route('accommodations.index') }}" class="site-nav-link {{ request()->routeIs('accommodations.*') ? 'site-nav-link-active' : '' }}">Lưu trú</a>
                <a href="{{ route('tour_suggestions.index') }}" class="site-nav-link {{ request()->routeIs('tour_suggestions.*') ? 'site-nav-link-active' : '' }}">Gợi ý tour</a>
                <a href="{{ route('local_specialties.index') }}" class="site-nav-link {{ request()->routeIs('local_specialties.*') ? 'site-nav-link-active' : '' }}">Đặc sản</a>
                <a href="{{ route('events.index') }}" class="site-nav-link {{ request()->routeIs('events.*') ? 'site-nav-link-active' : '' }}">Sự kiện &amp; lễ hội</a>
                <a href="{{ route('posts.index') }}" class="site-nav-link {{ request()->routeIs('posts.*') ? 'site-nav-link-active' : '' }}">Tin tức</a>
            </nav>
        </div>
    </header>

    @if ($preview ?? false)
        <div class="border-b border-amber-300 bg-amber-100 px-4 py-3 text-center text-sm font-medium text-amber-950 sm:px-6">
            <span class="inline-flex items-center justify-center gap-2">
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l6.75-8.25a1 1 0 0 1 1.598 0l6.75 8.25c.183.222.29.499.29.796s-.107.574-.29.796l-6.75 8.25a1 1 0 0 1-1.598 0l-6.75-8.25Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Đây là chế độ xem trước (gồm cả bản nháp). Chỉ cán bộ đăng nhập mới thấy thanh này.
            </span>
        </div>
    @endif

    @stack('hero')

    <main class="@yield('main_class', 'mx-auto w-full max-w-7xl flex-1 px-4 py-10 sm:px-6 lg:px-8')">
        @yield('content')
    </main>

    <footer class="border-t border-stone-800 bg-brand-950 text-stone-400">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <p class="text-lg font-bold leading-snug text-white">{{ config('tourist.headline_line1') }}</p>
                    <p class="mt-1 text-sm font-medium text-stone-400">{{ config('tourist.headline_line2') }}</p>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-stone-400">
                        {{ config('tourist.hero_tagline') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-stone-500">Khám phá</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('pages.show', ['page' => 'gioi-thieu']) }}" class="text-stone-300 hover:text-white">Giới thiệu</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="text-stone-300 hover:text-white">Điểm đến</a></li>
                        <li><a href="{{ route('accommodations.index') }}" class="text-stone-300 hover:text-white">Lưu trú</a></li>
                        <li><a href="{{ route('tour_suggestions.index') }}" class="text-stone-300 hover:text-white">Gợi ý tour</a></li>
                        <li><a href="{{ route('local_specialties.index') }}" class="text-stone-300 hover:text-white">Đặc sản địa phương</a></li>
                        <li><a href="{{ route('events.index') }}" class="text-stone-300 hover:text-white">Sự kiện</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-stone-300 hover:text-white">Tin tức</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-stone-500">Liên hệ</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        @if (config('tourist.hotline'))
                            <li class="text-stone-300">{{ config('tourist.hotline') }}</li>
                        @endif
                        @if (config('tourist.support_email'))
                            <li><a href="mailto:{{ config('tourist.support_email') }}" class="hover:text-white">{{ config('tourist.support_email') }}</a></li>
                        @endif
                        @if (! config('tourist.hotline') && ! config('tourist.support_email'))
                            <li class="text-stone-500">Cập nhật trong phần cấu hình.</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="mt-10 flex flex-wrap items-center justify-between gap-4 border-t border-stone-800 pt-8 text-xs text-stone-500">
                <p>&copy; {{ date('Y') }} {{ config('tourist.site_title') }}. Đã đăng ký bản quyền.</p>
                <p class="text-stone-600">Tham khảo phong cách cổng <a href="https://visitnghean.gov.vn" class="text-accent-400 hover:text-accent-300" rel="noopener noreferrer">Du lịch Nghệ An</a>.</p>
            </div>
        </div>
    </footer>
</body>
</html>
