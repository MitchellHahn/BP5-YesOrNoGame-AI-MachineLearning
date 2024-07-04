-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                8.0.33 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van bp5 wordt geschreven
CREATE DATABASE IF NOT EXISTS `bp5` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bp5`;

-- Structuur van  tabel bp5.node wordt geschreven
CREATE TABLE IF NOT EXISTS `node` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(100) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpen data van tabel bp5.node: ~27 rows (ongeveer)
INSERT INTO `node` (`id`, `question`, `answer`) VALUES
	(1, 'Is the character male?', NULL),
	(2, 'Is the character a king?', NULL),
	(3, 'Is the character a queen?', NULL),
	(4, 'did he die?', NULL),
	(5, 'is he short?', NULL),
	(6, 'did she die?', NULL),
	(7, 'is she short?', NULL),
	(8, NULL, 'Tyrian Lanister'),
	(9, NULL, 'Jaime Lanister'),
	(10, NULL, 'John Snow'),
	(11, NULL, 'Joffrey Lanister'),
	(12, NULL, 'Lady Knight'),
	(13, NULL, 'Sansa Stark'),
	(14, NULL, 'Arya Stark'),
	(15, NULL, 'Daenerys Targarayen'),
	(16, 'did he sleep with one of his relatives', NULL),
	(17, 'did he get his arm cut off', NULL),
	(18, 'did he kill his sibling', NULL),
	(19, NULL, 'Bran Stark'),
	(20, NULL, 'The hound'),
	(21, NULL, 'Theon Greyjoy'),
	(22, 'did  she sleep with one of her siblings', NULL),
	(23, 'can she fly dragons', NULL),
	(24, 'did she commit suicide', NULL),
	(25, NULL, 'Cersea Lanister'),
	(26, NULL, 'Margaery Tyrrel'),
	(27, NULL, 'Olenna Tyrrel');

-- Structuur van  tabel bp5.node_history wordt geschreven
CREATE TABLE IF NOT EXISTS `node_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `node` int NOT NULL DEFAULT '0',
  `parent_node` int NOT NULL DEFAULT '0',
  `datum` date DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumpen data van tabel bp5.node_history: ~68 rows (ongeveer)
INSERT INTO `node_history` (`id`, `node`, `parent_node`, `datum`, `name`) VALUES
	(223, 21, 0, NULL, NULL),
	(224, 21, 0, NULL, NULL),
	(225, 21, 0, NULL, NULL),
	(226, 21, 0, NULL, NULL),
	(233, 21, 0, NULL, NULL),
	(237, 20, 0, NULL, NULL),
	(248, 9, 0, NULL, NULL),
	(249, 9, 0, NULL, NULL),
	(250, 9, 0, NULL, NULL),
	(251, 20, 0, NULL, NULL),
	(252, 9, 0, NULL, NULL),
	(253, 20, 0, NULL, NULL),
	(254, 20, 0, NULL, NULL),
	(255, 17, 0, NULL, NULL),
	(256, 20, 0, NULL, NULL),
	(257, 21, 0, NULL, NULL),
	(258, 20, 0, NULL, NULL),
	(259, 20, 0, NULL, NULL),
	(260, 11, 0, NULL, NULL),
	(261, 13, 0, NULL, NULL),
	(262, 14, 0, NULL, NULL),
	(263, 20, 0, NULL, NULL),
	(264, 8, 0, NULL, NULL),
	(265, 13, 0, NULL, NULL),
	(266, 13, 0, NULL, NULL),
	(267, 10, 0, NULL, NULL),
	(268, 9, 0, NULL, NULL),
	(269, 20, 0, NULL, NULL),
	(270, 20, 0, NULL, NULL),
	(271, 14, 0, NULL, NULL),
	(272, 20, 0, NULL, NULL),
	(273, 20, 0, NULL, NULL),
	(274, 20, 0, NULL, NULL),
	(275, 20, 0, NULL, NULL),
	(276, 20, 0, NULL, NULL),
	(277, 11, 0, NULL, NULL),
	(278, 11, 0, NULL, NULL),
	(279, 11, 0, NULL, NULL),
	(280, 20, 0, NULL, NULL),
	(281, 11, 0, NULL, NULL),
	(282, 8, 0, NULL, NULL),
	(283, 8, 0, NULL, NULL),
	(284, 8, 0, NULL, NULL),
	(285, 8, 0, NULL, NULL),
	(286, 8, 0, NULL, NULL),
	(287, 8, 0, NULL, NULL),
	(288, 11, 0, NULL, NULL),
	(289, 8, 0, NULL, NULL),
	(290, 8, 0, NULL, NULL),
	(291, 8, 0, NULL, NULL),
	(292, 8, 0, NULL, NULL),
	(293, 8, 0, NULL, NULL),
	(294, 20, 0, NULL, NULL),
	(295, 20, 0, NULL, NULL),
	(296, 20, 0, NULL, NULL),
	(297, 8, 0, NULL, NULL),
	(298, 11, 0, NULL, NULL),
	(299, 10, 0, NULL, NULL),
	(300, 10, 0, NULL, NULL),
	(301, 21, 0, NULL, NULL),
	(302, 8, 0, NULL, NULL),
	(303, 8, 0, NULL, NULL),
	(304, 11, 0, NULL, NULL),
	(305, 25, 0, NULL, NULL),
	(306, 11, 0, NULL, NULL),
	(307, 4, 0, NULL, NULL),
	(308, 4, 0, NULL, NULL),
	(309, 11, 0, NULL, NULL);

