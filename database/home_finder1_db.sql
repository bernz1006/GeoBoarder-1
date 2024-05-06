-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2023 at 07:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_finder1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_establishment`
--

CREATE TABLE `account_establishment` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `map` text NOT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `permit_file` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `contact` varchar(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `payment_details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_establishment`
--

INSERT INTO `account_establishment` (`id`, `email`, `password`, `name`, `address`, `map`, `cover_photo`, `permit_file`, `price`, `status`, `contact`, `type`, `payment_details`) VALUES
(1, 'voxpopolimendieta@gmail.com', '$2y$10$4S0/t8joYyp/fRfB4XbQiuiD/PYezQdjh6syGOt8zJbbA7hFxI0Vq', 'Vox', 'Cabanatuan, Sumacab Este', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d346.52813263064337!2d120.94510698262631!3d15.443806653310439!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397270947f6eff1%3A0x6a180a8c974aabb!2sVox%20Hotel!5e0!3m2!1sen!2sph!4v1697896387909!5m2!1sen!2sph\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade', 'uploads/building.jpg', '', '3500.00', 'approved', '09707060100', 'boarding_house', 'GCASH - 09707060100 M.R'),
(2, 'lloydsanguyo12@gmail.com', '$2y$10$DY3qs0KdmoHw4h.tQJcvb.r31vpNsTVjX7IoJnBy2y.y7FWFcYnKe', 'Triple J', 'Cabanatuan, Sumacab Este', '', 'uploads/cabanatuan7.jpg', '', '1500.00', 'approved', '0', 'bedspace', ''),
(3, 'popoli@gmail.com', '$2y$10$mBI3WhCxyRwMucHbtT4ggeNjpV9S6vTMwpbKhseUEJGsWqTGIa7/2', 'Lloyd', 'Cabanatuan, Sumacab Este', '', 'upload/cabanatuan2.jpg', '', '6000.00', 'approved', '0', '', ''),
(4, 'lloydsanguyo1@gmail.com', '$2y$10$Iv4dwG686hci7pL1pmv9LOgmESwTVkNdsIexUuxaJaVm5Pmlf6NHO', '3\'s Marias Apartment', 'Cabanatuan, Sumacab Este', '', 'uploads/download2.jpg', '', '1250.00', 'approved', '0', '', ''),
(5, 'manna@gmail.com', '$2y$10$AJ4dq8zNqbZzbxmY9s4oTuqM9hleGNtMEc7pG46phk7i/CwMpAe1i', 'Manna Building', 'Cabanatuan, Sumacab Este', '', 'uploads/building.jpg', '', '5000.00', 'approved', '0', '', ''),
(6, 'uc@gmail.com', '$2y$10$FC7Te0E4wZV62AS9KwOMoedhWBX3peCLJpSIzA6gBDtRT9hpQa9Zq', 'UC Dormitory', 'Cabanatuan, Sumacab Este', '', 'uploads/g6.jpg', '', '8000.00', 'approved', '0', '', ''),
(7, 'ansak@gmail.com', '$2y$10$p9YJBz5/0vWws.N5PgxKNuhUjX2TvHwRDq8hDx/AdDU/lc33KeRkm', 'Ansak Beach House', 'Cabanatuan, Sumacab Este', '', 'uploads/transient2.jpg', '', '7500.00', 'approved', '0', '', ''),
(8, 'inno@gmail.com', '$2y$10$xnQhr9l8JnzKhtKcFrEZuenhVp1rGnwVHLJZs0rgqzsZtgbZP/xum', 'Inno Boarding', 'Cabanatuan, Sumacab Este', '', 'uploads/boarding2.jpg', '', '1000.00', 'approved', '0', '', ''),
(9, 'karla@gmail.com', '$2y$10$dGEWoCzXfu3o7t5rHekAZ.MKfWAXTSQcBkYG4CkTeEecKvQxqstqe', 'Karla Building', 'Cabanatuan, Sumacab Este', '', 'uploads/652ff7fb87919_red.jpg', '', '1300.00', 'approved', '0', '', ''),
(10, 'shannen@gmail.com', '$2y$10$LnjLmN9BgCwv1d/K5PBQAOCLkTyacYPECZ/8DNV.3QMZULdicADge', 'Shannen Bio Chem Building', 'Cabanatuan, Sumacab Este', 'https://maps.app.goo.gl/DkEEH22PPqoWramB7', 'uploads/652fde17d3506_black.jpg', '', '2500.00', 'approved', '0', '', ''),
(11, 'jaja@gmail.com', '$2y$10$PZGcDMHWWhVwDVh2MHF3..p8Wz/gcrTR5NUoHdPSm3ipWXU79WsCy', 'Jaja Apartment', 'Cabanatuan, Sumacab Este', 'https://maps.app.goo.gl/DkEEH22PPqoWramB7', 'uploads/652fdd49ed36a_boarding2.jpg', '', '1500.00', 'approved', '0', '', ''),
(12, 'rendel@gmail.com', '$2y$10$ILSnLVr.Ir2olok4Ghd6UOg6JOa8FcNtngp5BhIOEkOq4MGuYlCUS', 'Rendel Maningas', '', '', 'uploads/', '', '0.00', 'pending', '', '', ''),
(13, 'ken@gmail.com', '$2y$10$G/nBp6V9UzMv7gQnUhNvaurcXnDaMv//SIPraZi0B0vv4NkTy3A2i', 'Ken', '12312', '', 'uploads/3-ingredient-garlic-herb-grilled-chicken-wings.jpg', '', '1000.00', 'approved', '', '', ''),
(14, 'ken@test.com', '$2y$10$HW5pVv30G0PFBnIgieqseuzWtGt9vYw3otCM.K7mx0x1AjeXUXUKu', 'Ken', 'Cabanatuan City', 'test', 'uploads/black.jpg', '', '1000.00', 'declined', '123131', '', ''),
(15, '', '$2y$10$F5uRIeQ4NomYH0WLuk3DwOH6IWllnuG.folenn.rcyKIBgIz9I5Gu', '', '', '', 'uploads/', '', '0.00', 'approved', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `selfie_file` varchar(255) NOT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Denied') NOT NULL DEFAULT 'Pending',
  `approval_date` timestamp NULL DEFAULT NULL,
  `valid_id_file` varchar(255) NOT NULL,
  `proof_of_payment_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `room_id`, `name`, `contact`, `email`, `address`, `selfie_file`, `reservation_date`, `status`, `approval_date`, `valid_id_file`, `proof_of_payment_file`) VALUES
