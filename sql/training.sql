-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: training
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `checkin`
--

DROP TABLE IF EXISTS `checkin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainee_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_E1631C9136C682D0` (`trainee_id`),
  KEY `IDX_E1631C91BEFD98D1` (`training_id`),
  CONSTRAINT `FK_E1631C9136C682D0` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`id`),
  CONSTRAINT `FK_E1631C91BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkin`
--

LOCK TABLES `checkin` WRITE;
/*!40000 ALTER TABLE `checkin` DISABLE KEYS */;
INSERT INTO `checkin` VALUES (1,1,2,'2021-03-10 09:40:16'),(3,2,2,'2021-03-11 15:11:58'),(4,2,1,'2021-03-11 16:01:55');
/*!40000 ALTER TABLE `checkin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210310000811','2021-03-10 00:08:16',748),('DoctrineMigrations\\Version20210310005619','2021-03-10 00:56:22',573),('DoctrineMigrations\\Version20210310010627','2021-03-10 01:06:33',56),('DoctrineMigrations\\Version20210310012352','2021-03-10 01:23:55',202),('DoctrineMigrations\\Version20210310015243','2021-03-10 01:52:48',139),('DoctrineMigrations\\Version20210311035627','2021-03-11 03:56:31',63),('DoctrineMigrations\\Version20210311040449','2021-03-11 04:04:55',53),('DoctrineMigrations\\Version20210311041358','2021-03-11 04:14:02',567),('DoctrineMigrations\\Version20210311050843','2021-03-11 05:36:18',208),('DoctrineMigrations\\Version20210311061106','2021-03-11 06:13:19',184),('DoctrineMigrations\\Version20210311061513','2021-03-11 06:15:19',199),('DoctrineMigrations\\Version20210311095230','2021-03-11 09:52:43',213),('DoctrineMigrations\\Version20210311202027','2021-03-11 20:20:30',54);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'计划中'),(2,'进行中'),(3,'暂停'),(4,'取消'),(5,'结束');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainee`
--

DROP TABLE IF EXISTS `trainee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trainee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pstatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `politics` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idnum` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:simple_array)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainee`
--

LOCK TABLES `trainee` WRITE;
/*!40000 ALTER TABLE `trainee` DISABLE KEYS */;
INSERT INTO `trainee` VALUES (1,'学员1',26,'0','0','1','1','13211111111','42036648956325','宝丰镇宝丰村','0,2','image.png',NULL),(2,'学员2',27,'0','2','0','0',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `trainee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainee_training`
--

DROP TABLE IF EXISTS `trainee_training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trainee_training` (
  `trainee_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  PRIMARY KEY (`trainee_id`,`training_id`),
  KEY `IDX_1B77F00636C682D0` (`trainee_id`),
  KEY `IDX_1B77F006BEFD98D1` (`training_id`),
  CONSTRAINT `FK_1B77F00636C682D0` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1B77F006BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainee_training`
--

LOCK TABLES `trainee_training` WRITE;
/*!40000 ALTER TABLE `trainee_training` DISABLE KEYS */;
INSERT INTO `trainee_training` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(2,1);
/*!40000 ALTER TABLE `trainee_training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainer`
--

DROP TABLE IF EXISTS `trainer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trainer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainer`
--

LOCK TABLES `trainer` WRITE;
/*!40000 ALTER TABLE `trainer` DISABLE KEYS */;
INSERT INTO `trainer` VALUES (1,'王教官'),(2,'张教官'),(3,'李教官');
/*!40000 ALTER TABLE `trainer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainer_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `instructor` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5128A8FFB08EDF6` (`trainer_id`),
  KEY `IDX_D5128A8F6BF700BD` (`status_id`),
  CONSTRAINT `FK_D5128A8F6BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `FK_D5128A8FFB08EDF6` FOREIGN KEY (`trainer_id`) REFERENCES `trainer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` VALUES (1,1,1,'训练1','训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训练1训1训练1训练1训练1训练1训练1训练1训练','2021-03-10 09:24:05','2021-03-11 00:00:00','2021-03-24 00:00:00','王教官'),(2,1,2,'训练2','1safsafsafsaf','2021-03-10 09:35:29','2021-03-11 00:00:00','2021-03-24 00:00:00',''),(3,2,3,'训练4','safsafsadfsadfsadfafsad','2021-03-11 13:36:23','2021-03-11 00:00:00','2021-03-18 00:00:00',''),(4,3,3,'训练5','训练5训练5','2021-03-11 13:37:36','2021-03-13 00:00:00','2021-03-18 00:00:00',''),(5,1,2,'训练6','训练6','2021-03-11 13:38:08','2021-03-11 00:00:00','2021-03-10 00:00:00','王教官'),(6,1,1,'训练7','训练7训练7训练7','2021-03-11 13:42:30','2021-03-12 00:00:00','2021-03-18 00:00:00',''),(7,1,2,'训练8','训练8训练8','2021-03-11 14:09:53','2021-03-12 00:00:00','2021-03-10 00:00:00','王教官'),(8,2,1,'训练9','训练9训练9','2021-03-11 15:21:20','2021-03-09 00:00:00','2021-03-18 00:00:00','');
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-12 13:45:30
