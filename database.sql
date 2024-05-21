-- MySQL dump 10.13  Distrib 8.0.33, for macos13.3 (arm64)
--
-- Host: localhost    Database: starbelly
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `activations`
--

DROP TABLE IF EXISTS `activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `code` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activations_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activations`
--

LOCK TABLES `activations` WRITE;
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;
INSERT INTO `activations` VALUES (1,1,'w2MjIs0k0xOzIc9AWyfV10IF4H7I7bWX',1,'2023-07-02 19:58:38','2023-07-02 19:58:38','2023-07-02 19:58:38'),(2,2,'FKiYbZyFZN8jxCXDlvneZ8mdJKGleJtc',1,'2023-07-02 19:58:38','2023-07-02 19:58:38','2023-07-02 19:58:38');
/*!40000 ALTER TABLE `activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_notifications`
--

LOCK TABLES `admin_notifications` WRITE;
/*!40000 ALTER TABLE `admin_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_histories`
--

DROP TABLE IF EXISTS `audit_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `module` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request` text COLLATE utf8mb4_unicode_ci,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(39) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_user` bigint unsigned NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_histories_user_id_index` (`user_id`),
  KEY `audit_histories_module_index` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_histories`
--

LOCK TABLES `audit_histories` WRITE;
/*!40000 ALTER TABLE `audit_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint unsigned NOT NULL,
  `author_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `icon` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_featured` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Design',0,'And he added looking angrily at the window, and on it but tea. \'I don\'t know of any one; so, when the race was over. Alice was beginning to get in at the thought that it was just going to begin.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(2,'Lifestyle',0,'Duchess\'s cook. She carried the pepper-box in her pocket, and was delighted to find that she never knew so much already, that it led into a pig, my dear,\' said Alice, a little bird as soon as it was.','published',1,'Botble\\ACL\\Models\\User',NULL,0,0,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(3,'Travel Tips',0,'Alice, who felt very curious sensation, which puzzled her a good many little girls in my kitchen AT ALL. Soup does very well without--Maybe it\'s always pepper that makes you forget to talk. I can\'t.','published',1,'Botble\\ACL\\Models\\User',NULL,0,0,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(4,'Healthy',0,'Fish-Footman was gone, and, by the time she went on, turning to the fifth bend, I think?\' he said in a Little Bill It was so large a house, that she was out of it, and burning with curiosity, she.','published',1,'Botble\\ACL\\Models\\User',NULL,0,0,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(5,'Travel Tips',0,'I shan\'t go, at any rate it would like the look of the words don\'t FIT you,\' said the Caterpillar. Here was another puzzling question; and as he could think of any that do,\' Alice hastily replied.','published',1,'Botble\\ACL\\Models\\User',NULL,0,0,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(6,'Hotel',0,'Alice, whose thoughts were still running on the end of the house, and have next to no toys to play croquet.\' Then they all crowded round her, calling out in a low curtain she had read several nice.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(7,'Nature',0,'Queen had never heard it muttering to himself in an offended tone, and added \'It isn\'t mine,\' said the youth, \'as I mentioned before, And have grown most uncommonly fat; Yet you balanced an eel on.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_translations`
--

DROP TABLE IF EXISTS `categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_translations`
--

LOCK TABLES `categories_translations` WRITE;
/*!40000 ALTER TABLE `categories_translations` DISABLE KEYS */;
INSERT INTO `categories_translations` VALUES ('vi',1,NULL,NULL),('vi',2,NULL,NULL),('vi',3,NULL,NULL),('vi',4,NULL,NULL),('vi',5,NULL,NULL),('vi',6,NULL,NULL),('vi',7,NULL,NULL);
/*!40000 ALTER TABLE `categories_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `record_id` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities_translations`
--

DROP TABLE IF EXISTS `cities_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cities_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`cities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities_translations`
--

LOCK TABLES `cities_translations` WRITE;
/*!40000 ALTER TABLE `cities_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `cities_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_replies`
--

DROP TABLE IF EXISTS `contact_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_replies`
--

LOCK TABLES `contact_replies` WRITE;
/*!40000 ALTER TABLE `contact_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'Mr. Elroy Anderson MD','snitzsche@example.net','(701) 387-9145','4421 Santiago Light Apt. 199\nUptonmouth, WY 74850','Sit harum qui quo debitis eveniet voluptatem.','Et autem id vero vel ratione autem. Est optio expedita enim deserunt. Suscipit libero qui id qui. Autem quos doloremque ut tempora in id. Ipsam cumque maxime ratione enim. Voluptatem impedit similique exercitationem ipsum. Sed atque blanditiis totam reiciendis laboriosam quo. Minima sequi repudiandae similique nulla eum. Est sequi modi quod.','unread','2023-07-02 19:58:39','2023-07-02 19:58:39'),(2,'Tiffany Purdy','wleffler@example.org','256-863-8454','807 Alyce Motorway Apt. 769\nCarmelahaven, AL 74294','Qui cum magnam atque quis.','Eligendi quos qui impedit. Deleniti est sapiente occaecati excepturi assumenda. Quia non sit doloribus. Qui nam pariatur eos impedit iure dicta excepturi. Nam praesentium omnis voluptas enim nam. Quos voluptas numquam quidem placeat adipisci dolorum. Est esse ut omnis laboriosam soluta quibusdam. Et unde minus ut inventore nam et.','read','2023-07-02 19:58:39','2023-07-02 19:58:39'),(3,'Prof. Vivian Koelpin','heidi56@example.net','(408) 293-6920','9862 Rolfson Causeway\nTurcotteburgh, MD 21626','Voluptatem et et nihil nostrum quo voluptate.','Adipisci maiores sed voluptatem officia quo. Quo rem et et fugiat. Non et nisi aut voluptate possimus.','read','2023-07-02 19:58:39','2023-07-02 19:58:39'),(4,'Ms. Francesca Haley II','brohan@example.com','+16804030248','10750 Steuber Harbor Apt. 235\nKraigville, HI 73252-0011','Libero labore molestiae est eaque voluptas.','Expedita aut et consequuntur ut mollitia. Aut ut molestias tempora culpa tenetur qui alias. Inventore sit beatae in nobis ut. Sed non voluptatum est est amet. Sed quasi facere cumque eum. Soluta ea aut sed sed. Sequi tenetur non commodi et reiciendis amet. Nostrum illo neque iste quo maiores. Quia perferendis sequi cumque enim ut delectus recusandae. Est consectetur voluptas repellendus quia rem delectus. Id quo minus et praesentium optio.','unread','2023-07-02 19:58:39','2023-07-02 19:58:39'),(5,'Pearline Schneider','ortiz.vernon@example.net','574-384-2217','3613 Cummerata Greens\nLake Arjun, NH 63695-7226','Numquam doloribus earum magnam eaque et.','Non cupiditate est sunt rerum voluptatem. Corporis dolor id mollitia voluptates aliquid. Sapiente quasi ut et eligendi placeat et est. Illo quisquam repellat aut et et aut esse.','read','2023-07-02 19:58:39','2023-07-02 19:58:39'),(6,'Diana Becker','mcclure.neoma@example.org','1-972-535-1177','473 Champlin Spurs\nAufderharberg, VT 36560','Eum et beatae explicabo dolores dolores.','Non vero quos nesciunt ut. Quas et ut voluptas. Odit ab magnam ab commodi sunt. Corrupti deleniti dolorem nesciunt qui. Omnis culpa asperiores vel veniam. Autem veritatis rem dolorem occaecati ullam ut quod. Natus ipsam consequatur a quo sunt ea soluta.','unread','2023-07-02 19:58:39','2023-07-02 19:58:39'),(7,'Prof. Jerome Cremin PhD','prince06@example.org','312-686-1000','926 Nelle Spur\nGerholdchester, NE 19691-4563','Asperiores in porro laudantium enim.','Aut at aut vero assumenda maiores. Qui perspiciatis omnis numquam assumenda ab. Optio enim ratione accusamus mollitia accusamus. Animi veniam animi soluta autem qui sunt. At ut natus quasi incidunt sed nobis rerum sed. Sit rerum est vel voluptatibus sed exercitationem consectetur.','unread','2023-07-02 19:58:39','2023-07-02 19:58:39'),(8,'Prof. Wilford Herman II','lester09@example.net','858-536-1179','417 Prohaska Ports\nWest Richieland, ME 50547','Earum atque reiciendis aut.','Fuga tempore consequatur ducimus nisi minus. Dolor quos doloribus molestiae. Dolorem nostrum officia dolorem dolor dolorum consectetur qui. Laudantium totam qui culpa saepe. Aspernatur nisi corrupti quod maxime a quas velit. Quos labore et sed illo enim. Ipsam quia quidem et atque. Qui aut id quis reiciendis fugiat repellendus voluptatum perferendis. Eum delectus tempora tenetur corporis.','read','2023-07-02 19:58:39','2023-07-02 19:58:39'),(9,'Adella Schuster','maegan.lynch@example.net','469.732.5156','4919 Kurtis Freeway Apt. 714\nDonnellyfurt, RI 37237','Quis dolor expedita quia quidem quia minus.','Qui in minus dolores occaecati. Et voluptatibus tenetur eum facere qui. Qui consequatur et aliquid vitae. Quidem voluptatibus harum dolores aut accusamus eum.','read','2023-07-02 19:58:39','2023-07-02 19:58:39'),(10,'Brandyn Eichmann','anya51@example.net','+1-617-805-1543','95698 Becker Key Suite 413\nEast Alfredchester, NJ 94273','At sed natus et.','Maxime similique aliquam dolor odio. Eos ea ex aut laboriosam. Repellat quae dolor itaque nihil. Alias qui ea pariatur recusandae. Deleniti voluptatem tempora perferendis consequatur nobis deleniti. Quia dolores incidunt at eum ex.','unread','2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries_translations`
--

DROP TABLE IF EXISTS `countries_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countries_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`countries_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries_translations`
--

LOCK TABLES `countries_translations` WRITE;
/*!40000 ALTER TABLE `countries_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard_widget_settings`
--

DROP TABLE IF EXISTS `dashboard_widget_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dashboard_widget_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `widget_id` bigint unsigned NOT NULL,
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `status` tinyint unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dashboard_widget_settings_user_id_index` (`user_id`),
  KEY `dashboard_widget_settings_widget_id_index` (`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard_widget_settings`
--

LOCK TABLES `dashboard_widget_settings` WRITE;
/*!40000 ALTER TABLE `dashboard_widget_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashboard_widget_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard_widgets`
--

DROP TABLE IF EXISTS `dashboard_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dashboard_widgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard_widgets`
--

LOCK TABLES `dashboard_widgets` WRITE;
/*!40000 ALTER TABLE `dashboard_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashboard_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_brands`
--

DROP TABLE IF EXISTS `ec_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_brands`
--

LOCK TABLES `ec_brands` WRITE;
/*!40000 ALTER TABLE `ec_brands` DISABLE KEYS */;
INSERT INTO `ec_brands` VALUES (1,'Nestlé','Necessitatibus eligendi laborum rerum totam. Iure saepe voluptatem maiores. Quas tempora est perferendis omnis ea. Doloribus occaecati officiis est ipsum quia.','http://www.heathcote.org/','brands/1.png','published',0,0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'Pepsi','Qui sed beatae voluptas voluptatem. Velit quaerat ipsum adipisci. Nemo doloremque dolores omnis in sed qui repellendus.','http://ohara.biz/hic-enim-ipsa-blanditiis-voluptatem-ut-qui.html','brands/2.png','published',1,0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'McDonald\'s','Magnam sint facere exercitationem labore. Doloribus voluptatem aut non tempora eius qui deleniti. Ipsa earum cumque et omnis tenetur ut beatae. Rerum earum deleniti dolor unde quisquam.','https://www.ledner.com/labore-consequatur-quos-tempore-aperiam','brands/3.png','published',2,1,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(4,'Burger King','Nulla corporis consequuntur nihil delectus et animi. Ullam neque minima aut culpa odit atque fugiat.','http://www.waters.org/earum-itaque-mollitia-officia-ut-sed','brands/4.png','published',3,0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(5,'KFC','Dignissimos ut ad aliquam repellendus. Saepe dolor quaerat error amet soluta pariatur facere.','http://www.spinka.org/','brands/5.png','published',4,1,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(6,'Starbucks','Unde magnam et et sint velit et occaecati. Nihil quidem incidunt corrupti natus voluptates. Rerum tenetur quae molestiae est repellat facilis vel fugit.','https://www.larson.com/ea-praesentium-perspiciatis-ipsa-iste-occaecati-sint-quos-nam','brands/6.png','published',5,0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(7,'Popeyes','Inventore odit doloribus aut quia ratione qui qui. Repudiandae ipsa blanditiis odio sit molestiae tenetur qui. Suscipit aspernatur quam quos aut quis quibusdam dolor.','http://www.baumbach.com/ut-quae-at-iure-officiis-magni','brands/7.png','published',6,0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(8,'Phúc Long','Amet eligendi sed et sint architecto. Ut inventore reiciendis et. Natus assumenda sit quia vitae voluptas optio voluptatibus.','http://corwin.com/quod-optio-rerum-odio-aut-ea-et','brands/8.png','published',7,1,'2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `ec_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_brands_translations`
--

DROP TABLE IF EXISTS `ec_brands_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_brands_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_brands_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_brands_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_brands_translations`
--

LOCK TABLES `ec_brands_translations` WRITE;
/*!40000 ALTER TABLE `ec_brands_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_brands_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_cart`
--

DROP TABLE IF EXISTS `ec_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_cart` (
  `identifier` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`identifier`,`instance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_cart`
--

LOCK TABLES `ec_cart` WRITE;
/*!40000 ALTER TABLE `ec_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_currencies`
--

DROP TABLE IF EXISTS `ec_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_prefix_symbol` tinyint unsigned NOT NULL DEFAULT '0',
  `decimals` tinyint unsigned DEFAULT '0',
  `order` int unsigned DEFAULT '0',
  `is_default` tinyint NOT NULL DEFAULT '0',
  `exchange_rate` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_currencies`
--

LOCK TABLES `ec_currencies` WRITE;
/*!40000 ALTER TABLE `ec_currencies` DISABLE KEYS */;
INSERT INTO `ec_currencies` VALUES (1,'USD','$',1,2,0,1,1,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'EUR','€',0,2,1,0,0.84,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'VND','₫',0,0,2,0,23203,'2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `ec_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_addresses`
--

DROP TABLE IF EXISTS `ec_customer_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_customer_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_addresses`
--

LOCK TABLES `ec_customer_addresses` WRITE;
/*!40000 ALTER TABLE `ec_customer_addresses` DISABLE KEYS */;
INSERT INTO `ec_customer_addresses` VALUES (1,'Alayna Mosciski','customer@archielite.com','+15802923308','AM','Ramp','South Chasity','60461 Larkin Bridge Suite 271',1,1,'2023-07-02 19:58:45','2023-07-02 19:58:45','32002-0100'),(2,'Rosanna Nolan II','theron.bednar@example.com','+16465868985','MK','Course','South Annamarie','47645 Parker Forest',2,1,'2023-07-02 19:58:45','2023-07-02 19:58:45','12865-1380'),(3,'Carleton Gaylord PhD','vstiedemann@example.net','+16576736977','CO','Stream','Erdmanside','73959 Kaitlyn Valleys Suite 807',3,1,'2023-07-02 19:58:45','2023-07-02 19:58:45','36133-6665'),(4,'Mac Weissnat','jjerde@example.com','+12519765703','MV','Harbors','Croninmouth','15941 Avery Loaf Suite 167',4,1,'2023-07-02 19:58:45','2023-07-02 19:58:45','06183'),(5,'Madalyn Hegmann','douglas.eugenia@example.com','+16807576161','ET','Cove','Lake Destinchester','814 Witting Ville Apt. 270',5,1,'2023-07-02 19:58:45','2023-07-02 19:58:45','08961'),(6,'Ms. Dayna Boehm Jr.','dtorp@example.org','+18583729254','MT','Freeway','Caroleville','159 Kuhlman Place Suite 906',6,1,'2023-07-02 19:58:46','2023-07-02 19:58:46','15029'),(7,'Dr. Keyshawn Tromp','vluettgen@example.net','+17158392711','BF','Wall','Lake Bertram','17049 Ferry Villages',7,1,'2023-07-02 19:58:46','2023-07-02 19:58:46','96433'),(8,'Delpha Monahan','peter35@example.org','+16512389319','MD','Mills','South Billshire','6795 Shayna Plaza Apt. 767',8,1,'2023-07-02 19:58:46','2023-07-02 19:58:46','50874-2983'),(9,'Perry Kuhic','anastasia50@example.net','+12525764731','UG','Port','Hicklestad','5575 Brady Village',9,1,'2023-07-02 19:58:46','2023-07-02 19:58:46','23201-2967');
/*!40000 ALTER TABLE `ec_customer_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_password_resets`
--

DROP TABLE IF EXISTS `ec_customer_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_customer_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `ec_customer_password_resets_email_index` (`email`),
  KEY `ec_customer_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_password_resets`
--

LOCK TABLES `ec_customer_password_resets` WRITE;
/*!40000 ALTER TABLE `ec_customer_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_customer_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_recently_viewed_products`
--

DROP TABLE IF EXISTS `ec_customer_recently_viewed_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_customer_recently_viewed_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_recently_viewed_products`
--

LOCK TABLES `ec_customer_recently_viewed_products` WRITE;
/*!40000 ALTER TABLE `ec_customer_recently_viewed_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_customer_recently_viewed_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customer_used_coupons`
--

DROP TABLE IF EXISTS `ec_customer_used_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_customer_used_coupons` (
  `discount_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customer_used_coupons`
--

LOCK TABLES `ec_customer_used_coupons` WRITE;
/*!40000 ALTER TABLE `ec_customer_used_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_customer_used_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_customers`
--

DROP TABLE IF EXISTS `ec_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `email_verify_token` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activated',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_customers`
--

LOCK TABLES `ec_customers` WRITE;
/*!40000 ALTER TABLE `ec_customers` DISABLE KEYS */;
INSERT INTO `ec_customers` VALUES (1,'Alayna Mosciski','customer@archielite.com','$2y$10$xb04YBxlD/4FBFMZMDtKMeWUTCDfxqCRsQiKXSh2zbXyGnA2KvocG','customers/1.jpg','1989-06-28','+19036628794',NULL,'2023-07-02 19:58:45','2023-07-02 19:58:45','2023-07-03 02:58:45',NULL,'activated'),(2,'Rosanna Nolan II','theron.bednar@example.com','$2y$10$CP24HhsKQTKJVayGICiAHekwQx8uS0.NQkNPeM6OnzLBcttPylkES','customers/1.jpg','1977-06-10','+13084048763',NULL,'2023-07-02 19:58:45','2023-07-02 19:58:45','2023-07-03 02:58:45',NULL,'activated'),(3,'Carleton Gaylord PhD','vstiedemann@example.net','$2y$10$uqV0rsg89zPWE9tVdStp3Op6lPvEjweIQQjotv5xNpFfg4U1vHRli','customers/2.jpg','1979-06-09','+19852012357',NULL,'2023-07-02 19:58:45','2023-07-02 19:58:45','2023-07-03 02:58:45',NULL,'activated'),(4,'Mac Weissnat','jjerde@example.com','$2y$10$ypelDiVJTzpfy3WqB9Bng.GwlPtqccF0VXR3NEZBV4Qk074R1wJNq','customers/3.jpg','1984-06-17','+18142631601',NULL,'2023-07-02 19:58:45','2023-07-02 19:58:45','2023-07-03 02:58:45',NULL,'activated'),(5,'Madalyn Hegmann','douglas.eugenia@example.com','$2y$10$i6b3fbOWgzjfbtEGiGmZ0.VLiROp1sl9mXr4TqYn06KSDKcalDZa.','customers/4.jpg','1982-06-04','+17798549954',NULL,'2023-07-02 19:58:45','2023-07-02 19:58:45','2023-07-03 02:58:45',NULL,'activated'),(6,'Ms. Dayna Boehm Jr.','dtorp@example.org','$2y$10$7VETPh9Xyb3.jm4JW4rNDutCBrOF6zPsqMKhXXK.Rf/8Qa9hvuRIm','customers/5.jpg','1989-06-21','+15713243011',NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','2023-07-03 02:58:46',NULL,'activated'),(7,'Dr. Keyshawn Tromp','vluettgen@example.net','$2y$10$4L5Ha0ycKWo0awP20.CxmucCaKQBod9F28NpEyNL/k253HWCpqBpa','customers/6.jpg','1989-07-02','+14848988289',NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','2023-07-03 02:58:46',NULL,'activated'),(8,'Delpha Monahan','peter35@example.org','$2y$10$4WfI0fSC7x0yL/6jspE.oOljEtEbtChoOy/uuPhnHOtk8P55e4I3W','customers/7.jpg','1995-06-15','+13394291985',NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','2023-07-03 02:58:46',NULL,'activated'),(9,'Perry Kuhic','anastasia50@example.net','$2y$10$9o7ERkJRlKNHNTVk3kQXkuQDN91/9dG82cmuKC0XEfVLoxujBbY/y','customers/8.jpg','1984-06-09','+12793743469',NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','2023-07-03 02:58:46',NULL,'activated');
/*!40000 ALTER TABLE `ec_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_discount_customers`
--

DROP TABLE IF EXISTS `ec_discount_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_discount_customers` (
  `discount_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_discount_customers`
--

LOCK TABLES `ec_discount_customers` WRITE;
/*!40000 ALTER TABLE `ec_discount_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_discount_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_discount_product_collections`
--

DROP TABLE IF EXISTS `ec_discount_product_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_discount_product_collections` (
  `discount_id` bigint unsigned NOT NULL,
  `product_collection_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`product_collection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_discount_product_collections`
--

LOCK TABLES `ec_discount_product_collections` WRITE;
/*!40000 ALTER TABLE `ec_discount_product_collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_discount_product_collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_discount_products`
--

DROP TABLE IF EXISTS `ec_discount_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_discount_products` (
  `discount_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`discount_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_discount_products`
--

LOCK TABLES `ec_discount_products` WRITE;
/*!40000 ALTER TABLE `ec_discount_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_discount_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_discounts`
--

DROP TABLE IF EXISTS `ec_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_discounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `total_used` int unsigned NOT NULL DEFAULT '0',
  `value` double DEFAULT NULL,
  `type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'coupon',
  `can_use_with_promotion` tinyint(1) NOT NULL DEFAULT '0',
  `discount_on` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_quantity` int unsigned DEFAULT NULL,
  `type_option` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'amount',
  `target` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all-orders',
  `min_order_price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_discounts_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_discounts`
--

LOCK TABLES `ec_discounts` WRITE;
/*!40000 ALTER TABLE `ec_discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_flash_sale_products`
--

DROP TABLE IF EXISTS `ec_flash_sale_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_flash_sale_products` (
  `flash_sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `price` double unsigned DEFAULT NULL,
  `quantity` int unsigned DEFAULT NULL,
  `sold` int unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_flash_sale_products`
--

LOCK TABLES `ec_flash_sale_products` WRITE;
/*!40000 ALTER TABLE `ec_flash_sale_products` DISABLE KEYS */;
INSERT INTO `ec_flash_sale_products` VALUES (1,1,27.9,16,4),(1,2,35.67,13,5),(1,3,21.6,15,4),(1,4,25.6168,16,1),(1,5,19.27,14,1),(1,6,36.54,9,4),(1,7,40,11,1),(1,8,22.68,16,4),(1,9,43.5,12,3),(1,10,18.13,13,5);
/*!40000 ALTER TABLE `ec_flash_sale_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_flash_sales`
--

DROP TABLE IF EXISTS `ec_flash_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_flash_sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_flash_sales`
--

LOCK TABLES `ec_flash_sales` WRITE;
/*!40000 ALTER TABLE `ec_flash_sales` DISABLE KEYS */;
INSERT INTO `ec_flash_sales` VALUES (1,'Winter Sale','2023-08-02 00:00:00','published','2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_flash_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_flash_sales_translations`
--

DROP TABLE IF EXISTS `ec_flash_sales_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_flash_sales_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_flash_sales_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_flash_sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_flash_sales_translations`
--

LOCK TABLES `ec_flash_sales_translations` WRITE;
/*!40000 ALTER TABLE `ec_flash_sales_translations` DISABLE KEYS */;
INSERT INTO `ec_flash_sales_translations` VALUES ('vi',1,NULL);
/*!40000 ALTER TABLE `ec_flash_sales_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_global_option_value`
--

DROP TABLE IF EXISTS `ec_global_option_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_global_option_value` (
  `option_id` bigint unsigned NOT NULL COMMENT 'option id',
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_value` tinytext COLLATE utf8mb4_unicode_ci COMMENT 'option value',
  `affect_price` double DEFAULT NULL COMMENT 'value of price of this option affect',
  `order` int NOT NULL DEFAULT '9999',
  `affect_type` tinyint NOT NULL DEFAULT '0' COMMENT '0. fixed 1. percent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_global_option_value`
--

LOCK TABLES `ec_global_option_value` WRITE;
/*!40000 ALTER TABLE `ec_global_option_value` DISABLE KEYS */;
INSERT INTO `ec_global_option_value` VALUES (1,1,'1 Year',0,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(1,2,'2 Year',10,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(1,3,'3 Year',20,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,4,'4GB',0,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,5,'8GB',10,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,6,'16GB',20,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,7,'Core i5',0,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,8,'Core i7',10,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,9,'Core i9',20,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,10,'128GB',0,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,11,'256GB',10,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,12,'512GB',20,9999,0,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_global_option_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_global_option_value_translations`
--

DROP TABLE IF EXISTS `ec_global_option_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_global_option_value_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_global_option_value_id` bigint unsigned NOT NULL,
  `option_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_global_option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_global_option_value_translations`
--

LOCK TABLES `ec_global_option_value_translations` WRITE;
/*!40000 ALTER TABLE `ec_global_option_value_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_global_option_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_global_options`
--

DROP TABLE IF EXISTS `ec_global_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_global_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of options',
  `option_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'option type',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Checked if this option is required',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_global_options`
--

LOCK TABLES `ec_global_options` WRITE;
/*!40000 ALTER TABLE `ec_global_options` DISABLE KEYS */;
INSERT INTO `ec_global_options` VALUES (1,'Warranty','Botble\\Ecommerce\\Option\\OptionType\\RadioButton',1,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,'RAM','Botble\\Ecommerce\\Option\\OptionType\\RadioButton',1,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,'CPU','Botble\\Ecommerce\\Option\\OptionType\\RadioButton',1,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,'HDD','Botble\\Ecommerce\\Option\\OptionType\\Dropdown',0,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_global_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_global_options_translations`
--

DROP TABLE IF EXISTS `ec_global_options_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_global_options_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_global_options_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_global_options_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_global_options_translations`
--

LOCK TABLES `ec_global_options_translations` WRITE;
/*!40000 ALTER TABLE `ec_global_options_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_global_options_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_grouped_products`
--

DROP TABLE IF EXISTS `ec_grouped_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_grouped_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_product_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `fixed_qty` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_grouped_products`
--

LOCK TABLES `ec_grouped_products` WRITE;
/*!40000 ALTER TABLE `ec_grouped_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_grouped_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_invoice_items`
--

DROP TABLE IF EXISTS `ec_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int unsigned NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(15,2) unsigned NOT NULL,
  `tax_amount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `amount` decimal(15,2) unsigned NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_invoice_items_reference_type_reference_id_index` (`reference_type`,`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_invoice_items`
--

LOCK TABLES `ec_invoice_items` WRITE;
/*!40000 ALTER TABLE `ec_invoice_items` DISABLE KEYS */;
INSERT INTO `ec_invoice_items` VALUES (1,1,'Botble\\Ecommerce\\Models\\Product',80,'Turkey meat',NULL,'products/2.jpg',1,33.00,33.00,0.00,0.00,33.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,1,'Botble\\Ecommerce\\Models\\Product',110,'Leek and mushroom pie',NULL,'products/23.jpg',1,38.00,38.00,0.00,0.00,38.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,2,'Botble\\Ecommerce\\Models\\Product',59,'Boiled vegetables',NULL,'products/7.jpg',3,45.00,135.00,0.00,0.00,135.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,2,'Botble\\Ecommerce\\Models\\Product',99,'Chickpea and chilli pasta',NULL,'products/17.jpg',3,39.00,117.00,0.00,0.00,117.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(5,2,'Botble\\Ecommerce\\Models\\Product',123,'Spinach and aubergine bread',NULL,'products/8.jpg',3,46.00,138.00,0.00,0.00,138.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(6,2,'Botble\\Ecommerce\\Models\\Product',133,'Basil and chestnut soup',NULL,'products/14.jpg',1,35.00,35.00,0.00,0.00,35.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(7,3,'Botble\\Ecommerce\\Models\\Product',49,'Carpaccio de degrade',NULL,'products/1.jpg',3,41.00,123.00,0.00,0.00,123.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(8,3,'Botble\\Ecommerce\\Models\\Product',89,'Venison and aubergine kebab',NULL,'products/6.jpg',2,32.00,64.00,0.00,0.00,64.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(9,4,'Botble\\Ecommerce\\Models\\Product',74,'Spaghetti',NULL,'products/19.jpg',1,40.00,40.00,0.00,0.00,40.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(10,4,'Botble\\Ecommerce\\Models\\Product',103,'Anise and coconut curry',NULL,'products/26.jpg',2,33.00,66.00,0.00,0.00,66.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(11,4,'Botble\\Ecommerce\\Models\\Product',133,'Basil and chestnut soup',NULL,'products/14.jpg',3,35.00,105.00,0.00,0.00,105.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(12,5,'Botble\\Ecommerce\\Models\\Product',59,'Boiled vegetables',NULL,'products/7.jpg',2,45.00,90.00,0.00,0.00,90.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(13,5,'Botble\\Ecommerce\\Models\\Product',88,'Venison and aubergine kebab',NULL,'products/8.jpg',2,32.00,64.00,0.00,0.00,64.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(14,6,'Botble\\Ecommerce\\Models\\Product',56,'Fried beef',NULL,'products/24.jpg',2,50.00,100.00,0.00,0.00,100.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(15,6,'Botble\\Ecommerce\\Models\\Product',85,'Peppercorn and leek parcels',NULL,'products/4.jpg',2,32.00,64.00,0.00,0.00,64.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(16,7,'Botble\\Ecommerce\\Models\\Product',80,'Turkey meat',NULL,'products/2.jpg',1,33.00,33.00,0.00,0.00,33.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(17,7,'Botble\\Ecommerce\\Models\\Product',94,'Dulse and tumeric salad',NULL,'products/6.jpg',2,40.00,80.00,0.00,0.00,80.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(18,8,'Botble\\Ecommerce\\Models\\Product',44,'Salmon Grav-lax',NULL,'products/24.jpg',1,41.00,41.00,0.00,0.00,41.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(19,8,'Botble\\Ecommerce\\Models\\Product',66,'Pancake',NULL,'products/25.jpg',1,34.00,34.00,0.00,0.00,34.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(20,8,'Botble\\Ecommerce\\Models\\Product',84,'Peppercorn and leek parcels',NULL,'products/22.jpg',2,32.00,64.00,0.00,0.00,64.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(21,8,'Botble\\Ecommerce\\Models\\Product',118,'Bun dau mam tom',NULL,'products/24.jpg',2,33.00,66.00,0.00,0.00,66.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(22,9,'Botble\\Ecommerce\\Models\\Product',52,'Spring roll',NULL,'products/11.jpg',1,47.00,47.00,0.00,0.00,47.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(23,9,'Botble\\Ecommerce\\Models\\Product',106,'Cabbage and rosemary parcels',NULL,'products/17.jpg',2,40.00,80.00,0.00,0.00,80.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(24,10,'Botble\\Ecommerce\\Models\\Product',86,'Lamb and gruyere salad',NULL,'products/18.jpg',3,31.00,93.00,0.00,0.00,93.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(25,10,'Botble\\Ecommerce\\Models\\Product',119,'Onion sandwich with chilli relish',NULL,'products/3.jpg',3,31.00,93.00,0.00,0.00,93.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(26,11,'Botble\\Ecommerce\\Models\\Product',55,'Fish soup',NULL,'products/3.jpg',3,42.00,126.00,0.00,0.00,126.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(27,11,'Botble\\Ecommerce\\Models\\Product',59,'Boiled vegetables',NULL,'products/7.jpg',1,45.00,45.00,0.00,0.00,45.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(28,11,'Botble\\Ecommerce\\Models\\Product',88,'Venison and aubergine kebab',NULL,'products/8.jpg',3,32.00,96.00,0.00,0.00,96.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(29,11,'Botble\\Ecommerce\\Models\\Product',123,'Spinach and aubergine bread',NULL,'products/8.jpg',2,46.00,92.00,0.00,0.00,92.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(30,12,'Botble\\Ecommerce\\Models\\Product',88,'Venison and aubergine kebab',NULL,'products/8.jpg',2,32.00,64.00,0.00,0.00,64.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(31,12,'Botble\\Ecommerce\\Models\\Product',106,'Cabbage and rosemary parcels',NULL,'products/17.jpg',2,40.00,80.00,0.00,0.00,80.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(32,12,'Botble\\Ecommerce\\Models\\Product',124,'Banana and squash madras',NULL,'products/16.jpg',3,50.00,150.00,0.00,0.00,150.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(33,13,'Botble\\Ecommerce\\Models\\Product',93,'Dulse and tumeric salad',NULL,'products/26.jpg',3,40.00,120.00,0.00,0.00,120.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(34,13,'Botble\\Ecommerce\\Models\\Product',132,'Basil and chestnut soup',NULL,'products/22.jpg',1,35.00,35.00,0.00,0.00,35.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(35,14,'Botble\\Ecommerce\\Models\\Product',80,'Turkey meat',NULL,'products/2.jpg',1,33.00,33.00,0.00,0.00,33.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(36,14,'Botble\\Ecommerce\\Models\\Product',96,'Pork and broccoli soup',NULL,'products/9.jpg',1,33.00,33.00,0.00,0.00,33.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(37,14,'Botble\\Ecommerce\\Models\\Product',114,'Banh mi',NULL,'products/18.jpg',3,38.00,114.00,0.00,0.00,114.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(38,15,'Botble\\Ecommerce\\Models\\Product',59,'Boiled vegetables',NULL,'products/7.jpg',2,45.00,90.00,0.00,0.00,90.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(39,15,'Botble\\Ecommerce\\Models\\Product',74,'Spaghetti',NULL,'products/19.jpg',1,40.00,40.00,0.00,0.00,40.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(40,16,'Botble\\Ecommerce\\Models\\Product',66,'Pancake',NULL,'products/25.jpg',2,34.00,68.00,0.00,0.00,68.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(41,16,'Botble\\Ecommerce\\Models\\Product',111,'Leek and mushroom pie',NULL,'products/15.jpg',1,38.00,38.00,0.00,0.00,38.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(42,17,'Botble\\Ecommerce\\Models\\Product',52,'Spring roll',NULL,'products/11.jpg',1,47.00,47.00,0.00,0.00,47.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(43,17,'Botble\\Ecommerce\\Models\\Product',114,'Banh mi',NULL,'products/18.jpg',1,38.00,38.00,0.00,0.00,38.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(44,17,'Botble\\Ecommerce\\Models\\Product',125,'Apple and semolina cake',NULL,'products/5.jpg',3,46.00,138.00,0.00,0.00,138.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(45,17,'Botble\\Ecommerce\\Models\\Product',128,'Raisin and fennel yoghurt',NULL,'products/10.jpg',2,31.00,62.00,0.00,0.00,62.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(46,18,'Botble\\Ecommerce\\Models\\Product',59,'Boiled vegetables',NULL,'products/7.jpg',1,45.00,45.00,0.00,0.00,45.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(47,18,'Botble\\Ecommerce\\Models\\Product',116,'Pho bo',NULL,'products/4.jpg',3,32.00,96.00,0.00,0.00,96.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(48,18,'Botble\\Ecommerce\\Models\\Product',123,'Spinach and aubergine bread',NULL,'products/8.jpg',1,46.00,46.00,0.00,0.00,46.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(49,18,'Botble\\Ecommerce\\Models\\Product',127,'Apple and semolina cake',NULL,'products/16.jpg',2,33.00,66.00,0.00,0.00,66.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(50,19,'Botble\\Ecommerce\\Models\\Product',61,'Omelet',NULL,'products/23.jpg',2,50.00,100.00,0.00,0.00,100.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(51,19,'Botble\\Ecommerce\\Models\\Product',115,'Banh mi',NULL,'products/5.jpg',3,38.00,114.00,0.00,0.00,114.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(52,19,'Botble\\Ecommerce\\Models\\Product',120,'Onion sandwich with chilli relish',NULL,'products/19.jpg',1,31.00,31.00,0.00,0.00,31.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(53,19,'Botble\\Ecommerce\\Models\\Product',133,'Basil and chestnut soup',NULL,'products/14.jpg',3,35.00,105.00,0.00,0.00,105.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(54,20,'Botble\\Ecommerce\\Models\\Product',61,'Omelet',NULL,'products/23.jpg',1,50.00,50.00,0.00,0.00,50.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46'),(55,20,'Botble\\Ecommerce\\Models\\Product',98,'Chickpea and chilli pasta',NULL,'products/1.jpg',1,39.00,39.00,0.00,0.00,39.00,'[]','2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_invoices`
--

DROP TABLE IF EXISTS `ec_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_tax_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` decimal(15,2) unsigned NOT NULL,
  `tax_amount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `shipping_amount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) unsigned NOT NULL DEFAULT '0.00',
  `shipping_option` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `coupon_code` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `payment_id` bigint unsigned DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_invoices_code_unique` (`code`),
  KEY `ec_invoices_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  KEY `ec_invoices_payment_id_index` (`payment_id`),
  KEY `ec_invoices_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_invoices`
--

LOCK TABLES `ec_invoices` WRITE;
/*!40000 ALTER TABLE `ec_invoices` DISABLE KEYS */;
INSERT INTO `ec_invoices` VALUES (1,'Botble\\Ecommerce\\Models\\Order',1,'INV-1','Madalyn Hegmann','',NULL,'douglas.eugenia@example.com','+16807576161','814 Witting Ville Apt. 270, Lake Destinchester, Cove, ET',NULL,71.00,0.00,0.00,0.00,'1','default',NULL,NULL,71.00,NULL,1,'completed','2023-07-02 19:58:46','2023-06-29 11:58:46','2023-07-02 19:58:46'),(2,'Botble\\Ecommerce\\Models\\Order',2,'INV-2','Alayna Mosciski','',NULL,'customer@archielite.com','+15802923308','60461 Larkin Bridge Suite 271, South Chasity, Ramp, AM',NULL,425.00,0.00,0.00,0.00,'1','default',NULL,NULL,425.00,NULL,2,'pending',NULL,'2023-06-28 01:58:46','2023-07-02 19:58:46'),(3,'Botble\\Ecommerce\\Models\\Order',3,'INV-3','Dr. Keyshawn Tromp','',NULL,'vluettgen@example.net','+17158392711','17049 Ferry Villages, Lake Bertram, Wall, BF',NULL,187.00,0.00,0.00,0.00,'1','default',NULL,NULL,187.00,NULL,3,'completed','2023-07-02 19:58:46','2023-06-29 19:58:46','2023-07-02 19:58:46'),(4,'Botble\\Ecommerce\\Models\\Order',4,'INV-4','Alayna Mosciski','',NULL,'customer@archielite.com','+15802923308','60461 Larkin Bridge Suite 271, South Chasity, Ramp, AM',NULL,211.00,0.00,0.00,0.00,'1','default',NULL,NULL,211.00,NULL,4,'pending',NULL,'2023-06-24 07:58:46','2023-07-02 19:58:46'),(5,'Botble\\Ecommerce\\Models\\Order',5,'INV-5','Ms. Dayna Boehm Jr.','',NULL,'dtorp@example.org','+18583729254','159 Kuhlman Place Suite 906, Caroleville, Freeway, MT',NULL,154.00,0.00,0.00,0.00,'1','default',NULL,NULL,154.00,NULL,5,'pending',NULL,'2023-06-19 11:58:46','2023-07-02 19:58:46'),(6,'Botble\\Ecommerce\\Models\\Order',6,'INV-6','Madalyn Hegmann','',NULL,'douglas.eugenia@example.com','+16807576161','814 Witting Ville Apt. 270, Lake Destinchester, Cove, ET',NULL,164.00,0.00,0.00,0.00,'1','default',NULL,NULL,164.00,NULL,6,'completed','2023-07-02 19:58:46','2023-06-22 19:58:46','2023-07-02 19:58:46'),(7,'Botble\\Ecommerce\\Models\\Order',7,'INV-7','Rosanna Nolan II','',NULL,'theron.bednar@example.com','+16465868985','47645 Parker Forest, South Annamarie, Course, MK',NULL,113.00,0.00,0.00,0.00,'1','default',NULL,NULL,113.00,NULL,7,'pending',NULL,'2023-07-01 15:58:46','2023-07-02 19:58:46'),(8,'Botble\\Ecommerce\\Models\\Order',8,'INV-8','Rosanna Nolan II','',NULL,'theron.bednar@example.com','+16465868985','47645 Parker Forest, South Annamarie, Course, MK',NULL,205.00,0.00,0.00,0.00,'1','default',NULL,NULL,205.00,NULL,8,'completed','2023-07-02 19:58:46','2023-06-29 13:58:46','2023-07-02 19:58:46'),(9,'Botble\\Ecommerce\\Models\\Order',9,'INV-9','Rosanna Nolan II','',NULL,'theron.bednar@example.com','+16465868985','47645 Parker Forest, South Annamarie, Course, MK',NULL,127.00,0.00,0.00,0.00,'1','default',NULL,NULL,127.00,NULL,9,'completed','2023-07-02 19:58:46','2023-06-25 19:58:46','2023-07-02 19:58:46'),(10,'Botble\\Ecommerce\\Models\\Order',10,'INV-10','Rosanna Nolan II','',NULL,'theron.bednar@example.com','+16465868985','47645 Parker Forest, South Annamarie, Course, MK',NULL,186.00,0.00,0.00,0.00,'1','default',NULL,NULL,186.00,NULL,10,'completed','2023-07-02 19:58:46','2023-06-30 01:58:46','2023-07-02 19:58:46'),(11,'Botble\\Ecommerce\\Models\\Order',11,'INV-11','Mac Weissnat','',NULL,'jjerde@example.com','+12519765703','15941 Avery Loaf Suite 167, Croninmouth, Harbors, MV',NULL,359.00,0.00,0.00,0.00,'1','default',NULL,NULL,359.00,NULL,11,'completed','2023-07-02 19:58:46','2023-06-28 15:58:46','2023-07-02 19:58:46'),(12,'Botble\\Ecommerce\\Models\\Order',12,'INV-12','Mac Weissnat','',NULL,'jjerde@example.com','+12519765703','15941 Avery Loaf Suite 167, Croninmouth, Harbors, MV',NULL,294.00,0.00,0.00,0.00,'1','default',NULL,NULL,294.00,NULL,12,'completed','2023-07-02 19:58:46','2023-06-30 13:58:46','2023-07-02 19:58:46'),(13,'Botble\\Ecommerce\\Models\\Order',13,'INV-13','Madalyn Hegmann','',NULL,'douglas.eugenia@example.com','+16807576161','814 Witting Ville Apt. 270, Lake Destinchester, Cove, ET',NULL,155.00,0.00,0.00,0.00,'1','default',NULL,NULL,155.00,NULL,13,'completed','2023-07-02 19:58:46','2023-07-02 03:58:46','2023-07-02 19:58:46'),(14,'Botble\\Ecommerce\\Models\\Order',14,'INV-14','Ms. Dayna Boehm Jr.','',NULL,'dtorp@example.org','+18583729254','159 Kuhlman Place Suite 906, Caroleville, Freeway, MT',NULL,180.00,0.00,0.00,0.00,'1','default',NULL,NULL,180.00,NULL,14,'completed','2023-07-02 19:58:46','2023-06-26 23:58:46','2023-07-02 19:58:46'),(15,'Botble\\Ecommerce\\Models\\Order',15,'INV-15','Delpha Monahan','',NULL,'peter35@example.org','+16512389319','6795 Shayna Plaza Apt. 767, South Billshire, Mills, MD',NULL,130.00,0.00,0.00,0.00,'1','default',NULL,NULL,130.00,NULL,15,'completed','2023-07-02 19:58:46','2023-06-30 19:58:46','2023-07-02 19:58:46'),(16,'Botble\\Ecommerce\\Models\\Order',16,'INV-16','Madalyn Hegmann','',NULL,'douglas.eugenia@example.com','+16807576161','814 Witting Ville Apt. 270, Lake Destinchester, Cove, ET',NULL,106.00,0.00,0.00,0.00,'1','default',NULL,NULL,106.00,NULL,16,'completed','2023-07-02 19:58:46','2023-07-01 13:58:46','2023-07-02 19:58:46'),(17,'Botble\\Ecommerce\\Models\\Order',17,'INV-17','Alayna Mosciski','',NULL,'customer@archielite.com','+15802923308','60461 Larkin Bridge Suite 271, South Chasity, Ramp, AM',NULL,285.00,0.00,0.00,0.00,'1','default',NULL,NULL,285.00,NULL,17,'completed','2023-07-02 19:58:46','2023-07-01 03:58:46','2023-07-02 19:58:46'),(18,'Botble\\Ecommerce\\Models\\Order',18,'INV-18','Delpha Monahan','',NULL,'peter35@example.org','+16512389319','6795 Shayna Plaza Apt. 767, South Billshire, Mills, MD',NULL,253.00,0.00,0.00,0.00,'1','default',NULL,NULL,253.00,NULL,18,'pending',NULL,'2023-07-01 07:58:46','2023-07-02 19:58:46'),(19,'Botble\\Ecommerce\\Models\\Order',19,'INV-19','Mac Weissnat','',NULL,'jjerde@example.com','+12519765703','15941 Avery Loaf Suite 167, Croninmouth, Harbors, MV',NULL,350.00,0.00,0.00,0.00,'1','default',NULL,NULL,350.00,NULL,19,'completed','2023-07-02 19:58:46','2023-07-02 07:58:46','2023-07-02 19:58:46'),(20,'Botble\\Ecommerce\\Models\\Order',20,'INV-20','Delpha Monahan','',NULL,'peter35@example.org','+16512389319','6795 Shayna Plaza Apt. 767, South Billshire, Mills, MD',NULL,89.00,0.00,0.00,0.00,'1','default',NULL,NULL,89.00,NULL,20,'completed','2023-07-02 19:58:46','2023-07-02 17:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_option_value`
--

DROP TABLE IF EXISTS `ec_option_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_option_value` (
  `option_id` bigint unsigned NOT NULL COMMENT 'option id',
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_value` tinytext COLLATE utf8mb4_unicode_ci COMMENT 'option value',
  `affect_price` double DEFAULT NULL COMMENT 'value of price of this option affect',
  `order` int NOT NULL DEFAULT '9999',
  `affect_type` tinyint NOT NULL DEFAULT '0' COMMENT '0. fixed 1. percent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_option_value`
--

LOCK TABLES `ec_option_value` WRITE;
/*!40000 ALTER TABLE `ec_option_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_option_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_option_value_translations`
--

DROP TABLE IF EXISTS `ec_option_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_option_value_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_option_value_id` bigint unsigned NOT NULL,
  `option_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_option_value_translations`
--

LOCK TABLES `ec_option_value_translations` WRITE;
/*!40000 ALTER TABLE `ec_option_value_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_option_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_options`
--

DROP TABLE IF EXISTS `ec_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of options',
  `option_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'option type',
  `product_id` bigint unsigned NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '9999',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Checked if this option is required',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_options`
--

LOCK TABLES `ec_options` WRITE;
/*!40000 ALTER TABLE `ec_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_options_translations`
--

DROP TABLE IF EXISTS `ec_options_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_options_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_options_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_options_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_options_translations`
--

LOCK TABLES `ec_options_translations` WRITE;
/*!40000 ALTER TABLE `ec_options_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_options_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_addresses`
--

DROP TABLE IF EXISTS `ec_order_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint unsigned NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shipping_address',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_addresses`
--

LOCK TABLES `ec_order_addresses` WRITE;
/*!40000 ALTER TABLE `ec_order_addresses` DISABLE KEYS */;
INSERT INTO `ec_order_addresses` VALUES (1,'Madalyn Hegmann','+16807576161','douglas.eugenia@example.com','ET','Cove','Lake Destinchester','814 Witting Ville Apt. 270',1,'08961','shipping_address'),(2,'Alayna Mosciski','+15802923308','customer@archielite.com','AM','Ramp','South Chasity','60461 Larkin Bridge Suite 271',2,'32002-0100','shipping_address'),(3,'Dr. Keyshawn Tromp','+17158392711','vluettgen@example.net','BF','Wall','Lake Bertram','17049 Ferry Villages',3,'96433','shipping_address'),(4,'Alayna Mosciski','+15802923308','customer@archielite.com','AM','Ramp','South Chasity','60461 Larkin Bridge Suite 271',4,'32002-0100','shipping_address'),(5,'Ms. Dayna Boehm Jr.','+18583729254','dtorp@example.org','MT','Freeway','Caroleville','159 Kuhlman Place Suite 906',5,'15029','shipping_address'),(6,'Madalyn Hegmann','+16807576161','douglas.eugenia@example.com','ET','Cove','Lake Destinchester','814 Witting Ville Apt. 270',6,'08961','shipping_address'),(7,'Rosanna Nolan II','+16465868985','theron.bednar@example.com','MK','Course','South Annamarie','47645 Parker Forest',7,'12865-1380','shipping_address'),(8,'Rosanna Nolan II','+16465868985','theron.bednar@example.com','MK','Course','South Annamarie','47645 Parker Forest',8,'12865-1380','shipping_address'),(9,'Rosanna Nolan II','+16465868985','theron.bednar@example.com','MK','Course','South Annamarie','47645 Parker Forest',9,'12865-1380','shipping_address'),(10,'Rosanna Nolan II','+16465868985','theron.bednar@example.com','MK','Course','South Annamarie','47645 Parker Forest',10,'12865-1380','shipping_address'),(11,'Mac Weissnat','+12519765703','jjerde@example.com','MV','Harbors','Croninmouth','15941 Avery Loaf Suite 167',11,'06183','shipping_address'),(12,'Mac Weissnat','+12519765703','jjerde@example.com','MV','Harbors','Croninmouth','15941 Avery Loaf Suite 167',12,'06183','shipping_address'),(13,'Madalyn Hegmann','+16807576161','douglas.eugenia@example.com','ET','Cove','Lake Destinchester','814 Witting Ville Apt. 270',13,'08961','shipping_address'),(14,'Ms. Dayna Boehm Jr.','+18583729254','dtorp@example.org','MT','Freeway','Caroleville','159 Kuhlman Place Suite 906',14,'15029','shipping_address'),(15,'Delpha Monahan','+16512389319','peter35@example.org','MD','Mills','South Billshire','6795 Shayna Plaza Apt. 767',15,'50874-2983','shipping_address'),(16,'Madalyn Hegmann','+16807576161','douglas.eugenia@example.com','ET','Cove','Lake Destinchester','814 Witting Ville Apt. 270',16,'08961','shipping_address'),(17,'Alayna Mosciski','+15802923308','customer@archielite.com','AM','Ramp','South Chasity','60461 Larkin Bridge Suite 271',17,'32002-0100','shipping_address'),(18,'Delpha Monahan','+16512389319','peter35@example.org','MD','Mills','South Billshire','6795 Shayna Plaza Apt. 767',18,'50874-2983','shipping_address'),(19,'Mac Weissnat','+12519765703','jjerde@example.com','MV','Harbors','Croninmouth','15941 Avery Loaf Suite 167',19,'06183','shipping_address'),(20,'Delpha Monahan','+16512389319','peter35@example.org','MD','Mills','South Billshire','6795 Shayna Plaza Apt. 767',20,'50874-2983','shipping_address');
/*!40000 ALTER TABLE `ec_order_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_histories`
--

DROP TABLE IF EXISTS `ec_order_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned NOT NULL,
  `extras` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_histories`
--

LOCK TABLES `ec_order_histories` WRITE;
/*!40000 ALTER TABLE `ec_order_histories` DISABLE KEYS */;
INSERT INTO `ec_order_histories` VALUES (1,'create_order_from_seeder','Order is created from the checkout page',NULL,1,NULL,'2023-06-29 11:58:46','2023-06-29 11:58:46'),(2,'confirm_order','Order was verified by %user_name%',0,1,NULL,'2023-06-29 11:58:46','2023-06-29 11:58:46'),(3,'confirm_payment','Payment was confirmed (amount $71.00) by %user_name%',0,1,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,'create_shipment','Created shipment for order',0,1,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(5,'create_order_from_seeder','Order is created from the checkout page',NULL,2,NULL,'2023-06-28 01:58:46','2023-06-28 01:58:46'),(6,'confirm_order','Order was verified by %user_name%',0,2,NULL,'2023-06-28 01:58:46','2023-06-28 01:58:46'),(7,'create_shipment','Created shipment for order',0,2,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(8,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,2,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(9,'create_order_from_seeder','Order is created from the checkout page',NULL,3,NULL,'2023-06-29 19:58:46','2023-06-29 19:58:46'),(10,'confirm_order','Order was verified by %user_name%',0,3,NULL,'2023-06-29 19:58:46','2023-06-29 19:58:46'),(11,'confirm_payment','Payment was confirmed (amount $187.00) by %user_name%',0,3,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(12,'create_shipment','Created shipment for order',0,3,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(13,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,3,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(14,'create_order_from_seeder','Order is created from the checkout page',NULL,4,NULL,'2023-06-24 07:58:46','2023-06-24 07:58:46'),(15,'confirm_order','Order was verified by %user_name%',0,4,NULL,'2023-06-24 07:58:46','2023-06-24 07:58:46'),(16,'create_shipment','Created shipment for order',0,4,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(17,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,4,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(18,'create_order_from_seeder','Order is created from the checkout page',NULL,5,NULL,'2023-06-19 11:58:46','2023-06-19 11:58:46'),(19,'confirm_order','Order was verified by %user_name%',0,5,NULL,'2023-06-19 11:58:46','2023-06-19 11:58:46'),(20,'create_shipment','Created shipment for order',0,5,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(21,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,5,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(22,'create_order_from_seeder','Order is created from the checkout page',NULL,6,NULL,'2023-06-22 19:58:46','2023-06-22 19:58:46'),(23,'confirm_order','Order was verified by %user_name%',0,6,NULL,'2023-06-22 19:58:46','2023-06-22 19:58:46'),(24,'confirm_payment','Payment was confirmed (amount $164.00) by %user_name%',0,6,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(25,'create_shipment','Created shipment for order',0,6,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(26,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,6,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(27,'create_order_from_seeder','Order is created from the checkout page',NULL,7,NULL,'2023-07-01 15:58:46','2023-07-01 15:58:46'),(28,'confirm_order','Order was verified by %user_name%',0,7,NULL,'2023-07-01 15:58:46','2023-07-01 15:58:46'),(29,'create_shipment','Created shipment for order',0,7,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(30,'create_order_from_seeder','Order is created from the checkout page',NULL,8,NULL,'2023-06-29 13:58:46','2023-06-29 13:58:46'),(31,'confirm_order','Order was verified by %user_name%',0,8,NULL,'2023-06-29 13:58:46','2023-06-29 13:58:46'),(32,'confirm_payment','Payment was confirmed (amount $205.00) by %user_name%',0,8,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(33,'create_shipment','Created shipment for order',0,8,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(34,'create_order_from_seeder','Order is created from the checkout page',NULL,9,NULL,'2023-06-25 19:58:46','2023-06-25 19:58:46'),(35,'confirm_order','Order was verified by %user_name%',0,9,NULL,'2023-06-25 19:58:46','2023-06-25 19:58:46'),(36,'confirm_payment','Payment was confirmed (amount $127.00) by %user_name%',0,9,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(37,'create_shipment','Created shipment for order',0,9,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(38,'create_order_from_seeder','Order is created from the checkout page',NULL,10,NULL,'2023-06-30 01:58:46','2023-06-30 01:58:46'),(39,'confirm_order','Order was verified by %user_name%',0,10,NULL,'2023-06-30 01:58:46','2023-06-30 01:58:46'),(40,'confirm_payment','Payment was confirmed (amount $186.00) by %user_name%',0,10,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(41,'create_shipment','Created shipment for order',0,10,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(42,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,10,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(43,'create_order_from_seeder','Order is created from the checkout page',NULL,11,NULL,'2023-06-28 15:58:46','2023-06-28 15:58:46'),(44,'confirm_order','Order was verified by %user_name%',0,11,NULL,'2023-06-28 15:58:46','2023-06-28 15:58:46'),(45,'confirm_payment','Payment was confirmed (amount $359.00) by %user_name%',0,11,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(46,'create_shipment','Created shipment for order',0,11,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(47,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,11,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(48,'create_order_from_seeder','Order is created from the checkout page',NULL,12,NULL,'2023-06-30 13:58:46','2023-06-30 13:58:46'),(49,'confirm_order','Order was verified by %user_name%',0,12,NULL,'2023-06-30 13:58:46','2023-06-30 13:58:46'),(50,'confirm_payment','Payment was confirmed (amount $294.00) by %user_name%',0,12,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(51,'create_shipment','Created shipment for order',0,12,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(52,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,12,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(53,'create_order_from_seeder','Order is created from the checkout page',NULL,13,NULL,'2023-07-02 03:58:46','2023-07-02 03:58:46'),(54,'confirm_order','Order was verified by %user_name%',0,13,NULL,'2023-07-02 03:58:46','2023-07-02 03:58:46'),(55,'confirm_payment','Payment was confirmed (amount $155.00) by %user_name%',0,13,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(56,'create_shipment','Created shipment for order',0,13,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(57,'create_order_from_seeder','Order is created from the checkout page',NULL,14,NULL,'2023-06-26 23:58:46','2023-06-26 23:58:46'),(58,'confirm_order','Order was verified by %user_name%',0,14,NULL,'2023-06-26 23:58:46','2023-06-26 23:58:46'),(59,'confirm_payment','Payment was confirmed (amount $180.00) by %user_name%',0,14,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(60,'create_shipment','Created shipment for order',0,14,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(61,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,14,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(62,'create_order_from_seeder','Order is created from the checkout page',NULL,15,NULL,'2023-06-30 19:58:46','2023-06-30 19:58:46'),(63,'confirm_order','Order was verified by %user_name%',0,15,NULL,'2023-06-30 19:58:46','2023-06-30 19:58:46'),(64,'confirm_payment','Payment was confirmed (amount $130.00) by %user_name%',0,15,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(65,'create_shipment','Created shipment for order',0,15,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(66,'create_order_from_seeder','Order is created from the checkout page',NULL,16,NULL,'2023-07-01 13:58:46','2023-07-01 13:58:46'),(67,'confirm_order','Order was verified by %user_name%',0,16,NULL,'2023-07-01 13:58:46','2023-07-01 13:58:46'),(68,'confirm_payment','Payment was confirmed (amount $106.00) by %user_name%',0,16,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(69,'create_shipment','Created shipment for order',0,16,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(70,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,16,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(71,'create_order_from_seeder','Order is created from the checkout page',NULL,17,NULL,'2023-07-01 03:58:46','2023-07-01 03:58:46'),(72,'confirm_order','Order was verified by %user_name%',0,17,NULL,'2023-07-01 03:58:46','2023-07-01 03:58:46'),(73,'confirm_payment','Payment was confirmed (amount $285.00) by %user_name%',0,17,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(74,'create_shipment','Created shipment for order',0,17,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(75,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,17,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(76,'create_order_from_seeder','Order is created from the checkout page',NULL,18,NULL,'2023-07-01 07:58:46','2023-07-01 07:58:46'),(77,'confirm_order','Order was verified by %user_name%',0,18,NULL,'2023-07-01 07:58:46','2023-07-01 07:58:46'),(78,'create_shipment','Created shipment for order',0,18,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(79,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,18,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(80,'create_order_from_seeder','Order is created from the checkout page',NULL,19,NULL,'2023-07-02 07:58:46','2023-07-02 07:58:46'),(81,'confirm_order','Order was verified by %user_name%',0,19,NULL,'2023-07-02 07:58:46','2023-07-02 07:58:46'),(82,'confirm_payment','Payment was confirmed (amount $350.00) by %user_name%',0,19,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(83,'create_shipment','Created shipment for order',0,19,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(84,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,19,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(85,'create_order_from_seeder','Order is created from the checkout page',NULL,20,NULL,'2023-07-02 17:58:46','2023-07-02 17:58:46'),(86,'confirm_order','Order was verified by %user_name%',0,20,NULL,'2023-07-02 17:58:46','2023-07-02 17:58:46'),(87,'confirm_payment','Payment was confirmed (amount $89.00) by %user_name%',0,20,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(88,'create_shipment','Created shipment for order',0,20,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(89,'update_status','Order confirmed by %user_name%',0,3,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(90,'update_status','Order confirmed by %user_name%',0,6,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(91,'update_status','Order confirmed by %user_name%',0,10,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(92,'update_status','Order confirmed by %user_name%',0,11,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(93,'update_status','Order confirmed by %user_name%',0,12,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(94,'update_status','Order confirmed by %user_name%',0,14,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(95,'update_status','Order confirmed by %user_name%',0,16,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(96,'update_status','Order confirmed by %user_name%',0,17,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46'),(97,'update_status','Order confirmed by %user_name%',0,19,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_order_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_product`
--

DROP TABLE IF EXISTS `ec_order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `qty` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `product_options` text COLLATE utf8mb4_unicode_ci COMMENT 'product option data',
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double(8,2) DEFAULT '0.00',
  `restock_quantity` int unsigned DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'physical',
  `times_downloaded` int NOT NULL DEFAULT '0',
  `license_code` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_product`
--

LOCK TABLES `ec_order_product` WRITE;
/*!40000 ALTER TABLE `ec_order_product` DISABLE KEYS */;
INSERT INTO `ec_order_product` VALUES (1,1,1,33.00,0.00,'[]',NULL,80,'Turkey meat','products/2.jpg',755.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(2,1,1,38.00,0.00,'[]',NULL,110,'Leek and mushroom pie','products/23.jpg',716.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(3,2,3,45.00,0.00,'[]',NULL,59,'Boiled vegetables','products/7.jpg',1770.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(4,2,3,39.00,0.00,'[]',NULL,99,'Chickpea and chilli pasta','products/17.jpg',1815.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(5,2,3,46.00,0.00,'[]',NULL,123,'Spinach and aubergine bread','products/8.jpg',1770.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(6,2,1,35.00,0.00,'[]',NULL,133,'Basil and chestnut soup','products/14.jpg',686.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(7,3,3,41.00,0.00,'[]',NULL,49,'Carpaccio de degrade','products/1.jpg',1800.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(8,3,2,32.00,0.00,'[]',NULL,89,'Venison and aubergine kebab','products/6.jpg',1606.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(9,4,1,40.00,0.00,'[]',NULL,74,'Spaghetti','products/19.jpg',881.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(10,4,2,33.00,0.00,'[]',NULL,103,'Anise and coconut curry','products/26.jpg',1706.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(11,4,3,35.00,0.00,'[]',NULL,133,'Basil and chestnut soup','products/14.jpg',2058.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(12,5,2,45.00,0.00,'[]',NULL,59,'Boiled vegetables','products/7.jpg',1180.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(13,5,2,32.00,0.00,'[]',NULL,88,'Venison and aubergine kebab','products/8.jpg',1606.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(14,6,2,50.00,0.00,'[]',NULL,56,'Fried beef','products/24.jpg',1348.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(15,6,2,32.00,0.00,'[]',NULL,85,'Peppercorn and leek parcels','products/4.jpg',1008.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(16,7,1,33.00,0.00,'[]',NULL,80,'Turkey meat','products/2.jpg',755.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(17,7,2,40.00,0.00,'[]',NULL,94,'Dulse and tumeric salad','products/6.jpg',1732.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(18,8,1,41.00,0.00,'[]',NULL,44,'Salmon Grav-lax','products/24.jpg',698.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(19,8,1,34.00,0.00,'[]',NULL,66,'Pancake','products/25.jpg',802.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(20,8,2,32.00,0.00,'[]',NULL,84,'Peppercorn and leek parcels','products/22.jpg',1008.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(21,8,2,33.00,0.00,'[]',NULL,118,'Bun dau mam tom','products/24.jpg',1696.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(22,9,1,47.00,0.00,'[]',NULL,52,'Spring roll','products/11.jpg',832.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(23,9,2,40.00,0.00,'[]',NULL,106,'Cabbage and rosemary parcels','products/17.jpg',1364.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(24,10,3,31.00,0.00,'[]',NULL,86,'Lamb and gruyere salad','products/18.jpg',1977.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(25,10,3,31.00,0.00,'[]',NULL,119,'Onion sandwich with chilli relish','products/3.jpg',1809.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(26,11,3,42.00,0.00,'[]',NULL,55,'Fish soup','products/3.jpg',2082.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(27,11,1,45.00,0.00,'[]',NULL,59,'Boiled vegetables','products/7.jpg',590.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(28,11,3,32.00,0.00,'[]',NULL,88,'Venison and aubergine kebab','products/8.jpg',2409.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(29,11,2,46.00,0.00,'[]',NULL,123,'Spinach and aubergine bread','products/8.jpg',1180.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(30,12,2,32.00,0.00,'[]',NULL,88,'Venison and aubergine kebab','products/8.jpg',1606.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(31,12,2,40.00,0.00,'[]',NULL,106,'Cabbage and rosemary parcels','products/17.jpg',1364.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(32,12,3,50.00,0.00,'[]',NULL,124,'Banana and squash madras','products/16.jpg',2004.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(33,13,3,40.00,0.00,'[]',NULL,93,'Dulse and tumeric salad','products/26.jpg',2598.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(34,13,1,35.00,0.00,'[]',NULL,132,'Basil and chestnut soup','products/22.jpg',686.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(35,14,1,33.00,0.00,'[]',NULL,80,'Turkey meat','products/2.jpg',755.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(36,14,1,33.00,0.00,'[]',NULL,96,'Pork and broccoli soup','products/9.jpg',725.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(37,14,3,38.00,0.00,'[]',NULL,114,'Banh mi','products/18.jpg',1800.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(38,15,2,45.00,0.00,'[]',NULL,59,'Boiled vegetables','products/7.jpg',1180.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(39,15,1,40.00,0.00,'[]',NULL,74,'Spaghetti','products/19.jpg',881.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(40,16,2,34.00,0.00,'[]',NULL,66,'Pancake','products/25.jpg',1604.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(41,16,1,38.00,0.00,'[]',NULL,111,'Leek and mushroom pie','products/15.jpg',716.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(42,17,1,47.00,0.00,'[]',NULL,52,'Spring roll','products/11.jpg',832.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(43,17,1,38.00,0.00,'[]',NULL,114,'Banh mi','products/18.jpg',600.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(44,17,3,46.00,0.00,'[]',NULL,125,'Apple and semolina cake','products/5.jpg',2058.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(45,17,2,31.00,0.00,'[]',NULL,128,'Raisin and fennel yoghurt','products/10.jpg',1128.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(46,18,1,45.00,0.00,'[]',NULL,59,'Boiled vegetables','products/7.jpg',590.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(47,18,3,32.00,0.00,'[]',NULL,116,'Pho bo','products/4.jpg',2271.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(48,18,1,46.00,0.00,'[]',NULL,123,'Spinach and aubergine bread','products/8.jpg',590.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(49,18,2,33.00,0.00,'[]',NULL,127,'Apple and semolina cake','products/16.jpg',1162.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(50,19,2,50.00,0.00,'[]',NULL,61,'Omelet','products/23.jpg',1174.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(51,19,3,38.00,0.00,'[]',NULL,115,'Banh mi','products/5.jpg',1800.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(52,19,1,31.00,0.00,'[]',NULL,120,'Onion sandwich with chilli relish','products/19.jpg',603.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(53,19,3,35.00,0.00,'[]',NULL,133,'Basil and chestnut soup','products/14.jpg',2058.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(54,20,1,50.00,0.00,'[]',NULL,61,'Omelet','products/23.jpg',587.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL),(55,20,1,39.00,0.00,'[]',NULL,98,'Chickpea and chilli pasta','products/1.jpg',605.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','physical',0,NULL);
/*!40000 ALTER TABLE `ec_order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_referrals`
--

DROP TABLE IF EXISTS `ec_order_referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_referrals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landing_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landing_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landing_params` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gclid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fclid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_campaign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_medium` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_term` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utm_content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer_url` text COLLATE utf8mb4_unicode_ci,
  `referrer_domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_order_referrals_order_id_index` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_referrals`
--

LOCK TABLES `ec_order_referrals` WRITE;
/*!40000 ALTER TABLE `ec_order_referrals` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_order_referrals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_return_items`
--

DROP TABLE IF EXISTS `ec_order_return_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_return_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_return_id` bigint unsigned NOT NULL COMMENT 'Order return id',
  `order_product_id` bigint unsigned NOT NULL COMMENT 'Order product id',
  `product_id` bigint unsigned NOT NULL COMMENT 'Product id',
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int NOT NULL COMMENT 'Quantity return',
  `price` decimal(15,2) NOT NULL COMMENT 'Price Product',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `refund_amount` decimal(12,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_return_items`
--

LOCK TABLES `ec_order_return_items` WRITE;
/*!40000 ALTER TABLE `ec_order_return_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_order_return_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_returns`
--

DROP TABLE IF EXISTS `ec_order_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` bigint unsigned NOT NULL COMMENT 'Order ID',
  `store_id` bigint unsigned DEFAULT NULL COMMENT 'Store ID',
  `user_id` bigint unsigned NOT NULL COMMENT 'Customer ID',
  `reason` text COLLATE utf8mb4_unicode_ci COMMENT 'Reason return order',
  `order_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Order current status',
  `return_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Return status',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_order_returns_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_returns`
--

LOCK TABLES `ec_order_returns` WRITE;
/*!40000 ALTER TABLE `ec_order_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_order_returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_order_tax_information`
--

DROP TABLE IF EXISTS `ec_order_tax_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_order_tax_information` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `company_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_tax_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_order_tax_information_order_id_index` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_order_tax_information`
--

LOCK TABLES `ec_order_tax_information` WRITE;
/*!40000 ALTER TABLE `ec_order_tax_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_order_tax_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_orders`
--

DROP TABLE IF EXISTS `ec_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `shipping_option` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `status` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` decimal(15,2) NOT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `shipping_amount` decimal(15,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `coupon_code` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `sub_total` decimal(15,2) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `discount_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_finished` tinyint(1) DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `token` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_orders_code_unique` (`code`),
  KEY `ec_orders_user_id_status_created_at_index` (`user_id`,`status`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_orders`
--

LOCK TABLES `ec_orders` WRITE;
/*!40000 ALTER TABLE `ec_orders` DISABLE KEYS */;
INSERT INTO `ec_orders` VALUES (1,'#10000001',5,'1','default','pending',71.00,0.00,0.00,NULL,NULL,0.00,71.00,1,NULL,1,NULL,'A4gjfPvwwb29d8iyEuRDVzPMSKA8K',1,'2023-06-29 11:58:46','2023-07-02 19:58:46'),(2,'#10000002',1,'1','default','completed',425.00,0.00,0.00,NULL,NULL,0.00,425.00,1,NULL,1,'2023-07-02 19:58:46','UFqyNA58BWjEVgm5yDNf6ovGN9Hl5',2,'2023-06-28 01:58:46','2023-07-02 19:58:46'),(3,'#10000003',7,'1','default','completed',187.00,0.00,0.00,NULL,NULL,0.00,187.00,1,NULL,1,'2023-07-02 19:58:46','2irsfJOURqrdGAp9lQgatxz2QZ9Vr',3,'2023-06-29 19:58:46','2023-07-02 19:58:46'),(4,'#10000004',1,'1','default','completed',211.00,0.00,0.00,NULL,NULL,0.00,211.00,1,NULL,1,'2023-07-02 19:58:46','CqN4Gsk80pgE1ZfnErsiHRgOeSAG9',4,'2023-06-24 07:58:46','2023-07-02 19:58:46'),(5,'#10000005',6,'1','default','completed',154.00,0.00,0.00,NULL,NULL,0.00,154.00,1,NULL,1,'2023-07-02 19:58:46','hwphwbKTnqPkXLzVSNWoyUaEyaOeL',5,'2023-06-19 11:58:46','2023-07-02 19:58:46'),(6,'#10000006',5,'1','default','completed',164.00,0.00,0.00,NULL,NULL,0.00,164.00,1,NULL,1,'2023-07-02 19:58:46','wYtDhNJAxvanxjUVlDoGUk2ixD9K3',6,'2023-06-22 19:58:46','2023-07-02 19:58:46'),(7,'#10000007',2,'1','default','pending',113.00,0.00,0.00,NULL,NULL,0.00,113.00,1,NULL,1,NULL,'jsZtreebjF0GKwRnDPhRXJP1nzwWV',7,'2023-07-01 15:58:46','2023-07-02 19:58:46'),(8,'#10000008',2,'1','default','pending',205.00,0.00,0.00,NULL,NULL,0.00,205.00,1,NULL,1,NULL,'mcA1vZ6VGbRbDnLeTnnyRyCtJv76I',8,'2023-06-29 13:58:46','2023-07-02 19:58:46'),(9,'#10000009',2,'1','default','pending',127.00,0.00,0.00,NULL,NULL,0.00,127.00,1,NULL,1,NULL,'CAph9MVdlwurQNk4H17SaJwFnZ2w8',9,'2023-06-25 19:58:46','2023-07-02 19:58:46'),(10,'#10000010',2,'1','default','completed',186.00,0.00,0.00,NULL,NULL,0.00,186.00,1,NULL,1,'2023-07-02 19:58:46','7DgurkNzvD2cftzYv6LcNTRq71A1E',10,'2023-06-30 01:58:46','2023-07-02 19:58:46'),(11,'#10000011',4,'1','default','completed',359.00,0.00,0.00,NULL,NULL,0.00,359.00,1,NULL,1,'2023-07-02 19:58:46','8QuVsqWoIxyyfO2gCrIezRhtKnLXu',11,'2023-06-28 15:58:46','2023-07-02 19:58:46'),(12,'#10000012',4,'1','default','completed',294.00,0.00,0.00,NULL,NULL,0.00,294.00,1,NULL,1,'2023-07-02 19:58:46','aoVW8ZFUTIO3PopAP9hBYOf8hEDgI',12,'2023-06-30 13:58:46','2023-07-02 19:58:46'),(13,'#10000013',5,'1','default','pending',155.00,0.00,0.00,NULL,NULL,0.00,155.00,1,NULL,1,NULL,'54LKVLbJeaMOBFhxabvezvc14jR53',13,'2023-07-02 03:58:46','2023-07-02 19:58:46'),(14,'#10000014',6,'1','default','completed',180.00,0.00,0.00,NULL,NULL,0.00,180.00,1,NULL,1,'2023-07-02 19:58:46','LQRpFshKYms8QbCIHhAWRUJKcTWrs',14,'2023-06-26 23:58:46','2023-07-02 19:58:46'),(15,'#10000015',8,'1','default','pending',130.00,0.00,0.00,NULL,NULL,0.00,130.00,1,NULL,1,NULL,'hPaLTZmTX7EU4RjLEO1WNHP7RpnEZ',15,'2023-06-30 19:58:46','2023-07-02 19:58:46'),(16,'#10000016',5,'1','default','completed',106.00,0.00,0.00,NULL,NULL,0.00,106.00,1,NULL,1,'2023-07-02 19:58:46','618P8qu8VFKYNijSr5De2Bh1ET9pJ',16,'2023-07-01 13:58:46','2023-07-02 19:58:46'),(17,'#10000017',1,'1','default','completed',285.00,0.00,0.00,NULL,NULL,0.00,285.00,1,NULL,1,'2023-07-02 19:58:46','Cl89m8Bw1UZ5ujF0ldMuOW5pvuq6E',17,'2023-07-01 03:58:46','2023-07-02 19:58:46'),(18,'#10000018',8,'1','default','completed',253.00,0.00,0.00,NULL,NULL,0.00,253.00,1,NULL,1,'2023-07-02 19:58:46','qWlMYjh6m4qfLOpB8w9dO0Q8NaDu4',18,'2023-07-01 07:58:46','2023-07-02 19:58:46'),(19,'#10000019',4,'1','default','completed',350.00,0.00,0.00,NULL,NULL,0.00,350.00,1,NULL,1,'2023-07-02 19:58:46','H0pVE1WyVuXHEICnKPNjppdMJs6GY',19,'2023-07-02 07:58:46','2023-07-02 19:58:46'),(20,'#10000020',8,'1','default','pending',89.00,0.00,0.00,NULL,NULL,0.00,89.00,1,NULL,1,NULL,'dLmWNCuDWVnNaG94KVyNdQWOJAfYM',20,'2023-07-02 17:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_attribute_sets`
--

DROP TABLE IF EXISTS `ec_product_attribute_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_attribute_sets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_layout` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'swatch_dropdown',
  `is_searchable` tinyint unsigned NOT NULL DEFAULT '1',
  `is_comparable` tinyint unsigned NOT NULL DEFAULT '1',
  `is_use_in_product_listing` tinyint unsigned NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `use_image_from_product_variation` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_attribute_sets`
--

LOCK TABLES `ec_product_attribute_sets` WRITE;
/*!40000 ALTER TABLE `ec_product_attribute_sets` DISABLE KEYS */;
INSERT INTO `ec_product_attribute_sets` VALUES (1,'Color','color','visual',1,1,1,'published',0,'2023-07-02 19:58:45','2023-07-02 19:58:45',0),(2,'Weight','weight','text',1,1,1,'published',0,'2023-07-02 19:58:45','2023-07-02 19:58:45',0);
/*!40000 ALTER TABLE `ec_product_attribute_sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_attribute_sets_translations`
--

DROP TABLE IF EXISTS `ec_product_attribute_sets_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_attribute_sets_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_attribute_sets_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_product_attribute_sets_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_attribute_sets_translations`
--

LOCK TABLES `ec_product_attribute_sets_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_attribute_sets_translations` DISABLE KEYS */;
INSERT INTO `ec_product_attribute_sets_translations` VALUES ('vi',1,'Màu sắc'),('vi',2,'Kích thước');
/*!40000 ALTER TABLE `ec_product_attribute_sets_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_attributes`
--

DROP TABLE IF EXISTS `ec_product_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_set_id` bigint unsigned NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_product_attributes_attribute_set_id_status_index` (`attribute_set_id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_attributes`
--

LOCK TABLES `ec_product_attributes` WRITE;
/*!40000 ALTER TABLE `ec_product_attributes` DISABLE KEYS */;
INSERT INTO `ec_product_attributes` VALUES (1,1,'Green','green','#5FB7D4',NULL,1,1,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(2,1,'Blue','blue','#333333',NULL,0,2,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(3,1,'Red','red','#DA323F',NULL,0,3,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(4,1,'Black','back','#2F366C',NULL,0,4,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(5,1,'Brown','brown','#87554B',NULL,0,5,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(6,2,'1KG','1kg',NULL,NULL,1,1,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(7,2,'2KG','2kg',NULL,NULL,0,2,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(8,2,'3KG','3kg',NULL,NULL,0,3,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(9,2,'4KG','4kg',NULL,NULL,0,4,'published','2023-07-02 19:58:45','2023-07-02 19:58:45'),(10,2,'5KG','5kg',NULL,NULL,0,5,'published','2023-07-02 19:58:45','2023-07-02 19:58:45');
/*!40000 ALTER TABLE `ec_product_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_attributes_translations`
--

DROP TABLE IF EXISTS `ec_product_attributes_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_attributes_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_attributes_id` bigint unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_product_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_attributes_translations`
--

LOCK TABLES `ec_product_attributes_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_attributes_translations` DISABLE KEYS */;
INSERT INTO `ec_product_attributes_translations` VALUES ('vi',1,'Xanh lá cây'),('vi',2,'Xanh da trời'),('vi',3,'Đỏ'),('vi',4,'Đen'),('vi',5,'Nâu'),('vi',6,'1KG'),('vi',7,'2KG'),('vi',8,'3KG'),('vi',9,'4KG'),('vi',10,'5KG');
/*!40000 ALTER TABLE `ec_product_attributes_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_categories`
--

DROP TABLE IF EXISTS `ec_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `order` int unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_product_categories_parent_id_status_created_at_index` (`parent_id`,`status`,`created_at`),
  KEY `ec_product_categories_parent_id_status_index` (`parent_id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_categories`
--

LOCK TABLES `ec_product_categories` WRITE;
/*!40000 ALTER TABLE `ec_product_categories` DISABLE KEYS */;
INSERT INTO `ec_product_categories` VALUES (1,'Starters',0,'English, who wanted leaders, and had just begun to repeat it, but her voice sounded hoarse and strange, and the poor little thing sobbed again (or grunted, it was written to nobody, which isn\'t.','published',0,'product-categories/1.png',1,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'Main dishes',0,'King: \'however, it may kiss my hand if it had VERY long claws and a sad tale!\' said the Lory, with a whiting. Now you know.\' \'I don\'t know where Dinn may be,\' said the Pigeon in a natural way. \'I.','published',1,'product-categories/2.png',0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'Drinks',0,'WAS a narrow escape!\' said Alice, and she heard the Rabbit coming to look for her, and she tried the little glass table. \'Now, I\'ll manage better this time,\' she said to the company generally, \'You.','published',2,'product-categories/3.png',0,'2023-07-02 19:58:41','2023-07-02 19:58:41'),(4,'Desserts',0,'Alice thought decidedly uncivil. \'But perhaps he can\'t help that,\' said Alice. \'Nothing WHATEVER?\' persisted the King. The White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' the.','published',3,'product-categories/4.png',1,'2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `ec_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_categories_translations`
--

DROP TABLE IF EXISTS `ec_product_categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_categories_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_categories_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`ec_product_categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_categories_translations`
--

LOCK TABLES `ec_product_categories_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_categories_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_categories_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_categorizables`
--

DROP TABLE IF EXISTS `ec_product_categorizables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_categorizables` (
  `category_id` bigint unsigned NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`reference_id`,`reference_type`),
  KEY `ec_product_categorizables_category_id_index` (`category_id`),
  KEY `ec_product_categorizables_reference_id_index` (`reference_id`),
  KEY `ec_product_categorizables_reference_type_index` (`reference_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_categorizables`
--

LOCK TABLES `ec_product_categorizables` WRITE;
/*!40000 ALTER TABLE `ec_product_categorizables` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_categorizables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_category_product`
--

DROP TABLE IF EXISTS `ec_product_category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_category_product` (
  `category_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `ec_product_category_product_category_id_index` (`category_id`),
  KEY `ec_product_category_product_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_category_product`
--

LOCK TABLES `ec_product_category_product` WRITE;
/*!40000 ALTER TABLE `ec_product_category_product` DISABLE KEYS */;
INSERT INTO `ec_product_category_product` VALUES (1,12),(1,20),(1,37),(1,39),(1,40),(2,7),(2,8),(2,11),(2,17),(2,31),(3,14),(3,21),(4,3),(4,7),(4,17),(4,33),(6,13),(6,24),(6,30),(7,2),(7,7),(7,38),(8,2),(8,4),(8,9),(8,25),(9,3),(9,32),(10,5),(10,16),(10,18),(10,21),(10,22),(10,29),(10,30),(11,2),(11,3),(11,14),(11,21),(11,25),(11,32),(11,41),(12,26),(13,10),(13,11),(14,10),(14,27),(14,28),(14,32),(14,33),(15,28),(15,34),(15,37),(16,9),(16,12),(16,15),(16,20),(16,34),(16,35),(16,41),(17,8),(17,12),(17,26),(17,34),(17,37),(18,15),(18,20),(18,32),(19,1),(19,22),(20,14),(20,21),(20,24),(20,29),(20,39),(21,6),(21,23),(21,40),(22,6),(22,7),(22,11),(22,16),(23,1),(23,10),(23,15),(23,27),(23,33),(24,13),(24,37),(24,40),(25,1),(25,2),(25,18),(25,19),(25,22),(25,28),(25,31),(25,36),(25,38),(25,41),(26,9),(26,17),(26,24),(26,25),(27,4),(27,8),(27,19),(28,6),(28,8),(28,13),(28,19),(28,23),(28,27),(28,31),(28,36),(28,38),(29,3),(29,14),(29,23),(29,26),(29,35),(30,4),(30,5),(31,1),(31,9),(31,15),(31,17),(31,18),(31,28),(31,29),(31,40),(32,4),(32,5),(32,12),(32,26),(32,35),(33,6),(33,36),(34,19),(34,22),(34,24),(34,25),(34,33),(35,5),(35,16),(35,27),(35,30),(35,34),(35,36),(35,39),(35,41),(36,10),(36,20),(36,31),(36,35),(36,38),(37,11),(37,29),(37,30),(37,39);
/*!40000 ALTER TABLE `ec_product_category_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_collection_products`
--

DROP TABLE IF EXISTS `ec_product_collection_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_collection_products` (
  `product_collection_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`product_collection_id`),
  KEY `ec_product_collection_products_product_collection_id_index` (`product_collection_id`),
  KEY `ec_product_collection_products_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_collection_products`
--

LOCK TABLES `ec_product_collection_products` WRITE;
/*!40000 ALTER TABLE `ec_product_collection_products` DISABLE KEYS */;
INSERT INTO `ec_product_collection_products` VALUES (1,3),(1,9),(1,12),(1,13),(1,16),(1,19),(1,31),(1,38),(1,39),(1,41),(2,8),(2,11),(2,22),(2,23),(2,25),(2,30),(2,33),(2,34),(2,35),(2,36),(2,37),(3,1),(3,2),(3,4),(3,5),(3,6),(3,7),(3,10),(3,14),(3,15),(3,17),(3,18),(3,20),(3,21),(3,24),(3,26),(3,27),(3,28),(3,29),(3,32),(3,40);
/*!40000 ALTER TABLE `ec_product_collection_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_collections`
--

DROP TABLE IF EXISTS `ec_product_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_collections`
--

LOCK TABLES `ec_product_collections` WRITE;
/*!40000 ALTER TABLE `ec_product_collections` DISABLE KEYS */;
INSERT INTO `ec_product_collections` VALUES (1,'New Arrival','new-arrival',NULL,NULL,'published','2023-07-02 19:58:41','2023-07-02 19:58:41',0),(2,'Best Sellers','best-sellers',NULL,NULL,'published','2023-07-02 19:58:41','2023-07-02 19:58:41',0),(3,'Special Offer','special-offer',NULL,NULL,'published','2023-07-02 19:58:41','2023-07-02 19:58:41',0);
/*!40000 ALTER TABLE `ec_product_collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_collections_translations`
--

DROP TABLE IF EXISTS `ec_product_collections_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_collections_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_collections_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_product_collections_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_collections_translations`
--

LOCK TABLES `ec_product_collections_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_collections_translations` DISABLE KEYS */;
INSERT INTO `ec_product_collections_translations` VALUES ('vi',1,'Hàng mới về',NULL),('vi',2,'Bán chạy nhất',NULL),('vi',3,'Khuyến mãi đặc biệt',NULL);
/*!40000 ALTER TABLE `ec_product_collections_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_cross_sale_relations`
--

DROP TABLE IF EXISTS `ec_product_cross_sale_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_cross_sale_relations` (
  `from_product_id` bigint unsigned NOT NULL,
  `to_product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`from_product_id`,`to_product_id`),
  KEY `ec_product_cross_sale_relations_from_product_id_index` (`from_product_id`),
  KEY `ec_product_cross_sale_relations_to_product_id_index` (`to_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_cross_sale_relations`
--

LOCK TABLES `ec_product_cross_sale_relations` WRITE;
/*!40000 ALTER TABLE `ec_product_cross_sale_relations` DISABLE KEYS */;
INSERT INTO `ec_product_cross_sale_relations` VALUES (1,2),(1,6),(1,7),(1,13),(1,17),(1,20),(2,1),(2,4),(2,5),(2,11),(2,12),(2,20),(3,2),(3,10),(3,11),(3,14),(3,19),(4,3),(4,7),(4,8),(4,10),(4,12),(4,17),(4,20),(5,1),(5,3),(5,4),(5,6),(5,15),(5,17),(5,18),(6,1),(6,5),(6,13),(6,16),(6,20),(7,1),(7,3),(7,5),(7,13),(7,18),(7,19),(8,1),(8,5),(8,7),(8,11),(8,17),(8,19),(9,4),(9,5),(9,11),(9,12),(9,19),(10,4),(10,5),(10,6),(10,9),(10,12),(10,15),(10,17),(11,6),(11,8),(11,10),(11,14),(11,16),(12,2),(12,6),(12,7),(12,14),(12,16),(12,17),(12,18),(13,3),(13,7),(13,9),(13,10),(13,15),(13,20),(14,2),(14,5),(14,9),(14,10),(15,1),(15,2),(15,10),(15,14),(16,9),(16,10),(16,13),(16,15),(16,17),(16,18),(17,7),(17,10),(17,11),(17,13),(17,16),(18,2),(18,5),(18,7),(18,10),(18,13),(18,15),(18,17),(19,3),(19,6),(19,7),(19,8),(19,11),(19,14),(19,18),(20,2),(20,5),(20,9),(20,14),(20,16),(20,18),(20,19),(21,1),(21,12),(21,13),(21,14),(21,18),(22,2),(22,3),(22,5),(22,6),(22,8),(22,9),(22,17),(23,5),(23,6),(23,16),(23,17),(23,18),(24,3),(24,7),(24,9),(24,10),(24,12),(24,13),(25,3),(25,6),(25,9),(25,10),(25,12),(25,17),(26,3),(26,5),(26,8),(26,18),(26,19),(27,2),(27,3),(27,5),(27,7),(27,12),(27,15),(27,19),(28,2),(28,5),(28,6),(28,9),(28,15),(29,1),(29,3),(29,5),(29,10),(29,11),(29,17),(29,19),(30,2),(30,8),(30,11),(30,12),(30,17),(31,2),(31,4),(31,10),(31,11),(31,13),(31,14),(31,18),(32,6),(32,7),(32,11),(32,15),(32,16),(32,19),(33,1),(33,5),(33,7),(33,11),(33,13),(33,15),(34,5),(34,6),(34,8),(34,11),(34,12),(34,13),(34,16),(35,1),(35,4),(35,7),(35,10),(35,11),(35,18),(35,19),(36,7),(36,8),(36,10),(36,11),(36,15),(36,19),(37,1),(37,3),(37,8),(37,10),(37,11),(37,16),(37,18),(38,1),(38,4),(38,8),(38,12),(38,16),(38,18),(39,8),(39,12),(39,13),(39,14),(39,19),(40,5),(40,7),(40,9),(40,12),(40,13),(40,19),(41,3),(41,8),(41,11),(41,12),(41,13),(41,14),(41,15);
/*!40000 ALTER TABLE `ec_product_cross_sale_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_files`
--

DROP TABLE IF EXISTS `ec_product_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `url` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extras` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_product_files_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_files`
--

LOCK TABLES `ec_product_files` WRITE;
/*!40000 ALTER TABLE `ec_product_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_label_products`
--

DROP TABLE IF EXISTS `ec_product_label_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_label_products` (
  `product_label_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_label_id`,`product_id`),
  KEY `ec_product_label_products_product_label_id_index` (`product_label_id`),
  KEY `ec_product_label_products_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_label_products`
--

LOCK TABLES `ec_product_label_products` WRITE;
/*!40000 ALTER TABLE `ec_product_label_products` DISABLE KEYS */;
INSERT INTO `ec_product_label_products` VALUES (1,3),(1,21),(2,6),(2,15),(2,24),(2,27),(2,30),(2,36),(2,39),(3,9),(3,12),(3,18),(3,33);
/*!40000 ALTER TABLE `ec_product_label_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_labels`
--

DROP TABLE IF EXISTS `ec_product_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_labels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_labels`
--

LOCK TABLES `ec_product_labels` WRITE;
/*!40000 ALTER TABLE `ec_product_labels` DISABLE KEYS */;
INSERT INTO `ec_product_labels` VALUES (1,'Hot','#ec2434','published','2023-07-02 19:58:42','2023-07-02 19:58:42'),(2,'New','#00c9a7','published','2023-07-02 19:58:42','2023-07-02 19:58:42'),(3,'Sale','#fe9931','published','2023-07-02 19:58:42','2023-07-02 19:58:42');
/*!40000 ALTER TABLE `ec_product_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_labels_translations`
--

DROP TABLE IF EXISTS `ec_product_labels_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_labels_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_labels_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_product_labels_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_labels_translations`
--

LOCK TABLES `ec_product_labels_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_labels_translations` DISABLE KEYS */;
INSERT INTO `ec_product_labels_translations` VALUES ('vi',1,'Nổi bật',NULL),('vi',2,'Mới',NULL),('vi',3,'Giảm giá',NULL);
/*!40000 ALTER TABLE `ec_product_labels_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_related_relations`
--

DROP TABLE IF EXISTS `ec_product_related_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_related_relations` (
  `from_product_id` bigint unsigned NOT NULL,
  `to_product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`from_product_id`,`to_product_id`),
  KEY `ec_product_related_relations_from_product_id_index` (`from_product_id`),
  KEY `ec_product_related_relations_to_product_id_index` (`to_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_related_relations`
--

LOCK TABLES `ec_product_related_relations` WRITE;
/*!40000 ALTER TABLE `ec_product_related_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_related_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_tag_product`
--

DROP TABLE IF EXISTS `ec_product_tag_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_tag_product` (
  `product_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`tag_id`),
  KEY `ec_product_tag_product_product_id_index` (`product_id`),
  KEY `ec_product_tag_product_tag_id_index` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_tag_product`
--

LOCK TABLES `ec_product_tag_product` WRITE;
/*!40000 ALTER TABLE `ec_product_tag_product` DISABLE KEYS */;
INSERT INTO `ec_product_tag_product` VALUES (1,1),(1,3),(1,4),(2,2),(2,5),(3,2),(3,4),(4,1),(4,4),(4,6),(5,1),(5,2),(5,4),(6,1),(6,3),(7,5),(7,6),(8,5),(8,6),(9,2),(9,3),(10,3),(10,5),(11,1),(11,2),(11,3),(12,3),(12,6),(13,1),(13,4),(13,6),(14,2),(14,4),(14,5),(15,1),(15,2),(15,5),(16,1),(16,3),(16,4),(17,3),(17,6),(18,1),(18,2),(18,3),(19,1),(19,2),(19,3),(20,1),(20,5),(20,6),(21,1),(21,2),(22,1),(22,5),(23,2),(23,4),(23,5),(24,2),(24,3),(24,6),(25,1),(25,5),(26,4),(26,6),(27,3),(27,6),(28,2),(28,5),(28,6),(29,1),(29,3),(29,4),(30,2),(30,4),(30,6),(31,2),(31,4),(31,6),(32,4),(32,6),(33,4),(33,5),(33,6),(34,1),(34,5),(34,6),(35,1),(35,4),(35,5),(36,1),(36,3),(36,6),(37,3),(37,6),(38,2),(38,3),(38,5),(39,2),(39,4),(40,2),(40,3),(40,5),(41,3),(41,4);
/*!40000 ALTER TABLE `ec_product_tag_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_tags`
--

DROP TABLE IF EXISTS `ec_product_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_tags`
--

LOCK TABLES `ec_product_tags` WRITE;
/*!40000 ALTER TABLE `ec_product_tags` DISABLE KEYS */;
INSERT INTO `ec_product_tags` VALUES (1,'Dinner',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,'Delicious',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,'Breakfast',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(4,'Chocolate',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(5,'Vegan',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(6,'Sweet',NULL,'published','2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_product_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_tags_translations`
--

DROP TABLE IF EXISTS `ec_product_tags_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_tags_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_product_tags_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`ec_product_tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_tags_translations`
--

LOCK TABLES `ec_product_tags_translations` WRITE;
/*!40000 ALTER TABLE `ec_product_tags_translations` DISABLE KEYS */;
INSERT INTO `ec_product_tags_translations` VALUES ('vi',1,'Dinner'),('vi',2,'Delicious'),('vi',3,'Breakfast'),('vi',4,'Chocolate'),('vi',5,'Vegan'),('vi',6,'Sweet');
/*!40000 ALTER TABLE `ec_product_tags_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_up_sale_relations`
--

DROP TABLE IF EXISTS `ec_product_up_sale_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_up_sale_relations` (
  `from_product_id` bigint unsigned NOT NULL,
  `to_product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`from_product_id`,`to_product_id`),
  KEY `ec_product_up_sale_relations_from_product_id_index` (`from_product_id`),
  KEY `ec_product_up_sale_relations_to_product_id_index` (`to_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_up_sale_relations`
--

LOCK TABLES `ec_product_up_sale_relations` WRITE;
/*!40000 ALTER TABLE `ec_product_up_sale_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_up_sale_relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_variation_items`
--

DROP TABLE IF EXISTS `ec_product_variation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_variation_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint unsigned NOT NULL,
  `variation_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_product_variation_items_attribute_id_variation_id_index` (`attribute_id`,`variation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_variation_items`
--

LOCK TABLES `ec_product_variation_items` WRITE;
/*!40000 ALTER TABLE `ec_product_variation_items` DISABLE KEYS */;
INSERT INTO `ec_product_variation_items` VALUES (9,1,5),(27,1,14),(33,1,17),(35,1,18),(37,1,19),(41,1,21),(75,1,38),(99,1,50),(3,2,2),(11,2,6),(13,2,7),(31,2,16),(45,2,23),(49,2,25),(51,2,26),(61,2,31),(79,2,40),(85,2,43),(15,3,8),(17,3,9),(21,3,11),(29,3,15),(53,3,27),(63,3,32),(71,3,36),(81,3,41),(101,3,51),(103,3,52),(1,4,1),(7,4,4),(25,4,13),(39,4,20),(43,4,22),(57,4,29),(65,4,33),(87,4,44),(93,4,47),(95,4,48),(105,4,53),(5,5,3),(19,5,10),(23,5,12),(47,5,24),(55,5,28),(59,5,30),(67,5,34),(69,5,35),(73,5,37),(77,5,39),(83,5,42),(89,5,45),(91,5,46),(97,5,49),(107,5,54),(6,6,3),(44,6,22),(48,6,24),(58,6,29),(70,6,35),(86,6,43),(106,6,53),(2,7,1),(8,7,4),(10,7,5),(28,7,14),(40,7,20),(42,7,21),(56,7,28),(66,7,33),(76,7,38),(78,7,39),(80,7,40),(92,7,46),(100,7,50),(102,7,51),(108,7,54),(16,8,8),(22,8,11),(24,8,12),(26,8,13),(32,8,16),(34,8,17),(38,8,19),(46,8,23),(68,8,34),(74,8,37),(96,8,48),(12,9,6),(14,9,7),(18,9,9),(20,9,10),(30,9,15),(36,9,18),(64,9,32),(82,9,41),(84,9,42),(88,9,44),(90,9,45),(94,9,47),(98,9,49),(104,9,52),(4,10,2),(50,10,25),(52,10,26),(54,10,27),(60,10,30),(62,10,31),(72,10,36),(109,11,55),(113,11,57),(129,11,65),(133,11,67),(153,11,77),(167,11,84),(173,11,87),(115,12,58),(125,12,63),(139,12,70),(177,12,89),(179,12,90),(111,13,56),(119,13,60),(127,13,64),(141,13,71),(157,13,79),(161,13,81),(163,13,82),(165,13,83),(169,13,85),(131,14,66),(135,14,68),(143,14,72),(145,14,73),(147,14,74),(149,14,75),(155,14,78),(159,14,80),(171,14,86),(175,14,88),(117,15,59),(121,15,61),(123,15,62),(137,15,69),(151,15,76),(181,15,91),(183,15,92),(134,16,67),(136,16,68),(138,16,69),(142,16,71),(144,16,72),(156,16,78),(164,16,82),(182,16,91),(130,17,65),(132,17,66),(150,17,75),(152,17,76),(160,17,80),(162,17,81),(172,17,86),(174,17,87),(110,18,55),(112,18,56),(114,18,57),(120,18,60),(124,18,62),(146,18,73),(148,18,74),(154,18,77),(158,18,79),(176,18,88),(180,18,90),(184,18,92),(116,19,58),(118,19,59),(122,19,61),(140,19,70),(166,19,83),(178,19,89),(126,20,63),(128,20,64),(168,20,84),(170,20,85);
/*!40000 ALTER TABLE `ec_product_variation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_variations`
--

DROP TABLE IF EXISTS `ec_product_variations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_variations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `configurable_product_id` bigint unsigned NOT NULL,
  `is_default` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ec_product_variations_product_id_configurable_product_id_index` (`product_id`,`configurable_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_variations`
--

LOCK TABLES `ec_product_variations` WRITE;
/*!40000 ALTER TABLE `ec_product_variations` DISABLE KEYS */;
INSERT INTO `ec_product_variations` VALUES (1,42,1,1),(2,43,1,0),(3,44,2,1),(4,45,2,0),(5,46,2,0),(6,47,3,1),(7,48,3,0),(8,49,4,1),(9,50,4,0),(10,51,5,1),(11,52,5,0),(12,53,6,1),(13,54,6,0),(14,55,6,0),(15,56,7,1),(16,57,7,0),(17,58,8,1),(18,59,8,0),(19,60,8,0),(20,61,9,1),(21,62,10,1),(22,63,10,0),(23,64,11,1),(24,65,11,0),(25,66,12,1),(26,67,12,0),(27,68,13,1),(28,69,13,0),(29,70,14,1),(30,71,15,1),(31,72,16,1),(32,73,16,0),(33,74,16,0),(34,75,17,1),(35,76,18,1),(36,77,18,0),(37,78,18,0),(38,79,19,1),(39,80,19,0),(40,81,19,0),(41,82,20,1),(42,83,20,0),(43,84,20,0),(44,85,20,0),(45,86,21,1),(46,87,21,0),(47,88,22,1),(48,89,22,0),(49,90,22,0),(50,91,22,0),(51,92,23,1),(52,93,23,0),(53,94,23,0),(54,95,23,0),(55,96,24,1),(56,97,24,0),(57,98,25,1),(58,99,25,0),(59,100,25,0),(60,101,25,0),(61,102,26,1),(62,103,26,0),(63,104,27,1),(64,105,28,1),(65,106,28,0),(66,107,29,1),(67,108,29,0),(68,109,29,0),(69,110,30,1),(70,111,30,0),(71,112,31,1),(72,113,31,0),(73,114,31,0),(74,115,31,0),(75,116,32,1),(76,117,33,1),(77,118,33,0),(78,119,34,1),(79,120,34,0),(80,121,35,1),(81,122,35,0),(82,123,35,0),(83,124,36,1),(84,125,37,1),(85,126,37,0),(86,127,38,1),(87,128,39,1),(88,129,40,1),(89,130,40,0),(90,131,41,1),(91,132,41,0),(92,133,41,0);
/*!40000 ALTER TABLE `ec_product_variations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_views`
--

DROP TABLE IF EXISTS `ec_product_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `views` int NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '2023-07-03',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_product_views_product_id_date_unique` (`product_id`,`date`),
  KEY `ec_product_views_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_views`
--

LOCK TABLES `ec_product_views` WRITE;
/*!40000 ALTER TABLE `ec_product_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_product_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_product_with_attribute_set`
--

DROP TABLE IF EXISTS `ec_product_with_attribute_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_product_with_attribute_set` (
  `attribute_set_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`attribute_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_product_with_attribute_set`
--

LOCK TABLES `ec_product_with_attribute_set` WRITE;
/*!40000 ALTER TABLE `ec_product_with_attribute_set` DISABLE KEYS */;
INSERT INTO `ec_product_with_attribute_set` VALUES (1,1,0),(2,1,0),(1,2,0),(2,2,0),(1,3,0),(2,3,0),(1,4,0),(2,4,0),(1,5,0),(2,5,0),(1,6,0),(2,6,0),(1,7,0),(2,7,0),(1,8,0),(2,8,0),(1,9,0),(2,9,0),(1,10,0),(2,10,0),(1,11,0),(2,11,0),(1,12,0),(2,12,0),(1,13,0),(2,13,0),(1,14,0),(2,14,0),(1,15,0),(2,15,0),(1,16,0),(2,16,0),(1,17,0),(2,17,0),(1,18,0),(2,18,0),(1,19,0),(2,19,0),(1,20,0),(2,20,0),(1,21,0),(2,21,0),(1,22,0),(2,22,0),(1,23,0),(2,23,0),(3,24,0),(4,24,0),(3,25,0),(4,25,0),(3,26,0),(4,26,0),(3,27,0),(4,27,0),(3,28,0),(4,28,0),(3,29,0),(4,29,0),(3,30,0),(4,30,0),(3,31,0),(4,31,0),(3,32,0),(4,32,0),(3,33,0),(4,33,0),(3,34,0),(4,34,0),(3,35,0),(4,35,0),(3,36,0),(4,36,0),(3,37,0),(4,37,0),(3,38,0),(4,38,0),(3,39,0),(4,39,0),(3,40,0),(4,40,0),(3,41,0),(4,41,0);
/*!40000 ALTER TABLE `ec_product_with_attribute_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_products`
--

DROP TABLE IF EXISTS `ec_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `images` text COLLATE utf8mb4_unicode_ci,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int unsigned NOT NULL DEFAULT '0',
  `quantity` int unsigned DEFAULT NULL,
  `allow_checkout_when_out_of_stock` tinyint unsigned NOT NULL DEFAULT '0',
  `with_storehouse_management` tinyint unsigned NOT NULL DEFAULT '0',
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `brand_id` bigint unsigned DEFAULT NULL,
  `is_variation` tinyint NOT NULL DEFAULT '0',
  `sale_type` tinyint NOT NULL DEFAULT '0',
  `price` double unsigned DEFAULT NULL,
  `sale_price` double unsigned DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `length` double(8,2) DEFAULT NULL,
  `wide` double(8,2) DEFAULT NULL,
  `height` double(8,2) DEFAULT NULL,
  `weight` double(8,2) DEFAULT NULL,
  `tax_id` bigint unsigned DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'in_stock',
  `created_by_id` bigint unsigned DEFAULT '0',
  `created_by_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'physical',
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_per_item` double DEFAULT NULL,
  `generate_license_code` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_products_barcode_unique` (`barcode`),
  KEY `ec_products_brand_id_status_is_variation_created_at_index` (`brand_id`,`status`,`is_variation`,`created_at`),
  KEY `ec_products_sale_type_index` (`sale_type`),
  KEY `ec_products_start_date_index` (`start_date`),
  KEY `ec_products_end_date_index` (`end_date`),
  KEY `ec_products_sale_price_index` (`sale_price`),
  KEY `ec_products_is_variation_index` (`is_variation`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_products`
--

LOCK TABLES `ec_products` WRITE;
/*!40000 ALTER TABLE `ec_products` DISABLE KEYS */;
INSERT INTO `ec_products` VALUES (1,'Chevre au mill','I shall ever see you again, you dear old thing!\' said the Mouse. \'Of course,\' the Dodo in an offended tone, \'Hm! No accounting for tastes! Sing her \"Turtle Soup,\" will you, won\'t you join the dance?.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/15.jpg\",\"products\\/21.jpg\",\"products\\/8.jpg\",\"products\\/13.jpg\",\"products\\/10.jpg\",\"products\\/6.jpg\"]','SW-186-A0',0,16,0,1,1,2,0,0,31,NULL,NULL,NULL,20.00,19.00,19.00,756.00,NULL,130626,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(2,'Salmon Grav-lax','I\'ve offended it again!\' For the Mouse to tell its age, there was enough of me left to make out what it meant till now.\' \'If that\'s all I can kick a little!\' She drew her foot slipped, and in.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/24.jpg\",\"products\\/12.jpg\",\"products\\/16.jpg\",\"products\\/11.jpg\",\"products\\/2.jpg\"]','SW-183-A0',0,15,0,1,0,3,0,0,41,NULL,NULL,NULL,11.00,11.00,11.00,698.00,NULL,140486,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(3,'Straitlaced','Alice gently remarked; \'they\'d have been changed several times since then.\' \'What do you want to stay with it as far as they came nearer, Alice could bear: she got up this morning, but I can\'t.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/2.jpg\",\"products\\/25.jpg\",\"products\\/18.jpg\",\"products\\/22.jpg\",\"products\\/7.jpg\",\"products\\/20.jpg\"]','SW-110-A0',0,20,0,1,1,5,0,0,45,NULL,NULL,NULL,20.00,20.00,18.00,654.00,NULL,184487,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(4,'Carpaccio de degrade','Time as well as she had nothing else to do, and in his note-book, cackled out \'Silence!\' and read out from his book, \'Rule Forty-two. ALL PERSONS MORE THAN A MILE HIGH TO LEAVE THE COURT.\' Everybody.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/1.jpg\",\"products\\/26.jpg\",\"products\\/15.jpg\",\"products\\/18.jpg\",\"products\\/12.jpg\",\"products\\/20.jpg\",\"products\\/3.jpg\",\"products\\/2.jpg\"]','SW-134-A0',0,16,0,1,0,1,0,0,41,36.08,NULL,NULL,10.00,19.00,10.00,600.00,NULL,120096,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(5,'Spring roll','Duchess. \'Everything\'s got a moral, if only you can have no notion how delightful it will be much the same thing, you know.\' \'Not the same height as herself; and when Alice had no pictures or.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/26.jpg\",\"products\\/11.jpg\",\"products\\/9.jpg\"]','SW-119-A0',0,10,0,1,1,4,0,0,47,NULL,NULL,NULL,12.00,12.00,18.00,832.00,NULL,154369,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(6,'Fish soup','I say again!\' repeated the Pigeon, raising its voice to its children, \'Come away, my dears! It\'s high time to hear the very tones of the bottle was NOT marked \'poison,\' it is all the rest of my.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/10.jpg\",\"products\\/9.jpg\",\"products\\/3.jpg\",\"products\\/23.jpg\",\"products\\/14.jpg\",\"products\\/4.jpg\",\"products\\/5.jpg\",\"products\\/19.jpg\"]','SW-137-A0',0,20,0,1,0,1,0,0,42,NULL,NULL,NULL,11.00,19.00,18.00,694.00,NULL,49813,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(7,'Fried beef','YOUR table,\' said Alice; \'living at the mouth with strings: into this they slipped the guinea-pig, head first, and then a great hurry; \'this paper has just been picked up.\' \'What\'s in it?\' said the.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/24.jpg\",\"products\\/9.jpg\",\"products\\/16.jpg\"]','SW-146-A0',0,16,0,1,1,2,0,0,50,NULL,NULL,NULL,17.00,18.00,14.00,674.00,NULL,13421,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(8,'Boiled vegetables','Gryphon replied rather crossly: \'of course you know that you\'re mad?\' \'To begin with,\' said the Mock Turtle sighed deeply, and began, in rather a hard word, I will tell you just now what the flame.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/8.jpg\",\"products\\/7.jpg\",\"products\\/25.jpg\",\"products\\/19.jpg\",\"products\\/5.jpg\",\"products\\/26.jpg\",\"products\\/17.jpg\",\"products\\/16.jpg\",\"products\\/14.jpg\"]','SW-122-A0',0,17,0,1,0,5,0,0,45,40.5,NULL,NULL,19.00,15.00,19.00,590.00,NULL,87182,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(9,'Omelet','WHAT are you?\' And then a voice of the Rabbit\'s little white kid gloves: she took up the fan she was considering in her haste, she had known them all her riper years, the simple and loving heart of.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/23.jpg\",\"products\\/19.jpg\",\"products\\/9.jpg\",\"products\\/1.jpg\",\"products\\/21.jpg\",\"products\\/14.jpg\",\"products\\/15.jpg\",\"products\\/11.jpg\"]','SW-138-A0',0,11,0,1,1,1,0,0,50,NULL,NULL,NULL,12.00,11.00,20.00,587.00,NULL,41080,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(10,'Stuffed pancake','There could be NO mistake about it: it was impossible to say to itself, \'Oh dear! Oh dear! I\'d nearly forgotten that I\'ve got to the voice of the bread-and-butter. Just at this moment Alice felt a.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/6.jpg\",\"products\\/25.jpg\",\"products\\/12.jpg\",\"products\\/1.jpg\",\"products\\/17.jpg\",\"products\\/4.jpg\",\"products\\/9.jpg\",\"products\\/20.jpg\",\"products\\/7.jpg\"]','SW-191-A0',0,13,0,1,0,3,0,0,37,NULL,NULL,NULL,12.00,17.00,15.00,851.00,NULL,193840,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(11,'Spicy beef noodle soup','There ought to go through next walking about at the March Hare. \'Then it ought to eat or drink under the hedge. In another moment that it ought to tell its age, there was a little timidly, \'why you.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/13.jpg\",\"products\\/2.jpg\",\"products\\/5.jpg\",\"products\\/14.jpg\",\"products\\/23.jpg\",\"products\\/3.jpg\",\"products\\/22.jpg\",\"products\\/18.jpg\",\"products\\/4.jpg\",\"products\\/7.jpg\"]','SW-147-A0',0,10,0,1,1,5,0,0,43,NULL,NULL,NULL,20.00,15.00,17.00,777.00,NULL,164227,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(12,'Pancake','Alice thoughtfully: \'but then--I shouldn\'t be hungry for it, she found to be executed for having cheated herself in a tone of great relief. \'Now at OURS they had to stop and untwist it. After a.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/25.jpg\",\"products\\/2.jpg\",\"products\\/14.jpg\",\"products\\/11.jpg\",\"products\\/24.jpg\",\"products\\/16.jpg\",\"products\\/6.jpg\",\"products\\/13.jpg\",\"products\\/5.jpg\"]','SW-116-A0',0,13,0,1,0,3,0,0,34,24.82,NULL,NULL,18.00,12.00,12.00,802.00,NULL,151216,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(13,'Onion pickle','Dinah, if I might venture to go down the chimney, and said \'What else had you to get dry again: they had settled down again, the cook tulip-roots instead of the room. The cook threw a frying-pan.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/14.jpg\",\"products\\/10.jpg\",\"products\\/2.jpg\",\"products\\/17.jpg\",\"products\\/6.jpg\",\"products\\/8.jpg\",\"products\\/3.jpg\",\"products\\/12.jpg\",\"products\\/9.jpg\",\"products\\/26.jpg\"]','SW-194-A0',0,13,0,1,1,4,0,0,40,NULL,NULL,NULL,11.00,10.00,17.00,723.00,NULL,64798,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(14,'Ice-cream','Hatter hurriedly left the court, by the hedge!\' then silence, and then sat upon it.) \'I\'m glad they\'ve begun asking riddles.--I believe I can find them.\' As she said to Alice, they all crowded round.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/15.jpg\",\"products\\/11.jpg\",\"products\\/2.jpg\",\"products\\/3.jpg\",\"products\\/5.jpg\",\"products\\/23.jpg\"]','SW-115-A0',0,16,0,1,0,1,0,0,50,NULL,NULL,NULL,11.00,13.00,15.00,567.00,NULL,52113,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(15,'Salad','Alice, thinking it was all dark overhead; before her was another long passage, and the March Hare went \'Sh! sh!\' and the choking of the wood for fear of their hearing her; and when she heard one of.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/9.jpg\",\"products\\/18.jpg\",\"products\\/2.jpg\",\"products\\/19.jpg\",\"products\\/25.jpg\",\"products\\/21.jpg\",\"products\\/22.jpg\"]','SW-143-A0',0,10,0,1,1,1,0,0,44,NULL,NULL,NULL,17.00,18.00,17.00,748.00,NULL,173319,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(16,'Spaghetti','Queen, who was talking. \'How CAN I have dropped them, I wonder?\' And here poor Alice in a melancholy tone: \'it doesn\'t seem to see if she had sat down a good deal on where you want to stay in here.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/7.jpg\",\"products\\/17.jpg\",\"products\\/19.jpg\",\"products\\/20.jpg\",\"products\\/16.jpg\",\"products\\/1.jpg\",\"products\\/6.jpg\",\"products\\/3.jpg\",\"products\\/14.jpg\"]','SW-192-A0',0,17,0,1,0,4,0,0,40,30,NULL,NULL,10.00,16.00,11.00,881.00,NULL,30554,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(17,'Duck meat','He looked at her, and she jumped up and rubbed its eyes: then it watched the Queen was to eat some of them at last, they must needs come wriggling down from the shock of being all alone here!\' As.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/25.jpg\",\"products\\/7.jpg\",\"products\\/13.jpg\",\"products\\/24.jpg\",\"products\\/9.jpg\",\"products\\/20.jpg\",\"products\\/19.jpg\",\"products\\/23.jpg\",\"products\\/15.jpg\"]','SW-111-A0',0,19,0,1,1,5,0,0,33,NULL,NULL,NULL,16.00,12.00,11.00,703.00,NULL,4635,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(18,'Shrimp','Come on!\' So they had to sing \"Twinkle, twinkle, little bat! How I wonder what was the same thing as a last resource, she put them into a cucumber-frame, or something of the sea.\' \'I couldn\'t afford.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/20.jpg\",\"products\\/12.jpg\",\"products\\/5.jpg\",\"products\\/7.jpg\",\"products\\/3.jpg\",\"products\\/24.jpg\",\"products\\/6.jpg\",\"products\\/17.jpg\",\"products\\/22.jpg\"]','SW-131-A0',0,18,0,1,0,2,0,0,31,NULL,NULL,NULL,11.00,15.00,17.00,584.00,NULL,76398,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(19,'Turkey meat','Seaography: then Drawling--the Drawling-master was an old crab, HE was.\' \'I never said I could let you out, you know.\' He was looking at Alice as it turned round and round goes the clock in a dreamy.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/11.jpg\",\"products\\/2.jpg\",\"products\\/12.jpg\",\"products\\/16.jpg\",\"products\\/19.jpg\",\"products\\/1.jpg\",\"products\\/25.jpg\"]','SW-151-A0',0,13,0,1,1,1,0,0,33,NULL,NULL,NULL,13.00,11.00,12.00,755.00,NULL,177878,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(20,'Peppercorn and leek parcels','The three soldiers wandered about in all directions, tumbling up against each other; however, they got settled down again, the cook and the whole cause, and condemn you to offer it,\' said Alice very.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/17.jpg\",\"products\\/13.jpg\",\"products\\/22.jpg\",\"products\\/4.jpg\",\"products\\/7.jpg\",\"products\\/16.jpg\",\"products\\/11.jpg\",\"products\\/25.jpg\",\"products\\/18.jpg\",\"products\\/21.jpg\"]','SW-143-A0',0,15,0,1,0,5,0,0,32,22.72,NULL,NULL,18.00,14.00,16.00,504.00,NULL,129844,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(21,'Lamb and gruyere salad','Allow me to introduce some other subject of conversation. While she was appealed to by all three dates on their slates, and she was out of the singers in the sand with wooden spades, then a voice of.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/18.jpg\",\"products\\/26.jpg\",\"products\\/13.jpg\",\"products\\/3.jpg\"]','SW-144-A0',0,19,0,1,1,4,0,0,31,NULL,NULL,NULL,10.00,14.00,17.00,659.00,NULL,132639,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(22,'Venison and aubergine kebab','Gryphon, half to herself, as she went down on one side, to look about her any more if you\'d rather not.\' \'We indeed!\' cried the Gryphon, and the blades of grass, but she could not possibly reach it.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/8.jpg\",\"products\\/6.jpg\",\"products\\/23.jpg\",\"products\\/3.jpg\",\"products\\/4.jpg\",\"products\\/12.jpg\",\"products\\/26.jpg\",\"products\\/5.jpg\",\"products\\/21.jpg\"]','SW-198-A0',0,20,0,1,0,4,0,0,32,NULL,NULL,NULL,20.00,13.00,16.00,803.00,NULL,183751,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(23,'Dulse and tumeric salad','I shall have to fly; and the little golden key was lying on the twelfth?\' Alice went on at last, they must needs come wriggling down from the shock of being upset, and their curls got entangled.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/7.jpg\",\"products\\/26.jpg\",\"products\\/6.jpg\",\"products\\/22.jpg\",\"products\\/20.jpg\",\"products\\/13.jpg\"]','SW-166-A0',0,19,0,1,1,2,0,0,40,NULL,NULL,NULL,14.00,16.00,19.00,866.00,NULL,144492,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(24,'Pork and broccoli soup','Her listeners were perfectly quiet till she heard was a table, with a growl, And concluded the banquet--] \'What IS the same thing as \"I sleep when I got up this morning, but I THINK I can guess.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/9.jpg\",\"products\\/24.jpg\",\"products\\/18.jpg\",\"products\\/15.jpg\",\"products\\/16.jpg\"]','SW-171-A0',0,12,0,1,0,4,0,0,33,28.38,NULL,NULL,13.00,12.00,19.00,725.00,NULL,163478,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(25,'Chickpea and chilli pasta','Alice after it, never once considering how in the trial done,\' she thought, \'and hand round the court and got behind him, and very soon had to kneel down on one knee. \'I\'m a poor man, your Majesty,\'.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/1.jpg\",\"products\\/17.jpg\",\"products\\/6.jpg\",\"products\\/23.jpg\",\"products\\/9.jpg\",\"products\\/12.jpg\",\"products\\/11.jpg\",\"products\\/14.jpg\"]','SW-192-A0',0,11,0,1,1,5,0,0,39,NULL,NULL,NULL,12.00,18.00,11.00,605.00,NULL,181923,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(26,'Anise and coconut curry','Alice. \'I\'ve read that in about half no time! Take your choice!\' The Duchess took no notice of her age knew the right thing to nurse--and she\'s such a hurry that she began fancying the sort of.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/3.jpg\",\"products\\/26.jpg\",\"products\\/1.jpg\",\"products\\/15.jpg\"]','SW-125-A0',0,19,0,1,0,2,0,0,33,NULL,NULL,NULL,10.00,13.00,16.00,853.00,NULL,197574,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(27,'Rice and sesame pancake','She said the King. \'Nothing whatever,\' said Alice. \'That\'s very curious!\' she thought. \'I must go by the whole window!\' \'Sure, it does, yer honour: but it\'s an arm, yer honour!\' (He pronounced it.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/7.jpg\",\"products\\/21.jpg\",\"products\\/5.jpg\"]','SW-167-A0',0,17,0,1,1,5,0,0,50,NULL,NULL,NULL,13.00,19.00,10.00,622.00,NULL,172964,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(28,'Cabbage and rosemary parcels','Queen. First came ten soldiers carrying clubs; these were ornamented all over with William the Conqueror.\' (For, with all her fancy, that: they never executes nobody, you know. But do cats eat.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/10.jpg\",\"products\\/17.jpg\",\"products\\/15.jpg\"]','SW-100-A0',0,16,0,1,0,2,0,0,40,31.2,NULL,NULL,18.00,19.00,13.00,682.00,NULL,189207,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(29,'Nutmeg and cinnamon loaf','You see, she came suddenly upon an open place, with a sigh: \'he taught Laughing and Grief, they used to it in large letters. It was all about, and shouting \'Off with his nose Trims his belt and his.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/25.jpg\",\"products\\/5.jpg\",\"products\\/17.jpg\",\"products\\/21.jpg\"]','SW-105-A0',0,16,0,1,1,3,0,0,31,NULL,NULL,NULL,19.00,20.00,16.00,530.00,NULL,69808,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(30,'Leek and mushroom pie','I\'d been the right words,\' said poor Alice, \'to pretend to be a book written about me, that there was a bright brass plate with the next verse.\' \'But about his toes?\' the Mock Turtle replied in an.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/23.jpg\",\"products\\/15.jpg\",\"products\\/20.jpg\",\"products\\/1.jpg\",\"products\\/11.jpg\",\"products\\/3.jpg\",\"products\\/10.jpg\",\"products\\/7.jpg\",\"products\\/5.jpg\"]','SW-137-A0',0,19,0,1,0,4,0,0,38,NULL,NULL,NULL,15.00,12.00,15.00,716.00,NULL,4776,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(31,'Banh mi','Cheshire Cat,\' said Alice: \'besides, that\'s not a bit hurt, and she felt that there was enough of it at all; and I\'m sure I have to turn round on its axis--\' \'Talking of axes,\' said the Dormouse.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/13.jpg\",\"products\\/3.jpg\",\"products\\/18.jpg\",\"products\\/5.jpg\",\"products\\/24.jpg\",\"products\\/15.jpg\"]','SW-144-A0',0,11,0,1,1,4,0,0,38,NULL,NULL,NULL,14.00,20.00,10.00,600.00,NULL,31533,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(32,'Pho bo','Alice; and Alice could speak again. In a minute or two sobs choked his voice. \'Same as if she were looking over their heads. She felt very curious sensation, which puzzled her a good many little.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/4.jpg\",\"products\\/16.jpg\",\"products\\/6.jpg\",\"products\\/14.jpg\",\"products\\/18.jpg\",\"products\\/20.jpg\",\"products\\/1.jpg\",\"products\\/22.jpg\"]','SW-153-A0',0,13,0,1,0,4,0,0,32,27.84,NULL,NULL,14.00,20.00,20.00,757.00,NULL,30166,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(33,'Bun dau mam tom','Hatter. \'I told you butter wouldn\'t suit the works!\' he added in a day is very confusing.\' \'It isn\'t,\' said the King, who had been of late much accustomed to usurpation and conquest. Edwin and.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/14.jpg\",\"products\\/24.jpg\",\"products\\/21.jpg\",\"products\\/1.jpg\",\"products\\/12.jpg\",\"products\\/2.jpg\",\"products\\/19.jpg\",\"products\\/18.jpg\",\"products\\/25.jpg\",\"products\\/20.jpg\"]','SW-140-A0',0,14,0,1,1,2,0,0,33,NULL,NULL,NULL,18.00,13.00,17.00,848.00,NULL,102009,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(34,'Onion sandwich with chilli relish','When they take us up and ran off, thinking while she ran, as well say,\' added the March Hare: she thought it would,\' said the Mock Turtle sighed deeply, and began, in a tone of great surprise. \'Of.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/3.jpg\",\"products\\/19.jpg\",\"products\\/15.jpg\",\"products\\/16.jpg\",\"products\\/9.jpg\",\"products\\/25.jpg\",\"products\\/14.jpg\",\"products\\/4.jpg\",\"products\\/17.jpg\"]','SW-164-A0',0,19,0,1,0,5,0,0,31,NULL,NULL,NULL,20.00,20.00,20.00,603.00,NULL,115213,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(35,'Spinach and aubergine bread','Alice; \'I daresay it\'s a French mouse, come over with fright. \'Oh, I know!\' exclaimed Alice, who was beginning very angrily, but the Dodo said, \'EVERYBODY has won, and all must have been was not a.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/13.jpg\",\"products\\/1.jpg\",\"products\\/8.jpg\",\"products\\/17.jpg\",\"products\\/21.jpg\",\"products\\/15.jpg\"]','SW-136-A0',0,15,0,1,1,5,0,0,46,NULL,NULL,NULL,16.00,20.00,15.00,590.00,NULL,155049,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(36,'Banana and squash madras','Cat in a hurry: a large cat which was a dead silence. Alice noticed with some severity; \'it\'s very rude.\' The Hatter was the Rabbit say to this: so she began fancying the sort of knot, and then.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/16.jpg\",\"products\\/4.jpg\",\"products\\/13.jpg\",\"products\\/10.jpg\",\"products\\/21.jpg\",\"products\\/18.jpg\"]','SW-113-A0',0,15,0,1,0,5,0,0,50,43,NULL,NULL,10.00,11.00,10.00,668.00,NULL,56061,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(37,'Apple and semolina cake','Caterpillar angrily, rearing itself upright as it was over at last, more calmly, though still sobbing a little irritated at the bottom of a tree. \'Did you speak?\' \'Not I!\' he replied. \'We quarrelled.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/5.jpg\",\"products\\/4.jpg\",\"products\\/18.jpg\",\"products\\/3.jpg\",\"products\\/17.jpg\",\"products\\/24.jpg\",\"products\\/13.jpg\",\"products\\/2.jpg\",\"products\\/8.jpg\",\"products\\/19.jpg\"]','SW-193-A0',0,10,0,1,1,2,0,0,46,NULL,NULL,NULL,12.00,13.00,11.00,686.00,NULL,167912,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(38,'Apple and semolina cake','I don\'t think,\' Alice went on, \'if you don\'t know what to do anything but sit with its eyelids, so he did,\' said the Caterpillar. \'Well, I can\'t see you?\' She was close behind us, and he\'s treading.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/16.jpg\",\"products\\/14.jpg\",\"products\\/21.jpg\"]','SW-157-A0',0,13,0,1,0,5,0,0,33,NULL,NULL,NULL,10.00,10.00,13.00,581.00,NULL,64541,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(39,'Raisin and fennel yoghurt','Alice whispered, \'that it\'s done by everybody minding their own business,\' the Duchess was VERY ugly; and secondly, because they\'re making such a simple question,\' added the Gryphon; and then she.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/10.jpg\",\"products\\/5.jpg\",\"products\\/23.jpg\",\"products\\/19.jpg\",\"products\\/21.jpg\",\"products\\/3.jpg\",\"products\\/2.jpg\",\"products\\/4.jpg\",\"products\\/1.jpg\",\"products\\/20.jpg\"]','SW-170-A0',0,19,0,1,1,1,0,0,31,NULL,NULL,NULL,18.00,13.00,17.00,564.00,NULL,167429,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(40,'Chilli and egg penne','White Rabbit cried out, \'Silence in the sea!\' cried the Mouse, in a moment. \'Let\'s go on crying in this way! Stop this moment, and fetch me a good way off, and found herself at last it sat down and.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/6.jpg\",\"products\\/2.jpg\",\"products\\/22.jpg\",\"products\\/4.jpg\",\"products\\/19.jpg\"]','SW-111-A0',0,16,0,1,0,1,0,0,36,28.44,NULL,NULL,13.00,20.00,11.00,587.00,NULL,84585,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(41,'Basil and chestnut soup','And welcome little fishes in With gently smiling jaws!\' \'I\'m sure those are not the same, the next witness would be worth the trouble of getting her hands on her lap as if she had caught the.','<p>Short Hooded Coat features a straight body, large pockets with button flaps, ventilation air holes, and a string detail along the hemline. The style is completed with a drawstring hood, featuring Rains’ signature built-in cap. Made from waterproof, matte PU, this lightweight unisex rain jacket is an ode to nostalgia through its classic silhouette and utilitarian design details.</p>\n                                <p>- Casual unisex fit</p>\n\n                                <p>- 64% polyester, 36% polyurethane</p>\n\n                                <p>- Water column pressure: 4000 mm</p>\n\n                                <p>- Model is 187cm tall and wearing a size S / M</p>\n\n                                <p>- Unisex fit</p>\n\n                                <p>- Drawstring hood with built-in cap</p>\n\n                                <p>- Front placket with snap buttons</p>\n\n                                <p>- Ventilation under armpit</p>\n\n                                <p>- Adjustable cuffs</p>\n\n                                <p>- Double welted front pockets</p>\n\n                                <p>- Adjustable elastic string at hempen</p>\n\n                                <p>- Ultrasonically welded seams</p>\n\n                                <p>This is a unisex item, please check our clothing &amp; footwear sizing guide for specific Rains jacket sizing information. RAINS comes from the rainy nation of Denmark at the edge of the European continent, close to the ocean and with prevailing westerly winds; all factors that contribute to an average of 121 rain days each year. Arising from these rainy weather conditions comes the attitude that a quick rain shower may be beautiful, as well as moody- but first and foremost requires the right outfit. Rains focus on the whole experience of going outside on rainy days, issuing an invitation to explore even in the most mercurial weather.</p>','published','[\"products\\/6.jpg\",\"products\\/22.jpg\",\"products\\/14.jpg\",\"products\\/8.jpg\"]','SW-163-A0',0,19,0,1,1,5,0,0,35,NULL,NULL,NULL,20.00,17.00,10.00,686.00,NULL,29867,'2023-07-02 19:58:44','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(42,'Chevre au mill',NULL,NULL,'published','[\"products\\/15.jpg\"]','SW-186-A0',0,16,0,1,0,2,1,0,31,NULL,NULL,NULL,20.00,19.00,19.00,756.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(43,'Chevre au mill',NULL,NULL,'published','[\"products\\/21.jpg\"]','SW-186-A0-A1',0,16,0,1,0,2,1,0,31,NULL,NULL,NULL,20.00,19.00,19.00,756.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(44,'Salmon Grav-lax',NULL,NULL,'published','[\"products\\/24.jpg\"]','SW-183-A0',0,15,0,1,0,3,1,0,41,NULL,NULL,NULL,11.00,11.00,11.00,698.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(45,'Salmon Grav-lax',NULL,NULL,'published','[\"products\\/12.jpg\"]','SW-183-A0-A1',0,15,0,1,0,3,1,0,41,NULL,NULL,NULL,11.00,11.00,11.00,698.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(46,'Salmon Grav-lax',NULL,NULL,'published','[\"products\\/16.jpg\"]','SW-183-A0-A2',0,15,0,1,0,3,1,0,41,NULL,NULL,NULL,11.00,11.00,11.00,698.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(47,'Straitlaced',NULL,NULL,'published','[\"products\\/2.jpg\"]','SW-110-A0',0,20,0,1,0,5,1,0,45,NULL,NULL,NULL,20.00,20.00,18.00,654.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(48,'Straitlaced',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-110-A0-A1',0,20,0,1,0,5,1,0,45,NULL,NULL,NULL,20.00,20.00,18.00,654.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(49,'Carpaccio de degrade',NULL,NULL,'published','[\"products\\/1.jpg\"]','SW-134-A0',0,16,0,1,0,1,1,0,41,36.08,NULL,NULL,10.00,19.00,10.00,600.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(50,'Carpaccio de degrade',NULL,NULL,'published','[\"products\\/26.jpg\"]','SW-134-A0-A1',0,16,0,1,0,1,1,0,41,31.57,NULL,NULL,10.00,19.00,10.00,600.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(51,'Spring roll',NULL,NULL,'published','[\"products\\/26.jpg\"]','SW-119-A0',0,10,0,1,0,4,1,0,47,NULL,NULL,NULL,12.00,12.00,18.00,832.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(52,'Spring roll',NULL,NULL,'published','[\"products\\/11.jpg\"]','SW-119-A0-A1',0,10,0,1,0,4,1,0,47,NULL,NULL,NULL,12.00,12.00,18.00,832.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(53,'Fish soup',NULL,NULL,'published','[\"products\\/10.jpg\"]','SW-137-A0',0,20,0,1,0,1,1,0,42,NULL,NULL,NULL,11.00,19.00,18.00,694.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(54,'Fish soup',NULL,NULL,'published','[\"products\\/9.jpg\"]','SW-137-A0-A1',0,20,0,1,0,1,1,0,42,NULL,NULL,NULL,11.00,19.00,18.00,694.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(55,'Fish soup',NULL,NULL,'published','[\"products\\/3.jpg\"]','SW-137-A0-A2',0,20,0,1,0,1,1,0,42,NULL,NULL,NULL,11.00,19.00,18.00,694.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(56,'Fried beef',NULL,NULL,'published','[\"products\\/24.jpg\"]','SW-146-A0',0,16,0,1,0,2,1,0,50,NULL,NULL,NULL,17.00,18.00,14.00,674.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(57,'Fried beef',NULL,NULL,'published','[\"products\\/9.jpg\"]','SW-146-A0-A1',0,16,0,1,0,2,1,0,50,NULL,NULL,NULL,17.00,18.00,14.00,674.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(58,'Boiled vegetables',NULL,NULL,'published','[\"products\\/8.jpg\"]','SW-122-A0',0,17,0,1,0,5,1,0,45,40.5,NULL,NULL,19.00,15.00,19.00,590.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(59,'Boiled vegetables',NULL,NULL,'published','[\"products\\/7.jpg\"]','SW-122-A0-A1',0,17,0,1,0,5,1,0,45,39.6,NULL,NULL,19.00,15.00,19.00,590.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(60,'Boiled vegetables',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-122-A0-A2',0,17,0,1,0,5,1,0,45,35.1,NULL,NULL,19.00,15.00,19.00,590.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(61,'Omelet',NULL,NULL,'published','[\"products\\/23.jpg\"]','SW-138-A0',0,11,0,1,0,1,1,0,50,NULL,NULL,NULL,12.00,11.00,20.00,587.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(62,'Stuffed pancake',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-191-A0',0,13,0,1,0,3,1,0,37,NULL,NULL,NULL,12.00,17.00,15.00,851.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(63,'Stuffed pancake',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-191-A0-A1',0,13,0,1,0,3,1,0,37,NULL,NULL,NULL,12.00,17.00,15.00,851.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(64,'Spicy beef noodle soup',NULL,NULL,'published','[\"products\\/13.jpg\"]','SW-147-A0',0,10,0,1,0,5,1,0,43,NULL,NULL,NULL,20.00,15.00,17.00,777.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(65,'Spicy beef noodle soup',NULL,NULL,'published','[\"products\\/2.jpg\"]','SW-147-A0-A1',0,10,0,1,0,5,1,0,43,NULL,NULL,NULL,20.00,15.00,17.00,777.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(66,'Pancake',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-116-A0',0,13,0,1,0,3,1,0,34,24.82,NULL,NULL,18.00,12.00,12.00,802.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(67,'Pancake',NULL,NULL,'published','[\"products\\/2.jpg\"]','SW-116-A0-A1',0,13,0,1,0,3,1,0,34,29.92,NULL,NULL,18.00,12.00,12.00,802.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(68,'Onion pickle',NULL,NULL,'published','[\"products\\/14.jpg\"]','SW-194-A0',0,13,0,1,0,4,1,0,40,NULL,NULL,NULL,11.00,10.00,17.00,723.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(69,'Onion pickle',NULL,NULL,'published','[\"products\\/10.jpg\"]','SW-194-A0-A1',0,13,0,1,0,4,1,0,40,NULL,NULL,NULL,11.00,10.00,17.00,723.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(70,'Ice-cream',NULL,NULL,'published','[\"products\\/15.jpg\"]','SW-115-A0',0,16,0,1,0,1,1,0,50,NULL,NULL,NULL,11.00,13.00,15.00,567.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(71,'Salad',NULL,NULL,'published','[\"products\\/9.jpg\"]','SW-143-A0',0,10,0,1,0,1,1,0,44,NULL,NULL,NULL,17.00,18.00,17.00,748.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(72,'Spaghetti',NULL,NULL,'published','[\"products\\/7.jpg\"]','SW-192-A0',0,17,0,1,0,4,1,0,40,30,NULL,NULL,10.00,16.00,11.00,881.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(73,'Spaghetti',NULL,NULL,'published','[\"products\\/17.jpg\"]','SW-192-A0-A1',0,17,0,1,0,4,1,0,40,30.8,NULL,NULL,10.00,16.00,11.00,881.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(74,'Spaghetti',NULL,NULL,'published','[\"products\\/19.jpg\"]','SW-192-A0-A2',0,17,0,1,0,4,1,0,40,35.2,NULL,NULL,10.00,16.00,11.00,881.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(75,'Duck meat',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-111-A0',0,19,0,1,0,5,1,0,33,NULL,NULL,NULL,16.00,12.00,11.00,703.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(76,'Shrimp',NULL,NULL,'published','[\"products\\/20.jpg\"]','SW-131-A0',0,18,0,1,0,2,1,0,31,NULL,NULL,NULL,11.00,15.00,17.00,584.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(77,'Shrimp',NULL,NULL,'published','[\"products\\/12.jpg\"]','SW-131-A0-A1',0,18,0,1,0,2,1,0,31,NULL,NULL,NULL,11.00,15.00,17.00,584.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(78,'Shrimp',NULL,NULL,'published','[\"products\\/5.jpg\"]','SW-131-A0-A2',0,18,0,1,0,2,1,0,31,NULL,NULL,NULL,11.00,15.00,17.00,584.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(79,'Turkey meat',NULL,NULL,'published','[\"products\\/11.jpg\"]','SW-151-A0',0,13,0,1,0,1,1,0,33,NULL,NULL,NULL,13.00,11.00,12.00,755.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(80,'Turkey meat',NULL,NULL,'published','[\"products\\/2.jpg\"]','SW-151-A0-A1',0,13,0,1,0,1,1,0,33,NULL,NULL,NULL,13.00,11.00,12.00,755.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(81,'Turkey meat',NULL,NULL,'published','[\"products\\/12.jpg\"]','SW-151-A0-A2',0,13,0,1,0,1,1,0,33,NULL,NULL,NULL,13.00,11.00,12.00,755.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(82,'Peppercorn and leek parcels',NULL,NULL,'published','[\"products\\/17.jpg\"]','SW-143-A0',0,15,0,1,0,5,1,0,32,22.72,NULL,NULL,18.00,14.00,16.00,504.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(83,'Peppercorn and leek parcels',NULL,NULL,'published','[\"products\\/13.jpg\"]','SW-143-A0-A1',0,15,0,1,0,5,1,0,32,25.28,NULL,NULL,18.00,14.00,16.00,504.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(84,'Peppercorn and leek parcels',NULL,NULL,'published','[\"products\\/22.jpg\"]','SW-143-A0-A2',0,15,0,1,0,5,1,0,32,25.92,NULL,NULL,18.00,14.00,16.00,504.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(85,'Peppercorn and leek parcels',NULL,NULL,'published','[\"products\\/4.jpg\"]','SW-143-A0-A3',0,15,0,1,0,5,1,0,32,23.68,NULL,NULL,18.00,14.00,16.00,504.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(86,'Lamb and gruyere salad',NULL,NULL,'published','[\"products\\/18.jpg\"]','SW-144-A0',0,19,0,1,0,4,1,0,31,NULL,NULL,NULL,10.00,14.00,17.00,659.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(87,'Lamb and gruyere salad',NULL,NULL,'published','[\"products\\/26.jpg\"]','SW-144-A0-A1',0,19,0,1,0,4,1,0,31,NULL,NULL,NULL,10.00,14.00,17.00,659.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(88,'Venison and aubergine kebab',NULL,NULL,'published','[\"products\\/8.jpg\"]','SW-198-A0',0,20,0,1,0,4,1,0,32,NULL,NULL,NULL,20.00,13.00,16.00,803.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(89,'Venison and aubergine kebab',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-198-A0-A1',0,20,0,1,0,4,1,0,32,NULL,NULL,NULL,20.00,13.00,16.00,803.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(90,'Venison and aubergine kebab',NULL,NULL,'published','[\"products\\/23.jpg\"]','SW-198-A0-A2',0,20,0,1,0,4,1,0,32,NULL,NULL,NULL,20.00,13.00,16.00,803.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(91,'Venison and aubergine kebab',NULL,NULL,'published','[\"products\\/3.jpg\"]','SW-198-A0-A3',0,20,0,1,0,4,1,0,32,NULL,NULL,NULL,20.00,13.00,16.00,803.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(92,'Dulse and tumeric salad',NULL,NULL,'published','[\"products\\/7.jpg\"]','SW-166-A0',0,19,0,1,0,2,1,0,40,NULL,NULL,NULL,14.00,16.00,19.00,866.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(93,'Dulse and tumeric salad',NULL,NULL,'published','[\"products\\/26.jpg\"]','SW-166-A0-A1',0,19,0,1,0,2,1,0,40,NULL,NULL,NULL,14.00,16.00,19.00,866.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(94,'Dulse and tumeric salad',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-166-A0-A2',0,19,0,1,0,2,1,0,40,NULL,NULL,NULL,14.00,16.00,19.00,866.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(95,'Dulse and tumeric salad',NULL,NULL,'published','[\"products\\/22.jpg\"]','SW-166-A0-A3',0,19,0,1,0,2,1,0,40,NULL,NULL,NULL,14.00,16.00,19.00,866.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(96,'Pork and broccoli soup',NULL,NULL,'published','[\"products\\/9.jpg\"]','SW-171-A0',0,12,0,1,0,4,1,0,33,28.38,NULL,NULL,13.00,12.00,19.00,725.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(97,'Pork and broccoli soup',NULL,NULL,'published','[\"products\\/24.jpg\"]','SW-171-A0-A1',0,12,0,1,0,4,1,0,33,28.05,NULL,NULL,13.00,12.00,19.00,725.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(98,'Chickpea and chilli pasta',NULL,NULL,'published','[\"products\\/1.jpg\"]','SW-192-A0',0,11,0,1,0,5,1,0,39,NULL,NULL,NULL,12.00,18.00,11.00,605.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(99,'Chickpea and chilli pasta',NULL,NULL,'published','[\"products\\/17.jpg\"]','SW-192-A0-A1',0,11,0,1,0,5,1,0,39,NULL,NULL,NULL,12.00,18.00,11.00,605.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(100,'Chickpea and chilli pasta',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-192-A0-A2',0,11,0,1,0,5,1,0,39,NULL,NULL,NULL,12.00,18.00,11.00,605.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(101,'Chickpea and chilli pasta',NULL,NULL,'published','[\"products\\/23.jpg\"]','SW-192-A0-A3',0,11,0,1,0,5,1,0,39,NULL,NULL,NULL,12.00,18.00,11.00,605.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(102,'Anise and coconut curry',NULL,NULL,'published','[\"products\\/3.jpg\"]','SW-125-A0',0,19,0,1,0,2,1,0,33,NULL,NULL,NULL,10.00,13.00,16.00,853.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(103,'Anise and coconut curry',NULL,NULL,'published','[\"products\\/26.jpg\"]','SW-125-A0-A1',0,19,0,1,0,2,1,0,33,NULL,NULL,NULL,10.00,13.00,16.00,853.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(104,'Rice and sesame pancake',NULL,NULL,'published','[\"products\\/7.jpg\"]','SW-167-A0',0,17,0,1,0,5,1,0,50,NULL,NULL,NULL,13.00,19.00,10.00,622.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(105,'Cabbage and rosemary parcels',NULL,NULL,'published','[\"products\\/10.jpg\"]','SW-100-A0',0,16,0,1,0,2,1,0,40,31.2,NULL,NULL,18.00,19.00,13.00,682.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(106,'Cabbage and rosemary parcels',NULL,NULL,'published','[\"products\\/17.jpg\"]','SW-100-A0-A1',0,16,0,1,0,2,1,0,40,28,NULL,NULL,18.00,19.00,13.00,682.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(107,'Nutmeg and cinnamon loaf',NULL,NULL,'published','[\"products\\/25.jpg\"]','SW-105-A0',0,16,0,1,0,3,1,0,31,NULL,NULL,NULL,19.00,20.00,16.00,530.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(108,'Nutmeg and cinnamon loaf',NULL,NULL,'published','[\"products\\/5.jpg\"]','SW-105-A0-A1',0,16,0,1,0,3,1,0,31,NULL,NULL,NULL,19.00,20.00,16.00,530.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(109,'Nutmeg and cinnamon loaf',NULL,NULL,'published','[\"products\\/17.jpg\"]','SW-105-A0-A2',0,16,0,1,0,3,1,0,31,NULL,NULL,NULL,19.00,20.00,16.00,530.00,NULL,0,'2023-07-02 19:58:44','2023-07-02 19:58:44','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(110,'Leek and mushroom pie',NULL,NULL,'published','[\"products\\/23.jpg\"]','SW-137-A0',0,19,0,1,0,4,1,0,38,NULL,NULL,NULL,15.00,12.00,15.00,716.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(111,'Leek and mushroom pie',NULL,NULL,'published','[\"products\\/15.jpg\"]','SW-137-A0-A1',0,19,0,1,0,4,1,0,38,NULL,NULL,NULL,15.00,12.00,15.00,716.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(112,'Banh mi',NULL,NULL,'published','[\"products\\/13.jpg\"]','SW-144-A0',0,11,0,1,0,4,1,0,38,NULL,NULL,NULL,14.00,20.00,10.00,600.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(113,'Banh mi',NULL,NULL,'published','[\"products\\/3.jpg\"]','SW-144-A0-A1',0,11,0,1,0,4,1,0,38,NULL,NULL,NULL,14.00,20.00,10.00,600.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(114,'Banh mi',NULL,NULL,'published','[\"products\\/18.jpg\"]','SW-144-A0-A2',0,11,0,1,0,4,1,0,38,NULL,NULL,NULL,14.00,20.00,10.00,600.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(115,'Banh mi',NULL,NULL,'published','[\"products\\/5.jpg\"]','SW-144-A0-A3',0,11,0,1,0,4,1,0,38,NULL,NULL,NULL,14.00,20.00,10.00,600.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(116,'Pho bo',NULL,NULL,'published','[\"products\\/4.jpg\"]','SW-153-A0',0,13,0,1,0,4,1,0,32,27.84,NULL,NULL,14.00,20.00,20.00,757.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(117,'Bun dau mam tom',NULL,NULL,'published','[\"products\\/14.jpg\"]','SW-140-A0',0,14,0,1,0,2,1,0,33,NULL,NULL,NULL,18.00,13.00,17.00,848.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(118,'Bun dau mam tom',NULL,NULL,'published','[\"products\\/24.jpg\"]','SW-140-A0-A1',0,14,0,1,0,2,1,0,33,NULL,NULL,NULL,18.00,13.00,17.00,848.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(119,'Onion sandwich with chilli relish',NULL,NULL,'published','[\"products\\/3.jpg\"]','SW-164-A0',0,19,0,1,0,5,1,0,31,NULL,NULL,NULL,20.00,20.00,20.00,603.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(120,'Onion sandwich with chilli relish',NULL,NULL,'published','[\"products\\/19.jpg\"]','SW-164-A0-A1',0,19,0,1,0,5,1,0,31,NULL,NULL,NULL,20.00,20.00,20.00,603.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(121,'Spinach and aubergine bread',NULL,NULL,'published','[\"products\\/13.jpg\"]','SW-136-A0',0,15,0,1,0,5,1,0,46,NULL,NULL,NULL,16.00,20.00,15.00,590.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(122,'Spinach and aubergine bread',NULL,NULL,'published','[\"products\\/1.jpg\"]','SW-136-A0-A1',0,15,0,1,0,5,1,0,46,NULL,NULL,NULL,16.00,20.00,15.00,590.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(123,'Spinach and aubergine bread',NULL,NULL,'published','[\"products\\/8.jpg\"]','SW-136-A0-A2',0,15,0,1,0,5,1,0,46,NULL,NULL,NULL,16.00,20.00,15.00,590.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(124,'Banana and squash madras',NULL,NULL,'published','[\"products\\/16.jpg\"]','SW-113-A0',0,15,0,1,0,5,1,0,50,43,NULL,NULL,10.00,11.00,10.00,668.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(125,'Apple and semolina cake',NULL,NULL,'published','[\"products\\/5.jpg\"]','SW-193-A0',0,10,0,1,0,2,1,0,46,NULL,NULL,NULL,12.00,13.00,11.00,686.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(126,'Apple and semolina cake',NULL,NULL,'published','[\"products\\/4.jpg\"]','SW-193-A0-A1',0,10,0,1,0,2,1,0,46,NULL,NULL,NULL,12.00,13.00,11.00,686.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(127,'Apple and semolina cake',NULL,NULL,'published','[\"products\\/16.jpg\"]','SW-157-A0',0,13,0,1,0,5,1,0,33,NULL,NULL,NULL,10.00,10.00,13.00,581.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(128,'Raisin and fennel yoghurt',NULL,NULL,'published','[\"products\\/10.jpg\"]','SW-170-A0',0,19,0,1,0,1,1,0,31,NULL,NULL,NULL,18.00,13.00,17.00,564.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(129,'Chilli and egg penne',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-111-A0',0,16,0,1,0,1,1,0,36,28.44,NULL,NULL,13.00,20.00,11.00,587.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(130,'Chilli and egg penne',NULL,NULL,'published','[\"products\\/2.jpg\"]','SW-111-A0-A1',0,16,0,1,0,1,1,0,36,25.56,NULL,NULL,13.00,20.00,11.00,587.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(131,'Basil and chestnut soup',NULL,NULL,'published','[\"products\\/6.jpg\"]','SW-163-A0',0,19,0,1,0,5,1,0,35,NULL,NULL,NULL,20.00,17.00,10.00,686.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(132,'Basil and chestnut soup',NULL,NULL,'published','[\"products\\/22.jpg\"]','SW-163-A0-A1',0,19,0,1,0,5,1,0,35,NULL,NULL,NULL,20.00,17.00,10.00,686.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0),(133,'Basil and chestnut soup',NULL,NULL,'published','[\"products\\/14.jpg\"]','SW-163-A0-A2',0,19,0,1,0,5,1,0,35,NULL,NULL,NULL,20.00,17.00,10.00,686.00,NULL,0,'2023-07-02 19:58:45','2023-07-02 19:58:45','in_stock',0,'Botble\\ACL\\Models\\User',NULL,'physical',NULL,NULL,0);
/*!40000 ALTER TABLE `ec_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_products_translations`
--

DROP TABLE IF EXISTS `ec_products_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_products_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ec_products_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`ec_products_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_products_translations`
--

LOCK TABLES `ec_products_translations` WRITE;
/*!40000 ALTER TABLE `ec_products_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_products_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_reviews`
--

DROP TABLE IF EXISTS `ec_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `star` double(8,2) NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ec_reviews_product_id_customer_id_unique` (`product_id`,`customer_id`),
  KEY `ec_reviews_product_id_customer_id_status_created_at_index` (`product_id`,`customer_id`,`status`,`created_at`),
  KEY `ec_reviews_product_id_customer_id_status_index` (`product_id`,`customer_id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_reviews`
--

LOCK TABLES `ec_reviews` WRITE;
/*!40000 ALTER TABLE `ec_reviews` DISABLE KEYS */;
INSERT INTO `ec_reviews` VALUES (1,6,24,2.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/8.jpg\",\"products\\/20.jpg\"]'),(2,8,23,4.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/25.jpg\"]'),(3,3,37,2.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/13.jpg\",\"products\\/23.jpg\"]'),(4,3,7,5.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/24.jpg\"]'),(5,5,2,3.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/21.jpg\"]'),(6,1,4,1.00,'Great system, great support, good job Botble. I\'m looking forward to more great functional plugins.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/24.jpg\"]'),(7,9,33,5.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/25.jpg\"]'),(8,6,6,2.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/2.jpg\"]'),(10,2,22,4.00,'Those guys now what they are doing, the release such a good product that it\'s a pleasure to work with ! Even when I was stuck on the project, I created a ticket and the next day it was replied by the team. GOOD JOB guys. I love working with them :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/24.jpg\"]'),(11,6,2,5.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/16.jpg\",\"products\\/23.jpg\"]'),(12,7,33,1.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/3.jpg\",\"products\\/24.jpg\"]'),(14,9,18,3.00,'Great system, great support, good job Botble. I\'m looking forward to more great functional plugins.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/22.jpg\"]'),(15,9,39,2.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/23.jpg\"]'),(16,4,12,5.00,'The code is good, in general, if you like it, can you give it 5 stars?','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/16.jpg\",\"products\\/21.jpg\"]'),(17,2,1,2.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\"]'),(18,1,36,1.00,'Solution is too robust for our purpose so we didn\'t use it at the end. But I appreciate customer support during initial configuration.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/12.jpg\",\"products\\/22.jpg\"]'),(19,3,1,3.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\"]'),(20,9,41,2.00,'Great system, great support, good job Botble. I\'m looking forward to more great functional plugins.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/23.jpg\"]'),(21,1,7,3.00,'Cool template. Excellent code quality. The support responds very quickly, which is very rare on themeforest and codecanyon.net, I buy a lot of templates, and everyone will have a response from technical support for two or three days. Thanks to tech support. I recommend to buy.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/11.jpg\",\"products\\/24.jpg\"]'),(22,3,34,2.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/21.jpg\",\"products\\/20.jpg\"]'),(23,5,40,1.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\",\"products\\/20.jpg\"]'),(24,8,31,5.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\",\"products\\/24.jpg\"]'),(25,7,8,3.00,'The script is the best of its class, fast, easy to implement and work with , and the most important thing is the great support team , Recommend with no doubt.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/25.jpg\"]'),(26,1,27,4.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/24.jpg\"]'),(27,9,29,4.00,'The best store template! Excellent coding! Very good support! Thank you so much for all the help, I really appreciated.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/24.jpg\"]'),(29,6,33,3.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/14.jpg\"]'),(30,7,36,5.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/20.jpg\"]'),(31,1,16,5.00,'This web app is really good in design, code quality & features. Besides, the customer support provided by the Botble team was really fast & helpful. You guys are awesome!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/19.jpg\",\"products\\/21.jpg\"]'),(32,3,6,1.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\"]'),(33,3,32,3.00,'This web app is really good in design, code quality & features. Besides, the customer support provided by the Botble team was really fast & helpful. You guys are awesome!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\"]'),(34,3,19,2.00,'I Love this Script. I also found how to add other fees. Now I just wait the BIG update for the Marketplace with the Bulk Import. Just do not forget to make it to be Multi-language for us the Botble Fans.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\",\"products\\/25.jpg\"]'),(35,8,27,3.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/22.jpg\"]'),(36,9,7,2.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/14.jpg\"]'),(37,8,32,1.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/24.jpg\"]'),(38,6,17,3.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/25.jpg\"]'),(39,6,10,1.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\"]'),(40,5,21,1.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/26.jpg\"]'),(41,5,14,4.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\"]'),(42,1,18,5.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/26.jpg\"]'),(43,1,40,4.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/3.jpg\",\"products\\/20.jpg\"]'),(44,4,15,2.00,'The script is the best of its class, fast, easy to implement and work with , and the most important thing is the great support team , Recommend with no doubt.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/19.jpg\",\"products\\/21.jpg\"]'),(45,2,5,5.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/3.jpg\",\"products\\/25.jpg\"]'),(46,3,12,2.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/21.jpg\"]'),(48,6,15,5.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/22.jpg\"]'),(49,7,25,2.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\",\"products\\/20.jpg\"]'),(50,7,26,1.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\"]'),(52,9,9,1.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\"]'),(53,3,27,5.00,'Best ecommerce CMS online store!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\"]'),(55,2,16,4.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/12.jpg\",\"products\\/23.jpg\"]'),(56,5,3,4.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/11.jpg\",\"products\\/21.jpg\"]'),(57,7,41,2.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/23.jpg\"]'),(58,4,8,3.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\",\"products\\/25.jpg\"]'),(59,5,22,2.00,'Cool template. Excellent code quality. The support responds very quickly, which is very rare on themeforest and codecanyon.net, I buy a lot of templates, and everyone will have a response from technical support for two or three days. Thanks to tech support. I recommend to buy.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\"]'),(60,9,26,3.00,'The script is the best of its class, fast, easy to implement and work with , and the most important thing is the great support team , Recommend with no doubt.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\",\"products\\/22.jpg\"]'),(61,5,29,5.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/21.jpg\",\"products\\/26.jpg\"]'),(63,3,9,5.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/26.jpg\"]'),(64,9,15,1.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/10.jpg\"]'),(65,9,16,5.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\"]'),(66,7,30,3.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\"]'),(67,8,5,3.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/13.jpg\",\"products\\/25.jpg\"]'),(68,6,32,3.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\",\"products\\/25.jpg\"]'),(69,6,25,4.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/25.jpg\"]'),(70,3,18,1.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\"]'),(71,6,41,4.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\",\"products\\/25.jpg\"]'),(72,8,34,1.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/24.jpg\"]'),(73,1,13,2.00,'The code is good, in general, if you like it, can you give it 5 stars?','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\",\"products\\/26.jpg\"]'),(74,7,27,4.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/2.jpg\",\"products\\/25.jpg\"]'),(75,9,10,2.00,'Those guys now what they are doing, the release such a good product that it\'s a pleasure to work with ! Even when I was stuck on the project, I created a ticket and the next day it was replied by the team. GOOD JOB guys. I love working with them :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/2.jpg\",\"products\\/21.jpg\"]'),(76,7,11,4.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\"]'),(77,5,34,2.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\",\"products\\/21.jpg\"]'),(78,9,23,4.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/21.jpg\"]'),(79,6,14,2.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/25.jpg\"]'),(80,2,24,1.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\"]'),(81,1,8,5.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/16.jpg\",\"products\\/26.jpg\"]'),(82,4,18,3.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\",\"products\\/20.jpg\"]'),(83,8,22,2.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/26.jpg\"]'),(84,8,16,1.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/24.jpg\"]'),(85,4,29,1.00,'This web app is really good in design, code quality & features. Besides, the customer support provided by the Botble team was really fast & helpful. You guys are awesome!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\",\"products\\/26.jpg\"]'),(86,3,5,2.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/26.jpg\"]'),(87,4,22,3.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/22.jpg\"]'),(89,1,35,4.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/24.jpg\"]'),(90,4,25,2.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/20.jpg\"]'),(92,6,26,3.00,'Cool template. Excellent code quality. The support responds very quickly, which is very rare on themeforest and codecanyon.net, I buy a lot of templates, and everyone will have a response from technical support for two or three days. Thanks to tech support. I recommend to buy.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/2.jpg\",\"products\\/25.jpg\"]'),(93,9,32,5.00,'Ok good product. I have some issues in customizations. But its not correct to blame the developer. The product is good. Good luck for your business.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\",\"products\\/22.jpg\"]'),(94,6,39,2.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\"]'),(95,5,17,4.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/12.jpg\"]'),(97,9,3,4.00,'Customer Support are grade (A*), however the code is a way too over engineered for it\'s purpose.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\"]'),(98,3,8,5.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/3.jpg\"]'),(99,8,6,4.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/25.jpg\"]'),(100,2,39,4.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\",\"products\\/21.jpg\"]'),(101,6,16,2.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/2.jpg\"]'),(103,2,37,5.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\",\"products\\/25.jpg\"]'),(104,3,23,4.00,'Cool template. Excellent code quality. The support responds very quickly, which is very rare on themeforest and codecanyon.net, I buy a lot of templates, and everyone will have a response from technical support for two or three days. Thanks to tech support. I recommend to buy.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/26.jpg\"]'),(105,9,5,3.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\",\"products\\/21.jpg\"]'),(106,5,39,5.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/22.jpg\"]'),(107,2,21,1.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/8.jpg\",\"products\\/25.jpg\"]'),(108,1,2,2.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/21.jpg\"]'),(109,9,31,3.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/24.jpg\"]'),(110,2,25,2.00,'Ok good product. I have some issues in customizations. But its not correct to blame the developer. The product is good. Good luck for your business.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/12.jpg\"]'),(114,5,36,1.00,'Best ecommerce CMS online store!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/13.jpg\",\"products\\/21.jpg\"]'),(115,6,7,1.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\",\"products\\/25.jpg\"]'),(116,3,21,1.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\"]'),(117,3,14,1.00,'Solution is too robust for our purpose so we didn\'t use it at the end. But I appreciate customer support during initial configuration.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\"]'),(118,3,41,3.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/8.jpg\"]'),(119,6,23,2.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/11.jpg\"]'),(120,4,2,3.00,'Solution is too robust for our purpose so we didn\'t use it at the end. But I appreciate customer support during initial configuration.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/25.jpg\"]'),(121,1,41,4.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\"]'),(122,7,39,1.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/13.jpg\",\"products\\/26.jpg\"]'),(123,1,1,4.00,'This script is well coded and is super fast. The support is pretty quick. Very patient and helpful team. I strongly recommend it and they deserve more than 5 stars.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\",\"products\\/21.jpg\"]'),(124,1,24,5.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/25.jpg\"]'),(125,4,4,5.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/3.jpg\",\"products\\/20.jpg\"]'),(126,2,8,5.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\"]'),(128,8,40,5.00,'These guys are amazing! Responses immediately, amazing support and help... I immediately feel at ease after Purchasing..','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/22.jpg\"]'),(132,6,1,5.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/13.jpg\"]'),(133,1,5,4.00,'I Love this Script. I also found how to add other fees. Now I just wait the BIG update for the Marketplace with the Bulk Import. Just do not forget to make it to be Multi-language for us the Botble Fans.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/25.jpg\"]'),(135,1,26,5.00,'For me the best eCommerce script on Envato at this moment: modern, clean code, a lot of great features. The customer support is great too: I always get an answer within hours!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/22.jpg\"]'),(136,1,39,4.00,'I Love this Script. I also found how to add other fees. Now I just wait the BIG update for the Marketplace with the Bulk Import. Just do not forget to make it to be Multi-language for us the Botble Fans.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\"]'),(137,4,26,4.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\"]'),(139,5,4,3.00,'The code is good, in general, if you like it, can you give it 5 stars?','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/14.jpg\",\"products\\/21.jpg\"]'),(140,7,28,5.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\",\"products\\/25.jpg\"]'),(141,2,31,4.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/17.jpg\",\"products\\/24.jpg\"]'),(145,5,12,4.00,'Ok good product. I have some issues in customizations. But its not correct to blame the developer. The product is good. Good luck for your business.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/23.jpg\"]'),(147,1,31,2.00,'Clean & perfect source code','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\",\"products\\/25.jpg\"]'),(149,5,28,1.00,'The script is the best of its class, fast, easy to implement and work with , and the most important thing is the great support team , Recommend with no doubt.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/25.jpg\"]'),(150,2,26,2.00,'Solution is too robust for our purpose so we didn\'t use it at the end. But I appreciate customer support during initial configuration.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/21.jpg\",\"products\\/20.jpg\"]'),(152,6,21,3.00,'The code is good, in general, if you like it, can you give it 5 stars?','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/16.jpg\",\"products\\/24.jpg\"]'),(153,3,36,5.00,'The code is good, in general, if you like it, can you give it 5 stars?','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/23.jpg\"]'),(154,5,7,3.00,'Solution is too robust for our purpose so we didn\'t use it at the end. But I appreciate customer support during initial configuration.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/19.jpg\",\"products\\/25.jpg\"]'),(156,3,33,3.00,'The best store template! Excellent coding! Very good support! Thank you so much for all the help, I really appreciated.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/11.jpg\",\"products\\/26.jpg\"]'),(158,5,18,3.00,'Great system, great support, good job Botble. I\'m looking forward to more great functional plugins.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/19.jpg\",\"products\\/24.jpg\"]'),(159,9,22,5.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/16.jpg\",\"products\\/21.jpg\"]'),(160,7,20,1.00,'Good app, good backup service and support. Good documentation.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\"]'),(161,4,19,3.00,'Second or third time that I buy a Botble product, happy with the products and support. You guys do a good job :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/25.jpg\"]'),(164,8,19,3.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\",\"products\\/26.jpg\"]'),(165,3,17,3.00,'Perfect +++++++++ i love it really also i get to fast ticket answers... Thanks Lot BOTBLE Teams','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\"]'),(167,8,38,1.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/19.jpg\"]'),(169,4,27,1.00,'Great system, great support, good job Botble. I\'m looking forward to more great functional plugins.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/5.jpg\",\"products\\/22.jpg\"]'),(170,9,35,2.00,'The script is the best of its class, fast, easy to implement and work with , and the most important thing is the great support team , Recommend with no doubt.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\"]'),(171,4,31,4.00,'This web app is really good in design, code quality & features. Besides, the customer support provided by the Botble team was really fast & helpful. You guys are awesome!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/23.jpg\"]'),(173,2,38,1.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/6.jpg\",\"products\\/20.jpg\"]'),(174,8,8,4.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\",\"products\\/21.jpg\"]'),(175,4,23,2.00,'Great E-commerce system. And much more : Wonderful Customer Support.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/4.jpg\",\"products\\/23.jpg\"]'),(176,2,41,4.00,'Ok good product. I have some issues in customizations. But its not correct to blame the developer. The product is good. Good luck for your business.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/8.jpg\"]'),(178,4,30,5.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/22.jpg\"]'),(180,3,2,5.00,'Amazing code, amazing support. Overall, im really confident in Botble and im happy I made the right choice! Thank you so much guys for coding this masterpiece','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/26.jpg\",\"products\\/20.jpg\"]'),(182,2,6,2.00,'The best ecommerce CMS! Excellent coding! best support service! Thank you so much..... I really like your hard work.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/25.jpg\",\"products\\/21.jpg\"]'),(183,5,33,2.00,'I Love this Script. I also found how to add other fees. Now I just wait the BIG update for the Marketplace with the Bulk Import. Just do not forget to make it to be Multi-language for us the Botble Fans.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/9.jpg\"]'),(186,8,12,1.00,'Ok good product. I have some issues in customizations. But its not correct to blame the developer. The product is good. Good luck for your business.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/15.jpg\",\"products\\/25.jpg\"]'),(187,6,5,2.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/24.jpg\",\"products\\/25.jpg\"]'),(188,5,32,4.00,'Customer Support are grade (A*), however the code is a way too over engineered for it\'s purpose.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\"]'),(190,8,7,1.00,'It\'s not my first experience here on Codecanyon and I can honestly tell you all that Botble puts a LOT of effort into the support. They answer so fast, they helped me tons of times. REALLY by far THE BEST EXPERIENCE on Codecanyon. Those guys at Botble are so good that they deserve 5 stars. I recommend them, I trust them and I can\'t wait to see what they will sell in a near future. Thank you Botble :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/22.jpg\",\"products\\/22.jpg\"]'),(191,8,18,2.00,'Those guys now what they are doing, the release such a good product that it\'s a pleasure to work with ! Even when I was stuck on the project, I created a ticket and the next day it was replied by the team. GOOD JOB guys. I love working with them :)','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/8.jpg\"]'),(192,6,3,5.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/1.jpg\",\"products\\/24.jpg\"]'),(193,2,33,1.00,'Best ecommerce CMS online store!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/18.jpg\",\"products\\/26.jpg\"]'),(194,2,18,5.00,'We have received brilliant service support and will be expanding the features with the developer. Nice product!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/11.jpg\",\"products\\/26.jpg\"]'),(196,1,23,5.00,'Very enthusiastic support! Excellent code is written. It\'s a true pleasure working with.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/23.jpg\",\"products\\/21.jpg\"]'),(199,8,30,1.00,'Best ecommerce CMS online store!','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/20.jpg\",\"products\\/24.jpg\"]'),(200,9,13,4.00,'As a developer I reviewed this script. This is really awesome ecommerce script. I have convinced when I noticed that it\'s built on fully WordPress concept.','published','2023-07-02 19:58:46','2023-07-02 19:58:46','[\"products\\/7.jpg\",\"products\\/23.jpg\"]');
/*!40000 ALTER TABLE `ec_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_shipment_histories`
--

DROP TABLE IF EXISTS `ec_shipment_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_shipment_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `shipment_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_shipment_histories`
--

LOCK TABLES `ec_shipment_histories` WRITE;
/*!40000 ALTER TABLE `ec_shipment_histories` DISABLE KEYS */;
INSERT INTO `ec_shipment_histories` VALUES (1,'create_from_order','Shipping was created from order %order_id%',0,1,1,'2023-06-29 11:58:46','2023-06-29 11:58:46','Botble\\ACL\\Models\\User'),(2,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,1,1,'2023-07-01 03:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(3,'create_from_order','Shipping was created from order %order_id%',0,2,2,'2023-06-28 01:58:46','2023-06-28 01:58:46','Botble\\ACL\\Models\\User'),(4,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,2,2,'2023-07-01 05:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(5,'update_cod_status','Updated COD status to Completed . Updated by: %user_name%',0,2,2,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(6,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,2,2,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(7,'create_from_order','Shipping was created from order %order_id%',0,3,3,'2023-06-29 19:58:46','2023-06-29 19:58:46','Botble\\ACL\\Models\\User'),(8,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,3,3,'2023-07-01 07:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(9,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,3,3,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(10,'create_from_order','Shipping was created from order %order_id%',0,4,4,'2023-06-24 07:58:46','2023-06-24 07:58:46','Botble\\ACL\\Models\\User'),(11,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,4,4,'2023-07-01 09:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(12,'update_cod_status','Updated COD status to Completed . Updated by: %user_name%',0,4,4,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(13,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,4,4,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(14,'create_from_order','Shipping was created from order %order_id%',0,5,5,'2023-06-19 11:58:46','2023-06-19 11:58:46','Botble\\ACL\\Models\\User'),(15,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,5,5,'2023-07-01 11:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(16,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,5,5,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(17,'create_from_order','Shipping was created from order %order_id%',0,6,6,'2023-06-22 19:58:46','2023-06-22 19:58:46','Botble\\ACL\\Models\\User'),(18,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,6,6,'2023-07-01 13:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(19,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,6,6,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(20,'create_from_order','Shipping was created from order %order_id%',0,7,7,'2023-07-01 15:58:46','2023-07-01 15:58:46','Botble\\ACL\\Models\\User'),(21,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,7,7,'2023-07-01 15:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(22,'create_from_order','Shipping was created from order %order_id%',0,8,8,'2023-06-29 13:58:46','2023-06-29 13:58:46','Botble\\ACL\\Models\\User'),(23,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,8,8,'2023-07-01 17:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(24,'create_from_order','Shipping was created from order %order_id%',0,9,9,'2023-06-25 19:58:46','2023-06-25 19:58:46','Botble\\ACL\\Models\\User'),(25,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,9,9,'2023-07-01 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(26,'create_from_order','Shipping was created from order %order_id%',0,10,10,'2023-06-30 01:58:46','2023-06-30 01:58:46','Botble\\ACL\\Models\\User'),(27,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,10,10,'2023-07-01 21:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(28,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,10,10,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(29,'create_from_order','Shipping was created from order %order_id%',0,11,11,'2023-06-28 15:58:46','2023-06-28 15:58:46','Botble\\ACL\\Models\\User'),(30,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,11,11,'2023-07-01 23:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(31,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,11,11,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(32,'create_from_order','Shipping was created from order %order_id%',0,12,12,'2023-06-30 13:58:46','2023-06-30 13:58:46','Botble\\ACL\\Models\\User'),(33,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,12,12,'2023-07-02 01:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(34,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,12,12,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(35,'create_from_order','Shipping was created from order %order_id%',0,13,13,'2023-07-02 03:58:46','2023-07-02 03:58:46','Botble\\ACL\\Models\\User'),(36,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,13,13,'2023-07-02 03:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(37,'create_from_order','Shipping was created from order %order_id%',0,14,14,'2023-06-26 23:58:46','2023-06-26 23:58:46','Botble\\ACL\\Models\\User'),(38,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,14,14,'2023-07-02 05:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(39,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,14,14,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(40,'create_from_order','Shipping was created from order %order_id%',0,15,15,'2023-06-30 19:58:46','2023-06-30 19:58:46','Botble\\ACL\\Models\\User'),(41,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,15,15,'2023-07-02 07:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(42,'create_from_order','Shipping was created from order %order_id%',0,16,16,'2023-07-01 13:58:46','2023-07-01 13:58:46','Botble\\ACL\\Models\\User'),(43,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,16,16,'2023-07-02 09:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(44,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,16,16,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(45,'create_from_order','Shipping was created from order %order_id%',0,17,17,'2023-07-01 03:58:46','2023-07-01 03:58:46','Botble\\ACL\\Models\\User'),(46,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,17,17,'2023-07-02 11:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(47,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,17,17,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(48,'create_from_order','Shipping was created from order %order_id%',0,18,18,'2023-07-01 07:58:46','2023-07-01 07:58:46','Botble\\ACL\\Models\\User'),(49,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,18,18,'2023-07-02 13:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(50,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,18,18,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(51,'create_from_order','Shipping was created from order %order_id%',0,19,19,'2023-07-02 07:58:46','2023-07-02 07:58:46','Botble\\ACL\\Models\\User'),(52,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,19,19,'2023-07-02 15:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(53,'update_status','Changed status of shipping to: Delivered. Updated by: %user_name%',0,19,19,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User'),(54,'create_from_order','Shipping was created from order %order_id%',0,20,20,'2023-07-02 17:58:46','2023-07-02 17:58:46','Botble\\ACL\\Models\\User'),(55,'update_status','Changed status of shipping to: Approved. Updated by: %user_name%',0,20,20,'2023-07-02 17:58:46','2023-07-02 19:58:46','Botble\\ACL\\Models\\User');
/*!40000 ALTER TABLE `ec_shipment_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_shipments`
--

DROP TABLE IF EXISTS `ec_shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `weight` double(8,2) DEFAULT '0.00',
  `shipment_id` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate_id` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `cod_amount` decimal(15,2) DEFAULT '0.00',
  `cod_status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `cross_checking_status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `price` decimal(15,2) DEFAULT '0.00',
  `store_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tracking_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimate_date_shipped` datetime DEFAULT NULL,
  `date_shipped` datetime DEFAULT NULL,
  `label_url` text COLLATE utf8mb4_unicode_ci,
  `metadata` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_shipments`
--

LOCK TABLES `ec_shipments` WRITE;
/*!40000 ALTER TABLE `ec_shipments` DISABLE KEYS */;
INSERT INTO `ec_shipments` VALUES (1,1,NULL,1471.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0051858364','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46',NULL,NULL,NULL),(2,2,NULL,6041.00,NULL,NULL,'','delivered',425.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0025373068','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-10 02:58:46','2023-07-03 02:58:46',NULL,NULL),(3,3,NULL,3406.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0072802932','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-05 02:58:46','2023-07-03 02:58:46',NULL,NULL),(4,4,NULL,4645.00,NULL,NULL,'','delivered',211.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0014164404','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-10 02:58:46','2023-07-03 02:58:46',NULL,NULL),(5,5,NULL,2786.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0029806744','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-11 02:58:46','2023-07-03 02:58:46',NULL,NULL),(6,6,NULL,2356.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0085415911','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-09 02:58:46','2023-07-03 02:58:46',NULL,NULL),(7,7,NULL,2487.00,NULL,NULL,'','approved',113.00,'pending','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0074795124','FastShipping','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46',NULL,NULL,NULL),(8,8,NULL,4204.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0054972167','DHL','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-05 02:58:46',NULL,NULL,NULL),(9,9,NULL,2196.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0017439867','FastShipping','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46',NULL,NULL,NULL),(10,10,NULL,3786.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0040192342','FastShipping','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-11 02:58:46','2023-07-03 02:58:46',NULL,NULL),(11,11,NULL,6261.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0030781647','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46','2023-07-03 02:58:46',NULL,NULL),(12,12,NULL,4974.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0049222509','FastShipping','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-13 02:58:46','2023-07-03 02:58:46',NULL,NULL),(13,13,NULL,3284.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0054590114','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-09 02:58:46',NULL,NULL,NULL),(14,14,NULL,3280.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0088218735','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-11 02:58:46','2023-07-03 02:58:46',NULL,NULL),(15,15,NULL,2061.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0084207200','AliExpress','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-07 02:58:46',NULL,NULL,NULL),(16,16,NULL,2320.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0035492794','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-10 02:58:46','2023-07-03 02:58:46',NULL,NULL),(17,17,NULL,4618.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0083115808','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46','2023-07-03 02:58:46',NULL,NULL),(18,18,NULL,4613.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0072569142','AliExpress','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-12 02:58:46','2023-07-03 02:58:46',NULL,NULL),(19,19,NULL,5635.00,NULL,NULL,'','delivered',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0080695577','FastShipping','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-11 02:58:46','2023-07-03 02:58:46',NULL,NULL),(20,20,NULL,1192.00,NULL,NULL,'','approved',0.00,'completed','pending',0.00,0,'2023-07-02 19:58:46','2023-07-02 19:58:46','JJD0029432256','GHN','https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference','2023-07-06 02:58:46',NULL,NULL,NULL);
/*!40000 ALTER TABLE `ec_shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_shipping`
--

DROP TABLE IF EXISTS `ec_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_shipping` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_shipping`
--

LOCK TABLES `ec_shipping` WRITE;
/*!40000 ALTER TABLE `ec_shipping` DISABLE KEYS */;
INSERT INTO `ec_shipping` VALUES (1,'All',NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_shipping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_shipping_rule_items`
--

DROP TABLE IF EXISTS `ec_shipping_rule_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_shipping_rule_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipping_rule_id` bigint unsigned NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adjustment_price` decimal(15,2) DEFAULT '0.00',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_shipping_rule_items`
--

LOCK TABLES `ec_shipping_rule_items` WRITE;
/*!40000 ALTER TABLE `ec_shipping_rule_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_shipping_rule_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_shipping_rules`
--

DROP TABLE IF EXISTS `ec_shipping_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_shipping_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_id` bigint unsigned NOT NULL,
  `type` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'based_on_price',
  `from` decimal(15,2) DEFAULT '0.00',
  `to` decimal(15,2) DEFAULT '0.00',
  `price` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_shipping_rules`
--

LOCK TABLES `ec_shipping_rules` WRITE;
/*!40000 ALTER TABLE `ec_shipping_rules` DISABLE KEYS */;
INSERT INTO `ec_shipping_rules` VALUES (1,'Free delivery',1,'based_on_price',0.00,NULL,0.00,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_shipping_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_store_locators`
--

DROP TABLE IF EXISTS `ec_store_locators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_store_locators` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `is_shipping_location` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_store_locators`
--

LOCK TABLES `ec_store_locators` WRITE;
/*!40000 ALTER TABLE `ec_store_locators` DISABLE KEYS */;
INSERT INTO `ec_store_locators` VALUES (1,'Starbelly','sales@archielite.com','1800979769','502 New Street','AU','Brighton VIC','Brighton VIC',1,1,'2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_store_locators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_tax_products`
--

DROP TABLE IF EXISTS `ec_tax_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_tax_products` (
  `tax_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`tax_id`),
  KEY `ec_tax_products_tax_id_index` (`tax_id`),
  KEY `ec_tax_products_product_id_index` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_tax_products`
--

LOCK TABLES `ec_tax_products` WRITE;
/*!40000 ALTER TABLE `ec_tax_products` DISABLE KEYS */;
INSERT INTO `ec_tax_products` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41);
/*!40000 ALTER TABLE `ec_tax_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_taxes`
--

DROP TABLE IF EXISTS `ec_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_taxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` double(8,6) DEFAULT NULL,
  `priority` int DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_taxes`
--

LOCK TABLES `ec_taxes` WRITE;
/*!40000 ALTER TABLE `ec_taxes` DISABLE KEYS */;
INSERT INTO `ec_taxes` VALUES (1,'VAT',10.000000,1,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(2,'None',0.000000,2,'published','2023-07-02 19:58:46','2023-07-02 19:58:46'),(3,'Import Tax',15.000000,3,'published','2023-07-02 19:58:46','2023-07-02 19:58:46');
/*!40000 ALTER TABLE `ec_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ec_wish_lists`
--

DROP TABLE IF EXISTS `ec_wish_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ec_wish_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ec_wish_lists_product_id_customer_id_index` (`product_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ec_wish_lists`
--

LOCK TABLES `ec_wish_lists` WRITE;
/*!40000 ALTER TABLE `ec_wish_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `ec_wish_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_categories`
--

DROP TABLE IF EXISTS `faq_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_categories`
--

LOCK TABLES `faq_categories` WRITE;
/*!40000 ALTER TABLE `faq_categories` DISABLE KEYS */;
INSERT INTO `faq_categories` VALUES (1,'General',0,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'Buying',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'Payment',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(4,'Support',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `faq_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_categories_translations`
--

DROP TABLE IF EXISTS `faq_categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_categories_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq_categories_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`faq_categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_categories_translations`
--

LOCK TABLES `faq_categories_translations` WRITE;
/*!40000 ALTER TABLE `faq_categories_translations` DISABLE KEYS */;
INSERT INTO `faq_categories_translations` VALUES ('vi',1,NULL),('vi',2,NULL),('vi',3,NULL),('vi',4,NULL);
/*!40000 ALTER TABLE `faq_categories_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,'Where does it come from?','If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'How StarBelly Work?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'What is your shipping policy?','Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(4,'Where To Place A FAQ Page','Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(5,'Why do we use it?','It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(6,'Where can I get some?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(7,'Where does it come from?','If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(8,'How StarBelly Work?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',4,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(9,'What is your shipping policy?','Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(10,'Where To Place A FAQ Page','Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(11,'Why do we use it?','It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(12,'Where can I get some?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(13,'Where does it come from?','If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',4,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(14,'How StarBelly Work?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(15,'What is your shipping policy?','Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',4,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(16,'Where To Place A FAQ Page','Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(17,'Why do we use it?','It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(18,'Where can I get some?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(19,'Where does it come from?','If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(20,'How StarBelly Work?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',4,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(21,'What is your shipping policy?','Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(22,'Where To Place A FAQ Page','Just as the name suggests, a FAQ page is all about simple questions and answers. Gather common questions your customers have asked from your support team and include them in the FAQ, Use categories to organize questions related to specific topics.',2,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(23,'Why do we use it?','It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.',3,'published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(24,'Where can I get some?','To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.',1,'published','2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs_translations`
--

DROP TABLE IF EXISTS `faqs_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faqs_id` bigint unsigned NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `answer` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`faqs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs_translations`
--

LOCK TABLES `faqs_translations` WRITE;
/*!40000 ALTER TABLE `faqs_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,'Perfect','It was high time you were INSIDE, you might knock, and I never understood what it was very uncomfortable, and, as she said to herself, and fanned herself with one finger pressed upon its forehead.',1,0,'galleries/1.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(2,'New Day','The question is, what?\' The great question certainly was, what? Alice looked at Two. Two began in a day did you call it purring, not growling,\' said Alice. \'Why?\' \'IT DOES THE BOOTS AND SHOES.\' the.',1,0,'galleries/2.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(3,'Happy Day','White Rabbit, jumping up in great disgust, and walked a little of the Mock Turtle Soup is made from,\' said the White Rabbit; \'in fact, there\'s nothing written on the same year for such a very little.',1,0,'galleries/3.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(4,'Nature','White Rabbit, trotting slowly back again, and said, \'So you did, old fellow!\' said the Caterpillar. \'Well, I\'ve tried hedges,\' the Pigeon had finished. \'As if I only wish people knew that: then they.',0,0,'galleries/4.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(5,'Morning','Let this be a very truthful child; \'but little girls eat eggs quite as much as she had drunk half the bottle, she found her head on her toes when they hit her; and the Queen left off, quite out of a.',0,0,'galleries/5.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(6,'Photography','There ought to have been ill.\' \'So they were,\' said the Caterpillar. \'Well, perhaps not,\' said the Gryphon. \'Well, I shan\'t go, at any rate,\' said Alice: \'besides, that\'s not a mile high,\' said.',0,0,'galleries/6.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(7,'Summer','However, this bottle does. I do so like that curious song about the twentieth time that day. \'That PROVES his guilt,\' said the Cat. \'--so long as it spoke (it was exactly three inches high). \'But.',1,0,'galleries/7.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(8,'Holiday','ARE OLD, FATHER WILLIAM,\"\' said the Caterpillar. \'Not QUITE right, I\'m afraid,\' said Alice, \'how am I to get out again. That\'s all.\' \'Thank you,\' said the White Rabbit was still in sight, hurrying.',1,0,'galleries/8.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(9,'Winter','I\'m I, and--oh dear, how puzzling it all came different!\' Alice replied in a fight with another hedgehog, which seemed to be ashamed of yourself,\' said Alice, a little feeble, squeaking voice.',0,0,'galleries/9.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(10,'Warm','QUITE as much use in crying like that!\' But she waited patiently. \'Once,\' said the King, the Queen, who was reading the list of the what?\' said the King. \'Nothing whatever,\' said Alice. \'I\'ve so.',0,0,'galleries/10.jpg',1,'published','2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries_translations`
--

DROP TABLE IF EXISTS `galleries_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleries_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`galleries_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries_translations`
--

LOCK TABLES `galleries_translations` WRITE;
/*!40000 ALTER TABLE `galleries_translations` DISABLE KEYS */;
INSERT INTO `galleries_translations` VALUES ('vi',1,NULL,NULL),('vi',2,NULL,NULL),('vi',3,NULL,NULL),('vi',4,NULL,NULL),('vi',5,NULL,NULL),('vi',6,NULL,NULL),('vi',7,NULL,NULL),('vi',8,NULL,NULL),('vi',9,NULL,NULL),('vi',10,NULL,NULL);
/*!40000 ALTER TABLE `galleries_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_meta`
--

DROP TABLE IF EXISTS `gallery_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_meta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `images` text COLLATE utf8mb4_unicode_ci,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_meta_reference_id_index` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_meta`
--

LOCK TABLES `gallery_meta` WRITE;
/*!40000 ALTER TABLE `gallery_meta` DISABLE KEYS */;
INSERT INTO `gallery_meta` VALUES (1,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',1,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(2,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',2,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(3,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',3,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(4,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',4,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(5,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',5,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(6,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',6,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(7,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',7,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(8,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',8,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(9,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',9,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47'),(10,'[{\"img\":\"galleries\\/1.jpg\",\"description\":\"Eius qui in tenetur voluptas saepe distinctio. Consectetur et in quidem sunt. Est unde excepturi unde nihil architecto distinctio ut.\"},{\"img\":\"galleries\\/2.jpg\",\"description\":\"Et et occaecati numquam minus dolores aliquid et. Sapiente nulla ut veritatis molestiae rerum dolorem qui. Earum veniam ut maiores et possimus.\"},{\"img\":\"galleries\\/3.jpg\",\"description\":\"Voluptatem quia et facere dolorem porro magnam aut. Quis et aut totam reiciendis totam. Enim animi sapiente eligendi. Illo voluptas qui corporis.\"},{\"img\":\"galleries\\/4.jpg\",\"description\":\"Omnis sunt dolorem dicta illo nobis ducimus. Qui repudiandae omnis doloribus sit sed voluptas. Qui cum accusamus ut accusamus vero.\"},{\"img\":\"galleries\\/5.jpg\",\"description\":\"Et et molestiae ipsa ratione. Reprehenderit ducimus porro voluptatem dolorem. Est maxime dolor non facere vero exercitationem nulla.\"},{\"img\":\"galleries\\/6.jpg\",\"description\":\"Sed sed fugit facilis adipisci quas. Possimus necessitatibus qui sunt dignissimos. Sequi quidem quis repellendus blanditiis eius quas aperiam.\"},{\"img\":\"galleries\\/7.jpg\",\"description\":\"Ut quia libero consectetur porro illo eos qui. Et itaque illum blanditiis vero. Provident hic aut corporis voluptas.\"},{\"img\":\"galleries\\/8.jpg\",\"description\":\"Voluptatem hic vel ipsam cupiditate alias. Mollitia occaecati sunt in autem qui dignissimos sint. Qui minima accusamus sit.\"},{\"img\":\"galleries\\/9.jpg\",\"description\":\"Eum dicta accusantium labore atque rem. Magni at fuga assumenda quia quisquam harum. Neque id eum natus non vero voluptatem.\"}]',10,'Botble\\Gallery\\Models\\Gallery','2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `gallery_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_meta_translations`
--

DROP TABLE IF EXISTS `gallery_meta_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_meta_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_meta_id` bigint unsigned NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`gallery_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_meta_translations`
--

LOCK TABLES `gallery_meta_translations` WRITE;
/*!40000 ALTER TABLE `gallery_meta_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_meta_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_meta`
--

DROP TABLE IF EXISTS `language_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language_meta` (
  `lang_meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_meta_code` text COLLATE utf8mb4_unicode_ci,
  `lang_meta_origin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_meta_id`),
  KEY `language_meta_reference_id_index` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_meta`
--

LOCK TABLES `language_meta` WRITE;
/*!40000 ALTER TABLE `language_meta` DISABLE KEYS */;
INSERT INTO `language_meta` VALUES (1,'en_US','730784ebd60315a56695f5440b7abb14',1,'Botble\\Menu\\Models\\MenuLocation'),(2,'en_US','ee10fd9a16b6b8cf7afa3427766f2d7f',1,'Botble\\Menu\\Models\\Menu'),(3,'vi','a16ef5f6fe5733e1e61ef8512458a4aa',2,'Botble\\Menu\\Models\\MenuLocation'),(4,'vi','ee10fd9a16b6b8cf7afa3427766f2d7f',2,'Botble\\Menu\\Models\\Menu');
/*!40000 ALTER TABLE `language_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `lang_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_locale` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_flag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `lang_order` int NOT NULL DEFAULT '0',
  `lang_is_rtl` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en','en_US','us',1,0,0);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_files`
--

DROP TABLE IF EXISTS `media_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_id` bigint unsigned NOT NULL DEFAULT '0',
  `mime_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_files_user_id_index` (`user_id`),
  KEY `media_files_index` (`folder_id`,`user_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_files`
--

LOCK TABLES `media_files` WRITE;
/*!40000 ALTER TABLE `media_files` DISABLE KEYS */;
INSERT INTO `media_files` VALUES (1,0,'1','1',1,'image/png',16632,'illustrations/1.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(2,0,'2','2',1,'image/png',16632,'illustrations/2.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(3,0,'3','3',1,'image/png',16632,'illustrations/3.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(4,0,'banner','banner',1,'image/png',44223,'illustrations/banner.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(5,0,'burger-2','burger-2',1,'image/png',16575,'illustrations/burger-2.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(6,0,'burger','burger',1,'image/png',12683,'illustrations/burger.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(7,0,'cup','cup',1,'image/png',21453,'illustrations/cup.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(8,0,'delivery','delivery',1,'image/png',27729,'illustrations/delivery.png','[]','2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(9,0,'envelope-1','envelope-1',1,'image/png',11023,'illustrations/envelope-1.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(10,0,'envelope-2','envelope-2',1,'image/png',6630,'illustrations/envelope-2.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(11,0,'girl','girl',1,'image/png',43193,'illustrations/girl.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(12,0,'interior-2','interior-2',1,'image/jpeg',16621,'illustrations/interior-2.jpg','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(13,0,'interior','interior',1,'image/jpeg',8141,'illustrations/interior.jpg','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(14,0,'man','man',1,'image/png',85597,'illustrations/man.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(15,0,'phones','phones',1,'image/png',30044,'illustrations/phones.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(16,0,'reservation','reservation',1,'image/png',125123,'illustrations/reservation.png','[]','2023-07-02 19:58:37','2023-07-02 19:58:37',NULL),(21,0,'android','android',3,'image/png',695,'platforms/android.png','[]','2023-07-02 19:58:38','2023-07-02 19:58:38',NULL),(22,0,'ios','ios',3,'image/png',586,'platforms/ios.png','[]','2023-07-02 19:58:38','2023-07-02 19:58:38',NULL),(23,0,'1','1',4,'image/jpeg',13770,'blog/1.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(24,0,'2','2',4,'image/jpeg',15760,'blog/2.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(25,0,'3','3',4,'image/jpeg',17308,'blog/3.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(26,0,'4','4',4,'image/jpeg',13770,'blog/4.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(27,0,'5','5',4,'image/jpeg',12798,'blog/5.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(28,0,'6','6',4,'image/jpeg',15317,'blog/6.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(29,0,'post-1','post-1',4,'image/jpeg',1927,'blog/post-1.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(30,0,'post-2','post-2',4,'image/jpeg',1927,'blog/post-2.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(31,0,'post-3','post-3',4,'image/jpeg',1927,'blog/post-3.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(32,0,'post-4','post-4',4,'image/jpeg',1927,'blog/post-4.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(33,0,'post-5','post-5',4,'image/jpeg',1927,'blog/post-5.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(34,0,'post-6','post-6',4,'image/jpeg',1927,'blog/post-6.jpg','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(35,0,'arrow-2','arrow-2',5,'image/png',927,'general/arrow-2.png','[]','2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(36,0,'arrow','arrow',5,'image/png',773,'general/arrow.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(37,0,'cart','cart',5,'image/png',529,'general/cart.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(38,0,'delivery','delivery',5,'image/png',359,'general/delivery.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(39,0,'dialog','dialog',5,'image/png',754,'general/dialog.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(40,0,'favicon','favicon',5,'image/png',2787,'general/favicon.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(41,0,'logo-light','logo-light',5,'image/png',4078,'general/logo-light.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(42,0,'logo','logo',5,'image/png',5383,'general/logo.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(43,0,'menu','menu',5,'image/png',860,'general/menu.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(44,0,'play','play',5,'image/png',568,'general/play.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(45,0,'search','search',5,'image/png',581,'general/search.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(46,0,'signature','signature',5,'image/png',7061,'general/signature.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(47,0,'success','success',5,'image/jpeg',41382,'general/success.jpg','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(48,0,'zoom','zoom',5,'image/png',164,'general/zoom.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(49,0,'breadcrumb_default','breadcrumb_default',6,'image/jpeg',11404,'backgrounds/breadcrumb-default.jpg','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(50,0,'girl','girl',6,'image/png',43193,'backgrounds/girl.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(51,0,'interior','interior',6,'image/jpeg',8141,'backgrounds/interior.jpg','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(52,0,'phones','phones',6,'image/png',30044,'backgrounds/phones.png','[]','2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(53,0,'1','1',7,'image/png',7298,'brands/1.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(54,0,'2','2',7,'image/png',7298,'brands/2.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(55,0,'3','3',7,'image/png',7298,'brands/3.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(56,0,'4','4',7,'image/png',7298,'brands/4.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(57,0,'5','5',7,'image/png',7298,'brands/5.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(58,0,'6','6',7,'image/png',7298,'brands/6.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(59,0,'7','7',7,'image/png',7298,'brands/7.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(60,0,'8','8',7,'image/png',7298,'brands/8.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(61,0,'1','1',8,'image/png',17400,'product-categories/1.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(62,0,'2','2',8,'image/png',11010,'product-categories/2.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(63,0,'3','3',8,'image/png',12868,'product-categories/3.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(64,0,'4','4',8,'image/png',10187,'product-categories/4.png','[]','2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(65,0,'1','1',9,'image/jpeg',17308,'products/1.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(66,0,'10','10',9,'image/jpeg',17308,'products/10.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(67,0,'11','11',9,'image/jpeg',17308,'products/11.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(68,0,'12','12',9,'image/jpeg',17308,'products/12.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(69,0,'13','13',9,'image/jpeg',17308,'products/13.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(70,0,'14','14',9,'image/jpeg',17308,'products/14.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(71,0,'15','15',9,'image/jpeg',17308,'products/15.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(72,0,'16','16',9,'image/jpeg',17308,'products/16.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(73,0,'17','17',9,'image/jpeg',17308,'products/17.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(74,0,'18','18',9,'image/jpeg',17308,'products/18.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(75,0,'19','19',9,'image/jpeg',17308,'products/19.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(76,0,'2','2',9,'image/jpeg',17308,'products/2.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(77,0,'20','20',9,'image/jpeg',17308,'products/20.jpg','[]','2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(78,0,'21','21',9,'image/jpeg',17308,'products/21.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(79,0,'22','22',9,'image/jpeg',17308,'products/22.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(80,0,'23','23',9,'image/jpeg',17308,'products/23.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(81,0,'24','24',9,'image/jpeg',17308,'products/24.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(82,0,'25','25',9,'image/jpeg',17308,'products/25.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(83,0,'26','26',9,'image/jpeg',17308,'products/26.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(84,0,'3','3',9,'image/jpeg',17308,'products/3.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(85,0,'4','4',9,'image/jpeg',17308,'products/4.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(86,0,'5','5',9,'image/jpeg',17308,'products/5.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(87,0,'6','6',9,'image/jpeg',17308,'products/6.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(88,0,'7','7',9,'image/jpeg',17308,'products/7.jpg','[]','2023-07-02 19:58:43','2023-07-02 19:58:43',NULL),(89,0,'8','8',9,'image/jpeg',17308,'products/8.jpg','[]','2023-07-02 19:58:44','2023-07-02 19:58:44',NULL),(90,0,'9','9',9,'image/jpeg',17308,'products/9.jpg','[]','2023-07-02 19:58:44','2023-07-02 19:58:44',NULL),(91,0,'1','1',10,'image/jpeg',2516,'customers/1.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(92,0,'2','2',10,'image/jpeg',2516,'customers/2.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(93,0,'3','3',10,'image/jpeg',2516,'customers/3.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(94,0,'4','4',10,'image/jpeg',2516,'customers/4.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(95,0,'5','5',10,'image/jpeg',2516,'customers/5.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(96,0,'6','6',10,'image/jpeg',2516,'customers/6.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(97,0,'7','7',10,'image/jpeg',2516,'customers/7.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(98,0,'8','8',10,'image/jpeg',2516,'customers/8.jpg','[]','2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(99,0,'1','1',11,'image/jpeg',14028,'galleries/1.jpg','[]','2023-07-02 19:58:46','2023-07-02 19:58:46',NULL),(100,0,'10','10',11,'image/jpeg',14028,'galleries/10.jpg','[]','2023-07-02 19:58:46','2023-07-02 19:58:46',NULL),(101,0,'11','11',11,'image/jpeg',14028,'galleries/11.jpg','[]','2023-07-02 19:58:46','2023-07-02 19:58:46',NULL),(102,0,'12','12',11,'image/jpeg',14028,'galleries/12.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(103,0,'2','2',11,'image/jpeg',14028,'galleries/2.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(104,0,'3','3',11,'image/jpeg',14028,'galleries/3.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(105,0,'4','4',11,'image/jpeg',14028,'galleries/4.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(106,0,'5','5',11,'image/jpeg',14028,'galleries/5.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(107,0,'6','6',11,'image/jpeg',14028,'galleries/6.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(108,0,'7','7',11,'image/jpeg',14028,'galleries/7.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(109,0,'8','8',11,'image/jpeg',14028,'galleries/8.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(110,0,'9','9',11,'image/jpeg',14028,'galleries/9.jpg','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(111,0,'1','1',12,'image/png',9697,'teams/1.png','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(112,0,'2','2',12,'image/png',10042,'teams/2.png','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(113,0,'3','3',12,'image/png',9553,'teams/3.png','[]','2023-07-02 19:58:47','2023-07-02 19:58:47',NULL),(114,0,'4','4',12,'image/png',10230,'teams/4.png','[]','2023-07-02 19:58:48','2023-07-02 19:58:48',NULL);
/*!40000 ALTER TABLE `media_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_folders`
--

DROP TABLE IF EXISTS `media_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_folders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_folders_user_id_index` (`user_id`),
  KEY `media_folders_index` (`parent_id`,`user_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_folders`
--

LOCK TABLES `media_folders` WRITE;
/*!40000 ALTER TABLE `media_folders` DISABLE KEYS */;
INSERT INTO `media_folders` VALUES (1,0,'illustrations','illustrations',0,'2023-07-02 19:58:36','2023-07-02 19:58:36',NULL),(3,0,'platforms','platforms',0,'2023-07-02 19:58:38','2023-07-02 19:58:38',NULL),(4,0,'blog','blog',0,'2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(5,0,'general','general',0,'2023-07-02 19:58:39','2023-07-02 19:58:39',NULL),(6,0,'backgrounds','backgrounds',0,'2023-07-02 19:58:40','2023-07-02 19:58:40',NULL),(7,0,'brands','brands',0,'2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(8,0,'product-categories','product-categories',0,'2023-07-02 19:58:41','2023-07-02 19:58:41',NULL),(9,0,'products','products',0,'2023-07-02 19:58:42','2023-07-02 19:58:42',NULL),(10,0,'customers','customers',0,'2023-07-02 19:58:45','2023-07-02 19:58:45',NULL),(11,0,'galleries','galleries',0,'2023-07-02 19:58:46','2023-07-02 19:58:46',NULL),(12,0,'teams','teams',0,'2023-07-02 19:58:47','2023-07-02 19:58:47',NULL);
/*!40000 ALTER TABLE `media_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_settings`
--

DROP TABLE IF EXISTS `media_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `media_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_settings`
--

LOCK TABLES `media_settings` WRITE;
/*!40000 ALTER TABLE `media_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_locations`
--

DROP TABLE IF EXISTS `menu_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `location` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_locations_menu_id_created_at_index` (`menu_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_locations`
--

LOCK TABLES `menu_locations` WRITE;
/*!40000 ALTER TABLE `menu_locations` DISABLE KEYS */;
INSERT INTO `menu_locations` VALUES (1,1,'main-menu','2023-07-02 19:58:47','2023-07-02 19:58:47'),(2,2,'main-menu','2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `menu_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_nodes`
--

DROP TABLE IF EXISTS `menu_nodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_nodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `reference_id` bigint unsigned DEFAULT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_font` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` tinyint unsigned NOT NULL DEFAULT '0',
  `title` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_class` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `has_child` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_nodes_menu_id_index` (`menu_id`),
  KEY `menu_nodes_parent_id_index` (`parent_id`),
  KEY `reference_id` (`reference_id`),
  KEY `reference_type` (`reference_type`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_nodes`
--

LOCK TABLES `menu_nodes` WRITE;
/*!40000 ALTER TABLE `menu_nodes` DISABLE KEYS */;
INSERT INTO `menu_nodes` VALUES (1,1,0,NULL,NULL,'/',NULL,0,'Home',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(2,1,1,1,'Botble\\Page\\Models\\Page','/homepage-1',NULL,0,'Home 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(3,1,1,2,'Botble\\Page\\Models\\Page','/homepage-2',NULL,0,'Home 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(4,1,1,3,'Botble\\Page\\Models\\Page','/homepage-3',NULL,0,'Home 3',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(5,1,1,4,'Botble\\Page\\Models\\Page','/homepage-4',NULL,0,'Home 4',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(6,1,0,NULL,NULL,'#',NULL,0,'Pages',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(7,1,6,5,'Botble\\Page\\Models\\Page','/about-us',NULL,0,'About 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(8,1,6,6,'Botble\\Page\\Models\\Page','/about-us-2',NULL,0,'About 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(9,1,6,7,'Botble\\Page\\Models\\Page','/blog',NULL,0,'Blog Style 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(10,1,6,8,'Botble\\Page\\Models\\Page','/blog-2',NULL,0,'Blog Style 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(11,1,6,NULL,NULL,'/the-top-2020-handbag-trends-to-know',NULL,0,'Publication',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(12,1,6,9,'Botble\\Page\\Models\\Page','/gallery-1',NULL,0,'Gallery 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(13,1,6,10,'Botble\\Page\\Models\\Page','/gallery-2',NULL,0,'Gallery 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(14,1,6,NULL,NULL,'/galleries/perfect',NULL,0,'Gallery Detail',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(15,1,6,11,'Botble\\Page\\Models\\Page','/reviews',NULL,0,'Reviews',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(16,1,6,12,'Botble\\Page\\Models\\Page','/faqs',NULL,0,'FAQs',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(17,1,6,NULL,NULL,'404',NULL,0,'Error 404',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(18,1,0,NULL,NULL,'#',NULL,0,'Shop',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(19,1,18,NULL,NULL,'/products',NULL,0,'Products',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(20,1,18,13,'Botble\\Page\\Models\\Page','/shop-list-1',NULL,0,'Shop List 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(21,1,18,14,'Botble\\Page\\Models\\Page','/shop-list-2',NULL,0,'Shop List 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(22,1,18,NULL,NULL,'/products/chevre-au-mill',NULL,0,'Product Page',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(23,1,18,NULL,NULL,'/cart',NULL,0,'Cart',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(24,1,0,NULL,NULL,'#',NULL,0,'Auth',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(25,1,24,NULL,NULL,'/register',NULL,0,'Sign Up',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(26,1,24,NULL,NULL,'/login',NULL,0,'Log In',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(27,1,24,NULL,NULL,'/password/reset',NULL,0,'Reset Password',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(28,1,0,15,'Botble\\Page\\Models\\Page','/contact',NULL,0,'Contact',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(29,2,0,NULL,NULL,'/',NULL,0,'Home',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(30,2,29,1,'Botble\\Page\\Models\\Page','/homepage-1',NULL,0,'Home 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(31,2,29,2,'Botble\\Page\\Models\\Page','/homepage-2',NULL,0,'Home 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(32,2,29,3,'Botble\\Page\\Models\\Page','/homepage-3',NULL,0,'Home 3',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(33,2,29,4,'Botble\\Page\\Models\\Page','/homepage-4',NULL,0,'Home 4',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(34,2,0,NULL,NULL,'#',NULL,0,'Pages',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(35,2,34,5,'Botble\\Page\\Models\\Page','/about-us',NULL,0,'About 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(36,2,34,6,'Botble\\Page\\Models\\Page','/about-us-2',NULL,0,'About 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(37,2,34,7,'Botble\\Page\\Models\\Page','/blog',NULL,0,'Blog Style 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(38,2,34,8,'Botble\\Page\\Models\\Page','/blog-2',NULL,0,'Blog Style 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(39,2,34,NULL,NULL,'/the-top-2020-handbag-trends-to-know',NULL,0,'Publication',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(40,2,34,9,'Botble\\Page\\Models\\Page','/gallery-1',NULL,0,'Gallery 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(41,2,34,10,'Botble\\Page\\Models\\Page','/gallery-2',NULL,0,'Gallery 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(42,2,34,NULL,NULL,'/galleries/perfect',NULL,0,'Gallery Detail',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(43,2,34,11,'Botble\\Page\\Models\\Page','/reviews',NULL,0,'Reviews',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(44,2,34,12,'Botble\\Page\\Models\\Page','/faqs',NULL,0,'FAQs',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(45,2,34,NULL,NULL,'404',NULL,0,'Error 404',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(46,2,0,NULL,NULL,'#',NULL,0,'Shop',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(47,2,46,NULL,NULL,'/products',NULL,0,'Products',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(48,2,46,13,'Botble\\Page\\Models\\Page','/shop-list-1',NULL,0,'Shop List 1',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(49,2,46,14,'Botble\\Page\\Models\\Page','/shop-list-2',NULL,0,'Shop List 2',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(50,2,46,NULL,NULL,'/products/chevre-au-mill',NULL,0,'Product Page',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(51,2,46,NULL,NULL,'/cart',NULL,0,'Cart',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(52,2,0,NULL,NULL,'#',NULL,0,'Auth',NULL,'_self',1,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(53,2,52,NULL,NULL,'/register',NULL,0,'Sign Up',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(54,2,52,NULL,NULL,'/login',NULL,0,'Log In',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(55,2,52,NULL,NULL,'/password/reset',NULL,0,'Reset Password',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47'),(56,2,0,15,'Botble\\Page\\Models\\Page','/contact',NULL,0,'Contact',NULL,'_self',0,'2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `menu_nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Main menu','main-menu','published','2023-07-02 19:58:47','2023-07-02 19:58:47'),(2,'Menu chính','menu-chinh','published','2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meta_boxes`
--

DROP TABLE IF EXISTS `meta_boxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meta_boxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meta_boxes_reference_id_index` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta_boxes`
--

LOCK TABLES `meta_boxes` WRITE;
/*!40000 ALTER TABLE `meta_boxes` DISABLE KEYS */;
INSERT INTO `meta_boxes` VALUES (1,'breadcrumb_style','[\"expanded\"]',4,'Botble\\Page\\Models\\Page','2023-07-02 19:58:38','2023-07-02 19:58:38'),(2,'breadcrumb_title','[\"Taste the dishes of the restaurant without leaving home.\"]',4,'Botble\\Page\\Models\\Page','2023-07-02 19:58:38','2023-07-02 19:58:38'),(3,'breadcrumb_subtitle','[\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\"]',4,'Botble\\Page\\Models\\Page','2023-07-02 19:58:38','2023-07-02 19:58:38'),(4,'breadcrumb_style','[\"expanded\"]',6,'Botble\\Page\\Models\\Page','2023-07-02 19:58:38','2023-07-02 19:58:38'),(5,'title','[null]',1,'Botble\\Testimonial\\Models\\Testimonial','2023-07-02 19:58:41','2023-07-02 19:58:41'),(6,'title','[null]',2,'Botble\\Testimonial\\Models\\Testimonial','2023-07-02 19:58:41','2023-07-02 19:58:41'),(7,'title','[null]',3,'Botble\\Testimonial\\Models\\Testimonial','2023-07-02 19:58:41','2023-07-02 19:58:41'),(8,'title','[null]',4,'Botble\\Testimonial\\Models\\Testimonial','2023-07-02 19:58:41','2023-07-02 19:58:41'),(9,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',1,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(10,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',2,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(11,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',3,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(12,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',4,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(13,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',5,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(14,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',6,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(15,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',7,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(16,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',8,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(17,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',9,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(18,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',10,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(19,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',11,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(20,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',12,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(21,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',13,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(22,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',14,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(23,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',15,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(24,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',16,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(25,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',17,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(26,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',18,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(27,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',19,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(28,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',20,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(29,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',21,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(30,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',22,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(31,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',23,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(32,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',24,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(33,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',25,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(34,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',26,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(35,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',27,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(36,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',28,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(37,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',29,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(38,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',30,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(39,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',31,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(40,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',32,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(41,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',33,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(42,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',34,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(43,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',35,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(44,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',36,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(45,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',37,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(46,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',38,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(47,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',39,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(48,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',40,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44'),(49,'faq_schema_config','[[[{\"key\":\"question\",\"value\":\"What Shipping Methods Are Available?\"},{\"key\":\"answer\",\"value\":\"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor.\"}],[{\"key\":\"question\",\"value\":\"Do You Ship Internationally?\"},{\"key\":\"answer\",\"value\":\"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray.\"}],[{\"key\":\"question\",\"value\":\"How Long Will It Take To Get My Package?\"},{\"key\":\"answer\",\"value\":\"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice.\"}],[{\"key\":\"question\",\"value\":\"What Payment Methods Are Accepted?\"},{\"key\":\"answer\",\"value\":\"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY.\"}],[{\"key\":\"question\",\"value\":\"Is Buying On-Line Safe?\"},{\"key\":\"answer\",\"value\":\"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest.\"}]]]',41,'Botble\\Ecommerce\\Models\\Product','2023-07-02 19:58:44','2023-07-02 19:58:44');
/*!40000 ALTER TABLE `meta_boxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_04_09_032329_create_base_tables',1),(2,'2013_04_09_062329_create_revisions_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_reset_tokens_table',1),(5,'2014_10_12_100000_create_password_resets_table',1),(6,'2016_06_10_230148_create_acl_tables',1),(7,'2016_06_14_230857_create_menus_table',1),(8,'2016_06_28_221418_create_pages_table',1),(9,'2016_10_05_074239_create_setting_table',1),(10,'2016_11_28_032840_create_dashboard_widget_tables',1),(11,'2016_12_16_084601_create_widgets_table',1),(12,'2017_05_09_070343_create_media_tables',1),(13,'2017_11_03_070450_create_slug_table',1),(14,'2019_01_05_053554_create_jobs_table',1),(15,'2019_08_19_000000_create_failed_jobs_table',1),(16,'2019_12_14_000001_create_personal_access_tokens_table',1),(17,'2022_04_20_100851_add_index_to_media_table',1),(18,'2022_04_20_101046_add_index_to_menu_table',1),(19,'2022_07_10_034813_move_lang_folder_to_root',1),(20,'2022_08_04_051940_add_missing_column_expires_at',1),(21,'2022_09_01_000001_create_admin_notifications_tables',1),(22,'2022_10_14_024629_drop_column_is_featured',1),(23,'2022_11_18_063357_add_missing_timestamp_in_table_settings',1),(24,'2022_12_02_093615_update_slug_index_columns',1),(25,'2023_01_30_024431_add_alt_to_media_table',1),(26,'2023_02_16_042611_drop_table_password_resets',1),(27,'2023_04_23_005903_add_column_permissions_to_admin_notifications',1),(28,'2023_05_10_075124_drop_column_id_in_role_users_table',1),(29,'2015_06_29_025744_create_audit_history',2),(30,'2015_06_18_033822_create_blog_table',3),(31,'2021_02_16_092633_remove_default_value_for_author_type',3),(32,'2021_12_03_030600_create_blog_translations',3),(33,'2022_04_19_113923_add_index_to_table_posts',3),(34,'2016_06_17_091537_create_contacts_table',4),(35,'2020_03_05_041139_create_ecommerce_tables',5),(36,'2021_01_01_044147_ecommerce_create_flash_sale_table',5),(37,'2021_01_17_082713_add_column_is_featured_to_product_collections_table',5),(38,'2021_01_18_024333_add_zip_code_into_table_customer_addresses',5),(39,'2021_02_18_073505_update_table_ec_reviews',5),(40,'2021_03_10_024419_add_column_confirmed_at_to_table_ec_customers',5),(41,'2021_03_10_025153_change_column_tax_amount',5),(42,'2021_03_20_033103_add_column_availability_to_table_ec_products',5),(43,'2021_04_28_074008_ecommerce_create_product_label_table',5),(44,'2021_05_31_173037_ecommerce_create_ec_products_translations',5),(45,'2021_06_28_153141_correct_slugs_data',5),(46,'2021_08_17_105016_remove_column_currency_id_in_some_tables',5),(47,'2021_08_30_142128_add_images_column_to_ec_reviews_table',5),(48,'2021_09_01_115151_remove_unused_fields_in_ec_products',5),(49,'2021_10_04_030050_add_column_created_by_to_table_ec_products',5),(50,'2021_10_05_122616_add_status_column_to_ec_customers_table',5),(51,'2021_11_03_025806_nullable_phone_number_in_ec_customer_addresses',5),(52,'2021_11_23_071403_correct_languages_for_product_variations',5),(53,'2021_11_28_031808_add_product_tags_translations',5),(54,'2021_12_01_031123_add_featured_image_to_ec_products',5),(55,'2022_01_01_033107_update_table_ec_shipments',5),(56,'2022_02_16_042457_improve_product_attribute_sets',5),(57,'2022_03_22_075758_correct_product_name',5),(58,'2022_04_19_113334_add_index_to_ec_products',5),(59,'2022_04_28_144405_remove_unused_table',5),(60,'2022_05_05_115015_create_ec_customer_recently_viewed_products_table',5),(61,'2022_05_18_143720_add_index_to_table_ec_product_categories',5),(62,'2022_06_16_095633_add_index_to_some_tables',5),(63,'2022_06_30_035148_create_order_referrals_table',5),(64,'2022_07_24_153815_add_completed_at_to_ec_orders_table',5),(65,'2022_08_14_032836_create_ec_order_returns_table',5),(66,'2022_08_14_033554_create_ec_order_return_items_table',5),(67,'2022_08_15_040324_add_billing_address',5),(68,'2022_08_30_091114_support_digital_products_table',5),(69,'2022_09_13_095744_create_options_table',5),(70,'2022_09_13_104347_create_option_value_table',5),(71,'2022_10_05_163518_alter_table_ec_order_product',5),(72,'2022_10_12_041517_create_invoices_table',5),(73,'2022_10_12_142226_update_orders_table',5),(74,'2022_10_13_024916_update_table_order_returns',5),(75,'2022_10_21_030830_update_columns_in_ec_shipments_table',5),(76,'2022_10_28_021046_update_columns_in_ec_shipments_table',5),(77,'2022_11_16_034522_update_type_column_in_ec_shipping_rules_table',5),(78,'2022_11_19_041643_add_ec_tax_product_table',5),(79,'2022_12_12_063830_update_tax_defadult_in_ec_tax_products_table',5),(80,'2022_12_17_041532_fix_address_in_order_invoice',5),(81,'2022_12_26_070329_create_ec_product_views_table',5),(82,'2023_01_04_033051_fix_product_categories',5),(83,'2023_01_09_050400_add_ec_global_options_translations_table',5),(84,'2023_01_10_093754_add_missing_option_value_id',5),(85,'2023_01_17_082713_add_column_barcode_and_cost_per_item_to_product_table',5),(86,'2023_01_26_021854_add_ec_customer_used_coupons_table',5),(87,'2023_02_08_015900_update_options_column_in_ec_order_product_table',5),(88,'2023_02_27_095752_remove_duplicate_reviews',5),(89,'2023_03_20_115757_add_user_type_column_to_ec_shipment_histories_table',5),(90,'2023_04_21_082427_create_ec_product_categorizables_table',5),(91,'2023_05_03_011331_add_missing_column_price_into_invoice_items_table',5),(92,'2023_05_17_025812_fix_invoice_issue',5),(93,'2023_05_26_073140_move_option_make_phone_field_optional_at_checkout_page_to_mandatory_fields',5),(94,'2023_05_27_144611_fix_exchange_rate_setting',5),(95,'2023_06_22_084331_add_generate_license_code_to_ec_products_table',5),(96,'2023_06_30_042512_create_ec_order_tax_information_table',5),(97,'2018_07_09_221238_create_faq_table',6),(98,'2021_12_03_082134_create_faq_translations',6),(99,'2016_10_13_150201_create_galleries_table',7),(100,'2021_12_03_082953_create_gallery_translations',7),(101,'2022_04_30_034048_create_gallery_meta_translations_table',7),(102,'2016_10_03_032336_create_languages_table',8),(103,'2021_10_25_021023_fix-priority-load-for-language-advanced',9),(104,'2021_12_03_075608_create_page_translations',9),(105,'2019_11_18_061011_create_country_table',10),(106,'2021_12_03_084118_create_location_translations',10),(107,'2021_12_03_094518_migrate_old_location_data',10),(108,'2021_12_10_034440_switch_plugin_location_to_use_language_advanced',10),(109,'2022_01_16_085908_improve_plugin_location',10),(110,'2022_08_04_052122_delete_location_backup_tables',10),(111,'2023_04_23_061847_increase_state_translations_abbreviation_column',10),(112,'2017_10_24_154832_create_newsletter_table',11),(113,'2017_05_18_080441_create_payment_tables',12),(114,'2021_03_27_144913_add_customer_type_into_table_payments',12),(115,'2021_05_24_034720_make_column_currency_nullable',12),(116,'2021_08_09_161302_add_metadata_column_to_payments_table',12),(117,'2021_10_19_020859_update_metadata_field',12),(118,'2022_06_28_151901_activate_paypal_stripe_plugin',12),(119,'2022_07_07_153354_update_charge_id_in_table_payments',12),(120,'2022_11_02_092723_team_create_team_table',13),(121,'2018_07_09_214610_create_testimonial_table',14),(122,'2021_12_03_083642_create_testimonials_translations',14),(123,'2016_10_07_193005_create_translations_table',15);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscribed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Homepage 1','<div>[hero-banner style=\"1\" title=\"We do not cook, we create your emotions!\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" text_secondary=\"Hi, new friend!\" image=\"backgrounds/girl.png\" button_label_1=\"Our menu\" button_url_1=\"/shop-1\" button_label_2=\"About us\" button_url_2=\"/about-us\"][/hero-banner]</div><div>[our-features title=\"We are doing more than you expect\" title_1=\"We are located in the city center\" subtitle_1=\"Porto nemo venial necessitates presentiment diligent rem temporise disciple quo mod numeral.\" title_2=\"Fresh, organic ingredients\" subtitle_2=\"Consectetur numquam porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi.\" title_3=\"Own fast delivery\" subtitle_3=\"Necessitatibus praesentium eligendi rem temporibus adipisci quo modi. Lorem ipsum dolor sit.\" image=\"backgrounds/interior.jpg\" year_experience=\"2\"][/our-features]</div><div>[featured-categories title=\"What do you like today?\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" category_ids=\"1,2,3,4\" button_label=\"Shop now\" button_url=\"/shop-1\"][/featured-categories]</div><div>[products-list title=\"Most popular dishes\" subtitle=\"A great platform to buy, sell and rent your properties without any agent or commissions.\" type=\"feature\" style=\"slide\" items_on_slide=\"3\" limit=\"6\" footer_style=\"rating\" button_label=\"Shop now\" button_url=\"/shop-1\" button_icon=\"general/menu.png\"][/products-list]</div><div>[team title=\"They will cook for you\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" team_ids=\"1,2,3,4\" limit=\"4\" button_label=\"Open menu\" button_icon=\"general/menu.png\" button_url=\"/shop-1\"][/team]</div><div>[apps-download title=\"Download our mobile app.\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" image=\"backgrounds/phones.png\" platform_button_image_1=\"platforms/android.png\" platform_url_1=\"https://play.google.com/store\" platform_button_image_2=\"platforms/ios.png\" platform_url_2=\"https://www.apple.com/store\"][/apps-download]</div><div>[flash-sale-popup flash_sale_ids=\"1\" description=\"Et modi itaque praesentium\" timeout=\"5\"][/flash-sale-popup]</div>',1,NULL,'homepage','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(2,'Homepage 2','<div>[hero-banner style=&quot;2&quot; title=&quot;We do not cook, we create your emotions!&quot; subtitle=&quot;Consecrate numeral port nemo venial diligent rem disciple quo mod.&quot; text_secondary=&quot;Hi, new friend!&quot; image_1=&quot;illustrations/1.png&quot; image_2=&quot;illustrations/2.png&quot; image_3=&quot;illustrations/3.png&quot; message_1=&quot;&lt;span&gt;😋&lt;/span&gt; Om-nom-nom...&quot; message_2=&quot;&lt;span&gt;🥰&lt;/span&gt; Sooooo delicious!&quot; button_label_1=&quot;Our menu&quot; button_url_1=&quot;#&quot; button_label_2=&quot;About us&quot; button_url_2=&quot;#&quot;][/hero-banner]</div><div>[about-text image=&quot;galleries/2.jpg&quot; experience_year=&quot;17&quot; experience_text=&quot;Years Experience&quot; title=&quot;We are doing more than you expect&quot; text=&quot;Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. &lt;br&gt;&lt;br&gt; Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum.&quot; text_image=&quot;general/signature.png&quot;][/about-text]</div><div>[features title_1=\"We are located in the city center\" description_1=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_2=\"Fresh ingredients from organic farms\" description_2=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_3=\"Own fast delivery. 30 min Maximum\" description_3=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_4=\"Professional, experienced chefs\" description_4=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_5=\"The highest standards of service\" description_5=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\"][/features]</div><div>[products-list title=\"Most popular dishes\" subtitle=\"A great platform to buy, sell and rent your properties without any agent or commissions.\" type=\"trending\" style=\"slide\" items_per_row=\"3\" limit=\"5\" footer_style=\"rating\" button_label=\"Shop now\" button_url=\"/shop-2\" button_icon=\"general/menu.png\"][/products-list]</div><div>[testimonials title=\"Reviews about us\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" limit=\"5\" button_url=\"#\" button_label=\"All reviews\" button_icon=\"general/dialog.png\"][/testimonials]</div><div>[call-to-action title=\"Free delivery service.\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image=\"illustrations/delivery.png\" button_primary_url=\"#\" button_primary_label=\"Order delivery\" button_primary_icon=\"general/cart.png\" button_secondary_url=\"#\" button_secondary_label=\"Menu\" button_secondary_icon=\"general/menu.png\"][/call-to-action]</div>',1,NULL,'homepage','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(3,'Homepage 3','<div>[featured-categories category_ids=\"1,2,3,4\" style=\"1\"][/featured-categories]</div><div>[products-list title=\"Most popular dishes\" subtitle=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" type=\"trending\" style=\"slide\" items_per_row=\"4\" limit=\"6\" footer_style=\"add-to-cart\" button_label=\"Shop now\" button_url=\"/shop-1\" button_icon=\"general/arrow.png\"][/products-list]</div><div>[products-list title=\"Our Bestsellers\" subtitle=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" type=\"feature\" style=\"slide\" items_per_row=\"4\" limit=\"6\" footer_style=\"add-to-cart\" button_label=\"View all\" button_url=\"/shop-1\" button_icon=\"general/arrow.png\"][/products-list]</div><div>[team title=\"They will cook for you\" subtitle=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" team_ids=\"1,2,3,4\" limit=\"4\" button_label=\"More about us\" button_icon=\"general/arrow.png\"][/team]</div><div>[promo title_left=\"-50%\" subtitle_left=\"Discount for all* burgers!\" description_left=\"*Et modi itaque praesentium.\" image_left=\"illustrations/burger.png\" button_label_left=\"Get it now\" button_url_left=\"/products\" title_right=\"Visit Starbelly and get your coffee*\" subtitle_right=\"For free!\" description_right=\"*Et modi itaque praesentium.\" image_right=\"illustrations/cup.png\" button_label_right=\"Get it now\" button_url_right=\"#\"][/promo]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(4,'Homepage 4','<div>[featured-categories category_ids=\"1,2,3,4\" style=\"2\"][/featured-categories]</div><div>[products-list title=\"Most popular dishes\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" type=\"feature\" style=\"slide\" items_per_row=\"3\" limit=\"6\" footer_style=\"add-to-cart\" button_label=\"View all\" button_url=\"#\" button_icon=\"general/arrow.png\"][/products-list]</div><div>[call-to-action title=\"-50% Discount for all* burgers!\" description=\"*Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image=\"illustrations/burger-2.png\" style_image=\"product\" button_primary_url=\"#\" button_primary_label=\"Get it now!\" button_primary_icon=\"general/cart.png\" button_secondary_url=\"#\" button_secondary_label=\"Menu\" button_secondary_icon=\"general/menu.png\"][/call-to-action]</div><div>[products-list title=\"Our Bestsellers\" subtitle=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" type=\"trending\" style=\"slide\" items_per_row=\"3\" limit=\"6\" footer_style=\"add-to-cart\" button_label=\"View all\" button_url=\"#\" button_icon=\"general/arrow.png\"][/products-list]</div><div>[team title=\"They will cook for you\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" team_ids=\"1,2,3\" button_label=\"More about us\" button_url=\"/about-us\" button_icon=\"general/arrow.png\"][/team]</div><div>[call-to-action title=\"Free delivery service.\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image=\"illustrations/delivery.png\" button_primary_url=\"#\" button_primary_label=\"Order delivery\" button_primary_icon=\"general/cart.png\" button_secondary_url=\"/shop-1\" button_secondary_label=\"Menu\" button_secondary_icon=\"general/menu.png\"][/call-to-action]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(5,'About Us','<div>[about-text image=\"blog/post-3.jpg\" experience_year=\"17\" experience_text=\"Years Experience\" title=\"We are doing more than you expect\" text=\"Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. <br><br> Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum.\" text_image=\"general/signature.png\"][/about-text]</div><div>[features title_1=\"We are located in the city center\" description_1=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_2=\"Fresh ingredients from organic farms\" description_2=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_3=\"Own fast delivery. 30 min Maximum\" description_3=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_4=\"Professional, experienced chefs\" description_4=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_5=\"The highest standards of service\" description_5=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\"][/features]</div><div>[video badge_text=&quot;Promo video&quot; title=&quot;Restaurant is like a theater. &lt;br&gt;Our task is to amaze you!&quot; description=&quot;Repellat, dolorem a. Qui ipsam quos, obcaecati mollitia consectetur ad vero minus neque sit architecto totam distineserunt pariatur adipisci rem aspernatur illum ex!&quot; video_thumbnail=&quot;illustrations/interior-2.jpg&quot; video_url=&quot;https://www.youtube.com/watch?v=F3zw1Gvn4Mk&quot; play_button_label=&quot;Promo video&quot;][/video]</div><div>[team title=\"They will cook for you\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" team_ids=\"1,2,3,4\" button_label=\"View Shop\" button_icon=\"general/menu.png\" button_url=\"/shop-2\"][/team]</div><div>[testimonials title=\"Reviews about us\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" limit=\"5\" button_url=\"reviews\" button_label=\"All reviews\" button_icon=\"general/dialog.png\"][/testimonials]</div><div>[call-to-action title=\"Free delivery service.\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image=\"illustrations/delivery.png\" button_primary_url=\"#\" button_primary_label=\"Order delivery\" button_primary_icon=\"general/cart.png\" button_secondary_url=\"#\" button_secondary_label=\"Menu\" button_secondary_icon=\"general/menu.png\"][/call-to-action]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(6,'About Us 2','<div>[about-text image=\"blog/post-3.jpg\" experience_year=\"17\" experience_text=\"Years Experience\" title=\"We are doing more than you expect\" text=\"Faudantium magnam error temporibus ipsam aliquid neque quibusdam dolorum, quia ea numquam assumenda mollitia dolorem impedit. Voluptate at quis exercitationem officia temporibus adipisci quae totam enim dolorum, assumenda. Sapiente soluta nostrum reprehenderit a velit obcaecati facilis vitae magnam tenetur neque vel itaque inventore eaque explicabo commodi maxime! Aliquam quasi, voluptates odio. Consectetur adipisicing elit. <br><br> Cupiditate nesciunt amet facilis numquam, nam adipisci qui voluptate voluptas enim obcaecati veritatis animi nulla, mollitia commodi quaerat ex, autem ea laborum.\" text_image=\"general/signature.png\"][/about-text]</div><div>[features title_1=\"We are located in the city center\" description_1=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_2=\"Fresh ingredients from organic farms\" description_2=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_3=\"Own fast delivery. 30 min Maximum\" description_3=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_4=\"Professional, experienced chefs\" description_4=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\" title_5=\"The highest standards of service\" description_5=\"Porro nemo veniam necessitatibus praesentium eligendi rem temporibus adipisci quo modi numquam.\"][/features]</div><div>[video badge_text=&quot;Promo video&quot; title=&quot;Restaurant is like a theater. &lt;br&gt;Our task is to amaze you!&quot; description=&quot;Repellat, dolorem a. Qui ipsam quos, obcaecati mollitia consectetur ad vero minus neque sit architecto totam distineserunt pariatur adipisci rem aspernatur illum ex!&quot; video_thumbnail=&quot;illustrations/interior-2.jpg&quot; video_url=&quot;https://www.youtube.com/watch?v=F3zw1Gvn4Mk&quot; play_button_label=&quot;Promo video&quot;][/video]</div><div>[team title=\"They will cook for you\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" team_ids=\"1,2,3,4\" limit=\"3\" button_label=\"View Shop\" button_icon=\"general/menu.png\" button_url=\"/shop-2\"][/team]</div><div>[testimonials title=\"Reviews about us\" description=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" limit=\"5\" button_url=\"#\" button_label=\"All reviews\" button_icon=\"general/dialog.png\"][/testimonials]</div><div>[apps-download title=\"Download our mobile app.\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" image=\"backgrounds/phones.png\" platform_button_image_1=\"platforms/android.png\" platform_url_1=\"#\" platform_button_image_2=\"platforms/ios.png\" platform_url_2=\"#\"][/apps-download]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(7,'Blog style 1','<div>[blog-posts style=\"2\" title=\"Latest publications\" description=\"Below is the latest news from us. We get regularly updated from reliable sources.\"][/blog-posts]</div><div>[blog-footer widget=\"blog-footer\"][/blog-footer]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(8,'Blog style 2','<div>[blog-posts style=\"3\" title=\"Latest publications\" description=\"Below is the latest news from us. We get regularly updated from reliable sources.\"][/blog-posts]</div><div>[blog-footer widget=\"blog-footer\"][/blog-footer]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(9,'Gallery 1','<div>[galleries-list per_page=\"8\" style=\"1\"][/galleries-list]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(10,'Gallery 2','<div>[galleries-list per_page=\"8\" style=\"2\"][/galleries-list]</div>',1,NULL,'default','','published','2023-07-02 19:58:38','2023-07-02 19:58:38'),(11,'Reviews','<div>[testimonials-list][/testimonials-list]</div><div>[apps-download title=\"Download our mobile app.\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" image=\"backgrounds/phones.png\" platform_button_image_1=\"platforms/android.png\" platform_url_1=\"#\" platform_button_image_2=\"platforms/ios.png\" platform_url_2=\"#\"][/apps-download]</div>',1,NULL,'default','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(12,'FAQs','<div>[faqs categories=\"1,2,3,4\"][/faqs]</div><div>[apps-download title=\"Download our mobile app.\" subtitle=\"Consecrate numeral port nemo venial diligent rem disciple quo mod.\" image=\"backgrounds/phones.png\" platform_button_image_1=\"platforms/android.png\" platform_url_1=\"#\" platform_button_image_2=\"platforms/ios.png\" platform_url_2=\"#\"][/apps-download]</div>',1,NULL,'default','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(13,'Shop list 1','<div>[products-list type=\"all\" style=\"static\" items_per_row=\"4\" per_page=\"16\" footer_style=\"rating\"][/products-list]</div><div>[promo title_left=\"-50%\" subtitle_left=\"Discount for all* burgers!\" description_left=\"*Et modi itaque praesentium.\" image_left=\"illustrations/burger.png\" button_label_left=\"Get it now\" button_url_left=\"/products\" title_right=\"Visit Starbelly and get your coffee*\" subtitle_right=\"For free!\" description_right=\"*Et modi itaque praesentium.\" image_right=\"illustrations/cup.png\" button_label_right=\"Get it now\" button_url_right=\"#\"][/promo]</div>',1,NULL,'default','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(14,'Shop list 2','<div>[products-list type=\"all\" style=\"static\" items_per_row=\"3\" per_page=\"15\" footer_style=\"add-to-cart\"][/products-list]</div><div>[call-to-action title=\"-50% Discount for all* burgers!\" description=\"*Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image=\"illustrations/burger-2.png\" style_image=\"product\" button_primary_url=\"#\" button_primary_label=\"Get it now!\" button_primary_icon=\"general/cart.png\" button_secondary_url=\"#\" button_secondary_label=\"Menu\" button_secondary_icon=\"general/menu.png\"][/call-to-action]</div>',1,NULL,'default','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(15,'Contact','<div>[contact-form title=\"Get in Touch with Starbelly\" subtitle=\"Consectetur numquam poro nemo veniam eligendi rem adipisci quo modi.\" image_primary=\"illustrations/envelope-1.png\" image_secondary=\"illustrations/envelope-2.png\"][/contact-form]</div><div>[contact-information title_1=\"Welcome\" description_1=\"Montréal, 1510 Rue Sauvé\" title_2=\"Call\" description_2=\"+02 (044) 756-X6-52\" title_3=\"Write\" description_3=\"starbelly@mail.com\"][/contact-information]</div><div>[google-map]Montréal, 1510 Rue Sauvé[/google-map]</div>',1,NULL,'homepage','','published','2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_translations`
--

DROP TABLE IF EXISTS `pages_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`pages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_translations`
--

LOCK TABLES `pages_translations` WRITE;
/*!40000 ALTER TABLE `pages_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `currency` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_channel` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'confirm',
  `customer_id` bigint unsigned DEFAULT NULL,
  `refunded_amount` decimal(15,2) unsigned DEFAULT NULL,
  `refund_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'USD',0,'JSOYGQSCCS','sslcommerz',NULL,71.00,1,'completed','confirm',5,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(2,'USD',0,'OZY5VRIS95','cod',NULL,425.00,2,'pending','confirm',1,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(3,'USD',0,'JHJYWR8IYL','sslcommerz',NULL,187.00,3,'completed','confirm',7,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(4,'USD',0,'GPHBEHKNQY','cod',NULL,211.00,4,'pending','confirm',1,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(5,'USD',0,'TDCGGDQZAN','bank_transfer',NULL,154.00,5,'pending','confirm',6,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(6,'USD',0,'MGRBN9H4YN','razorpay',NULL,164.00,6,'completed','confirm',5,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(7,'USD',0,'B8X3ZLYCIV','cod',NULL,113.00,7,'pending','confirm',2,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(8,'USD',0,'FIWMDRHMCZ','stripe',NULL,205.00,8,'completed','confirm',2,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(9,'USD',0,'ZOFLY1EMFX','sslcommerz',NULL,127.00,9,'completed','confirm',2,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(10,'USD',0,'QMT3UAM4RL','sslcommerz',NULL,186.00,10,'completed','confirm',2,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(11,'USD',0,'P0NBLOOKLB','stripe',NULL,359.00,11,'completed','confirm',4,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(12,'USD',0,'3DDBAQX12O','stripe',NULL,294.00,12,'completed','confirm',4,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(13,'USD',0,'P4OXGGNDLF','paystack',NULL,155.00,13,'completed','confirm',5,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(14,'USD',0,'RJKTLEYFC3','paystack',NULL,180.00,14,'completed','confirm',6,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(15,'USD',0,'4SPR1HSO0Z','sslcommerz',NULL,130.00,15,'completed','confirm',8,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(16,'USD',0,'91VIAG6DBN','paystack',NULL,106.00,16,'completed','confirm',5,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(17,'USD',0,'L2PDZIOSZ7','stripe',NULL,285.00,17,'completed','confirm',1,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(18,'USD',0,'OFG0GOYHI9','bank_transfer',NULL,253.00,18,'pending','confirm',8,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(19,'USD',0,'AX6VXRXAJL','sslcommerz',NULL,350.00,19,'completed','confirm',4,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL),(20,'USD',0,'6WGSCHWOW0','stripe',NULL,89.00,20,'completed','confirm',8,NULL,NULL,'2023-07-02 19:58:46','2023-07-02 19:58:46','Botble\\Ecommerce\\Models\\Customer',NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_categories` (
  `category_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  KEY `post_categories_category_id_index` (`category_id`),
  KEY `post_categories_post_id_index` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
INSERT INTO `post_categories` VALUES (1,1),(6,1),(4,2),(7,2),(2,3),(5,3),(2,4),(5,4),(3,5),(5,5),(1,6),(7,6),(1,7),(7,7),(4,8),(5,8),(4,9),(7,9),(3,10),(6,10),(2,11),(7,11),(4,12),(7,12),(1,13),(7,13),(2,14),(6,14),(1,15),(7,15),(4,16),(5,16);
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tags` (
  `tag_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  KEY `post_tags_tag_id_index` (`tag_id`),
  KEY `post_tags_post_id_index` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tags`
--

LOCK TABLES `post_tags` WRITE;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
INSERT INTO `post_tags` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(1,2),(2,2),(3,2),(4,2),(5,2),(1,3),(2,3),(3,3),(4,3),(5,3),(1,4),(2,4),(3,4),(4,4),(5,4),(1,5),(2,5),(3,5),(4,5),(5,5),(1,6),(2,6),(3,6),(4,6),(5,6),(1,7),(2,7),(3,7),(4,7),(5,7),(1,8),(2,8),(3,8),(4,8),(5,8),(1,9),(2,9),(3,9),(4,9),(5,9),(1,10),(2,10),(3,10),(4,10),(5,10),(1,11),(2,11),(3,11),(4,11),(5,11),(1,12),(2,12),(3,12),(4,12),(5,12),(1,13),(2,13),(3,13),(4,13),(5,13),(1,14),(2,14),(3,14),(4,14),(5,14),(1,15),(2,15),(3,15),(4,15),(5,15),(1,16),(2,16),(3,16),(4,16),(5,16);
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint unsigned NOT NULL,
  `author_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int unsigned NOT NULL DEFAULT '0',
  `format_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `author_id` (`author_id`),
  KEY `author_type` (`author_type`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'The Top 2020 Handbag Trends to Know','Soup! Who cares for fish, Game, or any other dish? Who would not open any of them. \'I\'m sure I\'m not looking for eggs, as it didn\'t sound at all the things get used up.\' \'But what did the archbishop.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',1,'blog/1.jpg',2645,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(2,'Top Search Engine Optimization Strategies!','She pitied him deeply. \'What is it?\' The Gryphon lifted up both its paws in surprise. \'What! Never heard of one,\' said Alice, (she had kept a piece of rudeness was more than three.\' \'Your hair wants.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',1,'blog/2.jpg',2799,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(3,'Which Company Would You Choose?','I can say.\' This was not a VERY unpleasant state of mind, she turned the corner, but the Rabbit asked. \'No, I give you fair warning,\' shouted the Gryphon, the squeaking of the Gryphon, and the small.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/3.jpg',314,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(4,'Used Car Dealer Sales Tricks Exposed','WOULD put their heads off?\' shouted the Queen ordering off her head!\' Those whom she sentenced were taken into custody by the hand, it hurried off, without waiting for turns, quarrelling all the.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',1,'blog/4.jpg',6551,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(5,'20 Ways To Sell Your Product Faster','For instance, suppose it doesn\'t matter a bit,\' said the Queen, pointing to the door, and tried to curtsey as she could. \'The game\'s going on shrinking rapidly: she soon made out that one of them.\'.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',1,'blog/5.jpg',3967,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(6,'The Secrets Of Rich And Famous Writers','The Mouse looked at her, and the sound of a feather flock together.\"\' \'Only mustard isn\'t a bird,\' Alice remarked. \'Oh, you can\'t swim, can you?\' he added, turning to the Dormouse, who seemed too.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/6.jpg',7131,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(7,'Imagine Losing 20 Pounds In 14 Days!','I wonder?\' As she said to herself; \'his eyes are so VERY remarkable in that; nor did Alice think it so VERY remarkable in that; nor did Alice think it was,\' he said. \'Fifteenth,\' said the Hatter.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',1,'blog/6.jpg',8646,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(8,'Are You Still Using That Slow, Old Typewriter?','However, \'jury-men\' would have called him Tortoise because he was obliged to have lessons to learn! No, I\'ve made up my mind about it; and the pair of the words \'DRINK ME,\' but nevertheless she.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/3.jpg',431,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(9,'A Skin Cream That’s Proven To Work','Magpie began wrapping itself up and down, and nobody spoke for some time without interrupting it. \'They were obliged to have him with them,\' the Mock Turtle, \'they--you\'ve seen them, of course?\'.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/5.jpg',9340,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(10,'10 Reasons To Start Your Own, Profitable Website!','Mabel! I\'ll try if I was, I shouldn\'t want YOURS: I don\'t take this young lady to see the Mock Turtle in a helpless sort of chance of getting up and walking away. \'You insult me by talking such.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',0,'blog/6.jpg',5165,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(11,'Simple Ways To Reduce Your Unwanted Wrinkles!','CHAPTER III. A Caucus-Race and a piece of bread-and-butter in the distance would take the roof was thatched with fur. It was as long as it went. So she set off at once: one old Magpie began wrapping.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',1,'blog/1.jpg',776,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(12,'Apple iMac with Retina 5K display review','ME.\' \'You!\' said the sage, as he could go. Alice took up the conversation dropped, and the King said, with a melancholy way, being quite unable to move. She soon got it out into the air, mixed up.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',1,'blog/3.jpg',5689,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(13,'10,000 Web Site Visitors In One Month:Guaranteed','WOULD twist itself round and round the court was in a sorrowful tone; \'at least there\'s no meaning in them, after all. I needn\'t be afraid of interrupting him,) \'I\'ll give him sixpence. _I_ don\'t.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/6.jpg',6787,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(14,'Unlock The Secrets Of Selling High Ticket Items','King, \'unless it was addressed to the conclusion that it was only a child!\' The Queen turned crimson with fury, and, after waiting till she had been to the beginning again?\' Alice ventured to.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',2,'Botble\\ACL\\Models\\User',0,'blog/5.jpg',7316,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(15,'4 Expert Tips On How To Choose The Right Men’s Wallet','PRECIOUS nose\'; as an unusually large saucepan flew close by her. There was exactly three inches high). \'But I\'m not particular as to size,\' Alice hastily replied; \'only one doesn\'t like changing so.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',0,'blog/3.jpg',1788,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39'),(16,'Sexy Clutches: How to Buy &amp; Wear a Designer Clutch Bag','Alice asked. \'We called him Tortoise because he was speaking, so that it might be some sense in your knocking,\' the Footman went on talking: \'Dear, dear! How queer everything is queer to-day.\' Just.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n','published',1,'Botble\\ACL\\Models\\User',1,'blog/2.jpg',9342,NULL,'2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_translations`
--

DROP TABLE IF EXISTS `posts_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posts_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`posts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_translations`
--

LOCK TABLES `posts_translations` WRITE;
/*!40000 ALTER TABLE `posts_translations` DISABLE KEYS */;
INSERT INTO `posts_translations` VALUES ('vi',1,'Xu hướng túi xách hàng đầu năm 2020 cần biết','Soup! Who cares for fish, Game, or any other dish? Who would not open any of them. \'I\'m sure I\'m not looking for eggs, as it didn\'t sound at all the things get used up.\' \'But what did the archbishop.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',2,'Các Chiến lược Tối ưu hóa Công cụ Tìm kiếm Hàng đầu!','She pitied him deeply. \'What is it?\' The Gryphon lifted up both its paws in surprise. \'What! Never heard of one,\' said Alice, (she had kept a piece of rudeness was more than three.\' \'Your hair wants.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',3,'Bạn sẽ chọn công ty nào?','I can say.\' This was not a VERY unpleasant state of mind, she turned the corner, but the Rabbit asked. \'No, I give you fair warning,\' shouted the Gryphon, the squeaking of the Gryphon, and the small.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',4,'Lộ ra các thủ đoạn bán hàng của đại lý ô tô đã qua sử dụng','WOULD put their heads off?\' shouted the Queen ordering off her head!\' Those whom she sentenced were taken into custody by the hand, it hurried off, without waiting for turns, quarrelling all the.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',5,'20 Cách Bán Sản phẩm Nhanh hơn','For instance, suppose it doesn\'t matter a bit,\' said the Queen, pointing to the door, and tried to curtsey as she could. \'The game\'s going on shrinking rapidly: she soon made out that one of them.\'.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',6,'Bí mật của những nhà văn giàu có và nổi tiếng','The Mouse looked at her, and the sound of a feather flock together.\"\' \'Only mustard isn\'t a bird,\' Alice remarked. \'Oh, you can\'t swim, can you?\' he added, turning to the Dormouse, who seemed too.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',7,'Hãy tưởng tượng bạn giảm 20 bảng Anh trong 14 ngày!','I wonder?\' As she said to herself; \'his eyes are so VERY remarkable in that; nor did Alice think it so VERY remarkable in that; nor did Alice think it was,\' he said. \'Fifteenth,\' said the Hatter.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',8,'Bạn vẫn đang sử dụng máy đánh chữ cũ, chậm đó?','However, \'jury-men\' would have called him Tortoise because he was obliged to have lessons to learn! No, I\'ve made up my mind about it; and the pair of the words \'DRINK ME,\' but nevertheless she.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',9,'Một loại kem dưỡng da đã được chứng minh hiệu quả','Magpie began wrapping itself up and down, and nobody spoke for some time without interrupting it. \'They were obliged to have him with them,\' the Mock Turtle, \'they--you\'ve seen them, of course?\'.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',10,'10 Lý do Để Bắt đầu Trang web Có Lợi nhuận của Riêng Bạn!','Mabel! I\'ll try if I was, I shouldn\'t want YOURS: I don\'t take this young lady to see the Mock Turtle in a helpless sort of chance of getting up and walking away. \'You insult me by talking such.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',11,'Những cách đơn giản để giảm nếp nhăn không mong muốn của bạn!','CHAPTER III. A Caucus-Race and a piece of bread-and-butter in the distance would take the roof was thatched with fur. It was as long as it went. So she set off at once: one old Magpie began wrapping.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',12,'Đánh giá Apple iMac với màn hình Retina 5K','ME.\' \'You!\' said the sage, as he could go. Alice took up the conversation dropped, and the King said, with a melancholy way, being quite unable to move. She soon got it out into the air, mixed up.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',13,'10.000 Khách truy cập Trang Web Trong Một Tháng: Được Đảm bảo','WOULD twist itself round and round the court was in a sorrowful tone; \'at least there\'s no meaning in them, after all. I needn\'t be afraid of interrupting him,) \'I\'ll give him sixpence. _I_ don\'t.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',14,'Mở khóa Bí mật Bán được vé Cao','King, \'unless it was addressed to the conclusion that it was only a child!\' The Queen turned crimson with fury, and, after waiting till she had been to the beginning again?\' Alice ventured to.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',15,'4 Lời khuyên của Chuyên gia về Cách Chọn Ví Nam Phù hợp','PRECIOUS nose\'; as an unusually large saucepan flew close by her. There was exactly three inches high). \'But I\'m not particular as to size,\' Alice hastily replied; \'only one doesn\'t like changing so.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n'),('vi',16,'Sexy Clutches: Cách Mua & Đeo Túi Clutch Thiết kế','Alice asked. \'We called him Tortoise because he was speaking, so that it might be some sense in your knocking,\' the Footman went on talking: \'Dear, dear! How queer everything is queer to-day.\' Just.','<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as considering recast to some crass until.</p><p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><hr class=\"wp-block-separator is-style-dots\">\n<p>Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness <a href=\"#\">nightingale</a> the instead exited expedient up far ouch mellifluous\n    altruistic and and lighted more instead much when ferret but the.</p>\n<figure class=\"wp-block-gallery columns-3 wp-block-image\">\n    <ul class=\"blocks-gallery-grid\">\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-2.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-3.jpg\">\n            </a>\n        </li>\n        <li class=\"blocks-gallery-item\">\n            <a href=\"#\">\n                <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-4.jpg\">\n            </a>\n        </li>\n    </ul>\n    <figcaption><i class=\"ti-credit-card mr-5\"></i>Image credit: Behance</figcaption>\n</figure>\n<hr>\n<p>Yet more some certainly yet alas abandonedly whispered <a href=\"#\">intriguingly</a><sup><a href=\"#\">[2]</a></sup>\n    well extensive one howled talkative admonishingly below a rethought overlaid dear gosh activated less <a href=\"#\">however</a>\n    hawk yet oh scratched ostrich some outside crud irrespective lightheartedly and much far amenably that the elephant\n    since when.</p>\n<h2>The Guitar Legends</h2>\n<p>Furrowed this in the upset <a href=\"#\">some across</a><sup><a href=\"#\">[3]</a></sup> tiger oh loaded house gosh\n    whispered <a href=\"#\">faltering alas</a><sup><a href=\"#\">[4]</a></sup> ouch cuckoo coward in scratched undid\n    together bit fumblingly so besides salamander heron during the jeepers hello fitting jauntily much smoothly\n    globefish darn blessedly far so along bluebird leopard and.</p>\n<blockquote>\n    <p>Integer eu faucibus <a href=\"#\">dolor</a><sup><a href=\"#\">[5]</a></sup>. Ut venenatis tincidunt diam elementum\n        imperdiet. Etiam accumsan semper nisl eu congue. Sed aliquam magna erat, ac eleifend lacus rhoncus in.</p>\n</blockquote>\n<p>Fretful human far recklessly while caterpillar well a well blubbered added one a some far whispered rampantly\n    whispered while irksome far clung irrespective wailed more rosily and where saluted while black dear so yikes as\n    considering recast to some crass until cow much less and rakishly overdrew consistent for by responsible oh one\n    hypocritical less bastard hey oversaw zebra browbeat a well.</p>\n<h3>Getting Crypto Rich</h3>\n<hr class=\"wp-block-separator is-style-wide\">\n<div class=\"wp-block-image\">\n    <figure class=\"alignleft is-resized\">\n        <img class=\"border-radius-5\" src=\"https://demos.alithemes.com/html/stories/demo/assets/imgs/news/thumb-11.jpg\">\n    </figure>\n</div>\n<p>And far contrary smoked some contrary among stealthy engagingly suspiciously a cockatoo far circa sank dully lewd\n    slick cracked llama the much gecko yikes more squirrel sniffed this and the the much within uninhibited this\n    abominable a blubbered overdid foresaw through alas the pessimistic.</p>\n<p>Gosh jaguar ostrich quail one excited dear hello and bound and the and bland moral misheard roadrunner flapped lynx\n    far that and jeepers giggled far and far bald that roadrunner python inside held shrewdly the manatee.</p>\n<br>\n<hr>\n<p>\n    Thanks sniffed in hello after in foolhardy and some far purposefully much one at the much conjointly leapt skimpily\n    that quail sheep some goodness nightingale the instead exited expedient up far ouch mellifluous altruistic and and\n    lighted more instead much when ferret but the.\n</p>\n<p>Yet more some certainly yet alas abandonedly whispered intriguingly well extensive one howled talkative admonishingly\n    below a rethought overlaid dear gosh activated less however hawk yet oh scratched ostrich some outside crud\n    irrespective lightheartedly and much far amenably that the elephant since when.</p>\n');
/*!40000 ALTER TABLE `posts_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisions`
--

LOCK TABLES `revisions` WRITE;
/*!40000 ALTER TABLE `revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_users`
--

DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_users` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_users_user_id_index` (`user_id`),
  KEY `role_users_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_users`
--

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
INSERT INTO `role_users` VALUES (2,1,'2023-07-02 19:58:38','2023-07-02 19:58:38');
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `created_by` bigint unsigned NOT NULL,
  `updated_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`),
  KEY `roles_created_by_index` (`created_by`),
  KEY `roles_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Admin','{\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true,\"core.system\":true,\"core.manage.license\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"settings.options\":true,\"settings.email\":true,\"settings.media\":true,\"settings.cronjob\":true,\"api.settings\":true,\"menus.index\":true,\"menus.create\":true,\"menus.edit\":true,\"menus.destroy\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"plugins.index\":true,\"plugins.edit\":true,\"plugins.remove\":true,\"plugins.marketplace\":true,\"core.appearance\":true,\"theme.index\":true,\"theme.activate\":true,\"theme.remove\":true,\"theme.options\":true,\"theme.custom-css\":true,\"theme.custom-js\":true,\"theme.custom-html\":true,\"widgets.index\":true,\"analytics.general\":true,\"analytics.page\":true,\"analytics.browser\":true,\"analytics.referrer\":true,\"audit-log.index\":true,\"audit-log.destroy\":true,\"backups.index\":true,\"backups.create\":true,\"backups.restore\":true,\"backups.destroy\":true,\"plugins.blog\":true,\"posts.index\":true,\"posts.create\":true,\"posts.edit\":true,\"posts.destroy\":true,\"categories.index\":true,\"categories.create\":true,\"categories.edit\":true,\"categories.destroy\":true,\"tags.index\":true,\"tags.create\":true,\"tags.edit\":true,\"tags.destroy\":true,\"contacts.index\":true,\"contacts.edit\":true,\"contacts.destroy\":true,\"plugins.ecommerce\":true,\"ecommerce.settings\":true,\"ecommerce.report.index\":true,\"products.index\":true,\"products.create\":true,\"products.edit\":true,\"products.destroy\":true,\"product-categories.index\":true,\"product-categories.create\":true,\"product-categories.edit\":true,\"product-categories.destroy\":true,\"product-tag.index\":true,\"product-tag.create\":true,\"product-tag.edit\":true,\"product-tag.destroy\":true,\"brands.index\":true,\"brands.create\":true,\"brands.edit\":true,\"brands.destroy\":true,\"product-collections.index\":true,\"product-collections.create\":true,\"product-collections.edit\":true,\"product-collections.destroy\":true,\"product-attribute-sets.index\":true,\"product-attribute-sets.create\":true,\"product-attribute-sets.edit\":true,\"product-attribute-sets.destroy\":true,\"product-attributes.index\":true,\"product-attributes.create\":true,\"product-attributes.edit\":true,\"product-attributes.destroy\":true,\"tax.index\":true,\"tax.create\":true,\"tax.edit\":true,\"tax.destroy\":true,\"reviews.index\":true,\"reviews.destroy\":true,\"shipping_methods.index\":true,\"ecommerce.shipping-rule-items.index\":true,\"ecommerce.shipping-rule-items.create\":true,\"ecommerce.shipping-rule-items.edit\":true,\"ecommerce.shipping-rule-items.destroy\":true,\"ecommerce.shipping-rule-items.bulk-import\":true,\"ecommerce.shipments.index\":true,\"ecommerce.shipments.create\":true,\"ecommerce.shipments.edit\":true,\"ecommerce.shipments.destroy\":true,\"orders.index\":true,\"orders.create\":true,\"orders.edit\":true,\"orders.destroy\":true,\"discounts.index\":true,\"discounts.create\":true,\"discounts.edit\":true,\"discounts.destroy\":true,\"customers.index\":true,\"customers.create\":true,\"customers.edit\":true,\"customers.destroy\":true,\"flash-sale.index\":true,\"flash-sale.create\":true,\"flash-sale.edit\":true,\"flash-sale.destroy\":true,\"product-label.index\":true,\"product-label.create\":true,\"product-label.edit\":true,\"product-label.destroy\":true,\"ecommerce.import.products.index\":true,\"ecommerce.export.products.index\":true,\"order_returns.index\":true,\"order_returns.edit\":true,\"order_returns.destroy\":true,\"global-option.index\":true,\"global-option.create\":true,\"global-option.edit\":true,\"global-option.destroy\":true,\"ecommerce.invoice.index\":true,\"ecommerce.invoice.edit\":true,\"ecommerce.invoice.destroy\":true,\"ecommerce.invoice-template.index\":true,\"plugin.faq\":true,\"faq.index\":true,\"faq.create\":true,\"faq.edit\":true,\"faq.destroy\":true,\"faq_category.index\":true,\"faq_category.create\":true,\"faq_category.edit\":true,\"faq_category.destroy\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"languages.index\":true,\"languages.create\":true,\"languages.edit\":true,\"languages.destroy\":true,\"plugin.location\":true,\"country.index\":true,\"country.create\":true,\"country.edit\":true,\"country.destroy\":true,\"state.index\":true,\"state.create\":true,\"state.edit\":true,\"state.destroy\":true,\"city.index\":true,\"city.create\":true,\"city.edit\":true,\"city.destroy\":true,\"location.bulk-import.index\":true,\"location.export.index\":true,\"newsletter.index\":true,\"newsletter.destroy\":true,\"payment.index\":true,\"payments.settings\":true,\"payment.destroy\":true,\"social-login.settings\":true,\"team.index\":true,\"team.create\":true,\"team.edit\":true,\"team.destroy\":true,\"testimonial.index\":true,\"testimonial.create\":true,\"testimonial.edit\":true,\"testimonial.destroy\":true,\"plugins.translation\":true,\"translations.locales\":true,\"translations.theme-translations\":true,\"translations.index\":true}','Admin users role',1,1,1,'2023-07-02 19:58:38','2023-07-02 19:58:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'activated_plugins','[\"language\",\"language-advanced\",\"analytics\",\"audit-log\",\"backup\",\"blog\",\"captcha\",\"contact\",\"cookie-consent\",\"ecommerce\",\"faq\",\"gallery\",\"location\",\"newsletter\",\"payment\",\"paypal\",\"paystack\",\"razorpay\",\"rss-feed\",\"shippo\",\"social-login\",\"sslcommerz\",\"stripe\",\"team\",\"testimonial\",\"translation\"]',NULL,'2023-07-02 19:58:38'),(2,'payment_cod_status','1',NULL,'2023-07-02 19:58:38'),(3,'payment_bank_transfer_status','1',NULL,'2023-07-02 19:58:38'),(5,'api_enabled','0',NULL,'2023-07-02 19:58:38'),(6,'show_admin_bar','1',NULL,'2023-07-02 19:58:38'),(8,'language_hide_default','1',NULL,NULL),(9,'language_switcher_display','list',NULL,NULL),(10,'language_display','all',NULL,NULL),(11,'language_hide_languages','[]',NULL,NULL),(12,'theme','starbelly',NULL,NULL),(13,'admin_favicon','general/favicon.png',NULL,NULL),(14,'admin_logo','general/logo-light.png',NULL,NULL),(15,'theme-starbelly-site_title','StarBelly - Restaurant & Cafe Laravel Script',NULL,NULL),(16,'theme-starbelly-seo_description','StarBelly is a Restaurant & Cafe Laravel Script. It is a powerful, clean, modern, and fully responsive template. It is designed for agency, business, corporate, creative, freelancer, portfolio, photography, personal, resume, and any kind of creative fields.',NULL,NULL),(17,'theme-starbelly-copyright','© 2023 Archi Elite JSC. All Rights Reserved.',NULL,NULL),(18,'theme-starbelly-homepage_id','1',NULL,NULL),(19,'theme-starbelly-blog_page_id','3',NULL,NULL),(20,'theme-starbelly-favicon','general/favicon.png',NULL,NULL),(21,'theme-starbelly-logo','general/logo.png',NULL,NULL),(22,'theme-starbelly-seo_og_image','general/open-graph-image.png',NULL,NULL),(23,'theme-starbelly-action_button_text','Contact Us',NULL,NULL),(24,'theme-starbelly-action_button_url','/contact',NULL,NULL),(25,'theme-starbelly-cookie_consent_message','Your experience on this site will be improved by allowing cookies ',NULL,NULL),(26,'theme-starbelly-cookie_consent_learn_more_url','/cookie-policy',NULL,NULL),(27,'theme-starbelly-cookie_consent_learn_more_text','Cookie Policy',NULL,NULL),(28,'theme-starbelly-cookie_consent_learn_abc_more_text','ABC',NULL,NULL),(29,'theme-starbelly-background_post_single','general/bg-post.png',NULL,NULL),(30,'theme-starbelly-address','66 avenue des Champs, 75008, Paris, France',NULL,NULL),(31,'theme-starbelly-hotline','(+01) - 456 789',NULL,NULL),(32,'theme-starbelly-email','contact@agon.com',NULL,NULL),(33,'theme-starbelly-login_page_image','general/login.png',NULL,NULL),(34,'theme-starbelly-register_page_images','[\"general\\/register-1.png\",\"general\\/register-2.png\",\"general\\/register-3.png\",\"general\\/register-4.png\",\"general\\/register-5.png\"]',NULL,NULL),(35,'theme-starbelly-primary_color','#F5C332',NULL,NULL),(36,'theme-starbelly-secondary_color','#8D99AE',NULL,NULL),(37,'theme-starbelly-danger_color','#EF476F',NULL,NULL),(38,'theme-starbelly-primary_font','Rubik',NULL,NULL),(39,'theme-starbelly-top_bar_color','#F5C332',NULL,NULL),(40,'theme-starbelly-gallery_page_style','1',NULL,NULL),(41,'theme-starbelly-gallery_page_detail_style','1',NULL,NULL),(42,'theme-starbelly-gallery_page_title','It’s a pity that the photo does not convey the taste!',NULL,NULL),(43,'theme-starbelly-gallery_page_description','Consecrate numeral port nemo intelligentsia rem disciple quo mod.',NULL,NULL),(44,'theme-starbelly-gallery_breadcrumb_title','It’s a pity that the photo does not convey the taste!',NULL,NULL),(45,'theme-starbelly-gallery_breadcrumb_subtitle','Consecrate numeral port nemo venial diligent rem disciple quo mod.',NULL,NULL),(46,'theme-starbelly-background_image_page_404','illustrations/man.png',NULL,NULL),(47,'theme-starbelly-max_filter_price','1000',NULL,NULL),(48,'theme-starbelly-background_breadcrumb_default','backgrounds/breadcrumb-default.jpg',NULL,NULL),(49,'theme-starbelly-social_links','[[{\"key\":\"social-name\",\"value\":\"Facebook\"},{\"key\":\"social-icon\",\"value\":\"fab fa-facebook-f\"},{\"key\":\"social-url\",\"value\":\"https:\\/\\/www.facebook.com\\/\"}],[{\"key\":\"social-name\",\"value\":\"Twitter\"},{\"key\":\"social-icon\",\"value\":\"fab fa-twitter\"},{\"key\":\"social-url\",\"value\":\"https:\\/\\/www.twitter.com\\/\"}],[{\"key\":\"social-name\",\"value\":\"Instagram\"},{\"key\":\"social-icon\",\"value\":\"fab fa-instagram\"},{\"key\":\"social-url\",\"value\":\"https:\\/\\/www.instagram.com\\/\"}],[{\"key\":\"social-name\",\"value\":\"Youtube\"},{\"key\":\"social-icon\",\"value\":\"fab fa-youtube\"},{\"key\":\"social-url\",\"value\":\"https:\\/\\/www.youtube.com\\/\"}]]',NULL,NULL),(50,'media_random_hash','3cb6e0c28280ab3352afe232abe9b935',NULL,NULL),(51,'ecommerce_store_name','Starbelly',NULL,NULL),(52,'ecommerce_store_phone','1800979769',NULL,NULL),(53,'ecommerce_store_address','502 New Street',NULL,NULL),(54,'ecommerce_store_state','Brighton VIC',NULL,NULL),(55,'ecommerce_store_city','Brighton VIC',NULL,NULL),(56,'ecommerce_store_country','AU',NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slugs`
--

DROP TABLE IF EXISTS `slugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slugs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slugs_reference_id_index` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slugs`
--

LOCK TABLES `slugs` WRITE;
/*!40000 ALTER TABLE `slugs` DISABLE KEYS */;
INSERT INTO `slugs` VALUES (1,'homepage-1',1,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(2,'homepage-2',2,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(3,'homepage-3',3,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(4,'homepage-4',4,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(5,'about-us',5,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(6,'about-us-2',6,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(7,'blog',7,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(8,'blog-2',8,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(9,'gallery-1',9,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:38','2023-07-02 19:58:38'),(10,'gallery-2',10,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(11,'reviews',11,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(12,'faqs',12,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(13,'shop-list-1',13,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(14,'shop-list-2',14,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(15,'contact',15,'Botble\\Page\\Models\\Page','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(16,'design',1,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(17,'lifestyle',2,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(18,'travel-tips',3,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(19,'healthy',4,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(20,'travel-tips',5,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(21,'hotel',6,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(22,'nature',7,'Botble\\Blog\\Models\\Category','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(23,'general',1,'Botble\\Blog\\Models\\Tag','tag','2023-07-02 19:58:39','2023-07-02 19:58:39'),(24,'design',2,'Botble\\Blog\\Models\\Tag','tag','2023-07-02 19:58:39','2023-07-02 19:58:39'),(25,'fashion',3,'Botble\\Blog\\Models\\Tag','tag','2023-07-02 19:58:39','2023-07-02 19:58:39'),(26,'branding',4,'Botble\\Blog\\Models\\Tag','tag','2023-07-02 19:58:39','2023-07-02 19:58:39'),(27,'modern',5,'Botble\\Blog\\Models\\Tag','tag','2023-07-02 19:58:39','2023-07-02 19:58:39'),(28,'the-top-2020-handbag-trends-to-know',1,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(29,'top-search-engine-optimization-strategies',2,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(30,'which-company-would-you-choose',3,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(31,'used-car-dealer-sales-tricks-exposed',4,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(32,'20-ways-to-sell-your-product-faster',5,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(33,'the-secrets-of-rich-and-famous-writers',6,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(34,'imagine-losing-20-pounds-in-14-days',7,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(35,'are-you-still-using-that-slow-old-typewriter',8,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(36,'a-skin-cream-thats-proven-to-work',9,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(37,'10-reasons-to-start-your-own-profitable-website',10,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(38,'simple-ways-to-reduce-your-unwanted-wrinkles',11,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(39,'apple-imac-with-retina-5k-display-review',12,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(40,'10000-web-site-visitors-in-one-monthguaranteed',13,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(41,'unlock-the-secrets-of-selling-high-ticket-items',14,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(42,'4-expert-tips-on-how-to-choose-the-right-mens-wallet',15,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(43,'sexy-clutches-how-to-buy-wear-a-designer-clutch-bag',16,'Botble\\Blog\\Models\\Post','','2023-07-02 19:58:39','2023-07-02 19:58:39'),(44,'nestle',1,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(45,'pepsi',2,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(46,'mcdonalds',3,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(47,'burger-king',4,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(48,'kfc',5,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(49,'starbucks',6,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(50,'popeyes',7,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(51,'phuc-long',8,'Botble\\Ecommerce\\Models\\Brand','brands','2023-07-02 19:58:41','2023-07-02 19:58:41'),(52,'starters',1,'Botble\\Ecommerce\\Models\\ProductCategory','product-categories','2023-07-02 19:58:41','2023-07-02 19:58:41'),(53,'main-dishes',2,'Botble\\Ecommerce\\Models\\ProductCategory','product-categories','2023-07-02 19:58:41','2023-07-02 19:58:41'),(54,'drinks',3,'Botble\\Ecommerce\\Models\\ProductCategory','product-categories','2023-07-02 19:58:41','2023-07-02 19:58:41'),(55,'desserts',4,'Botble\\Ecommerce\\Models\\ProductCategory','product-categories','2023-07-02 19:58:41','2023-07-02 19:58:41'),(56,'chevre-au-mill',1,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(57,'salmon-grav-lax',2,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(58,'straitlaced',3,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(59,'carpaccio-de-degrade',4,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(60,'spring-roll',5,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(61,'fish-soup',6,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(62,'fried-beef',7,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(63,'boiled-vegetables',8,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(64,'omelet',9,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(65,'stuffed-pancake',10,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(66,'spicy-beef-noodle-soup',11,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(67,'pancake',12,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(68,'onion-pickle',13,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(69,'ice-cream',14,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(70,'salad',15,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(71,'spaghetti',16,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(72,'duck-meat',17,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(73,'shrimp',18,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(74,'turkey-meat',19,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(75,'peppercorn-and-leek-parcels',20,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(76,'lamb-and-gruyere-salad',21,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(77,'venison-and-aubergine-kebab',22,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(78,'dulse-and-tumeric-salad',23,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(79,'pork-and-broccoli-soup',24,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(80,'chickpea-and-chilli-pasta',25,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(81,'anise-and-coconut-curry',26,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(82,'rice-and-sesame-pancake',27,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(83,'cabbage-and-rosemary-parcels',28,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(84,'nutmeg-and-cinnamon-loaf',29,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(85,'leek-and-mushroom-pie',30,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(86,'banh-mi',31,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(87,'pho-bo',32,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(88,'bun-dau-mam-tom',33,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(89,'onion-sandwich-with-chilli-relish',34,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(90,'spinach-and-aubergine-bread',35,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(91,'banana-and-squash-madras',36,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(92,'apple-and-semolina-cake',37,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(93,'apple-and-semolina-cake',38,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(94,'raisin-and-fennel-yoghurt',39,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(95,'chilli-and-egg-penne',40,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(96,'basil-and-chestnut-soup',41,'Botble\\Ecommerce\\Models\\Product','products','2023-07-02 19:58:44','2023-07-02 19:58:44'),(97,'dinner',1,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(98,'delicious',2,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(99,'breakfast',3,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(100,'chocolate',4,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(101,'vegan',5,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(102,'sweet',6,'Botble\\Ecommerce\\Models\\ProductTag','product-tags','2023-07-02 19:58:46','2023-07-02 19:58:46'),(103,'perfect',1,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(104,'new-day',2,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(105,'happy-day',3,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(106,'nature',4,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(107,'morning',5,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(108,'photography',6,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(109,'summer',7,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(110,'holiday',8,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(111,'winter',9,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47'),(112,'warm',10,'Botble\\Gallery\\Models\\Gallery','galleries','2023-07-02 19:58:47','2023-07-02 19:58:47');
/*!40000 ALTER TABLE `slugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states_translations`
--

DROP TABLE IF EXISTS `states_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `states_id` bigint unsigned NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`states_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states_translations`
--

LOCK TABLES `states_translations` WRITE;
/*!40000 ALTER TABLE `states_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `states_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint unsigned NOT NULL,
  `author_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'General',1,'Botble\\ACL\\Models\\User','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(2,'Design',1,'Botble\\ACL\\Models\\User','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(3,'Fashion',1,'Botble\\ACL\\Models\\User','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(4,'Branding',1,'Botble\\ACL\\Models\\User','','published','2023-07-02 19:58:39','2023-07-02 19:58:39'),(5,'Modern',1,'Botble\\ACL\\Models\\User','','published','2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags_translations`
--

DROP TABLE IF EXISTS `tags_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags_translations`
--

LOCK TABLES `tags_translations` WRITE;
/*!40000 ALTER TABLE `tags_translations` DISABLE KEYS */;
INSERT INTO `tags_translations` VALUES ('vi',1,NULL,NULL),('vi',2,NULL,NULL),('vi',3,NULL,NULL),('vi',4,NULL,NULL),('vi',5,NULL,NULL);
/*!40000 ALTER TABLE `tags_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socials` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'Paul Trueman','teams/1.png','Chef','USA','{\"facebook\":\"fb.com\",\"twitter\":\"twitter.com\",\"instagram\":\"instagram.com\"}','published','2023-07-02 19:58:48','2023-07-02 19:58:48'),(2,'Emma Newman','teams/2.png','Assistant chef','Qatar','{\"facebook\":\"fb.com\",\"twitter\":\"twitter.com\",\"instagram\":\"instagram.com\"}','published','2023-07-02 19:58:48','2023-07-02 19:58:48'),(3,'Oscar Oldman','teams/3.png','Chef','India','{\"facebook\":\"fb.com\",\"twitter\":\"twitter.com\",\"instagram\":\"instagram.com\"}','published','2023-07-02 19:58:48','2023-07-02 19:58:48'),(4,'Ed Freeman','teams/4.png','Assistant chef','China','{\"facebook\":\"fb.com\",\"twitter\":\"twitter.com\",\"instagram\":\"instagram.com\"}','published','2023-07-02 19:58:48','2023-07-02 19:58:48');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams_translations`
--

DROP TABLE IF EXISTS `teams_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teams_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`teams_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams_translations`
--

LOCK TABLES `teams_translations` WRITE;
/*!40000 ALTER TABLE `teams_translations` DISABLE KEYS */;
INSERT INTO `teams_translations` VALUES ('vi',1,'Paul Trueman','Đầu bếp','Mỹ'),('vi',2,'Emma Newman','Phụ bếp','Qatar'),('vi',3,'Oscar Oldman','Đầu bếp','Ấn độ'),('vi',4,'Ed Freeman','Phụ bếp','Trung Quốc');
/*!40000 ALTER TABLE `teams_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Wade Warren','Ratione maiores quod et est nemo voluptas. Voluptate quasi amet incidunt voluptate. Et recusandae quod ab optio. Ea animi ea facilis modi sit. Sint beatae in facere occaecati ipsum. Et eligendi iure ut est quis ex et fuga. Molestiae aliquam quia quia dolores aut cumque. Id commodi molestias sed numquam et omnis aliquam.','customers/1.jpg','Louis Vuitton','published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(2,'Brooklyn Simmons','Consequatur aliquid sequi sint sequi quasi. Eius at officiis perspiciatis illum voluptatem. Ut asperiores vel doloremque facilis. Deleniti quos voluptas consectetur voluptas. Impedit quo molestias aperiam ea tempora voluptatem ipsum et. Qui et commodi facere eum ex. Ipsum quod aut rem nesciunt vitae.','customers/2.jpg','Nintendo','published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(3,'Jenny Wilson','Ut quo ad ea aut voluptatem eum magnam. Dolorem delectus quia occaecati nemo odio dolores enim. Deserunt natus numquam architecto ducimus in quam. Odit ut sunt aliquid et et neque ut.','customers/3.jpg','Starbucks','published','2023-07-02 19:58:41','2023-07-02 19:58:41'),(4,'Albert Flores','Culpa cumque et eligendi inventore qui aut sapiente. Quo nihil nobis tempore in ipsa hic natus. Voluptatem autem cupiditate quis quo. Consequatur ea ut alias quo veritatis. Aliquid deleniti earum eos veritatis iste occaecati. Ut ipsum cumque illum necessitatibus accusamus atque. Nobis nesciunt culpa qui sit porro aliquam.','customers/4.jpg','Bank of America','published','2023-07-02 19:58:41','2023-07-02 19:58:41');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials_translations`
--

DROP TABLE IF EXISTS `testimonials_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `testimonials_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `company` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`testimonials_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials_translations`
--

LOCK TABLES `testimonials_translations` WRITE;
/*!40000 ALTER TABLE `testimonials_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonials_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` int NOT NULL DEFAULT '0',
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3207 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_meta`
--

DROP TABLE IF EXISTS `user_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_meta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_meta_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_meta`
--

LOCK TABLES `user_meta` WRITE;
/*!40000 ALTER TABLE `user_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_id` bigint unsigned DEFAULT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `manage_supers` tinyint(1) NOT NULL DEFAULT '0',
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@archielite.com',NULL,'$2y$10$NH8PobVRl8N7daTuB8cHKea5TeXNbaXzsTCBGAU6YYF4Hjb3ZD4C.',NULL,'2023-07-02 19:58:38','2023-07-02 19:58:38','Super','Admin','admin',NULL,1,1,NULL,NULL),(2,'user@archielite.com',NULL,'$2y$10$SfrLz57D9ndTh0FlXgW38.NOlac0MrmzJBzvYclCpsXx6jygHmQiK',NULL,'2023-07-02 19:58:38','2023-07-02 19:58:38','Normal','Admin','user',NULL,0,0,'{\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true,\"core.system\":true,\"core.manage.license\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"settings.options\":true,\"settings.email\":true,\"settings.media\":true,\"settings.cronjob\":true,\"api.settings\":true,\"menus.index\":true,\"menus.create\":true,\"menus.edit\":true,\"menus.destroy\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"plugins.index\":true,\"plugins.edit\":true,\"plugins.remove\":true,\"plugins.marketplace\":true,\"core.appearance\":true,\"theme.index\":true,\"theme.activate\":true,\"theme.remove\":true,\"theme.options\":true,\"theme.custom-css\":true,\"theme.custom-js\":true,\"theme.custom-html\":true,\"widgets.index\":true,\"analytics.general\":true,\"analytics.page\":true,\"analytics.browser\":true,\"analytics.referrer\":true,\"audit-log.index\":true,\"audit-log.destroy\":true,\"backups.index\":true,\"backups.create\":true,\"backups.restore\":true,\"backups.destroy\":true,\"plugins.blog\":true,\"posts.index\":true,\"posts.create\":true,\"posts.edit\":true,\"posts.destroy\":true,\"categories.index\":true,\"categories.create\":true,\"categories.edit\":true,\"categories.destroy\":true,\"tags.index\":true,\"tags.create\":true,\"tags.edit\":true,\"tags.destroy\":true,\"contacts.index\":true,\"contacts.edit\":true,\"contacts.destroy\":true,\"plugins.ecommerce\":true,\"ecommerce.settings\":true,\"ecommerce.report.index\":true,\"products.index\":true,\"products.create\":true,\"products.edit\":true,\"products.destroy\":true,\"product-categories.index\":true,\"product-categories.create\":true,\"product-categories.edit\":true,\"product-categories.destroy\":true,\"product-tag.index\":true,\"product-tag.create\":true,\"product-tag.edit\":true,\"product-tag.destroy\":true,\"brands.index\":true,\"brands.create\":true,\"brands.edit\":true,\"brands.destroy\":true,\"product-collections.index\":true,\"product-collections.create\":true,\"product-collections.edit\":true,\"product-collections.destroy\":true,\"product-attribute-sets.index\":true,\"product-attribute-sets.create\":true,\"product-attribute-sets.edit\":true,\"product-attribute-sets.destroy\":true,\"product-attributes.index\":true,\"product-attributes.create\":true,\"product-attributes.edit\":true,\"product-attributes.destroy\":true,\"tax.index\":true,\"tax.create\":true,\"tax.edit\":true,\"tax.destroy\":true,\"reviews.index\":true,\"reviews.destroy\":true,\"shipping_methods.index\":true,\"ecommerce.shipping-rule-items.index\":true,\"ecommerce.shipping-rule-items.create\":true,\"ecommerce.shipping-rule-items.edit\":true,\"ecommerce.shipping-rule-items.destroy\":true,\"ecommerce.shipping-rule-items.bulk-import\":true,\"ecommerce.shipments.index\":true,\"ecommerce.shipments.create\":true,\"ecommerce.shipments.edit\":true,\"ecommerce.shipments.destroy\":true,\"orders.index\":true,\"orders.create\":true,\"orders.edit\":true,\"orders.destroy\":true,\"discounts.index\":true,\"discounts.create\":true,\"discounts.edit\":true,\"discounts.destroy\":true,\"customers.index\":true,\"customers.create\":true,\"customers.edit\":true,\"customers.destroy\":true,\"flash-sale.index\":true,\"flash-sale.create\":true,\"flash-sale.edit\":true,\"flash-sale.destroy\":true,\"product-label.index\":true,\"product-label.create\":true,\"product-label.edit\":true,\"product-label.destroy\":true,\"ecommerce.import.products.index\":true,\"ecommerce.export.products.index\":true,\"order_returns.index\":true,\"order_returns.edit\":true,\"order_returns.destroy\":true,\"global-option.index\":true,\"global-option.create\":true,\"global-option.edit\":true,\"global-option.destroy\":true,\"ecommerce.invoice.index\":true,\"ecommerce.invoice.edit\":true,\"ecommerce.invoice.destroy\":true,\"ecommerce.invoice-template.index\":true,\"plugin.faq\":true,\"faq.index\":true,\"faq.create\":true,\"faq.edit\":true,\"faq.destroy\":true,\"faq_category.index\":true,\"faq_category.create\":true,\"faq_category.edit\":true,\"faq_category.destroy\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"languages.index\":true,\"languages.create\":true,\"languages.edit\":true,\"languages.destroy\":true,\"plugin.location\":true,\"country.index\":true,\"country.create\":true,\"country.edit\":true,\"country.destroy\":true,\"state.index\":true,\"state.create\":true,\"state.edit\":true,\"state.destroy\":true,\"city.index\":true,\"city.create\":true,\"city.edit\":true,\"city.destroy\":true,\"location.bulk-import.index\":true,\"location.export.index\":true,\"newsletter.index\":true,\"newsletter.destroy\":true,\"payment.index\":true,\"payments.settings\":true,\"payment.destroy\":true,\"social-login.settings\":true,\"team.index\":true,\"team.create\":true,\"team.edit\":true,\"team.destroy\":true,\"testimonial.index\":true,\"testimonial.create\":true,\"testimonial.edit\":true,\"testimonial.destroy\":true,\"plugins.translation\":true,\"translations.locales\":true,\"translations.theme-translations\":true,\"translations.index\":true}',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `widget_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint unsigned NOT NULL DEFAULT '0',
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets`
--

LOCK TABLES `widgets` WRITE;
/*!40000 ALTER TABLE `widgets` DISABLE KEYS */;
INSERT INTO `widgets` VALUES (1,'ContactInformation','information-sidebar','starbelly',1,'{\"id\":\"ContactInformation\",\"title\":\"Contact Information\",\"phone\":\"0123456789\",\"email\":\"contact@archielite.com\",\"address\":\"Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678.\",\"working_hours_start\":\"08:00\",\"working_hours_end\":\"17:00\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(2,'ContactInformation','information-sidebar','starbelly-vi',1,'{\"id\":\"ContactInformation\",\"title\":\"Contact Information\",\"phone\":\"0123456789\",\"email\":\"contact@archielite.com\",\"address\":\"Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678.\",\"working_hours_start\":\"08:00\",\"working_hours_end\":\"17:00\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(3,'GalleryWidget','information-sidebar','starbelly',2,'{\"id\":\"GalleryWidget\",\"title_gallery\":\"Instagram\",\"number_image\":6}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(4,'GalleryWidget','information-sidebar','starbelly-vi',2,'{\"id\":\"GalleryWidget\",\"title_gallery\":\"Instagram\",\"number_image\":6}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(5,'BlogPostsWidget','information-sidebar','starbelly',3,'{\"id\":\"BlogPostsWidget\",\"title\":\"Latest publications\",\"limit\":3,\"style\":\"in-sidebar\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(6,'BlogPostsWidget','information-sidebar','starbelly-vi',3,'{\"id\":\"BlogPostsWidget\",\"title\":\"Latest publications\",\"limit\":3,\"style\":\"in-sidebar\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(7,'BlogPostsWidget','blog-footer','starbelly',1,'{\"id\":\"BlogPostsWidget\",\"title\":\"Most popular Publication\",\"description\":\"From Our blog and Event Fanpage\",\"limit\":5}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(8,'BlogPostsWidget','blog-footer','starbelly-vi',1,'{\"id\":\"BlogPostsWidget\",\"title\":\"Most popular Publication\",\"description\":\"From Our blog and Event Fanpage\",\"limit\":5}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(9,'BlogSearchWidget','blog-sidebar','starbelly',1,'{\"name\":\"Search\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(10,'BlogSearchWidget','blog-sidebar','starbelly-vi',1,'{\"name\":\"Search\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(11,'BlogCategoriesWidget','blog-sidebar','starbelly',2,'{\"name\":\"Categories\",\"limit\":5}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(12,'BlogCategoriesWidget','blog-sidebar','starbelly-vi',2,'{\"name\":\"Categories\",\"limit\":5}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(13,'BlogTagsWidget','blog-sidebar','starbelly',3,'{\"name\":\"Keywords\",\"limit\":10}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(14,'BlogTagsWidget','blog-sidebar','starbelly-vi',3,'{\"name\":\"Keywords\",\"limit\":10}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(15,'AppDownloadWidget','galleries_sidebar','starbelly',1,'{\"title\":\"Download our mobile app.\",\"subtitle\":\"Consecrate numeral port nemo intelligentsia rem disciple quo mod.\",\"image\":\"backgrounds\\/phones.png\",\"platform_name_1\":\"App Store\",\"platform_button_image_1\":\"platforms\\/ios.png\",\"platform_url_1\":\"#\",\"platform_name_2\":\"GooglePlay\",\"platform_button_image_2\":\"platforms\\/android.png\",\"platform_url_2\":\"#\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(16,'AppDownloadWidget','galleries_sidebar','starbelly-vi',1,'{\"title\":\"Download our mobile app.\",\"subtitle\":\"Consecrate numeral port nemo intelligentsia rem disciple quo mod.\",\"image\":\"backgrounds\\/phones.png\",\"platform_name_1\":\"App Store\",\"platform_button_image_1\":\"platforms\\/ios.png\",\"platform_url_1\":\"#\",\"platform_name_2\":\"GooglePlay\",\"platform_button_image_2\":\"platforms\\/android.png\",\"platform_url_2\":\"#\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(17,'CallToActionWidget','product-footer','starbelly',1,'{\"title\":\"Free delivery service.\",\"description\":\"*Consectetur numquam poro nemo veniam<br>eligendi rem adipisci quo modi.\",\"image\":\"illustrations\\/delivery.png\",\"button_primary_url\":\"#\",\"button_primary_label\":\"Order delivery\",\"button_primary_icon\":\"general\\/cart.png\",\"button_secondary_url\":\"#\",\"button_secondary_label\":\"Menu\",\"button_secondary_icon\":\"general\\/menu.png\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(18,'CallToActionWidget','product-footer','starbelly-vi',1,'{\"title\":\"Free delivery service.\",\"description\":\"*Consectetur numquam poro nemo veniam<br>eligendi rem adipisci quo modi.\",\"image\":\"illustrations\\/delivery.png\",\"button_primary_url\":\"#\",\"button_primary_label\":\"Order delivery\",\"button_primary_icon\":\"general\\/cart.png\",\"button_secondary_url\":\"#\",\"button_secondary_label\":\"Menu\",\"button_secondary_icon\":\"general\\/menu.png\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(19,'NewsletterWidget','pre_footer_sidebar','starbelly',1,'{\"title\":\"Subscribe our newsletter\",\"subtitle\":\"Subscribe to get latest updates and information\",\"image\":\"illustrations\\/envelope-1.png\"}','2023-07-02 19:58:39','2023-07-02 19:58:39'),(20,'NewsletterWidget','pre_footer_sidebar','starbelly-vi',1,'{\"title\":\"Subscribe our newsletter\",\"subtitle\":\"Subscribe to get latest updates and information\",\"image\":\"illustrations\\/envelope-1.png\"}','2023-07-02 19:58:39','2023-07-02 19:58:39');
/*!40000 ALTER TABLE `widgets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-03  9:59:05