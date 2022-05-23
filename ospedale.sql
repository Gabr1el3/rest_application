-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 23, 2022 alle 23:05
-- Versione del server: 5.7.17
-- Versione PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ospedale`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuntamento`
--

CREATE TABLE `appuntamento` (
  `id_appuntamento` int(3) NOT NULL,
  `id_utente` int(3) NOT NULL,
  `id_visita` int(3) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `appuntamento`
--

INSERT INTO `appuntamento` (`id_appuntamento`, `id_utente`, `id_visita`, `date`) VALUES
(1, 4, 1, '2022-06-09'),
(2, 1, 2, '2022-05-30'),
(3, 2, 2, '2022-06-16'),
(5, 13, 3, '2022-05-23');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(3) NOT NULL,
  `tipologia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipologia`) VALUES
(1, 'Allergologica'),
(2, 'Cardiologica'),
(3, 'Dermatologica'),
(4, 'Diabetologica'),
(5, 'Gastroenterologica'),
(6, 'Odontoiatrica'),
(7, 'Pneumologica'),
(8, 'Psichiatrica'),
(9, 'Urologica'),
(10, 'Ortopedica'),
(11, 'Otorinolaringoiatrica');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id_utente` int(3) NOT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `eta` int(3) DEFAULT NULL,
  `sesso` set('M','F') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `cognome`, `nome`, `eta`, `sesso`) VALUES
(1, 'Amodeo', 'Gabriele', 19, 'M'),
(2, 'Ponti', 'Andrea', 18, 'M'),
(3, 'Valtolina', 'Alberto', 19, 'M'),
(4, 'Erario', 'Maria', 20, 'F'),
(5, 'Luciano', 'Rodolfo', 70, 'M'),
(6, 'Castoldi', 'Giorgio', 60, 'M'),
(7, 'Montanaro', 'Lorenzo', 19, 'M'),
(8, 'Vigano', 'Margherita', 25, 'F'),
(9, 'Kalulu', 'Pierre', 21, 'M'),
(10, 'Santillo', 'Vincenza', 20, 'F'),
(13, 'Gavioli', 'Alessio', 20, 'M');

-- --------------------------------------------------------

--
-- Struttura della tabella `visita`
--

CREATE TABLE `visita` (
  `id_visita` int(3) NOT NULL,
  `id_tipo` int(3) DEFAULT NULL,
  `nome_medico` varchar(30) DEFAULT NULL,
  `cognome_medico` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `visita`
--

INSERT INTO `visita` (`id_visita`, `id_tipo`, `nome_medico`, `cognome_medico`) VALUES
(1, 3, 'Davide', 'Diflorio'),
(2, 6, 'Simone', 'Epiglotti'),
(3, 2, 'Simone', 'Abbate'),
(4, 5, 'Ueldi', 'Ademi'),
(5, 1, 'Carlotta', 'Pezzoli'),
(6, 4, 'Mattia', 'Gabbia'),
(7, 7, 'Giorgio', 'Chiellini'),
(8, 8, 'Edoardo', 'Verdi');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD PRIMARY KEY (`id_appuntamento`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_visita` (`id_visita`);

--
-- Indici per le tabelle `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id_utente`);

--
-- Indici per le tabelle `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  MODIFY `id_appuntamento` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la tabella `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id_utente` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT per la tabella `visita`
--
ALTER TABLE `visita`
  MODIFY `id_visita` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD CONSTRAINT `appuntamento_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visita` (`id_visita`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appuntamento_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