(1, 1, 'vox ', '09123456789', 'voxpopolimendieta@gmail.com', 'Cabanatuan, Sumacab Este', 'uploads/652fdd49ed36a_boarding2.jpg', '2023-11-07 14:10:01', 'Approved', NULL, '', ''),
(2, 1, 'Lloyd', '09482038418', 'lloydsanguyo12@gmail.com', 'Pantabangan', 'uploads/652fdecedbb19_boarding1.jpg', '2023-11-07 14:45:30', 'Approved', NULL, '', ''),
(3, 1, 'marvin', '09123456789', 'marvin@gmail.com', 'Gen. Tinio', 'uploads/652fde17d3506_black.jpg', '2023-11-07 14:47:24', 'Approved', NULL, '', ''),
(4, 1, 'FEEL', '09123456789', 'feel@gmail.com', 'Gen. Tinio', 'uploads/652fdcd61f9ba_black.jpg', '2023-11-07 14:53:25', 'Approved', NULL, '', ''),
(5, 12, 'jerelyn', '12345678910', 'jerelyn@gmail.com', 'Gen. Tinio', 'uploads/652fdecedbb19_boarding1.jpg', '2023-11-07 14:56:52', 'Approved', NULL, '', ''),
(6, 12, 'Maam Apol', '09123456789', 'voxpopolimendieta@gmail.com', 'Cabanatuan, Sumacab Este', 'uploads/652fde17d3506_black.jpg', '2023-11-08 07:15:54', 'Approved', NULL, '', ''),
(7, 1, 'Maam Apol', '09123456789', 'voxpopolimendieta@gmail.com', 'Cabanatuan, Sumacab Este', 'uploads/652fde17d3506_black.jpg', '2023-11-08 07:48:12', 'Pending', NULL, '', ''),
(8, 12, 'ken', '09123456789', 'voxpopolimendieta@gmail.com', 'Cabanatuan, Sumacab Este', 'uploads/652fe710bd2a1_dormitory1.jpg', '2023-11-09 04:08:40', 'Denied', NULL, '', ''),
(34, 16, 'test', 'teest1231', 'test@gmail.com', 'asdfa', 'uploads/3-ingredient-caramel-pear-galette.jpg', '2023-11-09 18:06:22', 'Pending', NULL, '', ''),
(35, 0, 'rendel', '123131', 'adaw@gmail.com', '1231', 'uploads/-em-ba-em-s-ultimate-lobster-rolls-51169080.jpg', '2023-11-10 02:36:51', 'Pending', NULL, 'uploads/valid_id/3-ingredient-caramel-pear-galette.jpg', ''),
(36, 0, 'rendel', '123131', 'adaw@gmail.com', '1231', 'uploads/-em-ba-em-s-ultimate-lobster-rolls-51169080.jpg', '2023-11-10 02:37:35', 'Pending', NULL, 'uploads/valid_id/3-ingredient-caramel-pear-galette.jpg', ''),
(37, 0, 'rendlee', '123131', 'adaw@gmail.com', '12312', 'uploads/3-ingredient-brown-butter-shortbread.jpg', '2023-11-10 02:37:53', 'Pending', NULL, 'uploads/valid_id/1-2-3-4-cake-51128010.jpg', ''),
(38, 14, 'rendel', '123413', 'test@gmail.com', 'awda', 'uploads/3-ingredient-curry-grilled-chicken-wings.jpg', '2023-11-10 02:38:45', 'Pending', NULL, 'uploads/valid_id/3-ingredient-flourless-chocolate-cake.jpg', ''),
(39, 12, 'Rendel', '12313123', 'rendel@gmail.com', 'adwa', 'uploads/cabanatuan2.jpg', '2023-11-10 14:13:45', 'Approved', NULL, 'uploads/valid_id/black.jpg', ''),
(40, 12, 'Carlosss', '123131', 'adwad@gmail.com', 'awda', 'uploads/RobloxScreenShot20230710_175557328.png', '2023-11-10 18:09:25', 'Pending', NULL, 'uploads/valid_id/RobloxScreenShot20230602_150222706.png', 'uploads/proof_of_payment/images.png');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `availability` enum('Available','Not Available') NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `max` int(11) NOT NULL,
  `features` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `description`, `price`, `availability`, `establishment_id`, `image_path`, `max`, `features`) VALUES
