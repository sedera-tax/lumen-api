-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 21 juil. 2020 à 05:21
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test-api`
--

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_07_20_093501_create_products_table', 1),
(2, '2020_07_20_101510_create_items_table', 2),
(3, '2020_07_21_033552_create_orders_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `content`, `created_at`, `updated_at`) VALUES
(2, '[{\"quantity\": 3, \"product_id\": 3}, {\"quantity\": 2, \"product_id\": 1}]', '2020-07-21 05:18:59', '2020-07-21 05:18:59');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 'test 1', 'description test', 15.00, '2020-07-20 13:01:04', '2020-07-20 15:12:48'),
(2, 'test 2', 'description test', 0.00, '2020-07-20 13:01:51', '2020-07-20 13:01:51'),
(3, 'Milk', 'Milk TIKO vita Malagasy', 100.00, '2020-07-20 15:28:26', '2020-07-20 16:01:35'),
(4, 'Cheese', 'Cheese TIKO vita Malagasy', 0.00, '2020-07-20 15:30:33', '2020-07-20 15:30:33'),
(5, 'Cake', 'description', 100.00, '2020-07-20 18:00:25', '2020-07-20 18:45:52'),
(6, 'Lilliana Kertzmann', 'Rerum odit saepe optio maxime. Suscipit quisquam totam est omnis. Consequatur sed ut et. Consequuntur quod aut delectus qui.', 13.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(7, 'Kailee Nicolas V', 'Facilis eaque sapiente eum id veritatis. Unde in odit vel cupiditate occaecati id soluta. Minima ut nisi qui pariatur voluptatem.', 1360.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(8, 'Velma Becker', 'Eligendi qui fugit iste. Repellendus qui voluptatibus sed fugit. Enim possimus laudantium perspiciatis perferendis aut. Rerum veniam earum dignissimos.', 837.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(9, 'Malachi Heidenreich', 'Quas est laboriosam debitis ut soluta quos qui. Harum amet delectus qui itaque consequuntur id. Ut reiciendis earum velit dolorem alias. Dolor in ut culpa porro.', 1044.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(10, 'Mr. Jamaal D\'Amore V', 'Culpa repudiandae maiores iusto qui ipsum aspernatur. Qui soluta ab sequi. Culpa nam quisquam in provident nihil.', 173.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(11, 'Aracely Lebsack', 'Non qui ut et tenetur ut. Quisquam est fuga minima. Ea harum dolor est nam ducimus.', 1028.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(12, 'Lavina Bogisich III', 'Reiciendis dolorem et sed. Quaerat et non expedita vero reprehenderit ratione. Laborum hic rem quia voluptatem.', 243.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(13, 'Ezra Fisher', 'Non vitae a recusandae distinctio velit praesentium vero totam. Tenetur voluptas iste aut itaque. Incidunt sunt voluptatem aliquid et aliquam. Commodi quam assumenda corrupti voluptas.', 1178.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(14, 'Prof. Dock Corwin', 'Tempora quidem repudiandae suscipit voluptate fugit. Cumque suscipit tempore praesentium corrupti magni qui. Eaque sit nulla nulla ipsam et. Error dolores doloremque est minus.', 1139.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16'),
(15, 'Peter Kozey', 'Impedit dicta placeat nesciunt doloribus est nostrum consequuntur sit. Ad debitis vero in eos. Nostrum quia id et et vero eum quia. Voluptatem voluptas quibusdam quia impedit.', 728.00, '2020-07-20 18:57:16', '2020-07-20 18:57:16');

-- --------------------------------------------------------

--
-- Structure de la table `product_items`
--

DROP TABLE IF EXISTS `product_items`;
CREATE TABLE IF NOT EXISTS `product_items` (
  `product_items_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `expired_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_items_id`),
  KEY `product_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_items`
--

INSERT INTO `product_items` (`product_items_id`, `quantity`, `product_id`, `expired_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2020-08-22', '2020-07-20 13:18:28', '2020-07-21 05:18:59'),
(2, 1, 1, '2020-07-22', '2020-07-20 13:19:09', '2020-07-21 05:18:59'),
(3, 2, 3, '2020-07-22', '2020-07-20 15:33:47', '2020-07-21 05:18:59'),
(4, 4, 3, '2020-07-30', '2020-07-20 15:34:17', '2020-07-21 05:18:59'),
(5, 5, 5, '2020-07-30', '2020-07-20 18:01:35', '2020-07-20 18:01:35');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
