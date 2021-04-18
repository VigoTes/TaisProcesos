-- RECUPERADO DE LA BASE DE DATOS EL 23 01 2021 el dia despues de la presentacion del proy de 2da unidad de PESI

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2021 a las 16:13:16
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pesiprocorg1`
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
-- Estructura de tabla para la tabla `cambioedicion`
--

CREATE TABLE `cambioedicion` (
  `idCambio` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `nroCambioEnEmpresa` int(11) NOT NULL,
  `fechaHoraCambio` datetime NOT NULL,
  `descripcionDelCambio` varchar(300) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `anteriorValor` varchar(300) NOT NULL,
  `nuevoValor` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cambioedicion`
--

INSERT INTO `cambioedicion` (`idCambio`, `idEmpresa`, `nroCambioEnEmpresa`, `fechaHoraCambio`, `descripcionDelCambio`, `idUsuario`, `anteriorValor`, `nuevoValor`) VALUES
(1, 2, 1, '2021-01-20 19:38:38', 'primer cambio de prueba', 1, 'aaaaaa', 'nuevo'),
(4, 2, 2, '2021-01-21 01:21:14', 'Se editó un proceso.', 1, 'Administracion y Se encarga de administrar todos los bienes y activos de la empresa.', 'Administraciones y Se encarga de administrar todos los bienes y activos de la empresa'),
(5, 2, 3, '2021-01-21 01:21:45', 'Se editó un proceso.', 1, 'Administraciones y Se encarga de administrar todos los bienes y activos de la empresa', 'Administracionesx y Se encarga de administrar todos los bienes y activos de la empresa'),
(6, 2, 4, '2021-01-21 01:26:41', 'Se editó un proceso.', 1, 'Administracionesx y Se encarga de administrar todos los bienes y activos de la empresa', 'Administracionesx y Se encarga de administrar todos los bienes y activos de la empresa.'),
(7, 2, 5, '2021-01-21 01:32:37', 'Se editó un proceso.', 1, 'Gestion de Almacenes y Proceso encargado de registrar editar y verificar las existencias, entradas y salidas del almacén.', 'Gestion de Almacenes y Proceso encargado de registrar editar y verificar las existencias, entradas y salidas del almacén'),
(8, 2, 6, '2021-01-20 20:34:38', 'Se editó un proceso.', 1, 'Contabilidad y Proceso encargado de llevar registro de los movimientos de activos y pasivos de la empresa', 'Contabilidad y Proceso encargado de llevar registro de los movimientos de activos y pasivos de la empresa...'),
(9, 2, 7, '2021-01-20 20:39:26', 'Se creó un proceso.', 1, '', 'Conduccion Presupuestal'),
(10, 2, 8, '2021-01-20 20:39:59', 'Se editó un proceso.', 1, 'Conduccion Presupuestal y Se encarga de', 'Conduccion Presupuestal y Se encarga de conducir el presupuesto y velar su cumplimiento.'),
(11, 2, 9, '2021-01-20 20:51:00', 'Se creó una matriz.', 1, '', 'idMatrizCreada= descripcion=as'),
(12, 2, 10, '2021-01-20 20:53:04', 'Se borró una matriz.', 1, 'idMatrizBorrada=5 descripcion=as', ''),
(13, 2, 11, '2021-01-20 21:00:51', 'Se editó una matriz (se añadió una marca)', 1, 'idMatrizEditada=1 idFila=23 idCol=1', 'x'),
(14, 2, 12, '2021-01-20 21:03:01', 'Se editó una matriz (se añadió una marca)', 1, 'idMatrizEditada=2 idFila=5 idCol=1', 'X'),
(15, 2, 13, '2021-01-20 21:48:10', 'Se editó un puesto ', 1, 'nombreAnt=Profesor', 'nombreNuevo = Profesor de trompeta'),
(16, 2, 14, '2021-01-20 21:50:26', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=4 idCol=6', 'x'),
(17, 2, 15, '2021-01-20 21:54:09', 'Se eliminó un puesto ', 1, 'nombreAnt=Tecnico de cables', ''),
(18, 2, 16, '2021-01-20 22:01:29', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = Creacion de actas'),
(19, 2, 17, '2021-01-20 22:01:59', 'Se editó un subproceso ', 1, 'anteriorNombre = Creacion de actas', ' nombre = Creacion de actas institucionales'),
(20, 2, 18, '2021-01-20 22:02:14', 'Se eliminó un subproceso ', 1, 'anteriorNombre = Creacion de actas institucionales', ''),
(21, 1, 1, '2021-01-20 22:03:56', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = asd'),
(22, 1, 2, '2021-01-20 22:04:22', 'Se editó un puesto ', 1, 'nombreAnt=Jefe de TI', 'nombreNuevo = Jefe de TI'),
(23, 1, 3, '2021-01-20 22:11:40', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=6 idCol=10', 'x'),
(24, 1, 4, '2021-01-20 22:11:53', 'Se eliminó un subproceso ', 1, 'anteriorNombre = asd', ''),
(25, 2, 19, '2021-01-21 10:51:39', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=1', 'x'),
(26, 2, 20, '2021-01-21 10:53:02', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=1', '*'),
(27, 2, 21, '2021-01-21 10:53:15', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=2 idCol=1', '*'),
(28, 2, 22, '2021-01-21 10:53:23', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=23 idCol=1', '*'),
(29, 2, 23, '2021-01-21 10:53:30', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=23 idCol=2', '*'),
(30, 2, 24, '2021-01-21 10:53:40', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=2 idCol=1', 'x'),
(31, 2, 25, '2021-01-21 11:04:24', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=2 idCol=1', '*'),
(32, 2, 26, '2021-01-21 11:04:34', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=23 idCol=1', 'x'),
(33, 2, 27, '2021-01-21 11:04:38', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=2 idCol=1', 'X'),
(34, 2, 28, '2021-01-21 11:04:44', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=1', '/'),
(35, 2, 29, '2021-01-21 11:04:53', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=24 idCol=2', 'X'),
(36, 2, 30, '2021-01-21 11:05:24', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=2 idFila=4 idCol=6', '*'),
(37, 2, 31, '2021-01-21 11:05:28', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=2 idFila=5 idCol=1', '*'),
(38, 2, 32, '2021-01-21 11:05:33', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=2 idFila=2 idCol=8', '*'),
(39, 2, 33, '2021-01-21 11:20:14', 'Se creó un area.', 1, '', 'Celulares'),
(40, 2, 34, '2021-01-21 11:20:20', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = gaaaaaaaaaaaaa'),
(41, 2, 35, '2021-01-21 11:20:22', 'Se editó un area.', 1, 'Celulares  /\\  asdsaadsdasdasdas', 'Celulares  /\\  asdsaadsdasdasdas'),
(42, 2, 36, '2021-01-21 11:21:36', 'Se eliminó un area.', 1, 'idAreaEliminada=6', ''),
(43, 2, 37, '2021-01-21 11:27:27', 'Se creó un area.', 1, '', 'heey 2'),
(44, 2, 38, '2021-01-21 11:27:33', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = puest1'),
(45, 2, 39, '2021-01-21 11:27:37', 'Se creó un puesto ', 1, 'nroEnArea=2', 'nombre = puesto2'),
(46, 2, 40, '2021-01-21 11:27:39', 'Se editó un area.', 1, 'heey 2  /\\  aaaaaaaaaaaaaaaaaaaaa', 'heey 2  /\\  aaaaaaaaaaaaaaaaaaaaa'),
(47, 2, 41, '2021-01-21 11:27:53', 'Se eliminó un area y sus puestos.', 1, 'idAreaEliminada=7', ''),
(48, 2, 42, '2021-01-21 11:29:57', 'Se borró una matriz.', 1, 'idMatrizBorrada=2         descripcion=esta es la 2 version de la matriz ahora subpr vs puests', ''),
(49, 2, 43, '2021-01-21 11:30:10', 'Se editó un proceso.', 1, 'Conduccion Presupuestal /\\ Se encarga de conducir el presupuesto y velar su cumplimiento.', 'Conduccion Presupuestal /\\ Se encarga de conducir el presupuesto y velar su cumplimiento.'),
(50, 2, 44, '2021-01-21 11:47:35', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=2', 'X'),
(51, 2, 45, '2021-01-21 11:47:39', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=2 idCol=2', 'x'),
(52, 2, 46, '2021-01-21 11:47:44', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=23 idCol=2', '/'),
(53, 2, 47, '2021-01-21 11:49:58', 'Se editó un area.', 1, 'Sonido  /\\  se encaga de sonidearse', 'Sonido  /\\  se encaga de sonidearse'),
(54, 2, 48, '2021-01-21 11:50:04', 'Se eliminó un area y sus puestos.', 1, 'idAreaEliminada=2 nombre=Sonido', ''),
(55, 2, 49, '2021-01-21 12:47:54', 'Se creó un area.', 1, '', 'Sonido'),
(56, 2, 50, '2021-01-21 12:48:01', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = sonnd1'),
(57, 2, 51, '2021-01-21 12:48:05', 'Se creó un puesto ', 1, 'nroEnArea=2', 'nombre = sondd2'),
(58, 2, 52, '2021-01-21 12:48:09', 'Se creó un puesto ', 1, 'nroEnArea=3', 'nombre = sondd33'),
(59, 2, 53, '2021-01-21 12:48:31', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=24 idCol=8', 'x'),
(60, 2, 54, '2021-01-21 12:48:35', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=8', 'X'),
(61, 2, 55, '2021-01-21 12:48:51', 'Se creó una matriz.', 1, '', 'idMatrizCreada=2 descripcion=proc vs puest prueba'),
(62, 2, 56, '2021-01-21 12:49:06', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=23 idCol=16', 'x'),
(63, 2, 57, '2021-01-21 12:49:09', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=17', 'X'),
(64, 2, 58, '2021-01-21 12:49:13', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=24 idCol=18', '/'),
(65, 2, 59, '2021-01-21 13:01:51', 'Se creó un area.', 1, '', 'prueba de borrado'),
(66, 2, 60, '2021-01-21 13:01:55', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = ed1'),
(67, 2, 61, '2021-01-21 13:01:58', 'Se creó un puesto ', 1, 'nroEnArea=2', 'nombre = ed2'),
(68, 2, 62, '2021-01-21 13:02:00', 'Se creó un puesto ', 1, 'nroEnArea=3', 'nombre = ed3'),
(69, 2, 63, '2021-01-21 13:02:21', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=23 idCol=9', 'x'),
(70, 2, 64, '2021-01-21 13:02:25', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=9', 'X'),
(71, 2, 65, '2021-01-21 13:02:38', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=24 idCol=9', '/'),
(72, 2, 66, '2021-01-21 13:02:49', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=19', 'x'),
(73, 2, 67, '2021-01-21 13:02:52', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=23 idCol=20', 'X'),
(74, 2, 68, '2021-01-21 13:03:00', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=24 idCol=21', 'X'),
(75, 2, 69, '2021-01-21 13:03:05', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=6', '/'),
(76, 2, 70, '2021-01-21 13:03:34', 'Se eliminó un area y sus puestos.', 1, 'idAreaEliminada=9 nombre=prueba de borrado', ''),
(77, 2, 71, '2021-01-21 13:13:22', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=24 idCol=1', 'x'),
(78, 2, 72, '2021-01-21 13:13:37', 'Se eliminó un proceso y sus subprocesos.', 1, 'idProcesoEliminado=24 nombre=Conduccion Presupuestal', ''),
(79, 2, 73, '2021-01-21 13:13:58', 'Se creó una matriz.', 1, '', 'idMatrizCreada=3 descripcion=SUB PASD KADS DASDAS DAS'),
(80, 2, 74, '2021-01-21 13:14:23', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=5 idCol=1', '/'),
(81, 2, 75, '2021-01-21 13:14:45', 'Se eliminó un subproceso ', 1, 'anteriorNombre = Gestion de Actas', ''),
(82, 2, 76, '2021-01-21 13:15:07', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = CONTEO DE ARCAS 2222'),
(83, 2, 77, '2021-01-21 13:15:20', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=4 idCol=1', '/'),
(84, 2, 78, '2021-01-21 13:15:24', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=11 idCol=1', '/'),
(85, 2, 79, '2021-01-21 13:15:43', 'Se eliminó un proceso y sus subprocesos.', 1, 'idProcesoEliminado=2 nombre=Contabilidad', ''),
(86, 2, 80, '2021-01-21 13:18:01', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = admin1'),
(87, 2, 81, '2021-01-21 13:18:04', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = admin2'),
(88, 2, 82, '2021-01-21 13:18:12', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=12 idCol=1', '/'),
(89, 2, 83, '2021-01-21 13:18:16', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=13 idCol=1', '/'),
(90, 2, 84, '2021-01-21 13:18:30', 'Se eliminó un proceso y sus subprocesos.', 1, 'idProcesoEliminado=23 nombre=Administracionesx', ''),
(91, 2, 85, '2021-01-21 13:20:32', 'Se creó un proceso.', 1, '', 'Administracion'),
(92, 2, 86, '2021-01-21 13:20:38', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = admin1'),
(93, 2, 87, '2021-01-21 13:20:42', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = admin2'),
(94, 2, 88, '2021-01-21 13:20:45', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 3 nombre = admin 3'),
(95, 2, 89, '2021-01-21 13:20:55', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=14 idCol=1', '/'),
(96, 2, 90, '2021-01-21 13:20:59', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=15 idCol=1', 'x'),
(97, 2, 91, '2021-01-21 13:21:02', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=16 idCol=1', 'X'),
(98, 2, 92, '2021-01-21 13:21:12', 'Se eliminó un proceso y sus subprocesos.', 1, 'idProcesoEliminado=25 nombre=Administracion', ''),
(99, 2, 93, '2021-01-21 14:41:42', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=1', 'X'),
(100, 2, 94, '2021-01-21 14:42:04', 'Se creó un proceso.', 1, '', 'Contratacion de Personal'),
(101, 2, 95, '2021-01-21 14:42:16', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=26 idCol=1', 'x'),
(102, 2, 96, '2021-01-21 14:42:40', 'Se eliminó un puesto ', 1, 'puesto eliminado = Profesor de trompeta', ''),
(103, 1, 5, '2021-01-21 14:47:39', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=6 idCol=9', '*'),
(104, 1, 6, '2021-01-21 14:47:43', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=6 idCol=10', '*'),
(105, 1, 7, '2021-01-21 14:47:57', 'Se borró una matriz.', 1, 'idMatrizBorrada=4         descripcion=ubi sub pr vs puest', ''),
(106, 2, 97, '2021-01-21 14:50:15', 'Se editó un proceso.', 3, 'Contratacion de Personal /\\ ss', 'Contratacion de Personal /\\ hey'),
(107, 2, 98, '2021-01-21 15:14:55', 'Se creó un proceso.', 3, '', 'nuevo proceso'),
(108, 2, 99, '2021-01-21 15:15:04', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=2 idFila=27 idCol=6', 'X'),
(109, 2, 100, '2021-01-21 15:43:40', 'Se creó un proceso.', 3, '', 'Otro proceso'),
(110, 2, 101, '2021-01-21 15:43:53', 'Se creó un area.', 3, '', 'Tecnologias de la informacion'),
(111, 2, 102, '2021-01-21 15:44:00', 'Se creó un area.', 3, '', 'Logística'),
(112, 2, 103, '2021-01-21 15:44:11', 'Se creó un area.', 3, '', 'Soporte tecnico'),
(113, 2, 104, '2021-01-21 15:44:21', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=28 idCol=10', 'x'),
(114, 2, 105, '2021-01-21 16:25:43', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=26 idCol=10', '/'),
(115, 2, 106, '2021-01-21 16:25:48', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=1 idCol=10', 'X'),
(116, 2, 107, '2021-01-21 16:25:52', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=27 idCol=11', 'x'),
(117, 2, 108, '2021-01-21 18:32:39', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=26 idCol=11', '/'),
(118, 2, 109, '2021-01-21 18:32:44', 'Se editó una matriz (se añadió una marca)', 3, 'nroMatrizEmpresa=1 idFila=1 idCol=12', 'X'),
(119, 2, 110, '2021-01-21 18:41:03', 'Se editó una matriz (se borró una marca)', 3, 'nroMatrizEmpresa=1 idFila=26 idCol=11', '*'),
(120, 2, 111, '2021-01-21 18:41:10', 'Se editó una matriz (se borró una marca)', 3, 'nroMatrizEmpresa=1 idFila=1 idCol=10', '*'),
(121, 1, 8, '2021-01-22 10:16:50', 'Se creó una matriz.', 1, '', 'idMatrizCreada=1 descripcion=Primera matriz'),
(122, 1, 9, '2021-01-22 10:49:14', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=22 idCol=4', 'X'),
(123, 1, 10, '2021-01-22 10:49:19', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=21 idCol=5', '/'),
(124, 1, 11, '2021-01-22 10:49:23', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=21 idCol=4', 'x'),
(125, 2, 112, '2021-01-22 11:48:56', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = Lanzamiento de convocatoria'),
(126, 2, 113, '2021-01-22 11:49:03', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = Seleccion de Curriculos'),
(127, 2, 114, '2021-01-22 11:49:18', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 3 nombre = Entrevista personal'),
(128, 2, 115, '2021-01-22 11:49:39', 'Se editó un proceso.', 1, 'Contratacion de Personal /\\ hey', 'Contratacion de Personal /\\ Proceso encargado de contratar al personal necesario para los proyectos.'),
(129, 2, 116, '2021-01-22 11:55:02', 'Se creó un puesto ', 1, 'nroEnArea=3', 'nombre = Profesor nombrado'),
(130, 2, 117, '2021-01-22 11:55:07', 'Se editó un puesto ', 1, 'nombreAnt=Director Principal 2', 'nombreNuevo = Director Principal'),
(131, 2, 118, '2021-01-22 13:27:54', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 3 nombre = Registro de entradas'),
(132, 2, 119, '2021-01-22 13:30:06', 'Se editó un proceso.', 1, 'nuevo proceso /\\ hey', 'Planeamiento estratégico /\\ proceso sistemático de desarrollo e implementación de planes para alcanzar propósitos u objetivos'),
(133, 2, 120, '2021-01-22 13:30:19', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = Desarrollo Conceptual'),
(134, 2, 121, '2021-01-22 13:30:31', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = Gestión de sistemas de planificación'),
(135, 2, 122, '2021-01-22 13:30:44', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 3 nombre = Gestión de financiamiento'),
(136, 2, 123, '2021-01-22 13:31:20', 'Se editó un proceso.', 1, 'Otro proceso /\\ adsdas das dsa dsa', 'Creacion de nuevos servicios /\\ Proceso encargado de crear los servicios que se ofertarán.'),
(137, 2, 124, '2021-01-22 13:31:31', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 1 nombre = Identificación de necesidades'),
(138, 2, 125, '2021-01-22 13:31:37', 'Se creó un subproceso ', 1, '', 'nroEnProceso = 2 nombre = Diseño de estrategias de intervencion'),
(139, 2, 126, '2021-01-22 13:32:11', 'Se editó un area.', 1, 'Soporte tecnico  /\\  daw dwa terjjersjyjs sy y y', 'Soporte tecnico  /\\  Área encargada de brindar soporte a las demás áreas.'),
(140, 2, 127, '2021-01-22 13:32:22', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = Informático'),
(141, 2, 128, '2021-01-22 13:32:26', 'Se creó un puesto ', 1, 'nroEnArea=2', 'nombre = Técnico'),
(142, 2, 129, '2021-01-22 13:32:55', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = Jefe de logistica'),
(143, 2, 130, '2021-01-22 13:33:11', 'Se editó un area.', 1, 'Logística  /\\  adsa dsdsa', 'Logística  /\\  Se encarga de gestionar las compras de insumos.'),
(144, 2, 131, '2021-01-22 13:33:29', 'Se eliminó un area y sus puestos.', 1, 'idAreaEliminada=1 nombre=Gestion Academica', ''),
(145, 2, 132, '2021-01-22 13:34:30', 'Se editó un area.', 1, 'Tecnologias de la informacion  /\\  ads das dsa dsa dsa', 'Tecnologias de la informacion  /\\  Se encarga de administrar las tecnologías usadas por la empresa.'),
(146, 2, 133, '2021-01-22 13:34:37', 'Se creó un puesto ', 1, 'nroEnArea=1', 'nombre = Jefe de TI'),
(147, 2, 134, '2021-01-22 13:34:42', 'Se creó un puesto ', 1, 'nroEnArea=2', 'nombre = Asistente de TI'),
(148, 2, 135, '2021-01-22 13:34:49', 'Se creó un puesto ', 1, 'nroEnArea=3', 'nombre = Practicante de sistemas'),
(149, 2, 136, '2021-01-22 13:34:52', 'Se editó un area.', 1, 'Tecnologias de la informacion  /\\  Se encarga de administrar las tecnologías usadas por la empresa.', 'Tecnologias de la informacion  /\\  Se encarga de administrar las tecnologías usadas por la empresa.'),
(150, 2, 137, '2021-01-22 13:35:03', 'Se borró una matriz.', 1, 'idMatrizBorrada=7         descripcion=SUB PASD KADS DASDAS DAS', ''),
(151, 2, 138, '2021-01-22 13:35:31', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=24', '/'),
(152, 2, 139, '2021-01-22 13:35:36', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=1 idCol=25', 'X'),
(153, 2, 140, '2021-01-22 13:35:39', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=27 idCol=26', 'x'),
(154, 2, 141, '2021-01-22 13:35:42', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=2 idFila=28 idCol=27', 'x'),
(155, 2, 142, '2021-01-22 13:38:53', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=11', '*'),
(156, 2, 143, '2021-01-22 13:39:30', 'Se creó una matriz.', 1, '', 'idMatrizCreada=3 descripcion=Primera edición para subprocesos vs Puestos'),
(157, 2, 144, '2021-01-22 13:39:44', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=20 idCol=24', 'x'),
(158, 2, 145, '2021-01-22 13:39:48', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=24 idCol=25', '/'),
(159, 2, 146, '2021-01-22 13:39:52', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=2 idCol=23', 'X'),
(160, 2, 147, '2021-01-22 13:39:57', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=25 idCol=27', 'x'),
(161, 2, 148, '2021-01-22 14:46:14', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=10', 'Se creó x con Gestion de Almacenes'),
(162, 2, 149, '2021-01-22 14:48:21', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=11', 'Se creó X con la fila Gestion de Almacenes y columna Logística'),
(163, 2, 150, '2021-01-22 14:49:05', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=26 idCol=10', 'Se creó * con la fila Contratacion de Personal y columna Tecnologias de la informacion'),
(164, 2, 151, '2021-01-22 14:49:53', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=18 idCol=23', 'Se creó X con la fila Seleccion de Curriculos y columna Gestión de financiamiento'),
(165, 2, 152, '2021-01-22 14:51:01', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=23 idCol=24', 'Se creó x con la fila  y columna '),
(166, 2, 153, '2021-01-22 14:51:55', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=3 idFila=17 idCol=25', 'Se creó x con la fila Lanzamiento de convocatoria y columna Jefe de logistica'),
(167, 2, 154, '2021-01-22 14:52:13', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=12', 'Se creó x con la fila Planeamiento estratégico y columna Soporte tecnico'),
(168, 2, 155, '2021-01-22 15:12:36', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=12', 'Se creó * con la fila Gestion de Almacenes y columna Soporte tecnico'),
(169, 2, 156, '2021-01-22 15:13:49', 'Se creó un area.', 1, '', 'Recursos Humanos'),
(170, 2, 157, '2021-01-22 15:14:16', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=12', 'Se creó * con la fila Planeamiento estratégico y columna Soporte tecnico'),
(171, 2, 158, '2021-01-22 15:14:24', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=1 idCol=10', 'Se creó * con la fila Gestion de Almacenes y columna Tecnologias de la informacion'),
(172, 2, 159, '2021-01-22 15:14:30', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=26 idCol=13', 'Se creó X con la fila Contratacion de Personal y columna Recursos Humanos'),
(173, 2, 160, '2021-01-22 15:14:42', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=10', 'Se creó / con la fila Planeamiento estratégico y columna Tecnologias de la informacion'),
(174, 2, 161, '2021-01-22 15:38:39', 'Se editó una matriz (se añadió una marca)', 4, 'nroMatrizEmpresa=1 idFila=26 idCol=10', 'Se creó x con la fila Contratacion de Personal y columna Tecnologias de la informacion'),
(175, 2, 162, '2021-01-22 15:38:43', 'Se editó una matriz (se añadió una marca)', 4, 'nroMatrizEmpresa=1 idFila=27 idCol=11', 'Se creó X con la fila Planeamiento estratégico y columna Logística'),
(176, 2, 163, '2021-01-22 15:39:46', 'Se eliminó un proceso y sus subprocesos.', 4, 'idProcesoEliminado=1 nombre=Gestion de Almacenes', ''),
(177, 2, 164, '2021-01-23 10:12:12', 'Se editó una matriz (se borró una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=11', 'Se creó * con la fila Planeamiento estratégico y columna Logística'),
(178, 2, 165, '2021-01-23 10:12:16', 'Se editó una matriz (se añadió una marca)', 1, 'nroMatrizEmpresa=1 idFila=27 idCol=12', 'Se creó x con la fila Planeamiento estratégico y columna Soporte tecnico'),
(179, 2, 166, '2021-01-23 10:12:31', 'Se editó un proceso.', 1, 'Contratacion de Personal /\\ Proceso encargado de contratar al personal necesario para los proyectos.', 'Contratacion de Personal /\\ Proceso encargado de contratar al personal necesario para los proyectos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celdamatriz`
--

CREATE TABLE `celdamatriz` (
  `idCelda` int(11) NOT NULL,
  `idFila` int(11) NOT NULL,
  `idColumna` int(11) NOT NULL,
  `idMatriz` int(11) NOT NULL,
  `contenido` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `celdamatriz`
--

INSERT INTO `celdamatriz` (`idCelda`, `idFila`, `idColumna`, `idMatriz`, `contenido`) VALUES
(87, 28, 10, 1, 'x'),
(93, 22, 4, 8, 'X'),
(94, 21, 5, 8, '/'),
(95, 21, 4, 8, 'x'),
(98, 27, 26, 6, 'x'),
(99, 28, 27, 6, 'x'),
(101, 24, 25, 9, '/'),
(103, 25, 27, 9, 'x'),
(106, 18, 23, 9, 'X'),
(107, 23, 24, 9, 'x'),
(108, 17, 25, 9, 'x'),
(110, 26, 13, 1, 'X'),
(111, 27, 10, 1, '/'),
(112, 26, 10, 1, 'x'),
(114, 27, 12, 1, 'x');

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
(1, 'Ubisoft', '1234567891231', 'Los corales 18258 asl dlas  2195  LT2XXXXXXXXX', 'mision de buausd a dsja sjjsa', 'd asdsabdsbads da sdasbdsadsabasdbas', 'asdda ssa asas a sddas as asadbabd dsadsabsbaddbdas', 'adasdab dasbadsdsasdsadsadb sadasdadxxxxx', 1),
(2, 'Cedepas Norte SAC', '2581474571591', 'Callecristal 362 interior A5', 'Organizar la información de mundo y hacerla accesible a todos', 'Organizar la información de mundo y hacerla accesible a todos', 'a', 'a', 1),
(3, 'Coca Cola', '2581473691591', 'Callecristal 362 interior A5', 'AASDSA SA  SS', 'AS XA XA xxxxxxxxxxxxxxxxxx', 'ADWWAT AWT AWWT', 'ATW TWA ATW', 1),
(4, 'Vigosoft', '2581474571591', 'Estados Unidos -> laravella', 'asdadsdasasd dasdas dasads jmtymty my fyum', 'asd dasdas dasads jmtymty my fyu', 'asd dasdas dasads jmtymty my fyu', 'asd dasdas dasads jmtymty my fyu', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresausuario`
--

CREATE TABLE `empresausuario` (
  `idUsuario` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idAI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresausuario`
--

INSERT INTO `empresausuario` (`idUsuario`, `idEmpresa`, `idAI`) VALUES
(2, 1, 36),
(2, 3, 37),
(2, 4, 38),
(3, 2, 39),
(3, 4, 40),
(1, 1, 41),
(1, 2, 42),
(1, 3, 43),
(1, 4, 44),
(4, 2, 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matrizprocorg`
--

CREATE TABLE `matrizprocorg` (
  `idMatriz` int(11) NOT NULL,
  `nroEnEmpresa` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `tipoDeMatriz` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `matrizprocorg`
--

INSERT INTO `matrizprocorg` (`idMatriz`, `nroEnEmpresa`, `idEmpresa`, `tipoDeMatriz`, `descripcion`) VALUES
(1, 1, 2, 1, 'Primera version de la matriz'),
(6, 2, 2, 2, 'proc vs puest prueba'),
(8, 1, 1, 1, 'Primera matriz'),
(9, 3, 2, 4, 'Primera edición para subprocesos vs Puestos');

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
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `idProceso` int(11) NOT NULL,
  `nroEnEmpresa` int(11) NOT NULL,
  `descripcionProceso` varchar(200) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `nombreProceso` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proceso`
--

INSERT INTO `proceso` (`idProceso`, `nroEnEmpresa`, `descripcionProceso`, `idEmpresa`, `nombreProceso`) VALUES
(21, 1, 'Esta area se encarga de gestionar todos los activos y pasivos de la empresa', 1, 'Gestion de Recursos'),
(22, 2, 'Proceso encargado de remunerar', 1, 'Contratacion de Personal'),
(26, 2, 'Proceso encargado de contratar al personal necesario para los proyectos', 2, 'Contratacion de Personal'),
(27, 3, 'proceso sistemático de desarrollo e implementación de planes para alcanzar propósitos u objetivos', 2, 'Planeamiento estratégico'),
(28, 4, 'Proceso encargado de crear los servicios que se ofertarán.', 2, 'Creacion de nuevos servicios');

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
-- Estructura de tabla para la tabla `subproceso`
--

CREATE TABLE `subproceso` (
  `idSubproceso` int(11) NOT NULL,
  `nroEnProceso` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `idProceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subproceso`
--

INSERT INTO `subproceso` (`idSubproceso`, `nroEnProceso`, `nombre`, `idProceso`) VALUES
(6, 1, 'Gestion de Recursos humanos', 21),
(7, 2, 'Gestion de existencias', 21),
(8, 3, 'Creacion del inventario', 21),
(17, 1, 'Lanzamiento de convocatoria', 26),
(18, 2, 'Seleccion de Curriculos', 26),
(19, 3, 'Entrevista personal', 26),
(21, 1, 'Desarrollo Conceptual', 27),
(22, 2, 'Gestión de sistemas de planificación', 27),
(23, 3, 'Gestión de financiamiento', 27),
(24, 1, 'Identificación de necesidades', 28),
(25, 2, 'Diseño de estrategias de intervencion', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `DNI` varchar(11) NOT NULL,
  `estadoAct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `name`, `email`, `password`, `nombres`, `apellidos`, `DNI`, `estadoAct`) VALUES
(1, 'admin', 'degolego2000@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Diego Ernesto', 'Vigo Briones', '71208489', 1),
(2, 'vigocraft', 'efranco@unitru.edu.pe', '$2y$10$rI4Fkv2HLnYaD6aqtKbwBuPvWPDNwRMo/aCgDFELNvwHVcjKu0lOe', 'Isaac Juan', 'Diaz Valdez', '24425856', 1),
(3, 'grillo', 'hola.aguaflorida@gmail.com', '$2y$10$3mqgx5t1VCgUS43rU415yOD5fcZmB53035cLgioF0EjkFaxWMc5Li', 'Juan Julio', 'Diaz Valdez', '12341234', 1),
(4, 'kari', 'si.eis.ar.ro@gmail.com', '$2y$10$3cLZug88mHJpeHdBZrioGuS2sQini2/EZGB3t.dlmg4OQCEwHCYR.', 'Juan Ernesto', 'Maximo Rodriguez', '42244646', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idArea`);

--
-- Indices de la tabla `cambioedicion`
--
ALTER TABLE `cambioedicion`
  ADD PRIMARY KEY (`idCambio`);

--
-- Indices de la tabla `celdamatriz`
--
ALTER TABLE `celdamatriz`
  ADD PRIMARY KEY (`idCelda`);

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
-- Indices de la tabla `matrizprocorg`
--
ALTER TABLE `matrizprocorg`
  ADD PRIMARY KEY (`idMatriz`);

--
-- Indices de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  ADD PRIMARY KEY (`idObjetivoEst`);

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
-- Indices de la tabla `subproceso`
--
ALTER TABLE `subproceso`
  ADD PRIMARY KEY (`idSubproceso`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cambioedicion`
--
ALTER TABLE `cambioedicion`
  MODIFY `idCambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de la tabla `celdamatriz`
--
ALTER TABLE `celdamatriz`
  MODIFY `idCelda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresausuario`
--
ALTER TABLE `empresausuario`
  MODIFY `idAI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `matrizprocorg`
--
ALTER TABLE `matrizprocorg`
  MODIFY `idMatriz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `objetivo`
--
ALTER TABLE `objetivo`
  MODIFY `idObjetivoEst` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `idProceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `idPuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `subproceso`
--
ALTER TABLE `subproceso`
  MODIFY `idSubproceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
