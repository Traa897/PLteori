-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Okt 2025 pada 05.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_management`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `director` varchar(100) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Durasi dalam menit',
  `release_date` date NOT NULL,
  `status` enum('akan_tayang','sedang_tayang','telah_tayang') NOT NULL,
  `synopsis` text DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `movies`
--

INSERT INTO `movies` (`id`, `title`, `director`, `genre`, `duration`, `release_date`, `status`, `synopsis`, `poster_url`, `created_at`, `updated_at`) VALUES
(1, 'Pengabdi Setan 3', 'Joko Anwar', 'Horror', 120, '2025-11-15', 'akan_tayang', 'Kelanjutan dari kisah keluarga yang dihantui masa lalu kelam mereka.', 'https://via.placeholder.com/300x450/FF0000/FFFFFF?text=Pengabdi+Setan+3', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(2, 'Siksa Kubur', 'Joko Anwar', 'Horror', 110, '2024-04-11', 'telah_tayang', 'Film horor yang menceritakan tentang siksaan di alam kubur.', 'https://via.placeholder.com/300x450/000000/FFFFFF?text=Siksa+Kubur', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(3, 'Dune: Part Three', 'Denis Villeneuve', 'Sci-Fi', 165, '2026-12-18', 'akan_tayang', 'Kelanjutan epik dari saga Dune yang memukau.', 'https://via.placeholder.com/300x450/D4A574/000000?text=Dune+3', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(4, 'Avatar 3', 'James Cameron', 'Sci-Fi', 180, '2025-12-20', 'telah_tayang', 'Petualangan baru di planet Pandora dengan teknologi visual terbaru.', 'https://via.placeholder.com/300x450/0099FF/FFFFFF?text=Avatar+3', '2025-10-27 01:57:10', '2025-10-27 04:30:52'),
(5, 'Godzilla x Kong: The New Empire', 'Adam Wingard', 'Action', 135, '2024-03-29', 'telah_tayang', 'Pertarungan epik antara dua titan legendaris melawan ancaman baru.', 'https://via.placeholder.com/300x450/FF6600/000000?text=Godzilla+x+Kong', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(6, 'Deadpool & Wolverine', 'Shawn Levy', 'Action/Comedy', 128, '2024-07-26', 'sedang_tayang', 'Kolaborasi dua superhero paling sarkastik di Marvel Universe.', 'https://via.placeholder.com/300x450/FF0000/FFFF00?text=Deadpool+Wolverine', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(7, 'Venom: The Last Dance', 'Kelly Marcel', 'Action', 120, '2024-10-25', 'sedang_tayang', 'Petualangan terakhir Eddie Brock dan Venom melawan musuh terkuat mereka.', 'https://via.placeholder.com/300x450/000000/FFFFFF?text=Venom+3', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(8, 'Wicked', 'Jon M. Chu', 'Musical', 160, '2024-11-22', 'sedang_tayang', 'Adaptasi musikal Broadway yang mengisahkan kisah Penyihir dari Oz.', 'https://via.placeholder.com/300x450/00FF00/000000?text=Wicked', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(9, 'Joker: Folie à Deux', 'Todd Phillips', 'Drama', 138, '2024-10-04', 'telah_tayang', 'Kelanjutan kisah Arthur Fleck dengan Harley Quinn.', 'https://via.placeholder.com/300x450/9900FF/FFFFFF?text=Joker+2', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(10, 'Gladiator II', 'Ridley Scott', 'Action/Drama', 155, '2024-11-15', 'sedang_tayang', 'Sekuel epik dari film Gladiator yang legendaris.', 'https://via.placeholder.com/300x450/8B4513/FFFFFF?text=Gladiator+II', '2025-10-27 01:57:10', '2025-10-27 01:57:10'),
(11, 'kang solah ', 'Herwin Novianto', 'Comedy', 169, '2025-02-25', 'sedang_tayang', '', 'https://media.themoviedb.org/t/p/w188_and_h282_bestv2/hfH54RSX7rGAlo6aS1HLyzLdM0B.jpg', '2025-10-27 03:55:43', '2025-10-27 03:55:43'),
(12, 'kikuk', 'maxim', 'horror', 159, '2025-01-26', 'telah_tayang', '', 'https://via.placeholder.com/300x450/4A90E2/FFFFFF?text=Movie+Poster', '2025-10-27 04:31:19', '2025-10-27 04:31:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
