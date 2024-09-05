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
