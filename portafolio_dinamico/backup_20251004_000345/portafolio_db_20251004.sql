-- MySQL dump 10.13  Distrib 8.0.35, for macos12.7 (arm64)
--
-- Host: localhost    Database: portafolio_db
-- ------------------------------------------------------
-- Server version	5.7.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$SlP2wtRFH7geSeAnjyQlG.Cf/oywh9wvb7DhApDlEUavNE3gVrN3y','luisrocedev@gmail.com','2025-10-03 21:29:30','2025-10-03 21:13:58'),(2,'admin2','admin2','admin@gmail.com',NULL,'2025-10-03 21:27:57');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `featured_projects`
--

DROP TABLE IF EXISTS `featured_projects`;
/*!50001 DROP VIEW IF EXISTS `featured_projects`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `featured_projects` AS SELECT 
 1 AS `id`,
 1 AS `title`,
 1 AS `slug`,
 1 AS `description`,
 1 AS `short_description`,
 1 AS `image_url`,
 1 AS `technologies`,
 1 AS `github_url`,
 1 AS `live_url`,
 1 AS `featured`,
 1 AS `order_position`,
 1 AS `status`,
 1 AS `created_at`,
 1 AS `updated_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replit_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (1,'Luis Jahir Rodríguez Cedeño','Full Stack Developer & Designer','Desarrollador en formación con enfoque Full Stack. Actualmente estudio DAM, combinando habilidades de frontend atractivo con lógica backend estructurada. He desarrollado desde portales modulares hasta sistemas de gestión reales como TPVs, PMS hoteleros y microservicios de IA.','luisrocedev@gmail.com','','España','https://github.com/luisrocedev','https://es.linkedin.com/in/luisrocedev','https://replit.com/@luisrocedev','','','2025-10-03 21:30:48');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technologies` json DEFAULT NULL,
  `github_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `order_position` int(11) DEFAULT '0',
  `status` enum('active','archived','draft') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_projects_featured` (`featured`),
  KEY `idx_projects_status` (`status`),
  KEY `idx_projects_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'TaronjaBoxValencia','taronjaboxvalencia','Web dinámica para centro deportivo desarrollada con HTML, CSS y JavaScript. Sistema modular con gestión de clases, horarios y reservas. Diseño responsive y optimizado para dispositivos móviles.','Web dinámica para centro deportivo','https://media.tenor.com/mtiOW6O-k8YAAAAM/shrek-shrek-rizz.gif','[\"HTML\", \"CSS\", \"JavaScript\", \"PHP\"]','https://github.com/luisrocedev/taronjaboxvalencia','https://github.com/jocarsa/dam2526/tree/main/Segundo/Programaci%C3%B3n%20de%20servicios%20y%20procesos','https://www.youtube.com/watch?v=dQw4w9WgXcQ',1,1,'active','2025-10-03 21:13:58','2025-10-03 21:50:55'),(2,'DarkOrange','darkorange','Panel de control administrativo con sistema de login y CRUDs completos. Gestión modular de usuarios, productos y configuraciones. Interfaz intuitiva con validaciones en tiempo real.','Panel Admin con login y CRUDs',NULL,'[\"PHP\", \"MySQL\", \"JavaScript\", \"Bootstrap\"]','https://github.com/luisrocedev/darkorange',NULL,NULL,1,2,'active','2025-10-03 21:13:58','2025-10-03 21:13:58'),(3,'PMS Daniya','pms-daniya','Sistema de gestión hotelera completo (Property Management System). Incluye gestión de reservas, pagos, usuarios y reportes. Arquitectura monolítica robusta con panel administrativo.','Sistema de gestión hotelera completo',NULL,'[\"PHP\", \"MySQL\", \"JavaScript\", \"AJAX\"]','https://github.com/luisrocedev/PMS-Daniya',NULL,NULL,1,3,'active','2025-10-03 21:13:58','2025-10-03 21:13:58'),(4,'CRM Sistema','crm','Sistema de gestión de clientes (Customer Relationship Management) diseñado para seguimiento y atención al cliente. Incluye gestión de leads, tickets y historial de interacciones.','Sistema para seguimiento y atención al cliente',NULL,'[\"PHP\", \"MySQL\", \"JavaScript\"]','https://github.com/luisrocedev/CRM',NULL,NULL,1,4,'active','2025-10-03 21:13:58','2025-10-03 21:13:58'),(5,'TPV Voltereta','tpv-voltereta','Punto de venta para restauración con gestión de caja, pedidos en tiempo real y sistema de chat interno. Interfaz optimizada para uso en tablets y dispositivos táctiles.','Punto de venta con caja, pedidos y chat',NULL,'[\"PHP\", \"MySQL\", \"JavaScript\", \"WebSockets\"]','https://github.com/luisrocedev/TPV-Voltereta',NULL,NULL,1,5,'active','2025-10-03 21:13:58','2025-10-03 21:13:58'),(6,'LChat','lchat','Sistema de chat en tiempo real desarrollado con Node.js y WebSockets. Diseño moderno con soporte para salas, notificaciones y emojis. Arquitectura escalable y eficiente.','Chat en tiempo real con diseño moderno',NULL,'[\"Node.js\", \"Express\", \"Socket.io\", \"JavaScript\"]','https://github.com/luisrocedev/LChat',NULL,NULL,1,6,'active','2025-10-03 21:13:58','2025-10-03 21:13:58'),(7,'Asistente IA PMS','asistente-ia-pms','Microservicio de inteligencia artificial para hoteles con detección de intenciones. Utiliza procesamiento de lenguaje natural (NLP) con clasificadores Bayesianos para interpretar consultas de usuarios.','Microservicio de IA para hoteles',NULL,'[\"Node.js\", \"Natural\", \"NLP\", \"IA\"]','https://github.com/luisrocedev/asistente-ia-pms',NULL,NULL,1,7,'active','2025-10-03 21:13:58','2025-10-03 21:13:58');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('frontend','backend','database','tools','other') COLLATE utf8mb4_unicode_ci DEFAULT 'other',
  `level` enum('básico','intermedio','avanzado','experto') COLLATE utf8mb4_unicode_ci DEFAULT 'intermedio',
  `icon_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_skills_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'HTML','frontend','avanzado',NULL,1,'2025-10-03 21:13:58'),(2,'CSS','frontend','avanzado',NULL,2,'2025-10-03 21:13:58'),(3,'JavaScript','frontend','avanzado',NULL,3,'2025-10-03 21:13:58'),(4,'Tailwind CSS','frontend','intermedio',NULL,4,'2025-10-03 21:13:58'),(5,'Bootstrap','frontend','avanzado',NULL,5,'2025-10-03 21:13:58'),(6,'PHP','backend','avanzado',NULL,6,'2025-10-03 21:13:58'),(7,'Node.js','backend','intermedio',NULL,7,'2025-10-03 21:13:58'),(8,'Express.js','backend','intermedio',NULL,8,'2025-10-03 21:13:58'),(9,'MySQL','database','avanzado',NULL,9,'2025-10-03 21:13:58'),(10,'JSON','database','avanzado',NULL,10,'2025-10-03 21:13:58'),(11,'Git','tools','avanzado',NULL,11,'2025-10-03 21:13:58'),(12,'GitHub','tools','avanzado',NULL,12,'2025-10-03 21:13:58'),(13,'VS Code','tools','avanzado',NULL,13,'2025-10-03 21:13:58'),(14,'MAMP','tools','avanzado',NULL,14,'2025-10-03 21:13:58'),(15,'NLP','other','intermedio',NULL,15,'2025-10-03 21:13:58'),(16,'WebSockets','other','intermedio',NULL,16,'2025-10-03 21:13:58'),(17,'REST APIs','other','intermedio',NULL,17,'2025-10-03 21:13:58');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!50001 DROP VIEW IF EXISTS `stats`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `stats` AS SELECT 
 1 AS `total_projects`,
 1 AS `featured_projects`,
 1 AS `total_skills`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `featured_projects`
--

/*!50001 DROP VIEW IF EXISTS `featured_projects`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `featured_projects` AS select `projects`.`id` AS `id`,`projects`.`title` AS `title`,`projects`.`slug` AS `slug`,`projects`.`description` AS `description`,`projects`.`short_description` AS `short_description`,`projects`.`image_url` AS `image_url`,`projects`.`technologies` AS `technologies`,`projects`.`github_url` AS `github_url`,`projects`.`live_url` AS `live_url`,`projects`.`featured` AS `featured`,`projects`.`order_position` AS `order_position`,`projects`.`status` AS `status`,`projects`.`created_at` AS `created_at`,`projects`.`updated_at` AS `updated_at` from `projects` where ((`projects`.`featured` = 1) and (`projects`.`status` = 'active')) order by `projects`.`order_position` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stats`
--

/*!50001 DROP VIEW IF EXISTS `stats`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `stats` AS select (select count(0) from `projects` where (`projects`.`status` = 'active')) AS `total_projects`,(select count(0) from `projects` where ((`projects`.`featured` = 1) and (`projects`.`status` = 'active'))) AS `featured_projects`,(select count(0) from `skills`) AS `total_skills` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-04  0:03:45
