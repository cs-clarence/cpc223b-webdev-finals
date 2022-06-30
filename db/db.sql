-- MariaDB dump 10.19  Distrib 10.5.16-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: carwash
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `__applied_migrations__`
--

DROP TABLE IF EXISTS `__applied_migrations__`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `__applied_migrations__` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `applied_sql` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `__applied_migrations__`
--

LOCK TABLES `__applied_migrations__` WRITE;
/*!40000 ALTER TABLE `__applied_migrations__` DISABLE KEYS */;
INSERT INTO `__applied_migrations__` VALUES (1,'2022_06_28_14_31_17_129_129646_init','7a0810d75f1552ee608db8325e949c91088923f121c4b4723dae821acd925255','CREATE TABLE services (\n  id BIGINT PRIMARY KEY AUTO_INCREMENT,\n  name VARCHAR(255) NOT NULL,\n  fee DOUBLE NOT NULL\n);\n\nCREATE TABLE service_for_customers (\n  id BIGINT PRIMARY KEY AUTO_INCREMENT,\n  customer_name TEXT NOT NULL,\n  service TEXT NOT NULL,\n  car_type TEXT NOT NULL,\n  cash DOUBLE NOT NULL,\n  charge DOUBLE NOT NULL,\n  tip DOUBLE NOT NULL,\n  date TEXT NOT NULL,\n  time TEXT NOT NULL\n);\n\nCREATE TABLE initials (\n  id BIGINT PRIMARY KEY AUTO_INCREMENT,\n  cash DOUBLE NOT NULL,\n  date VARCHAR(32) UNIQUE NOT NULL \n);');
/*!40000 ALTER TABLE `__applied_migrations__` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `initials`
--

DROP TABLE IF EXISTS `initials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `initials` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cash` double NOT NULL,
  `date` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `initials`
--

LOCK TABLES `initials` WRITE;
/*!40000 ALTER TABLE `initials` DISABLE KEYS */;
INSERT INTO `initials` VALUES (4,1000,'2022-06-29'),(6,1500,'2022-06-30');
/*!40000 ALTER TABLE `initials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_for_customers`
--

DROP TABLE IF EXISTS `service_for_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_for_customers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customer_name` text NOT NULL,
  `service` text NOT NULL,
  `car_type` text NOT NULL,
  `cash` double NOT NULL,
  `charge` double NOT NULL,
  `tip` double NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_for_customers`
--

LOCK TABLES `service_for_customers` WRITE;
/*!40000 ALTER TABLE `service_for_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_for_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `fee` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Wash',100),(2,'Wash With Wax',150),(3,'Under Wash',200),(4,'Full Wash',300);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-30 10:18:28
