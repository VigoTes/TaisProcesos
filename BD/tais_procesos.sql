-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2021 a las 10:29:38
-- Versión del servidor: 5.7.32-log
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tais_procesos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idArea` int(11) NOT NULL,
  `nroEnEmpresa` int(11) NOT NULL,
  `descripcionArea` varchar(200) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `nombreArea` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idArea`, `nroEnEmpresa`, `descripcionArea`, `idEmpresa`, `nombreArea`) VALUES
(4, 1, 'Se encarga de gestionar las computadoras las redes y demas', 1, 'Tecnologias de Informacion'),
(5, 2, 'Area encargadaaaaaaaaaaaaa', 1, 'Contabilidad'),
(10, 2, 'Se encarga de administrar las tecnologías usadas por la empresa.', 2, 'Tecnologias de la informacion'),
(11, 3, 'Se encarga de gestionar las compras de insumos.', 2, 'Logística'),
(12, 1, 'Área encargada de brindar soporte a las demás áreas.', 2, 'Soporte tecnico'),
(13, 4, 'Se encarga de gestionar los rec humanos', 2, 'Recursos Humanos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio`
--

CREATE TABLE `cambio` (
  `idCambio` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cambio`
--

INSERT INTO `cambio` (`idCambio`, `descripcion`, `idEmpresa`, `idEmpleado`, `fechaHora`) VALUES
(1, 'Se actualizaron los datos principales de la empresa', 2, 0, '2021-04-20 01:03:11'),
(2, 'Se actualizaron los datos principales de la empresa', 2, 0, '2021-04-20 01:03:20'),
(3, 'Se ha  actualizado  el proceso Gestión de proyectoss de la empresa', 2, 0, '2021-04-20 01:09:06'),
(4, 'Se eliminó la relación entre las estrategias \"Propuesta de valor\" hacia \"Crecimiento de ingresos en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:17:40'),
(5, 'Se eliminó la relación entre las estrategias \"Gestión de clientes\" hacia \"Propuesta de valor en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:17:45'),
(6, 'Se eliminó la relación entre las estrategias \"Clima laboral\" hacia \"Regulatorios y ambientales en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:17:48'),
(7, 'Se agregó la relación elemento \"Propuesta de valor\" hacia \"Crecimiento de ingresos en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:17:56'),
(8, 'Se creó la estrategia  \"Autosustentabilidad\" en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:18:15'),
(9, 'Se ha  actualizado  un registro Enerox del indicador indicador del  proceso \'Monitoreo de implementación de plan anual de trabajo\'', 2, 0, '2021-04-20 01:24:01'),
(10, 'Se actualizaron los datos del indicadorindicador', 2, 0, '2021-04-20 01:24:19'),
(11, 'Se ha  actualizado  el proceso Gestión de proyectos de la empresa', 2, 0, '2021-04-20 01:27:20'),
(12, 'Se ha  Actualizado  el proceso Elaboración de proyectos de la empresa', 2, 0, '2021-04-20 01:27:46'),
(13, 'Se ha  añadido  el proceso Gestion de TI de la empresa', 2, 0, '2021-04-20 01:35:13'),
(14, 'Se ha  Agregado  el proceso Inventario de computadoras de la empresa', 2, 0, '2021-04-20 01:35:29'),
(15, 'Se agregó la relación elemento \"Clima laboral\" hacia \"Regulatorios y ambientales en el Proceso Contratacion de Personal', 2, 0, '2021-04-20 01:46:45'),
(16, 'Se eliminó al empleado ANA CECILIA ANGULO ALVAde la empresa', 2, 0, '2021-04-20 01:48:58'),
(17, 'Se eliminó al empleado JUDITH VERONICA AVILA JORGEde la empresa', 2, 0, '2021-04-20 01:49:04'),
(18, 'Se eliminó al empleado SANTOS ROSARIO ESCOBEDO SANCHEZde la empresa', 2, 0, '2021-04-20 01:49:10'),
(19, 'Se ha  añadido  el proceso Direccionamiento estratégico de la empresa', 2, 0, '2021-04-20 01:52:04'),
(20, 'Se ha  Agregado  el proceso Conducción Institucional de la empresa', 2, 0, '2021-04-20 01:52:19'),
(21, 'Se ha  Agregado  el proceso Gestión Institucional de la empresa', 2, 0, '2021-04-20 01:52:27'),
(22, 'Se ha  Agregado  el proceso Desarrollo conceptual de la empresa', 2, 0, '2021-04-20 01:52:37'),
(23, 'Se ha  Agregado  el proceso Gestión de sistemas de planificación de la empresa', 2, 0, '2021-04-20 01:52:46'),
(24, 'Se ha  Agregado  el proceso Planificación Presupuestal de la empresa', 2, 0, '2021-04-20 01:52:54'),
(25, 'Se ha  añadido  el proceso Provisión de Fondos de la empresa', 2, 0, '2021-04-20 01:54:39'),
(26, 'Se ha  Agregado  el proceso Gestión de Solicitudes de Fondos de la empresa', 2, 0, '2021-04-20 01:54:47'),
(27, 'Se ha  Agregado  el proceso Rendición de Gastos de la empresa', 2, 0, '2021-04-20 01:54:57'),
(28, 'Se creó la estrategia  \"Lograr la autosuficiencia financiera\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:00:37'),
(29, 'Se creó la estrategia  \"Satisfacer necesidades de las regiones\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:00:47'),
(30, 'Se creó la estrategia  \"Generar nuevas oportunidades de trabajo\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:00:57'),
(31, 'Se creó la estrategia  \"Brindar fondos correctamente\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:01:17'),
(32, 'Se creó la estrategia  \"Mejorar la eficiencia en  la provision de fondos\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:01:34'),
(33, 'Se agregó la relación elemento \"Brindar fondos correctamente\" hacia \"Satisfacer necesidades de las regiones en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:01:46'),
(34, 'Se agregó la relación elemento \"Brindar fondos correctamente\" hacia \"Generar nuevas oportunidades de trabajo en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:01:51'),
(35, 'Se agregó la relación elemento \"Mejorar la eficiencia en  la provision de fondos\" hacia \"Brindar fondos correctamente en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:01:57'),
(36, 'Se agregó la relación elemento \"Satisfacer necesidades de las regiones\" hacia \"Lograr la autosuficiencia financiera en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:02:02'),
(37, 'Se agregó la relación elemento \"Generar nuevas oportunidades de trabajo\" hacia \"Lograr la autosuficiencia financiera en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:02:08'),
(38, 'Se creó la estrategia  \"dadsa\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:02:15'),
(39, 'Se eliminó la estrategia  \"dadsa\" en el Subproceso Gestión de Solicitudes de Fondos', 2, 0, '2021-04-20 02:02:28'),
(40, 'Se ha creado el indicador Solicitudes aprobadas directamente del proceso Provisión de Fondos', 2, 0, '2021-04-20 02:05:09'),
(41, 'Se actualizaron los datos del indicador Solicitudes aprobadas directamente', 2, 0, '2021-04-20 02:05:57'),
(42, 'Se actualizaron los datos del indicador Solicitudes aprobadas directamente', 2, 0, '2021-04-20 02:07:46'),
(43, 'Se actualizaron los datos del indicador Solicitudes aprobadas directamente', 2, 0, '2021-04-20 02:16:07'),
(44, 'Se actualizaron los datos del indicador Solicitudes aprobadas directamente', 2, 0, '2021-04-20 02:17:13'),
(45, 'Se ha  añadido  un registro Enero del indicador Solicitudes aprobadas directamente del  proceso \'Provisión de Fondos\'', 2, 0, '2021-04-20 02:17:27'),
(46, 'Se ha  añadido  un registro Febrero del indicador Solicitudes aprobadas directamente del  proceso \'Provisión de Fondos\'', 2, 0, '2021-04-20 02:17:38'),
(47, 'Se ha  añadido  un registro Marzo del indicador Solicitudes aprobadas directamente del  proceso \'Provisión de Fondos\'', 2, 0, '2021-04-20 02:17:49'),
(48, 'Se eliminó la relación entre las estrategias \"Innovación\" hacia \"Propuesta de valor en el Proceso Contratacion de Personal', 2, 5, '2021-04-20 02:33:26'),
(49, 'Se  actualizó  al empleado JANET APAESTEGUI BUSTAMANTEde la empresa', 2, 5, '2021-04-20 02:33:48'),
(50, 'Se eliminó la estrategia  \"gadsa\" en el Proceso Monitoreo de implementación de plan anual de trabajo', 2, 0, '2021-04-20 02:39:08'),
(51, 'Se eliminó la estrategia  \"dsaadsasda\" en el Proceso Monitoreo de implementación de plan anual de trabajo', 2, 0, '2021-04-20 02:39:12'),
(52, 'Se eliminó la estrategia  \"planea\" en el Proceso Monitoreo de implementación de plan anual de trabajo', 2, 0, '2021-04-20 02:39:15'),
(53, 'Se  actualizó  al empleado JANET APAESTEGUI BUSTAMANTEde la empresa', 2, 0, '2021-04-20 02:45:34'),
(54, 'Se  actualizó  al empleado JANET APAESTEGUI BUSTAMANTEde la empresa', 2, 0, '2021-04-20 02:45:58'),
(55, 'Se  actualizó  al empleado JANET APAESTEGUI BUSTAMANTEde la empresa', 9, 0, '2021-04-20 02:47:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elemento_mapa`
--

CREATE TABLE `elemento_mapa` (
  `idElemento` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `idMapaEstrategico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `elemento_mapa`
--

INSERT INTO `elemento_mapa` (`idElemento`, `nombre`, `idNivel`, `idMapaEstrategico`) VALUES
(17, 'oye  sí', 4, 4),
(19, 'cuacki', 2, 4),
(20, 'camara web', 1, 4),
(24, 'Crecimiento de ingresos', 1, 1),
(25, 'Productividad', 1, 1),
(26, 'Propuesta de valor', 2, 1),
(27, 'Innovación', 3, 1),
(28, 'Gestión de clientes', 3, 1),
(29, 'Operaciones', 3, 1),
(30, 'Regulatorios y ambientales', 3, 1),
(31, 'Competencias y habilidades', 4, 1),
(32, 'Infraestructura y tecnología', 4, 1),
(33, 'Clima laboral', 4, 1),
(35, 'Autosustentabilidad', 1, 1),
(36, 'Lograr la autosuficiencia financiera', 1, 20),
(37, 'Satisfacer necesidades de las regiones', 2, 20),
(38, 'Generar nuevas oportunidades de trabajo', 2, 20),
(39, 'Brindar fondos correctamente', 3, 20),
(40, 'Mejorar la eficiencia en  la provision de fondos', 4, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `dni` char(8) NOT NULL,
  `activo` int(11) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `fechaDeBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `idUsuario`, `nombres`, `apellidos`, `dni`, `activo`, `fechaRegistro`, `fechaDeBaja`) VALUES
(0, 0, 'admin', 'admin', '71208489', 1, '2021-03-09', '2021-03-19'),
(1, 1, 'FAUSTO GILMER', 'ALARCON ROJAS', '40556946', 1, '2021-03-29', '2060-03-29'),
(2, 2, 'PAULA', 'ALIAGA RODRIGUEZ', '46636006', 1, '2021-03-29', '2060-03-29'),
(3, 3, 'GIANLUIGUI BRYAN', 'ALVARADO VELIZ', '47541289', 1, '2021-03-29', '2060-03-29'),
(4, 4, 'ANA CECILIA', 'ANGULO ALVA', '26682689', 1, '2021-03-29', '2060-03-29'),
(5, 5, 'JANET', 'APAESTEGUI BUSTAMANTE', '41943357', 1, '2021-03-29', '2060-03-29'),
(6, 6, 'HUBERT RICHARD', 'APARCO HUAMAN', '43485279', 1, '2021-03-29', '2060-03-29'),
(7, 7, 'JUDITH VERONICA', 'AVILA JORGE', '42090409', 1, '2021-03-29', '2060-03-29'),
(8, 8, 'MERY JAHAIRA', 'BENITES OBESO', '44847934', 1, '2021-03-29', '2060-03-29'),
(9, 9, 'MARYCRUZ ROCÍO', 'BRIONES ORDOÑEZ', '26682687', 1, '2021-03-29', '2060-03-29'),
(10, 10, 'MELVA VIRGINIA', 'CABRERA TEJADA', '17914644', 1, '2021-03-29', '2060-03-29'),
(11, 11, 'HINDIRA KATERINE', 'CASTAÑEDA ALFARO', '70355561', 1, '2021-03-29', '2060-03-29'),
(12, 12, 'WILSON EDGAR', 'COTRINA MEGO', '70585629', 1, '2021-03-29', '2060-03-29'),
(13, 13, 'ROXANA MELISSA', 'DONET PAREDES', '44685699', 1, '2021-03-29', '2060-03-29'),
(14, 14, 'SANTOS ROSARIO', 'ESCOBEDO SANCHEZ', '19327774', 1, '2021-03-29', '2060-03-29'),
(15, 15, 'JACQUELINE', 'GARCIA ESPINOZA', '40360154', 1, '2021-03-29', '2060-03-29'),
(16, 16, 'GABY SHARON', 'HUANCA MAMANI', '45740336', 1, '2021-03-29', '2060-03-29'),
(17, 17, 'CARLOS RICARDO', 'LEON LUTGARDO', '15738099', 1, '2021-03-29', '2060-03-29'),
(18, 18, 'JUAN CARLOS', 'LEON SAUCEDO', '19330869', 1, '2021-03-29', '2060-03-29'),
(19, 19, 'CRISTELL FRANCCESCA', 'LINO ZANONI', '74240802', 1, '2021-03-29', '2060-03-29'),
(20, 20, 'EDWAR LUIS', 'LIZARRAGA ALVAREZ', '70386230', 1, '2021-03-29', '2060-03-29'),
(21, 21, 'CYNTHIA ESPERANZA', 'LOPEZ PRADO', '42927000', 1, '2021-03-29', '2060-03-29'),
(22, 22, 'ROSSMERY LUZ', 'MARTINEZ OBANDO', '42305800', 1, '2021-03-29', '2060-03-29'),
(23, 23, 'CARMEN CECILIA', 'MOLLEAPASA PASTOR', '15766143', 1, '2021-03-29', '2060-03-29'),
(24, 24, 'CAROLYN LILIANA', 'MORENO PEREZ', '45540460', 1, '2021-03-29', '2060-03-29'),
(25, 25, 'KELY EUSEBIA', 'MULLER TITO', '45372425', 1, '2021-03-29', '2060-03-29'),
(26, 26, 'SEGUNDO EDGARDO', 'OBANDO PINTADO', '3120627', 1, '2021-03-29', '2060-03-29'),
(27, 27, 'ELVIS', 'ORRILLO MAYTA', '45576187', 1, '2021-03-29', '2060-03-29'),
(28, 28, 'SANTOS ABELARDO', 'PEREDA LUIS', '17877014', 1, '2021-03-29', '2060-03-29'),
(29, 29, 'KARLHOS MARCO', 'QUINDE RODRIGUEZ', '2897932', 1, '2021-03-29', '2060-03-29'),
(30, 30, 'MILAGROS', 'QUIROZ TORREJON', '44155217', 1, '2021-03-29', '2060-03-29'),
(31, 31, 'RONY AQUILES', 'RODRIGUEZ ROMERO', '18175358', 1, '2021-03-29', '2060-03-29'),
(32, 32, 'DANIEL', 'RODRIGUEZ RUIZ', '40068481', 1, '2021-03-29', '2060-03-29'),
(33, 33, 'JANET JACQUELINE', 'ROJAS GONZALEZ', '18126610', 1, '2021-03-29', '2060-03-29'),
(34, 34, 'RICHARD JAVIER', 'ROSILLO ASTUDILLO', '43162714', 1, '2021-03-29', '2060-03-29'),
(35, 35, 'TANIA JULISSA', 'RUIZ CORNEJO', '40392458', 1, '2021-03-29', '2060-03-29'),
(36, 36, 'CINTHIA CAROLYN', 'SANCHEZ RAMIREZ', '40242073', 1, '2021-03-29', '2060-03-29'),
(37, 37, 'NELIDA RICARDINA', 'SERIN CRUZADO', '40994213', 1, '2021-03-29', '2060-03-29'),
(38, 38, 'JUAN CARLOS', 'SILVA COTRINA', '42122048', 1, '2021-03-29', '2060-03-29'),
(39, 39, 'JUANA ROSA', 'URIOL VILLALOBOS', '44896824', 1, '2021-03-29', '2060-03-29'),
(40, 40, 'CARLOS ANIBAL', 'VILCA CHAVEZ', '46352412', 1, '2021-03-29', '2060-03-29'),
(41, 41, 'JAVIER OSMAR', 'VILLENA RAMOS', '43953715', 1, '2021-03-29', '2060-03-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nombreEmpresa` varchar(200) NOT NULL,
  `ruc` varchar(13) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `mision` varchar(300) NOT NULL,
  `vision` varchar(300) NOT NULL,
  `factorDif` varchar(300) NOT NULL,
  `propuestaV` varchar(300) NOT NULL,
  `estadoAct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombreEmpresa`, `ruc`, `direccion`, `mision`, `vision`, `factorDif`, `propuestaV`, `estadoAct`) VALUES
(1, 'Ubisoftxz', '1234567891231', 'Los corales 18258 asl dlas  2195  LT2XXXXXXXXX', 'mision de buausd a dsja sjjsa', 'd asdsabdsbads da sdasbdsadsabasdbas', 'asdda ssa asas a sddas as asadbabd dsadsabsbaddbdas', 'adasdab dasbadsdsasdsadsadb sadasdadxxxxx', 1),
(2, 'Cedepas Norte SAC', '2581474571591', 'Los Corales 289 Urb. Santa Inés TRUJILLO, PERÚS', 'Organizar la información de mundo y hacerla accesible a todos', 'Organizar la información de mundo y hacerla accesible a todos', 'CEDEPAS Norte tiene calificación de CITE agropecuario\r\n(Resolución Ejecutiva Nº 113-2015-ITP/DE. El  Peruano, Trujillo, Perú, 17 de noviembre de 2015', 'La propuesta de valor de CEDEPAS Norte, en la sede de Trujillo, es proponer una innovadora y funcional plataforma de servicios especializados en tecnología y gestión y desarrollo de proyectos a los productores, empresas, asociaciones y cooperativas; en un marco de desarrollo territorial rural.', 1),
(3, 'Coca Cola', '2581473691591', 'Callecristal 362 interior A5', 'AASDSA SA  SS', 'AS XA XA xxxxxxxxxxxxxxxxxx', 'ADWWAT AWT AWWT', 'ATW TWA ATW', 0),
(4, 'Vigosoft', '2581474571591', 'Estados Unidos -> laravella', 'asdadsdasasd dasdas dasads jmtymty my fyum', 'asd dasdas dasads jmtymty my fyu', 'asd dasdas dasads jmtymty my fyu', 'asd dasdas dasads jmtymty my fyu', 0),
(5, 'dasdas', '1234123412341', 'asdsaddas', 'asdsad', 'dsa', 'ads', 'asd', 0),
(6, 'dasdas', '1234123412341', 'asdsaddas', 'asdsad', 'dsa', 'ads', 'asd', 0),
(7, 'dasdas52', '1234123412333', 'asdsaddas21', 'asdsad52', 'dsa12', 'ads25', 'asd125', 0),
(8, 'Maracsoft', '1234123412341', 'sdadsa', 'adsdas', 'adsdas', 'asddsa', 'adsdasads', 0),
(9, 'Maracsoft', '1234123412341', 'sdadsa', 'adsdas', 'adsdas', 'asddsa', 'adsdasads', 1),
(10, 'gaga', '2581473691591', 'ga', 'ga', 'ga', 'ga', 'ga', 0),
(11, 'adsdsa', '1234567856743', 'as', 'dsadsa', 'asd', 'dsa', 'dasads', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresausuario`
--

CREATE TABLE `empresausuario` (
  `idEmpleado` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idAI` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresausuario`
--

INSERT INTO `empresausuario` (`idEmpleado`, `idEmpresa`, `idAI`, `idRol`) VALUES
(2, 1, 36, 0),
(2, 3, 37, 0),
(2, 4, 38, 0),
(3, 4, 40, 0),
(0, 1, 41, 0),
(0, 2, 42, 2),
(0, 3, 43, 0),
(0, 4, 44, 0),
(0, 7, 46, 0),
(18, 1, 51, 0),
(5, 2, 52, 3),
(0, 9, 53, 0),
(5, 9, 54, 4),
(0, 10, 55, 0),
(0, 11, 56, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flechaelementomapa`
--

CREATE TABLE `flechaelementomapa` (
  `idFlecha` int(11) NOT NULL,
  `idElementoOrigen` int(11) NOT NULL,
  `idElementoDestino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `flechaelementomapa`
--

INSERT INTO `flechaelementomapa` (`idFlecha`, `idElementoOrigen`, `idElementoDestino`) VALUES
(16, 19, 20),
(23, 29, 26),
(24, 30, 26),
(25, 31, 28),
(27, 26, 25),
(28, 26, 24),
(29, 33, 30),
(30, 39, 37),
(31, 39, 38),
(32, 40, 39),
(33, 37, 36),
(34, 38, 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicador`
--

CREATE TABLE `indicador` (
  `idIndicador` int(11) NOT NULL,
  `idProceso` int(11) DEFAULT NULL,
  `idSubproceso` int(11) DEFAULT NULL,
  `nombre` varchar(500) NOT NULL,
  `frecuenciaDeMedicion` varchar(500) NOT NULL,
  `unidadDeFrecuencia` varchar(500) NOT NULL,
  `limite1` float NOT NULL,
  `limite2` float NOT NULL,
  `sentidoDeSemaforo` int(11) NOT NULL,
  `lineaBase` float NOT NULL,
  `P_QueMedira` varchar(500) NOT NULL,
  `P_QuienMedira` varchar(500) NOT NULL,
  `P_Mecanismos` varchar(500) NOT NULL,
  `P_Tolerancia` varchar(500) NOT NULL,
  `P_QueSeHara` varchar(500) NOT NULL,
  `formula` varchar(500) NOT NULL,
  `unidadDeMedida` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `indicador`
--

INSERT INTO `indicador` (`idIndicador`, `idProceso`, `idSubproceso`, `nombre`, `frecuenciaDeMedicion`, `unidadDeFrecuencia`, `limite1`, `limite2`, `sentidoDeSemaforo`, `lineaBase`, `P_QueMedira`, `P_QuienMedira`, `P_Mecanismos`, `P_Tolerancia`, `P_QueSeHara`, `formula`, `unidadDeMedida`) VALUES
(1, 26, NULL, 'Rendiciones Contabilizadas Correctamente', '5', 'Día', 5, 6, 1, 6, 'La tasa de aceptación directa de las rendiciones de gastos', 'Contabilidad', 'Tasas, puesto que nos permite tener una mirada general sobre la cantidad de observaciones que se tienen en las rendiciones a nivel mensual, así como las que nunca fueron observadas y son aprobadas en primera instancia.', 'La tolerancia no debe ser mayor al 30% de rendiciones observadas', 'Se podrá evaluar si el subproceso rendición de gastos eficaz o se necesita aplicar una reingeniería de procesos o implementar un sistema para mejorarlo.', 'Tasa de RCD=(#RCD)/(#R)*100%', '5'),
(3, NULL, 17, 'Solicitudes aprobadas directamente', '', '', 0, 0, 0, 0, 'La tasa de aceptación directa de las solicitudes de fondos', 'Gerencia de proyectos y Administración', 'Tasas, puesto que nos permite tener una mirada general sobre la cantidad de observaciones que se tienen en las solicitudes a nivel mensual, así como las solicitudes que nunca fueron observadas y son aprobadas en primera instancia', 'La tolerancia no debe ser mayor al 30% de solicitudes observadas', 'Se podrá evaluar si el subproceso gestión de solicitudes de fondos es eficaz o se necesita aplicar una reingeniería de procesos o implementar un sistema para mejorarlo.', 'Tasa de SAD=(#SAD)/(#S)*100%', ''),
(5, NULL, 25, 'Cant estrategicas1', '', '', 0, 0, 0, 0, 'LA CANTIDAD PUES1', '2', '2Mis ojos', '250%', '2ejecutar un plan mejor de prevencion', '2CANT ESTRATEGICAS = CANT/TOTAL', ''),
(6, 33, NULL, 'SOF', '52', 'Día', 5, 122, 0, 1, 'DSAKASKD', 'DIEGO VIGO', 'AKDSKADS', '51', 'ASDKKDAS', 'T=512&ASD*52', 'carteles'),
(7, 33, NULL, 'indicador', '8', 'Mes', 55.7, 456, 0, 53, '1a', '4a', '2a', '5a', '3a', '6a', 'carteles DE ROPaaA'),
(8, 34, NULL, 'Gastos administrativos', '1', 'Año', 5, 11, 1, 30, 'La relación de gastos administrativos y totales en los proyectos', 'Gerente de proyectos', 'Se usarán datos obtenidos de los informes finales de la organización', 'La tolerancia no debe ser mayor al 60% del gasto total', 'Se podrá evaluar si la gran parte del presupuesto del proyecto se destina a gastos administrativos o a gastos netamente del proyecto.', 'Tasa de Gasto Adm=(Gasto administrativo)/(Gasto total del proyecto)*100%', 'porcentaje'),
(9, 38, NULL, 'Solicitudes aprobadas directamente', '1', 'Proyecto', 0.3, 0.7, 1, 0.7, 'La tasa de aceptación directa de las solicitudes de fondos', 'Gerencia de proyectos y Administración', 'Tasas, puesto que nos permite tener una mirada general sobre la cantidad de observaciones que se tienen en las solicitudes a nivel mensual, así como las solicitudes que nunca fueron observadas y son aprobadas en primera instancia.', 'La tolerancia no debe ser mayor al 30% de solicitudes observadas', 'Se podrá evaluar si el subproceso gestión de solicitudes de fondos es eficaz o se necesita aplicar una reingeniería de procesos o implementar un sistema para mejorarlo.', 'Tasa de SAD=(#SAD)/(#S)*100%', 'Solicitudes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapaestrategico`
--

CREATE TABLE `mapaestrategico` (
  `idMapaEstrategico` int(11) NOT NULL,
  `idProceso` int(11) DEFAULT NULL,
  `idSubproceso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mapaestrategico`
--

INSERT INTO `mapaestrategico` (`idMapaEstrategico`, `idProceso`, `idSubproceso`) VALUES
(1, 26, NULL),
(2, 33, NULL),
(3, 34, NULL),
(4, NULL, 33),
(5, NULL, 34),
(6, 34, NULL),
(7, 35, NULL),
(8, 34, NULL),
(9, 34, NULL),
(10, NULL, 33),
(11, 36, NULL),
(12, NULL, 35),
(13, 37, NULL),
(14, NULL, 36),
(15, NULL, 37),
(16, NULL, 38),
(17, NULL, 39),
(18, NULL, 40),
(19, 38, NULL),
(20, NULL, 41),
(21, NULL, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_mapa`
--

CREATE TABLE `nivel_mapa` (
  `idNivel` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel_mapa`
--

INSERT INTO `nivel_mapa` (`idNivel`, `nombre`) VALUES
(1, 'Financiera'),
(2, 'Clientes'),
(3, 'Procesos Internos'),
(4, 'Aprendizaje y Crecimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivo`
--

CREATE TABLE `objetivo` (
  `idObjetivoEst` int(11) NOT NULL,
  `descripcionObj` varchar(200) NOT NULL,
  `empresa_idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `objetivo`
--

INSERT INTO `objetivo` (`idObjetivoEst`, `descripcionObj`, `empresa_idEmpresa`) VALUES
(1, 'asd sa sadsa a wdaw daw daw daw daw da wdd wa', 1),
(2, '2do obj', 1),
(3, 'este tercero', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idPermiso`, `nombre`) VALUES
(1, 'empresa.ver'),
(2, 'empresa.crear'),
(3, 'empresa.editar'),
(4, 'proceso.ver'),
(5, 'proceso.CEE'),
(6, 'subproceso.ver'),
(7, 'subproceso.CEE'),
(8, 'mapa.ver'),
(9, 'mapa.CEE'),
(10, 'registro.ver'),
(11, 'registro.CEE'),
(12, 'indicador.ver'),
(13, 'indicador.CEE'),
(14, 'empleado.CEE'),
(15, 'empleadoDeEmpresa.CEE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisorol`
--

CREATE TABLE `permisorol` (
  `idPermisoRol` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisorol`
--

INSERT INTO `permisorol` (`idPermisoRol`, `idPermiso`, `idRol`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
(4, 4, 0),
(5, 5, 0),
(6, 6, 0),
(7, 7, 0),
(8, 8, 0),
(9, 9, 0),
(10, 10, 0),
(11, 11, 0),
(12, 12, 0),
(13, 13, 0),
(14, 1, 2),
(16, 3, 2),
(17, 4, 2),
(18, 5, 2),
(19, 6, 2),
(20, 7, 2),
(21, 8, 2),
(22, 9, 2),
(23, 10, 2),
(24, 11, 2),
(25, 12, 2),
(26, 13, 2),
(27, 1, 3),
(28, 4, 3),
(29, 6, 3),
(30, 9, 3),
(31, 10, 3),
(32, 11, 3),
(33, 12, 3),
(34, 13, 3),
(35, 1, 4),
(36, 4, 4),
(37, 6, 4),
(38, 8, 4),
(39, 10, 4),
(40, 12, 4),
(41, 14, 0),
(42, 15, 0),
(43, 15, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `idProceso` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`idProceso`, `descripcion`, `idEmpresa`, `nombre`) VALUES
(26, 'Proceso encargado de contratar al personal necesario para los proyectos', 2, 'Contratacion de Personal'),
(33, 'Revisar informes periódicos y finales de acuerdo a contrato con financiera Compara metas y plazos programadas con metas ejecutadas Emite un informe de monitoreo', 2, 'Monitoreo de implementación de plan anual de trabajo'),
(34, 'Se encarga de hacer todo lo referente a proyectos.', 2, 'Gestión de proyectos'),
(35, 'a', 1, 'Planeamiento estratégico'),
(36, 'Gestión de TI es el proceso de supervisión de todos los asuntos relacionados con las operaciones y recursos de tecnología de la información dentro de una organización.', 2, 'Gestion de TI'),
(37, 'el direccionamiento estratégico influye en los planes operativos que debe tener el desarrollo exhaustivo del qué, cómo, cuándo y quién, dejando claro los hitos de cumplimiento de la estrategia y los factores críticos de éxito para fomentar la responsabilidad en el proceso', 2, 'Direccionamiento estratégico'),
(38, 'a', 2, 'Provisión de Fondos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `idPuesto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `idArea` int(11) NOT NULL,
  `nroEnArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`idPuesto`, `nombre`, `idArea`, `nroEnArea`) VALUES
(9, 'Jefe de TI', 4, 1),
(10, 'Ingeniero de Sistemas', 4, 2),
(23, 'Informático', 12, 1),
(24, 'Técnico', 12, 2),
(25, 'Jefe de logistica', 11, 1),
(26, 'Jefe de TI', 10, 1),
(27, 'Asistente de TI', 10, 2),
(28, 'Practicante de sistemas', 10, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_indicador`
--

CREATE TABLE `registro_indicador` (
  `idRegistro` int(11) NOT NULL,
  `nombrePeriodo` varchar(500) NOT NULL,
  `valor` float NOT NULL,
  `idIndicador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registro_indicador`
--

INSERT INTO `registro_indicador` (`idRegistro`, `nombrePeriodo`, `valor`, `idIndicador`) VALUES
(1, 'Enerox', 455, 7),
(2, 'Febrero', 12, 7),
(5, 'Marzo', 555, 7),
(6, 'Enero', 17, 1),
(7, 'Pacificación cuyes', 8, 8),
(8, 'Enero', 0.24, 9),
(9, 'Febrero', 0.32, 9),
(10, 'Marzo', 0.37, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre`, `descripcion`) VALUES
(0, 'Admin total', 'Puede crear empresas y asignar permisos en estas'),
(2, 'Administrador', 'Puede crear procesos y subprocesos, crear indicadores.'),
(3, 'Editor', 'Editar mapa estrategico, generar registros de indicadores.'),
(4, 'Visitante', 'Puede ver todo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subproceso`
--

CREATE TABLE `subproceso` (
  `idSubproceso` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `idProceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subproceso`
--

INSERT INTO `subproceso` (`idSubproceso`, `nombre`, `idProceso`) VALUES
(6, 'Gestion de Recursos humanos', 21),
(8, 'Creacion del inventario', 21),
(21, 'Desarrollo Conceptual', 27),
(22, 'Gestión de sistemas de planificación', 27),
(23, 'Gestión de financiamiento', 27),
(24, 'Identificación de necesidades', 28),
(25, 'Diseño de estrategias de intervencion', 28),
(26, 'contratación de profesores', 29),
(30, 'Registro de PC', 30),
(33, 'Elaboración de proyectos', 34),
(34, 'Implementación del proyecto', 34),
(35, 'Inventario de computadoras', 36),
(36, 'Conducción Institucional', 37),
(37, 'Gestión Institucional', 37),
(38, 'Desarrollo conceptual', 37),
(39, 'Gestión de sistemas de planificación', 37),
(40, 'Planificación Presupuestal', 37),
(41, 'Gestión de Solicitudes de Fondos', 38),
(42, 'Rendición de Gastos', 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadfrecuenciaindicador`
--

CREATE TABLE `unidadfrecuenciaindicador` (
  `idUnidad` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidadfrecuenciaindicador`
--

INSERT INTO `unidadfrecuenciaindicador` (`idUnidad`, `nombre`) VALUES
(1, 'Día'),
(2, 'Mes'),
(3, 'Año'),
(4, 'Proyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `isAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usuario`, `password`, `isAdmin`) VALUES
(0, 'admin', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 1),
(1, 'E0428', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(2, 'E0727', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(3, 'E0668', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(4, 'E0004', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(5, 'E0306', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(6, 'E0674', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(7, 'E0435', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(8, 'E0726', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(9, 'E0149', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(10, 'E0103', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(11, 'E0729', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(12, 'E0787', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(13, 'E0267', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(14, 'E0075', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(15, 'E0177', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(16, 'E0716', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(17, 'E0677', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(18, 'E0269', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(19, 'E0679', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(20, 'E0718', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(21, 'E0641', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(22, 'E0286', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(23, 'E0454', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(24, 'E0612', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(25, 'E0703', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(26, 'E0195', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(27, 'E0721', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(28, 'E0159', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(29, 'E0397', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(30, 'E0510', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(31, 'E0084', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(32, 'E0181', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(33, 'E0063', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(34, 'E0593', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(35, 'E0390', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(36, 'E0092', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(37, 'E0524', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(38, 'E0704', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(39, 'E0568', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(40, 'E0763', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0),
(41, 'E0765', '$2y$10$NT382fPkmou2YFXnAfN5V.DghGqNKhA5Ai/DycFWTIQ4dJKmlbXOu', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idArea`);

--
-- Indices de la tabla `cambio`
--
ALTER TABLE `cambio`
  ADD PRIMARY KEY (`idCambio`);

--
-- Indices de la tabla `elemento_mapa`
--
ALTER TABLE `elemento_mapa`
  ADD PRIMARY KEY (`idElemento`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `empresausuario`
--
ALTER TABLE `empresausuario`
  ADD PRIMARY KEY (`idAI`);

--
-- Indices de la tabla `flechaelementomapa`
--
ALTER TABLE `flechaelementomapa`
  ADD PRIMARY KEY (`idFlecha`);

--
-- Indices de la tabla `indicador`
--
ALTER TABLE `indicador`
  ADD PRIMARY KEY (`idIndicador`);

--
-- Indices de la tabla `mapaestrategico`
--
ALTER TABLE `mapaestrategico`
  ADD PRIMARY KEY (`idMapaEstrategico`);

--
-- Indices de la tabla `nivel_mapa`
--
ALTER TABLE `nivel_mapa`
  ADD PRIMARY KEY (`idNivel`);

--
-- Indices de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  ADD PRIMARY KEY (`idObjetivoEst`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idPermiso`);

--
-- Indices de la tabla `permisorol`
--
ALTER TABLE `permisorol`
  ADD PRIMARY KEY (`idPermisoRol`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`idProceso`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`idPuesto`);

--
-- Indices de la tabla `registro_indicador`
--
ALTER TABLE `registro_indicador`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `subproceso`
--
ALTER TABLE `subproceso`
  ADD PRIMARY KEY (`idSubproceso`);

--
-- Indices de la tabla `unidadfrecuenciaindicador`
--
ALTER TABLE `unidadfrecuenciaindicador`
  ADD PRIMARY KEY (`idUnidad`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cambio`
--
ALTER TABLE `cambio`
  MODIFY `idCambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `elemento_mapa`
--
ALTER TABLE `elemento_mapa`
  MODIFY `idElemento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `empresausuario`
--
ALTER TABLE `empresausuario`
  MODIFY `idAI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `flechaelementomapa`
--
ALTER TABLE `flechaelementomapa`
  MODIFY `idFlecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `indicador`
--
ALTER TABLE `indicador`
  MODIFY `idIndicador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `mapaestrategico`
--
ALTER TABLE `mapaestrategico`
  MODIFY `idMapaEstrategico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `nivel_mapa`
--
ALTER TABLE `nivel_mapa`
  MODIFY `idNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  MODIFY `idObjetivoEst` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idPermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `permisorol`
--
ALTER TABLE `permisorol`
  MODIFY `idPermisoRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `idProceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `idPuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `registro_indicador`
--
ALTER TABLE `registro_indicador`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `subproceso`
--
ALTER TABLE `subproceso`
  MODIFY `idSubproceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `unidadfrecuenciaindicador`
--
ALTER TABLE `unidadfrecuenciaindicador`
  MODIFY `idUnidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
