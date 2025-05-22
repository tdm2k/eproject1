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
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publish_year` int DEFAULT NULL,
  `description` text,
  `buy_link` varchar(2083) DEFAULT NULL,
  `image_url` varchar(2083) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (9,'Life on Our Planet','Tom Fletcher','WITNESS BOOKS',1982,'Today there are 20 million species on our planet. Yet what we see is just a snapshot in time. 99% of Earth&#039;s inhabitants are lost to our deep past. The story of what happened to these lineages - their rise and their fall - is truly remarkable.\r\n\r\nAccompanying the ground-breaking series, Life on Our Planet tells the story of life&#039;s epic battle to conquer and survive on planet Earth, showing in a new light what&#039;s been lost to us, and how life&#039;s future is now being written by us. From ancient ocean worlds and plant life&#039;s first forays onto land, to the rise and fall of the dinosaurs and the devastation of the last Ice Age, this is a sweeping view of evolution, through five extinctions and, with the arrival of humans on earth, the beginning of the sixth...\r\n\r\nWith over 200 photos and images from the groundbreaking Netflix series, Life on Our Planet is an unforgettable journey to our ancient past, containing powerful lessons to learn about our future.','https://nhasachphuongnam.com/life-on-our-planet.html?srsltid=AfmBOopD9toqBn-glxR6q7M6JPfK1dvlOmf6N8yLAuJ4thpOaoyMv1Y_','assets/books/1747733957_Untitled-1_aofj-d1.jpg'),(10,'The Earth Book','Camilla de la Bédoyère','Miles Kelly Publishing Ltd',2006,'Prepare yourself for a spectacular tour of the world&#039;s many habitats, each possessing its own unique mood. From the claustrophobic darkness of the Deep Ocean to the big skies of the Open Plains; the merciless, ever-expanding Deserts to the diminishing Jungles, teeming with violent life. The thread that binds them all is water - the precious element that has carved our world and makes all life possible - and only three percent of which on the entire Earth is fresh.Within each habitat, we take a journey of exploration. We find the hidden life - the animals who have yet to be extensively filmed, either through the inaccessibility of their habitat or their own elusive behaviour. Mass migration spectacles, blind cave fish, bioluminescent corals and rarely-seen large mountain cats, all beautifully captured by the world&#039;s best nature photographers.With a foreword by Sir David Attenborough, Planet Earth is the ultimate portrait of our planet, and the perfect companion piece to a truly historic television event.','https://nhasachphuongnam.com/the-earth-book-vi.html?gad_source=1&amp;gad_campaignid=19956129087&amp;gbraid=0AAAAABXinI7nVnStyJTMOyTYIqFJaq5u2&amp;gclid=Cj0KCQjw0LDBBhCnARIsAMpYlAo6CqV5HpSej90v3DLzc6CPf9uIYfal__OMpt4SvcFMhkKmh-IWjzIaAgWzEALw_wcB','assets/books/1747745828_28_zhtp-xy.jpg'),(11,' The Comet (HC)','Joe Todd-Stanton','Flying Eye Books',2015,'A picture book touching on the impact of moving away from home that teaches coping skills for kids struggling with relationships and sense of belonging, while also holding space for the places they come from. For fans of The Blue House by Phoebe Wahl.\r\n\r\nWhen Nyla is forced to leave her home in the country to start life again in the city, all she can think about is everything she misses from before.\r\n\r\nSo when a comet comes crashing through the city streets and starts growing into a forest, Nyla can’t resist a chance to head somewhere that feels closer to what she had before … but what starts as an escape could be just the thing to make her finally feel at home.\r\n\r\nParents looking for childrens books that target ages 3-5 and emphasize the value of imagination and play as acts of self care will be excited they found this beautiful book!','https://paperbacks.vn/books/the-comet-hc/','assets/books/1747747461_14-01.jpg'),(12,'Usborne Book &amp; Jigsaws: The Solar System','Federica Iossa','Usborne Publishing',2020,'This pack contains a beautifully illustrated 200-piece jigsaw of the Solar System and a richly detailed double-sided fold-out that forms one continuous picture of the Solar System, featuring the Sun, planets, and various moons and spacecraft. The reverse features the same image, annotated with facts about each of the objects shown. Richly detailed jigsaw and book makes a fantastic, informative present. Kids can have hours of fun discovering the different worlds around the Sun as they piece together the puzzle. Fold-out Solar System book is full of fascinating facts and a great introduction to the solar system for kids.','https://nhasachphuongnam.com/usborne-book-jigsaws-the-solar-system.html?gad_source=1&amp;gad_campaignid=19956129087&amp;gbraid=0AAAAABXinI7nVnStyJTMOyTYIqFJaq5u2&amp;gclid=Cj0KCQjw0LDBBhCnARIsAMpYlArq5HWhK_3-GZs3VXkltEZ673QBxRDW-DcupJ-iFqsU2JnNv9VbxS8aAlnIEALw_wcB','assets/books/1747747564_Untitled-1_7e1p-88.jpg'),(17,'The Astronomy Book: Big Ideas Simply Explained','Cathy Scott','DK Publishing',2017,'Get ready to discover the story of the universe page by page! This educational book for teens will take you on a wild journey through the cosmos and incredible discoveries throughout history. Filled with beautifully illustrated diagrams, graphics, and jargon-free language, The Astronomy Book breaks down difficult concepts to guide you through the big ideas of astronomy.','https://sachhocthuat.com/the-astronomy-book-big-ideas-simply-explained/?gad_source=1&amp;gad_campaignid=21363074394&amp;gbraid=0AAAAAqgkvxjAkAis8ETpAAGAqaEutn8fd&amp;gclid=CjwKCAjw87XBBhBIEiwAxP3_A2lSKhR9tgjyAqY7ci66BVRfSP9qNbmzN9OPQ_40sWrnG5_PaH5bRxoCf3sQAvD_BwE','assets/books/1747883844_1617162986-the-astronomy-book-big-ideas-simply-explained2-510x510.jpg');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-22 10:28:43
