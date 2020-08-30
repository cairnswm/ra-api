-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.10-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


DROP TABLE `users`;

-- Dumping structure for table raapi_test.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `address` varchar(50) NOT NULL DEFAULT '0',
  `age` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table raapi_test.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `address`, `age`, `level`) VALUES
	(1, 'William', '0', 50, 5),
	(2, 'Yolande', '50', 50, 6),
	(3, 'Loreley', '0', 24, 4),
	(4, 'Kaylen', '0', 22, 2),
	(5, 'Gawain', '0', 19, 2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table raapi_test.level
CREATE TABLE IF NOT EXISTS `level` (
  `unid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`unid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table raapi_test.level: ~0 rows (approximately)
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` (`unid`, `id`, `name`) VALUES
	(1, 0, 'Beginner'),
	(2, 1, 'Level 1'),
	(3, 2, 'Lvl 2'),
	(4, 3, 'Intermediate'),
	(5, 4, 'Expert'),
	(6, 5, 'Pro');
/*!40000 ALTER TABLE `level` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
