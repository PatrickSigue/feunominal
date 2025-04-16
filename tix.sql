-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 07:54 AM
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
  `seatplan_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`cinema_id`, `venue_id`, `name`, `seat_capacity`, `seat_rows`, `seat_columns`, `seatplan_image`) VALUES
(1, 3, 'MOA Cinema 1', 140, 10, 14, NULL),
(2, 3, 'MOA Director\'s Club', 48, 6, 8, NULL),
(3, 4, 'Ayala Manila Bay Cinema 1', 108, 9, 12, NULL),
(4, 3, 'MOA Cinema 2', 140, 10, 14, NULL),
(5, 3, 'MOA Cinema 3', 140, 10, 14, NULL),
(6, 3, 'MOA Cinema 4', 140, 10, 14, NULL),
(7, 5, 'Robinsons Manila Cinema 1', 432, 18, 24, NULL),
(8, 5, 'Robinsons Manila Cinema 3', 432, 18, 24, NULL),
(9, 5, 'Robinsons Manila Cinema 4', 432, 18, 24, NULL),
(10, 4, 'Ayala Manila Bay Cinema 2', 108, 9, 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `event_type` enum('Movie','Sport','Concert','Festival','Play') NOT NULL,
  `v_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre`) VALUES
(2, 'Action'),
(5, 'Adventure'),
(1, 'Animation'),
(16, 'Comedy'),
(41, 'Crime fiction'),
(45, 'Crime film'),
(38, 'Drama'),
(39, 'Fairy tale'),
(3, 'Family'),
(4, 'Fantasy'),
(40, 'Historical drama'),
(21, 'Horror'),
(43, 'Martial Arts'),
(15, 'Melodrama'),
(13, 'Musical'),
(18, 'Mystery'),
(42, 'Neo-noir'),
(12, 'Romance'),
(14, 'Sci-fi'),
(37, 'Superhero'),
(17, 'Thriller'),
(44, 'Western');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `poster` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_title`, `description`, `poster`, `banner`) VALUES
(1, 'A Minecraft Movie', 'A Minecraft Movie is a 2025 American fantasy adventure comedy film based on the 2011 video game Minecraft by Mojang Studios. It was directed by Jared Hess and written by Chris Bowman, Hubbel Palmer, Neil Widener, Gavin James, and Chris Galletta, from a story by Allison Schroeder, Bowman, and Palmer. The film stars Jason Momoa, Jack Black, Danielle Brooks, Emma Myers, and Sebastian Hansen. In the film, four misfits are pulled through a portal into a cubic world, and must embark on a quest back to the real world with the help of an \'expert crafter\' named Steve.', 'https://image.tmdb.org/t/p/original/yFHHfHcUgGAxziP1C3lLt0q2T4s.jpg', 'https://static1.squarespace.com/static/5c95f8d416b640656eb7765a/t/66d91a6f0ce15731e6a506a1/1725504111169/minecraft+movie+l.jpg?format=1500w'),
(2, 'Scott Pilgrim vs. the World', 'Scott Pilgrim vs. the World[a] is a 2010 romantic action comedy film co-written, produced and directed by Edgar Wright, based on the graphic novel series Scott Pilgrim by Bryan Lee O\'Malley. It stars an ensemble cast, with Michael Cera as Scott Pilgrim, a slacker musician who is trying to win a competition to get a record deal, while also battling the seven evil exes of his new girlfriend Ramona Flowers, played by Mary Elizabeth Winstead.', 'https://m.media-amazon.com/images/M/MV5BNTA5ZWMwNmYtNWI1ZS00NDRlLTkxNzktMzdhZDU2ZDhjNDJmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://res.cloudinary.com/jerrick/image/upload/v1616461970/60594092376f3d001e02e355.jpg'),
(3, 'The Blair Witch Project\r\n', 'The Blair Witch Project is a 1999 American psychological horror film written, directed, and edited by Daniel Myrick and Eduardo Sánchez. One of the most successful independent films of all time, it is a \"found footage\" pseudo-documentary in which three students (Heather Donahue, Michael C. Williams, and Joshua Leonard) hike into the Black Hills near Burkittsville, Maryland, to shoot a documentary about a local myth known as the Blair Witch.', 'https://image.tmdb.org/t/p/original/9050VGrYjYrEjpOvDZVAngLbg1f.jpg', 'https://lightbox-prod.imgix.net/images/assets/BANNER_LANDSCAPE_mac_10598147_73CE84BA-A331-40BB-B139B5A21AEB13AB.jpg'),
(4, 'Gravity', 'Gravity is a 2013 science fiction thriller film directed by Alfonso Cuarón, who also co-wrote, co-edited, and produced the film. It stars Sandra Bullock and George Clooney as American astronauts who attempt to return to Earth after the destruction of their Space Shuttle in orbit.', 'https://upload.wikimedia.org/wikipedia/en/f/f6/Gravity_Poster.jpg', 'https://assets.scriptslug.com/live/img/x/posters/3122/gravity-2013_669f4c9eb7.jpg'),
(5, 'Bambi', 'Bambi is a 1942 American animated coming-of-age drama film[4] produced by Walt Disney Productions and released by RKO Radio Pictures. Loosely based on Felix Salten\'s 1923 novel Bambi, a Life in the Woods, the production was supervised by David D. Hand, and was directed by a team of sequence directors, including James Algar, Bill Roberts, Norman Wright, Sam Armstrong, Paul Satterfield, and Graham Heid.', 'https://i.ebayimg.com/images/g/360AAOSwkz5hWRit/s-l1200.jpg', 'https://i.pinimg.com/736x/ea/61/f3/ea61f3a84e551fb378e4d93de1c99ac9.jpg'),
(6, 'School of Rock', 'School of Rock (titled onscreen as The School of Rock) is a 2003 comedy film directed by Richard Linklater, produced by Scott Rudin and written by Mike White. The film stars Jack Black, Joan Cusack, White and Sarah Silverman. Black plays struggling rock guitarist Dewey Finn, who is fired from his band and subsequently poses as a substitute teacher at a prestigious prep school. After witnessing the musical talent of the students, Dewey forms a band of fifth-graders to attempt to win the upcoming Battle of the Bands and use his winnings to pay his rent.', 'https://i.ebayimg.com/images/g/HscAAOSwXeJe7gUj/s-l1200.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRF_kPCNTBFjqbr94EATxuQGJ1tiJzDhwtpAg&s'),
(7, 'Thunderbolts*', 'After finding themselves ensnared in a death trap, an unconventional team of antiheroes must embark on a dangerous mission that will force them to confront the darkest corners of their pasts.', 'https://i.ebayimg.com/images/g/jCkAAOSwk0hm8sPc/s-l1200.jpg', 'https://knightedgemedia.com/wp-content/uploads/2024/09/thunderbolts-teaser-trailer-banner.jpg'),
(8, 'The Wild Robot', 'After a shipwreck, an intelligent robot is stranded on an uninhabited island. To survive the harsh surroundings, she bonds with the native animals and cares for an orphaned baby goose.', 'https://s3.amazonaws.com/nightjarprod/content/uploads/sites/261/2024/08/15103059/wTnV3PCVW5O92JMrFvvrRcV39RU-scaled.jpg\r\n', 'https://snworksceo.imgix.net/jhn/bd7e4343-598d-4c3e-bf93-c2c10ccb1555.sized-1000x1000.png?w=1000'),
(9, 'Wicked', 'Misunderstood because of her green skin, a young woman named Elphaba forges an unlikely but profound friendship with Glinda, a student with an unflinching desire for popularity. Following an encounter with the Wizard of Oz, their relationship soon reaches a crossroad as their lives begin to take very different paths.\r\n', 'https://upload.wikimedia.org/wikipedia/en/thumb/5/57/Wicked_2024_whisper_poster.jpg/250px-Wicked_2024_whisper_poster.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqrZ2truFKXrtUFVl_3ioFO63zmbNg4E2pbw&s'),
(10, 'Bullet Train', 'Ladybug is an unlucky assassin who\'s determined to do his job peacefully after one too many gigs has gone off the rails. Fate, however, may have other plans as his latest mission puts him on a collision course with lethal adversaries from around the globe -- all with connected yet conflicting objectives -- on the world\'s fastest train.', 'https://image.tmdb.org/t/p/original/j8szC8OgrejDQjjMKSVXyaAjw3V.jpg', 'https://flixchatter.net/wp-content/uploads/2022/08/bullet-train-poster.jpg?w=640'),
(11, 'Oppenheimer', 'During World War II, Lt. Gen. Leslie Groves Jr. appoints physicist J. Robert Oppenheimer to work on the top-secret Manhattan Project. Oppenheimer and a team of scientists spend years developing and designing the atomic bomb. Their work comes to fruition on July 16, 1945, as they witness the world\'s first nuclear explosion, forever changing the course of history.', 'https://m.media-amazon.com/images/M/MV5BN2JkMDc5MGQtZjg3YS00NmFiLWIyZmQtZTJmNTM5MjVmYTQ4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://goldendiscs.ie/cdn/shop/collections/Header_Oppenheimer_2for25_460x@2x.png?v=1697618018'),
(12, 'The Diplomat', 'Amid an international crisis, a career diplomat juggles her new high-profile job as ambassador to the United Kingdom and her turbulent marriage to a political star.', 'https://m.media-amazon.com/images/M/MV5BNjFkZTBlYjgtMDA2OS00YjI2LWFiNjMtNWIxZTljYTEzMjRiXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhz9DhD0j8chxKmkFgmKO_gItQ_aBg4bnX4w&s'),
(13, 'Dungeons & Dragons: Honor Among Thieves', 'A charming thief and a band of unlikely adventurers embark on an epic quest to retrieve a long lost relic, but their charming adventure goes dangerously awry when they run afoul of the wrong people.', 'https://m.media-amazon.com/images/M/MV5BOGRjMjQ0ZDAtODc0OS00MGY1LTkxMTMtODhhNjY5NTM4N2IwXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg\r\n', 'https://dungeonsanddragonsfan.com/wp-content/uploads/2023/03/dnd-movie-honor-among-thieves-review-hero.png'),
(14, 'Skill House', 'A dark satire of social media and influencer culture, unflinching take on fame and what new celebrities are willing to do to attain it.', 'https://pbs.twimg.com/media/Gnaft3uWYAAPGGM.jpg', 'https://pbs.twimg.com/profile_images/1697506977809907712/PbCSbOPt_400x400.jpg'),
(15, 'Interstellar', 'In Earth\'s future, a global crop blight and second Dust Bowl are slowly rendering the planet uninhabitable. Professor Brand (Michael Caine), a brilliant NASA physicist, is working on plans to save mankind by transporting Earth\'s population to a new home via a wormhole. But first, Brand must send former NASA pilot Cooper (Matthew McConaughey) and a team of researchers through the wormhole and across the galaxy to find out which of three planets could be mankind\'s new home.', 'https://upload.wikimedia.org/wikipedia/en/b/bc/Interstellar_film_poster.jpg\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3G7v0v1Zj-amNdX5Ve8h3R_68mukwcWT9ZQ&s'),
(16, 'The Spiderwick Chronicles', 'Of the three Grace children, Jared (Freddie Highmore) has always been thought of as the troublemaker. So when strange things happen after his family\'s move to a relative\'s dilapidated estate, sister Mallory (Sarah Bolger), twin brother Simon and their mother assume that Jared is behind it all. However, magical creatures roam the grounds, and they all want a special book that Jared has found: a field guide to fantastic creatures, penned by Arthur Spiderwick.', 'https://static.wikia.nocookie.net/spiderwick/images/e/e4/Spiderwick_Film_Poster.jpg/revision/latest?cb=20240516090019\r\n', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4ZBx5WRQZCKwdQHygty6Irg0NA-RRFAM5Zw&s');

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
(6, 16);

-- --------------------------------------------------------

--
-- Table structure for table `movie_tickets`
--

CREATE TABLE `movie_tickets` (
  `movie_tix_id` int(11) NOT NULL,
  `showing_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_tickets`
--

INSERT INTO `movie_tickets` (`movie_tix_id`, `showing_id`, `seat_id`, `user_id`, `booking_time`) VALUES
(5, 45, 13, 2, '2025-04-16 13:53:14'),
(6, 45, 14, 2, '2025-04-16 13:53:14');

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
(13, 2, 2, 45, 'F', 4),
(14, 2, 2, 45, 'F', 5);

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
  `show_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `showings`
--

INSERT INTO `showings` (`showing_id`, `movie_id`, `cinema_id`, `price`, `show_date`, `show_time`) VALUES
(22, 1, 10, 390, '2025-04-30', '20:00:00'),
(23, 6, 3, 390, '2025-05-17', '20:00:00'),
(24, 7, 2, 450, '2025-05-20', '20:00:00'),
(25, 16, 6, 360, '2025-04-24', '20:00:00'),
(26, 2, 7, 350, '2025-05-28', '16:00:00'),
(27, 1, 10, 390, '2025-05-03', '16:00:00'),
(28, 15, 2, 450, '2025-04-19', '12:00:00'),
(29, 11, 7, 350, '2025-05-04', '12:00:00'),
(30, 5, 9, 350, '2025-04-22', '16:00:00'),
(31, 12, 4, 360, '2025-04-15', '20:00:00'),
(32, 8, 3, 390, '2025-05-01', '16:00:00'),
(33, 13, 6, 360, '2025-04-25', '16:00:00'),
(34, 10, 2, 450, '2025-05-02', '20:00:00'),
(35, 4, 1, 360, '2025-04-12', '16:00:00'),
(36, 3, 3, 390, '2025-04-18', '16:00:00'),
(37, 14, 8, 350, '2025-05-05', '12:00:00'),
(38, 5, 9, 350, '2025-05-10', '20:00:00'),
(39, 9, 2, 450, '2025-05-09', '12:00:00'),
(40, 13, 3, 390, '2025-05-08', '16:00:00'),
(41, 11, 7, 350, '2025-05-12', '20:00:00'),
(42, 2, 6, 360, '2025-05-14', '16:00:00'),
(43, 16, 3, 390, '2025-05-21', '16:00:00'),
(44, 14, 9, 350, '2025-04-16', '12:00:00'),
(45, 1, 2, 450, '2025-05-22', '16:00:00'),
(46, 5, 6, 360, '2025-04-27', '12:00:00'),
(47, 8, 1, 360, '2025-04-23', '20:00:00'),
(48, 12, 7, 350, '2025-05-18', '20:00:00'),
(49, 10, 4, 360, '2025-04-29', '16:00:00'),
(50, 13, 2, 450, '2025-05-07', '20:00:00'),
(51, 3, 6, 360, '2025-04-26', '20:00:00'),
(52, 15, 8, 350, '2025-05-06', '16:00:00'),
(53, 2, 1, 360, '2025-05-19', '20:00:00'),
(54, 7, 4, 360, '2025-04-13', '20:00:00'),
(55, 14, 9, 350, '2025-05-13', '12:00:00'),
(56, 5, 2, 450, '2025-05-23', '20:00:00'),
(57, 10, 7, 350, '2025-05-24', '16:00:00'),
(58, 8, 4, 360, '2025-05-25', '20:00:00'),
(59, 12, 6, 360, '2025-05-26', '12:00:00'),
(60, 15, 3, 390, '2025-04-17', '20:00:00'),
(61, 11, 10, 390, '2025-05-27', '16:00:00'),
(62, 9, 5, 360, '2025-05-30', '16:00:00'),
(63, 7, 3, 390, '2025-04-20', '16:00:00'),
(64, 14, 10, 390, '2025-04-14', '12:00:00'),
(65, 10, 5, 360, '2025-04-21', '16:00:00'),
(66, 1, 9, 350, '2025-04-11', '12:00:00'),
(67, 16, 2, 450, '2025-05-11', '12:00:00'),
(68, 6, 7, 350, '2025-05-29', '16:00:00'),
(69, 13, 8, 350, '2025-05-18', '12:00:00'),
(70, 3, 4, 360, '2025-04-06', '12:00:00'),
(71, 4, 10, 390, '2025-05-15', '12:00:00');

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `s_name`, `email`, `password`, `user_type`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', 'admin', 'admin', '2025-04-14 07:23:14'),
(2, 'Jose', 'Rizal', 'jose@rizal.com', 'jose', 'customer', '2025-04-14 19:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(10) NOT NULL,
  `venue_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `address`, `event_type`, `image`) VALUES
(3, 'Mall of Asia', 'SM Mall of Asia, Seaside Blvd, Pasay, 1300 Metro Manila', 'Movie', ''),
(4, 'Ayala Malls Manila Bay', 'Macapagal Boulevard cor. Asean Avenue, Aseana City, Tambo, Parañaque, Metro Manila', 'Movie', ''),
(5, 'Robinsons Place Manila', 'Pedro Gil, cor Adriatico St, Ermita, Manila, 1000 Metro Manila', 'Movie', '');

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `v_id` (`v_id`);

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
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `movie_tickets`
--
ALTER TABLE `movie_tickets`
  MODIFY `movie_tix_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seats_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD CONSTRAINT `cinemas_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`v_id`) REFERENCES `venues` (`venue_id`) ON DELETE CASCADE;

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
