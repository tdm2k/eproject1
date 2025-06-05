-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: eproject1
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `observatories`
--

DROP TABLE IF EXISTS `observatories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `observatories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `location` text,
  `description` text,
  `image_url` varchar(2083) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `observatories`
--

LOCK TABLES `observatories` WRITE;
/*!40000 ALTER TABLE `observatories` DISABLE KEYS */;
INSERT INTO `observatories` VALUES (10,'Einstein Tower','Albert-Einstein-Straße 1, 14473 Potsdam, Germany','Among the buildings named after the great German physicist, the Einstein Tower (or Einsteinturm in German) is perhaps the most impressive. Located in the Albert Einstein Science Park in Potsdam, Germany, the tower was completed in 1921 and designed by architect Erich Mendelsohn. It houses a special solar telescope created by astronomer Erwin Finlay-Freundlich to test Einstein’s theory of relativity.','assets/observatories/observatory_683860f7687d5.jpg'),(11,'Fabra Observatory','Carrer de l&amp;#039;Observatori, s/n, 08035 Barcelona, Spain','Located in a modernist palace, the Fabra Observatory (Observatori Fabra) is operated by the Royal Academy of Sciences and Arts of Barcelona. Perched atop Mount Tibidabo in Barcelona at an altitude of over 400 meters, Fabra has served as a center for meteorological, seismological, and astronomical research since 1904.','assets/observatories/observatory_683864442410d.jpg'),(12,'Griffith Observatory','2800 East Observatory Road Los Angeles, CA 90027, United States','Located in the park of the same name in Los Angeles, USA, the Griffith Observatory houses numerous models of the universe and telescopes, including a 30 cm aperture Zeiss refracting telescope. The building is situated at an elevation of over 345 meters above sea level.','assets/observatories/observatory_683864b352a35.jpg'),(13,'Kitt Peak National Observatory','Arizona State Route 386, Kitt Peak, Arizona 85634, United States','The world’s largest collection of astronomical instruments belongs to the Kitt Peak National Observatory located in the Sonoran Desert of Arizona, USA. Kitt Peak is home to over 20 telescopes, including the McMath-Pierce Solar Telescope, the largest solar telescope in the world.','assets/observatories/observatory_683865060434e.jpg'),(14,'Palomar Observatory','35899 Canfield Road Palomar Mountain, California 92060, United States','Palomar Observatory is located in northern San Diego County, California, USA, and is often called the &amp;quot;Cathedral of Astronomy.&amp;quot; Established in 1928, Palomar houses the &amp;quot;Giant Eye,&amp;quot; a telescope with an aperture of over 500 cm, which was the largest telescope in the world for several decades.','assets/observatories/observatory_6838668d0bc80.jpg'),(15,'Parkes Observatory','Parkes, New South Wales 2870, Australia','The Parkes Observatory in Australia is famous for its 64-meter wide radio telescope, which received live images from the Apollo 11 spacecraft’s Moon landing in 1969.','assets/observatories/observatory_683866beca318.jpg'),(16,' Pic du Midi Observatory','Observatoire Midi-Pyrénées, 65270 Saint-Lary-Soulan, France','Located at nearly 2,900 meters high in the Pyrenees Mountains of France, the Pic du Midi Observatory is also the highest museum in Europe. It was used by scientists to study the surface of the Moon prior to the Apollo spacecraft landing.','assets/observatories/observatory_683866f507333.jpg'),(17,'Nha Trang Observatory','2C Nguyễn Thị Minh Khai, Vĩnh Phước, Nha Trang, Khánh Hòa, Vietnam','The Nha Trang Observatory (abbreviated as NTO) is one of two observatories built under the project of the Vietnam National Space Center (VNSC). Construction began in 2015 and was completed in August 2017. The city of Nha Trang has planned to include the observatory as part of its tourist itinerary for visitors coming to the city for leisure and tourism.','assets/observatories/observatory_68386a1d3960a.jpg');
/*!40000 ALTER TABLE `observatories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-05 10:49:00
