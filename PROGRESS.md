# Tiến độ dự án (đồng bộ đa agent)

File này giúp **nhiều agent / phiên làm việc** cùng một codebase: biết đã làm gì, còn gì, và tránh chồng chéo.  
**Blueprint chi tiết:** xem [`BLUEPRINT_DU_LICH_XA.md`](BLUEPRINT_DU_LICH_XA.md).

---

## Quy ước khi làm việc

1. **Đầu phiên:** đọc `PROGRESS.md` + phần liên quan trong `BLUEPRINT_DU_LICH_XA.md`.
2. **Cuối phiên:** cập nhật bảng **Tiến độ**, **Việc đang mở / khối**, và **Handoff gần nhất** (ngắn gọn, có ngày).
3. **Tránh:** hai agent cùng sửa một module lớn không báo — ghi ý định làm vào **Việc đang mở**.

---

## Ngữ cảnh nhanh

| Mục | Giá trị |
|-----|---------|
| Stack | Laravel 12, Blade, Vite, Filament 5, MariaDB 10.5 (Docker) |
| Admin | `/admin` |
| Docker | `compose.yml`, `Dockerfile`, `scripts/docker-setup.sh`, `scripts/docker-npm.sh`, `scripts/docker-npm-dev.sh` |
| Role đơn giản | Cột `users.role` (`admin` / `editor`), `users.is_active` |

---

## Tiến độ tổng (checklist)

### Hạ tầng & dự án

- [x] Docker (nginx + PHP-FPM + app + **MariaDB 10.5**), script bootstrap/setup
- [x] Chạy **npm** trong Docker: `./scripts/docker-npm.sh` (install/build/…), `./scripts/docker-npm-dev.sh` (Vite dev + port 5173); `docker-setup.sh` gọi các script này cho build asset
- [x] Session / proxy / nginx phục vụ Filament & Livewire khi cần
- [x] `APP_NAME`, `.env` mẫu phù hợp local / Docker

### Cơ sở dữ liệu & model

- [x] Bảng: `destinations`, `events`, `posts`, `pages` (+ `status` draft/published)
- [x] Bảng `users`: thêm `role`, `is_active`
- [x] Enum `PublicationStatus`, `UserRole`; model + scope `published` (Post có logic `published_at`)
- [x] Slug tự sinh (trait), route binding công khai theo slug + chỉ published

### Admin Filament

- [x] Resource: Destination, Event, Post, Page, **Accommodation**, **TourSuggestion**, **LocalSpecialty** (CRUD, lọc status / loại / nhóm)
- [x] Resource User (chỉ Admin): role, `is_active`, mật khẩu
- [x] Policy: Editor không xóa nội dung; Admin đầy đủ; User chỉ Admin
- [x] Nhãn / hướng dẫn / placeholder **tiếng Việt** trên form & bảng
- [x] Filament UI theo **locale ứng dụng**: đặt `APP_LOCALE=vi` (Filament 5 không có `Panel::locale()`; chuỗi core lấy từ gói ngôn ngữ vendor sau `composer install`; có thể publish `lang` nếu cần chỉnh tay)
- [ ] *(tuỳ chọn)* Publish / chỉnh file `lang` vendor Filament để toàn bộ nhãn hệ thống (nút, bảng…) đồng nhất tiếng Việt 100% nếu còn sót tiếng Anh

### Website công khai

