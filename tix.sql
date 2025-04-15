-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 07:59 AM
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
(1, 3, 'MOA Cinema 1', 140, 14, 10, NULL),
(2, 3, 'MOA Director\'s Club', 48, 6, 8, NULL),
(3, 4, 'Ayala Manila Bay Cinema 1', 108, 9, 12, NULL);

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
(3, 'Family'),
(4, 'Fantasy'),
(21, 'Horror'),
(15, 'Melodrama'),
(13, 'Musical'),
(18, 'Mystery'),
(12, 'Romance'),
(14, 'Sci-fi'),
(17, 'Thriller');

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
(6, 'School of Rock', 'School of Rock (titled onscreen as The School of Rock) is a 2003 comedy film directed by Richard Linklater, produced by Scott Rudin and written by Mike White. The film stars Jack Black, Joan Cusack, White and Sarah Silverman. Black plays struggling rock guitarist Dewey Finn, who is fired from his band and subsequently poses as a substitute teacher at a prestigious prep school. After witnessing the musical talent of the students, Dewey forms a band of fifth-graders to attempt to win the upcoming Battle of the Bands and use his winnings to pay his rent.', 'https://i.ebayimg.com/images/g/HscAAOSwXeJe7gUj/s-l1200.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRF_kPCNTBFjqbr94EATxuQGJ1tiJzDhwtpAg&s');

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

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seats_id` int(11) NOT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `seat_row` char(2) DEFAULT NULL,
  `seat_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(13, 1, 1, 0, '2025-04-25', '12:00:00'),
(14, 1, 1, 0, '2025-04-25', '16:00:00'),
(15, 3, 2, 0, '2025-04-26', '20:00:00'),
(16, 4, 2, 0, '2025-04-27', '16:00:00'),
(17, 2, 3, 0, '2025-04-25', '12:00:00'),
(18, 1, 3, 0, '2025-04-25', '18:00:00'),
(19, 1, 1, 0, '2025-04-26', '12:00:00'),
(20, 1, 1, 0, '2025-04-26', '16:00:00'),
(21, 1, 2, 0, '2025-04-25', '18:00:00');

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
(4, 'Ayala Malls Manila Bay', 'Macapagal Boulevard cor. Asean Avenue, Aseana City, Tambo, Parañaque, Metro Manila', 'Movie', '');

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
  ADD KEY `cinema_id` (`cinema_id`);

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
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie_tickets`
--
ALTER TABLE `movie_tickets`
  MODIFY `movie_tix_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seats_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`cinema_id`);

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