-- Structuur van  tabel bp5.node_relation wordt geschreven
CREATE TABLE IF NOT EXISTS `node_relation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `node_yes` int NOT NULL,
  `node_no` int NOT NULL,
  `parent_node` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relationno` (`node_no`),
  KEY `relationyes` (`node_yes`),
  KEY `parentnode` (`parent_node`),
  CONSTRAINT `parentnode` FOREIGN KEY (`parent_node`) REFERENCES `node` (`id`),
  CONSTRAINT `relationno` FOREIGN KEY (`node_no`) REFERENCES `node` (`id`),
  CONSTRAINT `relationyes` FOREIGN KEY (`node_yes`) REFERENCES `node` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpen data van tabel bp5.node_relation: ~13 rows (ongeveer)
INSERT INTO `node_relation` (`id`, `node_yes`, `node_no`, `parent_node`) VALUES
	(1, 2, 3, 1),
	(2, 4, 5, 2),
	(3, 11, 16, 4),
	(4, 10, 19, 16),
	(5, 8, 17, 5),
	(6, 9, 18, 17),
	(7, 20, 21, 18),
	(8, 6, 7, 3),
	(9, 14, 12, 7),
	(10, 22, 13, 6),
	(11, 25, 23, 22),
	(12, 15, 24, 23),
	(13, 27, 26, 24);

