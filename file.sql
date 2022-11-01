CREATE DATABASE  IF NOT EXISTS `cafeteria_konecta` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cafeteria_konecta`;

-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: cafeteria_konecta
-- ------------------------------------------------------
-- Server version	8.0.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `konecta_categories`
--

DROP TABLE IF EXISTS `konecta_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konecta_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci COMMENT='Tabla de las categorias de los productos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konecta_categories`
--

LOCK TABLES `konecta_categories` WRITE;
/*!40000 ALTER TABLE `konecta_categories` DISABLE KEYS */;
INSERT INTO `konecta_categories` VALUES (1,'Vegetales','vegetales','2022-02-02'),(2,'Frutas','frutas','2022-02-02'),(3,'Proteinas','proteinas','2022-02-02'),(4,'Procesados','Comida procesada','2022-02-02'),(5,'Proteina Vegetal','Comida vegetariana','2022-02-02');
/*!40000 ALTER TABLE `konecta_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konecta_products`
--

DROP TABLE IF EXISTS `konecta_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konecta_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `reference` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `price` int NOT NULL,
  `weight` int NOT NULL,
  `category_id` int NOT NULL,
  `stock` int NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CategoriesXProducts_idx` (`category_id`),
  CONSTRAINT `FK_CategoriesXProducts` FOREIGN KEY (`category_id`) REFERENCES `konecta_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci COMMENT='Tabla donde se imprime los productos que la cafeteria de Konecta dispone';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `konecta_shoppings`
--

DROP TABLE IF EXISTS `konecta_shoppings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konecta_shoppings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ShoppingXUsers_idx` (`user_id`),
  KEY `FK_ShoppingXProducts_idx` (`product_id`),
  CONSTRAINT `FK_ShoppingXProducts` FOREIGN KEY (`product_id`) REFERENCES `konecta_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ShoppingXUsers` FOREIGN KEY (`user_id`) REFERENCES `konecta_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci COMMENT='Tabla donde se almacena las ventas realizadas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `konecta_users`
--

DROP TABLE IF EXISTS `konecta_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konecta_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci COMMENT='Tabla de los usuarios quienes se conectan al sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konecta_users`
--


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-31 23:36:04
