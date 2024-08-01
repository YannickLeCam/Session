-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sessionlecam
CREATE DATABASE IF NOT EXISTS `sessionlecam` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sessionlecam`;

-- Listage de la structure de table sessionlecam. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.category : ~3 rows (environ)
INSERT IGNORE INTO `category` (`id`, `name`) VALUES
	(1, 'Dev web'),
	(2, 'Bureautique'),
	(3, 'Comptabilité');

-- Listage de la structure de table sessionlecam. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table sessionlecam.doctrine_migration_versions : ~2 rows (environ)
INSERT IGNORE INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20240729133530', '2024-07-31 06:56:36', 561),
	('DoctrineMigrations\\Version20240729135155', '2024-07-31 06:56:36', 441);

-- Listage de la structure de table sessionlecam. intern
CREATE TABLE IF NOT EXISTS `intern` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.intern : ~2 rows (environ)
INSERT IGNORE INTO `intern` (`id`, `name`, `first_name`, `email`, `birthday`, `city`, `adress`, `gender`, `zip_code`) VALUES
	(2, 'Meleard', 'Nolann', 'nolann.meleard@gmail.com', '1996-09-23 00:00:00', 'Nantes', '13 général faschier', 'Homme', '44120'),
	(3, 'Le Cam', 'Yann', 'yannick.lecam1@gmail.com', '1996-11-08 00:00:00', 'Strasbourg', '8 rue de la Toussaint', 'Homme', '67000');

-- Listage de la structure de table sessionlecam. intern_session
CREATE TABLE IF NOT EXISTS `intern_session` (
  `intern_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`intern_id`,`session_id`),
  KEY `IDX_A6D9BBE2525DD4B4` (`intern_id`),
  KEY `IDX_A6D9BBE2613FECDF` (`session_id`),
  CONSTRAINT `FK_A6D9BBE2525DD4B4` FOREIGN KEY (`intern_id`) REFERENCES `intern` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A6D9BBE2613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.intern_session : ~2 rows (environ)
INSERT IGNORE INTO `intern_session` (`intern_id`, `session_id`) VALUES
	(2, 2),
	(3, 1),
	(3, 2);

-- Listage de la structure de table sessionlecam. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sessionlecam. module_program
CREATE TABLE IF NOT EXISTS `module_program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3996499D12469DE2` (`category_id`),
  CONSTRAINT `FK_3996499D12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.module_program : ~8 rows (environ)
INSERT IGNORE INTO `module_program` (`id`, `category_id`, `name`) VALUES
	(1, 1, 'PHP'),
	(2, 1, 'Javascript'),
	(3, 1, 'HTML'),
	(4, 1, 'CSS'),
	(5, 2, 'Word'),
	(6, 2, 'PowerPoint'),
	(7, 2, 'Excel'),
	(8, 3, 'Gestion Entreprise');

-- Listage de la structure de table sessionlecam. program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int DEFAULT NULL,
  `module_id` int DEFAULT NULL,
  `duration` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784613FECDF` (`session_id`),
  KEY `IDX_92ED7784AFC2B591` (`module_id`),
  CONSTRAINT `FK_92ED7784613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_92ED7784AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module_program` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.program : ~13 rows (environ)
INSERT IGNORE INTO `program` (`id`, `session_id`, `module_id`, `duration`) VALUES
	(1, 1, 1, 6),
	(2, 1, 3, 12),
	(3, 1, 4, 16),
	(5, 2, 5, 3),
	(39, 3, 4, 5),
	(40, 3, 1, 5),
	(45, 3, 2, 5),
	(75, 1, 2, 15),
	(76, 4, 1, 30),
	(77, 4, 2, 15),
	(78, 4, 3, 10),
	(79, 4, 4, 2),
	(80, 4, 5, 20),
	(81, 3, 3, 2);

-- Listage de la structure de table sessionlecam. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `places` int NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4A76ED395` (`user_id`),
  CONSTRAINT `FK_D044D5D4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.session : ~4 rows (environ)
INSERT IGNORE INTO `session` (`id`, `name`, `description`, `date_start`, `date_end`, `places`, `user_id`) VALUES
	(1, 'Dev web', 'Ouais le web c tro b1', '2024-08-02 00:00:00', '2024-09-10 00:00:00', 12, 1),
	(2, 'Bureatique', 'Word c tro de la balle ! en plus avec j\'excelle sur Excel', '2024-07-06 00:00:00', '2024-08-17 00:00:00', 10, 2),
	(3, 'Litterature', 'Beaudelaire les fleurs du mal toussa toussa', '2023-10-03 00:00:00', '2023-10-21 00:00:00', 3, 1),
	(4, 'sfqfsqdf', 'fqsdfsdqfsqfsdqf', '2024-06-05 00:00:00', '2024-08-21 00:00:00', 20, 2);

-- Listage de la structure de table sessionlecam. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.user : ~2 rows (environ)
INSERT IGNORE INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `name`) VALUES
	(1, 'kldfsmldfsd@fds.fr', '["ROLE_USER"]', '$2y$10$fxTH/3WxTGhdpM2DNraBweMTNmRF9Q43yDYYWj9xHxlMtMmL2gP7O', 'Mickael', 'Murmann'),
	(2, 'Step@gmail.com', '["ROLE_USER"]', '$2y$10$XGzFolKK0Uh7/hlyo78ce.btmM0/PM0bAv9GdT.q9uXBHSoZStZQy', 'Stephane', 'Smail');

-- Listage de la structure de table sessionlecam. user_module_program
CREATE TABLE IF NOT EXISTS `user_module_program` (
  `user_id` int NOT NULL,
  `module_program_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`module_program_id`),
  KEY `IDX_521396C4A76ED395` (`user_id`),
  KEY `IDX_521396C4AB5D2C97` (`module_program_id`),
  CONSTRAINT `FK_521396C4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_521396C4AB5D2C97` FOREIGN KEY (`module_program_id`) REFERENCES `module_program` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sessionlecam.user_module_program : ~10 rows (environ)
INSERT IGNORE INTO `user_module_program` (`user_id`, `module_program_id`) VALUES
	(1, 1),
	(1, 3),
	(1, 4),
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(2, 5),
	(2, 6),
	(2, 7);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
