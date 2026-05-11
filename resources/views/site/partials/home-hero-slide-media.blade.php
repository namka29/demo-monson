@php
    use App\Enums\HeroBannerMediaType;

    $slideIndex ??= 0;

    /** @var int $slidesCount tổng slide đang có (1 = không carousel). */
    $slidesCount ??= 1;

    /** Chỉ slide đầu tải YouTube iframe ngay khi có nhiều slide; một slide duy nhất luôn tải iframe. */
    $loadYoutubeNow = (($slidesCount === 1) || ($slideIndex === 0));

    $youtubeEmbed = ($banner->media_type === HeroBannerMediaType::Youtube) ? $banner->youtubeEmbedSrc() : null;
@endphp

@if ($banner->media_type === HeroBannerMediaType::ImageUrl || $banner->media_type === HeroBannerMediaType::ImageUpload)
    @php $bgUrl = $banner->resolvedBackgroundImageUrl(); @endphp
    @if ($bgUrl)
        <img
            src="{{ e($bgUrl) }}"
            alt=""
            class="pointer-events-none absolute inset-0 h-full w-full object-cover"
            width="1920"
            height="1080"
            decoding="async"
            @if ($slideIndex === 0)
                fetchpriority="high"
            @endif
        >
    @endif
@elseif ($banner->media_type === HeroBannerMediaType::VideoUrl || $banner->media_type === HeroBannerMediaType::VideoUpload)
    @php
        $videoSrc = $banner->resolvedVideoSrc();
        $poster = $banner->resolvedPosterUrl();
    @endphp
    @if ($videoSrc)
        <video
            data-hero-video
            class="pointer-events-none absolute inset-0 h-full w-full object-cover"
            muted
            playsinline
            loop
            preload="metadata"
            @if (($slidesCount ?? 1) === 1) autoplay @endif
            @if ($poster) poster="{{ e($poster) }}" @endif
        >
            <source src="{{ e($videoSrc) }}" type="video/mp4">
        </video>
    @endif
@elseif ($banner->media_type === HeroBannerMediaType::Youtube)
    @if ($youtubeEmbed)
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <iframe
                class="pointer-events-none absolute left-1/2 top-1/2 h-[56.25vw] min-h-full w-[177.77vh] min-w-full -translate-x-1/2 -translate-y-1/2"
                title="Video slider trang chủ"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                data-hero-embed-src="{{ e($youtubeEmbed) }}"
                @if ($loadYoutubeNow)
                    src="{{ e($youtubeEmbed) }}"
                    loading="eager"
                @else
                    loading="lazy"
                @endif
            ></iframe>
        </div>
    @endif
@endif

@unless ($banner->slideHasRenderableMedia())
    <img
        src="{{ e($fallbackBg) }}"
        alt=""
        class="pointer-events-none absolute inset-0 h-full w-full object-cover"
        width="1920"
        height="1080"
        decoding="async"
    >
@endunless
