-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `eTicket`;

DROP TABLE IF EXISTS `comprobante`;
CREATE TABLE `comprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `punto_venta` char(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_factura` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CAE` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `vencimiento` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'draft',
  `concepto` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_documento` char(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero_documento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `importe_gravado` double(10,2) DEFAULT NULL,
  `importe_exento_iva` double(10,2) DEFAULT NULL,
  `importe_iva` int(20) DEFAULT NULL,
  `cuit` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `comprobante` (`id`, `punto_venta`, `tipo_factura`, `CAE`, `vencimiento`, `concepto`, `tipo_documento`, `numero_documento`, `importe_gravado`, `importe_exento_iva`, `importe_iva`, `cuit`) VALUES
(1,	NULL,	NULL,	'70062817567362',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	NULL,	NULL,	'70062817567362',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	NULL,	NULL,	'70062817567362',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(4,	NULL,	NULL,	'70062817567362',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(5,	NULL,	NULL,	'70062817812664',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(6,	'1',	NULL,	'70062817830095',	'2020-02-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(7,	'1',	'6',	'70062818070157',	'1997',	'1',	'99',	'0',	100.00,	0.00,	21,	'20230173932');

INSERT INTO `posts` (`id`, `title`, `status`, `content`, `user_id`) VALUES
(1,	'titulo',	'draft',	'este es el contenido',	1),
(2,	'Titulo',	'draft',	'Este es el contenido',	1);

-- 2020-02-11 16:35:16
