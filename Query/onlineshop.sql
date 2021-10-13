-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-08-2021 a las 06:56:53
-- Versión del servidor: 8.0.26
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `onlineshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `balance`
--

CREATE TABLE `balance` (
  `movement` int NOT NULL,
  `iduser` int NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `transact` set('income','expenses') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `movement` int NOT NULL,
  `iduser` int NOT NULL,
  `codproduct` int NOT NULL,
  `quality` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `iduser` int NOT NULL,
  `codproduct` int NOT NULL,
  `rate` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

CREATE TABLE `inventory` (
  `movement` int NOT NULL,
  `codproduct` int NOT NULL,
  `quality` decimal(6,2) NOT NULL,
  `transact` set('income','expenses') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

CREATE TABLE `invoice` (
  `reference` int NOT NULL,
  `iduser` int NOT NULL,
  `date` date NOT NULL,
  `codproduct` int NOT NULL,
  `quality` decimal(6,2) NOT NULL,
  `unitprice` decimal(6,2) NOT NULL,
  `totalamount` decimal(6,2) NOT NULL,
  `currentbalance` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `cod` int NOT NULL,
  `image` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `um` set('Unit(s)','Kg(s)') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`cod`, `image`, `name`, `price`, `um`) VALUES
(1, 'item-1', 'Apple', '0.30', 'Unit(s)'),
(2, 'item-2', 'Beer', '2.00', 'Unit(s)'),
(3, 'item-3', 'Water', '1.00', 'Unit(s)'),
(4, 'item-4', 'Cheese', '3.74', 'Kg(s)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shippingcart`
--

CREATE TABLE `shippingcart` (
  `movement` int NOT NULL,
  `iduser` int NOT NULL,
  `shippingselected` set('UPS','Pick Up') COLLATE utf8_unicode_ci NOT NULL,
  `statuscart` set('Paid','Unpaid') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`movement`),
  ADD KEY `iduserbalance` (`iduser`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`movement`),
  ADD KEY `codproductcart` (`codproduct`) USING BTREE,
  ADD KEY `idusercart` (`iduser`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD KEY `codproductfavorite` (`codproduct`),
  ADD KEY `iduserfavorite` (`iduser`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`movement`),
  ADD KEY `codproductinventory_idx` (`codproduct`);

--
-- Indices de la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD KEY `referencemove_idx` (`reference`),
  ADD KEY `iduserinvoice_idx` (`iduser`),
  ADD KEY `codproductinvoice_idx` (`codproduct`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `shippingcart`
--
ALTER TABLE `shippingcart`
  ADD PRIMARY KEY (`movement`),
  ADD KEY `idusershippingcart_idx` (`iduser`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `balance`
--
ALTER TABLE `balance`
  MODIFY `movement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `movement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `movement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `shippingcart`
--
ALTER TABLE `shippingcart`
  MODIFY `movement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `iduserbalance` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `codproductcart` FOREIGN KEY (`codproduct`) REFERENCES `products` (`cod`),
  ADD CONSTRAINT `idusercart` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `codproductfavorite` FOREIGN KEY (`codproduct`) REFERENCES `products` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iduserfavorite` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `codproductinventory` FOREIGN KEY (`codproduct`) REFERENCES `products` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `codproductinvoice` FOREIGN KEY (`codproduct`) REFERENCES `products` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iduserinvoice` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referencemove` FOREIGN KEY (`reference`) REFERENCES `shippingcart` (`movement`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `shippingcart`
--
ALTER TABLE `shippingcart`
  ADD CONSTRAINT `idusershippingcart` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
