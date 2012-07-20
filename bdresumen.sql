-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2012 at 04:41 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bdresumen`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblareas`
--

CREATE TABLE IF NOT EXISTS `tblareas` (
  `idArea` int(11) NOT NULL AUTO_INCREMENT,
  `nombreArea` varchar(50) NOT NULL,
  PRIMARY KEY (`idArea`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblareas`
--

INSERT INTO `tblareas` (`idArea`, `nombreArea`) VALUES
(1, 'EducaciÃ³n'),
(2, 'Gerencia');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategoria`
--

CREATE TABLE IF NOT EXISTS `tblcategoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `codigoCategoria` varchar(10) NOT NULL,
  `nombreCategoria` varchar(75) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblcategoria`
--

INSERT INTO `tblcategoria` (`idCategoria`, `codigoCategoria`, `nombreCategoria`) VALUES
(4, 'UVME', 'ESPECIALIZACIONES'),
(5, 'UVMM', 'MAESTRIAS');

-- --------------------------------------------------------

--
-- Table structure for table `tblcat_area`
--

CREATE TABLE IF NOT EXISTS `tblcat_area` (
  `idCat_area` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoria` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  PRIMARY KEY (`idCat_area`),
  KEY `idCategoria` (`idCategoria`,`idArea`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tblcat_area`
--

INSERT INTO `tblcat_area` (`idCat_area`, `idCategoria`, `idArea`) VALUES
(9, 4, 1),
(11, 5, 1),
(10, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblconfiguraciones`
--

CREATE TABLE IF NOT EXISTS `tblconfiguraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dias_actConfiguraciones` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblconfiguraciones`
--

INSERT INTO `tblconfiguraciones` (`id`, `dias_actConfiguraciones`) VALUES
(1, 90);

-- --------------------------------------------------------

--
-- Table structure for table `tblpermisos`
--

CREATE TABLE IF NOT EXISTS `tblpermisos` (
  `idPermisos` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `modUsuario` varchar(1) NOT NULL,
  `agregarUsuario` varchar(1) NOT NULL,
  `modificarUsuario` varchar(1) NOT NULL,
  `eliminarUsuario` varchar(1) NOT NULL,
  `modTutores` varchar(1) NOT NULL,
  `agregarTutores` varchar(1) NOT NULL,
  `modificarTutores` varchar(1) NOT NULL,
  `eliminarTutores` varchar(1) NOT NULL,
  `modCategorias` varchar(1) NOT NULL,
  `agregarCategorias` varchar(1) NOT NULL,
  `modificarCategorias` varchar(1) NOT NULL,
  `eliminarCategorias` varchar(1) NOT NULL,
  `modSubcategorias` varchar(1) NOT NULL,
  `agregarSubcategorias` varchar(1) NOT NULL,
  `modificarSubcategorias` varchar(1) NOT NULL,
  `eliminarSubcategorias` varchar(1) NOT NULL,
  `modResumen` varchar(1) NOT NULL,
  `agregarResumen` varchar(1) NOT NULL,
  `modificarResumen` varchar(1) NOT NULL,
  `eliminarResumen` varchar(1) NOT NULL,
  `modUbicaciones` varchar(1) NOT NULL,
  `agregarUbicaciones` varchar(1) NOT NULL,
  `modificarUbicaciones` varchar(1) NOT NULL,
  `eliminarUbicaciones` varchar(1) NOT NULL,
  `modArea` varchar(1) NOT NULL DEFAULT 'N',
  `agregarArea` varchar(1) NOT NULL DEFAULT 'N',
  `modificarArea` varchar(1) NOT NULL DEFAULT 'N',
  `eliminarArea` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idPermisos`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tblpermisos`
--

INSERT INTO `tblpermisos` (`idPermisos`, `idUsuario`, `modUsuario`, `agregarUsuario`, `modificarUsuario`, `eliminarUsuario`, `modTutores`, `agregarTutores`, `modificarTutores`, `eliminarTutores`, `modCategorias`, `agregarCategorias`, `modificarCategorias`, `eliminarCategorias`, `modSubcategorias`, `agregarSubcategorias`, `modificarSubcategorias`, `eliminarSubcategorias`, `modResumen`, `agregarResumen`, `modificarResumen`, `eliminarResumen`, `modUbicaciones`, `agregarUbicaciones`, `modificarUbicaciones`, `eliminarUbicaciones`, `modArea`, `agregarArea`, `modificarArea`, `eliminarArea`) VALUES
(1, 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(5, 11, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tblresumen`
--

CREATE TABLE IF NOT EXISTS `tblresumen` (
  `idResumen` int(11) NOT NULL AUTO_INCREMENT,
  `codigoResumen` varchar(10) NOT NULL,
  `anoResumen` varchar(12) NOT NULL,
  `idUbicacion` int(11) NOT NULL,
  `tituloResumen` varchar(255) NOT NULL,
  `textoResumen` text NOT NULL,
  `archivoResumen` varchar(100) NOT NULL,
  `autoresResumen` varchar(250) NOT NULL,
  `idCategoria` int(11) NOT NULL DEFAULT '1',
  `idSubcategoria` int(11) NOT NULL,
  `idTutor` int(11) NOT NULL,
  `fechaResumen` date NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idResumen`),
  KEY `idUbicacion` (`idUbicacion`,`idSubcategoria`,`idTutor`),
  KEY `idCategoria` (`idCategoria`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tblresumen`
--

INSERT INTO `tblresumen` (`idResumen`, `codigoResumen`, `anoResumen`, `idUbicacion`, `tituloResumen`, `textoResumen`, `archivoResumen`, `autoresResumen`, `idCategoria`, `idSubcategoria`, `idTutor`, `fechaResumen`, `idUsuario`) VALUES
(21, 'EGI-1', '2002', 3, 'Actividades', 'JHAS GDASHJGD JASGD JASGJDGAS', '2.pdf', 'kjhsd kfjh sdkjfh skjhf kjsd', 4, 5, 14, '2012-07-13', 1),
(22, 'EGI-22', '2012', 3, 'TÃ­tulo', '<p>\r\nSed interdum tincidunt metus, vitae sodales nibh ultrices in. Phasellus \r\nadipiscing eros id elit bibendum ornare. Ut sed nisl sit amet lectus \r\nmattis tempor. Nulla dictum urna sed arcu imperdiet placerat. Integer \r\negestas velit quis libero luctus feugiat. Praesent eu nisl risus, ut \r\nadipiscing risus. Morbi tortor quam, rutrum sit amet placerat eget, \r\ndictum id mi. Donec in sapien fermentum dolor scelerisque pharetra. \r\nVivamus urna nunc, porttitor sit amet gravida et, venenatis a odio. \r\nEtiam placerat mollis mi dictum posuere.\r\n</p>\r\n<p>\r\nAenean eu sapien ante. Suspendisse a nisi sit amet sapien feugiat \r\naliquam. Nulla urna quam, mattis vel bibendum feugiat, pellentesque id \r\nmagna. Sed eu arcu felis, eget porttitor felis. Donec dapibus est a enim\r\n facilisis dapibus. Nunc condimentum, mauris id bibendum condimentum, \r\nrisus augue scelerisque dolor, viverra consectetur quam enim non magna. \r\nSed vel est augue. Nulla aliquam tellus at velit fermentum suscipit. \r\nProin pellentesque mollis mi, ultricies pharetra arcu lobortis ac. \r\nAenean bibendum risus mi, nec ullamcorper risus. Proin porttitor sapien \r\nin lacus porta hendrerit. In hac habitasse platea dictumst. Suspendisse \r\npotenti. Suspendisse posuere metus eu dolor tempus placerat.\r\n</p>', 'GP-P24.pdf', 'Johnmer Bencomo', 4, 5, 14, '2012-07-15', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategorias`
--

CREATE TABLE IF NOT EXISTS `tblsubcategorias` (
  `idSubcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `codigoSubcategoria` varchar(10) NOT NULL,
  `nombreSubcategoria` varchar(75) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  PRIMARY KEY (`idSubcategoria`),
  KEY `idCategoria` (`idCategoria`),
  KEY `idArea` (`idArea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tblsubcategorias`
--

INSERT INTO `tblsubcategorias` (`idSubcategoria`, `codigoSubcategoria`, `nombreSubcategoria`, `idCategoria`, `idArea`) VALUES
(5, 'EGI', 'GERENCIA DE INVESTIGACIÃ“N', 4, 1),
(6, 'EGP', 'GERENCIA PUBLICA', 4, 1),
(7, 'EGM', 'GERENCIA DE MERCADEO', 4, 1),
(8, 'EGE', 'GERENCIA DE EMPRESAS', 4, 1),
(9, 'EGT', 'GERENCIA DE LA TECNOLOGIA DE LA INFORMACION', 5, 2),
(10, 'MAE', 'MAGISTER SCIENTIAURUM EN ADMINISTRACION DE EMPRESAS', 5, 1),
(11, 'EDE', 'DOCENCIA PARA LA EDUCACIÃ“N BÃSICA', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbltutores`
--

CREATE TABLE IF NOT EXISTS `tbltutores` (
  `idTutor` int(11) NOT NULL AUTO_INCREMENT,
  `cedulaTutor` varchar(12) NOT NULL,
  `nombreTutor` varchar(75) NOT NULL,
  `apellidoTutor` varchar(75) NOT NULL,
  `profesionTutor` varchar(75) NOT NULL,
  `postgradoTutor` varchar(100) DEFAULT NULL,
  `telfTutor` varchar(75) NOT NULL,
  `emailTutor` varchar(75) NOT NULL,
  `statusTutor` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idTutor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbltutores`
--

INSERT INTO `tbltutores` (`idTutor`, `cedulaTutor`, `nombreTutor`, `apellidoTutor`, `profesionTutor`, `postgradoTutor`, `telfTutor`, `emailTutor`, `statusTutor`) VALUES
(14, 'V-12540703', 'CLARIBEL', 'SILVA', 'ING EN COMPUTACION', 'ESPC. EN GERENCIA EN TECNOLOGIA DE LA INFORMACIÃ“N', '04247281953', 'silvac@uvm.edu.ve', 'A'),
(15, 'V-14460452', 'Johnmer', 'Bencomo', 'hgfhg', 'hgfjtfg', '04263714718', 'bjohnmer@gmail.com', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tblubicaciones`
--

CREATE TABLE IF NOT EXISTS `tblubicaciones` (
  `idUbicacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUbicacion` text NOT NULL,
  PRIMARY KEY (`idUbicacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tblubicaciones`
--

INSERT INTO `tblubicaciones` (`idUbicacion`, `nombreUbicacion`) VALUES
(3, 'Quinta Las Palmas');

-- --------------------------------------------------------

--
-- Table structure for table `tblusuario`
--

CREATE TABLE IF NOT EXISTS `tblusuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(75) NOT NULL,
  `apellidoUsuario` varchar(75) NOT NULL,
  `loginUsuario` varchar(20) NOT NULL,
  `claveUsuario` varchar(50) NOT NULL,
  `cedulaUsuario` varchar(25) NOT NULL,
  `statusUsuario` varchar(1) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tblusuario`
--

INSERT INTO `tblusuario` (`idUsuario`, `nombreUsuario`, `apellidoUsuario`, `loginUsuario`, `claveUsuario`, `cedulaUsuario`, `statusUsuario`) VALUES
(1, 'Administrador', 'Administrador', 'admin', '202cb962ac59075b964b07152d234b70', '1', 'A'),
(11, 'Johnmer', 'Bencomo', 'bjohnmer', '202cb962ac59075b964b07152d234b70', 'V-14460452', 'A');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
