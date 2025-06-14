-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: eproject1
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

--
-- Table structure for table `videos`
--

DROP TABLE
IF
  EXISTS `videos`;
  /*!40101 SET @saved_cs_client     = @@character_set_client */
;
  /*!50503 SET character_set_client = utf8mb4 */
;
  CREATE TABLE `videos` (
    `id` int NOT NULL AUTO_INCREMENT
    , `title` varchar(255) DEFAULT NULL
    , `url` varchar(2083) DEFAULT NULL
    , `description` text
    , `thumbnail_url` varchar(2083) DEFAULT NULL
    , `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
    , PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
  /*!40101 SET character_set_client = @saved_cs_client */
;

  --
  -- Dumping data for table `videos`
  --

  LOCK TABLES `videos` WRITE;
  /*!40000 ALTER TABLE `videos` DISABLE KEYS */
;
  INSERT INTO
    `videos`
  VALUES
    (
      3
      , 'Jupiter – The Giant Among Giants'
      , 'https://www.youtube.com/watch?v=-AakWzvAgRM&amp;amp;t=1s'
      , 'Jupiter isn&#039;t just the biggest planet—it&#039;s a planetary powerhouse. This incredible BBC Earth documentary takes us deep into the swirling atmosphere of the Solar System’s king. Viewers are introduced to the mechanics of the Great Red Spot, a hurricane three times larger than Earth that has raged for centuries. We explore the layers of gaseous clouds, immense magnetosphere, and the crushing pressure beneath the surface. Using data from the Juno mission, the video reconstructs Jupiter’s formation and internal structure, suggesting it may have formed first, acting like a cosmic vacuum that cleared debris and protected inner worlds like Earth.\r\n\r\nThe documentary also journeys through its remarkable moon system. Europa is particularly captivating—beneath its icy crust lies a global ocean that may harbor life. Io, meanwhile, is a volcanic inferno, constantly reshaped by intense gravitational forces. This video weaves together stunning CGI, interviews with NASA scientists, and breathtaking satellite footage to present not just a planet, but an entire miniature solar system orbiting within our own. Whether you&#039;re curious about planetary science, space weather, or cosmic history, this deep dive into Jupiter will leave you in awe of the forces that shape our universe.'
      , 'assets/videos/video_684bdfdf5358a.jpg'
      , '2025-06-13 08:22:55'
    )
    , (
      4
      , 'Mercury – Baked Frontier at the Sun’s Doorstep'
      , 'https://www.youtube.com/watch?v=X8iUg1O0fN4'
      , 'Closest to the Sun, Mercury is small but scientifically profound. This 4K documentary starts with Mariner 10’s pioneering fly-bys and dives into MESSENGER’s high-definition maps of its cratered surface. Discover the planet’s mysteriously oversized iron core—perhaps due to an ancient cataclysm that stripped away lighter crust.\r\n\r\nSurprisingly, permanently shadowed craters at its poles trap water-ice, defying its scorching daytime climate. The video explores “hollows”—oddly bright, shallow depressions that fade over time—likely formed through volatile loss. MESSENGER’s magnetic readings suggest a partially molten outer core beneath a solid shell. Viewers learn about Mercury’s odd 3:2 spin-orbit coupling and the extreme 600 °C temperature swings between day and night.\r\n\r\nThe film casts an eye toward ESA/JAXA’s BepiColombo mission, launched to provide new insights into Mercury’s geology and magnetism. Through CGI flybys and expert commentary, this documentary elevates Mercury from a solar wanderer to a key to planetary science. '
      , 'assets/videos/video_684be0bb7b933.jpg'
      , '2025-06-13 08:26:35'
    )
    , (
      5
      , 'Venus – Blazing Hothouse or Hidden Oasis?'
      , 'https://www.youtube.com/watch?v=nr8T7HdU2zI'
      , 'Venus, once Earth’s glamorous twin, has transformed into an inferno. This in-depth documentary uses radar mapping and cinematic narratives to reveal a world shrouded in thick, toxic clouds, with surface temperatures soaring above 460 °C and crushing pressure that would obliterate most probes. Soviet Venera landers made brief but intense forays, sending back surreal, sepia-toned images.\r\n\r\nExperts reconstruct Venus’s history, from possible ancient oceans to the onset of a runaway greenhouse effect. Viewers learn how sulfuric acid clouds dominate the sky, concealing volcanoes and lava plains. Some theories propose floating microbial life in the upper atmosphere—where conditions are more temperate—prompting renewed mission interest from NASA’s DAVINCI+ and ESA’s EnVision.\r\n\r\nFeaturing planetary geologists, atmospheric chemists, and stunning visualizations, the documentary illustrates how Venus is both a cautionary emblem of climate misuse—and a frontier for astrobiological discovery.'
      , 'assets/videos/video_684be150325dd.jpg'
      , '2025-06-13 08:29:04'
    )
    , (
      6
      , 'Earth – Our Fragile, Life‑Harboring Blue Marble'
      , 'https://www.youtube.com/watch?v=kpFryXQbVEA'
      , 'Bringing our home into cosmic focus, this NOVA special showcases Earth from the perspective of orbit. Sweeping satellite imagery reveals swirling hurricanes, glowing auroras, shifting glaciers, moving tectonic plates, and shimmering city lights—an aerial symphony of life and geology.\r\n\r\nScientists guide us through global climate patterns, from seasonal CO₂ cycles to warming trends and ecological markers. We witness coral bleaching, deforestation, and urban expansion—but also reforestation initiatives, wildlife recovery, and clean energy adoption. The film underscores Earth’s delicate balance, highlighting the planet’s resilience if we choose sustainable stewardship.\r\n\r\nTime-lapse sequences portray day–night cycles, revealing human impact across the globe. Geologists and ecologists emphasize how Earth remains not just hospitable—but also vulnerable. This film celebrates our planet’s beauty and challenges us to protect it for future generations.\r\n\r\n'
      , 'assets/videos/video_684be21159f18.jpg'
      , '2025-06-13 08:32:17'
    )
    , (
      7
      , 'Mars – Secrets of the Red Planet Revealed'
      , 'https://www.youtube.com/watch?v=rw_OgA9x7B8'
      , 'Mars looms large in our hopes for extraterrestrial exploration and life. This DW Documentary delves into ancient rover missions, revealing a planet once drenched with water. Incredible footage from Perseverance and Curiosity rovers showcases sedimentary rock formations in Jezero Crater—suggestive of lakebeds—and captures seasonal methane plumes that could hint at microbial life.\r\n\r\nThe story includes Ingenuity, the first drone flight on another world, scavenging Martian skies in a pioneering mission. We tour massive volcanoes like Olympus Mons, the grand canyon-like Valles Marineris, and the haunting polar ice caps. The film also examines planet-spanning dust storms that can engulf Mars for months.\r\n\r\nShifting to human aspirations, interviews with scientists and engineers explore colonization strategies: radiation shelter design, life-support tech, psychological readiness for isolation, and the ethics of terraforming. Aspirations of a Mars base merge with discussions of SpaceX’s Starship and NASA’s Artemis program. With CGI Martian habitats and stirring human narratives, this video paints Mars not as a distant red dot—but as our next great home.'
      , 'assets/videos/video_684be27b2a5ca.jpg'
      , '2025-06-13 08:34:03'
    )
    , (
      8
      , 'Saturn – The Ringed Wonder in Stunning Detail'
      , 'https://www.youtube.com/watch?v=CX917SSS9CI'
      , 'Saturn, with its mesmerizing rings and mysterious moons, has captivated humanity for centuries. This stunning 4K documentary delivers a cinematic tour of the gas giant’s most iconic features. Through high-definition visuals from the Cassini-Huygens mission, we witness close-ups of Saturn&#039;s vast ring system—composed of ice, dust, and rock chunks orbiting at incredible speeds. Scientists explain the dynamic behavior of these rings, including the &quot;spokes&quot; and propeller-like gaps caused by hidden moonlets.\r\n\r\nThe video then transports us to Titan, Saturn’s largest moon and one of the most Earth-like bodies in the solar system. With its thick atmosphere, lakes of liquid methane, and active weather system, Titan could be a cradle of exotic chemistry and possibly even life. Cassini’s descent probe, Huygens, gives us humanity’s first landing on a world farther than Mars. The documentary also explores Enceladus, another icy moon, revealing powerful geysers that shoot water vapor and organic molecules into space—clues of a hidden subsurface ocean.\r\n\r\nNarrated by leading astrophysicists and using advanced CGI, the film examines Saturn&#039;s role in shaping our understanding of the outer solar system and raises questions about how such distant, frozen moons could support life. It&#039;s a masterclass in planetary science and an unforgettable visual experience.'
      , 'assets/videos/video_684be2fb010e2.jpg'
      , '2025-06-13 08:36:11'
    )
    , (
      9
      , 'Uranus – Tilted Ice Giant of Mystery'
      , 'https://www.youtube.com/watch?v=Y6m_oliZ89M'
      , 'Uranus stands out—literally—tipped on its side at 98°, likely due to a massive ancient impact. This film uses Voyager 2’s 1986 fly-by, telescopic data, and CGI to illuminate its tilted seasons, which alternate between decades of sunlight and decades of darkness.\r\n\r\nClassified as an ice giant, Uranus has a thick mantle of water, ammonia, and methane frozen into a distinct mix, enveloping a rocky core. Its methane-rich atmosphere tints the planet a ghostly aqua, while faint rings and 27 moons—some likely harboring subsurface oceans—add complexity to its character. Scientists debate why Uranus radiates less heat than Neptune and how its offset magnetic field hints at interior irregularities.\r\n\r\nFeaturing planetary scientists and mission planners, the documentary advocates for a future orbiter-probe mission to unravel its secrets. With beautifully simulated longitudinal fly-overs and evolutive time-lapses, Uranus emerges as a frontier of planetary science.'
      , 'assets/videos/video_684be359840e8.jpg'
      , '2025-06-13 08:37:45'
    )
    , (
      10
      , 'Neptune – The Windy Blue Enigma'
      , 'https://www.youtube.com/watch?v=NStn7zZKXfE'
      , 'Plunging through the outer solar system, we land upon Neptune—planet of legendary winds and sapphire hues. National Geographic&#039;s documentary opens with Voyager 2’s breathtaking flyby footage, including dramatic reveals of the Great Dark Spot—a storm larger than Earth. Viewers learn how Neptune emits nearly twice the energy it absorbs from the Sun, suggesting internal heat and possible convection.\r\n\r\nAtmospheric methane gives Neptune its vivid blue color, but clouds of frozen methane create transient white streaks across the sky. The video examines supersonic winds over 2,100 km/h—the fastest in our solar system—and what fuels them.\r\n\r\nNeptune’s largest moon, Triton, defies expectations with retrograde orbit and active geysers, hinting at a captured Kuiper Belt object. Researchers speculate about subsurface layers and whether cryovolcanism is ongoing. The piece ends with calls for renewed missions using orbiters and atmospheric probes to better study this distant ice giant. Mysteries persist, but the blue wonder remains one of the most compelling worlds to explore. '
      , 'assets/videos/video_684be3a829123.jpg'
      , '2025-06-13 08:39:04'
    )
    , (
      11
      , ' Black Holes Exposed – Into the Abyss'
      , 'https://www.youtube.com/watch?v=kOEDG3j1bjs&amp;t=13s'
      , 'Embark on a mind-bending voyage deep into the heart of black holes in this feature-length NOVA documentary. Starting from the collapse of massive stars, the film explains how these dense objects form when gravity wins over nuclear pressure. You’ll learn about event horizons—the invisible point of no return—and witness dramatic visualizations of spacetime bending around them.\r\n\r\nThe documentary delves into the physics behind accretion disks—swirling rings of gas superheated to millions of degrees—and the powerful relativistic jets that shoot from their poles. Groundbreaking discoveries take center stage: the Event Horizon Telescope’s collision of light and shadow revealing the first image of a supermassive black hole (M87*), and LIGO&#039;s detection of gravitational waves from colliding black holes—confirmations of Einstein’s century-old predictions.\r\n\r\nExperts discuss key theoretical puzzles: Hawking radiation, the black hole information paradox, and speculative scenarios like wormholes and quantum foam. Stunning CGI, interviews with leading astrophysicists, and satellite data combine to bring viewers face-to-face with one of nature’s most enigmatic phenomena.\r\n\r\nWhether you&#039;re fascinated by extreme gravity, curious about cosmic origins, or passionate about the limits of physics, this documentary offers a meticulously detailed, visually compelling exploration of the abyss.\r\n\r\n'
      , 'assets/videos/video_684be4ef68122.jpg'
      , '2025-06-13 08:44:31'
    )
    , (
      12
      , ' The Big Bang Unleashed – Origins of Everything'
      , 'https://www.youtube.com/watch?v=foPlxyPuLgk'
      , 'This riveting documentary breaks down the foundation of our universe. Beginning with Planck-era physics and cosmic inflation, it visualizes the first 380,000 years when primordial plasma gave way to transparent space. We trace how light crystallized into the Cosmic Microwave Background and how quantum fluctuations seeded galaxies.\r\n\r\nNarrated by leading cosmologists, the film explains baryogenesis (why matter won over antimatter), nucleosynthesis (formation of hydrogen and helium), and structure formation. Interactive graphics model how dark matter scaffolds cosmic web filaments and dark energy accelerated expansion.\r\n\r\nWe also follow the latest breakthroughs: observations from the James Webb Space Telescope, neutrino detectors revealing early universe conditions, and labs recreating tiny versions of the Big Bang. This documentary connects the birth of all matter—and ultimately you—with each passing second of the cosmic clock.'
      , 'assets/videos/video_684be5c3e7331.jpg'
      , '2025-06-13 08:48:03'
    );
  /*!40000 ALTER TABLE `videos` ENABLE KEYS */
;
  UNLOCK TABLES;
  /*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;

  /*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
  /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
  /*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
  /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;

  -- Dump completed on 2025-06-13 19:52:28