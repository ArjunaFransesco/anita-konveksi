/*
SQLyog Community v13.1.3  (64 bit)
MySQL - 8.4.3 : Database - anita_konveksi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`nama`,`no_hp`,`alamat`,`created_at`,`updated_at`) values 
(2,'Budi Santoso','081311110001','Jl. Pahlawan No. 5, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(3,'Sari Dewi','081311110002','Jl. Diponegoro No. 12, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(4,'Ahmad Fauzi','081311110003','Jl. Sudirman No. 7, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(5,'Hendra Kurniawan','081311110004','Jl. Imam Bonjol No. 3, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(6,'Eka Prasetya','081311110005','Jl. A. Yani No. 21, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(7,'Yunita Rahayu','081311110006','Jl. Gatot Subroto No. 9, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(8,'Rizal Maulana','081311110007','Jl. Soekarno Hatta No. 15, Madiun','2026-06-12 20:25:51','2026-06-12 20:25:51'),
(9,'Imron jazuli','085755783203','DS. GEBANGKEREP','2026-06-15 13:08:41','2026-06-15 13:08:41'),
(10,'Akfa','081234569870','Semen','2026-06-15 14:14:01','2026-06-15 14:14:01'),
(26,'Budi Santoso','081242155150','Jl. Merdeka No. 81, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(27,'Siti Aminah','081297139219','Jl. Merdeka No. 5, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(28,'Joko Widodo','081268846464','Jl. Merdeka No. 10, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(29,'Rina Sari','081260659962','Jl. Merdeka No. 72, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(30,'Agus Setiawan','081252307021','Jl. Merdeka No. 35, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(31,'Dewi Lestari','081283515475','Jl. Merdeka No. 55, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(32,'Wahyu Hidayat','081222367812','Jl. Merdeka No. 66, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(33,'Sri Rahayu','081231780331','Jl. Merdeka No. 59, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(34,'Hendra Gunawan','081259378732','Jl. Merdeka No. 12, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(35,'Fitriani','081284309687','Jl. Merdeka No. 97, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(36,'Andi Pratama','081253852681','Jl. Merdeka No. 32, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(37,'Nurul Huda','081295558064','Jl. Merdeka No. 10, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(38,'Eko Saputro','081220193766','Jl. Merdeka No. 78, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(39,'Dian Sastrowardoyo','081274413887','Jl. Merdeka No. 9, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31'),
(40,'Bambang Pamungkas','081240435189','Jl. Merdeka No. 82, Jakarta','2026-06-15 17:20:31','2026-06-15 17:20:31');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_type` enum('harian','borongan','mingguan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'harian',
  `salary_rate` decimal(12,2) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `join_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

insert  into `employees`(`id`,`name`,`position`,`employee_type`,`salary_rate`,`phone`,`address`,`join_date`,`is_active`,`created_at`,`updated_at`) values 
(1,'Jilly Pinta Ade','Penjahit','mingguan',60000.00,'085413697','Santren',NULL,0,'2026-06-12 13:17:05','2026-06-15 17:11:57'),
(2,'Siti Rahayu','Penjahit','harian',85000.00,'081234567001','Jl. Mawar No. 12, Madiun','2023-01-10',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(3,'Nur Aini','Penjahit','borongan',4500.00,'081234567002','Jl. Melati No. 5, Madiun','2023-02-15',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(4,'Dewi Setyowati','Operator Sablon','harian',90000.00,'081234567003','Jl. Anggrek No. 8, Madiun','2023-03-01',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(5,'Rina Agustina','Quality Control','harian',80000.00,'081234567004','Jl. Dahlia No. 3, Madiun','2023-04-20',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(6,'Sri Wahyuni','Penjahit','borongan',4500.00,'081234567005','Jl. Kenanga No. 17, Madiun','2023-05-05',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(7,'Fitria Handayani','Pemotong Kain','harian',85000.00,'081234567006','Jl. Flamboyan No. 22, Madiun','2023-06-10',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(8,'Yuliana Putri','Penjahit','harian',85000.00,'081234567007','Jl. Cempaka No. 9, Madiun','2023-07-15',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(9,'Endang Sulistyowati','Operator Bordir','mingguan',550000.00,'081234567008','Jl. Tulip No. 4, Madiun','2023-08-01',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(10,'Marlina Sari','Penjahit','borongan',4500.00,'081234567009','Jl. Bougenville No. 11, Madiun','2023-09-20',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(11,'Wulandari','Quality Control','harian',80000.00,'081234567010','Jl. Seruni No. 6, Madiun','2023-10-05',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(12,'Ani Kusumawati','Pemotong Kain','harian',85000.00,'081234567011','Jl. Teratai No. 30, Madiun','2023-11-10',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(13,'Riska Amelia','Penjahit','borongan',4500.00,'081234567012','Jl. Kamboja No. 14, Madiun','2023-12-01',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(14,'Lestari Ningrum','Operator Sablon','mingguan',550000.00,'081234567013','Jl. Kantil No. 7, Madiun','2024-01-15',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(15,'Mardiana','Administrasi','harian',95000.00,'081234567014','Jl. Lavender No. 19, Madiun','2024-02-01',1,'2026-06-12 20:20:26','2026-06-12 20:20:26'),
(17,'Rini Maharaja','Sablon','mingguan',70000.00,'08512345678','Jombang',NULL,1,'2026-06-15 13:53:34','2026-06-15 13:54:42');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

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

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

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

/*Data for the table `jobs` */

/*Table structure for table `katalogs` */

DROP TABLE IF EXISTS `katalogs`;

