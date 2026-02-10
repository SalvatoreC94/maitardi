-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Nov 09, 2025 alle 16:16
-- Versione del server: 8.0.40
-- Versione PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasticceria`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `user_id`, `created_at`, `updated_at`) VALUES
(34, 'v23JFxiy74cabgH01x6nvt3gSWUcDeQfJ8OYYv28', NULL, '2025-11-03 13:18:51', '2025-11-03 13:18:51'),
(35, 'n33IF7M63mFOMEynwKXjTRrRuxSs5LMZ9hp6t2uk', NULL, '2025-11-03 19:55:42', '2025-11-03 19:55:42'),
(36, 'CLSsxi0djHn09X3HsSYX3ZixNlJrwMwWCqsUOCxl', NULL, '2025-11-04 09:02:50', '2025-11-04 09:02:50'),
(37, '032qcfnkFUHvZUbeF6D1LkVqouLtnUqYfFFo8tDx', NULL, '2025-11-04 09:03:01', '2025-11-04 09:03:01'),
(38, '5Zm6NvlD8bM6K9OA126OoYfF6sj9yM0r1LN6PuSl', NULL, '2025-11-04 10:45:49', '2025-11-04 10:45:49'),
(39, 'jFYMf07yVxNiOJFFwFfHPsiajFtPQdCI2GYQAnmq', NULL, '2025-11-05 08:11:45', '2025-11-05 08:11:45'),
(40, 'UBWBOFFwRJFWVuIH5iIS1JXiaQ0Yy1l9hKlUzuOr', NULL, '2025-11-05 19:38:47', '2025-11-05 19:38:47'),
(41, 'xautl3WND74Wux5YmjJttLVHmNhh6AacSQocQhF2', NULL, '2025-11-06 13:51:27', '2025-11-06 13:51:27');

-- --------------------------------------------------------

--
-- Struttura della tabella `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `unit_price_cents` int NOT NULL,
  `total_cents` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'Panettone', NULL, 'panettone', 1, '2025-10-16 18:47:42', '2025-10-19 08:13:45'),
(2, 'Colombe', NULL, 'colombe', 1, '2025-10-16 18:47:42', '2025-11-03 12:51:36'),
(3, 'Freschi', NULL, 'freschi', 1, '2025-10-16 18:47:42', '2025-10-16 18:47:42'),
(5, 'Salati', NULL, 'salati', 1, '2025-10-28 13:02:33', '2025-10-28 13:02:33');

-- --------------------------------------------------------

--
-- Struttura della tabella `category_product`
--

