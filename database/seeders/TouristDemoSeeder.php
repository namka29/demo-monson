<?php

namespace Database\Seeders;

use App\Enums\AccommodationType;
use App\Enums\PublicationStatus;
use App\Enums\SpecialtyCategory;
use App\Models\Accommodation;
use App\Models\Destination;
use App\Models\Event;
use App\Models\LocalSpecialty;
use App\Models\Page;
use App\Models\Post;
use App\Models\TourSuggestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Dữ liệu mẫu tham khảo phong cách nội dung https://visitnghean.gov.vn, cấu trúc kênh (lưu trú, tour, đặc sản) tham khảo các cổng cấp tỉnh (ví dụ dulichphutho.com.vn). Demo, không thuộc cơ quan thật.
 * Ảnh: Unsplash (CC) — cần kết nối mạng khi hiển thị URL ngoài.
 */
class TouristDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedDestinations();
        $this->seedEvents();
        $this->seedPosts();
        $this->seedPages();
        $this->seedAccommodations();
        $this->seedTourSuggestions();
        $this->seedLocalSpecialties();
    }

    private function seedDestinations(): void
    {
        $rows = [
            [
                'name' => 'Khu lưu niệm Chủ tịch Hồ Chí Minh tại Kim Liên',
                'slug' => 'khu-luu-niem-kim-lien',
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'description' => "Làng Sen, xã Kim Liên — nơi lưu giữ kỷ vật và không gian gắn với thời thơ ấu của Chủ tịch Hồ Chí Minh. Điểm hành hương văn hóa quan trọng của tỉnh, thu hút du khách trong và ngoài nước.\n\nGợi ý: dành nửa ngày, kết hợp tham quan nhà lưu niệm, mộ bà Hoàng Thị Loan và không gian làng quê.",
                'latitude' => 18.6842,
                'longitude' => 105.5444,
            ],
            [
                'name' => 'Biển Cửa Lò',
                'slug' => 'bien-cua-lo',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'description' => "Một trong những bãi biển nổi tiếng miền Trung với bãi cát dài, sóng hiền và hải sản tươi. Thích hợp nghỉ dưỡng, thể thao dưới nước và các lễ hội du lịch theo mùa.\n\nMùa cao điểm: hè; du khách nên đặt phòng trước khi lễ hội lớn.",
                'latitude' => 18.7995,
                'longitude' => 105.7180,
            ],
            [
                'name' => 'Vườn quốc gia Pù Mát',
                'slug' => 'vuon-quoc-gia-pu-mat',
                'image_url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80',
                'description' => "Rừng nguyên sinh, động — thực vật phong phú; điểm đến cho trekking, quan sát thiên nhiên và trải nghiệm văn hóa bản địa vùng Tây Nghệ An.\n\nDu khách tuân thủ quy định bảo vệ rừng và đi cùng hướng dẫn viên khi vào tuyến sâu.",
                'latitude' => 19.0500,
                'longitude' => 104.8833,
            ],
            [
                'name' => 'Chùa Bảo Lâm',
                'slug' => 'chua-bao-lam',
                'image_url' => 'https://images.unsplash.com/photo-1545569341-9eb8b30979d9?auto=format&fit=crop&w=1200&q=80',
                'description' => "Ngôi chùa cổ mang kiến trúc đặc trưng, không gian thanh tịnh — điểm dừng chân tâm linh và chiêm ngưỡng nghệ thuật tạo hình truyền thống.\n\nThích hợp tham quan buổi sáng; chú ý trang phục lịch sự khi vào khu thờ.",
                'latitude' => 18.7333,
                'longitude' => 105.6167,
            ],
            [
                'name' => 'Đảo chè Thanh Chương',
                'slug' => 'dao-che-thanh-chuong',
                'image_url' => 'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1200&q=80',
                'description' => "Cảnh quan đồi chè xanh mướt, đường đi bộ và góc chụp ảnh đẹp — trải nghiệm «check-in» và tìm hiểu văn hóa trồng chè địa phương.\n\nNên mang giày thể thao; một số khu thu phí tham quan theo quy định địa phương.",
                'latitude' => 18.7167,
                'longitude' => 105.4333,
            ],
            [
                'name' => 'Thành phố Vinh',
                'slug' => 'thanh-pho-vinh',
                'image_url' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&w=1200&q=80',
                'description' => "Trung tâm hành chính — kinh tế của tỉnh: ẩm thực đường phố, nơi nghỉ, kết nối giao thương và điểm trung chuyển tới các điểm du lịch lân cận.\n\nLưu ý giao thông giờ cao điểm; dùng bản đồ giao thông công cộng khi có.",
                'latitude' => 18.6796,
                'longitude' => 105.6813,
            ],
        ];

        foreach ($rows as $row) {
            Destination::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'image_url' => $row['image_url'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }

    private function seedEvents(): void
    {
        $tz = config('app.timezone', 'UTC');

        $rows = [
            [
                'title' => 'Festival Du lịch Cửa Lò: Bốn mùa biển gọi',
                'slug' => 'festival-du-lich-cua-lo-bon-mua-bien-goi',
                'image_url' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1200&q=80',
                'description' => "Lễ hội văn hóa — du lịch nhằm quảng bá hình ảnh biển Cửa Lò, giới thiệu tiềm năng du lịch và các hoạt động thể thao biển, ẩm thực địa phương.\n\n(Dữ liệu mẫu — thời gian có thể chỉnh trong admin.)",
                'starts_at' => Carbon::parse('2026-04-25 08:00', $tz),
                'ends_at' => Carbon::parse('2026-04-28 22:00', $tz),
                'location' => 'Phường Cửa Lò, tỉnh Nghệ An',
            ],
            [
                'title' => 'Lễ hội Đền Cuông',
                'slug' => 'le-hoi-den-cuong',
                'image_url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
                'description' => "Lễ hội truyền thống gắn với không gian đền thờ và văn hóa cội nguồn; thu hút du khách thập phương về Hoan Châu.\n\n(Dữ liệu mẫu.)",
                'starts_at' => Carbon::parse('2026-04-01 07:00', $tz),
                'ends_at' => Carbon::parse('2026-04-04 21:00', $tz),
                'location' => 'Đền Cuông, xã An Châu',
            ],
            [
                'title' => 'Lễ hội làng Vạc',
                'slug' => 'le-hoi-lang-vac',
                'image_url' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=1200&q=80',
                'description' => "Hoạt động văn hóa cộng đồng với phần lễ trang nghiêm và phần hội sôi động — giữ gìn di sản địa phương.\n\n(Dữ liệu mẫu.)",
                'starts_at' => Carbon::parse('2026-03-25 08:00', $tz),
                'ends_at' => Carbon::parse('2026-03-27 22:00', $tz),
                'location' => 'Khu di chỉ khảo cổ học làng Vạc, phường Thái Hòa',
            ],
            [
                'title' => 'Lễ hội Đền Chín Gian',
                'slug' => 'le-hoi-den-chin-gian',
                'image_url' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=1200&q=80',
                'description' => "Di tích kiểu nhà sàn, gắn với văn hóa dân tộc Thái — trải nghiệm nghi lễ và ẩm thực miền Tây xứ Nghệ.\n\n(Dữ liệu mẫu.)",
                'starts_at' => Carbon::parse('2026-04-01 09:00', $tz),
                'ends_at' => Carbon::parse('2026-04-03 18:00', $tz),
                'location' => 'Đền Chín Gian, xã Quế Phong',
            ],
        ];

        foreach ($rows as $row) {
            Event::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'image_url' => $row['image_url'],
                    'starts_at' => $row['starts_at'],
                    'ends_at' => $row['ends_at'],
                    'location' => $row['location'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }

    private function seedPosts(): void
    {
        $tz = config('app.timezone', 'UTC');

        $img1 = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80';
        $img2 = 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80';

        $rows = [
            [
                'title' => 'Top trải nghiệm ẩm thực Nghệ An nhất định phải thử',
                'slug' => 'top-am-thuc-nghe-an',
                'image_url' => $img1,
                'excerpt' => 'Từ cháo lươn, mướp đắng nhồi thịt đến hải sản Cửa Lò — gợi ý lịch ăn cho chuyến đi ngắn ngày.',
                'body' => <<<HTML
<p>Nghệ An nổi tiếng với ẩm thực đậm đà, kết hợp hải sản miền biển và món quê truyền thống. Dưới đây là một số gợi ý (nội dung demo).</p>
<figure class="my-6">
  <img src="{$img1}" alt="Món ăn địa phương" width="1200" height="675" class="w-full rounded-xl shadow-sm">
  <figcaption class="mt-2 text-center text-sm text-stone-500">Ảnh minh họa — Unsplash</figcaption>
</figure>
<p>Khi du lịch Cửa Lò, du khách có thể thử các món hải sản tươi theo mùa; tại Vinh và vùng lân cận, đừng bỏ qua đặc sản làm quà như nhút Thanh Chương (nếu có chương trình OCOP địa phương).</p>
<p><strong>Lưu ý:</strong> Thực đơn thực tế và địa chỉ quán nên được ban quản trị cập nhật theo mùa và kiểm định ATTP.</p>
HTML,
                'published_at' => Carbon::parse('2026-05-01 10:00', $tz),
            ],
            [
                'title' => 'Gợi ý lịch trình 2 ngày 1 đêm: biển — làng Sen',
                'slug' => 'lich-trinh-2-ngay-bien-lang-sen',
                'image_url' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Kết hợp nghỉ biển Cửa Lò và hành trình văn hóa tại Kim Liên.',
                'body' => <<<HTML
<p>Ngày 1: di chuyển tới Cửa Lò, nghỉ ngơi và tắm biển; chiều thưởng thức hải sản. Ngày 2: khởi hành sớm về Kim Liên, tham quan khu lưu niệm và trở về.</p>
<figure class="my-6">
  <img src="{$img2}" alt="Bữa ăn và không gian du lịch" width="1200" height="675" class="w-full rounded-xl shadow-sm">
</figure>
<p>Bài viết mang tính minh họa — điều chỉnh lịch theo phương tiện và mùa du lịch thực tế.</p>
HTML,
                'published_at' => Carbon::parse('2026-04-20 09:00', $tz),
            ],
            [
                'title' => 'Du lịch có trách nhiệm: gìn giữ di sản và môi trường',
                'slug' => 'du-lich-co-trach-nhiem',
                'image_url' => 'https://images.unsplash.com/photo-1470071459604-04b01a3e0a89?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Không xả rác tại khu di tích; tôn trọng nghi lễ tại đình, đền; ưu tiên dịch vụ địa phương.',
                'body' => <<<HTML
<p>Cổng thông tin du lịch khuyến khích du khách hành xử văn minh: giữ trật tự, xếp hàng, không chạm vào hiện vật trưng bày và tuân theo hướng dẫn tại di tích.</p>
<p>Tại khu bảo tồn thiên nhiên, không săn bắt, không thu thập mẫu thực vật — giúp bảo vệ hệ sinh thái cho thế hệ sau.</p>
HTML,
                'published_at' => Carbon::parse('2026-03-15 08:00', $tz),
            ],
        ];

        foreach ($rows as $row) {
            Post::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'excerpt' => $row['excerpt'],
                    'body' => $row['body'],
                    'image_url' => $row['image_url'],
                    'published_at' => $row['published_at'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }

    private function seedPages(): void
    {
        $hero = 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1400&q=80';

        Page::query()->updateOrCreate(
            ['slug' => 'gioi-thieu'],
            [
                'title' => 'Giới thiệu',
                'status' => PublicationStatus::Published,
                'body' => <<<HTML
<p><strong>Đây là trang nội dung tĩnh mẫu</strong>, tham khảo bố cục cổng du lịch địa phương như <a href="https://visitnghean.gov.vn" target="_blank" rel="noopener noreferrer">Khám phá Du lịch Nghệ An</a>. Nội dung mang tính minh họa cho hệ thống CMS của dự án.</p>
<figure class="my-8">
  <img src="{$hero}" alt="Phong cảnh thiên nhiên" width="1400" height="788" class="w-full rounded-2xl shadow-md">
  <figcaption class="mt-3 text-center text-sm text-stone-500">Ảnh minh họa — Unsplash</figcaption>
</figure>
<h2>Vì sao du lịch bền vững?</h2>
<p>Chúng tôi khuyến khích du khách sử dụng phương tiện công cộng khi có thể, giảm rác thải nhựa và tôn trọng văn hóa địa phương.</p>
<ul>
  <li>Bảo vệ di sản và cảnh quan</li>
  <li>Hỗ trợ sản phẩm OCOP, làng nghề</li>
  <li>Cập nhật tin tức và lịch sự kiện trên website</li>
</ul>
HTML,
            ],
        );
    }

    private function seedAccommodations(): void
    {
        $rows = [
            [
                'name' => 'Homestay Bản Mường — Nhà sàn view ruộng bậc thang',
                'slug' => 'homestay-ban-muong',
                'accommodation_type' => AccommodationType::Homestay,
                'image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Thôn P., xã T. (minh họa) — cách trung tâm khoảng 8 km',
                'price_hint' => '450.000đ – 850.000đ / đêm (2 người)',
                'contact_phone' => '0912 345 678',
                'description' => "Phòng nhà sàn gỗ, view cánh đồng và đồi thông. Ăn sáng đặc sản địa phương, chủ nhà hỗ trợ book xe đưa đón.\n\nPhù hợp gia đình nhỏ và nhóm bạn; đặt trước vào cuối tuần và ngày lễ.",
            ],
            [
                'name' => 'Khu nghỉ sinh thái Suối Khe',
                'slug' => 'resort-suoi-khe',
                'accommodation_type' => AccommodationType::Resort,
                'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Xã V., ven suối — minh họa địa danh',
                'price_hint' => 'Từ 1.800.000đ / bungalow / đêm',
                'contact_phone' => '0219 382 xxxx',
                'description' => "Bungalow mái lá, hồ bơi nhỏ dành cho khách lưu trú, nhà hàng phục vụ đặc sản đồng quê.\n\nTrẻ em có khu vui chơi ngoài trời; xe đưa đón theo lịch cố định đến các điểm du lịch lân cận.",
            ],
            [
                'name' => 'Khách sạn Tràng An Central',
                'slug' => 'khach-san-trang-an-central',
                'accommodation_type' => AccommodationType::Hotel,
                'latitude' => 20.2895000,
                'longitude' => 105.9100000,
                'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Đường Hùng Vương, TT. (minh họa)',
                'price_hint' => '800.000đ – 1.400.000đ / phòng đôi',
                'contact_phone' => '0219 123 456',
                'description' => "Khách sạn 3 sao khu vực trung tâm: thuận tiện di chuyển, đỗ xe, wifi, phòng họp nhỏ cho đoàn.\n\nƯu đãi đoàn và booking dài ngày — liên hệ trực tiếp hotline.",
            ],
            [
                'name' => 'Bungalow Lake View',
                'slug' => 'bungalow-lake-view',
                'accommodation_type' => AccommodationType::Bungalow,
                'latitude' => 20.2480000,
                'longitude' => 105.9310000,
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Bán đảo H., hồ nhân tạo (minh họa)',
                'price_hint' => '1.200.000đ – 2.000.000đ / căn / đêm',
                'contact_phone' => '0987 222 333',
                'description' => "Các căn bungalow độc lập hướng mặt nước, ban công riêng, BBQ ngoài trời theo yêu cầu.\n\nThích hợp nghỉ dưỡng ngắn ngày; có kayak và đạp xe quanh hồ.",
            ],
            [
                'name' => 'Nhà nghỉ Hoa Sen',
                'slug' => 'nha-nghi-hoa-sen',
                'accommodation_type' => AccommodationType::GuestHouse,
                'latitude' => 20.2758000,
                'longitude' => 105.9012000,
                'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                'address' => 'Chợ đêm khu du lịch (minh họa)',
                'price_hint' => '250.000đ – 450.000đ / phòng',
                'contact_phone' => '0918 000 111',
                'description' => "Nhà nghỉ gia đình, phòng sạch, điều hòa; gần chợ đêm và quán ăn.\n\nGiá mềm cho khách xuyên Việt và công tác ngắn ngày.",
            ],
        ];

        foreach ($rows as $row) {
            Accommodation::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'accommodation_type' => $row['accommodation_type'],
                    'description' => $row['description'],
                    'address' => $row['address'],
                    'latitude' => $row['latitude'] ?? null,
                    'longitude' => $row['longitude'] ?? null,
                    'price_hint' => $row['price_hint'],
                    'contact_phone' => $row['contact_phone'],
                    'image_url' => $row['image_url'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }

    private function seedTourSuggestions(): void
    {
        $rows = [
            [
                'title' => 'Tour di sản & làng cổ 2 ngày 1 đêm',
                'slug' => 'tour-di-san-lang-co-2n1d',
                'summary' => 'Kết nối đình làng, nhà lưu niệm và chợ phiên — phù hợp đoàn nhỏ và gia đình.',
                'duration_days' => 2,
                'highlights' => "Tham quan làng nghề truyền thống\nĂn trưa đặc sản địa phương\nTối nghỉ homestay hoặc khách sạn trung tâm\nSáng hôm sau ghé điểm di tích lân cận",
                'image_url' => 'https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?auto=format&fit=crop&w=1200&q=80',
                'body' => '<p><strong>Ngày 1:</strong> Tập trung tại điểm hẹn, tham quan khu di sản, trải nghiệm làm gốm / dệt (minh họa). Chiều tự do phố cổ, tối ẩm thực đường phố.</p><p><strong>Ngày 2:</strong> Thăm đền chùa hoặc bảo tàng địa phương, mua quà OCOP, kết thúc chương trình trưa.</p>',
            ],
            [
                'title' => 'Tour sinh thái & trekking trong ngày',
                'slug' => 'tour-sinh-thai-trekking-1-ngay',
                'summary' => 'Đi bộ đường mòn ngắn, picnic và ngắm cảnh — không cần qua đêm.',
                'duration_days' => 1,
                'highlights' => "08:00 khởi hành từ bãi đỗ xe khu du lịch\n10:00 trekking 3–4 km (độ khó nhẹ)\nTrưa picnic hoặc quán địa phương\nChiều về trước hoàng hôn",
                'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1200&q=80',
                'body' => '<p>Mang theo giày thể thao, nước uống và thuốc cá nhân. Hướng dẫn viên địa phương (tuỳ đơn vị lữ hành) có thể đi kèm.</p><p>Chương trình có thể kết hợp thuyền kayak hoặc thăm vườn quốc gia nếu mở cửa theo mùa.</p>',
            ],
            [
                'title' => 'Tour ẩm thực cuối tuần',
                'slug' => 'tour-am-thuc-cuoi-tuan',
                'summary' => 'Chợ sáng, quán bún chả, làng nghề làm bánh — trải nghiệm vị địa phương.',
                'duration_days' => 2,
                'highlights' => "Chợ phiên đặc sản buổi sớm\nQuán ăn được người dân giới thiệu\nThăm cơ sở OCOP (trà, mật ong…)\nTối chợ đêm / phố đi bộ (nếu có)",
                'image_url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80',
                'body' => '<p>Lịch linh hoạt theo mùa vụ nguyên liệu. Nên đặt trước nếu đoàn trên 10 người.</p>',
            ],
        ];

        foreach ($rows as $row) {
            TourSuggestion::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'summary' => $row['summary'],
                    'body' => $row['body'],
                    'duration_days' => $row['duration_days'],
                    'highlights' => $row['highlights'],
                    'image_url' => $row['image_url'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }

    private function seedLocalSpecialties(): void
    {
        $rows = [
            [
                'name' => 'Bún chả làng cổ',
                'slug' => 'bun-cha-lang-co',
                'category' => SpecialtyCategory::Food,
                'origin_hint' => 'Quán gia truyền khu phố cổ (minh họa)',
                'image_url' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?auto=format&fit=crop&w=1200&q=80',
                'description' => '<p>Thịt nướng than hoa, nước chấm chua ngọt, rau sống và bún tươi — món ăn đường phố quen thuộc, dễ tìm trong các cổng du lịch mục «Ăn uống» / «Đặc sản».</p><p><em>Gợi ý:</em> ăn nóng, kết hợp nem rán hoặc trà xanh địa phương.</p>',
            ],
            [
                'name' => 'Trà shan tuyết cổ thụ',
                'slug' => 'tra-shan-tuyet-co-thu',
                'category' => SpecialtyCategory::Beverage,
                'origin_hint' => 'Vùng cao Tây Bắc (minh họa xuất xứ)',
                'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=1200&q=80',
                'description' => '<p>Lá to, vị chát dịu, hậu ngọt — thường bán dạng khô hoặc quà tặng hộp giấy. Phù hợp làm quà sau chuyến đi.</p>',
            ],
            [
                'name' => 'Mật ong hoa rừng (OCOP 3 sao)',
                'slug' => 'mat-ong-hoa-rung-ocop',
                'category' => SpecialtyCategory::Ocop,
                'origin_hint' => 'Hợp tác xã OCOP địa phương (minh họa)',
                'image_url' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=1200&q=80',
                'description' => '<p>Sản phẩm OCOP gắn tem truy xuất; quy cách chai 500 ml / hộp quà. Tham khảo mô hình «Đặc sản» trên cổng tỉnh.</p>',
            ],
            [
                'name' => 'Làng nghề mộc mỹ nghệ',
                'slug' => 'lang-nghe-moc-my-nghe',
                'category' => SpecialtyCategory::Craft,
                'origin_hint' => 'Xã L., huyện T. (minh họa)',
                'image_url' => 'https://images.unsplash.com/photo-1452860606245-08befc0ff44b?auto=format&fit=crop&w=1200&q=80',
                'description' => '<p>Đồ gỗ thủ công, đồ lưu niệm — du khách có thể tham quan xưởng và mua trực tiếp. Một số hộ nhận đặt khắc chữ theo yêu cầu.</p>',
            ],
            [
                'name' => 'Nem chua Thanh Sơn',
                'slug' => 'nem-chua-thanh-son',
                'category' => SpecialtyCategory::Food,
                'origin_hint' => 'Đặc sản vùng miền núi (tên minh họa)',
                'image_url' => 'https://images.unsplash.com/photo-1529042410759-befb1204b468?auto=format&fit=crop&w=1200&q=80',
                'description' => '<p>Món lên men tự nhiên, ăn kèm tỏi, ớt và lá đinh lăng. Bảo quản lạnh khi mang xa.</p>',
            ],
        ];

        foreach ($rows as $row) {
            LocalSpecialty::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'name' => $row['name'],
                    'category' => $row['category'],
                    'description' => $row['description'],
                    'origin_hint' => $row['origin_hint'],
                    'image_url' => $row['image_url'],
                    'status' => PublicationStatus::Published,
                ],
            );
        }
    }
}
