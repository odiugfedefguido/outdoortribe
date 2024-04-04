-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 04, 2024 alle 11:33
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `outdoortribe`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `activity`
--

CREATE TABLE `activity` (
  `typeActivity` varchar(255) NOT NULL,
  `idMap` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `altitudine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `activity`
--

INSERT INTO `activity` (`typeActivity`, `idMap`, `description`, `difficulty`, `duration`, `km`, `altitudine`) VALUES
('Cycling', 'map2', 'Explore the countryside on two wheels', 2, 90, 25, 200),
('Hiking', 'map1', 'Enjoy a scenic hike through the mountains', 3, 120, 10, 500),
('Running', 'map3', 'Go for a refreshing run along the river', 1, 60, 8, 50);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`typeActivity`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
