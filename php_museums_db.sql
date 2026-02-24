-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-12-2025 a las 16:24:36
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbphppec3_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `museums_museos`
--

DROP TABLE IF EXISTS `museums_museos`;
CREATE TABLE IF NOT EXISTS `museums_museos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `ciudad` varchar(20) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `tematica` enum('Arte','Familia','Historia','Tecnología','Temporal','Tradición') CHARACTER SET utf8mb4 COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `fechas_horarios` text COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `visitas_guiadas` enum('Sí','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_es_0900_ai_ci;

--
-- Volcado de datos para la tabla `museums_museos`
--

INSERT INTO `museums_museos` (`id`, `nombre`, `ciudad`, `tematica`, `fechas_horarios`, `visitas_guiadas`, `precio`, `imagen`) VALUES
(1, 'Museo del Prado', 'Madrid', 'Arte', 'Lun-Sab 10:00-20:00; Dom 10:00-19:00', 'Sí', 15.00, '/dbphppec3_museums/assets/img/prado.jpg'),
(2, 'Museu Picasso', 'Barcelona', 'Arte', 'Mar-Dom 10:00-19:00', 'Sí', 12.00, '/dbphppec3_museums/assets/img/picasso.jpg'),
(3, 'Guggenheim Bilbao', 'Bilbao', 'Arte', 'Mar-Dom 11:00-19:00', 'Sí', 16.00, '/dbphppec3_museums/assets/img/guggenheim.jpg'),
(4, 'Museo Marítimo Vlc', 'Valencia', 'Historia', 'Lun-Dom 09:00-18:00', 'No', 8.50, '/dbphppec3_museums/assets/img/maritimo.jpg'),
(5, 'Museo Ciencias Medieval', 'Alicante', 'Tecnología', 'Mar-Dom 10:00-20:00', 'Sí', 10.00, '/dbphppec3_museums/assets/img/medieval.jpg'),
(6, 'Centro Arte Nova', 'Barcelona', 'Arte', 'Lun-Vie 10:00-18:00', 'Sí', 14.00, '/dbphppec3_museums/assets/img/nova.jpg'),
(7, 'Museo Pirineo', 'Huesca', 'Historia', 'Mar-Sab 10:00-17:00', 'No', 7.00, '/dbphppec3_museums/assets/img/pirineo.jpg'),
(8, 'Museo Mediterraneo', 'Tarragona', 'Tradición', 'Lun-Dom 09:30-19:00', 'Sí', 9.00, '/dbphppec3_museums/assets/img/mediterraneo.jpg'),
(9, 'Museo Espacio MX', 'Madrid', 'Tecnología', 'Lun-Sab 10:00-21:00', 'Sí', 11.50, '/dbphppec3_museums/assets/img/espacio.jpg'),
(10, 'Museo Solaris', 'Valencia', 'Arte', 'Lun-Dom 10:00-20:00', 'No', 13.00, '/dbphppec3_museums/assets/img/solaris.jpg'),
(11, 'Museo Extra', 'Valencia', 'Familia', 'Lun-Dom 09:00-19:00', 'No', 9.50, '/dbphppec3_museums/assets/img/extra.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `museums_users`
--

DROP TABLE IF EXISTS `museums_users`;
CREATE TABLE IF NOT EXISTS `museums_users` (
  `username` varchar(50) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_es_0900_ai_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_es_0900_ai_ci;

--
-- Volcado de datos para la tabla `museums_users`
--

INSERT INTO `museums_users` (`username`, `name`, `surname`, `password`) VALUES
('mturur', 'Marc', 'Turu', '$2y$12$sFeW3BVmxNCjXGh/n8iuTuIvj8MjXkCqIaUEONqWu6mr.ZieEenma');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
