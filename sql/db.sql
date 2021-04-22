
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
DROP TABLE IF EXISTS `balance_of_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance_of_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pharmacies_id` int(11) NOT NULL,
  `drugs_drugs_characteristics_link_id` int(11) NOT NULL,
  `balance` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drugs_drugs_characteristics_link_id` (`drugs_drugs_characteristics_link_id`),
  KEY `pharmacies_id` (`pharmacies_id`),
  CONSTRAINT `balance_of_goods_ibfk_2` FOREIGN KEY (`drugs_drugs_characteristics_link_id`) REFERENCES `drugs_drugs_characteristics_link` (`id`),
  CONSTRAINT `balance_of_goods_ibfk_3` FOREIGN KEY (`pharmacies_id`) REFERENCES `pharmacies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='остаток товаров';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `balance_of_goods` WRITE;
/*!40000 ALTER TABLE `balance_of_goods` DISABLE KEYS */;
INSERT INTO `balance_of_goods` VALUES (1,1,2,10),(2,1,3,10),(5,3,7,11),(6,10,10,5),(7,6,6,4),(8,7,3,5),(9,6,7,2),(10,1,9,14),(11,2,3,322),(13,2,4,1),(18,4,1,555);
/*!40000 ALTER TABLE `balance_of_goods` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_name` varchar(255) NOT NULL COMMENT 'торговое название препарата',
  `international_name` varchar(255) NOT NULL COMMENT 'международное непатентованное название',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='препараты';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` VALUES (2,'анальгин',' Метамизол натрий'),(3,'Парацетамол Велфарм','Парацетамол'),(4,'Пенталгин','Пенталгин'),(5,'Ибупрофен','Ибупрофен'),(6,'Арбидол','Умифеновир'),(7,'Фервекс','Парацетамол + Фенирамин + Аскорбиновая кислота'),(8,'Антигриппин','Парацетамол + Хлорфенамин + Аскорбиновая кислота'),(9,'Ингавирин','имидазолилэтанамид пентандиовой кислоты'),(10,'Анаферон','нет');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `drugs_characteristics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs_characteristics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_of_issue` varchar(40) NOT NULL COMMENT 'форма выпуска',
  `dosage` varchar(40) NOT NULL COMMENT 'дозировка',
  `cost` decimal(10,2) NOT NULL COMMENT 'цена',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='характеристики препаратов';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `drugs_characteristics` WRITE;
/*!40000 ALTER TABLE `drugs_characteristics` DISABLE KEYS */;
INSERT INTO `drugs_characteristics` VALUES (2,'раствор для внутривенного введения','0,5 мг',322.00),(3,'суппозитории ректальные','1 шт',300.00),(4,'таблетки','1 шт',200.00),(5,'суспензия','5 мг',500.00),(6,'таблетки','3 шт\\день',435.00),(7,'раствор для внутривенного введения','2 мг\\2 раза в день',500.00),(8,'сироп','125 мг/5 мл',354.00),(9,'таблетки','3 шт\\день',645.00),(10,'сироп','100 мг/5 мл',300.00),(11,'капсулы','3 шт\\день',754.00);
/*!40000 ALTER TABLE `drugs_characteristics` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `drugs_drugs_characteristics_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs_drugs_characteristics_link` (
  `drugs_id` int(11) NOT NULL,
  `drugs_characteristics_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `drugs_id` (`drugs_id`),
  KEY `drugs_characteristics_id` (`drugs_characteristics_id`),
  CONSTRAINT `drugs_drugs_characteristics_link_ibfk_5` FOREIGN KEY (`drugs_id`) REFERENCES `drugs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `drugs_drugs_characteristics_link_ibfk_6` FOREIGN KEY (`drugs_characteristics_id`) REFERENCES `drugs_characteristics` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `drugs_drugs_characteristics_link` WRITE;
/*!40000 ALTER TABLE `drugs_drugs_characteristics_link` DISABLE KEYS */;
INSERT INTO `drugs_drugs_characteristics_link` VALUES (2,2,1),(2,9,2),(3,9,3),(4,2,4),(4,10,5),(6,9,6),(7,5,7),(8,4,8),(9,11,9),(10,4,10);
/*!40000 ALTER TABLE `drugs_drugs_characteristics_link` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `drugs_drugs_indications_for_use_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs_drugs_indications_for_use_link` (
  `drugs_id` int(11) NOT NULL,
  `drugs_indications_for_use_id` int(11) NOT NULL,
  PRIMARY KEY (`drugs_id`,`drugs_indications_for_use_id`),
  KEY `drugs_indications_for_use_id` (`drugs_indications_for_use_id`),
  CONSTRAINT `drugs_drugs_indications_for_use_link_ibfk_4` FOREIGN KEY (`drugs_id`) REFERENCES `drugs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `drugs_drugs_indications_for_use_link_ibfk_5` FOREIGN KEY (`drugs_indications_for_use_id`) REFERENCES `drugs_indications_for_use` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `drugs_drugs_indications_for_use_link` WRITE;
/*!40000 ALTER TABLE `drugs_drugs_indications_for_use_link` DISABLE KEYS */;
INSERT INTO `drugs_drugs_indications_for_use_link` VALUES (2,1),(2,10),(4,2),(4,3),(4,4),(4,5),(5,6),(5,7),(5,8),(5,9),(5,10),(5,11),(8,5);
/*!40000 ALTER TABLE `drugs_drugs_indications_for_use_link` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `drugs_indications_for_use`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs_indications_for_use` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indication` text NOT NULL COMMENT 'показания к применению',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='показания к применению лекарств';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `drugs_indications_for_use` WRITE;
/*!40000 ALTER TABLE `drugs_indications_for_use` DISABLE KEYS */;
INSERT INTO `drugs_indications_for_use` VALUES (1,'Болевой синдром слабой и умеренной интенсивности различного генеза (в т.ч. головная боль, мигрень, зубная боль, невралгия, миалгия, альгодисменорея; боль при травмах, ожогах). Лихорадка при инфекционно-воспалительных заболеваниях.'),(2,'Болевой синдром различного генеза (почечная и желчная колика, невралгия, миалгия; при травмах, ожогах, после операций; головная боль, зубная боль, меналгии). Лихорадка при инфекционно-воспалительных заболеваниях.'),(3,'болевой синдром, связанный со спазмом гладкой мускулатуры, в т.ч. при хроническом холецистите, желчнокаменной болезни, постхолецистэктомическом синдроме, почечной колике;'),(4,'посттравматический и послеоперационный болевой синдром, в т.ч. сопровождающийся воспалением;'),(5,'простудные заболевания, сопровождающиеся лихорадочным синдромом (в качестве симптоматической терапии).'),(6,'Симптоматическое лечение головной боли напряжения и мигрени'),(7,'Симптоматическое лечение суставной, мышечной боли'),(8,'Симптоматическое лечение зубной боли'),(9,'Симптоматическое лечение боли в спине, пояснице, радикулита'),(10,'Симптоматическое лечение лихорадочных состояниях при простудных заболеваниях, гриппе'),(11,'Симптоматическое лечениеревматоидного артрита, остеоартроза');
/*!40000 ALTER TABLE `drugs_indications_for_use` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `drugs_drugs_characteristics_link_id` int(11) NOT NULL,
  `count` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drugs_drugs_characteristics_link_id` (`drugs_drugs_characteristics_link_id`),
  KEY `orders_id` (`orders_id`),
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`drugs_drugs_characteristics_link_id`) REFERENCES `drugs_drugs_characteristics_link` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,1,2,2),(2,1,4,1),(3,2,2,1),(4,3,7,1),(5,4,6,1),(6,5,8,1),(7,6,8,1),(9,8,2,2),(10,9,4,2),(11,10,9,2),(13,20,2,1),(14,21,2,1),(15,23,2,4),(16,24,2,4),(17,24,1,1),(18,25,2,4),(19,25,1,1),(20,26,1,1),(21,26,2,1),(22,27,2,1),(23,28,2,1),(24,29,2,1),(25,30,2,1),(26,31,2,1),(27,32,2,1),(28,33,2,1),(29,34,2,1),(30,35,2,1),(32,37,2,1),(33,38,2,1),(34,39,2,1),(35,40,2,1),(36,41,2,1),(37,42,2,1),(38,43,2,1),(39,44,2,1),(40,45,1,1),(43,45,3,2),(44,45,5,2),(45,47,10,1),(46,48,1,1),(47,49,1,1),(48,50,1,1),(49,51,1,1),(50,52,1,1),(51,53,1,1),(52,54,1,1),(53,55,1,1),(54,57,1,1),(55,58,1,1),(57,60,1,1),(58,61,1,1),(63,66,1,1),(64,66,2,1),(65,68,1,1),(66,68,2,1),(67,69,1,1),(68,69,2,1),(69,70,1,1),(70,70,2,1),(71,71,1,1),(72,71,2,1),(73,72,1,1),(74,72,2,1),(75,73,1,1),(76,73,2,1),(79,76,1,1),(80,76,2,1),(81,77,1,1),(82,77,2,1),(83,78,1,2),(84,78,2,2);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='заказы';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'2021-03-18'),(2,3,'2021-03-19'),(3,4,'2021-03-18'),(4,5,'2021-03-19'),(5,10,'2021-03-19'),(6,8,'2021-03-16'),(8,8,'2021-03-16'),(9,9,'2021-03-17'),(10,7,'2021-03-18'),(20,1,'2021-03-31'),(21,1,'2021-03-31'),(23,1,'2021-04-01'),(24,1,'2021-04-01'),(25,1,'2021-04-01'),(26,1,'2021-04-01'),(27,1,'2021-04-01'),(28,1,'2021-04-01'),(29,1,'2021-04-01'),(30,2,'2021-04-02'),(31,1,'2021-04-02'),(32,1,'2021-04-02'),(33,1,'2021-04-02'),(34,1,'2021-04-02'),(35,1,'2021-04-02'),(37,1,'2021-04-02'),(38,1,'2021-04-02'),(39,1,'2021-04-02'),(40,1,'2021-04-02'),(41,1,'2021-04-02'),(42,1,'2021-04-02'),(43,1,'2021-04-02'),(44,1,'2021-04-02'),(45,2,'2021-04-05'),(47,1,'2021-04-12'),(48,1,'2021-04-13'),(49,1,'2021-04-13'),(50,1,'2021-04-13'),(51,1,'2021-04-13'),(52,1,'2021-04-13'),(53,1,'2021-04-13'),(54,1,'2021-04-13'),(55,1,'2021-04-13'),(57,1,'2021-04-13'),(58,1,'2021-04-13'),(60,1,'2021-04-13'),(61,1,'2021-04-13'),(66,1,'2021-04-13'),(68,1,'2021-04-13'),(69,1,'2021-04-13'),(70,1,'2021-04-13'),(71,1,'2021-04-13'),(72,1,'2021-04-13'),(73,1,'2021-04-13'),(76,1,'2021-04-13'),(77,1,'2021-04-14'),(78,1,'2021-04-14');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pharmacies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmacies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='аптеки';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pharmacies` WRITE;
/*!40000 ALTER TABLE `pharmacies` DISABLE KEYS */;
INSERT INTO `pharmacies` VALUES (1,'Аптека №1','Г. Воронеж'),(2,'Аптека №1(2)','Г. Воронеж'),(3,'Аптека №2','Г. Воронеж'),(4,'Аптека №3','Г. Воронеж'),(5,'Аптека №4','Г. Воронеж'),(6,'Аптека №5','Г. Воронеж'),(7,'Аптека №6','Г. Воронеж'),(8,'Аптека №7','Г. Воронеж'),(9,'Аптека №8','Г. Воронеж'),(10,'Аптека №9','Г. Воронеж');
/*!40000 ALTER TABLE `pharmacies` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `patronymic` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='пользователи';
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Текутьев','Андрей','Андреевич','andrey@mail.ru','$2y$13$W8vDKS/5mScd395hTm5qvuf2EhpbkvS7ibojh1BFjx5pCIKEm2UVC',1,'AI9JS7Z9gy_ZPuqK3RQp-5IjZpJAyN21'),(2,'Иванов','Иван','Иванович','ivan@mail.ru','$2y$13$W8vDKS/5mScd395hTm5qvuf2EhpbkvS7ibojh1BFjx5pCIKEm2UVC',0,'eQ3y_av3RUfKuWKsS5ADIxOsarWP8K0k'),(3,'Иванов2','Иван','Иванович','ivan2@mail.ru','$2y$13$W8vDKS/5mScd395hTm5qvuf2EhpbkvS7ibojh1BFjx5pCIKEm2UVC',0,NULL),(4,'Иванов3','Иван','Иванович','ivan3@mail.ru','$2y$13$W8vDKS/5mScd395hTm5qvuf2EhpbkvS7ibojh1BFjx5pCIKEm2UVC',0,NULL),(5,'Иванов4','Иван','Иванович','ivan4@mail.ru','d297e83e2e5f779905b98aad87a8e59d539272fc',0,NULL),(6,'Иванов5','Иван','Иванович','ivan5@mail.ru','d297e83e2e5f779905b98aad87a8e59d539272fc',0,NULL),(7,'Иванов6','Иван','Иванович','ivan6@mail.ru','d297e83e2e5f779905b98aad87a8e59d539272fc',0,NULL),(8,'Иванов7','Иван','Иванович','ivan71@mail.ru','d297e83e2e5f779905b98aad87a8e59d539272fc',0,NULL),(9,'Иванов8','Иван','Иванович','ivan8@mail.ru','d297e83e2e5f779905b98aad87a8e59d539272fc',0,NULL),(10,'Иванов9','Иван9','Иванович9','ivan99@mail.ru','$2y$13$r3hlLd0zujXny8PNa8xkxeOYDMgxGx7U2w5R8cxS3moznznqCUMZO',0,'C7OLGF05o92KNtVT1G97V1be7s3MsYIu'),(19,'Иванов999','Иван999','Иванович999','ivan999@mail.ru','$2y$13$XlwOefYd.vLFG0XJz/T9yO4RfUNx64bVafJ3Jp2hn1xKhfaWsTOuK',0,'Mwg86U1_L8ttIDJGxE3zoCoZG64lc10V'),(20,'Иванов123','Иван123','Иванович123','ivan123@mail.ru','$2y$13$y2J7Lv6pRtVabWUNC2gPuOFgrUEDVzBn65kuD6GqONXoEPLsjl8Zm',0,'UhaEv-LbzP_ujYH3JJbfR2osGY0L4_Gg'),(24,'Андреев','Андрей','Иванович','andrey111@mail.ru','$2y$13$G6hHSLCjHDOXoEf4YxUHd.y0ckNekmUpzVUTXJ.LKhuxBYCmFXgfm',0,NULL),(25,'Иванов','Андрей','Иванович','ivan712311@mail.ru','$2y$13$82YdEKsjA2BHV3oPvp0BUuY/5tZIHiHVhdULOV.9XhoPnHRpWZqFC',0,NULL);
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

