@php
    $fallbackBg = config('tourist.hero_background_url');
    $slides = isset($heroSlides)
        ? collect($heroSlides)->filter(fn (\App\Models\HeroBanner $b) => $b->isRenderable())->values()
        : collect();

    $useSlideshow = $slides->count() > 1;
    $autoplayMs = isset($heroSlideAutoplayMs)
        ? (int) $heroSlideAutoplayMs
        : (int) config('tourist.hero_slide_autoplay_ms', 6500);
@endphp

<section
    id="hero-banner"
    class="hero-banner relative isolate mb-6 min-h-[min(88dvh,44rem)] overflow-hidden rounded-b-[2rem] text-white shadow-lg shadow-brand-900/20 sm:rounded-b-[2.5rem] lg:mb-8 lg:min-h-[min(85dvh,46rem)]"
    @if ($slides->count() >= 2)
        data-hero-slideshow
        data-autoplay-interval="{{ max(0, $autoplayMs) }}"
        role="region"
        aria-roledescription="carousel"
        aria-label="Banner trang chủ"
    @endif
>
    <div class="absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
        @if ($slides->isEmpty())
            <img
                src="{{ e($fallbackBg) }}"
                alt=""
                class="pointer-events-none absolute inset-0 h-full w-full object-cover"
                width="1920"
                height="1080"
                decoding="async"
                fetchpriority="high"
            >
        @else
            <div class="hero-banner__slides absolute inset-0 overflow-hidden">
                @foreach ($slides as $slideIndex => $banner)
                    <div
                        class="hero-banner__slide absolute inset-0 {{ $slideIndex === 0 ? 'is-active' : '' }}"
                        role="tabpanel"
                        id="hero-slide-{{ $slideIndex }}"
                        tabindex="-1"
                        data-hero-slide="{{ $slideIndex }}"
                        aria-hidden="{{ $slideIndex === 0 ? 'false' : 'true' }}"
                    >
                        @include('site.partials.home-hero-slide-media', [
                            'banner' => $banner,
                            'slideIndex' => $slideIndex,
                            'fallbackBg' => $fallbackBg,
                            'slidesCount' => $slides->count(),
                        ])
                    </div>
                @endforeach
            </div>

            @if ($useSlideshow)
                <div class="hero-banner__dots-wrap pointer-events-none absolute inset-x-0 bottom-6 z-30 flex justify-center px-4 sm:bottom-10">
                    <div
                        class="pointer-events-auto flex items-center gap-2 rounded-full border border-white/20 bg-brand-950/40 px-2 py-2 backdrop-blur-md"
                        role="tablist"
                        aria-label="Chọn slide"
                    >
                        @foreach ($slides as $slideIndex => $banner)
                            <button
                                type="button"
                                class="hero-banner__dot rounded-full bg-white/35 transition-[transform,background-color,width] hover:bg-white/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-400 {{ $slideIndex === 0 ? 'hero-banner__dot--active' : '' }}"
                                role="tab"
                                aria-selected="{{ $slideIndex === 0 ? 'true' : 'false' }}"
                                aria-controls="hero-slide-{{ $slideIndex }}"
                                tabindex="{{ $slideIndex === 0 ? '0' : '-1' }}"
                                data-go-slide="{{ $slideIndex }}"
                            >
                                <span class="sr-only">Slide {{ $slideIndex + 1 }}/{{ $slides->count() }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

    <div class="relative z-10 mx-auto flex min-h-[min(88dvh,44rem)] w-full max-w-7xl flex-col justify-center px-4 py-16 sm:px-6 sm:py-24 lg:min-h-[min(85dvh,46rem)] lg:px-8 lg:py-28">
        <div class="max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[0.35em] text-accent-300 sm:text-sm">
                #{{ config('app.name') }}
            </p>
            <p class="mt-4 text-xl font-medium text-white/90 sm:text-2xl">Trải nghiệm</p>
            <h1 class="mt-2 text-4xl font-bold leading-[1.1] tracking-tight drop-shadow-[0_1px_24px_oklch(0.22_0.05_230_/_0.65)] sm:text-5xl lg:text-6xl">
                Du lịch {{ config('app.name') }}
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-relaxed text-cyan-50/95 drop-shadow-[0_1px_16px_oklch(0.22_0.05_230_/_0.55)] sm:text-lg">
                {{ config('tourist.hero_tagline') }}
            </p>

            <nav class="mt-10 flex flex-wrap gap-2 sm:gap-3" aria-label="Lối tắt nội dung">
                <a href="{{ route('destinations.index') }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Khám phá
                </a>
                <a href="{{ route('destinations.index') }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Điểm đến
                </a>
                <a href="{{ route('events.index') }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Lễ hội &amp; sự kiện
                </a>
                <a href="{{ route('posts.index') }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Tin tức
                </a>
                <a href="{{ route('posts.index') }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Ẩm thực &amp; văn hóa
                </a>
                <a href="{{ route('pages.show', ['page' => 'gioi-thieu']) }}" class="hero-banner__pill">
                    <span class="hero-banner__pill-icon" aria-hidden="true"></span>Giới thiệu
                </a>
            </nav>

            <div class="mt-10 flex flex-wrap items-center gap-3">
                <a href="{{ route('destinations.index') }}" class="btn-hero-primary px-8 py-3 text-base shadow-xl">
                    Khám phá ngay
                </a>
                <a href="{{ route('events.index') }}" class="rounded-xl border-2 border-white/40 bg-white/10 px-8 py-3 text-base font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                    Lịch sự kiện
                </a>
            </div>
        </div>
    </div>
</section>
