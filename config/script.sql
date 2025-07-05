-- CREACIÓN DE LA BASE DE DATOS
DROP DATABASE IF EXISTS pescaderia;
CREATE DATABASE pescaderia CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pescaderia;

-- ================================================
-- 1. TABLA: rol
-- ================================================
CREATE TABLE rol (
  rol_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  PRIMARY KEY (rol_id)
);

INSERT INTO rol (rol_id, nombre) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Visitante');

-- ================================================
-- 2. TABLA: usuario
-- ================================================
CREATE TABLE usuario (
  usuario_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre_usuario VARCHAR(255) NOT NULL UNIQUE,
  nombre_completo VARCHAR(255) NOT NULL,
  contraseña VARCHAR(255) NOT NULL,
  rol_id INT(11),
  direccion VARCHAR(100) NOT NULL,
  correo VARCHAR(100)NOT NULL,
  telefono VARCHAR(10),
  PRIMARY KEY (usuario_id),
  KEY (rol_id),
  CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES rol(rol_id) ON DELETE SET NULL
);

INSERT INTO usuario (usuario_id, nombre_usuario, nombre_completo, contraseña, rol_id,direccion,correo,telefono) VALUES
(1, 'admin123', 'Marizta Rosero', '$2y$10$wDkh9Y3evZXdG8EZYNvOoerzp8pUSnEPR785STqY1KYm8E94J0eTC', 1,'Av.canonigo Ramos y 11 de noviembre','maritza@gmail.com','0992470053'),
(2, 'visitante', 'visitante', 'visitante', 3,'calle 2','visitante@gmail.com','0987877841');

-- ================================================
-- 3. TABLA: categoria
-- ================================================
CREATE TABLE categoria (
  categoria_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  PRIMARY KEY (categoria_id)
);

INSERT INTO categoria (categoria_id, nombre) VALUES
(1, 'Pescados'),
(2, 'Crustaceos'),
(3, 'PulposCalamares');

-- ================================================
-- 4. TABLA: producto
-- ================================================
CREATE TABLE producto (
  producto_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT DEFAULT NULL,
  precio DECIMAL(10,2) NOT NULL,
  stock INT(11) NOT NULL,
  imagen_url VARCHAR(255) DEFAULT NULL,
  categoria_id INT(11),
  unidadMedida VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (producto_id),
  KEY (categoria_id),
  CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(categoria_id) ON DELETE SET NULL
);

-- ================================================
-- 5. TABLA: pedido
-- ================================================
CREATE TABLE pedido (
  pedido_id INT(11) NOT NULL AUTO_INCREMENT,
  usuario_id INT(11) NOT NULL,
  fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10,2) DEFAULT NULL,
  PRIMARY KEY (pedido_id),
  KEY (usuario_id),
  CONSTRAINT fk_pedido_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id) ON DELETE CASCADE
);

-- ================================================
-- 6. TABLA: pedidoproducto
-- ================================================
CREATE TABLE pedidoproducto (
  pedido_id INT(11) NOT NULL,
  producto_id INT(11) NOT NULL,
  cantidad INT(11) NOT NULL,
  PRIMARY KEY (pedido_id, producto_id),
  KEY fk_producto_id (producto_id),
  CONSTRAINT fk_pedidoproducto_pedido FOREIGN KEY (pedido_id) REFERENCES pedido(pedido_id) ON DELETE CASCADE,
  CONSTRAINT fk_pedidoproducto_producto FOREIGN KEY (producto_id) REFERENCES producto(producto_id) ON DELETE CASCADE
);

-- ================================================
-- 7. TRIGGER: Actualizar total del pedido automáticamente
-- ================================================
DELIMITER $$

CREATE TRIGGER trg_CalcularTotal
AFTER INSERT ON pedidoproducto
FOR EACH ROW
BEGIN
  UPDATE pedido
  SET total = (
    SELECT SUM(pp.cantidad * p.precio)
    FROM pedidoproducto pp
    INNER JOIN producto p ON p.producto_id = pp.producto_id
    WHERE pp.pedido_id = NEW.pedido_id
  )
  WHERE pedido_id = NEW.pedido_id;
END$$

DELIMITER ;

-- ================================================
-- FIN DEL SCRIPT
-- ================================================
