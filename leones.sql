-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2017 a las 19:26:42
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `leones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`, `abreviatura`) VALUES
(1, 'GERENTE GENERAL', 'GG'),
(2, 'JEFE DE OPERACIONES', 'JO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_empresa_usuario`
--

CREATE TABLE `area_empresa_usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `area_empresa_usuario`
--

INSERT INTO `area_empresa_usuario` (`id`, `area_id`, `empresa_ruc`, `usuario_id`) VALUES
(1, 1, '20489468795', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

CREATE TABLE `armas` (
  `id` int(10) UNSIGNED NOT NULL,
  `calibre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `armas`
--

INSERT INTO `armas` (`id`, `calibre`, `tipo`) VALUES
(1, '9', 'PISTOLA'),
(2, '12', 'RETROCARGA'),
(3, '38', 'REVOLVER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arma_empresa`
--

CREATE TABLE `arma_empresa` (
  `serie` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `arma_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aseguradoras`
--

CREATE TABLE `aseguradoras` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fijo` float(8,2) DEFAULT NULL,
  `fondo` float(8,2) DEFAULT NULL,
  `prima` float(8,2) DEFAULT NULL,
  `flujo` float(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(10) UNSIGNED NOT NULL,
  `punto_id` int(10) UNSIGNED NOT NULL,
  `turno_id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_trabajador`
--

CREATE TABLE `asistencia_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `asistencia_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL,
  `entrada` time NOT NULL,
  `salida` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificaciones`
--

CREATE TABLE `bonificaciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `porcentaje` double DEFAULT NULL,
  `fijo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificacion_trabajador`
--

CREATE TABLE `bonificacion_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `bonificacion_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `nombre`) VALUES
(1, 'DESCANCERO'),
(2, 'LIMPIEZA'),
(3, 'SEGURIDAD'),
(4, 'CHOFER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartas`
--

CREATE TABLE `cartas` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `anio` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `destinatario` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `lugar` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `asunto` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `referencia` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `contenido` varchar(1024) COLLATE utf8_spanish2_ci NOT NULL,
  `redaccion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cartas`
--

INSERT INTO `cartas` (`id`, `usuario_id`, `empresa_ruc`, `anio`, `fecha`, `numero`, `codigo`, `destinatario`, `lugar`, `asunto`, `referencia`, `contenido`, `redaccion`) VALUES
(1, 1, '20489468795', 'AÑO DE LA RESTAURACIÓN INDUSTRIAL 2017', 'HUANUCO 09 DE ENERO DEL 2017', 85, 'CARTA Nº 85-2017/E.S.S.P. LEONES DE ORO S.R.L.', 'MIGUEL ANGEL SEGOVIA SANCHEZ', 'Huánuco.-', 'CONVOCATORIA A ELECCIONES 2017', '', '<p>Por la presente le expreso mis m&aacute;s gratos saludos recordandoles la citaci&oacute;n para presentarse como candidato a las elecciones de administrativos le la cofrad&iacute;a de negritos ni&ntilde;o Jes&uacute;s Puente Tingo.</p>\r\n\r\n<p>La plancha elenctoral requiere de representantes el los siguientes puesto:</p>\r\n\r\n<ul>\r\n	<li>Presidente</li>\r\n	<li>Vicepresidente</li>\r\n	<li>tesorero</li>\r\n	<li>secretario</li>\r\n</ul>\r\n\r\n<p>Sin m&aacute;s le recuerdo que junto a su plancha electoral se debe presentar su plan de trabajo para ser publicado en las redes sociales.</p>\r\n', '2017-01-09'),
(2, 1, '20489468795', 'AÑO DE LA RESTAURACIÓN INDUSTRIAL 2017', '09 DE ENERO DEL 2017', 86, 'CARTA Nº 86-2017/E.S.S.P. LEONES DE ORO S.R.L.', 'JUAN CARLOS CORONEL', 'Huánuco.-', 'CELEBRACIÓN DE ANIVERSARIO', '', '<p>&ntilde;lskdjf&ntilde;lskulsksj</p>\r\n\r\n<p>slkdjflkjdf</p>\r\n\r\n<p>lkkdjglkkzjfglk</p>\r\n\r\n<p>lkfkljg l.kdfg llkjefglkjdf &ntilde;lkdjfglkjfg lkjdfjglkjdf l&ntilde;kdjfgg djfg</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2017-01-09'),
(9, 1, '20489468795', 'AÑO DE LA REFORESTACION DE LA AMAZONIA PERUANA 2018', 'KJHSKJFH', 1, 'CARTA Nº 1-2018/E.S.S.P. LEONES DE ORO S.R.L.', 'KSJDHGKJH', 'kjsdhfh', 'KJSHGKJH', 'KJSDFKJH', '<p>kjxfhgkjh kjhsdfgh kjhdgjk okhdfgkjhContenido...</p>\r\n', '2018-01-01'),
(10, 1, '20489468795', 'AÑO DE LA REFORESTACION DE LA AMAZONIA PERUANA 2018', 'KJSHKFJH', 2, 'CARTA Nº 2-2018/E.S.S.P. LEONES DE ORO S.R.L.', 'KJFHGH', 'kxjhfh', 'KJSDFKJH', 'KJSHDFJH', '<p>kjdhfkgjh kjsdf kjhdg kjzj skdjb kjhsdf Contenido...</p>\r\n', '2018-01-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `contacto` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_empresa`
--

CREATE TABLE `cliente_empresa` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_ruc` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_ruc` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos`
--

CREATE TABLE `conceptos` (
  `id` int(10) UNSIGNED NOT NULL,
  `costo_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `subtotal` double NOT NULL,
  `igv` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_turno`
--

CREATE TABLE `concepto_turno` (
  `id` int(10) UNSIGNED NOT NULL,
  `concepto_id` int(10) UNSIGNED NOT NULL,
  `turno_id` int(10) UNSIGNED NOT NULL,
  `puestos` int(10) UNSIGNED NOT NULL,
  `sueldobasico` double NOT NULL,
  `asignacionfamiliar` double NOT NULL,
  `jornadanocturna` double NOT NULL,
  `sobretiempo1` double NOT NULL,
  `sobretiempo2` double NOT NULL,
  `descansero` double NOT NULL,
  `feriados` double NOT NULL,
  `igv` double NOT NULL,
  `gratificaciones` double NOT NULL,
  `cts` double NOT NULL,
  `vacaciones` double NOT NULL,
  `essalud` double NOT NULL,
  `sctr` double NOT NULL,
  `ueas` double NOT NULL,
  `capacitacion` double NOT NULL,
  `movilidad` double NOT NULL,
  `refrigerio` double NOT NULL,
  `gastosgenerale` double NOT NULL,
  `utilidad` double NOT NULL,
  `subtotal` double UNSIGNED NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `subtotal` double(15,2) NOT NULL,
  `igv` double(15,2) NOT NULL,
  `total` double(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato_documento`
--

CREATE TABLE `contrato_documento` (
  `id` int(10) UNSIGNED NOT NULL,
  `contrato_id` int(10) UNSIGNED NOT NULL,
  `documento_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos`
--

CREATE TABLE `costos` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `lugar` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `saludo` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `igv` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `despedida` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento_trabajador`
--

CREATE TABLE `descuento_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `descuento_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `monto` double NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `nombre`) VALUES
(1, 'DNI PROPIO'),
(2, 'ANTECEDENTES PENALES'),
(3, 'ANTECEDENTES JUDICIALES'),
(4, 'ANTECEDENTES POLICIALES'),
(5, 'DECLARACION DOMICILIARIA'),
(6, 'CONSTANCIA DE TRABAJO'),
(7, 'CERTIFICADO DE ESTUDIOS'),
(8, 'CONTRATO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_trabajador`
--

CREATE TABLE `documento_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `documento_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `documento_trabajador`
--

INSERT INTO `documento_trabajador` (`id`, `documento_id`, `trabajador_id`, `nombre`) VALUES
(1, 8, 2, '2CONTRATO.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`ruc`, `nombre`) VALUES
('20489468795', 'E.S.S.P. LEONES DE ORO S.R.L.'),
('20529007869', 'EMPRESA DE SERVICIOS MULTIPLES LEOMIL S.R.L.'),
('20529113898', 'P&R SEGURIDAD INTEGRAL S.R.L.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_herramienta`
--

CREATE TABLE `empresa_herramienta` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `herramienta_id` int(10) UNSIGNED NOT NULL,
  `serie` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `marca` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_herramienta_trabajador`
--

CREATE TABLE `empresa_herramienta_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_herramienta_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_prenda`
--

CREATE TABLE `empresa_prenda` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `prenda_id` int(10) UNSIGNED NOT NULL,
  `cantidad_p` int(10) UNSIGNED NOT NULL,
  `cantidad_s` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_prenda_trabajador_usuario`
--

CREATE TABLE `empresa_prenda_trabajador_usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `prenda_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `cantidad_p` int(10) UNSIGNED NOT NULL,
  `cantidad_s` int(10) UNSIGNED NOT NULL,
  `entrega` date NOT NULL,
  `devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE `informes` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `remite` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `cargo_remite` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `anio` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `destinatario` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `cargo_destinatario` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `asunto` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `contenido` mediumtext COLLATE utf8_spanish2_ci NOT NULL,
  `redaccion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `informes`
--

INSERT INTO `informes` (`id`, `usuario_id`, `empresa_ruc`, `remite`, `cargo_remite`, `anio`, `fecha`, `numero`, `codigo`, `destinatario`, `cargo_destinatario`, `asunto`, `contenido`, `redaccion`) VALUES
(1, 1, '20489468795', 'KJZDCFJHG', 'JHCVJXHC', 'AÑO DE LA RESTAURACIÓN INDUSTRIAL 2017', 'JSHDGFJHSDG', 59, 'INFORME Nº 59-2017/E.S.S.P. LEONES DE ORO S.R.L.', 'JUAN CARLOS CORONEL', 'HUJZHDG', 'JHSGCVFJSD', '<p>jshdgfjshdgContenido...</p>\r\n', '2017-01-09'),
(2, 1, '20489468795', 'LKJDSHFLKJ', 'LKJSDHFH', 'AÑO DE LA RESTAURACIÓN INDUSTRIAL 2017', 'KJXHFJH', 60, 'INFORME Nº 60-2017/E.S.S.P. LEONES DE ORO S.R.L.', 'KDJHFSDJ', 'KJSDFKJ', 'KLJSDHFLKJH', '<p>kjdfhj kjshdfj kjhsdfkjhdz lkjzdfh kzjdhflkjhContenido...</p>\r\n', '2017-01-09'),
(3, 1, '20489468795', 'LKJSDHFKJ', 'LKJSHDFH', 'AÑO DE LA REFORESTACION DE LA AMAZONIA PERUANA 2018', 'KJXDKJH', 1, 'INFORME Nº 1-2018/E.S.S.P. LEONES DE ORO S.R.L.', 'SKJFSJGF', 'LSKJHDFJH', 'LKJSHFKJ', '<p>kljzdhfjh kjhsdfjh lkjhsdfjh &nbsp;kjhwdjkfh kjdfjkh lkjhdlfkjh kjsdhf jhkdjfh klhedfkjh kjhdfkjh Contenido...</p>\r\n', '2018-01-09'),
(4, 1, '20489468795', 'LKSJADFJKH', 'LKSJDFHH JH', 'AÑO DE LA REFORESTACION DE LA AMAZONIA PERUANA 2018', 'LKJSDJKH', 2, 'INFORME Nº 2-2018/E.S.S.P. LEONES DE ORO S.R.L.', 'LKSJDFKJH', 'LKSJADHFJH', 'KJSDFJH', '<p>lkjshfd kjhsdkfjh lkjhdlkfjh lkjhsdfjh kkjsdfkjh kjhsdfkjh kjdhf lkjehgjh kjhdlfgkj jhdflgkjhg kjhdfgkjh lkjdsflkgjh kjhsdgff kjhesjkgh kjeglkj kjhsejkgh Contenido...</p>\r\n', '2018-01-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorandums`
--

CREATE TABLE `memorandums` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `remite` int(10) UNSIGNED DEFAULT NULL,
  `area_id` int(10) UNSIGNED DEFAULT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `asunto` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_memorandum_id` int(10) UNSIGNED DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `fecha` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `redaccion` date NOT NULL,
  `contenido` varchar(1024) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `memorandums`
--

INSERT INTO `memorandums` (`id`, `usuario_id`, `remite`, `area_id`, `empresa_ruc`, `asunto`, `tipo_memorandum_id`, `codigo`, `numero`, `fecha`, `redaccion`, `contenido`) VALUES
(1, 1, 1, 1, '20489468795', 'EL QUE SE INDICA', 1, 'MEMORANDUM Nº 74-2017/GG/E.S.S.P. LEONES DE ORO S.R.L.', 74, 'HUÁNUCO, 01 DE ENERO DEL 2017', '2017-01-09', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas orci quam, eleifend non nunc a, posuere facilisis turpis. Vestibulum lorem eros, rutrum quis porta in, iaculis eu massa. Nam aliquam, tellus at eleifend tempor, dolor tellus feugiat augue, non laoreet velit ligula sit amet dolor. Proin pretium odio in lacinia semper. Pellentesque sit amet laoreet arcu. Morbi vitae orci ut nibh facilisis interdum eu at metus. Sed pretium condimentum tempus. Phasellus id tincidunt sapien. Morbi ex diam, viverra vitae dolor nec, pellentesque placerat augue. Maecenas id mollis risus, at venenatis est. Vivamus et venenatis eros, posuere malesuada justo. Vivamus tristique nisi eu metus dictum, sed rhoncus eros malesuada. Sed faucibus commodo justo, eu facilisis nisl dignissim ac. Donec ac sodales mi, et ultrices erat.</p>\r\n\r\n<p style="text-align: justify;">In sollicitudin pellentesque aliquam. Quisque dictum mauris vehicula nibh pharetra rutrum. Donec aliquet, sapien non scelerisque po'),
(2, 1, 1, 1, '20489468795', 'EL QUE SE INDICA', 1, 'MEMORANDUM Nº 75-2017/GG/E.S.S.P. LEONES DE ORO S.R.L.', 75, 'HUÁNUCO, 09 DE ENERO DEL 2017', '2017-01-09', '<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas orci quam, eleifend non nunc a, posuere facilisis turpis. Vestibulum lorem eros, rutrum quis porta in, iaculis eu massa. Nam aliquam, tellus at eleifend tempor, dolor tellus feugiat augue, non laoreet velit ligula sit amet dolor. Proin pretium odio in lacinia semper. Pellentesque sit amet laoreet arcu. Morbi vitae orci ut nibh facilisis interdum eu at metus. Sed pretium condimentum tempus. Phasellus id tincidunt sapien. Morbi ex diam, viverra vitae dolor nec, pellentesque placerat augue. Maecenas id mollis risus, at venenatis est. Vivamus et venenatis eros, posuere malesuada justo. Vivamus tristique nisi eu metus dictum, sed rhoncus eros malesuada. Sed faucibus commodo justo, eu facilisis nisl dignissim ac. Donec ac sodales mi, et ultrices erat.</p>\r\n\r\n<p style="text-align: justify;">In sollicitudin pellentesque aliquam. Quisque dictum mauris vehicula nibh pharetra rutrum. Donec aliquet, sapien non scelerisque po'),
(6, 1, 1, 1, '20489468795', 'EL QUE SE INDICA', 1, 'MEMORANDUM Nº 1-2018/GG/E.S.S.P. LEONES DE ORO S.R.L.', 1, 'HUÁNUCO, 09 DE ENERO DEL 2018', '2018-01-09', '<p style="text-align: justify;">Praesent euismod ex ut tellus commodo mattis. Integer malesuada dictum tellus id sagittis. Curabitur at sapien finibus orci tincidunt egestas id in velit. Maecenas ultrices odio quis euismod feugiat. Quisque dui erat, tincidunt non vestibulum in, malesuada et sem. Suspendisse erat dolor, rutrum non porttitor ut, venenatis ac eros. Nulla magna purus, egestas sit amet justo at, egestas tincidunt orci. Suspendisse ac nulla ut ante ultrices placerat sed ut ante. Aliquam mattis enim nibh, in imperdiet odio rhoncus tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean efficitur ipsum eros, vulputate finibus tortor tincidunt quis. Vivamus dictum accumsan pharetra. Vivamus risus dui, malesuada sed commodo quis, lobortis quis ipsum. Curabitur ultricies porta diam eu commodo. Suspendisse potenti.</p>\r\n\r\n<p style="text-align: justify;">Ut tincidunt quam nec ex suscipit, id imperdiet nulla accumsan. Nullam lobortis est metus, in ornare t'),
(7, 1, 1, 1, '20489468795', 'EL QUE SE INDICA', 1, 'MEMORANDUM Nº 2-2018/GG/E.S.S.P. LEONES DE ORO S.R.L.', 2, 'HUÁNUCO, 09 DE ENERO DEL 2018', '2018-01-09', '<p style="text-align: justify;">Praesent euismod ex ut tellus commodo mattis. Integer malesuada dictum tellus id sagittis. Curabitur at sapien finibus orci tincidunt egestas id in velit. Maecenas ultrices odio quis euismod feugiat. Quisque dui erat, tincidunt non vestibulum in, malesuada et sem. Suspendisse erat dolor, rutrum non porttitor ut, venenatis ac eros. Nulla magna purus, egestas sit amet justo at, egestas tincidunt orci. Suspendisse ac nulla ut ante ultrices placerat sed ut ante. Aliquam mattis enim nibh, in imperdiet odio rhoncus tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean efficitur ipsum eros, vulputate finibus tortor tincidunt quis. Vivamus dictum accumsan pharetra. Vivamus risus dui, malesuada sed commodo quis, lobortis quis ipsum. Curabitur ultricies porta diam eu commodo. Suspendisse potenti.</p>\r\n\r\n<p style="text-align: justify;">Ut tincidunt quam nec ex suscipit, id imperdiet nulla accumsan. Nullam lobortis est metus, in ornare t'),
(8, 1, 1, 1, '20489468795', 'EL QUE SE INDICA', 1, 'MEMORANDUM Nº 3-2018/GG/E.S.S.P. LEONES DE ORO S.R.L.', 3, 'HUÁNUCO, 09 DE ENERO DEL 2018', '2018-01-09', '<p>ksjhdf kjshdf kjhdf kjhfkgh kjdfgh kjdhfg kmdhfgkjh kjdfhg kdhfg kdjhfgkjh odjhfg kkjhdfg</p>\r\n'),
(9, 1, 1, 1, '20489468795', 'KJF', 1, 'MEMORANDUM Nº 4-2018/GG/E.S.S.P. LEONES DE ORO S.R.L.', 4, 'KJDHVKJ', '2018-01-09', '<p>Contenido...ksjdhf kjsdhf kjhf&nbsp;</p>\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorandum_trabajador`
--

CREATE TABLE `memorandum_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `memorandum_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `memorandum_trabajador`
--

INSERT INTO `memorandum_trabajador` (`id`, `memorandum_id`, `trabajador_id`) VALUES
(1, 1, 2),
(2, 2, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_08_23_204212_crear_tabla_empresas', 1),
('2016_08_23_204213_llenar_tabla_empresas', 1),
('2016_08_23_204312_crear_tabla_prendas', 1),
('2016_08_23_205006_llenar_tabla_prendas', 1),
('2016_08_24_114033_crear_tabla_armas', 1),
('2016_08_24_120710_llenar_tabla_armas', 1),
('2016_08_24_123503_crear_tabla_arma_empresa', 1),
('2016_08_25_111252_crear_tabla_empresa_prenda', 1),
('2016_08_30_090629_crear_tabla_personas', 1),
('2016_08_30_100947_crear_tabla_documentos', 1),
('2016_08_30_143630_crear_tabla_clientes', 1),
('2016_08_30_144903_crear_tabla_trabajadores', 1),
('2016_08_30_150804_crear_tabla_documento_trabajador', 1),
('2016_08_30_153357_crear_tabla_usuarios', 1),
('2016_09_03_093552_crear_tabla_cliente_empresa', 1),
('2016_09_03_104010_llenar_tabla_documentos', 1),
('2016_09_08_173321_crear_tabla_cargos', 1),
('2016_09_08_175048_llenar_tabla_cargos', 1),
('2016_09_13_032300_crear_tabla_empresa_prenda_trabajador_usuario', 1),
('2016_09_14_124751_crear_tabla_contratos', 1),
('2016_09_14_211804_crear_tabla_contrato_documento', 1),
('2016_09_17_104038_crear_tabla_retenciones', 1),
('2016_09_22_143454_crear_tabla_areas', 1),
('2016_09_22_161803_crear_tabla_area_empresa_usuario', 1),
('2016_09_22_233708_llenar_tabla_areas', 1),
('2016_10_04_160649_crear_tabla_cartas', 1),
('2016_10_04_190823_crear_tabla_tipo_memorandums', 1),
('2016_10_04_191458_crear_tabla_memorandums', 1),
('2016_10_05_180903_crear_tabla_variables', 1),
('2016_10_12_203800_crear_tabla_informes', 1),
('2016_10_16_121632_crear_tabla_costos', 1),
('2016_10_16_123528_crear_tabla_conceptos', 1),
('2016_10_16_144120_crear_tabla_turnos', 1),
('2016_10_16_144513_llenar_tabla_turnos', 1),
('2016_10_16_144754_crear_tabla_concepto_turno', 1),
('2016_10_23_183018_crear_tabla_memorandum_trabajador', 1),
('2016_10_25_112158_modificar_tabla_costos', 1),
('2016_10_25_170107_modificar_tabla_concepto_turno', 1),
('2016_11_22_152457_crear_tabla_puntos', 1),
('2016_11_23_084823_crear_tabla_punto_trabajador', 1),
('2016_11_23_134330_crear_tabla_asistencias', 1),
('2016_11_23_134802_crear_tabla_asistencia_trabajador', 1),
('2016_12_05_070512_crear_tabla_descuentos', 1),
('2016_12_05_071624_crear_tabla_descuento_trabajador', 1),
('2016_12_09_040643_crear_tabla_herramientas', 1),
('2016_12_09_041411_crear_tabla_empresa_herramienta', 1),
('2016_12_09_042245_crear_tabla_empresa_herramienta_trabajador', 1),
('2016_12_13_201900_crear_tabla_aseguradoras', 1),
('2016_12_13_210918_modificar_tabla_trabajadores', 1),
('2016_12_17_231412_crear_tabla_bonificaciones', 1),
('2016_12_17_232400_crear_tabla_bonificacion_trabajador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `dni` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`dni`, `nombre`, `apellidos`, `direccion`, `telefono`) VALUES
('12236543', 'JUAN CARLOS', 'HUAMAN VALVERDE', '', ''),
('41419688', 'DANTE ESTEBAN', 'CORTES GANOZA', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `talla` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`id`, `nombre`, `talla`) VALUES
(1, 'PANTALON', 'M'),
(2, 'PANTALON', 'L'),
(3, 'PANTALON', 'XL'),
(4, 'CAMISA', 'M'),
(5, 'CAMISA', 'L'),
(6, 'CAMISA', 'XL'),
(7, 'BIRRETE', 'M'),
(8, 'BIRRETE', 'L'),
(9, 'BIRRETE', 'XL'),
(10, 'CORBATA', 'UNICA'),
(11, 'CHOMPA', 'UNICA'),
(12, 'CAPOTIN', 'UNICA'),
(13, 'BORCEQUIES', '40'),
(14, 'BORCEQUIES', '41'),
(15, 'BORCEQUIES', '42'),
(16, 'BORCEQUIES', '43'),
(17, 'VARA', 'UNICA'),
(18, 'LINTERNA', 'UNICA'),
(19, 'CINTURON', 'UNICA'),
(20, 'RADIO/CELURAR', 'UNICA'),
(21, 'SILBATO', 'UNICA'),
(22, 'CHAQUETA', 'M'),
(23, 'CHAQUETA', 'L'),
(24, 'POLO', 'M'),
(25, 'POLO', 'L'),
(26, 'ZAPATILLAS', '36'),
(27, 'ZAPATILLAS', '37'),
(28, 'ZAPATILLAS', '38'),
(29, 'ZAPATILLAS', '39'),
(30, 'ZAPATILLAS', '40'),
(31, 'ZAPATILLAS', '41'),
(32, 'ZAPATILLAS', '42'),
(33, 'BOTAS DE JEBE', 'UNICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE `puntos` (
  `id` int(10) UNSIGNED NOT NULL,
  `contrato_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `punto_trabajador`
--

CREATE TABLE `punto_trabajador` (
  `id` int(10) UNSIGNED NOT NULL,
  `punto_id` int(10) UNSIGNED NOT NULL,
  `trabajador_id` int(10) UNSIGNED NOT NULL,
  `cargo_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones`
--

CREATE TABLE `retenciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `contrato_id` int(10) UNSIGNED NOT NULL,
  `porcentaje` float(8,2) NOT NULL,
  `partes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_memorandums`
--

CREATE TABLE `tipo_memorandums` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_memorandums`
--

INSERT INTO `tipo_memorandums` (`id`, `nombre`) VALUES
(1, 'SANCIóN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` int(10) UNSIGNED NOT NULL,
  `persona_dni` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `aseguradora_id` int(10) UNSIGNED DEFAULT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `sueldo` double NOT NULL,
  `af` tinyint(1) NOT NULL,
  `he` int(11) NOT NULL,
  `cuenta` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `banco` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cci` tinyint(1) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`id`, `persona_dni`, `empresa_ruc`, `aseguradora_id`, `inicio`, `fin`, `sueldo`, `af`, `he`, `cuenta`, `banco`, `cci`, `foto`) VALUES
(2, '12236543', '20489468795', NULL, '2017-01-01', '2017-12-31', 850, 1, 4, '', '', NULL, 'usuario.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `entrada` time NOT NULL,
  `salida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id`, `nombre`, `entrada`, `salida`) VALUES
(1, 'DIURNO', '08:00:00', '20:00:00'),
(2, 'NOCTURNO', '20:00:00', '08:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `persona_dni` varchar(8) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nivel` tinyint(4) NOT NULL,
  `caja` tinyint(1) NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `persona_dni`, `password`, `remember_token`, `nivel`, `caja`, `contrasenia`) VALUES
(1, '41419688', '$2y$10$41kv3T4iQzv4NTsK1tFxnuG3Q4/TqrN/.r3ZqjOjPpqcxNiA2BuLm', 'Ma2Tf3hopEL4zmDSQ1WRVWip5NlU3zHostEmsxyc5ii2Z33LFMly7eNxei9P', 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variables`
--

CREATE TABLE `variables` (
  `id` int(10) UNSIGNED NOT NULL,
  `empresa_ruc` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_anio` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `inicio_memorandum` int(10) UNSIGNED DEFAULT NULL,
  `inicio_carta` int(10) UNSIGNED DEFAULT NULL,
  `inicio_informe` int(10) UNSIGNED DEFAULT NULL,
  `anio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `variables`
--

INSERT INTO `variables` (`id`, `empresa_ruc`, `nombre_anio`, `inicio_memorandum`, `inicio_carta`, `inicio_informe`, `anio`) VALUES
(1, '20489468795', 'AÑO DE LA RESTAURACIÓN INDUSTRIAL 2017', 74, 85, 59, 2017),
(2, '20489468795', 'AÑO DE LA REFORESTACION DE LA AMAZONIA PERUANA 2018', 1, 1, 1, 2018);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `area_empresa_usuario`
--
ALTER TABLE `area_empresa_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_empresa_usuario_area_id_foreign` (`area_id`),
  ADD KEY `area_empresa_usuario_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `area_empresa_usuario_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `arma_empresa`
--
ALTER TABLE `arma_empresa`
  ADD PRIMARY KEY (`serie`),
  ADD KEY `arma_empresa_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `arma_empresa_arma_id_foreign` (`arma_id`);

--
-- Indices de la tabla `aseguradoras`
--
ALTER TABLE `aseguradoras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencias_punto_id_foreign` (`punto_id`),
  ADD KEY `asistencias_turno_id_foreign` (`turno_id`);

--
-- Indices de la tabla `asistencia_trabajador`
--
ALTER TABLE `asistencia_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencia_trabajador_asistencia_id_foreign` (`asistencia_id`),
  ADD KEY `asistencia_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `bonificaciones`
--
ALTER TABLE `bonificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bonificacion_trabajador`
--
ALTER TABLE `bonificacion_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bonificacion_trabajador_bonificacion_id_foreign` (`bonificacion_id`),
  ADD KEY `bonificacion_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cartas_usuario_id_foreign` (`usuario_id`),
  ADD KEY `cartas_empresa_ruc_foreign` (`empresa_ruc`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ruc`);

--
-- Indices de la tabla `cliente_empresa`
--
ALTER TABLE `cliente_empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_empresa_cliente_ruc_foreign` (`cliente_ruc`),
  ADD KEY `cliente_empresa_empresa_ruc_foreign` (`empresa_ruc`);

--
-- Indices de la tabla `conceptos`
--
ALTER TABLE `conceptos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conceptos_costo_id_foreign` (`costo_id`);

--
-- Indices de la tabla `concepto_turno`
--
ALTER TABLE `concepto_turno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concepto_turno_concepto_id_foreign` (`concepto_id`),
  ADD KEY `concepto_turno_turno_id_foreign` (`turno_id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contratos_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `contratos_cliente_ruc_foreign` (`cliente_ruc`);

--
-- Indices de la tabla `contrato_documento`
--
ALTER TABLE `contrato_documento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrato_documento_contrato_id_foreign` (`contrato_id`),
  ADD KEY `contrato_documento_documento_id_foreign` (`documento_id`);

--
-- Indices de la tabla `costos`
--
ALTER TABLE `costos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `costos_empresa_ruc_foreign` (`empresa_ruc`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuento_trabajador`
--
ALTER TABLE `descuento_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `descuento_trabajador_descuento_id_foreign` (`descuento_id`),
  ADD KEY `descuento_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documento_trabajador`
--
ALTER TABLE `documento_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documento_trabajador_documento_id_foreign` (`documento_id`),
  ADD KEY `documento_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`ruc`);

--
-- Indices de la tabla `empresa_herramienta`
--
ALTER TABLE `empresa_herramienta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empresa_herramienta_serie_unique` (`serie`),
  ADD KEY `empresa_herramienta_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `empresa_herramienta_herramienta_id_foreign` (`herramienta_id`);

--
-- Indices de la tabla `empresa_herramienta_trabajador`
--
ALTER TABLE `empresa_herramienta_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_herramienta_trabajador_empresa_herramienta_id_foreign` (`empresa_herramienta_id`),
  ADD KEY `empresa_herramienta_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `empresa_prenda`
--
ALTER TABLE `empresa_prenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_prenda_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `empresa_prenda_prenda_id_foreign` (`prenda_id`);

--
-- Indices de la tabla `empresa_prenda_trabajador_usuario`
--
ALTER TABLE `empresa_prenda_trabajador_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_prenda_trabajador_usuario_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `empresa_prenda_trabajador_usuario_prenda_id_foreign` (`prenda_id`),
  ADD KEY `empresa_prenda_trabajador_usuario_trabajador_id_foreign` (`trabajador_id`),
  ADD KEY `empresa_prenda_trabajador_usuario_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informes`
--
ALTER TABLE `informes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informes_usuario_id_foreign` (`usuario_id`),
  ADD KEY `informes_empresa_ruc_foreign` (`empresa_ruc`);

--
-- Indices de la tabla `memorandums`
--
ALTER TABLE `memorandums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memorandums_usuario_id_foreign` (`usuario_id`),
  ADD KEY `memorandums_remite_foreign` (`remite`),
  ADD KEY `memorandums_area_id_foreign` (`area_id`),
  ADD KEY `memorandums_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `memorandums_tipo_memorandum_id_foreign` (`tipo_memorandum_id`);

--
-- Indices de la tabla `memorandum_trabajador`
--
ALTER TABLE `memorandum_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memorandum_trabajador_memorandum_id_foreign` (`memorandum_id`),
  ADD KEY `memorandum_trabajador_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `puntos_contrato_id_foreign` (`contrato_id`);

--
-- Indices de la tabla `punto_trabajador`
--
ALTER TABLE `punto_trabajador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `punto_trabajador_punto_id_foreign` (`punto_id`),
  ADD KEY `punto_trabajador_trabajador_id_foreign` (`trabajador_id`),
  ADD KEY `punto_trabajador_cargo_id_foreign` (`cargo_id`);

--
-- Indices de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retenciones_contrato_id_foreign` (`contrato_id`);

--
-- Indices de la tabla `tipo_memorandums`
--
ALTER TABLE `tipo_memorandums`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trabajadores_persona_dni_foreign` (`persona_dni`),
  ADD KEY `trabajadores_empresa_ruc_foreign` (`empresa_ruc`),
  ADD KEY `trabajadores_aseguradora_id_foreign` (`aseguradora_id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_persona_dni_foreign` (`persona_dni`);

--
-- Indices de la tabla `variables`
--
ALTER TABLE `variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variables_empresa_ruc_foreign` (`empresa_ruc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `area_empresa_usuario`
--
ALTER TABLE `area_empresa_usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `aseguradoras`
--
ALTER TABLE `aseguradoras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `asistencia_trabajador`
--
ALTER TABLE `asistencia_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `bonificaciones`
--
ALTER TABLE `bonificaciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `bonificacion_trabajador`
--
ALTER TABLE `bonificacion_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cartas`
--
ALTER TABLE `cartas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `cliente_empresa`
--
ALTER TABLE `cliente_empresa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `conceptos`
--
ALTER TABLE `conceptos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `concepto_turno`
--
ALTER TABLE `concepto_turno`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `contrato_documento`
--
ALTER TABLE `contrato_documento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `costos`
--
ALTER TABLE `costos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descuento_trabajador`
--
ALTER TABLE `descuento_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `documento_trabajador`
--
ALTER TABLE `documento_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `empresa_herramienta`
--
ALTER TABLE `empresa_herramienta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa_herramienta_trabajador`
--
ALTER TABLE `empresa_herramienta_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa_prenda`
--
ALTER TABLE `empresa_prenda`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empresa_prenda_trabajador_usuario`
--
ALTER TABLE `empresa_prenda_trabajador_usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `informes`
--
ALTER TABLE `informes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `memorandums`
--
ALTER TABLE `memorandums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `memorandum_trabajador`
--
ALTER TABLE `memorandum_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `puntos`
--
ALTER TABLE `puntos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `punto_trabajador`
--
ALTER TABLE `punto_trabajador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_memorandums`
--
ALTER TABLE `tipo_memorandums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `variables`
--
ALTER TABLE `variables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `area_empresa_usuario`
--
ALTER TABLE `area_empresa_usuario`
  ADD CONSTRAINT `area_empresa_usuario_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_empresa_usuario_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_empresa_usuario_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `arma_empresa`
--
ALTER TABLE `arma_empresa`
  ADD CONSTRAINT `arma_empresa_arma_id_foreign` FOREIGN KEY (`arma_id`) REFERENCES `armas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `arma_empresa_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_punto_id_foreign` FOREIGN KEY (`punto_id`) REFERENCES `puntos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_turno_id_foreign` FOREIGN KEY (`turno_id`) REFERENCES `turnos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencia_trabajador`
--
ALTER TABLE `asistencia_trabajador`
  ADD CONSTRAINT `asistencia_trabajador_asistencia_id_foreign` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencia_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bonificacion_trabajador`
--
ALTER TABLE `bonificacion_trabajador`
  ADD CONSTRAINT `bonificacion_trabajador_bonificacion_id_foreign` FOREIGN KEY (`bonificacion_id`) REFERENCES `bonificaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bonificacion_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cartas`
--
ALTER TABLE `cartas`
  ADD CONSTRAINT `cartas_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente_empresa`
--
ALTER TABLE `cliente_empresa`
  ADD CONSTRAINT `cliente_empresa_cliente_ruc_foreign` FOREIGN KEY (`cliente_ruc`) REFERENCES `clientes` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cliente_empresa_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conceptos`
--
ALTER TABLE `conceptos`
  ADD CONSTRAINT `conceptos_costo_id_foreign` FOREIGN KEY (`costo_id`) REFERENCES `costos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `concepto_turno`
--
ALTER TABLE `concepto_turno`
  ADD CONSTRAINT `concepto_turno_concepto_id_foreign` FOREIGN KEY (`concepto_id`) REFERENCES `conceptos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `concepto_turno_turno_id_foreign` FOREIGN KEY (`turno_id`) REFERENCES `turnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_cliente_ruc_foreign` FOREIGN KEY (`cliente_ruc`) REFERENCES `clientes` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contratos_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contrato_documento`
--
ALTER TABLE `contrato_documento`
  ADD CONSTRAINT `contrato_documento_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrato_documento_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `costos`
--
ALTER TABLE `costos`
  ADD CONSTRAINT `costos_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `descuento_trabajador`
--
ALTER TABLE `descuento_trabajador`
  ADD CONSTRAINT `descuento_trabajador_descuento_id_foreign` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `descuento_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `documento_trabajador`
--
ALTER TABLE `documento_trabajador`
  ADD CONSTRAINT `documento_trabajador_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documento_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_herramienta`
--
ALTER TABLE `empresa_herramienta`
  ADD CONSTRAINT `empresa_herramienta_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_herramienta_herramienta_id_foreign` FOREIGN KEY (`herramienta_id`) REFERENCES `herramientas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_herramienta_trabajador`
--
ALTER TABLE `empresa_herramienta_trabajador`
  ADD CONSTRAINT `empresa_herramienta_trabajador_empresa_herramienta_id_foreign` FOREIGN KEY (`empresa_herramienta_id`) REFERENCES `empresa_herramienta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_herramienta_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_prenda`
--
ALTER TABLE `empresa_prenda`
  ADD CONSTRAINT `empresa_prenda_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_prenda_prenda_id_foreign` FOREIGN KEY (`prenda_id`) REFERENCES `prendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresa_prenda_trabajador_usuario`
--
ALTER TABLE `empresa_prenda_trabajador_usuario`
  ADD CONSTRAINT `empresa_prenda_trabajador_usuario_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_prenda_trabajador_usuario_prenda_id_foreign` FOREIGN KEY (`prenda_id`) REFERENCES `prendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_prenda_trabajador_usuario_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empresa_prenda_trabajador_usuario_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `informes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `memorandums`
--
ALTER TABLE `memorandums`
  ADD CONSTRAINT `memorandums_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandums_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandums_remite_foreign` FOREIGN KEY (`remite`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandums_tipo_memorandum_id_foreign` FOREIGN KEY (`tipo_memorandum_id`) REFERENCES `tipo_memorandums` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandums_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `memorandum_trabajador`
--
ALTER TABLE `memorandum_trabajador`
  ADD CONSTRAINT `memorandum_trabajador_memorandum_id_foreign` FOREIGN KEY (`memorandum_id`) REFERENCES `memorandums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memorandum_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD CONSTRAINT `puntos_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `punto_trabajador`
--
ALTER TABLE `punto_trabajador`
  ADD CONSTRAINT `punto_trabajador_cargo_id_foreign` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `punto_trabajador_punto_id_foreign` FOREIGN KEY (`punto_id`) REFERENCES `puntos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `punto_trabajador_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD CONSTRAINT `retenciones_contrato_id_foreign` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD CONSTRAINT `trabajadores_aseguradora_id_foreign` FOREIGN KEY (`aseguradora_id`) REFERENCES `aseguradoras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trabajadores_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trabajadores_persona_dni_foreign` FOREIGN KEY (`persona_dni`) REFERENCES `personas` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_persona_dni_foreign` FOREIGN KEY (`persona_dni`) REFERENCES `personas` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `variables`
--
ALTER TABLE `variables`
  ADD CONSTRAINT `variables_empresa_ruc_foreign` FOREIGN KEY (`empresa_ruc`) REFERENCES `empresas` (`ruc`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
