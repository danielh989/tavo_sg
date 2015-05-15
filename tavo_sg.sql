/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50543
Source Host           : 127.0.0.1:3306
Source Database       : tavo_sg

Target Server Type    : MYSQL
Target Server Version : 50543
File Encoding         : 65001

Date: 2015-05-15 12:05:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for cuentas
-- ----------------------------
DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `total_pagar` double(7,2) DEFAULT NULL,
  `efectivo` double(7,2) DEFAULT NULL,
  `debito` double(7,2) DEFAULT NULL,
  `total_devuelto` double(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for mesas
-- ----------------------------
DROP TABLE IF EXISTS `mesas`;
CREATE TABLE `mesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`) USING BTREE,
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_mesa` int(11) DEFAULT NULL,
  `descuento` int(11) DEFAULT NULL,
  `estado` enum('Activo','Cerrado') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mesa` (`id_mesa`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` double(7,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for productosXpedido
-- ----------------------------
DROP TABLE IF EXISTS `productosXpedido`;
CREATE TABLE `productosXpedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `devuelto` enum('Si') COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` double(7,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `productosXpedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `productosXpedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for varios
-- ----------------------------
DROP TABLE IF EXISTS `varios`;
CREATE TABLE `varios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Procedure structure for cerrar_pedido
-- ----------------------------
DROP PROCEDURE IF EXISTS `cerrar_pedido`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `cerrar_pedido`(IN `id_pedido_in` int,IN `efectivo` double,IN `debito` double)
BEGIN
	
DECLARE total_sum, descuento_porc, descuento_calc, total, total_dev  DOUBLE;

set descuento_porc = (select descuento from pedidos where id=id_pedido_in);


if ISNULL(descuento_porc) then set descuento_porc=0;

end if;



set total_sum = (select sum(precio) from productosXpedido where id_pedido=id_pedido_in and devuelto IS NULL);
set total_dev = (select sum(precio) from productosXpedido where id_pedido=id_pedido_in and devuelto = 'Si');


set descuento_calc = total_sum*(descuento_porc/100);


set total = total_sum - descuento_calc;

insert into cuentas (id_pedido, total_pagar,efectivo,debito,total_devuelto) VALUES(id_pedido_in, total,efectivo,debito,total_dev);

UPDATE pedidos SET estado='Cerrado' WHERE id=id_pedido_in;



END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for insertar_producto_pedido
-- ----------------------------
DROP PROCEDURE IF EXISTS `insertar_producto_pedido`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_producto_pedido`(IN `id_pedido` int,`id_producto` int)
BEGIN
	
DECLARE precio_copia DOUBLE;


set precio_copia = (select precio from productos where id=id_producto);

insert into productosXpedido (id_pedido, id_producto, precio) VALUES(id_pedido, id_producto, precio_copia);

END
;;
DELIMITER ;