- [x] Trang chủ, `/diem-den`, `/su-kien`, `/tin-tuc`, `/trang/{slug}`; **`/luu-tru`**, **`/goi-y-tour`**, **`/dac-san`** (Lưu trú, Gợi ý tour, Đặc sản) + bộ lọc loại/nhóm, preview admin
- [x] Bảng & Filament: `accommodations`, `tour_suggestions`, `local_specialties` (dữ liệu mẫu trong `TouristDemoSeeder`, tham khảo cổng cấp tỉnh / OCOP)
- [x] Chỉ hiển thị nội dung **đã xuất bản** (binding trong `AppServiceProvider`)
- [x] **Vite + Tailwind** luôn load qua `@vite`; theme cổng du lịch (teal/cyan, hero, header/footer, menu mobile JS) — tham khảo phong cách [visitnghean.gov.vn](https://visitnghean.gov.vn)
- [x] `config/tourist.php` (hotline, tagline tùy chọn qua env), phân trang `vendor/pagination/tailwind`, nội dung rich text dùng class `.article-content`
- [x] **Redirect 301** từ `/destinations`, `/events`, `/posts`, `/pages/...` (URL cũ) sang đường dẫn tiếng Việt tương ứng
- [x] **Preview bản nháp**: `/xem-truoc/...`, middleware `auth` + `preview.staff`, `PreviewController`, bind `preview*` trong `AppServiceProvider`, nút «Xem trước trên web» trên trang sửa Filament
- [x] **Google Maps / OSM**: `config/tourist.php` + `TouristMaps` (`app/Support/TouristMaps.php`) trên trang chi tiết điểm đến — mặc định Google iframe `output=embed` (không cần API key); `TOURISM_MAPS_DRIVER=leaflet` → Leaflet + OpenStreetMap
- [x] Chuẩn hoá kiến trúc L5 cho luồng public/custom: `Controller -> Service -> Repository`, route binding resolve qua repository, tách hero thành `HeroBannerRepository` + `HeroSlideshowSettingRepository` (giữ nguyên luồng CRUD mặc định của Filament/Laravel bên thứ 3)

### An toàn & nội dung

- [x] Sanitize HTML: `stevebauman/purify`, `config/purify.php`, partial `partials/purified-body` cho `body` Post/Page, Tour (`body`), Đặc sản (`description`)
- *Ghi chú:* HTMLPurifier **không hỗ trợ** khai attribute `loading` trên `img` trong `HTML.Allowed` (sẽ 500). Cấu hình dùng `img[src|alt|width|height|class]`; nội dung/seed không dùng `loading="lazy"` trong HTML lưu DB (ảnh hero template dùng `loading` ở Blade vẫn ổn vì không qua Purify).
- [x] Quy trình an toàn DB: `docs/DB_SAFETY_RUNBOOK.md` + script `scripts/db-backup.sh` (backup SQL nhanh) + `scripts/db-safe-migrate.sh` (backup -> status -> migrate)

---

## Việc đang mở / khối (cập nhật khi có)

| Việc | Trạng thái | Ghi chú |
|------|------------|---------|
| *(trống)* | — | Thêm dòng khi có task đang giữ hoặc bị block |

---

## Handoff gần nhất

| Ngày (UTC hoặc local) | Người / Agent | Nội dung ngắn |
|------------------------|---------------|----------------|
| 2026-05-03 | Agent | Giao diện site công khai (Blade + Vite/Tailwind, `layouts/site`, vi-VN). Thêm `config/tourist.php`, phân trang, script `docker-npm.sh` / `docker-npm-dev.sh`, `vite` `server.host: true` cho dev trong container. |
| 2026-05-03 | Agent | Hoàn thiện: preview `/xem-truoc/*`, redirect 301 từ URL tiếng Anh cũ, Purify cho Post/Page, banner xem trước, Filament + `APP_LOCALE=vi` + nút xem trước, `config/services.php` (`google_maps`), cập nhật checklist. |
| 2026-05-03 | Agent | Sửa lỗi 500 trang tĩnh (vd. `/trang/gioi-thieu`): bỏ `loading` khỏi `HTML.Allowed` Purify, bổ sung `class` cho `img`/`figure`/`figcaption`; cập nhật seed. Bỏ `Panel::locale()` (Filament 5 không có method này). Rà soát lại `PROGRESS` + mô tả bản đồ khớp `TouristMaps`. |
| 2026-05-03 | Agent | Lưu trú / Gợi ý tour / Đặc sản: migration 3 bảng, model + enum, Filament, route công khai + preview, menu, `TouristDemoSeeder` mẫu (tham khảo cổng tỉnh & OCOP). |
| 2026-05-04 | Agent | Rà soát và đồng bộ kiến trúc L5 cho phần source custom: thêm Contracts/Repositories cho module public, `HomePageService`, chuyển `Route::bind` sang repository, tách Hero slideshow/settings vào 2 repository riêng; không thay đổi luồng mặc định third-party. Verify `docker compose exec app php artisan route:list` và `docker compose exec app php artisan test` đều OK. |
| 2026-05-04 | Agent | Thêm bộ quy trình an toàn DB: runbook `docs/DB_SAFETY_RUNBOOK.md`, script backup `scripts/db-backup.sh`, script migrate an toàn `scripts/db-safe-migrate.sh`; thống nhất nguyên tắc "backup truoc khi ghi DB". |

---

## Lệnh thường dùng (Docker)

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan route:list
# Node / Vite (không cần npm trên máy host)
./scripts/docker-npm.sh install
./scripts/docker-npm.sh run build
./scripts/docker-npm-dev.sh
```

---

## Gợi ý phân công song song

| Khu vực | File / namespace gợi ý | Rủi ro trùng |
|---------|-------------------------|--------------|
| Filament | `app/Filament/Resources/` | Trùng cùng một Resource |
| Policy | `app/Policies/` | Trùng model |
| Frontend site | `routes/web.php`, `resources/views/site/`, `app/Http/Controllers/Site/` | Route naming |
| DB | `database/migrations/` | Luôn tạo migration mới, tránh sửa migration đã chạy production |

*Nếu mở rộng (Maps, Preview), nên thêm một dòng vào **Việc đang mở** trước khi code.*
