import './bootstrap';
import './destination-map';

function initSiteNav() {
    const toggle = document.getElementById('site-nav-toggle');
    const panel = document.getElementById('site-nav-mobile');
    const iconOpen = document.getElementById('site-nav-icon-open');
    const iconClose = document.getElementById('site-nav-icon-close');

    if (!toggle || !panel) {
        return;
    }

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
        panel.classList.toggle('hidden', !open);
        if (iconOpen && iconClose) {
            iconOpen.classList.toggle('hidden', open);
            iconClose.classList.toggle('hidden', !open);
        }
    };

    toggle.addEventListener('click', () => {
        const next = toggle.getAttribute('aria-expanded') !== 'true';
        setOpen(next);
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    window.matchMedia('(min-width: 768px)').addEventListener('change', (e) => {
        if (e.matches) {
            setOpen(false);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSiteNav);
} else {
    initSiteNav();
}

/** Banner trang chủ: carousel (Fade + autoplay). Chỉ chạy khi có `[data-hero-slideshow]` (≥2 slide). */
function syncYoutubeIfForSlide(activeSlide) {
    const banner = activeSlide?.closest('#hero-banner');
    if (!banner) return;
    banner.querySelectorAll('.hero-banner__slide').forEach((slideEl) => {
        const active = slideEl === activeSlide;
        slideEl.querySelectorAll('iframe[data-hero-embed-src]').forEach((frame) => {
            const url = frame.getAttribute('data-hero-embed-src');
            if (!url) return;
            if (active) {
                frame.setAttribute('src', url);
            } else {
                frame.removeAttribute('src');
            }
        });
    });
}

function pauseVideosOutside(rootBanner, activeSlide) {
    rootBanner.querySelectorAll('video[data-hero-video]').forEach((video) => {
        if (!activeSlide || !activeSlide.contains(video)) {
            video.pause();
        }
    });
}

function activateHeroBannerSlide(root, index) {
    const slides = [...root.querySelectorAll('.hero-banner__slide[data-hero-slide]')];
    if (!slides.length) return;

    let next = Number.parseInt(String(index), 10);
    if (Number.isNaN(next)) next = 0;
    next = (next % slides.length + slides.length) % slides.length;

    const active = slides[next];
    if (!active) return;

    slides.forEach((slide) => slide.classList.remove('is-active'));
    slides.forEach((slide) =>
        slide.setAttribute('aria-hidden', slide === active ? 'false' : 'true'),
    );
    active.classList.add('is-active');

    const bannerRoot = root.closest('#hero-banner');
    if (bannerRoot) {
        pauseVideosOutside(bannerRoot, active);
    }
    active.querySelectorAll('video[data-hero-video]').forEach((video) => {
        video.play().catch(() => {});
    });
    syncYoutubeIfForSlide(active);

    root.querySelectorAll('[data-go-slide]').forEach((btn) => {
        const i = Number.parseInt(btn.getAttribute('data-go-slide') ?? '', 10);
        const on = i === next;
        btn.classList.toggle('hero-banner__dot--active', on);
        btn.setAttribute('aria-selected', on ? 'true' : 'false');
        btn.tabIndex = on ? 0 : -1;
    });
}

function initHeroHomeSlideshow() {
    const root = document.querySelector('[data-hero-slideshow].hero-banner');
    if (!(root instanceof HTMLElement)) return;

    const slides = [...root.querySelectorAll('.hero-banner__slide[data-hero-slide]')];
    if (slides.length <= 1) return;

    const rawMs = root.getAttribute('data-autoplay-interval');
    let autoplayMs = Number.parseInt(String(rawMs ?? '').trim(), 10);
    if (Number.isNaN(autoplayMs)) {
        autoplayMs = 6500;
    }
    autoplayMs = Math.max(0, autoplayMs);

    let current = slides.findIndex((s) => s.classList.contains('is-active'));
    if (current < 0) current = 0;

    let timer = null;

    const startAutoplay = () => {
        if (timer !== null || autoplayMs <= 0) return;
        timer = window.setInterval(() => {
            const next = ((current ?? 0) + 1) % slides.length;
            current = next;
            activateHeroBannerSlide(root, next);
        }, autoplayMs);
    };

    const stopAutoplay = () => {
        if (timer === null) return;
        window.clearInterval(timer);
        timer = null;
    };

    const go = (i) => {
        current = i;
        activateHeroBannerSlide(root, i);
    };

    root.querySelectorAll('[data-go-slide]').forEach((btn) => {
        btn.addEventListener('click', () => {
            stopAutoplay();
            const idx = Number.parseInt(btn.getAttribute('data-go-slide') ?? '', 10);
            if (!Number.isNaN(idx)) go(idx);
        });
    });

    root.addEventListener('keydown', (e) => {
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
        /** Tránh chiếm phím điều khiển khi đang đọc/link/chữ trong hero — chỉ khi focus ô chấm. */
        const el = e.target instanceof HTMLElement ? e.target : null;
        if (!el?.closest('.hero-banner__dots-wrap')) return;
        e.preventDefault();
        stopAutoplay();
        const dir = e.key === 'ArrowLeft' ? -1 : 1;
        go(((current ?? 0) + dir + slides.length) % slides.length);
    });

    // Chỉ tạm dừng khi người dùng tương tác nút chấm (không dừng cả khối hero — banner rất cao, chuột thường nằm trong vùng).
    const dotsWrap = root.querySelector('.hero-banner__dots-wrap');
    if (dotsWrap instanceof HTMLElement) {
        dotsWrap.addEventListener('mouseenter', stopAutoplay);
        dotsWrap.addEventListener('mouseleave', () => startAutoplay());
        dotsWrap.addEventListener('focusin', stopAutoplay);
        dotsWrap.addEventListener('focusout', () => {
            window.queueMicrotask(() => {
                if (!dotsWrap.contains(document.activeElement)) {
                    startAutoplay();
                }
            });
        });
    }

    activateHeroBannerSlide(root, current);
    startAutoplay();

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopAutoplay();
        else startAutoplay();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroHomeSlideshow);
} else {
    initHeroHomeSlideshow();
}
