{{-- Variables: $mapHeadingId, $placeTitle, $latitude, $longitude --}}

@if (\App\Support\TouristMaps::canEmbedIframe($latitude ?? null, $longitude ?? null))
    <section class="mt-10" aria-labelledby="{{ $mapHeadingId }}">
        <h2 id="{{ $mapHeadingId }}" class="text-lg font-bold text-brand-950">Vị trí trên bản đồ</h2>
        <p class="mt-2 text-sm text-stone-600">
            Bản đồ <a href="https://www.google.com/maps" class="font-medium text-brand-700 underline hover:text-brand-900" rel="noopener noreferrer">Google Maps</a>
            (nhúng iframe theo tọa độ, không dùng API key).
        </p>
        <div class="site-coordinate-map mt-4 overflow-hidden rounded-2xl ring-1 ring-stone-200">
            <iframe
                class="block h-[min(22rem,55vh)] w-full border-0"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
                src="{{ \App\Support\TouristMaps::googleIframeSrc($latitude, $longitude) }}"
                title="Bản đồ Google — {{ $placeTitle }}"
            ></iframe>
        </div>
        <p class="mt-3 text-sm text-stone-500">
            Tọa độ (WGS84):
            <span class="font-mono text-stone-700">{{ $latitude }}, {{ $longitude }}</span>
            —
            <a
                href="{{ \App\Support\TouristMaps::googleMapsExternalUrl($latitude, $longitude) }}"
                class="font-medium text-brand-700 underline hover:text-brand-900"
                rel="noopener noreferrer"
                target="_blank"
            >Mở trong Google Maps</a>
        </p>
    </section>
@endif
