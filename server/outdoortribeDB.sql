-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 02:27 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `outdoortribedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `follow_id` int NOT NULL,
  `follower_id` int NOT NULL,
  `followed_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`follow_id`, `follower_id`, `followed_id`) VALUES
(1, 1, 3),
(2, 1, 7),
(3, 1, 9),
(4, 2, 5),
(5, 2, 6),
(6, 2, 7),
(7, 3, 8),
(8, 3, 12),
(9, 4, 10),
(10, 4, 13),
(12, 5, 2),
(11, 5, 4),
(15, 5, 14),
(13, 6, 1),
(14, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`) VALUES
(1, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`id`, `post_id`, `user_id`, `name`) VALUES
(1, 10, 1, 'adventure1.png'),
(2, 2, 2, 'adventure2.png'),
(3, 4, 2, 'adventure3.png'),
(4, 11, 2, 'adventure4.png'),
(5, 12, 3, 'adventure5.png'),
(6, 3, 3, 'adventure6.png'),
(7, 14, 1, 'adventure7.png'),
(8, NULL, 1, 'man1.png'),
(9, NULL, 2, 'woman1.png'),
(10, NULL, 3, 'man2.png'),
(11, NULL, 4, 'man3.png'),
(12, NULL, 5, 'woman2.png'),
(13, NULL, 6, 'man4.png'),
(14, NULL, 7, 'woman3.png'),
(15, NULL, 8, 'man5.png'),
(16, NULL, 9, 'woman4.png'),
(17, NULL, 10, 'man6.png'),
(18, NULL, 11, 'woman5.png'),
(19, NULL, 12, 'man7'),
(20, NULL, 13, 'woman6'),
(21, 11, 2, 'adventure1.png'),
(22, 11, 2, 'adventure2.png'),
(23, 11, 2, 'adventure3.png'),
(24, 11, 2, 'adventure5.png');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` time DEFAULT NULL,
  `length` float DEFAULT NULL,
  `max_altitude` float DEFAULT NULL,
  `min_altitude` float DEFAULT NULL,
  `max_ascent` float DEFAULT NULL,
  `min_descent` float DEFAULT NULL,
  `difficulty` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likes` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `location`, `activity`, `duration`, `length`, `max_altitude`, `min_altitude`, `max_ascent`, `min_descent`, `difficulty`, `likes`, `created_at`) VALUES
(2, 2, 'Gita in bicicletta al lago', 'Lago di Garda, Italia', 'Cycling', '02:00:00', 20, 200, 100, 100, 100, 'Easy', 30, '2024-04-20 08:40:12'),
(3, 3, 'Trekking nei Pirenei', 'Pirenei, Spagna', 'Trekking', '02:00:00', 15, 2500, 1500, 1000, 1000, 'Medium', 20, '2024-04-20 08:40:12'),
(4, 2, 'Escursione nella Foresta Nera', 'Foresta Nera, Germania', 'Trekking', '03:00:00', 10, 1000, 700, 300, 200, 'Medium', 20, '2024-04-20 17:42:16'),
(10, 1, 'Escursione sul lago', 'Lago di Como, Italia', 'Trekking', '02:00:00', 5, 200, 180, 20, 0, 'Easy', 30, '2024-04-22 13:16:47'),
(11, 2, 'Gita in montagna', 'Monte Bianco, Italia', 'Hiking', '04:00:00', 10, 1500, 1400, 100, 100, 'Medium', 25, '2024-04-22 13:16:47'),
(12, 3, 'Ciclismo costiero', 'Costa Amalfitana, Italia', 'Cycling', '03:00:00', 20, 100, 100, 0, 0, 'Easy', 40, '2024-04-22 13:16:47'),
(13, 2, 'Escursione nei boschi', 'Foresta Nera, Germania', 'Trekking', '05:00:00', 15, 50, 0, 50, 50, 'Medium', 35, '2024-04-22 13:16:47'),
(14, 1, 'Tour in bicicletta', 'Toscana, Italia', 'Cycling', '06:00:00', 30, 500, 200, 300, 100, 'Hard', 20, '2024-04-22 13:16:47'),
(15, 14, 'Escursione nei Monti Sibillini', 'Monti Sibillini, Italia', 'Trekking', '05:00:00', 15, 2500, 1000, 1500, 500, 'Medium', 30, '2024-04-22 18:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `post_ratings`
--

CREATE TABLE `post_ratings` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` decimal(3,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_ratings`
--

INSERT INTO `post_ratings` (`id`, `post_id`, `user_id`, `rating`, `created_at`) VALUES
(1, 15, 1, 4.00, '2024-05-03 11:22:23'),
(2, 15, 2, 5.00, '2024-05-03 11:22:23'),
(3, 15, 3, 4.50, '2024-05-03 11:22:23'),
(4, 15, 4, 2.50, '2024-05-03 11:22:23'),
(5, 15, 5, 3.00, '2024-05-03 11:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `shared_post`
--

CREATE TABLE `shared_post` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `shared_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shared_post`
--

INSERT INTO `shared_post` (`id`, `user_id`, `post_id`, `shared_at`) VALUES
(1, 1, 3, '2024-04-30 08:00:00'),
(2, 2, 10, '2024-04-30 09:30:00'),
(3, 3, 11, '2024-04-30 10:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `password`) VALUES
(1, 'mario', 'rossi', 'mario.rossi@gmail.com', '123'),
(2, 'anna', 'verdi', 'anna.verdi@gmail.com', '456'),
(3, 'franco', 'gialli', 'franco.gialli@gmail.com', '789'),
(4, 'Marco', 'Rossi', 'marco.rossi@example.com', 'password1'),
(5, 'Giulia', 'Bianchi', 'giulia.bianchi@example.com', 'password2'),
(6, 'Luca', 'Ricci', 'luca.ricci@example.com', 'password3'),
(7, 'Sara', 'Martini', 'sara.martini@example.com', 'password4'),
(8, 'Matteo', 'Moretti', 'matteo.moretti@example.com', 'password5'),
(9, 'Alessia', 'Conti', 'alessia.conti@example.com', 'password6'),
(10, 'Davide', 'Ferrari', 'davide.ferrari@example.com', 'password7'),
(11, 'Francesca', 'Barbieri', 'francesca.barbieri@example.com', 'password8'),
(12, 'Giovanni', 'Galli', 'giovanni.galli@example.com', 'password9'),
(13, 'Chiara', 'Gatti', 'chiara.gatti@example.com', 'password10'),
(14, 'Maurizio', 'Rossato', 'maurizio.rossato@gmeil.com', 'pass1');

-- --------------------------------------------------------

--
-- Table structure for table `waypoints`
--

CREATE TABLE `waypoints` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `km` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waypoints`
--

INSERT INTO `waypoints` (`id`, `post_id`, `km`, `title`, `description`) VALUES
(1, 11, 0, 'Parcheggio', 'Punto di partenza. Potete lasciare la macchina qui'),
(2, 11, 3, 'Sorgente', 'Acqua potabile. Puoi riempire la tua borraccia'),
(3, 11, 6, 'Rifugio', 'Qui si trova un rifugio in mezzo alla natura. Solitamente aperto nella stagione estiva. Cibo buonissimo e gestori cordiali'),
(4, 11, 8, 'Fiume', 'In questo punto il fiume è abbastanza profondo per immergersi'),
(5, 11, 10, 'Fine percorso', 'Il percorso si conclude al parcheggio iniziale');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`follow_id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_ratings`
--
ALTER TABLE `post_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shared_post`
--
ALTER TABLE `shared_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waypoints`
--
ALTER TABLE `waypoints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `follow_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post_ratings`
--
ALTER TABLE `post_ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shared_post`
--
ALTER TABLE `shared_post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `waypoints`
--
ALTER TABLE `waypoints`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `photo_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `post_ratings`
--
ALTER TABLE `post_ratings`
  ADD CONSTRAINT `post_ratings_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `post_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `shared_post`
--
ALTER TABLE `shared_post`
  ADD CONSTRAINT `shared_post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `shared_post_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Constraints for table `waypoints`
--
ALTER TABLE `waypoints`
  ADD CONSTRAINT `waypoints_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
