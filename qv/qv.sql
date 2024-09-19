-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-09-2024 a las 15:56:33
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `qv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `Nombre_producto` varchar(100) NOT NULL,
  `Stock` int NOT NULL,
  `Precio_unidad` int NOT NULL,
  `Categoria` varchar(255) NOT NULL COMMENT 'Indique a que categoria pertenece el producto',
  `Imagen` blob NOT NULL,
  PRIMARY KEY (`id_producto`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `Nombre_producto`, `Stock`, `Precio_unidad`, `Categoria`, `Imagen`) VALUES
(1, 'Oreos', 45, 1500, 'Galletitas', 0x6f72656f732e6a7067),
(4, 'alfajor', 90, 800, 'snacks', 0x616c66616a6f722e6a7067),
(6, 'pepsi', 15, 1500, 'bebidas', 0x70657073696c6174612e6a7067),
(7, 'cepita', 4, 4455, 'bebidas', 0x636f63612e6a7067),
(8, 'cepita', 848, 646, 'snacks', 0x6f72656f616c66616a6f722e706e67),
(9, 'cepita', 7, 8, 'bebidas', 0x636f63612e6a7067),
(10, 'cepita', 6, 8, 'snacks', 0x636f63612e6a7067),
(11, 'seba', 5, 32312, 'bebidas', 0x626f63612e706e67),
(12, 'Luz perez', 4, 222, 'bebidas', 0x626f63612e706e67),
(13, 'FIORELL', 111, 12312321, 'snacks', 0x626f63612e706e67),
(14, 'aaaaaaa', 13213, 2, 'bebidas', 0x626f63612e706e67),
(15, 'aaaaa', 13213, 2, 'bebidas', 0x626f63612e706e67),
(16, 'cepita', 2, 34123213, 'bebidas', 0x73757274696461732e706e67);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

DROP TABLE IF EXISTS `registro`;
CREATE TABLE IF NOT EXISTS `registro` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `DNI` int NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Curso` varchar(50) NOT NULL,
  `Contraseña` varchar(16) NOT NULL,
  `Con_rep` varchar(16) NOT NULL,
  `rol` enum('cliente','vendedor') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cliente' COMMENT 'Rol asignado al usuario (cliente o vendedor)',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`Id`, `DNI`, `Nombre`, `Curso`, `Contraseña`, `Con_rep`, `rol`) VALUES
(9, 25200498, 'ingrid muller', 'curso2', '3456', '3456', 'cliente'),
(1, 46310913, 'Luz Perez', ' ', '1234', '1234', 'vendedor'),
(10, 46964696, 'Limon Cantero', 'curso2', 'octavio', 'octavio', 'cliente'),
(11, 47224369, 'valentin persoglia', '', 'persoglia', 'persoglia', 'cliente');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
