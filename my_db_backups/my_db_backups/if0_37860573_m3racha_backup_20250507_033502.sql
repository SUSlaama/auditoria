SET FOREIGN_KEY_CHECKS=0;



-- Estructura de la tabla `carrito`
DROP TABLE IF EXISTS `carrito`;
CREATE TABLE `carrito` (
  `idCarrito` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idCarrito`,`idUsuario`),
  KEY `user_carrito` (`idUsuario`),
  CONSTRAINT `user_carrito` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Estructura de la tabla `carritoproducto`
DROP TABLE IF EXISTS `carritoproducto`;
CREATE TABLE `carritoproducto` (
  `idCarrito` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  KEY `carProd_idCarrito` (`idCarrito`),
  KEY `carProd_idUsuario` (`idUsuario`),
  KEY `carProd_idProducto` (`idProducto`),
  CONSTRAINT `carProd_idCarrito` FOREIGN KEY (`idCarrito`) REFERENCES `carrito` (`idCarrito`),
  CONSTRAINT `carProd_idProducto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  CONSTRAINT `carProd_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `carrito` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Estructura de la tabla `direccion`
DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `idDireccion` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `noExt` int(11) NOT NULL,
  `noInt` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDireccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Estructura de la tabla `producto`
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `img` varchar(100) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos para la tabla `producto`
INSERT INTO `producto` VALUES('1', 'PLAYERA STRAY KIDS MANIAC', '200', 'Playera tela estampada.\n50% Algodón 50% Poliéster.\nLargo de manga: Manga media\nAjuste: Corte estándar\nCuello: Cuello redondo', 'img/Productos/producto1.png', 'clothes');
INSERT INTO `producto` VALUES('2', 'Playera Stray Kids Maniac Blanco', '200', 'Playera tela estampada.\n50% Algodón 50% Poliéster.\nLargo de manga: Manga media\nAjuste: Corte estándar\nCuello: Cuello redondo', 'img/Productos/producto2.png', 'clothes');
INSERT INTO `producto` VALUES('3', 'Playera Stray Kids - Nombres', '250', 'Playera tela estampada.\n50% Algodón 50% Poliéster.\nLargo de manga: Manga media\nAjuste: Corte estándar\nCuello: Cuello redondo\n', 'img/Productos/producto3.png', 'clothes');
INSERT INTO `producto` VALUES('4', 'Album Rock Star - Stray Kids', '600', 'Tipo: CD\r\nNumero de discos: 1\r\nFecha de lanzamiento: 2023\r\nArtista: Stray Kids', 'img/Productos/producto4.jpeg', 'albums');
INSERT INTO `producto` VALUES('5', 'Photocard - Bang Chan', '250', 'Material: Opalina\r\nFanmade Lomo\r\nMedidas: 55x84mm\r\nEsquinas redondeadas', 'img/Productos/producto5.png', 'photocards');
INSERT INTO `producto` VALUES('6', 'Album NOEASY - Stray Kids', '650', 'Tipo: CD\r\nNumero de discos: 1\r\nFecha de lanzamiento: 2021\r\nArtista: Stray Kids', 'img/Productos/producto6.png', 'albums');
INSERT INTO `producto` VALUES('7', 'Playera Prueba', '999', 'Playera de prueba auditoria', 'img/Productos/producto3.png', 'clothes');
INSERT INTO `producto` VALUES('8', 'ALBUM', '500', 'Album 19 de la banda StrayKidz', 'img/Productos/producto19.jpg', 'albums');
INSERT INTO `producto` VALUES('9', 'ALBUM 9', '200', 'Album numero 9 de StrayKidz', 'img/Productos/producto18.jpg', 'albums');
INSERT INTO `producto` VALUES('10', 'PLAYERA STRAY KIDS MAXIDENT', '1000', 'Playera tela estampada.\n50% Algodón 50% Poliéster.\nLargo de manga: Manga media\nAjuste: Corte estándar\nCuello: Cuello redondo', 'img/Productos/producto20.jpg', 'clothes');
INSERT INTO `producto` VALUES('11', 'Photocard - Han', '800', 'Photocard del integrante Han', 'img/Productos/producto15 han.jpg', 'PHOTOCARDS');



-- Estructura de la tabla `usuario`
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `idDireccion` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `user_dir` (`idDireccion`),
  CONSTRAINT `user_dir` FOREIGN KEY (`idDireccion`) REFERENCES `direccion` (`idDireccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Estructura de la tabla `usuarios`
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcado de datos para la tabla `usuarios`
INSERT INTO `usuarios` VALUES('1', 'admin', '$2y$10$lHjixfPkrFOBvQQi0CsxN.Rb3KNUBRI.z9nhIOoDyhc/gTN58o/FK', 'admin', 'admin');

SET FOREIGN_KEY_CHECKS=1;
