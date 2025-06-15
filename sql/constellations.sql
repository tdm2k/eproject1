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
-- Table structure for table `constellations`
--

DROP TABLE IF EXISTS `constellations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `constellations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `category_id` int DEFAULT NULL,
  `image` text,
  `notable_stars` text,
  `position` varchar(255) DEFAULT NULL,
  `legend` text,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `constellations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `constellations`
--

LOCK TABLES `constellations` WRITE;
/*!40000 ALTER TABLE `constellations` DISABLE KEYS */;
INSERT INTO `constellations` VALUES (16,'Aries','Aries is the first constellation of the Zodiac, appearing prominently in the northern sky during spring. It symbolizes beginnings, energy, and courage. Though relatively small, Aries stands out with three bright stars forming the ram’s head. Although it no longer marks the vernal equinox, it remains significant in astrology and Western culture. Astronomically, Aries helps in determining seasonal time and c',2,'684d24ba6dc8a_Ames.jpg','Hamal','3h 15m, +20°','In Greek mythology, Aries is the golden ram sent by Zeus to rescue the brothers Phrixus and Helle from danger. After completing its mission, the ram was sacrificed, and its golden fleece became a sacred relic. Zeus honored the ram’s bravery by placing it in the sky, symbolizing courage, sacrifice, and new beginnings.\r\n\r\n'),(17,'Taurus','Taurus is one of the most recognizable constellations, featuring the Hyades star cluster forming the bull’s face and the nearby Pleiades cluster. It is best visible in winter in the northern hemisphere. With the bright Aldebaran star, Taurus is a frequent subject in astronomy and astrology.',2,'684d27555cd62_Taurus.jpg','Aldebaran','4h 30m, +15°','In mythology, Taurus represents Zeus in the form of a white bull who abducted the princess Europa. When Europa climbed onto the bull’s back, Zeus swam across the sea to the island of Crete. The story symbolizes the allure and power of love.'),(18,'Gemini','Gemini consists of two bright stars, Castor and Pollux, representing the twin brothers in Greek mythology. It is a prominent winter constellation, located near Orion. The main stars form two parallel lines resembling two people standing side by side.',2,'684d2657e5ecb_gemini.jpg','Castor and Pollux','7h 0m, +20°','Castor was mortal, Pollux immortal. When Castor died, Pollux begged Zeus to share his immortality with his brother. Zeus was moved and placed both in the sky as the Gemini twins — symbols of brotherly love and sacrifice.'),(19,'Cancer','Cancer is one of the faintest zodiac constellations. It lies between Gemini and Leo and has an indistinct shape but contains the famous Beehive Cluster (Praesepe). This constellation is hard to observe in cities due to its dim stars.',2,'684d24f9df5ac_cancer.jpg','Beta Cancri','9h 0m, +20°','In mythology, the crab Cancer was sent by Hera to distract Hercules during his fight with the Hydra. Though crushed by Hercules, Hera honored the crab’s loyalty by placing it in the sky.'),(20,'Leo','Leo is one of the largest and most prominent constellations in the night sky. It resembles a lion lying down, with Regulus as its brightest star at the lion’s heart. Leo symbolizes strength, royalty, and confidence.',2,'684d26664d315_leo.jpg','Regulus','10h 30m, +10°','Leo is the Nemean lion of Greek myth, an invincible beast defeated by Hercules in one of his twelve labors. After its defeat, Zeus placed the lion in the sky to commemorate the heroic feat.\r\n\r\n'),(21,'Virgo','Virgo is the second largest constellation and one of the most iconic, often depicted as a maiden holding a sheaf of wheat. Spica, its brightest star, represents a grain or abundance.\r\n\r\n',2,'684d272907226_virgo.jpg','Spica','13h 20m, -10°','Virgo is associated with Demeter, the goddess of harvest, or Astraea, the goddess of justice. When humanity became corrupt, Astraea ascended to the heavens, symbolizing purity and justice.\r\n\r\n'),(22,'Libra','Libra is the only zodiac sign representing an inanimate object — the scales. It is small with no very bright stars but is known for its balanced shape. Libra symbolizes fairness, balance, and law.',2,'684d2678df2fb_libra.jpg','Zubenelgenubi','15h 20m, -15°','Libra was once part of Scorpio’s claws but was separated to represent justice. Some myths link it to Astraea’s scales.\r\n\r\n'),(23,'Scorpius','Scorpius is one of the most distinctive constellations, shaped like a scorpion with a curved tail. Antares, the “heart of the scorpion,” is a bright red star. It is prominent in summer skies.',2,'684d24ccac860_scorpion.jpg','Antares','16h 55m, -30°','Hera sent the scorpion to kill Orion due to his arrogance. After Orion’s death, both were placed in the sky on opposite sides, so when Scorpius rises, Orion sets.\r\n\r\n'),(24,'Sagittarius','Sagittarius represents the archer, often depicted as a centaur drawing a bow. It lies near the center of the Milky Way and contains many star clusters and nebulae.',2,'684d268a39abc_saugitarus.jpg','Kaus Australis','19h 0m, -25°','Sagittarius is associated with Chiron, the wise centaur who taught many heroes. After being wounded and unable to die, Chiron asked Zeus to remove his immortality, who then placed him in the sky.\r\n\r\n'),(25,'Capricornus','Capricornus is shaped like a goat with a fish’s tail. It is a faint constellation but easily recognized by its triangular shape. It’s an ancient symbol related to agriculture and time.',2,'684d250634530_capicom.jpg','Deneb Algedi','21h 0m, -20°','Capricornus represents Pan, the rustic god who escaped the monster Typhon by transforming his lower half into a fish. Zeus honored his cleverness by placing him among the stars.'),(26,'Aquarius','Aquarius is the water-bearer, often shown as a man pouring water from a jar. It is a large but dim constellation symbolizing life and wisdom.\r\n\r\n',2,'684d24e3964ad_aquarius.jpg','Sadalsuud','22h 30m, -10°','Aquarius represents Ganymede, the most beautiful mortal boy taken by Zeus to serve the gods as cupbearer. Zeus immortalized him as the constellation Aquarius.\r\n\r\n'),(27,'Pisces','Pisces depicts two fish swimming in opposite directions, connected by a cord. It is a large but faint constellation often overshadowed by city lights.',2,'684d2743be3cf_pices.jpg','Alrescha','1h 0m, +10°','When the monster Typhon attacked, Aphrodite and her son Eros turned into fish to escape, tying themselves together so they wouldn’t lose each other. Zeus placed them in the sky as Pisces.');
/*!40000 ALTER TABLE `constellations` ENABLE KEYS */;
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
