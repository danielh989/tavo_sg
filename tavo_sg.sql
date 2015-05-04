/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50543
Source Host           : 127.0.0.1:3306
Source Database       : tavo_sg

Target Server Type    : MYSQL
Target Server Version : 50543
File Encoding         : 65001

Date: 2015-05-04 18:49:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES ('1', 'Tacos y Patacones');
INSERT INTO `categorias` VALUES ('2', 'Hamburguesas');
INSERT INTO `categorias` VALUES ('3', 'Ensaladas');
INSERT INTO `categorias` VALUES ('4', 'Parrillas');
INSERT INTO `categorias` VALUES ('5', 'Sandwiches');
INSERT INTO `categorias` VALUES ('6', 'Bebidas');
INSERT INTO `categorias` VALUES ('7', 'Special Grill');
INSERT INTO `categorias` VALUES ('8', 'Extras');

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
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cuentas
-- ----------------------------
INSERT INTO `cuentas` VALUES ('4', '31', '1000.00', '500.00', '500.00');
INSERT INTO `cuentas` VALUES ('5', '32', '600.00', '300.00', '300.00');
INSERT INTO `cuentas` VALUES ('6', '33', null, '0.00', '0.00');
INSERT INTO `cuentas` VALUES ('7', '34', null, '0.00', '0.00');

-- ----------------------------
-- Table structure for mesas
-- ----------------------------
DROP TABLE IF EXISTS `mesas`;
CREATE TABLE `mesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of mesas
-- ----------------------------
INSERT INTO `mesas` VALUES ('1', '1', 'Redonda 1');
INSERT INTO `mesas` VALUES ('2', '2', 'Redonda 2');
INSERT INTO `mesas` VALUES ('3', '3', 'Redonda 3');
INSERT INTO `mesas` VALUES ('4', '4', 'Redonda 4');
INSERT INTO `mesas` VALUES ('5', '5', 'Redonda 5');
INSERT INTO `mesas` VALUES ('6', '6', 'Redonda 6');
INSERT INTO `mesas` VALUES ('7', '7', 'Cuadrada 1');
INSERT INTO `mesas` VALUES ('8', '8', 'Cuadrada 2');
INSERT INTO `mesas` VALUES ('9', '9', 'Cuadrada 3');
INSERT INTO `mesas` VALUES ('10', '10', 'Cuadrada 4');
INSERT INTO `mesas` VALUES ('11', '11', 'Barra 1');
INSERT INTO `mesas` VALUES ('12', '12', 'Barra 2');
INSERT INTO `mesas` VALUES ('13', '13', 'Mesa Grande');

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_mesa` int(11) DEFAULT NULL,
  `para_llevar` enum('Si') COLLATE utf8_spanish_ci DEFAULT NULL,
  `descuento` int(11) DEFAULT NULL,
  `estado` enum('Activo','Cerrado') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mesa` (`id_mesa`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of pedidos
-- ----------------------------
INSERT INTO `pedidos` VALUES ('31', '2015-04-30 21:52:22', '5', null, null, 'Cerrado');
INSERT INTO `pedidos` VALUES ('32', '2015-04-30 22:04:55', '1', null, null, 'Cerrado');
INSERT INTO `pedidos` VALUES ('33', '2015-05-02 15:15:57', '1', null, null, 'Cerrado');
INSERT INTO `pedidos` VALUES ('34', '2015-05-02 15:18:04', '1', null, null, 'Cerrado');
INSERT INTO `pedidos` VALUES ('35', '2015-05-02 16:16:56', '1', null, null, 'Activo');
INSERT INTO `pedidos` VALUES ('36', '2015-05-04 15:57:09', '3', null, null, 'Activo');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', '1', 'Patacon', 'Patacon de Carne o Pollo', '200.00');
INSERT INTO `productos` VALUES ('2', '2', 'Baby Grill', 'Hamburguesa Sencilla ', '200.00');
INSERT INTO `productos` VALUES ('3', '8', 'Jamon/Tocineta', 'Extra para cualquier comida', '70.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of productosXpedido
-- ----------------------------
INSERT INTO `productosXpedido` VALUES ('66', '31', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('67', '31', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('68', '31', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('69', '31', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('70', '31', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('71', '32', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('72', '32', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('73', '32', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('83', '35', '2', 'Si', '200.00');
INSERT INTO `productosXpedido` VALUES ('84', '36', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('85', '36', '2', null, '200.00');
INSERT INTO `productosXpedido` VALUES ('86', '36', '2', null, '200.00');

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
-- Records of varios
-- ----------------------------
INSERT INTO `varios` VALUES ('1', 'Descuento Familiar', '10');

-- ----------------------------
-- Procedure structure for cerrar_pedido
-- ----------------------------
DROP PROCEDURE IF EXISTS `cerrar_pedido`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `cerrar_pedido`(IN `id_pedido_in` int,IN `efectivo` int,IN `debito` int)
BEGIN
	
DECLARE total_sum, descuento_porc, descuento_calc, total  INT;

set descuento_porc = (select descuento from pedidos where id=id_pedido_in);


if ISNULL(descuento_porc) then set descuento_porc=0;

end if;



set total_sum = (select sum(precio) from productosXpedido where id_pedido=id_pedido_in);

set descuento_calc = total_sum*(descuento_porc/100);


set total = total_sum - descuento_calc;

insert into cuentas (id_pedido, total_pagar,efectivo,debito) VALUES(id_pedido_in, total,efectivo,debito);

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
	
DECLARE precio_copia INT;


set precio_copia = (select precio from productos where id=id_producto);

insert into productosXpedido (id_pedido, id_producto, precio) VALUES(id_pedido, id_producto, precio_copia);

END
;;
DELIMITER ;
