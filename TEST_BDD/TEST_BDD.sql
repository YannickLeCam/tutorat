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


-- Listage de la structure de la base pour tutorat
CREATE DATABASE IF NOT EXISTS `tutorat` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tutorat`;

-- Listage de la structure de table tutorat. direction
CREATE TABLE IF NOT EXISTS `direction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculte_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E4AD1B372C3434F` (`faculte_id`),
  CONSTRAINT `FK_3E4AD1B372C3434F` FOREIGN KEY (`faculte_id`) REFERENCES `faculte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.direction : ~2 rows (environ)
DELETE FROM `direction`;
INSERT INTO `direction` (`id`, `nom`, `prenom`, `faculte_id`) VALUES
	(1, 'Lecieux', 'Charlotte', 1),
	(2, 'Alex', 'Le Lion', 1);

-- Listage de la structure de table tutorat. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table tutorat.doctrine_migration_versions : ~4 rows (environ)
DELETE FROM `doctrine_migration_versions`;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20240820233902', '2024-08-20 23:39:18', 1533),
	('DoctrineMigrations\\Version20240823172530', '2024-08-23 17:25:45', 77),
	('DoctrineMigrations\\Version20240825234455', '2024-08-25 23:45:15', 743),
	('DoctrineMigrations\\Version20240826124411', '2024-08-26 12:44:23', 364),
	('DoctrineMigrations\\Version20240830231849', '2024-08-30 23:19:05', 287),
	('DoctrineMigrations\\Version20240830232713', '2024-08-30 23:27:19', 125);

-- Listage de la structure de table tutorat. faculte
CREATE TABLE IF NOT EXISTS `faculte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.faculte : ~2 rows (environ)
DELETE FROM `faculte`;
INSERT INTO `faculte` (`id`, `name`) VALUES
	(1, 'Lyon'),
	(2, 'Grenoble');

-- Listage de la structure de table tutorat. filleul
CREATE TABLE IF NOT EXISTS `filleul` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mineure_id` int NOT NULL,
  `specialite_id` int NOT NULL,
  `parrain_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculte_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F9383CF66B9354C` (`mineure_id`),
  KEY `IDX_2F9383CF2195E0F0` (`specialite_id`),
  KEY `IDX_2F9383CFDE2A7A37` (`parrain_id`),
  KEY `IDX_2F9383CF72C3434F` (`faculte_id`),
  CONSTRAINT `FK_2F9383CF2195E0F0` FOREIGN KEY (`specialite_id`) REFERENCES `specialite` (`id`),
  CONSTRAINT `FK_2F9383CF66B9354C` FOREIGN KEY (`mineure_id`) REFERENCES `mineure` (`id`),
  CONSTRAINT `FK_2F9383CF72C3434F` FOREIGN KEY (`faculte_id`) REFERENCES `faculte` (`id`),
  CONSTRAINT `FK_2F9383CFDE2A7A37` FOREIGN KEY (`parrain_id`) REFERENCES `parrain` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.filleul : ~5 rows (environ)
DELETE FROM `filleul`;
INSERT INTO `filleul` (`id`, `mineure_id`, `specialite_id`, `parrain_id`, `nom`, `prenom`, `mail`, `telephone`, `faculte_id`) VALUES
	(1, 1, 1, 1, 'TestFilleul', 'Filleul', 'Filleul@test.fr', '0606060606', 1),
	(2, 1, 1, 1, 'Test2', 'Fileul2', 'Filleul2@test.fr', '0607070707', 1),
	(3, 1, 1, 1, 'Lecieu', 'Maurice', 'maurice.lecieux@gmail.com', '0615485325', 1),
	(4, 3, 1, 2, 'Sockos', 'Pierre', 'Sockos.waouh@gmail.com', '065425183625', 1),
	(5, 1, 1, 1, 'a', 'a', 'aaa@gmrdkjg.fr', '0626532655', 1);

-- Listage de la structure de table tutorat. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.messenger_messages : ~1 rows (environ)
DELETE FROM `messenger_messages`;
INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":5:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:165:\\"http://127.0.0.1:8000/verify/email?expires=1724259428&signature=umM6bgfHebPk3x0fUc28w8z5Hl9jz5PZyvY3Ud5sbE4%3D&token=9InMst4UySMbAO2jViuqHgwPH5HgVdzpbGTEgMMI5%2BM%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:16:\\"tutorat@lyon.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:6:\\"Duriff\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:11:\\"top@test.fr\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}i:4;N;}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2024-08-21 15:57:08', '2024-08-21 15:57:08', NULL);

-- Listage de la structure de table tutorat. mineure
CREATE TABLE IF NOT EXISTS `mineure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.mineure : ~3 rows (environ)
DELETE FROM `mineure`;
INSERT INTO `mineure` (`id`, `name`) VALUES
	(1, 'Math'),
	(2, 'Physique'),
	(3, 'Ntm');

-- Listage de la structure de table tutorat. parrain
CREATE TABLE IF NOT EXISTS `parrain` (
  `id` int NOT NULL AUTO_INCREMENT,
  `top_id` int DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculte_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A7A835B4C82CB256` (`top_id`),
  KEY `IDX_A7A835B472C3434F` (`faculte_id`),
  CONSTRAINT `FK_A7A835B472C3434F` FOREIGN KEY (`faculte_id`) REFERENCES `faculte` (`id`),
  CONSTRAINT `FK_A7A835B4C82CB256` FOREIGN KEY (`top_id`) REFERENCES `top` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.parrain : ~3 rows (environ)