(1, 'Room 1', 'test', NULL, 'Available', 2, 'images/652fde17d3506_black.jpg', 9, ''),
(2, '', NULL, NULL, 'Available', 2, 'images/652fdecedbb19_boarding1.jpg', 0, ''),
(3, '', NULL, NULL, 'Available', 2, 'images/652fdf48943ee_cabanatuan2.jpg', 0, ''),
(4, '', NULL, NULL, 'Available', 2, 'images/652fe6326d39e_building.jpg', 0, ''),
(5, '', NULL, NULL, 'Available', 2, 'images/652fe6ea158c1_boarding1.jpg', 0, ''),
(6, 'Room 1', NULL, NULL, 'Available', 1, 'images/652fe710bd2a1_dormitory1.jpg', 0, ''),
(7, '', NULL, NULL, 'Available', 4, 'images/652ff6fe32e5c_cabanatuan3.jpg', 0, ''),
(8, '', NULL, NULL, 'Available', 4, 'images/652ff737caa01_cabanatuan2.jpg', 0, ''),
(9, '', NULL, NULL, 'Available', 3, 'images/652ff7fb87919_red.jpg', 0, ''),
(10, '', NULL, NULL, 'Available', 3, 'images/652ffa0509521_boarding1.jpg', 0, ''),
(11, '', NULL, NULL, 'Available', 10, 'images/653291aeefe8e_652fdd49ed36a_boarding2.jpg', 0, ''),
(12, 'Room 2', NULL, NULL, 'Available', 1, 'images/6549a4302b2ac_652fdcd61f9ba_black.jpg', 10, ''),
(13, 'Room 3', NULL, NULL, 'Available', 1, 'images/6549a6ae85270_652fdd49ed36a_boarding2.jpg', 0, ''),
(17, 'Room 211', 'test', '1000.00', 'Available', 1, 'uploads/photo.PNG', 1, 'Wifi, Plantsa'),
(18, 'Room 40', 'Hello', '2500.00', 'Available', 14, 'uploads/photo.PNG', 1, 'Wifi');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studID` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `profileupload` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_establishment`
--
ALTER TABLE `account_establishment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `establishment_id` (`establishment_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_establishment`
--
ALTER TABLE `account_establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `account_establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
