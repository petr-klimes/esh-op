-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                5.5.32 - MySQL Community Server (GPL)
-- OS serveru:                   Win32
-- HeidiSQL Verze:               8.3.0.4800
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportování struktury databáze pro
CREATE DATABASE IF NOT EXISTS `esh-op` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `esh-op`;


-- Exportování struktury pro tabulka esh-op.adress
CREATE TABLE IF NOT EXISTS `adress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ico` int(11) NOT NULL,
  `dico` int(11) NOT NULL,
  `street` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `psc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.adress: ~0 rows (přibližně)
/*!40000 ALTER TABLE `adress` DISABLE KEYS */;
/*!40000 ALTER TABLE `adress` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `e_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.category: ~0 rows (přibližně)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.icon
CREATE TABLE IF NOT EXISTS `icon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.icon: ~0 rows (přibližně)
/*!40000 ALTER TABLE `icon` DISABLE KEYS */;
/*!40000 ALTER TABLE `icon` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `title` text COLLATE utf8_czech_ci NOT NULL,
  `src` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.image: ~0 rows (přibližně)
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
/*!40000 ALTER TABLE `image` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.language
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.language: ~0 rows (přibližně)
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` (`id`, `name`, `code`) VALUES
	(1, 'Česky', 'cze');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.order
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `state` int(11) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.order: ~0 rows (přibližně)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `data` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_order_item_product` (`id_product`),
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.order_item: ~0 rows (přibližně)
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.order_state
CREATE TABLE IF NOT EXISTS `order_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.order_state: ~0 rows (přibližně)
/*!40000 ALTER TABLE `order_state` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_state` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `e_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date NOT NULL,
  `tax` int(11) NOT NULL DEFAULT '21',
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Produkty';

-- Exportování dat pro tabulku esh-op.product: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `e_name`, `price`, `valid_from`, `valid_to`, `tax`, `active`) VALUES
	(0, 'Lis na ovoce', 'lis-na-ovoce', 3500, NULL, '0000-00-00', 21, 1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_category_product` (`id_product`),
  KEY `FK_product_category_category` (`id_category`),
  CONSTRAINT `FK_product_category_category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_product_category_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.product_category: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product_discount
CREATE TABLE IF NOT EXISTS `product_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `old_price` int(11) NOT NULL,
  `icon` int(11) NOT NULL,
  `title` text COLLATE utf8_czech_ci NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_discount_product` (`id_product`),
  KEY `FK_product_discount_icon` (`icon`),
  CONSTRAINT `FK_product_discount_icon` FOREIGN KEY (`icon`) REFERENCES `icon` (`id`),
  CONSTRAINT `FK_product_discount_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.product_discount: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product_discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_discount` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product_image
CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_image` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_image_product` (`id_product`),
  KEY `FK_product_image_image` (`id_image`),
  CONSTRAINT `FK_product_image_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_product_image_image` FOREIGN KEY (`id_image`) REFERENCES `image` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.product_image: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product_product
CREATE TABLE IF NOT EXISTS `product_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_product_join` int(11) NOT NULL,
  `join_type` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_product_product` (`id_product`),
  KEY `FK_product_product_product_2` (`id_product_join`),
  CONSTRAINT `FK_product_product_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_product_product_product_2` FOREIGN KEY (`id_product_join`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.product_product: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_product` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.product_text
CREATE TABLE IF NOT EXISTS `product_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `id_language` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_text_product` (`id_product`),
  KEY `FK_product_text_language` (`id_language`),
  CONSTRAINT `FK_product_text_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_product_text_language` FOREIGN KEY (`id_language`) REFERENCES `language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.product_text: ~0 rows (přibližně)
/*!40000 ALTER TABLE `product_text` DISABLE KEYS */;
INSERT INTO `product_text` (`id`, `id_product`, `title`, `text`, `id_language`, `active`) VALUES
	(4, 0, 'titulek lisu na ovoce který bude tka akorát', 'dlouhy text u lisu na ovoce je asdfg aaklis w,era bn,ia nweoftg df. oldaligdaf ůlaod fnadůla blgtweirutaw .otůiaw gblaůsdi gusafdůlgfigoda.lda ůadů ůlao fgl aeruoi aů godaifg hdaů a', 1, 1);
/*!40000 ALTER TABLE `product_text` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.translation
CREATE TABLE IF NOT EXISTS `translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_language` int(11) NOT NULL,
  `key` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `value` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_translation_language` (`id_language`),
  CONSTRAINT `FK_translation_language` FOREIGN KEY (`id_language`) REFERENCES `language` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.translation: ~0 rows (přibližně)
/*!40000 ALTER TABLE `translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `translation` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.user: ~0 rows (přibližně)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Exportování struktury pro tabulka esh-op.user_adress
CREATE TABLE IF NOT EXISTS `user_adress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_adress` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_adress_user` (`id_user`),
  KEY `FK_user_adress_adress` (`id_adress`),
  CONSTRAINT `FK_user_adress_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_user_adress_adress` FOREIGN KEY (`id_adress`) REFERENCES `adress` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku esh-op.user_adress: ~0 rows (přibližně)
/*!40000 ALTER TABLE `user_adress` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_adress` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
