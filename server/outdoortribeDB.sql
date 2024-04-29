-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 29, 2024 alle 10:18
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

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
-- Struttura della tabella `follow`
--

CREATE TABLE `follow` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `follow`
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
-- Struttura della tabella `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `photo`
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
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `duration` time NOT NULL,
  `length` float NOT NULL,
  `max_altitude` float NOT NULL,
  `min_altitude` float NOT NULL,
  `max_ascent` float NOT NULL,
  `min_descent` float NOT NULL,
  `difficulty` varchar(6) NOT NULL,
  `rating` int(11) NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `location`, `activity`, `duration`, `length`, `max_altitude`, `min_altitude`, `max_ascent`, `min_descent`, `difficulty`, `rating`, `likes`, `created_at`) VALUES
(2, 2, 'Gita in bicicletta al lago', 'Lago di Garda, Italia', 'Cycling', '02:00:00', 20, 200, 100, 100, 100, 'Easy', 4, 30, '2024-04-20 08:40:12'),
(3, 3, 'Trekking nei Pirenei', 'Pirenei, Spagna', 'Trekking', '02:00:00', 15, 2500, 1500, 1000, 1000, 'Medium', 3, 20, '2024-04-20 08:40:12'),
(4, 2, 'Escursione nella Foresta Nera', 'Foresta Nera, Germania', 'Trekking', '03:00:00', 10, 1000, 700, 300, 200, 'Medium', 4, 20, '2024-04-20 17:42:16'),
(10, 1, 'Escursione sul lago', 'Lago di Como, Italia', 'Trekking', '02:00:00', 5, 200, 180, 20, 0, 'Easy', 4, 30, '2024-04-22 13:16:47'),
(11, 2, 'Gita in montagna', 'Monte Bianco, Italia', 'Hiking', '04:00:00', 10, 1500, 1400, 100, 100, 'Medium', 4, 25, '2024-04-22 13:16:47'),
(12, 3, 'Ciclismo costiero', 'Costa Amalfitana, Italia', 'Cycling', '03:00:00', 20, 100, 100, 0, 0, 'Easy', 4, 40, '2024-04-22 13:16:47'),
(13, 2, 'Escursione nei boschi', 'Foresta Nera, Germania', 'Trekking', '05:00:00', 15, 50, 0, 50, 50, 'Medium', 4, 35, '2024-04-22 13:16:47'),
(14, 1, 'Tour in bicicletta', 'Toscana, Italia', 'Cycling', '06:00:00', 30, 500, 200, 300, 100, 'Hard', 4, 20, '2024-04-22 13:16:47'),
(15, 14, 'Escursione nei Monti Sibillini', 'Monti Sibillini, Italia', 'Trekking', '05:00:00', 15, 2500, 1000, 1500, 500, 'Medium', 5, 30, '2024-04-22 18:17:15');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `user`
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
-- Struttura della tabella `waypoints`
--

CREATE TABLE `waypoints` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `waypoints`
--

INSERT INTO `waypoints` (`id`, `post_id`, `km`, `title`, `description`) VALUES
(1, 11, 0, 'Parcheggio', 'Punto di partenza. Potete lasciare la macchina qui'),
(2, 11, 3, 'Sorgente', 'Acqua potabile. Puoi riempire la tua borraccia'),
(3, 11, 6, 'Rifugio', 'Qui si trova un rifugio in mezzo alla natura. Solitamente aperto nella stagione estiva. Cibo buonissimo e gestori cordiali'),
(4, 11, 8, 'Fiume', 'In questo punto il fiume è abbastanza profondo per immergersi'),
(5, 11, 10, 'Fine percorso', 'Il percorso si conclude al parcheggio iniziale');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`follow_id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indici per le tabelle `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `waypoints`
--
ALTER TABLE `waypoints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `follow`
--
ALTER TABLE `follow`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `waypoints`
--
ALTER TABLE `waypoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `photo_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `waypoints`
--
ALTER TABLE `waypoints`
  ADD CONSTRAINT `waypoints_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