CREATE TABLE `category_product` (
  `category_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `category_product`
--

INSERT INTO `category_product` (`category_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 16, NULL, NULL),
(1, 17, NULL, NULL),
(1, 18, NULL, NULL),
(1, 19, NULL, NULL),
(1, 20, NULL, NULL),
(1, 21, NULL, NULL),
(1, 22, NULL, NULL),
(1, 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `job_batches`
--

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
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_06_150243_create_categories_table', 1),
(5, '2025_10_06_150322_create_products_table', 1),
(6, '2025_10_06_150423_create_carts_table', 1),
(7, '2025_10_06_150457_create_orders_table', 1),
(8, '2025_10_06_150541_create_cart_items_table', 1),
(9, '2025_10_06_150617_create_order_items_table', 1),
(10, '2025_10_06_150647_create_store_settings_table', 1),
(11, '2025_10_06_170457_add_is_admin_to_users_table', 1),
(12, '2025_10_06_170738_add_customer_fields_to_users_table', 1),
(13, '2025_10_08_095736_create_category_product_table', 1),
(14, '2025_10_08_111519_normalize_store_settings_table', 1),
(15, '2025_10_14_064444_align_order_items_snapshots', 1),
(16, '2025_10_14_150745_add_customer_fields_to_users_table', 1),
(17, '2025_10_26_203759_add_images_to_products_table', 2),
(18, '2025_10_28_141039_alter_cart_items_fk_on_delete_cascade', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` json NOT NULL,
  `delivery_fee_cents` int NOT NULL DEFAULT '0',
  `subtotal_cents` int NOT NULL,
  `discount_cents` int NOT NULL DEFAULT '0',
  `total_cents` int NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EUR',
  `payment_status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_status` enum('new','pending','preparing','shipped','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `courier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_payment_intent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int NOT NULL,
  `unit_price_cents` int NOT NULL,
  `total_cents` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_cents` int UNSIGNED NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `images` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `sku`, `price_cents`, `is_visible`, `images`, `description`, `created_at`, `updated_at`) VALUES
(16, 'Panettone Tradizionale', 'panettone-tradizionale', 'PT001', 3500, 1, '[\"products/products/panettone-tradizionale-vhfmoXz0.webp\"]', 'Il grande classico MaiTardi: lievitato naturalmente con Lievito Madre per una sofficità autentica e profumi di agrumi mediterranei.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, sale, burro, uvetta australiana, arancia semicandita, farina di mandorle, mandorle, vaniglia del Madagascar.', '2025-11-03 14:12:50', '2025-11-04 13:00:24'),
(17, 'Panettone Cioccolato', 'panettone-cioccolato', 'PT002', 3500, 1, '[\"products/products/panettone-cioccolato-24WY6ufE.webp\"]', 'Goloso e avvolgente: impasto soffice e profumato con note di vaniglia e ricche pepite di cioccolato fondente al 55%.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, sale, burro, farina di nocciole, vaniglia del Madagascar, pezzi di cioccolato fondente al 55%.', '2025-11-03 14:12:50', '2025-11-04 11:10:48'),
(18, 'Panettone Cinque Cereali e Frutti di Bosco', 'panettone-cinque-cereali-frutti-di-bosco', 'PT003', 3800, 1, '[\"products/products/panettone-cereali-N3yKui3i.webp\"]', 'Rustico e sorprendente: l’equilibrio tra il mix di cereali, frutti di bosco semicanditi e la dolcezza del cioccolato bianco.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, mix di cereali, vaniglia del Madagascar, frutti di bosco semicanditi, cioccolato bianco.', '2025-11-03 14:12:50', '2025-11-04 11:08:14'),
(19, 'Panettone Albicocca Pellecchiella', 'panettone-albicocca-pellecchiella', 'PT004', 3500, 1, '[\"products/products/panettone-pellecchiella-6hIHZuFJ.webp\"]', 'Omaggio alla tradizione campana: morbido, aromatico e impreziosito dalla pregiata Albicocca Pellecchiella del Vesuvio.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, farina di mandorle, vaniglia del Madagascar, Albicocca Pellecchiella del Vesuvio.', '2025-11-03 14:12:50', '2025-11-04 13:09:07'),
(20, 'Panettone Pistacchio', 'panettone-pistacchio', 'PT005', 4000, 1, '[\"products/products/panettone-pistacchio-v1-rNNJAMa9.webp\"]', 'Elegante e cremoso: la dolcezza del cioccolato bianco incontra il pistacchio. Accompagnato da una crema spalmabile artigianale al pistacchio.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, vaniglia del Madagascar, cioccolato bianco, pistacchio.', '2025-11-03 14:12:50', '2025-11-04 11:08:38'),
(21, 'Panettone Agrumella', 'panettone-agrumella', 'PT006', 3800, 1, '[\"products/products/panettone-agrumella-IING8rKg.webp\"]', 'Fresco e profumato: limone e arancia semicanditi con una nota gentile di cioccolato bianco. Accompagnato da una crema al mandarino.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, vaniglia del Madagascar, limone e arancia semicanditi, cioccolato bianco, fette di limone e arancia disidratate.', '2025-11-03 14:12:50', '2025-11-04 11:09:51'),
(22, 'Pan d\'Or', 'panettone-pan-dor', 'PT007', 3500, 1, '[\"products/products/chatgpt-image-15-ott-2025-18-00-04-cDYKE1O0.png\"]', 'Delicato e luminoso: pepite di burro di cacao e scorze agrumate per un profilo fine e armonico.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, vaniglia del Madagascar, pepite di burro di cacao, buccia di limone e arancia grattugiata.', '2025-11-03 14:12:50', '2025-11-04 13:51:29'),
(23, 'Panettone Mela e Cannella', 'panettone-mela-cannella', 'PT008', 3800, 1, '[\"products/products/panettone-mele-cannella-MJWtFQdB.webp\"]', 'Avvolgente e invernale: mela annurca semicandita, cannella e cioccolato al latte per un comfort food d’autore.\r\n\r\nIngredienti: Farina 00, Lievito Madre, uova, zucchero, miele, malto, burro, sale, cannella in polvere, mela annurca semicandita, cioccolato al latte, fette di mela disidratate.', '2025-11-03 14:12:50', '2025-11-04 12:16:43');

-- --------------------------------------------------------

--
-- Struttura della tabella `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UIU7JrarssoUIDNBBYIOt34boWdaa3BWXPeKvqq2', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiTTFrZEFVVkFaaGszVFF5RjlsYVprVnRQTG43SUZmMER4YVhnTUFadiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkdDdZd1cvaWpIbDdBRE5YTU9FNndVZTVSSGZJZ3lYSzVycTFYakg3anM1RVZnYlV5T3V6MTYiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1762454828);

-- --------------------------------------------------------

--
-- Struttura della tabella `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EUR',
  `shipping_base_cents` int UNSIGNED NOT NULL DEFAULT '0',
  `free_shipping_threshold_cents` int UNSIGNED NOT NULL DEFAULT '0',
  `is_open` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `store_settings`
--

INSERT INTO `store_settings` (`id`, `created_at`, `updated_at`, `store_name`, `currency`, `shipping_base_cents`, `free_shipping_threshold_cents`, `is_open`) VALUES
(1, '2025-10-16 15:38:05', '2025-10-16 18:20:17', 'Mai tardi Shop', 'EUR', 1000, 6900, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `city`, `province`, `zip`, `shipping_address`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'prova test front', 'front@test.it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Sl7i5uUexNRoHH7zqQWxQ.JX/cEIe2T1enCN11Z5CVlm2ZLTm5Nny', 0, NULL, '2025-10-21 08:38:08', '2025-10-21 08:38:08'),
(3, 'tore', 'ultimo@test.it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$hsls3Vgjv/phUWovSs3tquhArJ67vT6ZkCZl.qRpRCZ7Rwt1QhvmG', 0, NULL, '2025-10-26 19:42:07', '2025-10-26 19:42:07'),
(4, 'salv', 'sal@prova.it', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Eoj68DirFtLj/h931lzbu.IbuUTbIfY1IT89SB1MFwBTANIbT2zAm', 0, NULL, '2025-10-28 13:31:26', '2025-10-28 13:31:26'),
(5, 'prova', 'prova@test.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$v0aqWF4iAyXtm5yHZ7imJu6yq/BJueXH5zpg6CNemIzEVauMecKYm', 0, NULL, '2025-10-28 13:44:33', '2025-10-28 13:44:33'),
(6, 'sal coz', 'salvatorecozzolino.1594@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$RN15yyL47QgT.W0kF18H0uVZv/NdUpt9nP74ppXiy3IvHujB1YCaq', 0, NULL, '2025-10-28 16:12:37', '2025-10-28 16:12:37'),
(8, 'Admin Maitardi', 'infomaitardi@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$L5VaPWJxvGOtcbFsvc7mQe7YLum/5y.spwL7zg/uofDK5ayhtS2FK', 1, NULL, '2025-11-09 14:25:30', '2025-11-09 14:25:30');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indici per le tabelle `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indici per le tabelle `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_session_id_index` (`session_id`);

--
-- Indici per le tabelle `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indici per le tabelle `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`category_id`,`product_id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`);

--
-- Indici per le tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indici per le tabelle `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indici per le tabelle `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_code_unique` (`code`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indici per le tabelle `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indici per le tabelle `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_is_visible_stock_qty_index` (`is_visible`);

--
-- Indici per le tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indici per le tabelle `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT per la tabella `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
