-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2024 at 01:29 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist_records`
--

CREATE TABLE `checklist_records` (
  `record_id` int UNSIGNED NOT NULL,
  `period_id` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `room_id` int NOT NULL,
  `item_id` int NOT NULL,
  `actual_quantity` int NOT NULL,
  `missing_quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checklist_records`
--

INSERT INTO `checklist_records` (`record_id`, `period_id`, `room_id`, `item_id`, `actual_quantity`, `missing_quantity`) VALUES
(414, '1-January-2024', 1, 2, 10, 10),
(415, '1-January-2024', 1, 3, 0, 0),
(416, '1-January-2024', 1, 4, 0, 0),
(417, '1-January-2024', 1, 5, 0, 0),
(418, '1-January-2024', 1, 7, 0, 0),
(419, '1-January-2024', 1, 8, 0, 0),
(420, '1-January-2024', 1, 9, 0, 0),
(421, '1-January-2024', 1, 10, 0, 0),
(422, '1-January-2024', 1, 11, 0, 0),
(423, '1-January-2024', 1, 12, 0, 0),
(424, '1-January-2024', 1, 13, 0, 0),
(425, '1-January-2024', 1, 14, 0, 0),
(426, '1-January-2024', 1, 15, 0, 0),
(427, '1-January-2024', 1, 16, 0, 0),
(428, '1-January-2024', 1, 17, 0, 0),
(429, '1-January-2024', 1, 18, 0, 0),
(430, '1-January-2024', 1, 19, 0, 0),
(431, '1-January-2024', 2, 2, 2, 0),
(432, '1-January-2024', 2, 3, 0, 0),
(433, '1-January-2024', 2, 4, 0, 0),
(434, '1-January-2024', 2, 5, 0, 0),
(435, '1-January-2024', 2, 7, 0, 0),
(436, '1-January-2024', 2, 8, 0, 0),
(437, '1-January-2024', 2, 9, 0, 0),
(438, '1-January-2024', 2, 10, 0, 0),
(439, '1-January-2024', 2, 11, 0, 0),
(440, '1-January-2024', 2, 12, 0, 0),
(441, '1-January-2024', 2, 13, 0, 0),
(442, '1-January-2024', 2, 14, 0, 0),
(443, '1-January-2024', 2, 15, 0, 0),
(444, '1-January-2024', 2, 16, 0, 0),
(445, '1-January-2024', 2, 17, 0, 0),
(446, '1-January-2024', 2, 18, 0, 0),
(447, '1-January-2024', 2, 19, 0, 0),
(448, '1-June-2024', 1, 2, 1, 1),
(449, '1-June-2024', 1, 3, 0, 0),
(450, '1-June-2024', 1, 4, 0, 0),
(451, '1-June-2024', 1, 5, 0, 0),
(452, '1-June-2024', 1, 7, 0, 0),
(453, '1-June-2024', 1, 8, 0, 0),
(454, '1-June-2024', 1, 9, 0, 0),
(455, '1-June-2024', 1, 10, 0, 0),
(456, '1-June-2024', 1, 11, 0, 0),
(457, '1-June-2024', 1, 12, 0, 0),
(458, '1-June-2024', 1, 13, 0, 0),
(459, '1-June-2024', 1, 14, 0, 0),
(460, '1-June-2024', 1, 15, 0, 0),
(461, '1-June-2024', 1, 16, 0, 0),
(462, '1-June-2024', 1, 17, 0, 0),
(463, '1-June-2024', 1, 18, 0, 0),
(464, '1-June-2024', 1, 19, 0, 0),
(465, '2-June-2024', 1, 2, 1, 1),
(466, '2-June-2024', 1, 3, 0, 0),
(467, '2-June-2024', 1, 4, 0, 0),
(468, '2-June-2024', 1, 5, 5, 5),
(469, '2-June-2024', 1, 7, 0, 0),
(470, '2-June-2024', 1, 8, 0, 0),
(471, '2-June-2024', 1, 9, 0, 0),
(472, '2-June-2024', 1, 10, 0, 0),
(473, '2-June-2024', 1, 11, 0, 0),
(474, '2-June-2024', 1, 12, 0, 0),
(475, '2-June-2024', 1, 13, 0, 0),
(476, '2-June-2024', 1, 14, 0, 0),
(477, '2-June-2024', 1, 15, 0, 0),
(478, '2-June-2024', 1, 16, 0, 0),
(479, '2-June-2024', 1, 17, 0, 0),
(480, '2-June-2024', 1, 18, 0, 0),
(481, '2-June-2024', 1, 19, 0, 0),
(482, '2-June-2024', 3, 2, 0, 0),
(483, '2-June-2024', 3, 3, 0, 0),
(484, '2-June-2024', 3, 4, 0, 0),
(485, '2-June-2024', 3, 5, 0, 0),
(486, '2-June-2024', 3, 7, 0, 0),
(487, '2-June-2024', 3, 8, 0, 0),
(488, '2-June-2024', 3, 9, 0, 0),
(489, '2-June-2024', 3, 10, 0, 0),
(490, '2-June-2024', 3, 11, 0, 0),
(491, '2-June-2024', 3, 12, 0, 0),
(492, '2-June-2024', 3, 13, 0, 0),
(493, '2-June-2024', 3, 14, 0, 0),
(494, '2-June-2024', 3, 15, 0, 0),
(495, '2-June-2024', 3, 16, 0, 0),
(496, '2-June-2024', 3, 17, 0, 0),
(497, '2-June-2024', 3, 18, 0, 0),
(498, '2-June-2024', 3, 19, 0, 0),
(500, '2-June-2024', 4, 2, 45, 23),
(501, '2-June-2024', 4, 3, 45, 53),
(502, '2-June-2024', 4, 4, 67, 12),
(503, '2-June-2024', 4, 5, 86, 85),
(504, '2-June-2024', 4, 7, 32, 61),
(505, '2-June-2024', 4, 8, 100, 42),
(506, '2-June-2024', 4, 9, 73, 17),
(507, '2-June-2024', 4, 10, 20, 31),
(508, '2-June-2024', 4, 11, 13, 61),
(509, '2-June-2024', 4, 12, 6, 25),
(510, '2-June-2024', 4, 13, 34, 35),
(511, '2-June-2024', 4, 14, 26, 84),
(512, '2-June-2024', 4, 15, 92, 89),
(513, '2-June-2024', 4, 16, 79, 67),
(514, '2-June-2024', 4, 17, 10, 45),
(515, '2-June-2024', 4, 18, 90, 55),
(516, '2-June-2024', 4, 19, 86, 39),
(518, '3-June-2024', 4, 2, 79, 14),
(519, '3-June-2024', 4, 3, 97, 23),
(520, '3-June-2024', 4, 4, 65, 59),
(521, '3-June-2024', 4, 5, 7, 94),
(522, '3-June-2024', 4, 7, 38, 89),
(523, '3-June-2024', 4, 8, 58, 30),
(524, '3-June-2024', 4, 9, 89, 43),
(525, '3-June-2024', 4, 10, 61, 79),
(526, '3-June-2024', 4, 11, 20, 88),
(527, '3-June-2024', 4, 12, 11, 67),
(528, '3-June-2024', 4, 13, 69, 36),
(529, '3-June-2024', 4, 14, 35, 64),
(530, '3-June-2024', 4, 15, 23, 6),
(531, '3-June-2024', 4, 16, 64, 9),
(532, '3-June-2024', 4, 17, 67, 43),
(533, '3-June-2024', 4, 18, 96, 88),
(534, '3-June-2024', 4, 19, 37, 2),
(536, '31-January-2024', 1, 2, 10, 10),
(537, '31-January-2024', 1, 3, 0, 0),
(538, '31-January-2024', 1, 4, 0, 0),
(539, '31-January-2024', 1, 5, 0, 0),
(540, '31-January-2024', 1, 7, 0, 0),
(541, '31-January-2024', 1, 8, 0, 0),
(542, '31-January-2024', 1, 9, 0, 0),
(543, '31-January-2024', 1, 10, 0, 0),
(544, '31-January-2024', 1, 11, 0, 0),
(545, '31-January-2024', 1, 12, 0, 0),
(546, '31-January-2024', 1, 13, 0, 0),
(547, '31-January-2024', 1, 14, 0, 0),
(548, '31-January-2024', 1, 15, 0, 0),
(549, '31-January-2024', 1, 16, 0, 0),
(550, '31-January-2024', 1, 17, 0, 0),
(551, '31-January-2024', 1, 18, 0, 0),
(552, '31-January-2024', 1, 19, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `standard_quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `standard_quantity`) VALUES
(2, 'Perban (lbr 5 cm)', 2),
(3, 'Perban (lbr 10 cm)', 2),
(4, 'Perban (lbr 1,25 cm)', 2),
(5, 'Plester Cepat', 10),
(7, 'Kain Segitiga/mittela', 2),
(8, 'Gunting', 1),
(9, 'Peniti', 12),
(10, 'Sarung Tangan', 2),
(11, 'Masker', 1),
(12, 'Pinset', 1),
(13, 'Lampu Senter', 1),
(14, 'Gelas Cuci Mata', 1),
(15, 'Kantong Plastik Bersih', 1),
(16, 'Aquades (100ml)', 1),
(17, 'Povidon Iodin (60ml)', 1),
(18, 'Alkohol 70%', 1),
(19, 'Buku Panduan P3K', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `room_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`) VALUES
(1, 'Ruangan Keuangan'),
(2, 'Ruangan Aga'),
(3, 'Lobby SDM'),
(4, 'Ruangan SDM'),
(5, 'Lobby Rencana'),
(6, 'Ruang Rencana'),
(7, 'Lobby Distribusi'),
(8, 'Ruang Dan'),
(9, 'Ruang UPPK'),
(10, 'Pos A'),
(11, 'Pos D'),
(12, 'Gedung P Batur'),
(13, 'Lap. Tenis'),
(14, 'Gedung P Bina'),
(15, 'K Driver'),
(16, 'TPS LB3'),
(17, 'Masjid');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklist_records`
--
ALTER TABLE `checklist_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist_records`
--
ALTER TABLE `checklist_records`
  MODIFY `record_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=553;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_records`
--
ALTER TABLE `checklist_records`
  ADD CONSTRAINT `checklist_records_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
