/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : 127.0.0.1:3306
Source Database       : tavo_sg

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-03-20 09:04:33
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of cuentas
-- ----------------------------

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
  `id_mesa` int(11) NOT NULL,
  `descuento` int(11) NOT NULL,
  `estado` enum('Activo','Cerrado') COLLATE utf8_spanish_ci DEFAULT NULL,
  `para_llevar` enum('Si','No') COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mesa` (`id_mesa`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of pedidos
-- ----------------------------
INSERT INTO `pedidos` VALUES ('1', '2015-03-19 17:27:44', '3', '12', 'Activo', 'No');
INSERT INTO `pedidos` VALUES ('2', '2015-03-19 17:28:35', '4', '10', 'Activo', 'No');

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
INSERT INTO `productos` VALUES ('1', '1', 'Patacon de Carne o de Pollo', null, '200.00');
INSERT INTO `productos` VALUES ('2', '2', 'Baby Grill', 'Hamburguesa Sencilla ', '200.00');
INSERT INTO `productos` VALUES ('3', '8', 'Jamon/Tocineta', 'Extra para cualquier comida', '70.00');

-- ----------------------------
-- Table structure for productosXpedido
-- ----------------------------
DROP TABLE IF EXISTS `productosXpedido`;
CREATE TABLE `productosXpedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `devuelto` enum('Si','No') COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` double(7,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `productosXpedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `productosXpedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of productosXpedido
-- ----------------------------
INSERT INTO `productosXpedido` VALUES ('1', '1', '1', null, null, null);
INSERT INTO `productosXpedido` VALUES ('2', null, null, null, null, null);

-- ----------------------------
-- Table structure for varios
-- ----------------------------
DROP TABLE IF EXISTS `varios`;
CREATE TABLE `varios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of varios
-- ----------------------------
INSERT INTO `varios` VALUES ('1', 'Descuento Familiar', '10');