CREATE TABLE `katalogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar_list` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `katalogs_kategori_unique` (`kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `katalogs` */

insert  into `katalogs`(`id`,`kategori`,`judul`,`deskripsi`,`gambar_list`,`created_at`,`updated_at`) values 
(1,'seragam-sekolah','Seragam Sekolah','Kualitas terbaik dari Anita Konveksi untuk Seragam Sekolah','[\"images/portofolio/seragam-sekolah/1.jpg\", \"images/portofolio/seragam-sekolah/2.jpg\", \"images/portofolio/seragam-sekolah/3.jpg\", \"images/portofolio/seragam-sekolah/4.jpg\", \"images/portofolio/seragam-sekolah/5.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(2,'seragam-kantor','Seragam Kantor','Kualitas terbaik dari Anita Konveksi untuk Seragam Kantor','[\"images/portofolio/seragam-kantor/1.jpg\", \"images/portofolio/seragam-kantor/2.jpg\", \"images/portofolio/seragam-kantor/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(3,'seragam-drumband','Seragam Drumband','Kualitas terbaik dari Anita Konveksi untuk Seragam Drumband','[\"images/portofolio/seragam-drumband/1.jpg\", \"images/portofolio/seragam-drumband/2.jpg\", \"images/portofolio/seragam-drumband/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(4,'jas-almamater','Jas Almamater','Kualitas terbaik dari Anita Konveksi untuk Jas Almamater','[\"images/portofolio/jas-almamater/1.jpg\", \"images/portofolio/jas-almamater/2.jpg\", \"images/portofolio/jas-almamater/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(5,'umbul-umbul','Umbul Umbul','Kualitas terbaik dari Anita Konveksi untuk Umbul Umbul','[\"images/portofolio/umbul-umbul/1.jpg\", \"images/portofolio/umbul-umbul/2.jpg\", \"images/portofolio/umbul-umbul/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(6,'topi','Topi','Kualitas terbaik dari Anita Konveksi untuk Topi','[\"images/portofolio/topi/1.jpg\", \"images/portofolio/topi/2.jpg\", \"images/portofolio/topi/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(7,'jaket','Jaket','Kualitas terbaik dari Anita Konveksi untuk Jaket','[\"images/portofolio/jaket/1.jpg\", \"katalog_images/WhatsApp Image 2026-06-15 at 23.42.36.jpeg\", \"katalog_images/WhatsApp Image 2026-06-15 at 23.42.37.jpeg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(8,'pdl','Pdl','Kualitas terbaik dari Anita Konveksi untuk Pdl','[\"images/portofolio/pdl/1.jpg\", \"images/portofolio/pdl/2.jpg\", \"images/portofolio/pdl/3.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28'),
(9,'dll','Dll','Kualitas terbaik dari Anita Konveksi','[\"images/portofolio/dll/1.jpg\", \"images/portofolio/dll/2.jpg\", \"images/portofolio/dll/3.jpg\", \"images/portofolio/dll/4.jpg\"]','2026-06-15 17:50:28','2026-06-15 17:50:28');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_04_07_120258_create_users_table',1),
(5,'2026_04_07_124642_create_employees_table',1),
(6,'2026_04_14_000001_create_customers_table',1),
(7,'2026_04_14_000002_create_orders_table',1),
(8,'2026_04_14_000003_create_order_details_table',1),
(9,'2026_04_14_000004_create_payments_table',1),
(10,'2026_05_05_142227_create_sizes_table',1),
(11,'2026_05_05_142237_add_logo_and_size_to_order_details_table',1),
(12,'2026_05_05_143233_add_diskon_to_orders_table',1),
(13,'2026_05_05_144242_add_diskon_columns_to_orders_table',1),
(14,'2026_05_05_144321_create_sizes_table',1),
(15,'2026_05_05_144352_add_logo_size_columns_to_order_details_table',1),
(16,'2026_05_16_042803_create_pengeluarans_table',1),
(18,'2026_05_18_000001_create_order_detail_logos_table',1),
(19,'2026_05_29_000001_add_foto_nota_to_pengeluarans_table',1),
(20,'2026_05_29_000002_create_order_hasil_fotos_table',1),
(21,'2026_05_16_044831_create_penggajians_table',2),
(22,'2026_06_15_141918_change_file_columns_to_text',3),
(23,'2026_06_15_174701_create_katalogs_table',4);

/*Table structure for table `order_detail_logos` */

DROP TABLE IF EXISTS `order_detail_logos`;

CREATE TABLE `order_detail_logos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_detail_id` bigint unsigned NOT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_desain` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_detail_logos_order_detail_id_foreign` (`order_detail_id`),
  CONSTRAINT `order_detail_logos_order_detail_id_foreign` FOREIGN KEY (`order_detail_id`) REFERENCES `order_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `order_detail_logos` */

insert  into `order_detail_logos`(`id`,`order_detail_id`,`logo_path`,`keterangan_desain`,`created_at`,`updated_at`) values 
(2,9,'order_logos/6a2ff959747738.09576442_1781528921.jpg','didepan kiri','2026-06-15 13:08:41','2026-06-15 13:08:41'),
(3,9,'order_logos/6a2ff95974dde4.06258945_1781528921.png','didepan','2026-06-15 13:08:41','2026-06-15 13:08:41'),
(4,10,NULL,'Di kiri dada','2026-06-15 14:14:01','2026-06-15 14:14:01'),
(5,11,'order_logos/6a30293dcd8bf9.33624469_1781541181.jpg','Di kiri dada','2026-06-15 16:33:01','2026-06-15 16:33:01'),
(6,12,'order_logos/6a30293dcdcde0.20727681_1781541181.jpg','Di kiri dada','2026-06-15 16:33:01','2026-06-15 16:33:01');

/*Table structure for table `order_details` */

DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `jenis_produk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `ukuran` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bahan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desain` text COLLATE utf8mb4_unicode_ci,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `size_custom` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_satuan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_details_order_id_foreign` (`order_id`),
  KEY `order_details_size_id_foreign` (`size_id`),
  CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `order_details` */

insert  into `order_details`(`id`,`order_id`,`jenis_produk`,`jumlah`,`ukuran`,`bahan`,`warna`,`desain`,`logo_path`,`size_id`,`size_custom`,`harga_satuan`,`subtotal`,`created_at`,`updated_at`) values 
(2,2,'Seragam Sekolah SD',10,'M','Drill','Putih','Bordir nama sekolah di dada kiri',NULL,NULL,NULL,150000.00,1500000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(3,3,'Seragam Kantor',12,'L','Tropical','Biru Navy','Sablon logo perusahaan di punggung',NULL,NULL,NULL,200000.00,2400000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(4,4,'Jaket Komunitas',16,'XL','Fleece','Hitam','Bordir nama komunitas depan dan belakang',NULL,NULL,NULL,200000.00,3200000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(5,5,'PDL',12,'L','Ripstop','Army Green','Sablon nama instansi di dada kanan',NULL,NULL,NULL,150000.00,1800000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(6,6,'Jas Almamater',15,'M','Balatex','Biru Royal','Bordir logo universitas di dada kiri',NULL,NULL,NULL,300000.00,4500000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(7,7,'Seragam Drumband',9,'M','Satin','Merah Marun','Sablon motif drumband full front',NULL,NULL,NULL,300000.00,2700000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(8,8,'Topi Custom',35,'-','Drill','Hitam','Bordir nama event di bagian depan',NULL,NULL,NULL,100000.00,3500000.00,'2026-06-12 20:26:05','2026-06-12 20:26:05'),
(9,9,'Seragam Kantor',30,NULL,'Cuton','Hitam merah','didepan kiri','order_logos/6a2ff959747738.09576442_1781528921.jpg',3,NULL,115000.00,3450000.00,'2026-06-15 13:08:41','2026-06-15 13:08:41'),
(10,10,'PDL',10,NULL,'Katun','Hitam','Di kiri dada',NULL,2,NULL,100000.00,1000000.00,'2026-06-15 14:14:01','2026-06-15 14:14:01'),
(11,11,'PDL',10,NULL,'Katun','Hitam','Di kiri dada','order_logos/6a30293dcd8bf9.33624469_1781541181.jpg',5,NULL,100000.00,1000000.00,'2026-06-15 16:33:01','2026-06-15 16:33:01'),
(12,11,'PDL',10,NULL,'Katun','Hitam','Di kiri dada','order_logos/6a30293dcdcde0.20727681_1781541181.jpg',1,NULL,100000.00,1000000.00,'2026-06-15 16:33:01','2026-06-15 16:33:01'),
(180,112,'Seragam Olahraga',47,'XXL','Combed 30s','Merah',NULL,NULL,NULL,NULL,118000.00,5546000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(181,112,'Topi Trucker',16,'L','Taslan','Putih',NULL,NULL,NULL,NULL,29000.00,464000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(182,112,'Jaket Bomber',24,'S','Kanvas 10oz','Navy','Saku Depan','acak_images/1110981801842926322.jpg',NULL,NULL,107000.00,2568000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(183,113,'Kemeja PDH',38,'M','American Drill','Merah','Topi Depan','acak_images/398568635787196334.jpg',NULL,NULL,37000.00,1406000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(184,114,'Topi Trucker',41,'M','Lotto','Hitam','Lengan Kanan','acak_images/WhatsApp Image 2026-06-16 at 00.28.05.jpeg',NULL,NULL,110000.00,4510000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(185,114,'Kemeja PDH',50,'XXL','Combed 30s','Navy','Lengan Kanan','acak_images/1110981801842926322.jpg',NULL,NULL,65000.00,3250000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(186,115,'Totebag Kanvas',48,'XXL','American Drill','Navy','Samping Totebag','acak_images/1085719422747587095.jpg',NULL,NULL,44000.00,2112000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(187,116,'Seragam Olahraga',50,'XL','Taslan','Abu-abu','Punggung Tengah','acak_images/Soy_ on TikTok.jpg',NULL,NULL,99000.00,4950000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(188,117,'Topi Trucker',43,'L','American Drill','Abu-abu','Lengan Kiri','acak_images/WhatsApp Image 2026-06-16 at 00.28.05 (4).jpeg',NULL,NULL,39000.00,1677000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(189,117,'Topi Trucker',38,'M','Combed 30s','Navy',NULL,NULL,NULL,NULL,112000.00,4256000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(190,117,'Totebag Kanvas',30,'XL','Taslan','Navy','Lengan Kanan','acak_images/650699846185929769.jpg',NULL,NULL,56000.00,1680000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(191,118,'Jaket Bomber',31,'L','Combed 30s','Merah',NULL,NULL,NULL,NULL,32000.00,992000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(192,119,'Jaket Bomber',14,'S','Taslan','Putih','Topi Depan','acak_images/cat.jpg',NULL,NULL,91000.00,1274000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(193,119,'Jaket Bomber',38,'XXL','Rafel','Abu-abu','Saku Depan','acak_images/cat.jpg',NULL,NULL,120000.00,4560000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(194,119,'Jaket Bomber',34,'XXL','Lotto','Hitam',NULL,NULL,NULL,NULL,96000.00,3264000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(195,120,'Seragam Olahraga',14,'XXL','Taslan','Abu-abu','Tengkuk Leher','acak_images/904449537681472444.jpg',NULL,NULL,46000.00,644000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(196,120,'Topi Trucker',35,'XXL','Rafel','Putih','Lengan Kanan','acak_images/WhatsApp Image 2026-06-16 at 00.28.05 (4).jpeg',NULL,NULL,76000.00,2660000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(197,121,'Seragam Olahraga',33,'L','Taslan','Merah','Dada Kanan','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg',NULL,NULL,120000.00,3960000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(198,121,'Totebag Kanvas',28,'XL','Taslan','Navy',NULL,NULL,NULL,NULL,92000.00,2576000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(199,122,'Jaket Bomber',11,'XXL','Taslan','Navy','Lengan Kanan','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg',NULL,NULL,28000.00,308000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(200,122,'Kemeja PDH',28,'L','Taslan','Abu-abu','Tengkuk Leher','acak_images/1008736016545216215.jpg',NULL,NULL,100000.00,2800000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(201,122,'Seragam Olahraga',12,'XL','Combed 30s','Navy','Lengan Kanan','acak_images/785174516295481903.jpg',NULL,NULL,86000.00,1032000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(202,123,'Totebag Kanvas',30,'S','American Drill','Navy','Lengan Kanan','acak_images/WhatsApp Image 2026-06-16 at 00.28.06.jpeg',NULL,NULL,37000.00,1110000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(203,123,'Kaos Polo',39,'S','Kanvas 10oz','Abu-abu','Lengan Kiri','acak_images/1110981801842926322.jpg',NULL,NULL,104000.00,4056000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(204,123,'Kaos Polo',35,'XL','Kanvas 10oz','Hitam','Samping Totebag','acak_images/cat.jpg',NULL,NULL,82000.00,2870000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(205,124,'Totebag Kanvas',37,'M','Lotto','Hitam','Topi Depan','acak_images/1110981801842926322.jpg',NULL,NULL,112000.00,4144000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(206,124,'Seragam Olahraga',14,'S','Lotto','Merah','Dada Kanan','acak_images/942096815806868372.jpg',NULL,NULL,33000.00,462000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(207,124,'Jaket Bomber',39,'S','Rafel','Navy','Samping Totebag','acak_images/cat.jpg',NULL,NULL,71000.00,2769000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(208,125,'Totebag Kanvas',24,'L','Rafel','Merah','Punggung Tengah','acak_images/1110629958096079539.jpg',NULL,NULL,93000.00,2232000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(209,125,'Kemeja PDH',17,'XXL','Lotto','Merah','Topi Depan','acak_images/299630181479731482.jpg',NULL,NULL,42000.00,714000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(210,126,'Seragam Olahraga',31,'L','Rafel','Hitam','Dada Kanan','acak_images/398568635787196334.jpg',NULL,NULL,113000.00,3503000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(211,126,'Kemeja PDH',30,'L','Rafel','Merah','Saku Depan','acak_images/1110629958096079539.jpg',NULL,NULL,28000.00,840000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(212,126,'Seragam Olahraga',12,'S','Combed 30s','Putih',NULL,NULL,NULL,NULL,43000.00,516000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(213,127,'Kemeja PDH',39,'S','Rafel','Merah','Dada Kanan','acak_images/890023945133409776.jpg',NULL,NULL,38000.00,1482000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(214,127,'Kemeja PDH',47,'S','Kanvas 10oz','Hitam','Lengan Kanan','acak_images/Sherilyn jaimes Mendoza.jpg',NULL,NULL,58000.00,2726000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(215,128,'Kaos Polo',49,'S','Lotto','Abu-abu','Lengan Kiri','acak_images/WhatsApp Image 2026-06-16 at 00.28.05 (2).jpeg',NULL,NULL,81000.00,3969000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(216,128,'Seragam Olahraga',26,'XXL','Kanvas 10oz','Hitam','Tengkuk Leher','acak_images/650699846185929769.jpg',NULL,NULL,110000.00,2860000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(217,129,'Topi Trucker',24,'S','Taslan','Putih','Samping Totebag','acak_images/1110629958096079539.jpg',NULL,NULL,115000.00,2760000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(218,130,'Totebag Kanvas',37,'S','Kanvas 10oz','Putih','Punggung Tengah','acak_images/WhatsApp Image 2026-06-16 at 00.28.05.jpeg',NULL,NULL,35000.00,1295000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(219,131,'Kaos Polo',23,'S','Combed 30s','Putih','Topi Depan','acak_images/1035546508044250549.jpg',NULL,NULL,106000.00,2438000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(220,132,'Jaket Bomber',24,'M','Lotto','Navy',NULL,NULL,NULL,NULL,86000.00,2064000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(221,132,'Totebag Kanvas',49,'L','Kanvas 10oz','Putih','Saku Depan','acak_images/785174516295481903.jpg',NULL,NULL,112000.00,5488000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(222,132,'Jaket Bomber',28,'XL','Kanvas 10oz','Hitam','Dada Kanan','acak_images/1035546508044250549.jpg',NULL,NULL,66000.00,1848000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(223,133,'Kemeja PDH',36,'M','Kanvas 10oz','Abu-abu','Lengan Kiri','acak_images/837880705691801263.jpg',NULL,NULL,34000.00,1224000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(224,133,'Kaos Polo',38,'M','Kanvas 10oz','Abu-abu','Dada Kiri','acak_images/890023945133409776.jpg',NULL,NULL,26000.00,988000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(225,133,'Jaket Bomber',45,'XL','American Drill','Abu-abu','Samping Totebag','acak_images/cat.jpg',NULL,NULL,92000.00,4140000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(226,134,'Jaket Bomber',21,'M','Kanvas 10oz','Abu-abu','Saku Depan','acak_images/☆ on TikTok.jpg',NULL,NULL,60000.00,1260000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(227,134,'Jaket Bomber',19,'M','Taslan','Navy','Saku Depan','acak_images/1008736016545216215.jpg',NULL,NULL,93000.00,1767000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(228,134,'Kemeja PDH',42,'XXL','Rafel','Abu-abu','Lengan Kiri','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg',NULL,NULL,65000.00,2730000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(229,135,'Totebag Kanvas',13,'XXL','Lotto','Navy','Lengan Kanan','acak_images/☆ on TikTok.jpg',NULL,NULL,116000.00,1508000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(230,136,'Jaket Bomber',13,'L','Taslan','Putih','Lengan Kanan','acak_images/download (2).jpg',NULL,NULL,28000.00,364000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(231,136,'Jaket Bomber',24,'XXL','American Drill','Abu-abu','Saku Depan','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg',NULL,NULL,57000.00,1368000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(232,137,'Totebag Kanvas',33,'L','American Drill','Putih','Punggung Tengah','acak_images/WhatsApp Image 2026-06-16 at 00.28.05 (3).jpeg',NULL,NULL,81000.00,2673000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(233,137,'Kemeja PDH',15,'M','Taslan','Abu-abu','Dada Kiri','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg',NULL,NULL,117000.00,1755000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(234,138,'Kaos Polo',42,'XL','Combed 30s','Navy',NULL,NULL,NULL,NULL,76000.00,3192000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(235,138,'Kaos Polo',30,'L','American Drill','Abu-abu','Samping Totebag','acak_images/1110981801842926322.jpg',NULL,NULL,105000.00,3150000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(236,139,'Kaos Polo',34,'S','Lotto','Hitam','Topi Depan','acak_images/cat.jpg',NULL,NULL,117000.00,3978000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(237,140,'Topi Trucker',37,'XL','American Drill','Merah','Topi Depan','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg',NULL,NULL,71000.00,2627000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(238,140,'Totebag Kanvas',19,'M','Lotto','Merah','Punggung Tengah','acak_images/WhatsApp Image 2026-06-16 at 00.28.05 (1).jpeg',NULL,NULL,47000.00,893000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(239,140,'Jaket Bomber',41,'XL','Taslan','Putih','Punggung Tengah','acak_images/890023945133409776.jpg',NULL,NULL,78000.00,3198000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(240,141,'Kemeja PDH',47,'M','Kanvas 10oz','Navy','Dada Kanan','acak_images/1035546508044250549.jpg',NULL,NULL,55000.00,2585000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(241,141,'Seragam Olahraga',27,'S','Combed 30s','Navy','Samping Totebag','acak_images/WhatsApp Image 2026-06-16 at 00.28.06 (1).jpeg',NULL,NULL,70000.00,1890000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(242,141,'Topi Trucker',30,'L','American Drill','Navy','Tengkuk Leher','acak_images/WhatsApp Image 2026-06-16 at 00.28.06 (1).jpeg',NULL,NULL,64000.00,1920000.00,'2026-06-15 17:40:00','2026-06-15 17:40:00');

/*Table structure for table `order_hasil_fotos` */

DROP TABLE IF EXISTS `order_hasil_fotos`;

CREATE TABLE `order_hasil_fotos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `foto_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_hasil_fotos_order_id_foreign` (`order_id`),
  CONSTRAINT `order_hasil_fotos_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `order_hasil_fotos` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `total_harga` decimal(15,2) NOT NULL DEFAULT '0.00',
  `diskon_jenis` enum('persen','nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'persen',
  `diskon_tipe` enum('none','persen','nominal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `diskon_persen` decimal(5,2) NOT NULL DEFAULT '0.00',
  `diskon_nominal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_setelah_diskon` decimal(15,2) NOT NULL DEFAULT '0.00',
  `dp` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sisa_tagihan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status_produksi` enum('nunggu_konfirmasi','menunggu_bahan','proses_potong','proses_jahit','proses_sablon_bordir','quality_control','siap_diambil','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nunggu_konfirmasi',
  `status_pembayaran` enum('belum','lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_invoice_number_unique` (`invoice_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_status_produksi_index` (`status_produksi`),
  KEY `orders_status_pembayaran_index` (`status_pembayaran`),
  KEY `orders_tanggal_pesan_index` (`tanggal_pesan`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`invoice_number`,`customer_id`,`tanggal_pesan`,`deadline`,`total_harga`,`diskon_jenis`,`diskon_tipe`,`diskon_persen`,`diskon_nominal`,`total_setelah_diskon`,`dp`,`sisa_tagihan`,`status_produksi`,`status_pembayaran`,`created_at`,`updated_at`) values 
(2,'INV-2026-0001',2,'2026-05-01','2026-05-20',1500000.00,'persen','none',0.00,0.00,1500000.00,750000.00,750000.00,'menunggu_bahan','belum','2026-06-12 20:25:59','2026-06-12 13:29:09'),
(3,'INV-2026-0002',3,'2026-05-05','2026-05-25',2400000.00,'persen','persen',10.00,0.00,2160000.00,1000000.00,1160000.00,'menunggu_bahan','belum','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(4,'INV-2026-0003',4,'2026-05-08','2026-05-28',3200000.00,'persen','nominal',0.00,200000.00,3000000.00,1500000.00,1500000.00,'proses_potong','belum','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(5,'INV-2026-0004',5,'2026-05-10','2026-06-01',1800000.00,'persen','none',0.00,0.00,1800000.00,900000.00,900000.00,'proses_jahit','belum','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(6,'INV-2026-0005',6,'2026-05-12','2026-06-05',4500000.00,'persen','persen',5.00,0.00,4275000.00,4275000.00,0.00,'proses_sablon_bordir','lunas','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(7,'INV-2026-0006',7,'2026-05-15','2026-06-08',2700000.00,'persen','none',0.00,0.00,2700000.00,2700000.00,0.00,'quality_control','lunas','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(8,'INV-2026-0007',8,'2026-05-18','2026-06-10',3600000.00,'persen','nominal',0.00,100000.00,3500000.00,3500000.00,0.00,'selesai','lunas','2026-06-12 20:25:59','2026-06-12 20:25:59'),
(9,'INV-2026-008',9,'2026-06-15','2026-04-01',3450000.00,'persen','none',5.00,0.00,3277500.00,1000000.00,2277500.00,'selesai','belum','2026-06-15 13:08:41','2026-06-15 14:02:47'),
(10,'INV-2026-009',10,'2026-06-15','2026-05-31',1000000.00,'persen','none',0.00,0.00,1000000.00,500000.00,500000.00,'nunggu_konfirmasi','belum','2026-06-15 14:14:01','2026-06-15 14:14:01'),
(11,'INV-2026-010',10,'2026-06-15','2026-05-31',2000000.00,'nominal','nominal',5.00,100000.00,1900000.00,1100000.00,0.00,'nunggu_konfirmasi','lunas','2026-06-15 16:33:01','2026-06-15 16:46:14'),
(112,'INV-2026-011',2,'2026-04-22','2026-06-30',8578000.00,'persen','none',0.00,0.00,8578000.00,8578000.00,0.00,'proses_jahit','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(113,'INV-2026-012',2,'2026-06-03','2026-06-24',1406000.00,'persen','none',0.00,0.00,1406000.00,1406000.00,0.00,'quality_control','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(114,'INV-2026-013',27,'2026-06-01','2026-06-16',7760000.00,'persen','none',0.00,0.00,7760000.00,0.00,7760000.00,'menunggu_bahan','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(115,'INV-2026-014',27,'2026-05-24','2026-07-02',2112000.00,'persen','none',0.00,0.00,2112000.00,2112000.00,0.00,'proses_jahit','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(116,'INV-2026-015',28,'2026-05-31','2026-06-20',4950000.00,'persen','none',0.00,0.00,4950000.00,4950000.00,0.00,'quality_control','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(117,'INV-2026-016',28,'2026-06-10','2026-07-02',7613000.00,'persen','none',0.00,0.00,7613000.00,7613000.00,0.00,'nunggu_konfirmasi','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(118,'INV-2026-017',29,'2026-05-26','2026-06-27',992000.00,'persen','none',0.00,0.00,992000.00,337280.00,654720.00,'quality_control','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(119,'INV-2026-018',29,'2026-05-13','2026-06-21',9098000.00,'persen','none',0.00,0.00,9098000.00,9098000.00,0.00,'proses_jahit','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(120,'INV-2026-019',30,'2026-04-20','2026-06-30',3304000.00,'persen','none',0.00,0.00,3304000.00,3304000.00,0.00,'menunggu_bahan','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(121,'INV-2026-020',30,'2026-05-31','2026-06-21',6536000.00,'persen','none',0.00,0.00,6536000.00,2941200.00,3594800.00,'nunggu_konfirmasi','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(122,'INV-2026-021',31,'2026-06-09','2026-07-03',4140000.00,'persen','none',0.00,0.00,4140000.00,2318400.00,1821600.00,'quality_control','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(123,'INV-2026-022',31,'2026-05-18','2026-06-23',8036000.00,'persen','none',0.00,0.00,8036000.00,5384120.00,2651880.00,'quality_control','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(124,'INV-2026-023',32,'2026-06-02','2026-06-22',7375000.00,'persen','none',0.00,0.00,7375000.00,0.00,7375000.00,'proses_potong','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(125,'INV-2026-024',32,'2026-05-24','2026-06-22',2946000.00,'persen','none',0.00,0.00,2946000.00,2946000.00,0.00,'menunggu_bahan','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(126,'INV-2026-025',33,'2026-04-30','2026-06-24',4859000.00,'persen','none',0.00,0.00,4859000.00,2818220.00,2040780.00,'proses_jahit','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(127,'INV-2026-026',33,'2026-06-13','2026-06-26',4208000.00,'persen','none',0.00,0.00,4208000.00,4208000.00,0.00,'siap_diambil','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(128,'INV-2026-027',34,'2026-05-20','2026-06-16',6829000.00,'persen','none',0.00,0.00,6829000.00,3277920.00,3551080.00,'proses_sablon_bordir','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(129,'INV-2026-028',34,'2026-04-19','2026-06-19',2760000.00,'persen','none',0.00,0.00,2760000.00,1297200.00,1462800.00,'siap_diambil','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(130,'INV-2026-029',35,'2026-06-14','2026-07-02',1295000.00,'persen','none',0.00,0.00,1295000.00,867650.00,427350.00,'proses_sablon_bordir','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(131,'INV-2026-030',35,'2026-05-15','2026-07-05',2438000.00,'persen','none',0.00,0.00,2438000.00,2438000.00,0.00,'menunggu_bahan','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(132,'INV-2026-031',36,'2026-05-14','2026-07-05',9400000.00,'persen','none',0.00,0.00,9400000.00,9400000.00,0.00,'nunggu_konfirmasi','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(133,'INV-2026-032',36,'2026-06-03','2026-06-18',6352000.00,'persen','none',0.00,0.00,6352000.00,6352000.00,0.00,'quality_control','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(134,'INV-2026-033',37,'2026-05-06','2026-06-25',5757000.00,'persen','none',0.00,0.00,5757000.00,3684480.00,2072520.00,'proses_jahit','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(135,'INV-2026-034',37,'2026-05-20','2026-06-20',1508000.00,'persen','none',0.00,0.00,1508000.00,1508000.00,0.00,'proses_jahit','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(136,'INV-2026-035',38,'2026-06-02','2026-06-19',1732000.00,'persen','none',0.00,0.00,1732000.00,519600.00,1212400.00,'proses_sablon_bordir','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(137,'INV-2026-036',38,'2026-05-15','2026-06-21',4428000.00,'persen','none',0.00,0.00,4428000.00,4428000.00,0.00,'menunggu_bahan','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(138,'INV-2026-037',39,'2026-05-27','2026-06-21',6342000.00,'persen','none',0.00,0.00,6342000.00,6342000.00,0.00,'selesai','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(139,'INV-2026-038',39,'2026-04-22','2026-07-01',3978000.00,'persen','none',0.00,0.00,3978000.00,0.00,3978000.00,'proses_potong','belum','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(140,'INV-2026-039',40,'2026-04-19','2026-07-03',6718000.00,'persen','none',0.00,0.00,6718000.00,6718000.00,0.00,'menunggu_bahan','lunas','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(141,'INV-2026-040',40,'2026-05-15','2026-06-21',6395000.00,'persen','none',0.00,0.00,6395000.00,4412550.00,1982450.00,'menunggu_bahan','belum','2026-06-15 17:40:00','2026-06-15 17:40:00');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `metode` enum('tunai','transfer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunai',
  `bukti_transfer` text COLLATE utf8mb4_unicode_ci,
  `tipe` enum('dp','pelunasan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dp',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  KEY `payments_tanggal_bayar_index` (`tanggal_bayar`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payments` */

insert  into `payments`(`id`,`order_id`,`tanggal_bayar`,`jumlah`,`metode`,`bukti_transfer`,`tipe`,`catatan`,`created_at`,`updated_at`) values 
(2,2,'2026-05-01',750000.00,'tunai',NULL,'dp','DP 50%','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(3,3,'2026-05-05',1000000.00,'transfer',NULL,'dp','DP awal via transfer BRI','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(4,4,'2026-05-08',1500000.00,'tunai',NULL,'dp','DP 50%','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(5,5,'2026-05-10',900000.00,'transfer',NULL,'dp','DP 50% via transfer','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(6,6,'2026-05-12',2000000.00,'tunai',NULL,'dp','DP awal','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(7,6,'2026-05-30',2275000.00,'transfer',NULL,'pelunasan','Pelunasan via transfer BCA','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(8,7,'2026-05-15',2700000.00,'tunai',NULL,'pelunasan','Bayar lunas di tempat','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(9,8,'2026-05-18',1500000.00,'transfer',NULL,'dp','DP via transfer Mandiri','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(10,8,'2026-06-05',2000000.00,'tunai',NULL,'pelunasan','Pelunasan saat ambil barang','2026-06-12 20:26:12','2026-06-12 20:26:12'),
(11,9,'2026-06-15',1000000.00,'transfer','payment_proofs/6a2ff95978ef20.39380438_1781528921.jpg','dp','DP awal','2026-06-15 13:08:41','2026-06-15 13:08:41'),
(12,10,'2026-06-15',500000.00,'tunai','payment_proofs/6a3008a98622f1.03818744_1781532841.jpg','dp','DP awal','2026-06-15 14:14:01','2026-06-15 14:14:01'),
(13,11,'2026-06-15',800000.00,'transfer','[\"payment_proofs\\/6a30293dd34443.31165243_1781541181.jpg\",\"payment_proofs\\/6a30293dd366b7.26840597_1781541181.jpg\"]','dp','DP awal','2026-06-15 16:33:01','2026-06-15 16:33:01'),
(14,11,'2026-06-15',300000.00,'tunai','[\"payment_proofs\\/6a302c30659192.74605368_1781541936.jpg\"]','dp','tahap 2','2026-06-15 16:45:36','2026-06-15 16:45:36'),
(15,11,'2026-06-15',800000.00,'tunai','[\"payment_proofs\\/6a302c56428992.50768434_1781541974.jpg\"]','pelunasan','pelunasan','2026-06-15 16:46:14','2026-06-15 16:46:14'),
(137,112,'2026-04-22',4289000.00,'transfer',NULL,'dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(138,112,'2026-04-27',4289000.00,'transfer','acak_images/1012747035362297688.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(139,113,'2026-06-03',703000.00,'transfer','acak_images/Soy_ on TikTok.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(140,113,'2026-06-07',703000.00,'tunai','acak_images/398568635787196334.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(141,115,'2026-05-24',1056000.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(142,115,'2026-05-27',1056000.00,'tunai','acak_images/904449537681472444.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(143,116,'2026-05-31',2475000.00,'transfer',NULL,'dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(144,116,'2026-06-02',2475000.00,'transfer','acak_images/1009650810219696716.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(145,117,'2026-06-10',3806500.00,'tunai','acak_images/WhatsApp Image 2026-06-16 at 00.28.06.jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(146,117,'2026-06-11',3806500.00,'tunai',NULL,'pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(147,118,'2026-05-26',337280.00,'tunai','acak_images/1008736016545216215.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(148,119,'2026-05-13',4549000.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(149,119,'2026-05-17',4549000.00,'tunai','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(150,120,'2026-04-20',1652000.00,'transfer','acak_images/299630181479731482.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(151,120,'2026-04-22',1652000.00,'tunai','acak_images/WhatsApp Image 2026-06-16 at 00.28.06 (1).jpeg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(152,121,'2026-05-31',2941200.00,'tunai','acak_images/cat.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(153,122,'2026-06-09',2318400.00,'tunai',NULL,'dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(154,123,'2026-05-18',5384120.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.29.04 (1).jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(155,125,'2026-05-24',1473000.00,'tunai','acak_images/398568635787196334.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(156,125,'2026-05-26',1473000.00,'tunai','acak_images/WhatsApp Image 2026-06-16 at 00.28.06.jpeg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(157,126,'2026-04-30',2818220.00,'tunai','acak_images/download (2).jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(158,127,'2026-06-13',2104000.00,'transfer','acak_images/1085719422747587095.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(159,127,'2026-06-16',2104000.00,'tunai',NULL,'pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(160,128,'2026-05-20',3277920.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.28.05.jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(161,129,'2026-04-19',1297200.00,'tunai','acak_images/1085719422747587095.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(162,130,'2026-06-14',867650.00,'tunai','acak_images/650699846185929769.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(163,131,'2026-05-15',1219000.00,'transfer',NULL,'dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(164,131,'2026-05-18',1219000.00,'transfer',NULL,'pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(165,132,'2026-05-14',4700000.00,'transfer','acak_images/650699846185929769.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(166,132,'2026-05-15',4700000.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(167,133,'2026-06-03',3176000.00,'tunai',NULL,'dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(168,133,'2026-06-08',3176000.00,'tunai','acak_images/942096815806868372.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(169,134,'2026-05-06',3684480.00,'tunai','acak_images/1035546508044250549.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(170,135,'2026-05-20',754000.00,'transfer','acak_images/1085719422747587095.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(171,135,'2026-05-24',754000.00,'transfer',NULL,'pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(172,136,'2026-06-02',519600.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.28.05.jpeg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(173,137,'2026-05-15',2214000.00,'tunai','acak_images/890023945133409776.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(174,137,'2026-05-17',2214000.00,'tunai','acak_images/890023945133409776.jpg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(175,138,'2026-05-27',3171000.00,'transfer','acak_images/1009650810219696716.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(176,138,'2026-05-28',3171000.00,'tunai',NULL,'pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(177,140,'2026-04-19',3359000.00,'transfer','acak_images/Soy_ on TikTok.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(178,140,'2026-04-21',3359000.00,'transfer','acak_images/WhatsApp Image 2026-06-16 at 00.29.04.jpeg','pelunasan','Pelunasan Akhir','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(179,141,'2026-05-15',4412550.00,'tunai','acak_images/1012747035362297688.jpg','dp','Pembayaran Awal','2026-06-15 17:40:00','2026-06-15 17:40:00');

/*Table structure for table `pengeluarans` */

DROP TABLE IF EXISTS `pengeluarans`;

CREATE TABLE `pengeluarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `tipe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `metode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunai',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `foto_nota` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengeluarans_tanggal_index` (`tanggal`),
  KEY `pengeluarans_tipe_index` (`tipe`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengeluarans` */

insert  into `pengeluarans`(`id`,`tanggal`,`tipe`,`keterangan`,`jumlah`,`metode`,`catatan`,`foto_nota`,`created_at`,`updated_at`) values 
(1,'2026-06-12','bahan_baku','kain',500000.00,'tunai',NULL,NULL,'2026-06-12 16:01:30','2026-06-12 16:01:30'),
(3,'2026-06-15','listrik_air','Air',50000.00,'transfer','Air mingguan','pengeluaran_nota/bhXLH8sVrLclqV3fgzOhqPyNnUXFZeQEnF0VKjy8.jpg','2026-06-15 13:45:13','2026-06-15 13:45:13'),
(4,'2026-06-15','bahan_baku','Air',50000.00,'tunai','mantab','[\"pengeluaran_nota\\/7SlSLv7Az1MWB6g37PINzv7yT2xzpJTKNUvgqCAs.jpg\",\"pengeluaran_nota\\/1EASFZQ3yrbYxaG2AJSOUs8iuvxdjxaybl5EBLsn.jpg\"]','2026-06-15 14:36:52','2026-06-15 14:36:52'),
(55,'2026-05-31','bahan_baku','Belanja keperluan bahan_baku 1',900000.00,'transfer','Testing data pengeluaran','acak_images/785174516295481903.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(56,'2026-06-14','lain_lain','Belanja keperluan operasional 2',2050000.00,'transfer','Testing data pengeluaran','acak_images/650699846185929769.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(57,'2026-05-17','lain_lain','Belanja keperluan lain_lain 3',2050000.00,'tunai','Testing data pengeluaran','acak_images/1035546508044250549.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(58,'2026-06-07','gaji','Belanja keperluan bahan_baku 4',2400000.00,'transfer','Testing data pengeluaran','acak_images/299630181479731482.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(59,'2026-05-30','operasional','Belanja keperluan gaji 5',1650000.00,'transfer','Testing data pengeluaran','acak_images/299630181479731482.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(60,'2026-06-11','bahan_baku','Belanja keperluan lain_lain 6',550000.00,'tunai','Testing data pengeluaran',NULL,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(61,'2026-06-03','operasional','Belanja keperluan operasional 7',1750000.00,'tunai','Testing data pengeluaran','acak_images/WhatsApp Image 2026-06-16 at 00.28.06 (1).jpeg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(62,'2026-05-16','lain_lain','Belanja keperluan bahan_baku 8',1100000.00,'transfer','Testing data pengeluaran','acak_images/?Game_ Genshin Impact_✨Name_ Hu Tao “Fragrance in….jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(63,'2026-05-30','bahan_baku','Belanja keperluan operasional 9',950000.00,'tunai','Testing data pengeluaran',NULL,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(64,'2026-05-21','bahan_baku','Belanja keperluan listrik_air 10',1150000.00,'tunai','Testing data pengeluaran','acak_images/299630181479731482.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(65,'2026-05-20','lain_lain','Belanja keperluan gaji 11',800000.00,'transfer','Testing data pengeluaran','acak_images/938226534909094701.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(66,'2026-05-11','lain_lain','Belanja keperluan operasional 12',1800000.00,'tunai','Testing data pengeluaran','acak_images/1085719422747587095.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(67,'2026-05-25','lain_lain','Belanja keperluan operasional 13',750000.00,'tunai','Testing data pengeluaran',NULL,'2026-06-15 17:40:00','2026-06-15 17:40:00'),
(68,'2026-05-25','bahan_baku','Belanja keperluan gaji 14',1450000.00,'transfer','Testing data pengeluaran','acak_images/☆ on TikTok.jpg','2026-06-15 17:40:00','2026-06-15 17:40:00'),
(69,'2026-06-09','operasional','Belanja keperluan operasional 15',1850000.00,'transfer','Testing data pengeluaran','acak_images/?Game_ Genshin Impact_✨Name_ Hu Tao “Fragrance in….jpg','2026-06-15 17:40:00','2026-06-15 17:40:00');

/*Table structure for table `penggajians` */

DROP TABLE IF EXISTS `penggajians`;

CREATE TABLE `penggajians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `bulan` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minggu_ke` int DEFAULT NULL,
  `hari_kerja` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_gaji` decimal(15,2) NOT NULL,
  `status` enum('pending','dibayar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `penggajians_employee_id_bulan_minggu_ke_unique` (`employee_id`,`bulan`,`minggu_ke`),
  CONSTRAINT `penggajians_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penggajians` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

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

/*Data for the table `sessions` */

/*Table structure for table `sizes` */

DROP TABLE IF EXISTS `sizes`;

CREATE TABLE `sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sizes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sizes` */

insert  into `sizes`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'S','2026-06-12 20:03:55','2026-06-12 20:03:55'),
(2,'M','2026-06-12 20:03:55','2026-06-12 20:03:55'),
(3,'L','2026-06-12 20:03:55','2026-06-12 20:03:55'),
(4,'XL','2026-06-12 20:03:55','2026-06-12 20:03:55'),
(5,'XXL','2026-06-12 20:03:55','2026-06-12 20:03:55'),
(6,'XXXL','2026-06-12 20:03:55','2026-06-12 20:03:55');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('owner','admin','kasir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Pemilik Toko','owner','$2y$12$FHB3zTikhQN6W/7eGyDeJeRZPqa.SnmR1zFTZmmSJJ2zxRAsRFnPO','owner',NULL,'2026-06-12 20:03:55','2026-06-12 20:03:55'),
(2,'Administrator','admin','$2y$12$MDpCwLXH5J6VPjlb/oyzCu.QOas9aHt.XXxzdHjnmZ8yBgyAfrpgq','admin',NULL,'2026-06-12 20:03:55','2026-06-12 20:03:55');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
