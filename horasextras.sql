-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: horasextras
-- ------------------------------------------------------
-- Server version	10.1.34-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auditorias`
--

DROP TABLE IF EXISTS `auditorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_user_cargo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `diurnas` int(3) NOT NULL,
  `nocturnas` int(3) NOT NULL,
  `dominicales` int(3) NOT NULL,
  `nocturnos` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditorias`
--

LOCK TABLES `auditorias` WRITE;
/*!40000 ALTER TABLE `auditorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo_user`
--

DROP TABLE IF EXISTS `cargo_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `cargo_id` int(10) NOT NULL,
  `estado` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_id`),
  KEY `id_cargo` (`cargo_id`),
  CONSTRAINT `cargo_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `cargo_user_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo_user`
--

LOCK TABLES `cargo_user` WRITE;
/*!40000 ALTER TABLE `cargo_user` DISABLE KEYS */;
INSERT INTO `cargo_user` VALUES (1,5,1,1,'2020-03-04 21:39:21','2020-03-04 21:39:21'),(7,12,1,1,'2020-03-09 19:45:33','2020-03-09 19:45:33');
/*!40000 ALTER TABLE `cargo_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `sueldo` double NOT NULL,
  `valor_diurna` double NOT NULL,
  `valor_nocturna` double NOT NULL,
  `valor_dominical` double NOT NULL,
  `valor_recargo` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` VALUES (1,'cargo de prueba',676575757.1,5000,500,50,50001,'2020-03-09 19:52:19','2020-03-10 00:52:19'),(21,'prueba prueba',343434,3434,341,1212,2424,'2020-02-28 22:09:34','2020-02-28 22:09:34'),(22,'prueba2',3456789,4567,3232,2323,232323,'2020-03-09 18:14:48','2020-03-09 18:14:48');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horas`
--

DROP TABLE IF EXISTS `horas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_cargo` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tipo_hora` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id_user_cargo` (`id_user_cargo`),
  CONSTRAINT `horas_ibfk_1` FOREIGN KEY (`id_user_cargo`) REFERENCES `cargo_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horas`
--

LOCK TABLES `horas` WRITE;
/*!40000 ALTER TABLE `horas` DISABLE KEYS */;
INSERT INTO `horas` VALUES (1,7,'2020-01-11','06:23:00','18:24:00',2,'2020-03-13 03:26:46','2020-03-13 03:26:46'),(14,7,'2020-01-11','11:43:00','16:44:00',1,'2020-03-13 21:05:49','2020-03-13 21:05:49'),(15,7,'2020-01-11','11:43:00','13:44:00',2,'2020-03-13 21:16:33','2020-03-13 21:16:33'),(16,7,'2020-01-11','11:43:00','14:44:00',2,'2020-03-13 21:16:57','2020-03-13 21:16:57'),(17,7,'2020-01-11','11:43:00','15:44:00',2,'2020-03-13 21:19:34','2020-03-13 21:19:34'),(18,7,'2020-01-11','11:43:00','17:44:00',2,'2020-03-13 21:19:43','2020-03-13 21:19:43'),(19,7,'2020-01-18','00:29:00','06:29:00',2,'2020-03-13 21:28:44','2020-03-13 21:28:44'),(20,7,'2020-01-12','09:30:00','11:30:00',2,'2020-03-13 21:29:46','2020-03-13 21:29:46'),(21,7,'2020-01-11','13:31:00','14:32:00',1,'2020-03-13 21:30:59','2020-03-13 21:30:59'),(22,7,'2020-01-31','05:56:00','07:56:00',2,'2020-03-14 03:08:45','2020-03-14 03:08:45'),(23,7,'2020-01-31','09:00:00','10:30:00',3,'2020-03-14 03:11:20','2020-03-14 03:11:20');
/*!40000 ALTER TABLE `horas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('alkonia1@hotmail.com','$2y$10$BpRSyk.7BnKerFiMvTis4ecbzIlMoHDLJwc5IYcb3nKjrJT/8DB.S','2020-02-27 03:25:39');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','2020-02-27 19:59:37','0000-00-00 00:00:00'),(2,'Funcionario','2020-02-27 19:59:37','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documento` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `centro` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) NOT NULL,
  `estado` int(1) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'123456789','Cédula de Ciudadanía','Prueba','Prueba','CEAI','VALLE','prueba@yopmail.com','232212',1,1,'$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6','BJq58CZNyXVq6nyvnT1u4Df2b1kV6hKjTYcM7Vby90QYaVXaD9qGdX0D1MYD',NULL,'2020-03-09 18:18:02'),(12,'42343243','Cédula de Ciudadanía','prueba prueba','prueba','CEAI','VALLE','hotmail@hotmaill.com','2323232',2,1,'$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6',NULL,'2020-03-09 19:45:33','2020-03-10 00:51:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-13 17:14:16
