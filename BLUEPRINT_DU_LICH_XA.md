# Blueprint — Website du lịch cấp xã

Tài liệu tóm tắt yêu cầu (trích từ blueprint Laravel du lịch xã) để tra cứu nhanh khi triển khai.

## 1. Tech stack

| Thành phần | Lựa chọn |
|------------|-----------|
| Framework / view | Laravel (Blade) |
| Admin | Filament Admin |
| Cơ sở dữ liệu | MySQL |
| Bản đồ | Google Maps |
| Lưu trữ file | Local |

## 2. Module nghiệp vụ

- **Destination** — điểm du lịch  
- **Event** — lễ hội  
- **Post** — tin tức  
- **Page** — trang tĩnh  

### 2.1. Mở rộng cổng (menu & kênh nội dung — tham khảo cổng cấp tỉnh)

Các kênh sau **bổ sung** cho cổng thông tin du lịch cấp xã, bố cục và phân loại có thể tham khảo cổng cấp tỉnh (ví dụ [Du lịch Phú Thọ — mục Nơi ở](https://dulichphutho.com.vn/vi/hotels?PageID=1)): nhóm menu, bộ lọc khu vực / giá / loại hình (tuỳ giai đoạn triển khai).

| Kênh | Mục đích | Gợi ý đường dẫn công khai (ASCII, không dấu) |
|------|-----------|-----------------------------------------------|
| **Lưu trú** | Giới thiệu cơ sở lưu trú (khách sạn, homestay, resort…); có thể mở rộng danh mục & lọc sau | `/luu-tru` (+ chi tiết `/luu-tru/{slug}` khi có entity) |
| **Gợi ý tour** | Gợi ý tuyến / gói tham quan, liên kết điểm đến | `/goi-y-tour` (+ chi tiết tuỳ mô hình dữ liệu) |
| **Đặc sản địa phương** | Ẩm thực / đặc sản, OCOP (nội dung giới thiệu hoặc danh mục sản phẩm) | `/dac-san` (+ chi tiết tuỳ mô hình dữ liệu) |

**Phương án triển khai (lựa chọn theo phiên):**

1. **Giai đoạn 1:** Trang landing Blade + nội dung cấu hình / `Page` CMS (slug riêng hoặc URL đẹp qua route), menu header & footer.  
2. **Giai đoạn 2:** Bảng + Filament Resource (CRUD), slug, `published`, preview giống các module hiện có; bộ lọc & phân trang khi cần.

## 3. Phân quyền người dùng

| Vai trò | Quyền |
|---------|--------|
| **Admin** | Toàn quyền hệ thống |
| **Editor** | Tạo / sửa nội dung; **không** quản lý user |

## 4. Database mẫu (Destination)

| Trường | Kiểu / gợi ý |
|--------|----------------|
| `name` | string |
| `slug` | string |
| `description` | text |
| `latitude` | decimal |
| `longitude` | decimal |
| `status` | draft / published |

*(Các module khác có thể bổ sung bảng/field chi tiết khi implement.)*

## 5. Routes frontend (đề xuất — tiếng Việt không dấu)

- `/`  
- `/diem-den` — danh sách điểm đến  
- `/diem-den/{slug}` — chi tiết  
- `/su-kien` — sự kiện  
- `/su-kien/{slug}`  
- `/tin-tuc` — tin tức  
- `/tin-tuc/{slug}`  
- `/trang/{slug}` — trang tĩnh  
- `/luu-tru` — **Lưu trú** (landing / danh sách; chi tiết khi có module)  
- `/goi-y-tour` — **Gợi ý tour**  
- `/dac-san` — **Đặc sản địa phương**  

## 6. Quy tắc nghiệp vụ

- Chỉ hiển thị nội dung có **status = published** (mặt công khai).  
- **Slug** được tạo **tự động**.  
- Có chức năng **preview** cho admin (xem trước khi publish).  

## 7. Phạm vi triển khai (checklist tổng)

- [x] **Công việc 1** — Laravel 12 skeleton, `.env.example` ưu tiên MySQL, storage local (`FILESYSTEM_DISK=local`), `filament/filament` trong `composer.json`, và **Docker** (nginx + PHP-FPM + MySQL): `Dockerfile`, `compose.yml`, `.env.docker`, `scripts/docker-setup.sh` (chi tiết §8).
- [x] CRUD & Filament cho **Destination**, **Event**, **Post**, **Page**, **User** (theo policy Admin / Editor) — chi tiết tiến độ: `PROGRESS.md`.
- [x] Frontend Blade — trang chủ, `/diem-den`, `/su-kien`, `/tin-tuc`, `/trang/{slug}`; redirect URL cũ; preview bản nháp; sanitize HTML (Purify).
- [x] Bản đồ điểm đến — `TouristMaps` + tuỳ chọn Leaflet/OSM (`TOURISM_MAPS_DRIVER`).
- [x] **Lưu trú**, **Gợi ý tour**, **Đặc sản địa phương** — bảng `accommodations`, `tour_suggestions`, `local_specialties`; Filament CRUD; `/luu-tru`, `/goi-y-tour`, `/dac-san`; dữ liệu mẫu trong `TouristDemoSeeder` (§2.1).

## 8. Công việc 1 — Khởi tạo nền tảng (trạng thái repo)

**Đã có trong folder dự án**

- Laravel 12 (skeleton), Blade + Vite + Tailwind 4.
- **Filament** trong `composer.json` (`filament/filament` `^5.0`).
- **`.env.example`**: MySQL local / dev; **`.env.docker`**: giá trị phù hợp trong stack Docker (`DB_HOST=mysql`, …).
- **Docker**: `Dockerfile` (PHP 8.3-FPM), `docker/nginx/default.conf`, `compose.yml` (**nginx** cổng `:8080` → **app**, **mysql**), `.dockerignore`, volume Composer (`tourist_vendor`) và npm (`tourist_node_modules`) để `vendor`/node không ghi đè bind mount một cách hỗn loạn.

### Cách A — Docker (khuyến nghị nếu máy chỉ có Docker)

Yêu cầu **Docker Compose v2**.

1. `./scripts/docker-setup.sh`

   Hoặc từng bước: `docker compose build app` → `docker compose up -d` → (nếu chưa có `.env`) `cp .env.docker .env` → `docker compose exec app php artisan key:generate` → `docker compose exec app php artisan migrate` → `docker compose exec app php artisan filament:install --panels` → `docker compose --profile node run --rm node sh -lc "npm install && npm run build"`.

2. Mở ứng dụng **http://localhost:8080** (đổi cổng: biến môi trường `APP_PORT` khi `docker compose up`). MySQL có thể truy cập từ host qua **`localhost:3306`** (đổi `MYSQL_PUBLISH_PORT` nếu trùng cổng MySQL của máy).

3. **Profile `node`**: chỉ dùng khi cần chạy npm (build hoặc cài deps), ví dụ `docker compose --profile node run --rm node npm run dev`.

Lần đầu vào **`app`**, entrypoint trong image sẽ **`composer install`** nếu thư mục `vendor` trong volume chưa có.

**Terminal báo `docker: command not found` (hay gặp với bash trong Cursor)**

- Mở **Docker Desktop**, để trạng thái **Running**.
- Docker Desktop có thể cài symlink CLI: vào Docker Desktop (**Settings**, **Advanced** hoặc mục tương đương theo phiên bản — đôi khi **Install CLI tools** hoặc khu vực **Troubleshoot**).

Trong một phiên bash (tại thư mục gốc repo):

```bash
cd đường/dẫn/tới/tourist_web   # chỉnh đúng máy bạn
source scripts/lib/docker-desktop-path.sh
docker_desktop_prepend_path
which docker && docker compose version
```

Muốn cố định cho mọi cửa sổ bash, thêm dòng **`export PATH="/Applications/Docker.app/Contents/Resources/bin:$PATH"`** (và **`$HOME/.docker/bin`** nếu có) vào **`~/.bash_profile`** hoặc **`~/.bashrc`**.

macOS mặc định dùng **zsh**: thêm cùng dòng **`export PATH=...`** vào **`~/.zshrc`** rồi `source ~/.zshrc` (hoặc mở tab terminal mới).

**Không muốn sửa profile:** chạy lệnh Docker qua wrapper (từ thư mục gốc repo):

```bash
./scripts/run-with-docker.sh docker compose ps
./scripts/run-with-docker.sh docker compose up -d
```

### Cách B — Không Docker (PHP + Composer trực tiếp trên máy)

1. `docker compose up -d mysql` *chỉ* MySQL *(hoặc MySQL của bạn; chỉnh `DB_*` trong `.env`)*
2. `./scripts/bootstrap-step1.sh`

Hoặc tay: `composer install` → copy `.env.example` → `php artisan key:generate` → `php artisan migrate` → `php artisan filament:install --panels` → `npm install && npm run build` → `php artisan serve`.

Truy cập Filament sau khi cài panel (URL thường **`/admin`**).

---

*Nguồn: blueprint PDF `laravel_du_lich_xa_blueprint`.*
