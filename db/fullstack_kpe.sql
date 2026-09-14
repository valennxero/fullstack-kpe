-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Aug 31, 2026 at 08:33 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fullstack_kpe`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemain`
--

CREATE TABLE `detail_pemain` (
  `idmovie` int NOT NULL,
  `idpemain` int NOT NULL,
  `peran` enum('Utama','Pembantu','Cameo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pemain`
--

INSERT INTO `detail_pemain` (`idmovie`, `idpemain`, `peran`) VALUES
(15, 1, 'Utama'),
(15, 2, 'Cameo'),
(16, 1, 'Cameo');

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `idgambar` int NOT NULL,
  `extension` varchar(4) NOT NULL,
  `idmovie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`idgambar`, `extension`, `idmovie`) VALUES
(1, 'jpg', 11),
(2, 'jpg', 12),
(3, 'jpg', 12),
(4, 'jpg', 13),
(5, 'jpg', 13),
(6, 'jpg', 13),
(7, '', 15),
(8, '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `idgenre` int NOT NULL,
  `nama` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`idgenre`, `nama`) VALUES
(1, 'Action'),
(2, 'Sci-Fi'),
(3, 'Drama'),
(4, 'Comedy'),
(5, 'Horror'),
(6, 'Crime'),
(7, 'Romance'),
(8, 'Anime');

-- --------------------------------------------------------

--
-- Table structure for table `genre_movie`
--

CREATE TABLE `genre_movie` (
  `id_movie` int NOT NULL,
  `id_genre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre_movie`
--

INSERT INTO `genre_movie` (`id_movie`, `id_genre`) VALUES
(12, 1),
(13, 1),
(15, 1),
(16, 1),
(12, 4),
(16, 6),
(12, 8),
(13, 8),
(15, 8);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `idmovie` int NOT NULL,
  `judul` varchar(45) NOT NULL,
  `rilis` date NOT NULL,
  `skor` double NOT NULL,
  `sinopsis` varchar(500) NOT NULL,
  `serial` tinyint(1) NOT NULL,
  `extension` varchar(4) NOT NULL,
  `genre` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `extention_new` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`idmovie`, `judul`, `rilis`, `skor`, `sinopsis`, `serial`, `extension`, `genre`, `extention_new`) VALUES
(1, 'Dark Inception', '2010-07-16', 8.8, 'Pencuri yang mencuri rahasia lewat teknologi berbagi mimpi mendapat tugas menanam sebuah ide.', 0, 'mp4', 'Sci-Fi', NULL),
(2, 'The Dark Knight', '2008-07-18', 9, 'Batman menghadapi Joker yang menebar kekacauan di kota Gotham.', 0, 'mkv', 'Action', NULL),
(3, 'Interstelldark', '2014-11-07', 8.6, 'Sekelompok penjelajah menembus lubang cacing demi menyelamatkan umat manusia.', 0, 'mp4', 'Sci-Fi', NULL),
(4, 'Parasite', '2019-05-30', 8.5, 'Keluarga miskin perlahan menyusup ke kehidupan keluarga kaya.', 0, 'mkv', 'Drama', NULL),
(5, 'Breaking Bad', '2008-01-20', 9.5, 'Guru kimia SMA berubah menjadi produsen narkoba demi masa depan keluarganya.', 1, 'mp4', 'Crime', NULL),
(6, 'Stranger Things', '2016-07-15', 8.7, 'Sekelompok anak menghadapi kekuatan supernatural di kota kecil Hawkins.', 1, 'mkv', 'Horror', NULL),
(7, 'The Matrix', '1999-03-31', 8.7, 'Seorang hacker menemukan bahwa realitas hanyalah simulasi komputer.', 0, 'avi', 'Sci-Fi', NULL),
(8, 'Spirited Away', '2001-07-20', 8.6, 'Gadis kecil terjebak di dunia roh dan harus berjuang menyelamatkan orang tuanya.', 0, 'mp4', 'Anime', NULL),
(9, 'Kungfu Soccer', '2026-08-28', 8, 'Sepakbola', 1, '.mp4', NULL, NULL),
(10, 'Kungfu Soccer', '2026-08-28', 8, 'Sepakbola', 1, '.mp4', NULL, NULL),
(11, 'Kungfu Soccer', '2026-08-28', 8, 'Sepakbola', 1, '.mp4', NULL, NULL),
(12, 'Kungfu Soccer', '2026-08-28', 8, 'Sepakbola', 1, '.mp4', NULL, NULL),
(13, 'Insidious', '2026-08-29', 6, 'Insidious ', 1, '.mp4', NULL, NULL),
(14, 'Insidious Part 2', '2026-09-04', 3, 'Insidious Part 2', 1, '.mp4', NULL, NULL),
(15, 'Insidious Part 2', '2026-09-04', 3, 'Insidious Part 2', 1, '.mp4', NULL, NULL),
(16, 'Test', '2026-08-29', 9, 'Test', 1, '.mp4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemain`
--

CREATE TABLE `pemain` (
  `idpemain` int NOT NULL,
  `nama` varchar(45) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemain`
--

INSERT INTO `pemain` (`idpemain`, `nama`, `gender`) VALUES
(1, 'Harry Potter', 'Pria'),
(2, 'Jennie Blackpink', 'Wanita');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pemain`
--
ALTER TABLE `detail_pemain`
  ADD PRIMARY KEY (`idmovie`,`idpemain`),
  ADD KEY `fk_idpemain` (`idpemain`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`idgambar`),
  ADD KEY `fk_idmovie` (`idmovie`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`idgenre`);

--
-- Indexes for table `genre_movie`
--
ALTER TABLE `genre_movie`
  ADD PRIMARY KEY (`id_movie`,`id_genre`),
  ADD KEY `fk_gm_genre` (`id_genre`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`idmovie`);

--
-- Indexes for table `pemain`
--
ALTER TABLE `pemain`
  ADD PRIMARY KEY (`idpemain`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `idgambar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `idgenre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `idmovie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pemain`
--
ALTER TABLE `pemain`
  MODIFY `idpemain` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pemain`
--
ALTER TABLE `detail_pemain`
  ADD CONSTRAINT `fk_idpemain` FOREIGN KEY (`idpemain`) REFERENCES `pemain` (`idpemain`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `fk_idmovie` FOREIGN KEY (`idmovie`) REFERENCES `movie` (`idmovie`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `genre_movie`
--
ALTER TABLE `genre_movie`
  ADD CONSTRAINT `fk_gm_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`idgenre`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_gm_movie` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`idmovie`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
