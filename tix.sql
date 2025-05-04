-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 10:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tix`
--

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `cinema_id` int(11) NOT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `seat_capacity` int(11) DEFAULT NULL,
  `seat_rows` int(11) DEFAULT NULL,
  `seat_columns` int(11) DEFAULT NULL,
  `seatplan_image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`cinema_id`, `venue_id`, `name`, `seat_capacity`, `seat_rows`, `seat_columns`, `seatplan_image`, `user_id`, `archived`) VALUES
(1, 3, 'MOA Cinema 1', 140, 10, 14, NULL, 1, 0),
(2, 3, 'MOA Director\'s Club', 48, 6, 8, NULL, 1, 0),
(3, 4, 'Ayala Manila Bay Cinema 1', 108, 9, 12, NULL, 1, 0),
(4, 3, 'MOA Cinema 2', 140, 10, 14, NULL, 1, 0),
(5, 3, 'MOA Cinema 3', 140, 10, 14, NULL, 1, 0),
(6, 3, 'MOA Cinema 4', 140, 10, 14, NULL, 1, 0),
(7, 5, 'Robinsons Manila Cinema 1', 432, 18, 24, NULL, 1, 0),
(8, 5, 'Robinsons Manila Cinema 3', 432, 18, 24, NULL, 1, 0),
(9, 5, 'Robinsons Manila Cinema 4', 432, 18, 24, NULL, 1, 0),
(10, 4, 'Ayala Manila Bay Cinema 2', 108, 9, 12, NULL, 1, 0),
(14, 6, 'Kwarto ni Julian', 3, 1, 3, NULL, 1, 1),
(16, 8, 'testcine', 15, 3, 5, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre`, `user_id`) VALUES
(1, 'Animation', 1),
(2, 'Action', 1),
(3, 'Family', 1),
(4, 'Fantasy', 1),
(5, 'Adventure', 1),
(12, 'Romance', 1),
(13, 'Musical', 1),
(14, 'Sci-fi', 1),
(15, 'Melodrama', 1),
(16, 'Comedy', 1),
(17, 'Thriller', 1),
(18, 'Mystery', 1),
(21, 'Horror', 1),
(37, 'Superhero', 1),
(38, 'Drama', 1),
(39, 'Fairy tale', 1),
(40, 'Historical drama', 1),
(41, 'Crime fiction', 1),
(48, 'Martial Arts', 1),
(57, 'Sport', 1),
(58, 'Documentary', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_title`, `description`, `poster`, `banner`, `archived`, `user_id`) VALUES
(1, 'A Minecraft Movie', 'A Minecraft Movie is a 2025 American fantasy adventure comedy film based on the 2011 video game Minecraft by Mojang Studios. It was directed by Jared Hess and written by Chris Bowman, Hubbel Palmer, Neil Widener, Gavin James, and Chris Galletta, from a story by Allison Schroeder, Bowman, and Palmer. The film stars Jason Momoa, Jack Black, Danielle Brooks, Emma Myers, and Sebastian Hansen. In the film, four misfits are pulled through a portal into a cubic world, and must embark on a quest back to the real world with the help of an \'expert crafter\' named Steve.', 'https://image.tmdb.org/t/p/original/yFHHfHcUgGAxziP1C3lLt0q2T4s.jpg', 'https://static1.squarespace.com/static/5c95f8d416b640656eb7765a/t/66d91a6f0ce15731e6a506a1/1725504111169/minecraft+movie+l.jpg?format=1500w', 1, 1),
(2, 'Scott Pilgrim vs. the World', 'Scott Pilgrim vs. the World[a] is a 2010 romantic action comedy film co-written, produced and directed by Edgar Wright, based on the graphic novel series Scott Pilgrim by Bryan Lee O\'Malley. It stars an ensemble cast, with Michael Cera as Scott Pilgrim, a slacker musician who is trying to win a competition to get a record deal, while also battling the seven evil exes of his new girlfriend Ramona Flowers, played by Mary Elizabeth Winstead.', 'https://m.media-amazon.com/images/M/MV5BNTA5ZWMwNmYtNWI1ZS00NDRlLTkxNzktMzdhZDU2ZDhjNDJmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://res.cloudinary.com/jerrick/image/upload/v1616461970/60594092376f3d001e02e355.jpg', 0, 1),
(3, 'The Blair Witch Project\r\n', 'The Blair Witch Project is a 1999 American psychological horror film written, directed, and edited by Daniel Myrick and Eduardo Sánchez. One of the most successful independent films of all time, it is a \"found footage\" pseudo-documentary in which three students (Heather Donahue, Michael C. Williams, and Joshua Leonard) hike into the Black Hills near Burkittsville, Maryland, to shoot a documentary about a local myth known as the Blair Witch.', 'https://image.tmdb.org/t/p/original/9050VGrYjYrEjpOvDZVAngLbg1f.jpg', 'https://lightbox-prod.imgix.net/images/assets/BANNER_LANDSCAPE_mac_10598147_73CE84BA-A331-40BB-B139B5A21AEB13AB.jpg', 0, 1),
(4, 'Gravity', 'Gravity is a 2013 science fiction thriller film directed by Alfonso Cuarón, who also co-wrote, co-edited, and produced the film. It stars Sandra Bullock and George Clooney as American astronauts who attempt to return to Earth after the destruction of their Space Shuttle in orbit.', 'https://upload.wikimedia.org/wikipedia/en/f/f6/Gravity_Poster.jpg', 'https://assets.scriptslug.com/live/img/x/posters/3122/gravity-2013_669f4c9eb7.jpg', 0, 1),
(5, 'Bambi', 'Bambi is a 1942 American animated coming-of-age drama film[4] produced by Walt Disney Productions and released by RKO Radio Pictures. Loosely based on Felix Salten\'s 1923 novel Bambi, a Life in the Woods, the production was supervised by David D. Hand, and was directed by a team of sequence directors, including James Algar, Bill Roberts, Norman Wright, Sam Armstrong, Paul Satterfield, and Graham Heid.', 'https://i.ebayimg.com/images/g/360AAOSwkz5hWRit/s-l1200.jpg', 'https://i.pinimg.com/736x/ea/61/f3/ea61f3a84e551fb378e4d93de1c99ac9.jpg', 0, 1),
(6, 'School of Rock', 'School of Rock (titled onscreen as The School of Rock) is a 2003 comedy film directed by Richard Linklater, produced by Scott Rudin and written by Mike White. The film stars Jack Black, Joan Cusack, White and Sarah Silverman. Black plays struggling rock guitarist Dewey Finn, who is fired from his band and subsequently poses as a substitute teacher at a prestigious prep school. After witnessing the musical talent of the students, Dewey forms a band of fifth-graders to attempt to win the upcoming Battle of the Bands and use his winnings to pay his rent.', 'https://i.ebayimg.com/images/g/HscAAOSwXeJe7gUj/s-l1200.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRF_kPCNTBFjqbr94EATxuQGJ1tiJzDhwtpAg&s', 0, 1),
(7, 'Thunderbolts*', 'After finding themselves ensnared in a death trap, an unconventional team of antiheroes must embark on a dangerous mission that will force them to confront the darkest corners of their pasts.', 'https://i.ebayimg.com/images/g/jCkAAOSwk0hm8sPc/s-l1200.jpg', 'https://knightedgemedia.com/wp-content/uploads/2024/09/thunderbolts-teaser-trailer-banner.jpg', 0, 1),
(8, 'The Wild Robot', 'After a shipwreck, an intelligent robot is stranded on an uninhabited island. To survive the harsh surroundings, she bonds with the native animals and cares for an orphaned baby goose.', 'https://s3.amazonaws.com/nightjarprod/content/uploads/sites/261/2024/08/15103059/wTnV3PCVW5O92JMrFvvrRcV39RU-scaled.jpg\r\n', 'https://snworksceo.imgix.net/jhn/bd7e4343-598d-4c3e-bf93-c2c10ccb1555.sized-1000x1000.png?w=1000', 0, 1),
(9, 'Wicked', 'Misunderstood because of her green skin, a young woman named Elphaba forges an unlikely but profound friendship with Glinda, a student with an unflinching desire for popularity. Following an encounter with the Wizard of Oz, their relationship soon reaches a crossroad as their lives begin to take very different paths.\r\n', 'https://upload.wikimedia.org/wikipedia/en/thumb/5/57/Wicked_2024_whisper_poster.jpg/250px-Wicked_2024_whisper_poster.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqrZ2truFKXrtUFVl_3ioFO63zmbNg4E2pbw&s', 0, 1),
(10, 'Bullet Train', 'Ladybug is an unlucky assassin who\'s determined to do his job peacefully after one too many gigs has gone off the rails. Fate, however, may have other plans as his latest mission puts him on a collision course with lethal adversaries from around the globe -- all with connected yet conflicting objectives -- on the world\'s fastest train.', 'https://image.tmdb.org/t/p/original/j8szC8OgrejDQjjMKSVXyaAjw3V.jpg', 'https://flixchatter.net/wp-content/uploads/2022/08/bullet-train-poster.jpg?w=640', 0, 1),
(11, 'Oppenheimer', 'During World War II, Lt. Gen. Leslie Groves Jr. appoints physicist J. Robert Oppenheimer to work on the top-secret Manhattan Project. Oppenheimer and a team of scientists spend years developing and designing the atomic bomb. Their work comes to fruition on July 16, 1945, as they witness the world\'s first nuclear explosion, forever changing the course of history.', 'https://m.media-amazon.com/images/M/MV5BN2JkMDc5MGQtZjg3YS00NmFiLWIyZmQtZTJmNTM5MjVmYTQ4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://goldendiscs.ie/cdn/shop/collections/Header_Oppenheimer_2for25_460x@2x.png?v=1697618018', 0, 1),
(12, 'The Diplomat', 'Amid an international crisis, a career diplomat juggles her new high-profile job as ambassador to the United Kingdom and her turbulent marriage to a political star.', 'https://m.media-amazon.com/images/M/MV5BNjFkZTBlYjgtMDA2OS00YjI2LWFiNjMtNWIxZTljYTEzMjRiXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhz9DhD0j8chxKmkFgmKO_gItQ_aBg4bnX4w&s', 0, 1),
(13, 'Dungeons & Dragons: Honor Among Thieves', 'A charming thief and a band of unlikely adventurers embark on an epic quest to retrieve a long lost relic, but their charming adventure goes dangerously awry when they run afoul of the wrong people.', 'https://m.media-amazon.com/images/M/MV5BOGRjMjQ0ZDAtODc0OS00MGY1LTkxMTMtODhhNjY5NTM4N2IwXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://dungeonsanddragonsfan.com/wp-content/uploads/2023/03/dnd-movie-honor-among-thieves-review-hero.png', 0, 1),
(14, 'Skill House', 'A dark satire of social media and influencer culture, unflinching take on fame and what new celebrities are willing to do to attain it.', 'https://pbs.twimg.com/media/Gnaft3uWYAAPGGM.jpg', 'https://pbs.twimg.com/profile_images/1697506977809907712/PbCSbOPt_400x400.jpg', 0, 1),
(15, 'Interstellar', 'In Earth\'s future, a global crop blight and second Dust Bowl are slowly rendering the planet uninhabitable. Professor Brand (Michael Caine), a brilliant NASA physicist, is working on plans to save mankind by transporting Earth\'s population to a new home via a wormhole. But first, Brand must send former NASA pilot Cooper (Matthew McConaughey) and a team of researchers through the wormhole and across the galaxy to find out which of three planets could be mankind\'s new home.', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3G7v0v1Zj-amNdX5Ve8h3R_68mukwcWT9ZQ&s', 0, 1),
(16, 'The Spiderwick Chronicles', 'Of the three Grace children, Jared (Freddie Highmore) has always been thought of as the troublemaker. So when strange things happen after his family\'s move to a relative\'s dilapidated estate, sister Mallory (Sarah Bolger), twin brother Simon and their mother assume that Jared is behind it all. However, magical creatures roam the grounds, and they all want a special book that Jared has found: a field guide to fantastic creatures, penned by Arthur Spiderwick.', 'https://static.wikia.nocookie.net/spiderwick/images/e/e4/Spiderwick_Film_Poster.jpg/revision/latest?cb=20240516090019\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4ZBx5WRQZCKwdQHygty6Irg0NA-RRFAM5Zw&s', 0, 1),
(17, 'Blade Runner 2049', 'Officer K (Ryan Gosling), a new blade runner for the Los Angeles Police Department, unearths a long-buried secret that has the potential to plunge what\'s left of society into chaos. His discovery leads him on a quest to find Rick Deckard (Harrison Ford), a former blade runner who\'s been missing for 30 years.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThJ-i7ZCMsOuHDTx7edssFGIFkGo1OqKvD4g&s', 'https://static1.srcdn.com/wordpress/wp-content/uploads/2019/12/Featured-Blade-Runner-2049.jpg', 0, 1),
(18, 'Lilo & Stitch', 'A lonely Hawaiian girl befriends a runaway alien, helping to heal her fragmented family.', 'https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p29095_p_v8_aq.jpg', 'https://www.bluedogposters.com.au/cdn/shop/collections/stitch-poster-print-banner_750x.progressive.jpg?v=1684382533', 0, 1),
(19, 'Karate Kid: Legends', 'After kung fu prodigy Li Fong relocates to New York City, he attracts unwanted attention from a local karate champion and embarks on a journey to enter the ultimate karate competition with the help of Mr. Han and Daniel LaRusso.', 'https://cdn.kinocheck.com/i/kxokwqxln8.jpg', 'https://bravenewcoin.com/wp-content/uploads/2024/12/Karate-Kid-Legends-Title.jpg', 0, 1),
(20, 'Mission: Impossible - The Final Reckoning', 'Our lives are the sum of our choices. Tom Cruise is Ethan Hunt in Mission: Impossible - The Final Reckoning.', 'https://resizing.flixster.com/U3YCyXvV0jgUv1Cs3gQAEQJkrPY=/ems.cHJkLWVtcy1hc3NldHMvbW92aWVzLzNiNTBiZGIwLTc3YWYtNDk0ZC04NThkLTZjZDc0MTk0OTNhOS5qcGc=', 'https://pbs.twimg.com/media/Gca-IXCXMAAdHZP.jpg', 0, 1),
(21, 'How to Train Your Dragon', 'As an ancient threat endangers both Vikings and dragons alike on the isle of Berk, the friendship between Hiccup, an inventive Viking, and Toothless, a Night Fury dragon, becomes the key to both species forging a new future together.', 'https://image.tmdb.org/t/p/original/3kXIwnm8qftufEflzu0FwZV10zM.jpg', 'https://w0.peakpx.com/wallpaper/490/32/HD-wallpaper-how-to-train-your-dragon-how-to-train-your-dragon-hiccup-how-to-train-your-dragon-toothless-how-to-train-your-dragon.jpg', 0, 1),
(22, 'Smurfs', 'When Papa Smurf is taken by evil wizards Razamel and Gargamel, Smurfette leads the Smurfs on a mission to the real world to save him.', 'https://lh4.googleusercontent.com/proxy/wV2jwlDA8-3xQPIhnrEXbfRrRI7z9aU28PZrB4uPK7EntUd0Ymqld0zQV1KBtvwgAtXXp9aeuWsmvkrSryUuhndQFWX6gvE', 'https://gptoys.lhscdn.com/uploads/images/136069/smurfs-fullwidth.jpg?lm=51dd3775f36ae10f955dd54fc12e390a', 0, 1),
(23, 'The Conjuring: Last Rites', 'Paranormal investigators Ed and Lorraine Warren take on one last terrifying case involving mysterious entities they must confront.', 'https://i.pinimg.com/564x/4a/bf/f3/4abff36d0b2f972a84ceef8eebbc2893.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTaFRokakd0zHY3xZ7VGnyJvZjkBHg6rsulgw&s', 0, 1),
(24, 'We Harvest', 'A young surgeon takes a job in corrupt Las Vegas. Facing personal tragedy, he\'s tempted by coworkers harvesting criminal organs, believing the cause righteous before realizing his moral compromise.', 'https://images.squarespace-cdn.com/content/v1/65453b376968237b884652ae/2f1d2c88-ec57-428a-b7d9-c864b7f98b62/WE+HARVEST+Theatrical+Teaser+IMDb.jpg?format=1000w', 'https://images.squarespace-cdn.com/content/v1/65453b376968237b884652ae/a18b330e-470e-4fe7-8f7c-536b5e376eb5/WE+HARVEST+Theatrical+Landscape+v1.alt.png', 0, 1),
(25, 'The Legend of Ochi', 'In a remote village on the island of Carpathia, a shy girl is raised to fear an elusive animal species known as ochi. But when she discovers a wounded baby ochi has been left behind, she escapes on a quest to bring him home.', 'https://m.media-amazon.com/images/M/MV5BOWM4MjIxZmQtYzA3YS00YThiLWI5MjItZDM0YjZmNDFhZDA3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://static1.squarespace.com/static/56a1633ac21b86f80ddeacb4/t/670ebcbdc51b5a6c31cd8ebc/1729019069161/legend+of+ochi+banner.jpg?format=1500w', 0, 1),
(26, 'Juliet & Romeo', 'Based on the real story that inspired Shakespeare\'s Romeo and Juliet, it follows the greatest love story of all time, set as an original pop musical.', 'https://upload.wikimedia.org/wikipedia/en/4/47/Juliet_%26_Romeo_%282025%29_poster.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1mGv-g_mTDk48caeZ6v9IWnw-J68wV6GkYA&s', 0, 1),
(30, 'tdf unchained', 'ewan', 'https://www.boxtoboxfilms.com/app/uploads/2023/06/fr_fr_tdf_main_main_-_yellow_vertical_27x40_rgb_post_1-1013x1500.jpg', 'https://bicyclingaustralia.com.au/wp-content/uploads/2024/06/IMG_0173.jpeg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_genres`
--

INSERT INTO `movie_genres` (`movie_id`, `genre_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 2),
(2, 4),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(3, 17),
(3, 21),
(4, 14),
(4, 17),
(4, 18),
(5, 1),
(5, 4),
(5, 5),
(6, 13),
(6, 16),
(7, 2),
(7, 14),
(7, 37),
(8, 1),
(8, 5),
(8, 14),
(9, 2),
(9, 13),
(9, 16),
(9, 38),
(9, 39),
(10, 2),
(10, 5),
(10, 17),
(10, 18),
(11, 17),
(11, 40),
(12, 17),
(12, 18),
(12, 38),
(12, 41),
(13, 2),
(13, 4),
(13, 5),
(14, 21),
(15, 2),
(15, 14),
(15, 17),
(15, 38),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 38),
(18, 5),
(18, 14),
(18, 16),
(19, 2),
(19, 48),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(22, 1),
(22, 3),
(22, 4),
(23, 17),
(23, 18),
(23, 21),
(24, 17),
(24, 21),
(25, 3),
(25, 4),
(25, 5),
(26, 12),
(26, 13),
(26, 38),
(30, 57),
(30, 58);

-- --------------------------------------------------------

--
-- Table structure for table `movie_tickets`
--

CREATE TABLE `movie_tickets` (
  `movie_tix_id` int(11) NOT NULL,
  `showing_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `senior` tinyint(1) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_time` datetime DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_tickets`
--

INSERT INTO `movie_tickets` (`movie_tix_id`, `showing_id`, `seat_id`, `senior`, `user_id`, `booking_time`, `archived`) VALUES
(13, 200, 13, 0, 4, '2025-05-03 13:38:33', 0),
(14, 200, 14, 0, 4, '2025-05-03 13:38:33', 0),
(15, 478, 15, 0, 2, '2025-05-04 15:33:19', 0),
(16, 478, 16, 0, 2, '2025-05-04 15:33:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seats_id` int(11) NOT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `showing_id` int(11) NOT NULL,
  `seat_row` char(2) DEFAULT NULL,
  `seat_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seats_id`, `cinema_id`, `user_id`, `showing_id`, `seat_row`, `seat_number`) VALUES
(13, 5, 4, 200, 'J', 7),
(14, 5, 4, 200, 'J', 8),
(15, 10, 2, 478, 'I', 6),
(16, 10, 2, 478, 'I', 7);

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE `showings` (
  `showing_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showings`
--

INSERT INTO `showings` (`showing_id`, `movie_id`, `cinema_id`, `price`, `show_date`, `show_time`, `archived`, `user_id`) VALUES
(1, 1, 1, 360, '2025-05-05', '11:00:00', 1, 1),
(2, 1, 1, 360, '2025-05-05', '15:00:00', 1, 1),
(3, 1, 1, 360, '2025-05-05', '19:00:00', 1, 1),
(4, 1, 1, 360, '2025-05-05', '21:00:00', 1, 1),
(5, 1, 1, 360, '2025-05-06', '11:00:00', 1, 1),
(6, 1, 1, 360, '2025-05-06', '15:00:00', 1, 1),
(7, 1, 1, 360, '2025-05-06', '19:00:00', 1, 1),
(8, 1, 1, 360, '2025-05-06', '21:00:00', 1, 1),
(9, 1, 1, 360, '2025-05-07', '11:00:00', 1, 1),
(10, 1, 1, 360, '2025-05-07', '15:00:00', 1, 1),
(11, 1, 1, 360, '2025-05-07', '19:00:00', 1, 1),
(12, 1, 1, 360, '2025-05-07', '21:00:00', 1, 1),
(13, 1, 1, 360, '2025-05-08', '11:00:00', 1, 1),
(14, 1, 1, 360, '2025-05-08', '15:00:00', 1, 1),
(15, 1, 1, 360, '2025-05-08', '19:00:00', 1, 1),
(16, 1, 1, 360, '2025-05-08', '21:00:00', 1, 1),
(17, 2, 1, 360, '2025-05-09', '11:00:00', 0, 1),
(18, 2, 1, 360, '2025-05-09', '15:00:00', 0, 1),
(19, 2, 1, 360, '2025-05-09', '19:00:00', 0, 1),
(20, 2, 1, 360, '2025-05-09', '21:00:00', 0, 1),
(21, 2, 1, 360, '2025-05-10', '11:00:00', 0, 1),
(22, 2, 1, 360, '2025-05-10', '15:00:00', 0, 1),
(23, 2, 1, 360, '2025-05-10', '19:00:00', 0, 1),
(24, 2, 1, 360, '2025-05-10', '21:00:00', 0, 1),
(25, 2, 1, 360, '2025-05-11', '11:00:00', 0, 1),
(26, 2, 1, 360, '2025-05-11', '15:00:00', 0, 1),
(27, 2, 1, 360, '2025-05-11', '19:00:00', 0, 1),
(28, 2, 1, 360, '2025-05-11', '21:00:00', 0, 1),
(29, 2, 1, 360, '2025-05-12', '11:00:00', 0, 1),
(30, 2, 1, 360, '2025-05-12', '15:00:00', 0, 1),
(31, 2, 1, 360, '2025-05-12', '19:00:00', 0, 1),
(32, 2, 1, 360, '2025-05-12', '21:00:00', 0, 1),
(33, 3, 1, 360, '2025-05-13', '11:00:00', 0, 1),
(34, 3, 1, 360, '2025-05-13', '15:00:00', 0, 1),
(35, 3, 1, 360, '2025-05-13', '19:00:00', 0, 1),
(36, 3, 1, 360, '2025-05-13', '21:00:00', 0, 1),
(37, 3, 1, 360, '2025-05-14', '11:00:00', 0, 1),
(38, 3, 1, 360, '2025-05-14', '15:00:00', 0, 1),
(39, 3, 1, 360, '2025-05-14', '19:00:00', 0, 1),
(40, 3, 1, 360, '2025-05-14', '21:00:00', 0, 1),
(41, 4, 1, 360, '2025-05-15', '11:00:00', 0, 1),
(42, 4, 1, 360, '2025-05-15', '15:00:00', 0, 1),
(43, 4, 1, 360, '2025-05-15', '19:00:00', 0, 1),
(44, 4, 1, 360, '2025-05-15', '21:00:00', 0, 1),
(45, 4, 1, 360, '2025-05-16', '11:00:00', 0, 1),
(46, 4, 1, 360, '2025-05-16', '15:00:00', 0, 1),
(47, 4, 1, 360, '2025-05-16', '19:00:00', 0, 1),
(48, 4, 1, 360, '2025-05-16', '21:00:00', 0, 1),
(49, 5, 2, 450, '2025-05-05', '11:00:00', 0, 1),
(50, 5, 2, 450, '2025-05-05', '15:00:00', 0, 1),
(51, 5, 2, 450, '2025-05-05', '19:00:00', 0, 1),
(52, 5, 2, 450, '2025-05-05', '21:00:00', 0, 1),
(53, 5, 2, 450, '2025-05-06', '11:00:00', 0, 1),
(54, 5, 2, 450, '2025-05-06', '15:00:00', 0, 1),
(55, 5, 2, 450, '2025-05-06', '19:00:00', 0, 1),
(56, 5, 2, 450, '2025-05-06', '21:00:00', 0, 1),
(57, 5, 2, 450, '2025-05-07', '11:00:00', 0, 1),
(58, 5, 2, 450, '2025-05-07', '15:00:00', 0, 1),
(59, 5, 2, 450, '2025-05-07', '19:00:00', 0, 1),
(60, 5, 2, 450, '2025-05-07', '21:00:00', 0, 1),
(61, 5, 2, 450, '2025-05-08', '11:00:00', 0, 1),
(62, 5, 2, 450, '2025-05-08', '15:00:00', 0, 1),
(63, 5, 2, 450, '2025-05-08', '19:00:00', 0, 1),
(64, 5, 2, 450, '2025-05-08', '21:00:00', 0, 1),
(65, 6, 2, 450, '2025-05-09', '11:00:00', 0, 1),
(66, 6, 2, 450, '2025-05-09', '15:00:00', 0, 1),
(67, 6, 2, 450, '2025-05-09', '19:00:00', 0, 1),
(68, 6, 2, 450, '2025-05-09', '21:00:00', 0, 1),
(69, 6, 2, 450, '2025-05-10', '11:00:00', 0, 1),
(70, 6, 2, 450, '2025-05-10', '15:00:00', 0, 1),
(71, 6, 2, 450, '2025-05-10', '19:00:00', 0, 1),
(72, 6, 2, 450, '2025-05-10', '21:00:00', 0, 1),
(73, 6, 2, 450, '2025-05-11', '11:00:00', 0, 1),
(74, 6, 2, 450, '2025-05-11', '15:00:00', 0, 1),
(75, 6, 2, 450, '2025-05-11', '19:00:00', 0, 1),
(76, 6, 2, 450, '2025-05-11', '21:00:00', 0, 1),
(77, 7, 2, 450, '2025-05-12', '11:00:00', 0, 1),
(78, 7, 2, 450, '2025-05-12', '15:00:00', 0, 1),
(79, 7, 2, 450, '2025-05-12', '19:00:00', 0, 1),
(80, 7, 2, 450, '2025-05-12', '21:00:00', 0, 1),
(81, 7, 2, 450, '2025-05-13', '11:00:00', 0, 1),
(82, 7, 2, 450, '2025-05-13', '15:00:00', 0, 1),
(83, 7, 2, 450, '2025-05-13', '19:00:00', 0, 1),
(84, 7, 2, 450, '2025-05-13', '21:00:00', 0, 1),
(85, 8, 2, 450, '2025-05-14', '11:00:00', 0, 1),
(86, 8, 2, 450, '2025-05-14', '15:00:00', 0, 1),
(87, 8, 2, 450, '2025-05-14', '19:00:00', 0, 1),
(88, 8, 2, 450, '2025-05-14', '21:00:00', 0, 1),
(89, 8, 2, 450, '2025-05-15', '11:00:00', 0, 1),
(90, 8, 2, 450, '2025-05-15', '15:00:00', 0, 1),
(91, 8, 2, 450, '2025-05-15', '19:00:00', 0, 1),
(92, 8, 2, 450, '2025-05-15', '21:00:00', 0, 1),
(93, 8, 2, 450, '2025-05-16', '11:00:00', 0, 1),
(94, 8, 2, 450, '2025-05-16', '15:00:00', 0, 1),
(95, 8, 2, 450, '2025-05-16', '19:00:00', 0, 1),
(96, 8, 2, 450, '2025-05-16', '21:00:00', 0, 1),
(97, 9, 3, 350, '2025-05-05', '11:00:00', 0, 1),
(98, 9, 3, 350, '2025-05-05', '15:00:00', 0, 1),
(99, 9, 3, 350, '2025-05-05', '19:00:00', 0, 1),
(100, 9, 3, 350, '2025-05-05', '21:00:00', 0, 1),
(101, 9, 3, 350, '2025-05-06', '11:00:00', 0, 1),
(102, 9, 3, 350, '2025-05-06', '15:00:00', 0, 1),
(103, 9, 3, 350, '2025-05-06', '19:00:00', 0, 1),
(104, 9, 3, 350, '2025-05-06', '21:00:00', 0, 1),
(105, 9, 3, 350, '2025-05-07', '11:00:00', 0, 1),
(106, 9, 3, 350, '2025-05-07', '15:00:00', 0, 1),
(107, 9, 3, 350, '2025-05-07', '19:00:00', 0, 1),
(108, 9, 3, 350, '2025-05-07', '21:00:00', 0, 1),
(109, 10, 3, 350, '2025-05-08', '11:00:00', 0, 1),
(110, 10, 3, 350, '2025-05-08', '15:00:00', 0, 1),
(111, 10, 3, 350, '2025-05-08', '19:00:00', 0, 1),
(112, 10, 3, 350, '2025-05-08', '21:00:00', 0, 1),
(113, 10, 3, 350, '2025-05-09', '11:00:00', 0, 1),
(114, 10, 3, 350, '2025-05-09', '15:00:00', 0, 1),
(115, 10, 3, 350, '2025-05-09', '19:00:00', 0, 1),
(116, 10, 3, 350, '2025-05-09', '21:00:00', 0, 1),
(117, 10, 3, 350, '2025-05-10', '11:00:00', 0, 1),
(118, 10, 3, 350, '2025-05-10', '15:00:00', 0, 1),
(119, 10, 3, 350, '2025-05-10', '19:00:00', 0, 1),
(120, 10, 3, 350, '2025-05-10', '21:00:00', 0, 1),
(121, 10, 3, 350, '2025-05-11', '11:00:00', 0, 1),
(122, 10, 3, 350, '2025-05-11', '15:00:00', 0, 1),
(123, 10, 3, 350, '2025-05-11', '19:00:00', 0, 1),
(124, 10, 3, 350, '2025-05-11', '21:00:00', 0, 1),
(125, 11, 3, 350, '2025-05-12', '11:00:00', 0, 1),
(126, 11, 3, 350, '2025-05-12', '15:00:00', 0, 1),
(127, 11, 3, 350, '2025-05-12', '19:00:00', 0, 1),
(128, 11, 3, 350, '2025-05-12', '21:00:00', 0, 1),
(129, 11, 3, 350, '2025-05-13', '11:00:00', 0, 1),
(130, 11, 3, 350, '2025-05-13', '15:00:00', 0, 1),
(131, 11, 3, 350, '2025-05-13', '19:00:00', 0, 1),
(132, 11, 3, 350, '2025-05-13', '21:00:00', 0, 1),
(133, 11, 3, 350, '2025-05-14', '11:00:00', 0, 1),
(134, 11, 3, 350, '2025-05-14', '15:00:00', 0, 1),
(135, 11, 3, 350, '2025-05-14', '19:00:00', 0, 1),
(136, 11, 3, 350, '2025-05-14', '21:00:00', 0, 1),
(137, 11, 3, 350, '2025-05-15', '11:00:00', 0, 1),
(138, 11, 3, 350, '2025-05-15', '15:00:00', 0, 1),
(139, 11, 3, 350, '2025-05-15', '19:00:00', 0, 1),
(140, 11, 3, 350, '2025-05-15', '21:00:00', 0, 1),
(141, 12, 3, 350, '2025-05-16', '11:00:00', 0, 1),
(142, 12, 3, 350, '2025-05-16', '15:00:00', 0, 1),
(143, 12, 3, 350, '2025-05-16', '19:00:00', 0, 1),
(144, 12, 3, 350, '2025-05-16', '21:00:00', 0, 1),
(145, 13, 4, 360, '2025-05-05', '11:00:00', 0, 1),
(146, 13, 4, 360, '2025-05-05', '15:00:00', 0, 1),
(147, 13, 4, 360, '2025-05-05', '19:00:00', 0, 1),
(148, 13, 4, 360, '2025-05-05', '21:00:00', 0, 1),
(149, 13, 4, 360, '2025-05-06', '11:00:00', 0, 1),
(150, 13, 4, 360, '2025-05-06', '15:00:00', 0, 1),
(151, 13, 4, 360, '2025-05-06', '19:00:00', 0, 1),
(152, 13, 4, 360, '2025-05-06', '21:00:00', 0, 1),
(153, 14, 4, 360, '2025-05-07', '11:00:00', 0, 1),
(154, 14, 4, 360, '2025-05-07', '15:00:00', 0, 1),
(155, 14, 4, 360, '2025-05-07', '19:00:00', 0, 1),
(156, 14, 4, 360, '2025-05-07', '21:00:00', 0, 1),
(157, 14, 4, 360, '2025-05-08', '11:00:00', 0, 1),
(158, 14, 4, 360, '2025-05-08', '15:00:00', 0, 1),
(159, 14, 4, 360, '2025-05-08', '19:00:00', 0, 1),
(160, 14, 4, 360, '2025-05-08', '21:00:00', 0, 1),
(161, 15, 4, 360, '2025-05-09', '11:00:00', 0, 1),
(162, 15, 4, 360, '2025-05-09', '15:00:00', 0, 1),
(163, 15, 4, 360, '2025-05-09', '19:00:00', 0, 1),
(164, 15, 4, 360, '2025-05-09', '21:00:00', 0, 1),
(165, 15, 4, 360, '2025-05-10', '11:00:00', 0, 1),
(166, 15, 4, 360, '2025-05-10', '15:00:00', 0, 1),
(167, 15, 4, 360, '2025-05-10', '19:00:00', 0, 1),
(168, 15, 4, 360, '2025-05-10', '21:00:00', 0, 1),
(169, 15, 4, 360, '2025-05-11', '11:00:00', 0, 1),
(170, 15, 4, 360, '2025-05-11', '15:00:00', 0, 1),
(171, 15, 4, 360, '2025-05-11', '19:00:00', 0, 1),
(172, 15, 4, 360, '2025-05-11', '21:00:00', 0, 1),
(173, 15, 4, 360, '2025-05-12', '11:00:00', 0, 1),
(174, 15, 4, 360, '2025-05-12', '15:00:00', 0, 1),
(175, 15, 4, 360, '2025-05-12', '19:00:00', 0, 1),
(176, 15, 4, 360, '2025-05-12', '21:00:00', 0, 1),
(177, 16, 4, 360, '2025-05-13', '11:00:00', 0, 1),
(178, 16, 4, 360, '2025-05-13', '15:00:00', 0, 1),
(179, 16, 4, 360, '2025-05-13', '19:00:00', 0, 1),
(180, 16, 4, 360, '2025-05-13', '21:00:00', 0, 1),
(181, 16, 4, 360, '2025-05-14', '11:00:00', 0, 1),
(182, 16, 4, 360, '2025-05-14', '15:00:00', 0, 1),
(183, 16, 4, 360, '2025-05-14', '19:00:00', 0, 1),
(184, 16, 4, 360, '2025-05-14', '21:00:00', 0, 1),
(185, 16, 4, 360, '2025-05-15', '11:00:00', 0, 1),
(186, 16, 4, 360, '2025-05-15', '15:00:00', 0, 1),
(187, 16, 4, 360, '2025-05-15', '19:00:00', 0, 1),
(188, 16, 4, 360, '2025-05-15', '21:00:00', 0, 1),
(189, 17, 4, 360, '2025-05-16', '11:00:00', 0, 1),
(190, 17, 4, 360, '2025-05-16', '15:00:00', 0, 1),
(191, 17, 4, 360, '2025-05-16', '19:00:00', 0, 1),
(192, 17, 4, 360, '2025-05-16', '21:00:00', 0, 1),
(193, 18, 5, 360, '2025-05-05', '11:00:00', 0, 1),
(194, 18, 5, 360, '2025-05-05', '15:00:00', 0, 1),
(195, 18, 5, 360, '2025-05-05', '19:00:00', 0, 1),
(196, 18, 5, 360, '2025-05-05', '21:00:00', 0, 1),
(197, 18, 5, 360, '2025-05-06', '11:00:00', 0, 1),
(198, 18, 5, 360, '2025-05-06', '15:00:00', 0, 1),
(199, 18, 5, 360, '2025-05-06', '19:00:00', 0, 1),
(200, 18, 5, 360, '2025-05-06', '21:00:00', 0, 1),
(201, 18, 5, 360, '2025-05-07', '11:00:00', 0, 1),
(202, 18, 5, 360, '2025-05-07', '15:00:00', 0, 1),
(203, 18, 5, 360, '2025-05-07', '19:00:00', 0, 1),
(204, 18, 5, 360, '2025-05-07', '21:00:00', 0, 1),
(205, 18, 5, 360, '2025-05-08', '11:00:00', 0, 1),
(206, 18, 5, 360, '2025-05-08', '15:00:00', 0, 1),
(207, 18, 5, 360, '2025-05-08', '19:00:00', 0, 1),
(208, 18, 5, 360, '2025-05-08', '21:00:00', 0, 1),
(209, 19, 5, 360, '2025-05-09', '11:00:00', 0, 1),
(210, 19, 5, 360, '2025-05-09', '15:00:00', 0, 1),
(211, 19, 5, 360, '2025-05-09', '19:00:00', 0, 1),
(212, 19, 5, 360, '2025-05-09', '21:00:00', 0, 1),
(213, 19, 5, 360, '2025-05-10', '11:00:00', 0, 1),
(214, 19, 5, 360, '2025-05-10', '15:00:00', 0, 1),
(215, 19, 5, 360, '2025-05-10', '19:00:00', 0, 1),
(216, 19, 5, 360, '2025-05-10', '21:00:00', 0, 1),
(217, 19, 5, 360, '2025-05-11', '11:00:00', 0, 1),
(218, 19, 5, 360, '2025-05-11', '15:00:00', 0, 1),
(219, 19, 5, 360, '2025-05-11', '19:00:00', 0, 1),
(220, 19, 5, 360, '2025-05-11', '21:00:00', 0, 1),
(221, 19, 5, 360, '2025-05-12', '11:00:00', 0, 1),
(222, 19, 5, 360, '2025-05-12', '15:00:00', 0, 1),
(223, 19, 5, 360, '2025-05-12', '19:00:00', 0, 1),
(224, 19, 5, 360, '2025-05-12', '21:00:00', 0, 1),
(225, 20, 5, 360, '2025-05-13', '11:00:00', 0, 1),
(226, 20, 5, 360, '2025-05-13', '15:00:00', 0, 1),
(227, 20, 5, 360, '2025-05-13', '19:00:00', 0, 1),
(228, 20, 5, 360, '2025-05-13', '21:00:00', 0, 1),
(229, 20, 5, 360, '2025-05-14', '11:00:00', 0, 1),
(230, 20, 5, 360, '2025-05-14', '15:00:00', 0, 1),
(231, 20, 5, 360, '2025-05-14', '19:00:00', 0, 1),
(232, 20, 5, 360, '2025-05-14', '21:00:00', 0, 1),
(233, 20, 5, 360, '2025-05-15', '11:00:00', 0, 1),
(234, 20, 5, 360, '2025-05-15', '15:00:00', 0, 1),
(235, 20, 5, 360, '2025-05-15', '19:00:00', 0, 1),
(236, 20, 5, 360, '2025-05-15', '21:00:00', 0, 1),
(237, 21, 5, 360, '2025-05-16', '11:00:00', 0, 1),
(238, 21, 5, 360, '2025-05-16', '15:00:00', 0, 1),
(239, 21, 5, 360, '2025-05-16', '19:00:00', 0, 1),
(240, 21, 5, 360, '2025-05-16', '21:00:00', 0, 1),
(241, 22, 6, 360, '2025-05-05', '11:00:00', 0, 1),
(242, 22, 6, 360, '2025-05-05', '15:00:00', 0, 1),
(243, 22, 6, 360, '2025-05-05', '19:00:00', 0, 1),
(244, 22, 6, 360, '2025-05-05', '21:00:00', 0, 1),
(245, 22, 6, 360, '2025-05-06', '11:00:00', 0, 1),
(246, 22, 6, 360, '2025-05-06', '15:00:00', 0, 1),
(247, 22, 6, 360, '2025-05-06', '19:00:00', 0, 1),
(248, 22, 6, 360, '2025-05-06', '21:00:00', 0, 1),
(249, 23, 6, 360, '2025-05-07', '11:00:00', 0, 1),
(250, 23, 6, 360, '2025-05-07', '15:00:00', 0, 1),
(251, 23, 6, 360, '2025-05-07', '19:00:00', 0, 1),
(252, 23, 6, 360, '2025-05-07', '21:00:00', 0, 1),
(253, 23, 6, 360, '2025-05-08', '11:00:00', 0, 1),
(254, 23, 6, 360, '2025-05-08', '15:00:00', 0, 1),
(255, 23, 6, 360, '2025-05-08', '19:00:00', 0, 1),
(256, 23, 6, 360, '2025-05-08', '21:00:00', 0, 1),
(257, 23, 6, 360, '2025-05-09', '11:00:00', 0, 1),
(258, 23, 6, 360, '2025-05-09', '15:00:00', 0, 1),
(259, 23, 6, 360, '2025-05-09', '19:00:00', 0, 1),
(260, 23, 6, 360, '2025-05-09', '21:00:00', 0, 1),
(261, 23, 6, 360, '2025-05-10', '11:00:00', 0, 1),
(262, 23, 6, 360, '2025-05-10', '15:00:00', 0, 1),
(263, 23, 6, 360, '2025-05-10', '19:00:00', 0, 1),
(264, 23, 6, 360, '2025-05-10', '21:00:00', 0, 1),
(265, 24, 6, 360, '2025-05-11', '11:00:00', 0, 1),
(266, 24, 6, 360, '2025-05-11', '15:00:00', 0, 1),
(267, 24, 6, 360, '2025-05-11', '19:00:00', 0, 1),
(268, 24, 6, 360, '2025-05-11', '21:00:00', 0, 1),
(269, 24, 6, 360, '2025-05-12', '11:00:00', 0, 1),
(270, 24, 6, 360, '2025-05-12', '15:00:00', 0, 1),
(271, 24, 6, 360, '2025-05-12', '19:00:00', 0, 1),
(272, 24, 6, 360, '2025-05-12', '21:00:00', 0, 1),
(273, 25, 6, 360, '2025-05-13', '11:00:00', 0, 1),
(274, 25, 6, 360, '2025-05-13', '15:00:00', 0, 1),
(275, 25, 6, 360, '2025-05-13', '19:00:00', 0, 1),
(276, 25, 6, 360, '2025-05-13', '21:00:00', 0, 1),
(277, 25, 6, 360, '2025-05-14', '11:00:00', 0, 1),
(278, 25, 6, 360, '2025-05-14', '15:00:00', 0, 1),
(279, 25, 6, 360, '2025-05-14', '19:00:00', 0, 1),
(280, 25, 6, 360, '2025-05-14', '21:00:00', 0, 1),
(281, 25, 6, 360, '2025-05-15', '11:00:00', 0, 1),
(282, 25, 6, 360, '2025-05-15', '15:00:00', 0, 1),
(283, 25, 6, 360, '2025-05-15', '19:00:00', 0, 1),
(284, 25, 6, 360, '2025-05-15', '21:00:00', 0, 1),
(285, 26, 6, 360, '2025-05-16', '11:00:00', 0, 1),
(286, 26, 6, 360, '2025-05-16', '15:00:00', 0, 1),
(287, 26, 6, 360, '2025-05-16', '19:00:00', 0, 1),
(288, 26, 6, 360, '2025-05-16', '21:00:00', 0, 1),
(289, 1, 7, 370, '2025-05-05', '11:00:00', 1, 1),
(290, 1, 7, 370, '2025-05-05', '15:00:00', 1, 1),
(291, 1, 7, 370, '2025-05-05', '19:00:00', 1, 1),
(292, 1, 7, 370, '2025-05-05', '21:00:00', 1, 1),
(293, 1, 7, 370, '2025-05-06', '11:00:00', 1, 1),
(294, 1, 7, 370, '2025-05-06', '15:00:00', 1, 1),
(295, 1, 7, 370, '2025-05-06', '19:00:00', 1, 1),
(296, 1, 7, 370, '2025-05-06', '21:00:00', 1, 1),
(297, 1, 7, 370, '2025-05-07', '11:00:00', 1, 1),
(298, 1, 7, 370, '2025-05-07', '15:00:00', 1, 1),
(299, 1, 7, 370, '2025-05-07', '19:00:00', 1, 1),
(300, 1, 7, 370, '2025-05-07', '21:00:00', 1, 1),
(301, 1, 7, 370, '2025-05-08', '11:00:00', 1, 1),
(302, 1, 7, 370, '2025-05-08', '15:00:00', 1, 1),
(303, 1, 7, 370, '2025-05-08', '19:00:00', 1, 1),
(304, 1, 7, 370, '2025-05-08', '21:00:00', 1, 1),
(305, 2, 7, 370, '2025-05-09', '11:00:00', 0, 1),
(306, 2, 7, 370, '2025-05-09', '15:00:00', 0, 1),
(307, 2, 7, 370, '2025-05-09', '19:00:00', 0, 1),
(308, 2, 7, 370, '2025-05-09', '21:00:00', 0, 1),
(309, 2, 7, 370, '2025-05-10', '11:00:00', 0, 1),
(310, 2, 7, 370, '2025-05-10', '15:00:00', 0, 1),
(311, 2, 7, 370, '2025-05-10', '19:00:00', 0, 1),
(312, 2, 7, 370, '2025-05-10', '21:00:00', 0, 1),
(313, 2, 7, 370, '2025-05-11', '11:00:00', 0, 1),
(314, 2, 7, 370, '2025-05-11', '15:00:00', 0, 1),
(315, 2, 7, 370, '2025-05-11', '19:00:00', 0, 1),
(316, 2, 7, 370, '2025-05-11', '21:00:00', 0, 1),
(317, 3, 7, 370, '2025-05-12', '11:00:00', 0, 1),
(318, 3, 7, 370, '2025-05-12', '15:00:00', 0, 1),
(319, 3, 7, 370, '2025-05-12', '19:00:00', 0, 1),
(320, 3, 7, 370, '2025-05-12', '21:00:00', 0, 1),
(321, 3, 7, 370, '2025-05-13', '11:00:00', 0, 1),
(322, 3, 7, 370, '2025-05-13', '15:00:00', 0, 1),
(323, 3, 7, 370, '2025-05-13', '19:00:00', 0, 1),
(324, 3, 7, 370, '2025-05-13', '21:00:00', 0, 1),
(325, 3, 7, 370, '2025-05-14', '11:00:00', 0, 1),
(326, 3, 7, 370, '2025-05-14', '15:00:00', 0, 1),
(327, 3, 7, 370, '2025-05-14', '19:00:00', 0, 1),
(328, 3, 7, 370, '2025-05-14', '21:00:00', 0, 1),
(329, 3, 7, 370, '2025-05-15', '11:00:00', 0, 1),
(330, 3, 7, 370, '2025-05-15', '15:00:00', 0, 1),
(331, 3, 7, 370, '2025-05-15', '19:00:00', 0, 1),
(332, 3, 7, 370, '2025-05-15', '21:00:00', 0, 1),
(333, 4, 7, 370, '2025-05-16', '11:00:00', 0, 1),
(334, 4, 7, 370, '2025-05-16', '15:00:00', 0, 1),
(335, 4, 7, 370, '2025-05-16', '19:00:00', 0, 1),
(336, 4, 7, 370, '2025-05-16', '21:00:00', 0, 1),
(337, 5, 8, 370, '2025-05-05', '11:00:00', 0, 1),
(338, 5, 8, 370, '2025-05-05', '15:00:00', 0, 1),
(339, 5, 8, 370, '2025-05-05', '19:00:00', 0, 1),
(340, 5, 8, 370, '2025-05-05', '21:00:00', 0, 1),
(341, 5, 8, 370, '2025-05-06', '11:00:00', 0, 1),
(342, 5, 8, 370, '2025-05-06', '15:00:00', 0, 1),
(343, 5, 8, 370, '2025-05-06', '19:00:00', 0, 1),
(344, 5, 8, 370, '2025-05-06', '21:00:00', 0, 1),
(345, 5, 8, 370, '2025-05-07', '11:00:00', 0, 1),
(346, 5, 8, 370, '2025-05-07', '15:00:00', 0, 1),
(347, 5, 8, 370, '2025-05-07', '19:00:00', 0, 1),
(348, 5, 8, 370, '2025-05-07', '21:00:00', 0, 1),
(349, 5, 8, 370, '2025-05-08', '11:00:00', 0, 1),
(350, 5, 8, 370, '2025-05-08', '15:00:00', 0, 1),
(351, 5, 8, 370, '2025-05-08', '19:00:00', 0, 1),
(352, 5, 8, 370, '2025-05-08', '21:00:00', 0, 1),
(353, 6, 8, 370, '2025-05-09', '11:00:00', 0, 1),
(354, 6, 8, 370, '2025-05-09', '15:00:00', 0, 1),
(355, 6, 8, 370, '2025-05-09', '19:00:00', 0, 1),
(356, 6, 8, 370, '2025-05-09', '21:00:00', 0, 1),
(357, 6, 8, 370, '2025-05-10', '11:00:00', 0, 1),
(358, 6, 8, 370, '2025-05-10', '15:00:00', 0, 1),
(359, 6, 8, 370, '2025-05-10', '19:00:00', 0, 1),
(360, 6, 8, 370, '2025-05-10', '21:00:00', 0, 1),
(361, 6, 8, 370, '2025-05-11', '11:00:00', 0, 1),
(362, 6, 8, 370, '2025-05-11', '15:00:00', 0, 1),
(363, 6, 8, 370, '2025-05-11', '19:00:00', 0, 1),
(364, 6, 8, 370, '2025-05-11', '21:00:00', 0, 1),
(365, 7, 8, 370, '2025-05-12', '11:00:00', 0, 1),
(366, 7, 8, 370, '2025-05-12', '15:00:00', 0, 1),
(367, 7, 8, 370, '2025-05-12', '19:00:00', 0, 1),
(368, 7, 8, 370, '2025-05-12', '21:00:00', 0, 1),
(369, 7, 8, 370, '2025-05-13', '11:00:00', 0, 1),
(370, 7, 8, 370, '2025-05-13', '15:00:00', 0, 1),
(371, 7, 8, 370, '2025-05-13', '19:00:00', 0, 1),
(372, 7, 8, 370, '2025-05-13', '21:00:00', 0, 1),
(373, 8, 8, 370, '2025-05-14', '11:00:00', 0, 1),
(374, 8, 8, 370, '2025-05-14', '15:00:00', 0, 1),
(375, 8, 8, 370, '2025-05-14', '19:00:00', 0, 1),
(376, 8, 8, 370, '2025-05-14', '21:00:00', 0, 1),
(377, 8, 8, 370, '2025-05-15', '11:00:00', 0, 1),
(378, 8, 8, 370, '2025-05-15', '15:00:00', 0, 1),
(379, 8, 8, 370, '2025-05-15', '19:00:00', 0, 1),
(380, 8, 8, 370, '2025-05-15', '21:00:00', 0, 1),
(381, 9, 8, 370, '2025-05-16', '11:00:00', 0, 1),
(382, 9, 8, 370, '2025-05-16', '15:00:00', 0, 1),
(383, 9, 8, 370, '2025-05-16', '19:00:00', 0, 1),
(384, 9, 8, 370, '2025-05-16', '21:00:00', 0, 1),
(385, 10, 9, 370, '2025-05-05', '11:00:00', 0, 1),
(386, 10, 9, 370, '2025-05-05', '15:00:00', 0, 1),
(387, 10, 9, 370, '2025-05-05', '19:00:00', 0, 1),
(388, 10, 9, 370, '2025-05-05', '21:00:00', 0, 1),
(389, 10, 9, 370, '2025-05-06', '11:00:00', 0, 1),
(390, 10, 9, 370, '2025-05-06', '15:00:00', 0, 1),
(391, 10, 9, 370, '2025-05-06', '19:00:00', 0, 1),
(392, 10, 9, 370, '2025-05-06', '21:00:00', 0, 1),
(393, 10, 9, 370, '2025-05-07', '11:00:00', 0, 1),
(394, 10, 9, 370, '2025-05-07', '15:00:00', 0, 1),
(395, 10, 9, 370, '2025-05-07', '19:00:00', 0, 1),
(396, 10, 9, 370, '2025-05-07', '21:00:00', 0, 1),
(397, 10, 9, 370, '2025-05-08', '11:00:00', 0, 1),
(398, 10, 9, 370, '2025-05-08', '15:00:00', 0, 1),
(399, 10, 9, 370, '2025-05-08', '19:00:00', 0, 1),
(400, 10, 9, 370, '2025-05-08', '21:00:00', 0, 1),
(401, 11, 9, 370, '2025-05-09', '11:00:00', 0, 1),
(402, 11, 9, 370, '2025-05-09', '15:00:00', 0, 1),
(403, 11, 9, 370, '2025-05-09', '19:00:00', 0, 1),
(404, 11, 9, 370, '2025-05-09', '21:00:00', 0, 1),
(405, 11, 9, 370, '2025-05-10', '11:00:00', 0, 1),
(406, 11, 9, 370, '2025-05-10', '15:00:00', 0, 1),
(407, 11, 9, 370, '2025-05-10', '19:00:00', 0, 1),
(408, 11, 9, 370, '2025-05-10', '21:00:00', 0, 1),
(409, 11, 9, 370, '2025-05-11', '11:00:00', 0, 1),
(410, 11, 9, 370, '2025-05-11', '15:00:00', 0, 1),
(411, 11, 9, 370, '2025-05-11', '19:00:00', 0, 1),
(412, 11, 9, 370, '2025-05-11', '21:00:00', 0, 1),
(413, 12, 9, 370, '2025-05-12', '11:00:00', 0, 1),
(414, 12, 9, 370, '2025-05-12', '15:00:00', 0, 1),
(415, 12, 9, 370, '2025-05-12', '19:00:00', 0, 1),
(416, 12, 9, 370, '2025-05-12', '21:00:00', 0, 1),
(417, 12, 9, 370, '2025-05-13', '11:00:00', 0, 1),
(418, 12, 9, 370, '2025-05-13', '15:00:00', 0, 1),
(419, 12, 9, 370, '2025-05-13', '19:00:00', 0, 1),
(420, 12, 9, 370, '2025-05-13', '21:00:00', 0, 1),
(421, 12, 9, 370, '2025-05-14', '11:00:00', 0, 1),
(422, 12, 9, 370, '2025-05-14', '15:00:00', 0, 1),
(423, 12, 9, 370, '2025-05-14', '19:00:00', 0, 1),
(424, 12, 9, 370, '2025-05-14', '21:00:00', 0, 1),
(425, 12, 9, 370, '2025-05-15', '11:00:00', 0, 1),
(426, 12, 9, 370, '2025-05-15', '15:00:00', 0, 1),
(427, 12, 9, 370, '2025-05-15', '19:00:00', 0, 1),
(428, 12, 9, 370, '2025-05-15', '21:00:00', 0, 1),
(429, 13, 9, 370, '2025-05-16', '11:00:00', 0, 1),
(430, 13, 9, 370, '2025-05-16', '15:00:00', 0, 1),
(431, 13, 9, 370, '2025-05-16', '19:00:00', 0, 1),
(432, 13, 9, 370, '2025-05-16', '21:00:00', 0, 1),
(433, 14, 10, 350, '2025-05-05', '11:00:00', 0, 1),
(434, 14, 10, 350, '2025-05-05', '15:00:00', 0, 1),
(435, 14, 10, 350, '2025-05-05', '19:00:00', 0, 1),
(436, 14, 10, 350, '2025-05-05', '21:00:00', 0, 1),
(437, 14, 10, 350, '2025-05-06', '11:00:00', 0, 1),
(438, 14, 10, 350, '2025-05-06', '15:00:00', 0, 1),
(439, 14, 10, 350, '2025-05-06', '19:00:00', 0, 1),
(440, 14, 10, 350, '2025-05-06', '21:00:00', 0, 1),
(441, 14, 10, 350, '2025-05-07', '11:00:00', 0, 1),
(442, 14, 10, 350, '2025-05-07', '15:00:00', 0, 1),
(443, 14, 10, 350, '2025-05-07', '19:00:00', 0, 1),
(444, 14, 10, 350, '2025-05-07', '21:00:00', 0, 1),
(445, 15, 10, 350, '2025-05-08', '11:00:00', 0, 1),
(446, 15, 10, 350, '2025-05-08', '15:00:00', 0, 1),
(447, 15, 10, 350, '2025-05-08', '19:00:00', 0, 1),
(448, 15, 10, 350, '2025-05-08', '21:00:00', 0, 1),
(449, 15, 10, 350, '2025-05-09', '11:00:00', 0, 1),
(450, 15, 10, 350, '2025-05-09', '15:00:00', 0, 1),
(451, 15, 10, 350, '2025-05-09', '19:00:00', 0, 1),
(452, 15, 10, 350, '2025-05-09', '21:00:00', 0, 1),
(453, 16, 10, 350, '2025-05-10', '11:00:00', 0, 1),
(454, 16, 10, 350, '2025-05-10', '15:00:00', 0, 1),
(455, 16, 10, 350, '2025-05-10', '19:00:00', 0, 1),
(456, 16, 10, 350, '2025-05-10', '21:00:00', 0, 1),
(457, 16, 10, 350, '2025-05-11', '11:00:00', 0, 1),
(458, 16, 10, 350, '2025-05-11', '15:00:00', 0, 1),
(459, 16, 10, 350, '2025-05-11', '19:00:00', 0, 1),
(460, 16, 10, 350, '2025-05-11', '21:00:00', 0, 1),
(461, 16, 10, 350, '2025-05-12', '11:00:00', 0, 1),
(462, 16, 10, 350, '2025-05-12', '15:00:00', 0, 1),
(463, 16, 10, 350, '2025-05-12', '19:00:00', 0, 1),
(464, 16, 10, 350, '2025-05-12', '21:00:00', 0, 1),
(465, 16, 10, 350, '2025-05-13', '11:00:00', 0, 1),
(466, 16, 10, 350, '2025-05-13', '15:00:00', 0, 1),
(467, 16, 10, 350, '2025-05-13', '19:00:00', 0, 1),
(468, 16, 10, 350, '2025-05-13', '21:00:00', 0, 1),
(469, 17, 10, 350, '2025-05-14', '11:00:00', 0, 1),
(470, 17, 10, 350, '2025-05-14', '15:00:00', 0, 1),
(471, 17, 10, 350, '2025-05-14', '19:00:00', 0, 1),
(472, 17, 10, 350, '2025-05-14', '21:00:00', 0, 1),
(473, 17, 10, 350, '2025-05-15', '11:00:00', 0, 1),
(474, 17, 10, 350, '2025-05-15', '15:00:00', 0, 1),
(475, 17, 10, 350, '2025-05-15', '19:00:00', 0, 1),
(476, 17, 10, 350, '2025-05-15', '21:00:00', 0, 1),
(477, 18, 10, 350, '2025-05-16', '11:00:00', 0, 1),
(478, 18, 10, 350, '2025-05-16', '15:00:00', 0, 1),
(479, 18, 10, 350, '2025-05-16', '19:00:00', 0, 1),
(480, 18, 10, 350, '2025-05-16', '21:00:00', 0, 1),
(502, 30, 16, 200, '2025-05-09', '12:00:00', 0, 1),
(503, 30, 16, 200, '2025-05-09', '17:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `user_type` enum('customer','admin','organizer','') NOT NULL,
  `created_at` datetime NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `s_name`, `email`, `password`, `user_type`, `created_at`, `archived`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'admin', 'admin', '2025-04-14 07:23:14', 0),
(2, 'Jose', 'Rizal', 'jose@rizal.com', 'jose', 'customer', '2025-04-14 19:01:57', 0),
(3, 'Rizal', 'Jose', 'jose@jose.com', 'jose', 'customer', '2025-04-23 15:38:40', 0),
(4, 'Patrick', 'Sigue', 'patrick@sigue', 'patrick', 'customer', '2025-05-02 19:47:43', 0),
(5, 'John', 'Sigue', 'jsigue9596@gmail.com', 'BaYuQqUd', 'customer', '2025-05-04 09:04:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(10) NOT NULL,
  `venue_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `address`, `event_type`, `image`, `user_id`, `archived`) VALUES
(3, 'Mall of Asia', 'SM Mall of Asia, Seaside Blvd, Pasay, 1300 Metro Manila', 'Movie', '', 1, 0),
(4, 'Ayala Malls Manila Bay', 'Macapagal Boulevard cor. Asean Avenue, Aseana City, Tambo, Parañaque, Metro Manila', 'Movie', '', 1, 0),
(5, 'Robinsons Place Manila', 'Pedro Gil, cor Adriatico St, Ermita, Manila, 1000 Metro Manila', 'Movie', '', 1, 0),
(6, 'Bahay ni Julian', '177 Northern Hills Rd, Meycauayan, Metro Manila', '', '', 1, 1),
(8, 'testing', 'testing lang', '', '', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`cinema_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`),
  ADD UNIQUE KEY `genre` (`genre`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`movie_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `movie_tickets`
--
ALTER TABLE `movie_tickets`
  ADD PRIMARY KEY (`movie_tix_id`),
  ADD UNIQUE KEY `showing_id` (`showing_id`,`seat_id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seats_id`),
  ADD KEY `cinema_id` (`cinema_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `showing_id` (`showing_id`);

--
-- Indexes for table `showings`
--
ALTER TABLE `showings`
  ADD PRIMARY KEY (`showing_id`),
  ADD UNIQUE KEY `unique_cinema_date_time` (`cinema_id`,`show_date`,`show_time`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `movie_tickets`
--
ALTER TABLE `movie_tickets`
  MODIFY `movie_tix_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD CONSTRAINT `cinemas_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`);

--
-- Constraints for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);

--
-- Constraints for table `movie_tickets`
--
ALTER TABLE `movie_tickets`
  ADD CONSTRAINT `movie_tickets_ibfk_1` FOREIGN KEY (`showing_id`) REFERENCES `showings` (`showing_id`),
  ADD CONSTRAINT `movie_tickets_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seats_id`),
  ADD CONSTRAINT `movie_tickets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`cinema_id`),
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `seats_ibfk_3` FOREIGN KEY (`showing_id`) REFERENCES `showings` (`showing_id`);

--
-- Constraints for table `showings`
--
ALTER TABLE `showings`
  ADD CONSTRAINT `showings_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `showings_ibfk_2` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`cinema_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
