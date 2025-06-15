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
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `image_url` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (34,'The Journey of Light: From Stars to Our Eyes','When we look up at the night sky and admire the twinkling stars, we are actually peering into the past. The light from stars takes years — even millions of years — to reach Earth. The nearest star to us, the Sun, sends light that takes about 8 minutes to arrive. But more distant stars can be thousands of light-years away.\r\n\r\nThis means that what we see in the sky is a snapshot of the stars as they were in the past. Some stars may have already died, but their light is still traveling toward us. It’s a fascinating idea — the universe is not just a place, but a timeline captured in beams of light.\r\n\r\nUnderstanding the journey of light not only helps astronomers measure the distances between celestial bodies, but it also opens a window into the evolution of the cosmos, from the distant past to the present.\r\n\r\n','img_684d130f986c64.41158891.jpg','2025-06-08 14:18:13'),(35,'Black Holes – Invisible Yet Unmissable Mysteries','Black holes are formed when massive stars collapse under their own gravity after running out of fuel. Without sufficient outward pressure, the core collapses into a point where gravity becomes so intense that nothing—not even light—can escape. This makes black holes completely invisible to the naked eye.\r\n\r\nHowever, astronomers can detect them by observing how nearby matter behaves—such as glowing gas spiraling inward or stars orbiting an invisible center. Some supermassive black holes exist at the center of galaxies, including our Milky Way. The first-ever image of a black hole’s shadow, captured in 2019, marked a new era in studying these extreme cosmic entities.\r\n\r\n','img_684d1303dfaf87.25502160.jpg','2025-06-08 14:23:40'),(36,'Neutron Stars – Tiny Stars with Colossal Power','When a massive star explodes in a supernova, the remaining core may compress into a neutron star—one of the densest known objects in the universe. These stars are just about 20 km in diameter but can contain as much mass as our Sun. The density is so high that a single teaspoon of neutron star material could weigh hundreds of millions of tons.\r\n\r\nThey often spin rapidly, sometimes hundreds of times per second, and possess extremely strong magnetic fields. Some neutron stars emit regular radio pulses—known as pulsars—acting like cosmic lighthouses. Studying neutron stars helps scientists understand matter under extreme conditions and test the limits of physics.','img_684d12fabd5498.54526403.jpg','2025-06-08 14:24:25'),(37,'The Milky Way – A Spiral Masterpiece of Billions of Stars','The Milky Way is the galaxy where Earth resides. It\'s a spiral galaxy, with tightly wound arms surrounding a dense core of billions of stars. It’s estimated to contain 100–400 billion stars, along with countless planetary systems.\r\n\r\nEarth is located on the outskirts of the Orion Arm, about 27,000 light-years from the galactic center. Scientists have used radio and infrared telescopes to map the 3D structure of the Milky Way and discover vast “stellar highways.” Understanding our own galaxy is fundamental to exploring others and discovering our place in the universe.\r\n\r\n','img_684d12f09c6ae8.78050642.jpg','2025-06-08 14:25:18'),(38,'The Most Earth-like Exoplanet Beyond Our Solar System – Kepler-452b','Kepler-452b is an exoplanet discovered by the Kepler Space Telescope, located about 1,400 light-years away from Earth. It is one of the first planets identified to have a size and orbital position very similar to Earth, residing in the \"habitable zone\" of its host star, where liquid water could potentially exist on the planet’s surface.\r\n\r\nWith a radius approximately 1.6 times that of Earth, Kepler-452b may have an atmosphere and surface temperatures suitable for maintaining liquid water — a crucial factor for life as we know it. This planet orbits a star very similar to our Sun, which further increases its resemblance and the potential for sustaining life.\r\n\r\nAlthough there is no direct evidence of life on Kepler-452b, scientists are highly interested in studying and learning more about Earth-like planets beyond our Solar System. Discovering planets like Kepler-452b broadens our understanding of the universe and the possibility of life existing in other star systems.\r\n\r\nIn the future, with more advanced observation technologies, we may find many more similar planets and even detect signs of life beyond Earth, ushering in a new era for humanity in exploring the cosmos.\r\n\r\n','img_684d14d28bee42.27212673.jpg','2025-06-09 02:48:07');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-15 14:49:11
