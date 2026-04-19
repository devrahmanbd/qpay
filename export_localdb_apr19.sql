-- MySQL dump 10.13  Distrib 9.3.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: main
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_uid_foreign` (`uid`),
  CONSTRAINT `activity_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (95,1,'::1','Signin','2026-04-18 07:06:11'),(96,1,'::1','Signin','2026-04-18 13:40:47'),(97,1,'::1','Signin','2026-04-18 16:48:50'),(98,1,'::1','Signin','2026-04-18 20:37:58'),(99,1,'::1','Signin','2026-04-18 23:09:01'),(100,1,'::1','Signin','2026-04-18 23:39:41'),(101,1,'::1','Signin','2026-04-18 23:57:42');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addons`
--

DROP TABLE IF EXISTS `addons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_identifier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `status` int NOT NULL DEFAULT '1',
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addons`
--

LOCK TABLES `addons` WRITE;
/*!40000 ALTER TABLE `addons` DISABLE KEYS */;
/*!40000 ALTER TABLE `addons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_activity_logs`
--

DROP TABLE IF EXISTS `admin_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_activity_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_activity_logs_uid_foreign` (`uid`),
  CONSTRAINT `admin_activity_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `staffs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_activity_logs`
--

LOCK TABLES `admin_activity_logs` WRITE;
/*!40000 ALTER TABLE `admin_activity_logs` DISABLE KEYS */;
INSERT INTO `admin_activity_logs` VALUES (1,1,'::1','Login','2026-04-18 06:47:15',NULL),(2,1,'::1','Login','2026-04-18 18:14:18',NULL),(3,1,'::1','Login','2026-04-18 20:38:19',NULL);
/*!40000 ALTER TABLE `admin_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `affiliates`
--

DROP TABLE IF EXISTS `affiliates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `ref_id` int unsigned NOT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `affiliates_uid_foreign` (`uid`),
  KEY `affiliates_ref_id_foreign` (`ref_id`),
  CONSTRAINT `affiliates_ref_id_foreign` FOREIGN KEY (`ref_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `affiliates_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliates`
--

LOCK TABLES `affiliates` WRITE;
/*!40000 ALTER TABLE `affiliates` DISABLE KEYS */;
/*!40000 ALTER TABLE `affiliates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_keys`
--

DROP TABLE IF EXISTS `api_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_keys` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` int unsigned NOT NULL,
  `merchant_id` int unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Default',
  `key_type` enum('publishable','secret') COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_prefix` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_last4` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `environment` enum('live','test') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'test',
  `last_used_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `revoked_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_brand_merchant` (`brand_id`,`merchant_id`),
  KEY `idx_key_hash` (`key_hash`(8))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_keys`
--

LOCK TABLES `api_keys` WRITE;
/*!40000 ALTER TABLE `api_keys` DISABLE KEYS */;
INSERT INTO `api_keys` VALUES (1,8,1,'Default','publishable','pk_test_','7f5eeff5ecdc666ece3b04ed793bd30b4cfc5145830ef492f965c3ab1c99a75c','dbd2','test',NULL,NULL,NULL,'2026-04-18 18:36:25'),(2,8,1,'Default','secret','qp_test_','5b31d678b4a514ed2bafac3091ed30d5dd11cfb4c26aa7b2b65f0865c1bad319','5972','test',NULL,NULL,NULL,'2026-04-18 18:36:25');
/*!40000 ALTER TABLE `api_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_logs`
--

DROP TABLE IF EXISTS `api_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `api_key_id` int unsigned DEFAULT NULL,
  `brand_id` int unsigned DEFAULT NULL,
  `merchant_id` int unsigned DEFAULT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endpoint` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_code` smallint DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `environment` enum('live','test') COLLATE utf8mb4_unicode_ci DEFAULT 'live',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_api_key_id` (`api_key_id`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_logs`
--

LOCK TABLES `api_logs` WRITE;
/*!40000 ALTER TABLE `api_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_transaction_logs`
--

DROP TABLE IF EXISTS `bank_transaction_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_transaction_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `brand_id` int DEFAULT NULL,
  `files` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_transaction_logs_uid_foreign` (`uid`),
  CONSTRAINT `bank_transaction_logs_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_transaction_logs`
--

LOCK TABLES `bank_transaction_logs` WRITE;
/*!40000 ALTER TABLE `bank_transaction_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_transaction_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thumbnail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `uri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `domain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand_logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fees` decimal(10,3) NOT NULL DEFAULT '0.000',
  `fees_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=flat,1=percent',
  `currency` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=inactive,1=active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brands_uid_foreign` (`uid`),
  CONSTRAINT `brands_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (8,1,'demopay.xyz','103.159.37.122','BD Better Pay','8QFIJJNzDGGw1qmhdCJcK5xcvuh8PwRXviUfDlLatVhgkjXlZv','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967288_00c5211fea2e14b14555.jpg','{\"mobile_number\":\"01711991935\",\"whatsapp_number\":\"01711991935\",\"support_mail\":\"tuktakpay@gmail.com\"}',0.000,0,NULL,1,'2024-12-07 11:20:51','2025-03-11 00:04:26',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) NOT NULL,
  `type` tinyint NOT NULL,
  `price` double NOT NULL,
  `times` varchar(191) DEFAULT NULL,
  `used` int unsigned NOT NULL DEFAULT '0',
  `param` text NOT NULL,
  `description` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `user_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_ip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `devices_uid_foreign` (`uid`),
  CONSTRAINT `devices_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (14,1,'admin@gmail.com','Relme8','fVSARTobNKvglddV9QhKlPFTsFcLUD884mmh1wjg',NULL,'2025-03-11 20:15:22',NULL,NULL);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `question` text,
  `answer` longtext,
  `sort` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,'What is Demo Pay','Demo Pay: Transforming Transactions through Technology Demo Pay is a powerful yet easy to utilize digital solution created to streamline business exchanges. Leveraging individual accounts as gateways, it guarantees adaptability, protection, and simplicity of use. Here are the ways Demo Pay can change your operations: Effortless Customer Settlements: With Demo Pay, enterprises can effortlessly approve installments specifically through their sites, improving client benefit. Its configurable settings support diverse payment options including recurring payments and subscriptions. Programmatic Integration for Productivity: Incorporate Demo Pay\\\\\\\\\\\\\\\'s strong API into your framework for smooth exchange administration. Its flexible design interfaces seamlessly with a wide range of platforms to automate workflows and reconcile funds with minimal human intervention. Security You Can Depend On: Each exchange is encrypted and checked to give a sheltered condition, guaranteeing client trust and information honesty. Multi-factor authentication and automatic fraud detection further fortify the protection of sensitive consumer data. For Organizations of All Sizes: Whether you\\\\\\\\\\\\\\\'re a small new company or a large association, Demo Pay changes as indicated by your needs, empowering development and making monetary cycles intuitive. Begin your excursion with Demo Pay and redesign how your business deals with installments.',1,1,'2025-06-30 06:45:56','2025-06-30 06:45:56','2026-03-14 23:04:04'),(2,'Is Demo Pay a Safe Option for Businesses ?','Demo Pay: The Safe and Reliable Payment Option! Demo Pay ensures every transaction is secured and reliable &mdash; making it a great choice for businesses needing the best financial protection. Here\\\\\\\\\\\\\\\'s why you can trust it : Advanced Encryption Protocols Demo Pay employs military-grade encryption to protect sensitive transactional data, maintaining the privacy of your customers. Fraud Detection Systems Scalable with integrated fraud detection, Demo Pay identifies and blocks suspicious activities for the peace of mind of the business. International standard compliance Demo Pay complies with international security frameworks, including PCI DSS, to ensure its compliance with industry standards for secure payment processing. Integration without compromise with strong security Demo Pay is user-friendly and easy to integrate, yet it still never sacrifices safety, helping businesses of all sizes. Demo Pay caters the necessities of startups and enterprise businesses with an emphasis on security, efficiency, and reliability.',2,1,'2025-06-30 06:47:19','2025-06-30 06:47:19','2026-03-14 23:04:10');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_managers`
--

DROP TABLE IF EXISTS `file_managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_managers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_managers`
--

LOCK TABLES `file_managers` WRITE;
/*!40000 ALTER TABLE `file_managers` DISABLE KEYS */;
INSERT INTO `file_managers` VALUES (2,88,'1728398628_942e8c07e19cebba1673.jpg','public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728398628_942e8c07e19cebba1673.jpg','image/jpeg',103221,'2024-10-08 20:43:48'),(3,88,'1728398658_5e037cadedaa9ddc5395.jpg','public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728398658_5e037cadedaa9ddc5395.jpg','image/jpeg',10263,'2024-10-08 20:44:18'),(4,0,'1728399479_b7d73f35726d9e4310b5.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399479_b7d73f35726d9e4310b5.png','image/png',80596,'2024-10-08 20:57:59'),(5,0,'1728399488_b64c3407b15836b97fd5.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399488_b64c3407b15836b97fd5.png','image/png',102502,'2024-10-08 20:58:08'),(6,0,'1728399559_9cd8914214b745521876.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399559_9cd8914214b745521876.png','image/png',80596,'2024-10-08 20:59:19'),(7,0,'1728399564_a0c7c02fd5a00d7ad426.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728399564_a0c7c02fd5a00d7ad426.png','image/png',80596,'2024-10-08 20:59:24'),(8,6,'1728400816_efcb28e5a8242c8caa78.png','public/uploads/user/c1dfd96eea8cc2b62785275bca38ac261256e278/1728400816_efcb28e5a8242c8caa78.png','image/png',80596,'2024-10-08 21:20:16'),(9,1,'1728403939_dfba68933fe40076ad85.jpg','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1728403939_dfba68933fe40076ad85.jpg','image/jpeg',14158,'2024-10-08 22:12:19'),(10,0,'1728409631_b500be3dd669fbf6579e.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728409631_b500be3dd669fbf6579e.png','image/png',80596,'2024-10-08 23:47:11'),(11,0,'1728410037_9239d6c1bae86f22c973.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1728410037_9239d6c1bae86f22c973.png','image/png',80596,'2024-10-08 23:53:57'),(12,6,'1728459782_00c5b6202549db3b7ba4.jpg','public/uploads/user/c1dfd96eea8cc2b62785275bca38ac261256e278/1728459782_00c5b6202549db3b7ba4.jpg','image/jpeg',39655,'2024-10-09 13:43:02'),(13,179,'1728478783_ac6316caf55f369ce3ca.jpeg','public/uploads/user/9e44d2771c052d44058245eda6cb334689ca78cc/1728478783_ac6316caf55f369ce3ca.jpeg','image/jpeg',7603,'2024-10-09 18:59:43'),(14,185,'1728496161_d0d07ad08a7d6af8a376.jpg','public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496161_d0d07ad08a7d6af8a376.jpg','image/jpeg',46179,'2024-10-09 23:49:21'),(15,185,'1728496198_3630522c5e47f2c5d0ae.png','public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496198_3630522c5e47f2c5d0ae.png','image/png',12578,'2024-10-09 23:49:58'),(16,185,'1728496406_66492203136fe6c36375.jpg','public/uploads/user/cfa2ed2aac6d61f44ca9cba73e1e8946b7cd7d22/1728496406_66492203136fe6c36375.jpg','image/jpeg',17945,'2024-10-09 23:53:26'),(17,88,'1728625532_c736bb50a36ff775b6b3.jpg','public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1728625532_c736bb50a36ff775b6b3.jpg','image/jpeg',9848,'2024-10-11 11:45:32'),(18,294,'1728912198_9b860d2f3c72bd2ba023.png','public/uploads/user/3a085d1bc5fa41313c4e0910e7341af761b0f7db/1728912198_9b860d2f3c72bd2ba023.png','image/png',14217,'2024-10-14 19:23:18'),(19,294,'1728912321_ca1ae7710241735b3281.png','public/uploads/user/3a085d1bc5fa41313c4e0910e7341af761b0f7db/1728912321_ca1ae7710241735b3281.png','image/png',14217,'2024-10-14 19:25:21'),(20,88,'1729093736_5fc766c9b99212298c52.png','public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1729093736_5fc766c9b99212298c52.png','image/png',14217,'2024-10-16 21:48:56'),(21,88,'1729093831_fa933efbff64b7e36225.png','public/uploads/user/b37f6ddcefad7e8657837d3177f9ef2462f98acf/1729093831_fa933efbff64b7e36225.png','image/png',14217,'2024-10-16 21:50:31'),(22,295,'1729094239_8e2d65a6eb177299cf19.png','public/uploads/user/a02b857f2eff73e8e188f35529dd91f8144b23b9/1729094239_8e2d65a6eb177299cf19.png','image/png',353311,'2024-10-16 21:57:19'),(23,295,'1729094469_32a8993e4621be4b1de4.png','public/uploads/user/a02b857f2eff73e8e188f35529dd91f8144b23b9/1729094469_32a8993e4621be4b1de4.png','image/png',14217,'2024-10-16 22:01:09'),(24,298,'1729386388_9d7da5a470559431441d.jpg','public/uploads/user/eb65e208b715d3b42fc535aebcd8d3e7fb5f2c94/1729386388_9d7da5a470559431441d.jpg','image/jpeg',125565,'2024-10-20 07:06:28'),(25,300,'1729618566_ebbbf94a1463ae0457c8.png','public/uploads/user/e26973e6ee8ab9cd8cb3f207d1b90f00d2669eff/1729618566_ebbbf94a1463ae0457c8.png','image/png',405464,'2024-10-22 23:36:06'),(26,0,'1730479999_b87e7dfe94351beeb59e.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1730479999_b87e7dfe94351beeb59e.jpg','image/jpeg',14158,'2024-11-01 22:53:19'),(27,0,'1730480029_aa524a469f5d2c7b0c86.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1730480029_aa524a469f5d2c7b0c86.jpg','image/jpeg',14158,'2024-11-01 22:53:49'),(28,1,'1730595824_0af2130ffb3c7e904904.png','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1730595824_0af2130ffb3c7e904904.png','image/png',80596,'2024-11-03 07:03:44'),(29,0,'1732982962_ab1f3d84fa63112c3ca6.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1732982962_ab1f3d84fa63112c3ca6.png','image/png',5774,'2024-11-30 22:09:22'),(30,0,'1732982998_9ce2a923f99cd8fc2195.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1732982998_9ce2a923f99cd8fc2195.png','image/png',5774,'2024-11-30 22:09:58'),(31,0,'1733031584_41825073b1b771dca6c4.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031584_41825073b1b771dca6c4.png','image/png',9299,'2024-12-01 11:39:44'),(32,0,'1733031830_6e41fa51d1d9b0bcd847.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031830_6e41fa51d1d9b0bcd847.png','image/png',76912,'2024-12-01 11:43:50'),(33,0,'1733031856_50b153c4d9ae66b5a156.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031856_50b153c4d9ae66b5a156.png','image/png',76912,'2024-12-01 11:44:16'),(34,0,'1733031863_d0f67e662a5079f004eb.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733031863_d0f67e662a5079f004eb.png','image/png',9299,'2024-12-01 11:44:23'),(35,0,'1733114332_81e7abc3de6e2f6ae2b0.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1733114332_81e7abc3de6e2f6ae2b0.png','image/png',34218,'2024-12-02 10:38:52'),(36,1,'1733208458_d74f2aea85f7ca40742d.png','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1733208458_d74f2aea85f7ca40742d.png','image/png',34218,'2024-12-03 12:47:38'),(37,305,'1733548847_ac6a1016655add94c3fa.png','public/uploads/user/9a3d6127374af09c22015bf3ede3ac00a36e3ec6/1733548847_ac6a1016655add94c3fa.png','image/png',76912,'2024-12-07 11:20:47'),(38,1,'1734176170_0f063d499294a3f1e5ac.png','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734176170_0f063d499294a3f1e5ac.png','image/png',4190,'2024-12-14 17:36:10'),(39,1,'1734176397_89fe00dfab5b71abc250.png','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734176397_89fe00dfab5b71abc250.png','image/png',6974,'2024-12-14 17:39:57'),(40,0,'1734517490_3e85a09031251cde25cc.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734517490_3e85a09031251cde25cc.jpg','image/jpeg',11813,'2024-12-18 16:24:50'),(41,0,'1734517520_ce360fd376246a408ee2.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734517520_ce360fd376246a408ee2.jpg','image/jpeg',11813,'2024-12-18 16:25:20'),(42,0,'1734518091_54e0507c3f49114cec5c.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518091_54e0507c3f49114cec5c.jpg','image/jpeg',22993,'2024-12-18 16:34:51'),(43,0,'1734518168_ace641b4ec9c9209f648.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518168_ace641b4ec9c9209f648.png','image/png',47608,'2024-12-18 16:36:08'),(44,0,'1734518179_cd2492593a529e11a746.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734518179_cd2492593a529e11a746.jpg','image/jpeg',17921,'2024-12-18 16:36:19'),(45,0,'1734519128_69d5a090b9b3df244e02.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519128_69d5a090b9b3df244e02.jpg','image/jpeg',17921,'2024-12-18 16:52:08'),(46,0,'1734519891_d9639631de1634bf18bc.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519891_d9639631de1634bf18bc.png','image/png',47608,'2024-12-18 17:04:51'),(47,340,'1734542607_1ab17fcc7244e31abc31.jpg','public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734542607_1ab17fcc7244e31abc31.jpg','image/jpeg',69631,'2024-12-18 23:23:27'),(48,340,'1734542972_2d014fde6f86d13e69b0.png','public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734542972_2d014fde6f86d13e69b0.png','image/png',315707,'2024-12-18 23:29:33'),(49,0,'1734614289_262d9fd2c01e2ebc4719.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734614289_262d9fd2c01e2ebc4719.jpg','image/jpeg',17433,'2024-12-19 19:18:09'),(50,0,'1734614395_c0c3762ef72a251de9e6.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734614395_c0c3762ef72a251de9e6.png','image/png',53445,'2024-12-19 19:19:55'),(51,340,'1734937992_329284fb1bf938ea2987.png','public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734937992_329284fb1bf938ea2987.png','image/png',18841,'2024-12-23 13:13:12'),(52,340,'1734938769_a6de23117d04d5c4f0ec.png','public/uploads/user/3e6bf6c89ba8a8b8b189f85975b0fab42bdc6d4a/1734938769_a6de23117d04d5c4f0ec.png','image/png',18841,'2024-12-23 13:26:09'),(53,0,'1734947867_4e920b1c6db0a27cf27a.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734947867_4e920b1c6db0a27cf27a.png','image/png',121805,'2024-12-23 15:57:47'),(54,1,'1734967288_00c5211fea2e14b14555.jpg','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967288_00c5211fea2e14b14555.jpg','image/jpeg',11375,'2024-12-23 21:21:28'),(55,1,'1734967698_8eb8fbaa63941124dc8e.jpg','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1734967698_8eb8fbaa63941124dc8e.jpg','image/jpeg',55107,'2024-12-23 21:28:18'),(56,341,'1735011486_4801ce974c04db55cb75.jpg','public/uploads/user/8da4dabfaeb4a44681c9777c85db39140e3e12e6/1735011486_4801ce974c04db55cb75.jpg','image/jpeg',15878,'2024-12-24 09:38:06'),(57,343,'1735013786_0cc23734a29f647625ba.jpg','public/uploads/user/25a5e3012854728e0c6ab97fdcbb65c3a00c0965/1735013786_0cc23734a29f647625ba.jpg','image/jpeg',68916,'2024-12-24 10:16:26'),(58,343,'1735034795_4e4dddbf25a737e06538.jpg','public/uploads/user/25a5e3012854728e0c6ab97fdcbb65c3a00c0965/1735034795_4e4dddbf25a737e06538.jpg','image/jpeg',55107,'2024-12-24 16:06:35'),(59,344,'1735091568_9970f2d6c58fe5ba9c4e.jpg','public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735091568_9970f2d6c58fe5ba9c4e.jpg','image/jpeg',64520,'2024-12-25 07:52:48'),(60,345,'1735100654_556d77316b63cdccf145.jpg','public/uploads/user/35139ef894b28b73bea022755166a23933c7d9cb/1735100654_556d77316b63cdccf145.jpg','image/jpeg',55107,'2024-12-25 10:24:14'),(61,344,'1735120914_d1a3a6585c0af53167e9.jpg','public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735120914_d1a3a6585c0af53167e9.jpg','image/jpeg',64520,'2024-12-25 16:01:54'),(62,344,'1735121112_56db2aed8e2e08edfe31.jpg','public/uploads/user/640bacfb48aefac1f91028c01603e5c78d4f63ca/1735121112_56db2aed8e2e08edfe31.jpg','image/jpeg',64520,'2024-12-25 16:05:12'),(63,309,'1735189800_9eb8731cad43175badc8.jpg','public/uploads/user/ed2efc1c05342a60c2198a5e96773a237008956b/1735189800_9eb8731cad43175badc8.jpg','image/jpeg',149719,'2024-12-26 11:10:00'),(64,351,'1735458685_c0889c215fe1b81901a9.png','public/uploads/user/0026476a20bfbd08714155bb66f0b4feb2d25c1c/1735458685_c0889c215fe1b81901a9.png','image/png',53269,'2024-12-29 13:51:25'),(65,352,'1735568726_c731b945f81cc65167a0.png','public/uploads/user/efbc0848b836a9de4b0c18c93ec052d87647fb06/1735568726_c731b945f81cc65167a0.png','image/png',19341,'2024-12-30 20:25:26'),(66,309,'1735835221_52dd0ee3e1252e277692.jpg','public/uploads/user/ed2efc1c05342a60c2198a5e96773a237008956b/1735835221_52dd0ee3e1252e277692.jpg','image/jpeg',68306,'2025-01-02 22:27:01'),(67,358,'1741702704_8bb04122ef73501a7879.png','public/uploads/user/abf749051d8b000946c71a2e216e55eeb49cf414/1741702704_8bb04122ef73501a7879.png','image/png',390361,'2025-03-11 20:18:25'),(68,1,'1746806013_f5bd82cfd5cec3190852.png','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1746806013_f5bd82cfd5cec3190852.png','image/png',8337,'2025-05-09 21:53:33'),(69,0,'1746806453_631eb05aa9d55be8506e.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1746806453_631eb05aa9d55be8506e.png','image/png',8337,'2025-05-09 22:00:53'),(70,0,'1746806477_ff79c3408aab1c2f22f0.png','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1746806477_ff79c3408aab1c2f22f0.png','image/png',8337,'2025-05-09 22:01:17'),(71,364,'1750688991_115cf69d62c56087cb75.jpg','public/uploads/user/56e43ae4ca9369ef504ed49d4a92f42eddff81c5/1750688991_115cf69d62c56087cb75.jpg','image/jpeg',318809,'2025-06-23 20:29:51'),(72,364,'1750699011_dcb3da826b3d684999dd.jpg','public/uploads/user/56e43ae4ca9369ef504ed49d4a92f42eddff81c5/1750699011_dcb3da826b3d684999dd.jpg','image/jpeg',46475,'2025-06-23 23:16:51'),(73,0,'1751242004_2cb2a5bfadc8793f1ccd.png','public/uploads/admin/da4b9237bacccdf19c0760cab7aec4a8359010b0/1751242004_2cb2a5bfadc8793f1ccd.png','image/png',9099,'2025-06-30 06:06:44'),(74,371,'1751246697_5cefcdef23eab13eb215.png','public/uploads/user/3554dce55f341edd431fc711f6816673f081452d/1751246697_5cefcdef23eab13eb215.png','image/png',9099,'2025-06-30 07:24:57'),(75,0,'1751369973_57d5b943f3e17f94a03f.jpg','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1751369973_57d5b943f3e17f94a03f.jpg','image/jpeg',177301,'2025-07-01 17:39:33'),(76,372,'1751385968_1d66a6e43bb8eea7b3c8.jpg','public/uploads/user/6d93f2a0e5f0fe2cc3a6e9e3ade964b43b07f897/1751385968_1d66a6e43bb8eea7b3c8.jpg','image/jpeg',177301,'2025-07-01 22:06:08');
/*!40000 ALTER TABLE `file_managers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `customer_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `customer_amount` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL,
  `pay_status` int NOT NULL,
  `brand_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `transaction_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `extras` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `invoice_uid_foreign` (`uid`),
  CONSTRAINT `invoice_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kyc`
--

DROP TABLE IF EXISTS `kyc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kyc` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kyc_uid_foreign` (`uid`),
  CONSTRAINT `kyc_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kyc`
--

LOCK TABLES `kyc` WRITE;
/*!40000 ALTER TABLE `kyc` DISABLE KEYS */;
/*!40000 ALTER TABLE `kyc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2023-12-23-055313','Modules\\Blocks\\Database\\Migrations\\Queue','default','Blocks',1733164861,1),(2,'2023-12-23-055313','Modules\\Home\\Database\\Migrations\\Settings','default','Home',1733164862,2),(3,'2023-12-26-040632','Modules\\Home\\Database\\Migrations\\FileManager','default','Home',1733164862,2),(4,'2023-12-27-012628','Modules\\Home\\Database\\Migrations\\Payments','default','Home',1733164862,2),(5,'2024-04-30-042916','Modules\\Home\\Database\\Migrations\\Blogs','default','Home',1733164862,2),(6,'2024-05-15-153103','Modules\\Home\\Database\\Migrations\\Addons','default','Home',1733164862,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_data`
--

DROP TABLE IF EXISTS `module_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `module_data` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tmp_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `uid` int unsigned NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=success',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_data_uid_foreign` (`uid`),
  CONSTRAINT `module_data_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_data`
--

LOCK TABLES `module_data` WRITE;
/*!40000 ALTER TABLE `module_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `admin_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_uid_foreign` (`uid`),
  CONSTRAINT `notifications_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'is_maintenance_mode','0'),(2,'site_title','QPay | Ultimate Payment Gateway For Every Business'),(3,'site_description','QPay is your one-stop platform for seamless and secure payment automation. We specialise in streamlining payment processes for businesses and individuals, offering features like recurring billing, real-time transaction tracking, and integration with multiple payment gateways. With a focus on efficiency and user-friendliness, Auto Pay Solution ensures your payments are handled effortlessly, giving you more time to focus on growth. Experience the convenience of automated payments with our cutting-edge technology and reliable customer support.'),(4,'site_keywords','cloudman, Qpay, payment gateway in bd'),(5,'site_icon','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1751369973_57d5b943f3e17f94a03f.jpg'),(6,'site_name','QPay'),(7,'default_limit_per_page','100'),(8,'currency_decimal','2'),(9,'currency_decimal_separator','dot'),(10,'currency_thousand_separator','comma'),(11,'currency_symbol','৳'),(12,'maintenance_mode_time','2025-07-06T00:00'),(13,'enable_https','1'),(14,'optimize','1'),(15,'address','Dhaka, Bangladesh '),(16,'social_github_link','#'),(17,'social_facebook_link','https://www.facebook.com/'),(18,'social_instagram_link','#'),(19,'social_pinterest_link','#'),(20,'social_twitter_link','#'),(21,'social_tumblr_link',''),(22,'social_youtube_link','#'),(23,'contact_tel','01540203662'),(24,'contact_email','qpay@cloudman.one'),(25,'contact_work_hour','Sat-Thu 09 am - 10 pm'),(26,'copy_right_content','All Right Preserved by QPay'),(27,'update_file','1'),(28,'honeypot',''),(29,'site_logo','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/demopay.png'),(30,'is_clear_ticket','0'),(31,'default_clear_ticket_days','30'),(32,'default_pending_ticket_per_user','0'),(33,'enable_notification_popup','0'),(34,'notification_popup_content',''),(35,'enable_panel_notification_popup','0'),(36,'notification_popup_panel_content',''),(37,'is_verification_new_account','1'),(38,'is_welcome_email','1'),(39,'is_new_user_email','1'),(40,'email_welcome_email_subject','Welcome To Our site'),(41,'enable_notification','1'),(42,'email_from','info@anihost.top'),(43,'email_name','AniPay'),(44,'email_protocol_type','smtp'),(45,'is_addfund_bonus','0'),(46,'is_plan_bonus','0'),(47,'is_signup_bonus','0'),(48,'signup_bonus_amount','0'),(49,'affiliate_bonus_type','0'),(50,'affiliate_bonus','0'),(51,'min_affiliate_amount','0'),(52,'max_affiliate_time','0'),(53,'currency_code','BDT'),(54,'auto_rounding_x_decimal_places','2'),(55,'is_auto_currency_convert','0'),(56,'new_currecry_rate','1'),(57,'policy_content',''),(58,'embed_head_javascript',''),(59,'embed_javascript',''),(60,'is_payment_notice_email','1'),(61,'is_ticket_notice_email','1'),(62,'is_ticket_notice_email_admin','1'),(63,'is_order_notice_email','1'),(64,'smtp_server',''),(65,'smtp_port','587'),(66,'smtp_encryption','tls'),(67,'smtp_username',''),(68,'smtp_password',''),(69,'limit_per_page','10'),(70,'terms_content',''),(71,'enable_all_user','1'),(72,'enable_database_cache','1'),(73,'enable_tickets','1'),(74,'affiliate_level','4'),(75,'verification_email_subject','{{website_name}} - Please validate your account'),(76,'verification_email_content','<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{first_name}}</strong>!</p>\r\n<p>&nbsp;Thank you for joining! We\'re glad to have you as community member, and we\'re stocked for you to start exploring our service. &nbsp;If you don\'t verify your address, you won\'t be able to create a&nbsp;User Account.</p>\r\n<p>&nbsp;&nbsp;All you need to do is activate your account&nbsp;by click this link:&nbsp;<br />&nbsp; {{activation_link}}&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),(77,'email_welcome_email_content','<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{first_name}}</strong>!</p>\r\n<p>Congratulations!&nbsp;<br />You have successfully signed up for our service - {{website_name}}&nbsp;with follow data</p>\r\n<ul>\r\n<li>Firstname: {{first_name}}</li>\r\n<li>Lastname: {{last_name}}</li>\r\n<li>Email: {{email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>\r\n<p>We want to exceed your expectations, so please do not&nbsp;hesitate to reach out at any time if you have any questions or concerns. We look to working with you.</p>\r\n<p>Best Regards,</p>'),(78,'email_new_registration_subject','{{website_name}} - New Registration'),(79,'email_new_registration_content','<p>Hi Admin!</p>\r\n<p>Someone signed up in <strong>{{website_name}}</strong> with follow data</p>\r\n<ul>\r\n<li>Firstname {{first_name}}</li>\r\n<li>Lastname: {{last_name}}</li>\r\n<li>Email: {{email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>'),(80,'email_password_recovery_subject','{{website_name}} - Password Recovery'),(81,'email_password_recovery_content','<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>Somebody (hopefully you) requested a new password for your account.&nbsp;</p>\r\n<p>No changes have been made to your account yet.&nbsp;<br />You can reset your password by click this link:&nbsp;<br />{{recovery_password_link}}</p>\r\n<p>If you did not request a password reset, no further action is required.&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),(82,'admin_email_password_recovery_subject','{{website_name}} - Password Recovery'),(83,'admin_email_password_recovery_content','<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>Somebody (hopefully you) requested a new password for your account.&nbsp;</p>\r\n<p>No changes have been made to your account yet.&nbsp;<br />You can reset your password by click this link:&nbsp;<br />{{admin_recovery_password_link}}</p>\r\n<p>If you did not request a password reset, no further action is required.&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>'),(84,'email_payment_notice_subject','{{website_name}} -  Thank You! Deposit Payment Received'),(85,'email_payment_notice_content','<p>Hi<strong> {{first_name}}!&nbsp;</strong></p>\r\n<p>We\'ve just received your final remittance and would like to thank you. We appreciate your diligence in adding funds to your balance in our service.</p>\r\n<p>It has been a pleasure doing business with you. We wish you the best of luck.</p>\r\n<p>Thanks and Best Regards!</p>'),(86,'business_name',''),(87,'is_cookie_policy_page','0'),(88,'cookies_policy_page',''),(89,'embed_footee_javascript',''),(90,'home_page','1'),(91,'homepage_code','\n<section id=\"hero\" class=\"hero d-flex align-items-center\">\n\n    <div class=\"container\">\n        <div class=\"row\">\n            <div class=\"col-lg-6 d-flex flex-column justify-content-center\">\n                <h1 data-aos=\"fade-up\">Automate Your Payments Seamlessly</h1>\n                <h2 data-aos=\"fade-up\" data-aos-delay=\"400\">Join us to experience efficient and secure payment solutions for your business</h2>\n                <div data-aos=\"fade-up\" data-aos-delay=\"600\">\n                    <div class=\"text-center text-lg-start\">\n                        <a href=\"/sign-up\" class=\"btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center\">\n                            <span>Get Started</span>\n                            <i class=\"bi bi-arrow-right\"></i>\n                        </a>\n                    </div>\n                </div>\n            </div>\n            <div class=\"col-lg-6 order-1 order-lg-2 hero-img\" data-aos=\"zoom-out\">\n            \n            <img src=\"<?= base_url(\'public/assets/plat\') ?>/123123-1.png\" class=\"img-fluid animated\" alt=\"\">\n          </div> \n            \n        </div>\n    </div>\n\n</section><!-- End Hero -->\n\n<main id=\"main\">\n\n<section id=\"about\" class=\"values\">\n    <div class=\"container\" data-aos=\"fade-up\">\n        <header class=\"section-header\">\n            <h2>We Offer</h2>\n            <p>Our guiding principles that empower seamless payment solutions</p>\n        </header>\n\n        <div class=\"row\">\n            <div class=\"col-lg-4\" data-aos=\"fade-up\" data-aos-delay=\"200\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/tt.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Save Time</h3>\n                    <p>Simplify your payment processes and save valuable time with our integrated MFS API, ensuring fast and efficient transactions.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"400\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/nh.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Seamless Integration</h3>\n                    <p>Easily connect and integrate with our system. Automate workflows, link applications, and manage data sources effortlessly.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"600\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/mm.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Automate Personal Accounts</h3>\n                    <p>Streamline your payment reception with NagorikPay\'s automation. Direct payments to your personal account without manual intervention.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"800\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/5644447.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Invoice Generator</h3>\n                    <p>Create and send personalized payment links via email for quick and easy payments, eliminating the need for a website or online store.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"1000\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/6221918.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Billing Management</h3>\n                    <p>Simplify billing with NagorikPay\'s automated system. Monitor transactions, generate invoices, and streamline your billing process efficiently.</p>\n                </div>\n            </div>\n\n            <div class=\"col-lg-4 mt-4 mt-lg-0\" data-aos=\"fade-up\" data-aos-delay=\"1200\">\n                <div class=\"box\">\n                    <img src=\"<?= base_url(\'public/assets/plat\') ?>/2903544.png\" class=\"img-fluid\" alt=\"\">\n                    <h3>Multiple Payment Options</h3>\n                    <p>Offer your customers various payment methods, including Mobile Banking and Bank Transfers, through NagorikPay\'s versatile platform.</p>\n                </div>\n            </div>\n\n            \n        </div>\n    </div>\n</section><!-- End Values Section -->\n\n\n\n    <section id=\"counts\" class=\"counts\">\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <div class=\"row gy-4\">\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-people-fill\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"1963\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Happy Clients</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-book-half\" style=\"color: #ee6c20;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"6\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Plans</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-graph-up\" style=\"color: #15be56;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"3287490\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Total Amount Transactions</p>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"col-lg-3 col-md-6\">\n                <div class=\"count-box\">\n                    <!-- Updated icon -->\n                    <i class=\"bi bi-credit-card\" style=\"color: #bb0852;\"></i>\n                    <div>\n                        <span data-purecounter-start=\"0\" data-purecounter-end=\"12\" data-purecounter-duration=\"1\" class=\"purecounter\"></span>\n                        <p>Supported Payment Methods</p>\n                    </div>\n                </div>\n            </div>\n\n        </div>\n\n    </div>\n</section>\n\n    <section id=\"features\" class=\"features\">\n\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n            <h2>Features</h2>\n            <p>Advanced capabilities for streamlined payments</p>\n        </header>\n\n        <div class=\"row\">\n\n              <div class=\"col-xl-6\" data-aos=\"zoom-out\" data-aos-delay=\"100\">\n            \n            <img src=\"<?= base_url(\'public/assets/plat\') ?>/13429923.jpg\" class=\"img-fluid\" alt=\"\">\n          </div> \n                \n\n            <div class=\"col-lg-6 mt-5 mt-lg-0 d-flex\">\n                <div class=\"row align-self-center gy-4\">\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"200\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-speedometer2\"></i>\n                            <h3>Real-Time Processing</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"300\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-shield-lock\"></i>\n                            <h3>High Security</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"400\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-arrows-expand\"></i>\n                            <h3>Scalability</h3>\n                        </div>\n                    </div>\n\n                  \n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"600\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-link\"></i>\n                            <h3>Seamless Integration</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"700\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-graph-up\"></i>\n                            <h3>Comprehensive Reporting</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"800\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-check-circle\"></i>\n                            <h3>Automatic Payment Verification</h3>\n                        </div>\n                    </div>\n\n                    <div class=\"col-md-6\" data-aos=\"zoom-out\" data-aos-delay=\"900\">\n                        <div class=\"feature-box d-flex align-items-center\">\n                            <i class=\"bi bi-cash\"></i>\n                            <h3>No Transaction Fees</h3>\n                        </div>\n                    </div>\n\n                </div>\n            </div>\n\n        </div> <!-- / row -->\n\n    </div>\n\n</section><!-- End Features Section -->\n<section id=\"services\" class=\"services\">\n\n    <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n            <h2>Services</h2>\n            <p>Explore our range of services</p>\n        </header>\n\n        <div class=\"row mt-5\">\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"200\">\n                <div class=\"service-box blue\">\n                    <i class=\"bi bi-lightning-charge-fill icon\"></i>\n                    <h3>Instant Payment</h3>\n                    <p>After the customer makes the payment through NAGORIKPAY, it will be instantly added to account with automatic verification.</p>\n                      </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"300\">\n                <div class=\"service-box orange\">\n                    <i class=\"bi bi-arrow-repeat icon\"></i>\n                    <h3>Lifetime Updates</h3>\n                    <p>Enjoy free lifetime updates with the desired service.</p>\n                        </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"400\">\n                <div class=\"service-box green\">\n                    <i class=\"bi bi-wallet icon\"></i>\n                    <h3>Unlimited Transactions</h3>\n                    <p>Receive unlimited payments with Nagorikpay without any fees.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"500\">\n                <div class=\"service-box red\">\n                    <i class=\"bi bi-chat-dots icon\"></i>\n                    <h3>24/7 Support</h3>\n                    <p>Our support team is available 24/7 to solve any issues, including NagorikPay setup and usage.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"600\">\n                <div class=\"service-box purple\">\n                    <i class=\"bi bi-credit-card icon\"></i>\n                    <h3>Payment Processing</h3>\n                    <p>Efficient and secure processing for all your payment needs, ensuring seamless transactions every time.</p>\n                     </div>\n            </div>\n\n            <div class=\"col-lg-4 col-md-6\" data-aos=\"fade-up\" data-aos-delay=\"700\">\n                <div class=\"service-box pink\">\n                    <i class=\"bi bi-shield-check icon\"></i>\n                    <h3>Fraud Prevention</h3>\n                    <p>Advanced fraud prevention measures to protect your business and customers from unauthorized activities.</p>\n                      </div>\n            </div>\n\n        </div>\n\n    </div>\n\n</section><!-- End Services Section -->\n\n</main>\n\n\n\n    <!-- ======= Pricing Section ======= -->\n    <section id=\"pricing\" class=\"pricing\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <h2>Pricing</h2>\n                <p>Check our Pricing</p>\n            </header>\n\n            <div class=\"row gy-4\" data-aos=\"fade-left\">\n\n                <?php if (!empty($plans)) : foreach ($plans as $plan) :  ?>\n                        <div class=\"col-lg-3 col-md-6\" data-aos=\"zoom-in\" data-aos-delay=\"100\">\n                            <div class=\"box\">\n                                <h3 style=\"color: #07d5c0;\"><?= $plan[\'name\'] ?></h3>\n                                <div class=\"price\"><sup></sup><?= currency_format($plan[\'final_price\']) ?><span> / <?= duration_type($plan[\'name\'], $plan[\'duration_type\'], $plan[\'duration\'], false) ?></span></div>\n                                <p class=\"text-center\"><?= $plan[\'description\'] ?></p>\n\n                                <ul>\n                                    \n                                    <li><?= plan_message(\'brand\', $plan[\'brand\']) ?></li>\n                                    <li><?= plan_message(\'device\', $plan[\'device\']) ?></li>\n                                    <li><?= plan_message(\'transaction\', $plan[\'transaction\']) ?></li>\n                                </ul>\n                                <a href=\"<?= user_url(\'plans\') ?>\" class=\"btn-buy\">Buy Now</a>\n                            </div>\n                        </div>\n                <?php endforeach;\n                endif; ?>\n\n\n\n            </div>\n\n        </div>\n\n        </div>\n\n    </section><!-- End Pricing Section -->\n    \n    <!-- ======= Platform Section ======= -->\n    <section id=\"\" class=\"clients\">\n\n      <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n          <p>Supported Platforms</p>\n        </header>\n\n        <div class=\"clients-slider swiper\">\n          <div class=\"swiper-wrapper align-items-center\">\n          <div class=\"swiper-slide\"><img src=\"public/assets/plat/smm.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/php.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/javascript.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/jquery.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/nodejs.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/whmcs-logo.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/woocommerce-logo-transparent.png\" class=\"img-fluid\" alt=\"\"></div>\n            <div class=\"swiper-slide\"><img src=\"public/assets/plat/wordpress-logo-stacked-rgb.png\" class=\"img-fluid\" alt=\"\"></div>\n          </div>\n          <div class=\"swiper-pagination\"></div>\n        </div>\n      </div>\n\n    </section><!-- End Section -->\n    \n    \n    <!-- ======= F.A.Q Section ======= -->\n    <section id=\"faq\" class=\"faq\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <h2>F.A.Q</h2>\n                <p>Frequently Asked Questions</p>\n            </header>\n            <?php if (!empty($items)) : ?>\n                <div class=\"row\">\n                    <div class=\"col-lg-6\">\n                        <!-- F.A.Q List 1-->\n                        <div class=\"accordion accordion-flush\" id=\"faqlist1\">\n                            <?php\n                            // Split items for the first column\n                            $firstColumnItems = array_slice($items, 0, ceil(count($items) / 2));\n                            foreach ($firstColumnItems as $key => $item) : ?>\n                                <div class=\"accordion-item wow fadeInUp\" data-wow-delay=\"0.1s\">\n                                    <h2 class=\"accordion-header\" id=\"m<?= $item[\'id\'] ?>\">\n                                        <button class=\"accordion-button <?= $key == 0 ? \'\' : \'collapsed\' ?>\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#kkk<?= $item[\'id\'] ?>\" aria-expanded=\"<?= $key == 0 ? \'true\' : \'false\' ?>\" aria-controls=\"kkk<?= $item[\'id\'] ?>\">\n                                            <?= $item[\'question\'] ?>\n                                        </button>\n                                    </h2>\n                                    <div id=\"kkk<?= $item[\'id\'] ?>\" class=\"accordion-collapse collapse <?= $key == 0 ? \'show\' : \'\' ?>\" aria-labelledby=\"m<?= $item[\'id\'] ?>\" data-bs-parent=\"#faqlist1\">\n                                        <div class=\"accordion-body\">\n                                            <?= $item[\'answer\'] ?>\n                                        </div>\n                                    </div>\n                                </div>\n                            <?php endforeach; ?>\n                        </div>\n                    </div>\n\n                    <div class=\"col-lg-6\">\n                        <!-- F.A.Q List 2-->\n                        <div class=\"accordion accordion-flush\" id=\"faqlist2\">\n                            <?php\n                            // Split items for the second column\n                            $secondColumnItems = array_slice($items, ceil(count($items) / 2));\n                            foreach ($secondColumnItems as $key => $item) : ?>\n                                <div class=\"accordion-item wow fadeInUp\" data-wow-delay=\"0.1s\">\n                                    <h2 class=\"accordion-header\" id=\"m<?= $item[\'id\'] ?>\">\n                                        <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#kkk<?= $item[\'id\'] ?>\" aria-expanded=\"false\" aria-controls=\"kkk<?= $item[\'id\'] ?>\">\n                                            <?= $item[\'question\'] ?>\n                                        </button>\n                                    </h2>\n                                    <div id=\"kkk<?= $item[\'id\'] ?>\" class=\"accordion-collapse collapse\" aria-labelledby=\"m<?= $item[\'id\'] ?>\" data-bs-parent=\"#faqlist2\">\n                                        <div class=\"accordion-body\">\n                                            <?= $item[\'answer\'] ?>\n                                        </div>\n                                    </div>\n                                </div>\n                            <?php endforeach; ?>\n                        </div>\n                    </div>\n                </div>\n            <?php endif; ?>\n\n\n        </div>\n\n    </section><!-- End F.A.Q Section -->\n\n    <section id=\"clients\" class=\"clients\">\n\n        <div class=\"container\" data-aos=\"fade-up\">\n\n            <header class=\"section-header\">\n                <p>Supported Gateways</p>\n            </header>\n\n            <div class=\"clients-slider swiper\">\n                <div class=\"swiper-wrapper align-items-center\">\n                    <?php if (!empty($payments)) : foreach ($payments as $payment) : ?>\n                            <div class=\"swiper-slide\"><img src=\"<?= base_url() . @get_value(get_value($payment[\'params\'], \'option\'), \'logo\'); ?>\" class=\"img-fluid\" alt=\"\"></div>\n                    <?php endforeach;\n                    endif; ?>\n                </div>\n                <div class=\"swiper-pagination\"></div>\n            </div>\n        </div>\n\n    </section><!-- End Clients Section -->\n    \n<section id=\"contact\" class=\"contact\">\n\n      <div class=\"container\" data-aos=\"fade-up\">\n\n        <header class=\"section-header\">\n          <p>Contact US</p>\n        </header>\n\n        <div class=\"row gy-4\">\n\n          <div class=\"col-lg-6\">\n\n            <div class=\"row gy-4\">\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-geo-alt\"></i>\n                  <h3>Address</h3>\n                  <p><?= site_config(\'address\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-telephone\"></i>\n                  <h3>Call Us</h3>\n                  <p><?= site_config(\'contact_tel\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-envelope\"></i>\n                  <h3>Email Us</h3>\n                  <p><?= site_config(\'contact_email\') ?></p>\n                </div>\n              </div>\n              <div class=\"col-md-6\">\n                <div class=\"info-box\">\n                  <i class=\"bi bi-clock\"></i>\n                  <h3>Open Hours</h3>\n                  <p><?= site_config(\'contact_work_hour\') ?></p>\n                </div>\n              </div>\n            </div>\n\n          </div>\n\n          \n\n        </div>\n\n      </div>\n\n    </section><!-- End Contact Section -->\n\n\n\n</main><!-- End #main -->'),(92,'google_login','0'),(93,'google_auth_clientId','Google Auth Client Id'),(94,'google_auth_clientSecret','Google Auth ClientSecret'),(95,'enable_google_recaptcha','0'),(96,'google_capcha_site_key',''),(97,'google_capcha_secret_key',''),(98,'enable_kyc','0'),(99,'preloader','0'),(100,'enable_google_translator','0'),(101,'enable_goolge_translator','0'),(102,'preoloader','1'),(103,'enable_goolge_recapcha','0'),(104,'enable_google_recapcha','1'),(105,'sms_api_char_length',''),(106,'sms_api_o_char_length',''),(107,'sms_api_cost',''),(108,'sms_api_header_data',''),(109,'sms_api_params',''),(110,'sms_api_formdata','h'),(111,'sms_api_success_key','response_code'),(112,'sms_api_success_value','202'),(113,'is_user_trx_sms','0'),(114,'is_user_customer_trx_sms','0'),(115,'is_user_plan_sms','0'),(116,'is_user_addon_sms','0'),(117,'sms_api_method','POST'),(118,'sms_api_url','https://rest.nexmo.com/sms/json'),(119,'theme','custom'),(120,'user_plan_sms','Hi<strong> {{first_name}}!</strong>A plan of {{pay_amount}} tk has been added to your account successfully!</p>'),(124,'site_paymentform','V2'),(125,'website_name','Your Site'),(126,'website_favicon','https://trustpaybd.com/assets/images/favicon.png'),(127,'website_logo',''),(128,'site_form','V4'),(129,'global_debug','0');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=on, 0=off',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (13,'bkash','Bkash',2,'1','{\"type\":\"bkash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720001734_bed271b1089aa12b9887.png\"},\"name\":\"Bkash\",\"status\":\"1\"}'),(20,'nagad','Nagad',3,'1','{\"type\":\"nagad\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717231942_d63fe41b5e42176d4936.png\"},\"name\":\"Nagad\",\"status\":\"1\"}'),(21,'rocket','Rocket',4,'1','{\"type\":\"rocket\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239532_10348cc78dc0b990a8e5.png\"},\"name\":\"Rocket\",\"status\":\"1\"}'),(22,'upay','Upay',5,'1','{\"type\":\"upay\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239551_f0b3a097df92d481e17f.png\"},\"name\":\"Upay\",\"status\":\"1\"}'),(23,'cellfin','Cellfin',6,'1','{\"type\":\"cellfin\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239575_607da191972f326bb061.png\"},\"name\":\"Cellfin\",\"status\":\"1\"}'),(24,'ibl','Islamic Bank',8,'1','{\"type\":\"ibl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719310270_cf7aa34e989a1c87b73b.png\"},\"name\":\"Islamic Bank\",\"status\":\"1\"}'),(25,'bbrac','Brac Bank',15,'1','{\"type\":\"bbrac\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513007_a36d41cb85a2daa5c0d7.png\"},\"name\":\"Brac Bank\",\"status\":\"1\"}'),(26,'basia','Bank Asia',16,'1','{\"type\":\"basia\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513044_27c3590d4bdfcf8e000f.png\"},\"name\":\"Bank Asia\",\"status\":\"1\"}'),(27,'dbbl','DBBL Bank',12,'1','{\"type\":\"dbbl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309653_65205cb7a54698f09f34.png\"},\"name\":\"DBBL Bank\",\"status\":\"1\"}'),(28,'agrani','Agrani Bank',17,'1','{\"type\":\"agrani\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309709_13101fe233cfc95bb28b.png\"},\"name\":\"Agrani Bank\",\"status\":\"1\"}'),(29,'ebl','EBL Bank',14,'1','{\"type\":\"ebl\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719310018_5321255676af2e28a190.png\"},\"name\":\"EBL Bank\",\"status\":\"1\"}'),(30,'basic','Basic Bank',13,'1','{\"type\":\"basic\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309961_62ead36f575ac147ac18.png\"},\"name\":\"Basic Bank\",\"status\":\"1\"}'),(31,'jamuna','Jamuna Bank',18,'1','{\"type\":\"jamuna\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309764_ecf6e5b30fb0d31dd0f2.png\"},\"name\":\"Jamuna Bank\",\"status\":\"1\"}'),(32,'ific','IFIC Bank',19,'1','{\"type\":\"ific\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309900_b9fed4d4912f17f8f310.png\"},\"name\":\"IFIC Bank\",\"status\":\"1\"}'),(33,'sonali','Sonali Bank',11,'1','{\"type\":\"sonali\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717512472_49287598d04a98036bd3.png\"},\"name\":\"Sonali Bank\",\"status\":\"1\"}'),(34,'Ipay','Ipay',24,'1','{\"type\":\"Ipay\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720105981_89786069962c9b386204.webp\"},\"name\":\"Ipay\",\"status\":\"1\"}'),(35,'tap','tap',7,'1','{\"type\":\"tap\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717239652_9e61829d743ec04049e5.png\"},\"name\":\"tap\",\"status\":\"1\"}'),(36,'paypal','Paypal',25,'0','{\"type\":\"paypal\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513660_56a478dea2bf98f3e022.png\"},\"name\":\"Paypal\",\"status\":\"0\"}'),(37,'2checkout','2checkout',26,'0','{\"type\":\"2checkout\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100844_1656c9ab1694ae2459f7.png\"},\"name\":\"2checkout\",\"status\":\"1\"}'),(39,'binance','Binance',20,'1','{\"type\":\"binance\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513584_d7ff0294bf6b6c98db7b.png\"},\"name\":\"Binance\",\"status\":\"1\"}'),(40,'abbank','AB Bank',9,'1','{\"type\":\"abbank\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719309599_b6aac1ea1fb6fa57ffb2.png\"},\"name\":\"AB Bank\",\"status\":\"1\"}'),(41,'citybank','City Bank',10,'1','{\"type\":\"citybank\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717512423_12782dab3a9f260e0c5d.png\"},\"name\":\"City Bank\",\"status\":\"1\"}'),(42,'mastercard','Mastercard',23,'0','{\"type\":\"mastercard\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100801_cffe430721df95dae74b.png\"},\"name\":\"Mastercard\",\"status\":\"1\"}'),(43,'coinbase','Coinbase',22,'0','{\"type\":\"coinbase\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719311214_11838c32962f35810b58.png\"},\"name\":\"Coinbase\",\"status\":\"1\"}'),(44,'payeer','Payeer',21,'1','{\"type\":\"payeer\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1717513731_81f4435ab5365e24f0b6.png\"},\"name\":\"Payeer\",\"status\":\"0\"}'),(45,'surecash','Sure Cash',31,'1','{\"type\":\"surecash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719306582_f4ec8dc3e2a7da47151a.png\"},\"name\":\"Sure Cash\",\"status\":\"1\"}'),(46,'okwallet','Ok Wallet',29,'1','{\"type\":\"okwallet\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719306339_29c6b8d2a1d36349a356.png\"},\"name\":\"Ok Wallet\",\"status\":\"1\"}'),(47,'perfectmoney','Perfect Money',34,'0','{\"type\":\"perfectmoney\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1719311265_24bcdf2b9be294a3c28b.png\"},\"name\":\"Perfect Money\",\"status\":\"1\"}'),(48,'coinpayments','Coinpayments',30,'0','{\"type\":\"coinpayments\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720100760_f9e19f2550433c2aa06a.png\"},\"name\":\"Coinpayments\",\"status\":\"1\"}'),(49,'mcash','MCash',44,'1','{\"type\":\"mcash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720096138_9c15f75876952675f8a0.webp\"},\"name\":\"MCash\",\"status\":\"1\"}'),(51,'easypaisa','Easy Paisa',45,'0','{\"type\":\"easypaisa\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720096060_9cb999b4a54c789d3cea.png\"},\"name\":\"Easy Paisa\",\"status\":\"1\"}'),(52,'mycash','myCash',46,'1','{\"type\":\"mycash\",\"option\":{\"logo\":\"public\\/uploads\\/admin\\/356a192b7913b04c54574d18c28d46e6395428ab\\/1720097170_0d54ea45149671627510.jpeg\"},\"name\":\"myCash\",\"status\":\"1\"}');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` int NOT NULL,
  `device` int NOT NULL,
  `transaction` int NOT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `final_price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `duration` int NOT NULL COMMENT 'number of unit -1 for lifetime',
  `duration_type` int NOT NULL COMMENT '1=day,2=month, 3=year',
  `sort` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (13,'2c7130a39b77eecb03d96e8db85a84b4','15 Days','15 Days',1,1,-1,50.000,10.000,15,1,2,0,'2024-12-18 17:48:41','2026-03-14 23:04:57'),(14,'52cfbba9fbd2eb03b6896fa6604b04f9','Free','Free',5,5,-1,0.000,0.000,365,1,1,1,'2024-12-18 17:56:35','2026-03-14 23:04:57'),(15,'d9733681d4a03e8a645c84f83e24434a','30 Days','২টি ওয়েবসাইট ও ২টি ডিভাইসে ব্যবহার করুন',2,2,-1,150.000,20.000,1,2,3,0,'2024-12-18 18:24:30','2026-03-14 23:04:57'),(17,'4a77b6ef1822b0ec677b524abea2356c','6 Months','২টি ওয়েবসাইট ও ২টি ডিভাইসে ব্যবহার করুন',3,3,-1,499.000,120.000,6,2,4,0,'2024-12-18 21:07:22','2026-03-14 23:04:57'),(19,'d0ae1261dd32af22894975a51fb860c3','12 Months','২টি ওয়েবসাইট ও ৪টি ডিভাইসে ব্যবহার করুন',4,10,-1,799.000,210.000,1,3,5,0,'2024-12-18 21:23:07','2026-03-14 23:04:57');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue`
--

DROP TABLE IF EXISTS `queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `queue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_type` text,
  `task_data` text,
  `status` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue`
--

LOCK TABLES `queue` WRITE;
/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staffs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` varchar(50) NOT NULL,
  `role_id` int DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` text,
  `last_name` text,
  `balance` decimal(10,3) NOT NULL DEFAULT '0.000',
  `more_information` text,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `activation_key` varchar(50) DEFAULT NULL,
  `reset_key` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ids` (`ids`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffs`
--

LOCK TABLES `staffs` WRITE;
/*!40000 ALTER TABLE `staffs` DISABLE KEYS */;
INSERT INTO `staffs` VALUES (1,'admin',1,'admin@cloudman.one','Admin','',0.000,'','public/uploads/admin/356a192b7913b04c54574d18c28d46e6395428ab/1734519891_d9639631de1634bf18bc.png','$2y$10$JI7d/9kAM6NvOtTLERHUTuYL6TDCuXL5y/29w3ZyuodhnoLda4VRC',1,'8RXWHBUAXXB3b7VwW8DOHHgdK','WyeHchQIEDfKRBloGMsAh4e1r7NT4A8F','2024-06-01 14:33:05',NULL,NULL),(2,'0fac80be8e979415ae45159e0dd6e7f6',2,'admin@gmail.com','System','Admin',9999999.999,NULL,NULL,'$2y$10$/fZGD8pRA.1Cddigi9qkZe1QTAsQHcxxQssigkKk1Y.epL5ZEbPli',1,'kkuMjDHZW4djE1Y1TAHtSVQYR','jNumrvBzsT5uSGLFC6gMIsjyNz1Woaqa','2025-06-23 20:20:36','2025-06-23 20:20:36',NULL);
/*!40000 ALTER TABLE `staffs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_transactions`
--

DROP TABLE IF EXISTS `temp_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `brand_id` int unsigned NOT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BDT',
  `request` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GET' COMMENT 'GET or POST',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_transactions_uid_foreign` (`uid`),
  CONSTRAINT `temp_transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_transactions`
--

LOCK TABLES `temp_transactions` WRITE;
/*!40000 ALTER TABLE `temp_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int DEFAULT NULL,
  `template_key` varchar(120) DEFAULT NULL,
  `email_from` varchar(191) NOT NULL DEFAULT 'support@example.com',
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `template` text,
  `sms_body` text,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `sms_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_messages`
--

DROP TABLE IF EXISTS `ticket_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_id` int unsigned NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `support` tinyint NOT NULL COMMENT '1=support, 0=client',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_messages`
--

LOCK TABLES `ticket_messages` WRITE;
/*!40000 ALTER TABLE `ticket_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_user_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_uid_foreign` (`uid`),
  CONSTRAINT `tickets_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `brand_id` int DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_uid_foreign` (`uid`),
  CONSTRAINT `transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_coupons`
--

DROP TABLE IF EXISTS `user_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_coupons` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `coupon_id` int DEFAULT NULL,
  `plan_id` int DEFAULT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `discount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_coupons`
--

LOCK TABLES `user_coupons` WRITE;
/*!40000 ALTER TABLE `user_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notifier`
--

DROP TABLE IF EXISTS `user_notifier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_notifier` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '0=>mail, 1=>sms',
  `medium` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mobile number or email',
  `status` tinyint DEFAULT NULL,
  `charge` float DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_notifier_uid_foreign` (`uid`),
  CONSTRAINT `user_notifier_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notifier`
--

LOCK TABLES `user_notifier` WRITE;
/*!40000 ALTER TABLE `user_notifier` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notifier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_payment_settings`
--

DROP TABLE IF EXISTS `user_payment_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_payment_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `brand_id` int NOT NULL,
  `g_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_payment_settings_uid_foreign` (`uid`),
  CONSTRAINT `user_payment_settings_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_payment_settings`
--

LOCK TABLES `user_payment_settings` WRITE;
/*!40000 ALTER TABLE `user_payment_settings` DISABLE KEYS */;
INSERT INTO `user_payment_settings` VALUES (21,1,8,'bkash','mobile',1,'{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\",\"payment\":\"0\"},\"personal_number\":\"\",\"payment_number\":\"\",\"agent_number\":\"\",\"sandbox\":\"0\",\"logs\":\"0\",\"username\":\"\",\"password\":\"\",\"app_key\":\"\",\"app_secret\":\"\"}','2024-12-07 11:37:06',NULL),(22,1,8,'nagad','mobile',1,'{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"nagad_mode\":\"live\",\"merchant_id\":\"\",\"private_key\":\"\",\"public_key\":\"\"}','2024-12-07 11:37:17',NULL),(23,1,8,'rocket','mobile',1,'{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"merchant_url\":\"\"}','2024-12-07 11:37:25',NULL),(24,1,8,'upay','mobile',1,'{\"status\":\"1\",\"brand_id\":\"8\",\"active_payments\":{\"personal\":\"0\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"\",\"agent_number\":\"\",\"merchant_id\":\"\",\"merchant_key\":\"\",\"merchant_code\":\"\",\"merchant_name\":\"\"}','2024-12-07 11:37:34',NULL);
/*!40000 ALTER TABLE `user_payment_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_payouts`
--

DROP TABLE IF EXISTS `user_payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_payouts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `g_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `charge` decimal(10,3) NOT NULL DEFAULT '0.000',
  `net_amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_payouts_uid_foreign` (`uid`),
  CONSTRAINT `user_payouts_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_payouts`
--

LOCK TABLES `user_payouts` WRITE;
/*!40000 ALTER TABLE `user_payouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_payouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_plans`
--

DROP TABLE IF EXISTS `user_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_plans` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uid` int unsigned NOT NULL,
  `plan_id` int NOT NULL,
  `price` decimal(10,3) NOT NULL DEFAULT '0.000',
  `brand` int NOT NULL,
  `device` int NOT NULL,
  `transaction` int NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_plans_uid_foreign` (`uid`),
  CONSTRAINT `user_plans_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_plans`
--

LOCK TABLES `user_plans` WRITE;
/*!40000 ALTER TABLE `user_plans` DISABLE KEYS */;
INSERT INTO `user_plans` VALUES (20,1,7,1500.000,10,15,-1,'','2027-02-12 18:36:07','2024-12-07 11:17:25','2024-12-07 11:17:25',NULL);
/*!40000 ALTER TABLE `user_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `permissions` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'Admin','{\"id\":\"14\",\"name\":\"Admin\",\"dashboard_statistics\":\"on\",\"dashboard_bar_chart\":\"on\",\"dashboard_latest_transactions\":\"on\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_edit_user\":\"on\",\"user_add_fund_user\":\"on\",\"user_send_mail_user\":\"on\",\"user_detail_user\":\"on\",\"user_access_transaction\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"invoice_edit_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"device_access_device\":\"on\",\"device_edit_device\":\"on\",\"plan_access_plan\":\"on\",\"plan_access_user_plan\":\"on\",\"plan_add_plan\":\"on\",\"plan_edit_plan\":\"on\",\"setting_access_setting\":\"on\",\"setting_access_payment_setting\":\"on\",\"setting_access_faq\":\"on\",\"setting_access_coupon\":\"on\",\"setting_add_coupon\":\"on\",\"setting_edit_coupon\":\"on\",\"setting_access_blog\":\"on\",\"setting_developer\":\"on\",\"setting_access_tickets\":\"on\",\"setting_databackup\":\"on\"}',NULL),(2,'Owner','{\"id\":\"\",\"name\":\"Owner\",\"dashboard_statistics\":\"on\",\"dashboard_bar_chart\":\"on\",\"dashboard_latest_transactions\":\"on\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_edit_user\":\"on\",\"user_delete_user\":\"on\",\"user_view_user\":\"on\",\"user_add_fund_user\":\"on\",\"user_send_mail_user\":\"on\",\"user_set_password_user\":\"on\",\"user_detail_user\":\"on\",\"user_access_transaction\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"invoice_edit_invoice\":\"on\",\"invoice_delete_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"domain_delete_domain\":\"on\",\"device_access_device\":\"on\",\"device_edit_device\":\"on\",\"device_delete_device\":\"on\",\"plan_access_plan\":\"on\",\"plan_access_user_plan\":\"on\",\"plan_add_plan\":\"on\",\"plan_edit_plan\":\"on\",\"plan_delete_plan\":\"on\",\"setting_access_setting\":\"on\",\"setting_access_payment_setting\":\"on\",\"setting_access_staff\":\"on\",\"setting_access_role\":\"on\",\"setting_acess_activity\":\"on\",\"setting_access_faq\":\"on\",\"setting_access_coupon\":\"on\",\"setting_add_coupon\":\"on\",\"setting_edit_coupon\":\"on\",\"setting_delete_coupon\":\"on\",\"setting_access_blog\":\"on\",\"setting_developer\":\"on\",\"setting_access_tickets\":\"on\",\"setting_databackup\":\"on\"}',NULL),(3,'Support Operator','{\"id\":\"17\",\"name\":\"Support Operator\",\"user_access_user\":\"on\",\"user_add_user\":\"on\",\"user_add_fund_user\":\"on\",\"invoice_access_invoice\":\"on\",\"invoice_view_invoice\":\"on\",\"invoice_add_invoice\":\"on\",\"domain_access_domain\":\"on\",\"domain_edit_domain\":\"on\",\"device_access_device\":\"on\",\"plan_access_user_plan\":\"on\"}',NULL);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_transactions`
--

DROP TABLE IF EXISTS `user_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int unsigned NOT NULL,
  `information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,3) NOT NULL DEFAULT '0.000',
  `currency` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pending,1=initiated,2=success,3=cancel',
  `transaction_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_transactions_uid_foreign` (`uid`),
  CONSTRAINT `user_transactions_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_transactions`
--

LOCK TABLES `user_transactions` WRITE;
/*!40000 ALTER TABLE `user_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ids` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` text,
  `last_name` text,
  `phone` varchar(20) NOT NULL,
  `balance` decimal(10,3) NOT NULL DEFAULT '0.000',
  `more_information` text,
  `avatar` varchar(255) DEFAULT NULL,
  `api_credentials` text,
  `timezone` text,
  `ref_id` int NOT NULL,
  `ref_key` text,
  `addons` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `activation_key` varchar(50) DEFAULT NULL,
  `reset_key` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ids` (`ids`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=378 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1d8b34f05b1f18ef7c00f290cdfd199a','admin@cloudman.one','$2y$10$l/2q34XIGHRZr0ojAl8yGOj28S8X6a9Be2KFEmiSFYLvcDd/pcwUC','R Lab BD','Digital','01889298798',8500.000,'Admin','public/uploads/user/356a192b7913b04c54574d18c28d46e6395428ab/1746806013_f5bd82cfd5cec3190852.png',NULL,NULL,0,'bdfae46efb101d38f5f9d1bc7a9c2fca',NULL,1,'K1xKf110lm6H3XT7pnJtuPsjC','lUNRut1mQxzFQUKOeV5yaYVzTaic6jMx','2024-12-07 11:12:50','2024-12-07 11:15:58',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webhook_events`
--

DROP TABLE IF EXISTS `webhook_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webhook_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `webhook_id` int unsigned NOT NULL,
  `event` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json DEFAULT NULL,
  `status` enum('pending','delivered','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `attempts` tinyint unsigned NOT NULL DEFAULT '0',
  `last_attempt_at` datetime DEFAULT NULL,
  `response_code` smallint DEFAULT NULL,
  `response_body` text COLLATE utf8mb4_unicode_ci,
  `next_retry_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_webhook_id` (`webhook_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webhook_events`
--

LOCK TABLES `webhook_events` WRITE;
/*!40000 ALTER TABLE `webhook_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `webhook_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webhooks`
--

DROP TABLE IF EXISTS `webhooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webhooks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` int unsigned NOT NULL,
  `merchant_id` int unsigned NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `events` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_triggered_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_brand_merchant` (`brand_id`,`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webhooks`
--

LOCK TABLES `webhooks` WRITE;
/*!40000 ALTER TABLE `webhooks` DISABLE KEYS */;
INSERT INTO `webhooks` VALUES (3,8,1,'https://microscrop.shop/index.php/wp-json/qpay/v1/webhook','whsec_722180ad15adff4c5907cca5ff407eb75f474ab4aa427498','[\"*\", \"payment.created\", \"payment.completed\", \"payment.failed\", \"refund.created\"]',1,NULL,'2026-04-19 00:14:21','2026-04-19 00:14:21',NULL);
/*!40000 ALTER TABLE `webhooks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-19  0:46:18
