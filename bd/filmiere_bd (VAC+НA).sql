-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2016 a las 13:39:49
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `filmiere_bd`
--
CREATE DATABASE IF NOT EXISTS `filmiere_bd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `filmiere_bd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `butacas_ocupadas`
--

CREATE TABLE `butacas_ocupadas` (
  `id_horario` int(11) NOT NULL,
  `fila` int(11) NOT NULL,
  `columna` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_descuentos`
--

CREATE TABLE `codigos_descuentos` (
  `codigo` varchar(50) NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `activado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `asunto` varchar(15) DEFAULT NULL,
  `mensaje` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id_descuento` int(11) NOT NULL,
  `tipo` enum('PACK_4o5','PACK_MAYOR_5','SIN_DESCUENTO') NOT NULL,
  `porcentaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestor`
--

CREATE TABLE `gestor` (
  `sala` int(11) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id_compra` int(11) NOT NULL,
  `socio` varchar(20) DEFAULT NULL,
  `id_pelicula` int(11) NOT NULL,
  `num_entradas` int(11) NOT NULL,
  `precio` double NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `sala` int(11) NOT NULL,
  `hora` datetime NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `3D` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id_pelicula` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `fecha_estreno` date NOT NULL,
  `genero` enum('DRAMA','COMEDIA','CIENCIA_FICCION','BELICA','HISTORICA','TERROR','TRAGICOMEDIA') NOT NULL,
  `duracion_min` int(11) NOT NULL,
  `director` varchar(20) NOT NULL,
  `reparto` text NOT NULL,
  `sinopsis` text NOT NULL,
  `valoracion` int(11) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_butacas_sala`
--

CREATE TABLE `plantilla_butacas_sala` (
  `num_sala` int(11) NOT NULL,
  `fila` int(11) NOT NULL,
  `columna` int(11) NOT NULL,
  `tipo_butaca` enum('NORMAL','VIP','MINUSVALIDOS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_butacas`
--

CREATE TABLE `precios_butacas` (
  `id` int(11) NOT NULL,
  `tipo` enum('NORMAL','VIP','MINUSVALIDOS','3D') NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id_promo` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_logs`
--

CREATE TABLE `registro_logs` (
  `gestor` varchar(20) NOT NULL,
  `ultimo_log` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `num_sala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `nombre_usuario` varchar(20) NOT NULL,
  `nombre_completo` varchar(30) DEFAULT NULL,
  `correo` varchar(20) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `NombreU` varchar(20) NOT NULL,
  `Contrasena` varchar(150) NOT NULL,
  `Tipo` enum('ADMIN','SOCIO','GESTOR') NOT NULL,
  `num_aleatorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `butacas_ocupadas`
--
ALTER TABLE `butacas_ocupadas`
  ADD PRIMARY KEY (`id_horario`,`fila`,`columna`),
  ADD KEY `id_compra` (`id_compra`);

--
-- Indices de la tabla `codigos_descuentos`
--
ALTER TABLE `codigos_descuentos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id_descuento`);

--
-- Indices de la tabla `gestor`
--
ALTER TABLE `gestor`
  ADD PRIMARY KEY (`sala`),
  ADD KEY `sala` (`sala`),
  ADD KEY `gestor_ibfk_1` (`nombre_usuario`),
  ADD KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `socio` (`socio`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `sala` (`sala`),
  ADD KEY `pelicula` (`id_pelicula`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id_pelicula`);

--
-- Indices de la tabla `plantilla_butacas_sala`
--
ALTER TABLE `plantilla_butacas_sala`
  ADD PRIMARY KEY (`num_sala`,`fila`,`columna`);

--
-- Indices de la tabla `precios_butacas`
--
ALTER TABLE `precios_butacas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id_promo`);

--
-- Indices de la tabla `registro_logs`
--
ALTER TABLE `registro_logs`
  ADD PRIMARY KEY (`gestor`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`num_sala`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`nombre_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`NombreU`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1500;
--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id_pelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `precios_butacas`
--
ALTER TABLE `precios_butacas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `butacas_ocupadas`
--
ALTER TABLE `butacas_ocupadas`
  ADD CONSTRAINT `butacas_ocupadas_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `butacas_ocupadas_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `historial_compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gestor`
--
ALTER TABLE `gestor`
  ADD CONSTRAINT `gestor_ibfk_1` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuarios` (`NombreU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gestor_ibfk_2` FOREIGN KEY (`sala`) REFERENCES `sala` (`num_sala`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`socio`) REFERENCES `socio` (`nombre_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_compras_ibfk_2` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id_pelicula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`sala`) REFERENCES `sala` (`num_sala`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantilla_butacas_sala`
--
ALTER TABLE `plantilla_butacas_sala`
  ADD CONSTRAINT `plantilla_butacas_sala_ibfk_1` FOREIGN KEY (`num_sala`) REFERENCES `sala` (`num_sala`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
