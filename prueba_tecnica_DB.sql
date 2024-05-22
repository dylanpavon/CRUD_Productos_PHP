-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-05-2024 a las 10:34:14
-- Versión del servidor: 8.0.36
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_tecnica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `icon`) VALUES
(1, 'Hogar', '/images/hogar.png'),
(2, 'Autos', '/images/autos.png'),
(3, 'Instrumentos', '/images/instrumentos.png'),
(4, 'Ropa', '/images/ropa.png'),
(6, 'Deportes', '/images/deportes.png'),
(8, 'TV', '/images/tvs.png'),
(45, 'Juguetes', '/images/juguetes.png'),
(47, 'Electrónica', '/images/electronica.png'),
(51, 'Herramientas', '/images/herramientas.png'),
(52, 'Moda', '/images/moda.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `image`) VALUES
(2, 'Ford Fiesta', 2, '/images/ford fiesta.jpg'),
(3, 'Guitarra', 3, '/images/guitarra.jpg'),
(4, 'Jean', 4, '/images/jean.jpg'),
(5, 'Futbol', 6, '/images/futbol.jpg'),
(6, 'Samsung 50', 8, '/images/samsung 50.jpg'),
(7, 'Renault Clio', 2, '/images/renault clio.jpg'),
(8, 'Blusa', 4, '/images/blusa.jpg'),
(9, 'Raqueta', 6, '/images/raqueta.jpg'),
(18, 'Piano', 3, '/images/piano.jpg'),
(19, 'Cartera', 52, '/images/cartera.jpg'),
(22, 'Sillas', 1, '/images/sillas.jpg'),
(23, 'Martillo', 51, '/images/martillo.jpg'),
(25, 'Mesa', 1, '/images/mesa.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` longblob NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(1, 'dylanpavon_', 0x647061766f6e, 'dpavon217@gmail.com'),
(2, 'lolamento_', 0x736f72727962726f, 'lola@mento.com.ar'),
(3, 'bruni_123', 0x333030363230, 'bruno@gmail.com'),
(4, 'panchi_', 0x70616e636861, 'pancha@gmail.com'),
(5, 'tati_', 0x74617469, 'tati@gmail.com'),
(6, 'deniseledesma_', 0x333030363230, 'deniseledesma@gmail.com'),
(7, 'dylan_', 0x333030363230, 'dylan@gmail.com');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
