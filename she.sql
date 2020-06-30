-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: she
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `cargo_user`
--

DROP TABLE IF EXISTS `cargo_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargo_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Foránea que identifica al usuario',
  `cargo_id` int(10) NOT NULL COMMENT 'Foránea que identifica el cargo',
  `estado` int(1) NOT NULL COMMENT 'Si el cargo se encuentra vigente en el usuario (solo puede tener un cargo vigente a la vez)',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_id`),
  KEY `id_cargo` (`cargo_id`),
  CONSTRAINT `cargo_user_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`),
  CONSTRAINT `cargo_user_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registra cada cargo de cada usuario';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo_user`
--

LOCK TABLES `cargo_user` WRITE;
/*!40000 ALTER TABLE `cargo_user` DISABLE KEYS */;
INSERT INTO `cargo_user` VALUES (1,1,0,1,'0000-00-00 00:00:00','2020-06-30 18:29:59'),(2,2,0,1,'0000-00-00 00:00:00','2020-06-30 18:29:09');
/*!40000 ALTER TABLE `cargo_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargos` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del cargo',
  `sueldo` double DEFAULT NULL COMMENT 'Sueldo del cargo',
  `valor_diurna` double DEFAULT NULL COMMENT 'Valor de la hora diurna del cargo',
  `valor_nocturna` double DEFAULT NULL COMMENT 'Valor de la hora nocturna del cargo',
  `valor_dominical` double DEFAULT NULL COMMENT 'Valor de la hora de festivos y dominicales del cargo',
  `valor_recargo` double DEFAULT NULL COMMENT 'Valor de la hora del recargo nocturno del cargo',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registran la información de cada cargo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` VALUES (0,'Administrador',NULL,NULL,NULL,NULL,NULL,'2020-06-19 19:39:50','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fechas_especiales`
--

DROP TABLE IF EXISTS `fechas_especiales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fechas_especiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `fecha` date NOT NULL COMMENT 'Fecha que identifica la fecha especial',
  `descripcion` varchar(50) NOT NULL COMMENT 'Nombre que identifica la fecha especial',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de creación',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registran la información de fechas especiales para las horas dominicales y festivas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fechas_especiales`
--

LOCK TABLES `fechas_especiales` WRITE;
/*!40000 ALTER TABLE `fechas_especiales` DISABLE KEYS */;
INSERT INTO `fechas_especiales` VALUES (1,'2019-08-07','Batalla de Boyacá 2019','2020-06-23 00:01:57','2020-06-24 19:03:23'),(2,'2019-07-01','San Pedro y San Pablo 2019\r','2020-06-23 00:01:58',NULL),(3,'2019-07-20','Día de la Independencia 2019\r','2020-06-23 00:01:59',NULL),(4,'2019-08-19','La asunción de la Virgen 2019\r','2020-06-23 00:02:00',NULL),(5,'2019-10-14','Día de la Raza 2019\r','2020-06-23 00:02:01',NULL),(6,'2019-11-04','Todos los santos 2019\r','2020-06-23 00:02:02',NULL),(7,'2019-11-11','Independencia Cartagena 2019\r','2020-06-23 00:02:02',NULL),(8,'2020-01-01','Año nuevo 2020\r','2020-06-23 00:02:03',NULL),(9,'2020-01-06','Dia de reyes 2020\r','2020-06-23 00:02:04',NULL),(10,'2020-03-23','Día de San José 2020\r','2020-06-23 00:02:05',NULL),(11,'2020-04-09','Jueves Santo 2020\r','2020-06-23 00:02:05',NULL),(12,'2020-04-10','Viernes Santo 2020\r','2020-06-23 00:02:06',NULL),(13,'2020-05-01','Día de trabajo 2020\r','2020-06-23 00:02:07',NULL),(14,'2020-05-25','Día de la Ascención 2020\r','2020-06-23 00:02:07',NULL),(15,'2020-06-15','Corpus Christi 2020\r','2020-06-23 00:02:08',NULL),(16,'2020-06-22','Sagrado Corazón 2020\r','2020-06-23 00:02:08',NULL),(17,'2020-06-29','San Pedro y San Pablo 2020\r','2020-06-23 00:02:09',NULL),(18,'2020-07-20','Día de la Independencia 2020\r','2020-06-23 00:02:10',NULL),(19,'2020-08-07','Batalla de Boyacá 2020\r','2020-06-23 00:02:11',NULL),(20,'2020-08-17','La Asunción de la Virgen 2020\r','2020-06-23 00:02:11',NULL),(21,'2020-10-12','Día de la Raza 2020\r','2020-06-23 00:02:12',NULL),(22,'2020-11-02','Todos los santos 2020\r','2020-06-23 00:02:13',NULL),(23,'2020-11-16','Independencia Cartagena 2020\r','2020-06-23 00:02:13',NULL),(24,'2020-12-08','Día de la Inmaculada Concepción 2020\r','2020-06-23 00:02:16',NULL),(25,'2020-12-25','Día de Navidad 2020\r','2020-06-23 00:02:14',NULL);
/*!40000 ALTER TABLE `fechas_especiales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horas`
--

DROP TABLE IF EXISTS `horas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `solicitud_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Cabecera de la hora extra',
  `fecha` date NOT NULL COMMENT 'Fecha de ejecución de hora extra',
  `hi_registrada` time NOT NULL COMMENT 'Hora inicial de la hora extra',
  `hf_registrada` time NOT NULL COMMENT 'Hora fin de la hora extra',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  KEY `horas_ibfk_6` (`solicitud_id`),
  CONSTRAINT `horas_ibfk_6` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registran las horas extras realizadas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horas`
--

LOCK TABLES `horas` WRITE;
/*!40000 ALTER TABLE `horas` DISABLE KEYS */;
/*!40000 ALTER TABLE `horas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presupuestos`
--

DROP TABLE IF EXISTS `presupuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `presupuesto_inicial` double NOT NULL COMMENT 'Presupuesto inicial ',
  `presupuesto_gastado` double DEFAULT NULL COMMENT 'Cantidad de presupuesto gastado',
  `mes` varchar(10) NOT NULL DEFAULT '0' COMMENT 'Mes del presupuesto',
  `año` varchar(10) NOT NULL DEFAULT '0' COMMENT 'Año del presupuesto',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registran los presupuestos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presupuestos`
--

LOCK TABLES `presupuestos` WRITE;
/*!40000 ALTER TABLE `presupuestos` DISABLE KEYS */;
/*!40000 ALTER TABLE `presupuestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) NOT NULL COMMENT 'Campo único consecutivo',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre que identifica al rol',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registra la información de cada rol del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','2020-02-27 19:59:37','0000-00-00 00:00:00'),(2,'Funcionario','2020-02-27 19:59:37','0000-00-00 00:00:00'),(3,'Instructor','2020-06-19 21:17:15','0000-00-00 00:00:00'),(4,'Coordinador','2020-06-19 21:17:37','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `presupuesto_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Foránea que identifica el presupuesto',
  `tipo_hora_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Foránea que identifica el tipo de hora',
  `cargo_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foránea que identifica el cargo y el usuario que hizo la solicitud',
  `total_horas` double NOT NULL DEFAULT '0' COMMENT 'Cantidad de horas de la solicitud',
  `hora_inicio` time NOT NULL DEFAULT '00:00:00' COMMENT 'Hora inicio de la solicitud',
  `hora_fin` time NOT NULL COMMENT 'Hora fin de la solicitud',
  `actividades` varchar(255) NOT NULL COMMENT 'Actividades a ejecutar del funcionaro durante las horas extras',
  `created_by` int(11) NOT NULL COMMENT 'Usuario que creo la solicitud',
  `autorizacion` int(11) DEFAULT '0' COMMENT 'Usuario que autorizo la solicitud',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de creación',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  KEY `presupuesto_id` (`presupuesto_id`),
  KEY `cargo_user_id` (`cargo_user_id`),
  KEY `solicitudes_ibfk_2` (`tipo_hora_id`),
  CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`),
  CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`tipo_hora_id`) REFERENCES `tipo_horas` (`id`),
  CONSTRAINT `solicitudes_ibfk_3` FOREIGN KEY (`cargo_user_id`) REFERENCES `cargo_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registran las solicitudes de cada cargo_usuario y siendo la cabecera de horas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes`
--

LOCK TABLES `solicitudes` WRITE;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_horas`
--

DROP TABLE IF EXISTS `tipo_horas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_horas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `nombre_hora` varchar(50) NOT NULL DEFAULT '' COMMENT 'Nombre que identifica al tipo de hora',
  `hora_inicio` time NOT NULL COMMENT 'Hora inicial del tipo de hora',
  `hora_fin` time NOT NULL COMMENT 'Hora fin del tipo de hora',
  `tipo_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Tipo que identifica el tipo de hora',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  KEY `FK_tipo_horas_tipos` (`tipo_id`),
  CONSTRAINT `FK_tipo_horas_tipos` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registra la información de cada tipo de hora';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_horas`
--

LOCK TABLES `tipo_horas` WRITE;
/*!40000 ALTER TABLE `tipo_horas` DISABLE KEYS */;
INSERT INTO `tipo_horas` VALUES (1,'Diurnas(mañana)','06:00:00','12:00:00',1,'2020-06-27 19:24:55','2020-04-15 19:25:26'),(2,'Diurnas(tarde)','14:00:00','16:00:00',1,'2020-06-22 22:57:12','2020-06-23 03:57:12'),(3,'Nocturnas(noche)','18:00:00','22:00:00',2,'2020-06-19 22:47:21','2020-04-15 03:55:44'),(4,'Nocturnas(madrugada)','00:00:00','06:00:00',2,'2020-06-19 22:47:22','0000-00-00 00:00:00'),(5,'Recargo nocturno(noche)','18:00:00','22:00:00',3,'2020-06-19 22:47:23','2020-04-15 03:56:23'),(6,'Recargo nocturno(madrugada)','00:00:00','06:00:00',3,'2020-06-19 22:47:24','0000-00-00 00:00:00'),(7,'Dominicales y festivos','00:00:00','00:00:00',4,'2020-06-19 22:47:24','2020-04-14 22:00:29');
/*!40000 ALTER TABLE `tipo_horas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos`
--

DROP TABLE IF EXISTS `tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos` (
  `id` int(11) NOT NULL COMMENT 'Campo único consecutivo',
  `descripcion` varchar(50) DEFAULT NULL COMMENT 'Nombre de tipo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Es la tabla donde se registra cada tipo para el tipo de hora';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos`
--

LOCK TABLES `tipos` WRITE;
/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` VALUES (1,'Diurno'),(2,'Nocturno'),(3,'Recargo nocturno'),(4,'Dominicales y festivos');
/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Campo único consecutivo',
  `documento` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Número de documento único',
  `tipo_documento` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tipo de documento del usuario',
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombres completos del usuario',
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Apellidos completos del usuario',
  `centro` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Centro del usuario',
  `regional` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Regional del usuario',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Correo electrónico',
  `telefono` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Teléfono del usuario',
  `role_id` int(10) NOT NULL COMMENT 'Rol del usuario',
  `estado` int(1) NOT NULL COMMENT 'Estado del usuario si se encuentra habilitado para iniciar sesión o no',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contraseña encriptada del usuario',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Token del usuario al presionar "Recordarme"',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de creación',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Fecha de última actualización',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Es la tabla donde se registran los usuarios del sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'34547371','CC','Diana Pilar','Solarte Astaiza','CEAI','Valle','dsolarte@misena.edu.co 	','',1,1,'$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6','ikwRkvf66MhsLhIYdcAaLMhewwKzUvn3d0R8JzmsTo0MsjzvA5BhsMCLOzwN','2020-06-20 00:51:49','2020-06-30 22:12:04'),(2,'29667538','CC','Gloria Ines','Leon Palomino','CEAI','VALLE','gileon@sena.edu.co','3157678900',1,1,'$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6',NULL,'2020-06-20 00:51:49','2020-06-20 02:38:25');
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

-- Dump completed on 2020-06-30 13:34:54