DELETE FROM `parrain`;
INSERT INTO `parrain` (`id`, `top_id`, `nom`, `prenom`, `faculte_id`) VALUES
	(1, 1, 'TestParrain', 'Parrain', 1),
	(2, 1, 'Parrain2', 'Jesuisparrain', 1),
	(3, 2, 'Hubert', 'Louis', 1);

-- Listage de la structure de table tutorat. parrain_appreciation
CREATE TABLE IF NOT EXISTS `parrain_appreciation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filleul_id` int DEFAULT NULL,
  `parrain_id` int NOT NULL,
  `appreciation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `humeur` int NOT NULL,
  `travail` int NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ED95151D851A1D14` (`filleul_id`),
  KEY `IDX_ED95151DDE2A7A37` (`parrain_id`),
  CONSTRAINT `FK_ED95151D851A1D14` FOREIGN KEY (`filleul_id`) REFERENCES `filleul` (`id`),
  CONSTRAINT `FK_ED95151DDE2A7A37` FOREIGN KEY (`parrain_id`) REFERENCES `parrain` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.parrain_appreciation : ~3 rows (environ)
DELETE FROM `parrain_appreciation`;
INSERT INTO `parrain_appreciation` (`id`, `filleul_id`, `parrain_id`, `appreciation`, `humeur`, `travail`, `date_creation`) VALUES
	(1, 1, 1, 'Oué trop coool ce filleul mais un peu con', 4, 3, '2024-08-23'),
	(2, 2, 1, 'dazdad', 5, 1, '2024-08-25'),
	(3, 1, 1, 'Oué tjr cool lui et en plus il a apprit', 1, 5, '2024-08-25');

-- Listage de la structure de table tutorat. specialite
CREATE TABLE IF NOT EXISTS `specialite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.specialite : ~0 rows (environ)
DELETE FROM `specialite`;
INSERT INTO `specialite` (`id`, `name`) VALUES
	(1, 'Pharma');

-- Listage de la structure de table tutorat. top
CREATE TABLE IF NOT EXISTS `top` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculte_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1ED91FCA72C3434F` (`faculte_id`),
  CONSTRAINT `FK_1ED91FCA72C3434F` FOREIGN KEY (`faculte_id`) REFERENCES `faculte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.top : ~2 rows (environ)
DELETE FROM `top`;
INSERT INTO `top` (`id`, `nom`, `prenom`, `faculte_id`) VALUES
	(1, 'TestTop', 'Toptop', 1),
	(2, 'Top2', 'fsef', 1);

-- Listage de la structure de table tutorat. top_appreciation
CREATE TABLE IF NOT EXISTS `top_appreciation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filleul_id` int DEFAULT NULL,
  `top_id` int DEFAULT NULL,
  `appreciation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12CE7B70851A1D14` (`filleul_id`),
  KEY `IDX_12CE7B70C82CB256` (`top_id`),
  CONSTRAINT `FK_12CE7B70851A1D14` FOREIGN KEY (`filleul_id`) REFERENCES `filleul` (`id`),
  CONSTRAINT `FK_12CE7B70C82CB256` FOREIGN KEY (`top_id`) REFERENCES `top` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.top_appreciation : ~1 rows (environ)
DELETE FROM `top_appreciation`;
INSERT INTO `top_appreciation` (`id`, `filleul_id`, `top_id`, `appreciation`, `date_creation`) VALUES
	(1, 4, 1, 'jkdngkqldsngqs', '2024-08-31');

-- Listage de la structure de table tutorat. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `id_role` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tutorat.user : ~5 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `id_role`) VALUES
	(2, 'top@test.fr', '["ROLE_TOP"]', '$2y$13$BO.ZE3j4SOpzX/7/ZBJRNOkmzt444cp9HpybtumWCRso7l7OK6z1a', 0, 1),
	(3, 'parrain@test.fr', '["ROLE_PARRAIN"]', '$2y$13$/m0hAa00Be0759B4mas/yO1IORG3LpuJBs2TWAmo4IklosUweUBUK', 0, 1),
	(4, 'parrain2@test.fr', '["ROLE_PARRAIN"]', '$2y$13$6kM19X5oSeOxlM0eR9RZrucFDIMcYWM6X15Te98zmOv.XuP/bI2jm', 0, 2),
	(5, 'admin@test.fr', '["ROLE_DIRECTION", "ROLE_ADMIN"]', '$2y$13$nVZ3zxQpn7Hd.3Kg5hY8XuET.hH.HsI7ObRoq/Zvee9HJhEDYP2Om', 0, 1),
	(6, 'direction@test.fr', '["ROLE_DIRECTION"]', '$2y$13$Lx0qmFtgud0s0OfBBaJ9fOU0xjyUyeoMe2jG/Ueg4fAAtonFnl7uu', 0, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
