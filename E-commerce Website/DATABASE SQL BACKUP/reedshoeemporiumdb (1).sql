-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 13, 2024 at 02:29 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reedshoeemporiumdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

CREATE TABLE `orderline` (
  `orderlineID` int NOT NULL,
  `OrderID` int NOT NULL,
  `ProductID` int NOT NULL,
  `Quantity` int NOT NULL,
  `Total` float NOT NULL,
  `OrderDate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderline`
--

INSERT INTO `orderline` (`orderlineID`, `OrderID`, `ProductID`, `Quantity`, `Total`, `OrderDate`) VALUES
(1, 10, 12, 1, 2305, '2024-06-06 16:07:10'),
(2, 10, 21, 1, 2766, '2024-06-06 16:07:10'),
(3, 11, 20, 1, 2560, '2024-06-06 16:09:47'),
(4, 11, 28, 1, 553.2, '2024-06-06 16:09:47'),
(5, 11, 27, 2, 2028.4, '2024-06-06 16:09:47'),
(6, 12, 26, 3, 2212.8, '2024-06-06 16:10:38'),
(7, 12, 18, 2, 4610, '2024-06-06 16:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int NOT NULL,
  `UserID` int NOT NULL,
  `Total` float NOT NULL,
  `OrderDate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DeliveryDate` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `Total`, `OrderDate`, `DeliveryDate`) VALUES
(7, 3, 6085.2, '2024-06-06 15:39:13', NULL),
(8, 3, 7863.15, '2024-06-06 15:59:16', NULL),
(9, 3, 5347.6, '2024-06-06 16:02:23', NULL),
(10, 3, 5071, '2024-06-06 16:07:10', NULL),
(11, 3, 5141.6, '2024-06-06 16:09:47', NULL),
(12, 3, 6822.8, '2024-06-06 16:10:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `UserID` int NOT NULL,
  `Username` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Address` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ID` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `PhoneNumber` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AccountType` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`UserID`, `Username`, `Password`, `Address`, `ID`, `Email`, `PhoneNumber`, `AccountType`) VALUES
(1, 'admin', '$2y$10$Moz6VB421pt.WzZJ1HhzOOl11DlFYoO5TN1lyqxM771jVCYrpxBKO', '17', '7788994444555', 'KyleRhodes@gmail.com', '1112233456', 'admin'),
(2, 'asdfsdf', '$2y$10$jND9BI/6KriQviW.fSQkfupSXnLaIUvWEmdJ3g.AKJQ3ihnIOAGri', 'ugl', '12345678912', 'likh@gmail.com', '1234567897', 'user'),
(3, 'bossman', '$2y$10$Drn03D.KpJcpaKXfjRO04eY19bGibc3H4.ZfPlfN9QP/KVflD7.oK', 'asdf', '153264893512', 'bossman@gmail.com', '1325647895', 'user'),
(4, 'secondadmin', '$2y$10$Y4p..MK/T0Q7Ihe9G9pM6.bG7V9Wj6kiytT70gQYDhZyxSb1X/iDW', '17 Long grove mews, Mowbray', NULL, 'secondadmin@gmail.com', '1326459122', 'admin'),
(5, 'JacobBaker123', '$2y$10$u6cxPyrJvUcTrZ1bNhS/Peont8guhTP4DrjtKt0z3dXSW/9qG9cFu', '15 Lonsdale Way, Pinelands, Cape Town', NULL, 'jacobbaker@gmail.com', '0835154452', 'user'),
(6, 'asdfasd asdf', '$2y$10$eFXLhjwjoIVPVelK1HhXa.wWnnhGFsJNdfwfPFkSYwPIhkf/Gu7he', '123432 asdfasdf aasdfsa ', NULL, 'asdf@gmail.com', '1324567894', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int NOT NULL,
  `Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Category` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Price` float NOT NULL,
  `Description` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `Filename` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Name`, `Category`, `Price`, `Description`, `Filename`) VALUES
(6, 'Nike Air Force 1 07', 'Men', 1659.6, 'Classic design with thick, durable sole and hidden Air pocket for superior comfort.', 'Nike_Air_Force_1_07.jpg'),
(7, 'Hoka One One Arahi 5', 'Men', 2397.2, 'Features full-length EVA midsole and breathable materials for excellent fit and support.', 'Hoka_One_One_Arahi_5.jpg'),
(8, 'Brooks Launch 7', 'Men', 1844, 'Lightweight, responsive cushioning, ideal for running and casual wear.', 'Brooks_Launch_7.jpg'),
(9, 'Skechers Flex Advantage 2.0', 'Men', 1290.8, 'Memory foam insole with knit mesh fabric upper for all-day comfort.', 'Skechers_Flex_Advantage_2_0.jpg'),
(10, 'Naot General Boot', 'Men', 3688, 'Lightweight, stylish walking boots with water-resistant leather and supportive footbed.', 'Naot_General_Boot.jpg'),
(11, 'On Cloud 5', 'Men', 2581.6, 'Lightweight, breathable slip-on sneakers with great arch support.', 'On_Cloud_5.jpg'),
(12, 'Birkenstock Arizona Sandals', 'Men', 2305, 'Leather sandals with ultra-supportive cork-latex footbed and foam layer.', 'Birkenstock_Arizona_Sandals.jpg'),
(13, 'Oliver Cabell Driver Loafers', 'Men', 3595.8, 'Soft Italian suede with microfoam footbed, perfect for summer.', 'Oliver_Cabell_Driver_Loafers.jpg'),
(14, 'Larroudé Blair Block Pump', 'Women', 6085.2, 'Block heel with a mix of Mary Jane and modern design, perfect for work.', 'Larroude_Blair_Block_Pump.jpg'),
(15, 'Hoka Bondi 8', 'Women', 3699.95, 'Cushioned running shoes with breathable upper mesh and lightweight design.', 'Womens_Hoka_Bondi_8.jpg'),
(16, 'Womens Hoka Solimar Vanilla', 'Women', 2699.95, 'Cushioned running shoes with breathable upper mesh and lightweight design.', 'Womens_Hoka_Solimar_Vanilla.jpg'),
(17, 'Allbirds Wool Runners', 'Women', 2028.4, 'Made from sustainable materials, these runners are breathable and machine-washable.', 'Allbirds_Wool_Runners.jpg'),
(18, 'Rothys - The Flat', 'Women', 2305, 'Comfortable flats made from recycled materials, perfect for everyday wear.', 'Rothys_The_Flat.jpg'),
(19, 'Clarks Womens Sharon Dolly Loafer', 'Women', 1567.4, 'Cushioned loafers with ortholite footbed and modern design.', 'Clarks _Womens_Sharon_Dolly_Loafer.jpg'),
(20, 'Womens Vionic Skyway Blue Comfort Sneaker', 'Women', 2560, 'Walking sneakers with a focus on arch support and comfort.', 'Womens_Vionic_Skyway_Blue_Comfort_Sneaker.jpg'),
(21, 'Cole Haan GrandPro Tennis Sneaker', 'Women', 2766, 'Lightweight, stylish sneakers with cushioned footbed and durable sole.', 'Cole_Haan_GrandPro_Tennis_Sneaker.jpg'),
(22, 'Nike Revolution 6', 'Kids', 1106.4, 'Breathable, lightweight design made from recycled materials.', 'Nike_Revolution_6.jpg'),
(23, 'Stride Rite Made2Play Sneaker', 'Kids', 922, 'Machine-washable with anti-stink linings and durable design.', 'Stride_Rite_Made2Play_Sneaker_Little_Girls.jpg'),
(24, 'Womens New Balance Fresh Foam Arishi V4 Solar Flare', 'Kids', 1189.95, 'Supportive running shoes with durable rubber outsole and mesh upper.', 'Womens_New_Balance_Fresh_Foam_Arishi_V4_Solar_Flare.jpg'),
(25, 'Adidas Unisex Ultraboost 1.0 Kids', 'Kids', 2950.4, 'High-performance running shoes with responsive cushioning and Primeknit upper.', 'Adidas_Unisex_Ultraboost_1_0_Kids.jpg'),
(26, 'Puma Cabana Racer SL', 'Kids', 737.6, 'Retro-style sneakers with lightweight EVA midsole for comfort.', 'Cabana_Racer_SL_Toddler_Shoes.jpg'),
(27, 'Keen Newport H2 Sandals', 'Kids', 1014.2, 'Water-friendly sandals with supportive footbed and secure fit.', 'Keen_Newport_H2_Sandals.jpg'),
(28, 'Crocs Kids Classic Clog ', 'Kids', 553.2, 'Easy-to-clean, lightweight clogs with customizable charm holes.', 'Crocs_Kids_Classic_Clog.jpg'),
(29, 'Saucony Kids Baby Jazz Hook And Loop Sneaker', 'Kids', 829.8, 'Classic design with hook-and-loop closure and lightweight cushioning.', 'Saucony_Kids_Baby_Jazz_Hook_And_Loop_Sneaker.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`orderlineID`),
  ADD KEY `orderline_fk_1` (`ProductID`),
  ADD KEY `orderline_fk_2` (`OrderID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `orders_fk_1` (`UserID`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `orderlineID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderline`
--
ALTER TABLE `orderline`
  ADD CONSTRAINT `orderline_fk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderline_fk_2` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fk_1` FOREIGN KEY (`UserID`) REFERENCES `persons` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
