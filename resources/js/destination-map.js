/**
 * Bản đồ OSM (Leaflet) — chỉ tải khi có [data-destination-map] (trang không dùng Google iframe).
 */
async function initDestinationMaps() {
    const els = document.querySelectorAll('[data-destination-map]');
    if (els.length === 0) {
        return;
    }

    const L = (await import('leaflet')).default;
    await import('leaflet/dist/leaflet.css');

    els.forEach((el) => {
        const lat = parseFloat(el.dataset.lat ?? '');
        const lng = parseFloat(el.dataset.lng ?? '');
        const label = el.dataset.label ?? '';

        if (Number.isNaN(lat) || Number.isNaN(lng)) {
            return;
        }

        const map = L.map(el, {
            scrollWheelZoom: false,
        }).setView([lat, lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright" rel="noopener noreferrer">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(map);

        const marker = L.circleMarker([lat, lng], {
            radius: 10,
            fillColor: '#0f766e',
            color: '#ffffff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.92,
        }).addTo(map);

        if (label) {
            const popup = document.createElement('div');
            popup.className = 'max-w-xs text-sm font-medium text-stone-800';
            popup.textContent = label;
            marker.bindPopup(popup);
        }

        requestAnimationFrame(() => map.invalidateSize());
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDestinationMaps);
} else {
    initDestinationMaps();
}
