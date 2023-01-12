-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 12. jan 2023 ob 19.14
-- Različica strežnika: 10.4.27-MariaDB
-- Različica PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `teamfind`
--

-- --------------------------------------------------------

--
-- Struktura tabele `game`
--

CREATE TABLE `game` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `game`
--

INSERT INTO `game` (`ID`, `name`, `description`, `rating`) VALUES
(1, 'Call of Duty', 'You know this one', 3.5556),
(2, 'Control', NULL, 4);

-- --------------------------------------------------------

--
-- Struktura tabele `languages`
--

CREATE TABLE `languages` (
  `lang_eng` varchar(50) NOT NULL,
  `lang_local` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `languages`
--

INSERT INTO `languages` (`lang_eng`, `lang_local`) VALUES
('chinese', '汉语'),
('croatian', 'hrvatski'),
('english', 'english'),
('german', 'deutsch'),
('korean', '한국어'),
('slovenian', 'slovenščina');

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `game_times` bigint(20) DEFAULT 0,
  `language` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `game_days` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`username`, `email`, `password`, `game_times`, `language`, `contact`, `game_days`) VALUES
('1', 'ddsd@hh.si', '$2y$10$.eG4AsDrIvZ/cHQZsja2BOJcC.nPrlNpyUZ92z4uZyc/GHCcM7lqm', 198412, 'chinese', 'dd555sd@hh.si', 127),
('123', 'val.vec1@gmail.com', '$2y$10$LVmpXlAAfJuUeXDSpLM.JuWTsseJCzE7JAIoOtejO7dHCSCjdgkl2', 8388615, 'german', 'contact', 127),
('2', 'ddsd@hh.si', '$2y$10$F1u1xP5xNlfjr.GKH3XU0OJySsbSH8pm/Zdv0evT1fBVDG4Bgtzdi', 131, 'slovenian', 'contact', 127),
('3636', '', '$2y$10$RIALjk/ACNvjlABd4LkpGuDg.jsEy5MMfutgZeXbIgroZPHVW/g2a', 0, 'chinese', 'contact', 127),
('55', '55', '$2y$10$P1GxSt.3dePFW0Z4xYaea.wdoBIOJ.IuvLLECt3tBD3ugjK3lsfay', 0, 'croatian', '', 0),
('757', '1212', '$2y$10$bONg8MAHkcOY7YNXQIPrTukuoobMVzg2NA1JfQcsjpeW5FgAW60wK', 0, 'chinese', '', 0),
('bizgec', 'nepove@gmail.hr', '$2y$10$cXRoaGCfBnS8WN1zDaRYZerMCwoLJhK23uY/v8CS9c5QK/J0ZGcBu', 33030, 'croatian', 'ig/bizgec', 127),
('ddd', 'ddd@hh.si', '$2y$10$FmrxEDVylC9p3c0nDAorKOz1/v6rlqzY.SvjuO21.sg', 0, 'slovenian', NULL, 0),
('ff', 'ggg@f', '$2y$10$o5IJuSfMQm02OTWHIwAmmODb7Gv1KVcOeXqCRTlbIXcnisd0aUn9q', 0, 'slovenian', '', 0),
('glista', 'glistagod@gmail.com', '$2y$10$aaKD88zl3oxiFV18xldNI.fNquHbg4mKBcp.uDQDjh30I22cDEb5a', 15728643, 'slovenian', 'glista@gmail.com', 127),
('s', 'ddsd@hh.si', '$2y$10$ueQtqQz4ssNxfWDsEXj0Nuh0LU/3Qna44JDkvW/J.9aRTeOAGe8XO', 55, 'slovenian', 'dd555sd@hh.si', 7),
('ssfdvds', 'ddsd@hh.si', '$2y$10$za3CjtyNM3kqDWZK3OPGHOJ8mS.l9GjpUOqNstVi0dy', 0, 'slovenian', '', 0),
('ssfdvwds', 'ddsd@hh.si', '$2y$10$rILb9TFeW7m7qacL5jhllucNCwnV8HqU.rTjQO0.9x48gvl1xevpu', 3, 'slovenian', 'dd555sd@hh.si', 3),
('ssfvs', 'ddsd@hh.si', '$2y$10$GIdloWpG3zzIDWy6DUghFuFELFBh4Z/Kto9p/w2.0jd', 0, 'slovenian', '', 0),
('testni_up', 'plswork@gmail.si', '$2y$10$fvyd7aPB6X6QDX0JRsHCS.S6xvj.f6IyWxImgnvGaFLmr98gYqWW.', 1065216, 'chinese', '@ig/lolek', 127),
('user', 'test@testmail.si', '*CAAC3CD302CBC370570BA4A6474212262A227F73', 3, 'slovenian', NULL, 3),
('vilster', 'vilster@gmail.com', '$2y$10$PKiy3Cy9I9WkdEZtrM6X1OEi3.vHEFniEOYyqcVFVXF.L6ItV40ea', 390, 'slovenian', 'vilster', 127),
('ww', 'hdh', '$2y$10$cxLfuf2qkMgaFz3QDSQBYuu/aPLvBmV6FL8uY40.AZzMEoYdb/yry', 8388611, 'slovenian', 'contact', 127),
('zadnjitest', 'val.vec1@gmail.com', '$2y$10$rb/oi6I9OchkhmFinvLtjudUjfL0kXUrepkZiLNQUgTj.SLbYsuD2', 8388615, 'slovenian', 'watsup', 127);

-- --------------------------------------------------------

--
-- Struktura tabele `user_game_relation`
--

CREATE TABLE `user_game_relation` (
  `username` varchar(50) NOT NULL,
  `game_id` int(11) NOT NULL,
  `subscribed` tinyint(1) NOT NULL DEFAULT 0,
  `rating` int(11) DEFAULT NULL,
  `rel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `user_game_relation`
--

INSERT INTO `user_game_relation` (`username`, `game_id`, `subscribed`, `rating`, `rel_id`) VALUES
('user', 1, 1, 4, 1),
('user', 2, 1, 5, 2),
('ssfdvwds', 1, 1, 5, 3),
('2', 1, 1, 5, 4),
('2', 2, 1, 4, 5),
('bizgec', 1, 1, 2, 6),
('glista', 1, 1, 2, 7),
('vilster', 1, 0, 5, 8),
('vilster', 2, 1, 3, 9),
('123', 1, 1, 4, 10),
('zadnjitest', 1, 1, 2, 11),
('zadnjitest', 2, 1, NULL, 12),
('3636', 1, 1, NULL, 13),
('ww', 1, 0, 3, 14);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksi tabele `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_eng`);

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `language` (`language`);

--
-- Indeksi tabele `user_game_relation`
--
ALTER TABLE `user_game_relation`
  ADD PRIMARY KEY (`rel_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `game`
--
ALTER TABLE `game`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `user_game_relation`
--
ALTER TABLE `user_game_relation`
  MODIFY `rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`lang_eng`);

--
-- Omejitve za tabelo `user_game_relation`
--
ALTER TABLE `user_game_relation`
  ADD CONSTRAINT `user_game_relation_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `game` (`ID`),
  ADD CONSTRAINT `user_game_relation_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
