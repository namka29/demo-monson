-- MySQL dump 10.13  Distrib 8.4.9, for Linux (aarch64)
--
-- Host: localhost    Database: tourist_web
-- ------------------------------------------------------
-- Server version	8.4.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accommodations`
--

DROP TABLE IF EXISTS `accommodations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accommodations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accommodation_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `description` text COLLATE utf8mb4_unicode_ci,
  `address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `price_hint` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accommodations_slug_unique` (`slug`),
  KEY `accommodations_accommodation_type_index` (`accommodation_type`),
  KEY `accommodations_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodations`
--

LOCK TABLES `accommodations` WRITE;
/*!40000 ALTER TABLE `accommodations` DISABLE KEYS */;
INSERT INTO `accommodations` VALUES (3,'Homestay Bản Mường — Nhà sàn view ruộng bậc thang','homestay-ban-muong','homestay','Phòng nhà sàn gỗ, view cánh đồng và đồi thông. Ăn sáng đặc sản địa phương, chủ nhà hỗ trợ book xe đưa đón.\n\nPhù hợp gia đình nhỏ và nhóm bạn; đặt trước vào cuối tuần và ngày lễ.','Thôn P., xã T. (minh họa) — cách trung tâm khoảng 8 km',NULL,NULL,'450.000đ – 850.000đ / đêm (2 người)','0912 345 678','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(4,'Khu nghỉ sinh thái Suối Khe','resort-suoi-khe','resort','Bungalow mái lá, hồ bơi nhỏ dành cho khách lưu trú, nhà hàng phục vụ đặc sản đồng quê.\n\nTrẻ em có khu vui chơi ngoài trời; xe đưa đón theo lịch cố định đến các điểm du lịch lân cận.','Xã V., ven suối — minh họa địa danh',NULL,NULL,'Từ 1.800.000đ / bungalow / đêm','0219 382 xxxx','https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(5,'Khách sạn Tràng An Central','khach-san-trang-an-central','hotel','Khách sạn 3 sao khu vực trung tâm: thuận tiện di chuyển, đỗ xe, wifi, phòng họp nhỏ cho đoàn.\n\nƯu đãi đoàn và booking dài ngày — liên hệ trực tiếp hotline.','Đường Hùng Vương, TT. (minh họa)',20.2895000,105.9100000,'800.000đ – 1.400.000đ / phòng đôi','0219 123 456','https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(6,'Bungalow Lake View','bungalow-lake-view','bungalow','Các căn bungalow độc lập hướng mặt nước, ban công riêng, BBQ ngoài trời theo yêu cầu.\n\nThích hợp nghỉ dưỡng ngắn ngày; có kayak và đạp xe quanh hồ.','Bán đảo H., hồ nhân tạo (minh họa)',20.2480000,105.9310000,'1.200.000đ – 2.000.000đ / căn / đêm','0987 222 333','https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(7,'Nhà nghỉ Hoa Sen','nha-nghi-hoa-sen','guest_house','Nhà nghỉ gia đình, phòng sạch, điều hòa; gần chợ đêm và quán ăn.\n\nGiá mềm cho khách xuyên Việt và công tác ngắn ngày.','Chợ đêm khu du lịch (minh họa)',20.2758000,105.9012000,'250.000đ – 450.000đ / phòng','0918 000 111','https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `accommodations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `destinations_slug_unique` (`slug`),
  KEY `destinations_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (1,'Khu lưu niệm Chủ tịch Hồ Chí Minh tại Kim Liên','khu-luu-niem-kim-lien','Làng Sen, xã Kim Liên — nơi lưu giữ kỷ vật và không gian gắn với thời thơ ấu của Chủ tịch Hồ Chí Minh. Điểm hành hương văn hóa quan trọng của tỉnh, thu hút du khách trong và ngoài nước.\n\nGợi ý: dành nửa ngày, kết hợp tham quan nhà lưu niệm, mộ bà Hoàng Thị Loan và không gian làng quê.','https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',18.6842000,105.5444000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(2,'Biển Cửa Lò','bien-cua-lo','Một trong những bãi biển nổi tiếng miền Trung với bãi cát dài, sóng hiền và hải sản tươi. Thích hợp nghỉ dưỡng, thể thao dưới nước và các lễ hội du lịch theo mùa.\n\nMùa cao điểm: hè; du khách nên đặt phòng trước khi lễ hội lớn.','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',18.7995000,105.7180000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(3,'Vườn quốc gia Pù Mát','vuon-quoc-gia-pu-mat','Rừng nguyên sinh, động — thực vật phong phú; điểm đến cho trekking, quan sát thiên nhiên và trải nghiệm văn hóa bản địa vùng Tây Nghệ An.\n\nDu khách tuân thủ quy định bảo vệ rừng và đi cùng hướng dẫn viên khi vào tuyến sâu.','https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80',19.0500000,104.8833000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(4,'Chùa Bảo Lâm','chua-bao-lam','Ngôi chùa cổ mang kiến trúc đặc trưng, không gian thanh tịnh — điểm dừng chân tâm linh và chiêm ngưỡng nghệ thuật tạo hình truyền thống.\n\nThích hợp tham quan buổi sáng; chú ý trang phục lịch sự khi vào khu thờ.','https://images.unsplash.com/photo-1545569341-9eb8b30979d9?auto=format&fit=crop&w=1200&q=80',18.7333000,105.6167000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(5,'Đảo chè Thanh Chương','dao-che-thanh-chuong','Cảnh quan đồi chè xanh mướt, đường đi bộ và góc chụp ảnh đẹp — trải nghiệm «check-in» và tìm hiểu văn hóa trồng chè địa phương.\n\nNên mang giày thể thao; một số khu thu phí tham quan theo quy định địa phương.','https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?auto=format&fit=crop&w=1200&q=80',18.7167000,105.4333000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(6,'Thành phố Vinh','thanh-pho-vinh','Trung tâm hành chính — kinh tế của tỉnh: ẩm thực đường phố, nơi nghỉ, kết nối giao thương và điểm trung chuyển tới các điểm du lịch lân cận.\n\nLưu ý giao thông giờ cao điểm; dùng bản đồ giao thông công cộng khi có.','https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&w=1200&q=80',18.6796000,105.6813000,'published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_slug_unique` (`slug`),
  KEY `events_starts_at_index` (`starts_at`),
  KEY `events_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Festival Du lịch Cửa Lò: Bốn mùa biển gọi','festival-du-lich-cua-lo-bon-mua-bien-goi','Lễ hội văn hóa — du lịch nhằm quảng bá hình ảnh biển Cửa Lò, giới thiệu tiềm năng du lịch và các hoạt động thể thao biển, ẩm thực địa phương.\n\n(Dữ liệu mẫu — thời gian có thể chỉnh trong admin.)','https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=1200&q=80','2026-04-25 08:00:00','2026-04-28 22:00:00','Phường Cửa Lò, tỉnh Nghệ An','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(2,'Lễ hội Đền Cuông','le-hoi-den-cuong','Lễ hội truyền thống gắn với không gian đền thờ và văn hóa cội nguồn; thu hút du khách thập phương về Hoan Châu.\n\n(Dữ liệu mẫu.)','https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80','2026-04-01 07:00:00','2026-04-04 21:00:00','Đền Cuông, xã An Châu','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(3,'Lễ hội làng Vạc','le-hoi-lang-vac','Hoạt động văn hóa cộng đồng với phần lễ trang nghiêm và phần hội sôi động — giữ gìn di sản địa phương.\n\n(Dữ liệu mẫu.)','https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=1200&q=80','2026-03-25 08:00:00','2026-03-27 22:00:00','Khu di chỉ khảo cổ học làng Vạc, phường Thái Hòa','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(4,'Lễ hội Đền Chín Gian','le-hoi-den-chin-gian','Di tích kiểu nhà sàn, gắn với văn hóa dân tộc Thái — trải nghiệm nghi lễ và ẩm thực miền Tây xứ Nghệ.\n\n(Dữ liệu mẫu.)','https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=1200&q=80','2026-04-01 09:00:00','2026-04-03 18:00:00','Đền Chín Gian, xã Quế Phong','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_banners`
--

DROP TABLE IF EXISTS `hero_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `image_disk_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` text COLLATE utf8mb4_unicode_ci,
  `video_disk_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_video_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_poster_url` text COLLATE utf8mb4_unicode_ci,
  `video_poster_disk_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_banners_media_type_index` (`media_type`),
  KEY `hero_banners_is_active_index` (`is_active`),
  KEY `hero_banners_sort_order_index` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_banners`
--

LOCK TABLES `hero_banners` WRITE;
/*!40000 ALTER TABLE `hero_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `hero_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_slideshow_settings`
--

DROP TABLE IF EXISTS `hero_slideshow_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_slideshow_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `autoplay_interval_ms` int unsigned NOT NULL DEFAULT '6500',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_slideshow_settings`
--

LOCK TABLES `hero_slideshow_settings` WRITE;
/*!40000 ALTER TABLE `hero_slideshow_settings` DISABLE KEYS */;
INSERT INTO `hero_slideshow_settings` VALUES (1,6500,'2026-05-04 13:26:13','2026-05-04 13:26:13');
/*!40000 ALTER TABLE `hero_slideshow_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `local_specialties`
--

DROP TABLE IF EXISTS `local_specialties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `local_specialties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `description` text COLLATE utf8mb4_unicode_ci,
  `origin_hint` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `local_specialties_slug_unique` (`slug`),
  KEY `local_specialties_category_index` (`category`),
  KEY `local_specialties_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `local_specialties`
--

LOCK TABLES `local_specialties` WRITE;
/*!40000 ALTER TABLE `local_specialties` DISABLE KEYS */;
INSERT INTO `local_specialties` VALUES (1,'Bún chả làng cổ','bun-cha-lang-co','food','<p>Thịt nướng than hoa, nước chấm chua ngọt, rau sống và bún tươi — món ăn đường phố quen thuộc, dễ tìm trong các cổng du lịch mục «Ăn uống» / «Đặc sản».</p><p><em>Gợi ý:</em> ăn nóng, kết hợp nem rán hoặc trà xanh địa phương.</p>','Quán gia truyền khu phố cổ (minh họa)','https://images.unsplash.com/photo-1559847844-5315695dadae?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(2,'Trà shan tuyết cổ thụ','tra-shan-tuyet-co-thu','beverage','<p>Lá to, vị chát dịu, hậu ngọt — thường bán dạng khô hoặc quà tặng hộp giấy. Phù hợp làm quà sau chuyến đi.</p>','Vùng cao Tây Bắc (minh họa xuất xứ)','https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(3,'Mật ong hoa rừng (OCOP 3 sao)','mat-ong-hoa-rung-ocop','ocop','<p>Sản phẩm OCOP gắn tem truy xuất; quy cách chai 500 ml / hộp quà. Tham khảo mô hình «Đặc sản» trên cổng tỉnh.</p>','Hợp tác xã OCOP địa phương (minh họa)','https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(4,'Làng nghề mộc mỹ nghệ','lang-nghe-moc-my-nghe','craft','<p>Đồ gỗ thủ công, đồ lưu niệm — du khách có thể tham quan xưởng và mua trực tiếp. Một số hộ nhận đặt khắc chữ theo yêu cầu.</p>','Xã L., huyện T. (minh họa)','https://images.unsplash.com/photo-1452860606245-08befc0ff44b?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(5,'Nem chua Thanh Sơn','nem-chua-thanh-son','food','<p>Món lên men tự nhiên, ăn kèm tỏi, ớt và lá đinh lăng. Bảo quản lạnh khi mang xa.</p>','Đặc sản vùng miền núi (tên minh họa)','https://images.unsplash.com/photo-1529042410759-befb1204b468?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `local_specialties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_03_120000_create_destinations_table',1),(5,'2026_05_03_120001_create_events_table',1),(6,'2026_05_03_120002_create_posts_table',1),(7,'2026_05_03_120003_create_pages_table',1),(8,'2026_05_03_130000_add_role_to_users_table',1),(9,'2026_05_03_140000_add_is_active_to_users_table',1),(10,'2026_05_03_160000_add_image_url_to_content_tables',1),(11,'2026_05_03_200000_create_hero_banners_table',1),(12,'2026_05_03_210000_add_sort_order_to_hero_banners_table',1),(13,'2026_05_03_210000_create_accommodations_tour_suggestions_local_specialties_tables',1),(14,'2026_05_03_220000_create_hero_slideshow_settings_table',1),(15,'2026_05_04_200000_add_latitude_longitude_to_accommodations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Giới thiệu','gioi-thieu','<p><strong>Đây là trang nội dung tĩnh mẫu</strong>, tham khảo bố cục cổng du lịch địa phương như <a href=\"https://visitnghean.gov.vn\" target=\"_blank\" rel=\"noopener noreferrer\">Khám phá Du lịch Nghệ An</a>. Nội dung mang tính minh họa cho hệ thống CMS của dự án.</p>\n<figure class=\"my-8\">\n  <img src=\"https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1400&q=80\" alt=\"Phong cảnh thiên nhiên\" width=\"1400\" height=\"788\" class=\"w-full rounded-2xl shadow-md\">\n  <figcaption class=\"mt-3 text-center text-sm text-stone-500\">Ảnh minh họa — Unsplash</figcaption>\n</figure>\n<h2>Vì sao du lịch bền vững?</h2>\n<p>Chúng tôi khuyến khích du khách sử dụng phương tiện công cộng khi có thể, giảm rác thải nhựa và tôn trọng văn hóa địa phương.</p>\n<ul>\n  <li>Bảo vệ di sản và cảnh quan</li>\n  <li>Hỗ trợ sản phẩm OCOP, làng nghề</li>\n  <li>Cập nhật tin tức và lịch sự kiện trên website</li>\n</ul>','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_published_at_index` (`published_at`),
  KEY `posts_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Top trải nghiệm ẩm thực Nghệ An nhất định phải thử','top-am-thuc-nghe-an','Từ cháo lươn, mướp đắng nhồi thịt đến hải sản Cửa Lò — gợi ý lịch ăn cho chuyến đi ngắn ngày.','https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80','<p>Nghệ An nổi tiếng với ẩm thực đậm đà, kết hợp hải sản miền biển và món quê truyền thống. Dưới đây là một số gợi ý (nội dung demo).</p>\n<figure class=\"my-6\">\n  <img src=\"https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1200&q=80\" alt=\"Món ăn địa phương\" width=\"1200\" height=\"675\" class=\"w-full rounded-xl shadow-sm\">\n  <figcaption class=\"mt-2 text-center text-sm text-stone-500\">Ảnh minh họa — Unsplash</figcaption>\n</figure>\n<p>Khi du lịch Cửa Lò, du khách có thể thử các món hải sản tươi theo mùa; tại Vinh và vùng lân cận, đừng bỏ qua đặc sản làm quà như nhút Thanh Chương (nếu có chương trình OCOP địa phương).</p>\n<p><strong>Lưu ý:</strong> Thực đơn thực tế và địa chỉ quán nên được ban quản trị cập nhật theo mùa và kiểm định ATTP.</p>','2026-05-01 10:00:00','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(2,'Gợi ý lịch trình 2 ngày 1 đêm: biển — làng Sen','lich-trinh-2-ngay-bien-lang-sen','Kết hợp nghỉ biển Cửa Lò và hành trình văn hóa tại Kim Liên.','https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1200&q=80','<p>Ngày 1: di chuyển tới Cửa Lò, nghỉ ngơi và tắm biển; chiều thưởng thức hải sản. Ngày 2: khởi hành sớm về Kim Liên, tham quan khu lưu niệm và trở về.</p>\n<figure class=\"my-6\">\n  <img src=\"https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80\" alt=\"Bữa ăn và không gian du lịch\" width=\"1200\" height=\"675\" class=\"w-full rounded-xl shadow-sm\">\n</figure>\n<p>Bài viết mang tính minh họa — điều chỉnh lịch theo phương tiện và mùa du lịch thực tế.</p>','2026-04-20 09:00:00','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(3,'Du lịch có trách nhiệm: gìn giữ di sản và môi trường','du-lich-co-trach-nhiem','Không xả rác tại khu di tích; tôn trọng nghi lễ tại đình, đền; ưu tiên dịch vụ địa phương.','https://images.unsplash.com/photo-1470071459604-04b01a3e0a89?auto=format&fit=crop&w=1200&q=80','<p>Cổng thông tin du lịch khuyến khích du khách hành xử văn minh: giữ trật tự, xếp hàng, không chạm vào hiện vật trưng bày và tuân theo hướng dẫn tại di tích.</p>\n<p>Tại khu bảo tồn thiên nhiên, không săn bắt, không thu thập mẫu thực vật — giúp bảo vệ hệ sinh thái cho thế hệ sau.</p>','2026-03-15 08:00:00','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('H4op30Y8X3J3GT25V5jqyAidxnPhGCIY31rAWiOB',1,'192.168.65.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoielF4NE02aG5uQlB4R0NCekhQU2tDZndxamNmMUt3eGt1NnkwMkV6MSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9hZG1pbi9hY2NvbW1vZGF0aW9ucyI7czo1OiJyb3V0ZSI7czo0NToiZmlsYW1lbnQuYWRtaW4ucmVzb3VyY2VzLmFjY29tbW9kYXRpb25zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6IjQ4ZDhiOTA3MjA3ZTliZDA1MTQwOGJjZjU4MDYwNTkyZTI5MDRmNjRhYWRlYmY5NzgzZTg4NTMwNWEyNDRiZjUiO3M6NjoidGFibGVzIjthOjM6e3M6NDA6IjQ1OTZjZGQ5NTgwYWU0NGM4MGUzOTlhMWY4NTBhMzVhX2NvbHVtbnMiO2E6NDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjExOiJUacOqdSDEkeG7gSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoic2x1ZyI7czo1OiJsYWJlbCI7czo0OiJTbHVnIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InN0YXR1cyI7czo1OiJsYWJlbCI7czoxMzoiVHLhuqFuZyB0aMOhaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTI6IkPhuq1wIG5o4bqtdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI1NGNhZjI3ZmMzYWRkOTI4YTdlZDRmOGI4MTNlZTY4Nl9jb2x1bW5zIjthOjY6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpbWFnZV91cmwiO3M6NToibGFiZWwiO3M6NToi4bqibmgiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToidGl0bGUiO3M6NToibGFiZWwiO3M6MTE6IlRpw6p1IMSR4buBIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJzdGFydHNfYXQiO3M6NToibGFiZWwiO3M6MTI6IkLhuq90IMSR4bqndSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6ODoibG9jYXRpb24iO3M6NToibGFiZWwiO3M6MTQ6IsSQ4buLYSDEkWnhu4NtIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InN0YXR1cyI7czo1OiJsYWJlbCI7czoxMzoiVHLhuqFuZyB0aMOhaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTI6IkPhuq1wIG5o4bqtdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI1YzYyNzFlNDg1OTg5ZDI5ZGNjYjc5ZGVlYzcyNTIwYV9jb2x1bW5zIjthOjY6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpbWFnZV91cmwiO3M6NToibGFiZWwiO3M6NToi4bqibmgiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtZSI7czo1OiJsYWJlbCI7czo0OiJUw6puIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxODoiYWNjb21tb2RhdGlvbl90eXBlIjtzOjU6ImxhYmVsIjtzOjY6Ikxv4bqhaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InByaWNlX2hpbnQiO3M6NToibGFiZWwiO3M6MTM6Ikdpw6EgZ+G7o2kgw70iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjowO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjEzOiJUcuG6oW5nIHRow6FpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMjoiQ+G6rXAgbmjhuq10IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fX19',1777901478),('p1GWd3R8JkNueO0lc3f9CiV6Y6Fyk6C9i9A4wgZw',NULL,'127.0.0.1','Symfony','YTozOntzOjY6Il90b2tlbiI7czo0MDoiczY0amc4UWJ3RERxck5vZnJwS2NBbGk4VE1HUjRtQzdFcmZCbHZSbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1777901173);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tour_suggestions`
--

DROP TABLE IF EXISTS `tour_suggestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tour_suggestions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `duration_days` tinyint unsigned DEFAULT NULL,
  `highlights` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tour_suggestions_slug_unique` (`slug`),
  KEY `tour_suggestions_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tour_suggestions`
--

LOCK TABLES `tour_suggestions` WRITE;
/*!40000 ALTER TABLE `tour_suggestions` DISABLE KEYS */;
INSERT INTO `tour_suggestions` VALUES (1,'Tour di sản & làng cổ 2 ngày 1 đêm','tour-di-san-lang-co-2n1d','Kết nối đình làng, nhà lưu niệm và chợ phiên — phù hợp đoàn nhỏ và gia đình.','<p><strong>Ngày 1:</strong> Tập trung tại điểm hẹn, tham quan khu di sản, trải nghiệm làm gốm / dệt (minh họa). Chiều tự do phố cổ, tối ẩm thực đường phố.</p><p><strong>Ngày 2:</strong> Thăm đền chùa hoặc bảo tàng địa phương, mua quà OCOP, kết thúc chương trình trưa.</p>',2,'Tham quan làng nghề truyền thống\nĂn trưa đặc sản địa phương\nTối nghỉ homestay hoặc khách sạn trung tâm\nSáng hôm sau ghé điểm di tích lân cận','https://images.unsplash.com/photo-1515542622106-78bda8ba0e5b?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(2,'Tour sinh thái & trekking trong ngày','tour-sinh-thai-trekking-1-ngay','Đi bộ đường mòn ngắn, picnic và ngắm cảnh — không cần qua đêm.','<p>Mang theo giày thể thao, nước uống và thuốc cá nhân. Hướng dẫn viên địa phương (tuỳ đơn vị lữ hành) có thể đi kèm.</p><p>Chương trình có thể kết hợp thuyền kayak hoặc thăm vườn quốc gia nếu mở cửa theo mùa.</p>',1,'08:00 khởi hành từ bãi đỗ xe khu du lịch\n10:00 trekking 3–4 km (độ khó nhẹ)\nTrưa picnic hoặc quán địa phương\nChiều về trước hoàng hôn','https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12'),(3,'Tour ẩm thực cuối tuần','tour-am-thuc-cuoi-tuan','Chợ sáng, quán bún chả, làng nghề làm bánh — trải nghiệm vị địa phương.','<p>Lịch linh hoạt theo mùa vụ nguyên liệu. Nên đặt trước nếu đoàn trên 10 người.</p>',2,'Chợ phiên đặc sản buổi sớm\nQuán ăn được người dân giới thiệu\nThăm cơ sở OCOP (trà, mật ong…)\nTối chợ đêm / phố đi bộ (nếu có)','https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80','published','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `tour_suggestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'editor',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com',NULL,'$2y$12$OBZ9eO4ibignxM.4n6vpQ.7qjCFXmXSBFAXNWZ3ol3OY0f5ZdBqDq','admin',1,'w1efUqIbum6sbVs1uxeXJZ42DdJfmhT8M590gfTwVketd7pqDJFwsJ8OYcE6','2026-05-04 13:30:12','2026-05-04 13:30:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-04 13:34:33