-- Structuur van  tabel bp5.score wordt geschreven
CREATE TABLE IF NOT EXISTS `score` (
  `id` int DEFAULT NULL,
  `naam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `score` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumpen data van tabel bp5.score: ~12 rows (ongeveer)
INSERT INTO `score` (`id`, `naam`, `score`) VALUES
	(NULL, 'Mark', 60),
	(NULL, 'Tester', 30),
	(NULL, 'Mitch', 40),
	(NULL, 'Geert', 90),
	(NULL, 'Abdul', 50),
	(NULL, 'Osama', 80),
	(NULL, 'trump', 100),
	(NULL, 'joost', 180),
	(NULL, 'Dua Lipa', 80),
	(NULL, 'Bill Ilish', 130),
	(NULL, 'Rutte4', 40),
	(NULL, 'Development', 90);

-- Structuur van  tabel bp5.smart_guess_fail_nodes wordt geschreven
CREATE TABLE IF NOT EXISTS `smart_guess_fail_nodes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `node` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=610 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

-- Dumpen data van tabel bp5.smart_guess_fail_nodes: ~106 rows (ongeveer)
INSERT INTO `smart_guess_fail_nodes` (`id`, `node`, `created_at`, `updated_at`) VALUES
	(486, 20, '2024-05-23 23:25:47', '2024-05-23 23:25:47'),
	(505, 20, '2024-05-24 09:39:21', '2024-05-24 09:39:21'),
	(506, 20, '2024-05-24 09:42:18', '2024-05-24 09:42:18'),
	(507, 20, '2024-05-24 12:54:16', '2024-05-24 12:54:16'),
	(508, 20, '2024-05-24 12:57:16', '2024-05-24 12:57:16'),
	(509, 20, '2024-05-24 13:17:36', '2024-05-24 13:17:36'),
	(510, 20, '2024-05-24 13:28:26', '2024-05-24 13:28:26'),
	(511, 20, '2024-05-24 15:17:45', '2024-05-24 15:17:45'),
	(512, 21, '2024-05-24 15:22:02', '2024-05-24 15:22:02'),
	(513, 20, '2024-05-24 15:22:59', '2024-05-24 15:22:59'),
	(514, 20, '2024-05-24 15:25:16', '2024-05-24 15:25:16'),
	(515, 20, '2024-05-24 15:30:12', '2024-05-24 15:30:12'),
	(516, 20, '2024-05-24 15:31:32', '2024-05-24 15:31:32'),
	(517, 20, '2024-05-24 15:52:04', '2024-05-24 15:52:04'),
	(518, 21, '2024-05-24 15:56:36', '2024-05-24 15:56:36'),
	(519, 21, '2024-05-24 16:01:52', '2024-05-24 16:01:52'),
	(520, 21, '2024-05-24 16:04:11', '2024-05-24 16:04:11'),
	(521, 21, '2024-05-24 16:14:50', '2024-05-24 16:14:50'),
	(522, 21, '2024-05-24 16:24:47', '2024-05-24 16:24:47'),
	(523, 20, '2024-05-24 16:25:08', '2024-05-24 16:25:08'),
	(524, 20, '2024-05-24 16:25:31', '2024-05-24 16:25:31'),
	(525, 20, '2024-05-24 16:26:56', '2024-05-24 16:26:56'),
	(526, 21, '2024-05-24 16:27:17', '2024-05-24 16:27:17'),
	(527, 20, '2024-05-24 16:28:29', '2024-05-24 16:28:29'),
	(528, 21, '2024-05-24 16:28:54', '2024-05-24 16:28:54'),
	(529, 20, '2024-05-24 16:31:03', '2024-05-24 16:31:03'),
	(530, 9, '2024-05-24 16:35:33', '2024-05-24 16:35:33'),
	(531, 20, '2024-05-24 16:36:21', '2024-05-24 16:36:21'),
	(532, 20, '2024-05-24 16:37:18', '2024-05-24 16:37:18'),
	(533, 20, '2024-05-24 16:37:40', '2024-05-24 16:37:40'),
	(534, 20, '2024-05-24 16:39:57', '2024-05-24 16:39:57'),
	(535, 21, '2024-05-24 16:40:19', '2024-05-24 16:40:19'),
	(536, 20, '2024-05-24 16:59:20', '2024-05-24 16:59:20'),
	(537, 20, '2024-05-24 17:09:14', '2024-05-24 17:09:14'),
	(538, 20, '2024-05-24 17:19:54', '2024-05-24 17:19:54'),
	(539, 21, '2024-05-24 17:20:59', '2024-05-24 17:20:59'),
	(540, 20, '2024-05-24 17:31:39', '2024-05-24 17:31:39'),
	(541, 20, '2024-05-24 17:37:15', '2024-05-24 17:37:15'),
	(542, 20, '2024-05-24 17:40:18', '2024-05-24 17:40:18'),
	(543, 20, '2024-05-24 17:47:16', '2024-05-24 17:47:16'),
	(544, 21, '2024-05-24 17:47:48', '2024-05-24 17:47:48'),
	(545, 20, '2024-05-24 17:58:14', '2024-05-24 17:58:14'),
	(546, 20, '2024-05-24 18:13:19', '2024-05-24 18:13:19'),
	(547, 20, '2024-05-24 18:14:35', '2024-05-24 18:14:35'),
	(548, 21, '2024-05-24 18:14:57', '2024-05-24 18:14:57'),
	(549, 20, '2024-05-24 18:36:29', '2024-05-24 18:36:29'),
	(550, 20, '2024-05-24 18:37:28', '2024-05-24 18:37:28'),
	(551, 20, '2024-05-24 18:39:46', '2024-05-24 18:39:46'),
	(552, 20, '2024-05-24 18:40:09', '2024-05-24 18:40:09'),
	(553, 20, '2024-05-24 18:43:38', '2024-05-24 18:43:38'),
	(554, 20, '2024-05-24 18:45:23', '2024-05-24 18:45:23'),
	(555, 20, '2024-05-24 18:47:16', '2024-05-24 18:47:16'),
	(556, 20, '2024-05-24 18:48:58', '2024-05-24 18:48:58'),
	(557, 20, '2024-05-24 18:50:42', '2024-05-24 18:50:42'),
	(558, 20, '2024-05-24 18:52:26', '2024-05-24 18:52:26'),
	(559, 20, '2024-05-24 18:58:59', '2024-05-24 18:58:59'),
	(560, 20, '2024-05-24 19:00:10', '2024-05-24 19:00:10'),
	(561, 20, '2024-05-24 19:02:36', '2024-05-24 19:02:36'),
	(562, 20, '2024-05-24 19:04:03', '2024-05-24 19:04:03'),
	(563, 20, '2024-05-24 19:05:59', '2024-05-24 19:05:59'),
	(564, 20, '2024-05-24 21:40:44', '2024-05-24 21:40:44'),
	(565, 20, '2024-05-24 22:03:09', '2024-05-24 22:03:09'),
	(566, 21, '2024-05-24 22:03:40', '2024-05-24 22:03:40'),
	(567, 20, '2024-05-24 22:21:50', '2024-05-24 22:21:50'),
	(568, 20, '2024-05-24 23:04:37', '2024-05-24 23:04:37'),
	(569, 20, '2024-05-24 23:09:25', '2024-05-24 23:09:25'),
	(570, 20, '2024-05-24 23:16:19', '2024-05-24 23:16:19'),
	(571, 20, '2024-05-24 23:38:06', '2024-05-24 23:38:06'),
	(572, 20, '2024-05-24 23:47:15', '2024-05-24 23:47:15'),
	(573, 20, '2024-05-24 23:52:21', '2024-05-24 23:52:21'),
	(574, 20, '2024-05-24 23:55:19', '2024-05-24 23:55:19'),
	(575, 20, '2024-05-25 00:11:59', '2024-05-25 00:11:59'),
	(576, 20, '2024-05-25 00:23:49', '2024-05-25 00:23:49'),
	(577, 21, '2024-05-25 00:24:26', '2024-05-25 00:24:26'),
	(578, 20, '2024-05-25 00:25:54', '2024-05-25 00:25:54'),
	(579, 20, '2024-05-25 00:31:28', '2024-05-25 00:31:28'),
	(580, 20, '2024-05-25 01:00:52', '2024-05-25 01:00:52'),
	(581, 21, '2024-05-25 01:01:58', '2024-05-25 01:01:58'),
	(582, 20, '2024-05-25 01:06:05', '2024-05-25 01:06:05'),
	(583, 20, '2024-05-25 01:10:54', '2024-05-25 01:10:54'),
	(584, 20, '2024-05-25 01:11:14', '2024-05-25 01:11:14'),
	(585, 20, '2024-05-25 01:28:50', '2024-05-25 01:28:50'),
	(586, 20, '2024-05-25 01:33:15', '2024-05-25 01:33:15'),
	(587, 20, '2024-05-25 01:33:42', '2024-05-25 01:33:42'),
	(588, 20, '2024-05-25 01:34:18', '2024-05-25 01:34:18'),
	(589, 20, '2024-05-25 01:38:39', '2024-05-25 01:38:39'),
	(590, 20, '2024-05-25 01:39:11', '2024-05-25 01:39:11'),
	(591, 20, '2024-05-25 01:48:50', '2024-05-25 01:48:50'),
	(592, 20, '2024-05-25 01:55:58', '2024-05-25 01:55:58'),
	(593, 20, '2024-05-25 01:56:27', '2024-05-25 01:56:27'),
	(594, 20, '2024-05-25 02:46:06', '2024-05-25 02:46:06'),
	(595, 20, '2024-05-25 02:50:34', '2024-05-25 02:50:34'),
	(596, 20, '2024-05-25 03:01:29', '2024-05-25 03:01:29'),
	(597, 20, '2024-05-25 03:01:48', '2024-05-25 03:01:48'),
	(598, 20, '2024-05-25 03:20:50', '2024-05-25 03:20:50'),
	(599, 20, '2024-05-25 03:21:27', '2024-05-25 03:21:27'),
	(600, 20, '2024-05-25 03:22:28', '2024-05-25 03:22:28'),
	(601, 20, '2024-05-25 03:22:57', '2024-05-25 03:22:57'),
	(602, 20, '2024-05-25 03:47:12', '2024-05-25 03:47:12'),
	(603, 20, '2024-05-25 03:47:51', '2024-05-25 03:47:51'),
	(604, 21, '2024-05-29 16:32:15', '2024-05-29 16:32:15'),
	(605, 21, '2024-05-29 16:33:13', '2024-05-29 16:33:13'),
	(606, 21, '2024-05-29 23:51:28', '2024-05-29 23:51:28'),
	(607, 21, '2024-05-30 00:05:45', '2024-05-30 00:05:45'),
	(608, 21, '2024-05-30 00:17:16', '2024-05-30 00:17:16'),
	(609, 21, '2024-05-30 01:11:11', '2024-05-30 01:11:11');

-- Structuur van  tabel bp5.smart_guess_success_nodes wordt geschreven
CREATE TABLE IF NOT EXISTS `smart_guess_success_nodes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `node` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumpen data van tabel bp5.smart_guess_success_nodes: ~12 rows (ongeveer)
INSERT INTO `smart_guess_success_nodes` (`id`, `node`, `created_at`, `updated_at`) VALUES
	(185, 9, '2024-05-21 09:11:42', '2024-05-21 09:11:42'),
	(189, 20, '2024-05-21 09:17:50', '2024-05-21 09:17:50'),
	(190, 20, '2024-05-21 12:14:23', '2024-05-21 12:14:23'),
	(191, 20, '2024-05-21 12:14:31', '2024-05-21 12:14:31'),
	(192, 20, '2024-05-21 12:14:55', '2024-05-21 12:14:55'),
	(193, 20, '2024-05-22 02:50:59', '2024-05-22 02:50:59'),
	(194, 11, '2024-05-22 03:01:22', '2024-05-22 03:01:22'),
	(195, 11, '2024-05-25 02:08:32', '2024-05-25 02:08:32'),
	(197, 10, '2024-05-25 03:07:33', '2024-05-25 03:07:33'),
	(198, 11, '2024-05-29 17:51:42', '2024-05-29 17:51:42'),
	(199, 11, '2024-05-30 00:29:50', '2024-05-30 00:29:50'),
	(202, 11, '2024-05-30 00:43:04', '2024-05-30 00:43:04');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
