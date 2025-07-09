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
  correo VARCHAR(100) NOT NULL,
  telefono VARCHAR(10),
  PRIMARY KEY (usuario_id),
  KEY (rol_id),
  CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES rol(rol_id) ON DELETE SET NULL
);

INSERT INTO usuario (usuario_id, nombre_usuario, nombre_completo, contraseña, rol_id, direccion, correo, telefono) VALUES
(1, 'admin123', 'Marizta Rosero', '$2y$10$wDkh9Y3evZXdG8EZYNvOoerzp8pUSnEPR785STqY1KYm8E94J0eTC', 1, 'Av.canonigo Ramos y 11 de noviembre', 'maritza@gmail.com', '0992470053'),
(2, 'visitante', 'visitante', 'visitante', 3, 'calle 2', 'visitante@gmail.com', '0987877841');

-- ================================================
-- 3. TABLA: unidad_medida
-- ================================================
CREATE TABLE unidad_medida (
  unidad_id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  abreviatura VARCHAR(10) NOT NULL
);

INSERT INTO unidad_medida (nombre, abreviatura) VALUES
('Tonelada', 'Tn'), -- ID 1
('Libra', 'lb'),     -- ID 2
('Unidad', 'u');     -- ID 3

-- ================================================
-- 4. TABLA: categoria
-- ================================================
CREATE TABLE categoria (
  categoria_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  PRIMARY KEY (categoria_id)
);

INSERT INTO categoria (categoria_id, nombre) VALUES
(1, 'Pescados'),
(2, 'Crustáceos y Moluscos'),
(3, 'Pulpos y Calamares');

-- ================================================
-- 5. TABLA: producto
-- ================================================
CREATE TABLE producto (
  producto_id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT DEFAULT NULL,
  precio DECIMAL(10,2) NOT NULL,
  stock DECIMAL(10,4) NOT NULL,
  imagen_url VARCHAR(255) DEFAULT NULL,
  categoria_id INT(11),
  unidad_compra_id INT,
  unidad_venta_id INT,
  factor_conversion DECIMAL(10,4) DEFAULT 1.0000,
  PRIMARY KEY (producto_id),
  KEY (categoria_id),
  CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categoria(categoria_id) ON DELETE SET NULL,
  CONSTRAINT fk_producto_ucompra FOREIGN KEY (unidad_compra_id) REFERENCES unidad_medida(unidad_id),
  CONSTRAINT fk_producto_uventa FOREIGN KEY (unidad_venta_id) REFERENCES unidad_medida(unidad_id)
);

-- ================================================
-- 6. TRIGGER: trg_SetFactorConversion
-- Establece el factor de conversión automáticamente al insertar un nuevo producto.
-- Esto es crucial porque el `factor_conversion` no se inserta desde la interfaz de usuario.
-- ================================================
DELIMITER $$

CREATE TRIGGER trg_SetFactorConversion
BEFORE INSERT ON producto
FOR EACH ROW
BEGIN
    -- ID de Tonelada es 1
    -- ID de Libra es 2
    -- ID de Unidad es 3

    -- Si la unidad de compra es 'Tonelada'
    IF NEW.unidad_compra_id = 1 THEN
        -- Y la unidad de venta es 'Libra'
        IF NEW.unidad_venta_id = 2 THEN
            SET NEW.factor_conversion = 2204.6200; -- Aproximadamente 2204.62 libras en 1 tonelada métrica
        END IF;
    -- Si la unidad de compra es 'Unidad'
    ELSEIF NEW.unidad_compra_id = 3 THEN
        -- Y la unidad de venta también es 'Unidad'
        IF NEW.unidad_venta_id = 3 THEN
            SET NEW.factor_conversion = 1.0000; -- No hay conversión, 1 unidad = 1 unidad
        END IF;
    END IF;
    -- Para cualquier otra combinación o si los IDs no coinciden,
    -- NEW.factor_conversion mantendrá el valor que se envió o el DEFAULT (1.0000).
    -- Asegúrate de que las `unidad_compra_id` y `unidad_venta_id` estén siempre presentes.
END$$

DELIMITER ;

-- ================================================
-- 7. INSERCIÓN DE DATOS DE PRODUCTOS
-- ¡IMPORTANTE! Revisa los valores de `stock` y `factor_conversion`
-- Para productos de tonelada a libra, el `stock` debe ser en toneladas
-- y el `factor_conversion` se establecerá automáticamente por el trigger.
-- Para productos de unidad a unidad, el `stock` debe ser en unidades y
-- el `factor_conversion` se establecerá automáticamente en 1.0000.
-- ================================================
INSERT INTO `producto` (`producto_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen_url`, `categoria_id`, `unidad_compra_id`, `unidad_venta_id`, `factor_conversion`) VALUES
(1, 'Albacora Limpia', 'Albacora sin vísceras ni piel.', 3.00, 1.0000, 'public/img/albacoraLimpia.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(2, 'Albacora Entera', 'Pez albacora entero', 3.00, 1.0000, 'public/img/albacoraEntera.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(3, 'Pulpo', 'Pulpo fresco en porciones.', 4.00, 1.0000, 'public/img/pulpo.jpg', 3, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(4, 'Camarón Mar', 'Camarón de mar grande.', 4.00, 1.0000, 'public/img/camaronMar.jpg', 2, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(5, 'Albacora por libra', 'Porciones de albacora por libra.', 4.00, 1.0000, 'public/img/albacoraLibra.png', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(6, 'Albacora negocio', 'Precio especial por volumen.', 2.00, 1.0000, 'public/img/albacoraNegocio.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(7, 'Calamar', 'Calamar fresco por libra.', 4.00, 1.0000, 'public/img/calamar.jpg', 3, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(8, 'langostino', 'Langostinos grandes de mar.', 4.00, 1.0000, 'public/img/langostino.jpg', 2, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(9, 'Pez Espada', 'Filetes de pescado espada.', 4.00, 1.0000, 'public/img/espada.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(10, 'almeja', 'Almejas frescas empacadas.', 4.00, 500.0000, 'public/img/almejas.jpg', 2, 3, 3, DEFAULT), -- El factor será 1.0000 por el trigger
(11, 'Mejillones', 'Mejillones limpios en funda.', 4.00, 1000.0000, 'public/img/mejillones.jpg', 2, 3, 3, DEFAULT), -- El factor será 1.0000 por el trigger
(12, 'Conchas', 'Conchas enteras empacadas (100 unds).', 4.00, 2000.0000, 'public/img/conchas.jpg', 2, 3, 3, DEFAULT), -- El factor será 1.0000 por el trigger
(13, 'Pez Rayado', 'Pescado rayado fileteado.', 5.00, 1.0000, 'public/img/rayado.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(14, 'Pez Cache', 'Cache fresco en cortes por libra.', 3.00, 1.0000, 'public/img/cache.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(15, 'Tilapia', 'Tilapia limpia en porciones.', 3.00, 1.0000, 'public/img/tilapia.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(16, 'Picudo', 'Picudo fresco fileteado.', 5.00, 1.0000, 'public/img/picudo.jpg', 1, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(17, 'Camarón Piscina', 'Camarón de cultivo.', 4.00, 1.0000, 'public/img/camaronPiscina.jpg', 2, 1, 2, DEFAULT), -- El factor será 2204.6200 por el trigger
(18, 'Camarón Río', 'Camarón silvestre de río.', 6.00, 1.0000, 'public/img/camaronRio.jpg', 2, 1, 2, DEFAULT); -- El factor será 2204.6200 por el trigger


-- ================================================
-- 8. NUEVA TABLA: carrito
-- Esta tabla almacenará los productos temporales en el carrito de cada usuario.
-- ================================================
CREATE TABLE carrito (
  carrito_id INT(11) NOT NULL AUTO_INCREMENT,
  usuario_id INT(11) NOT NULL,
  producto_id INT(11) NOT NULL,
  cantidad INT(11) NOT NULL DEFAULT 1, -- Cantidad de este producto en el carrito
  fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Para saber cuándo se añadió
  PRIMARY KEY (carrito_id),
  UNIQUE KEY (usuario_id, producto_id), -- Un usuario no puede tener el mismo producto dos veces en el carrito
  CONSTRAINT fk_carrito_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id) ON DELETE CASCADE,
  CONSTRAINT fk_carrito_producto FOREIGN KEY (producto_id) REFERENCES producto(producto_id) ON DELETE CASCADE
);

-- ================================================
-- 9. TABLA: pedido
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
-- 10. TABLA: pedidoproducto
-- ================================================
CREATE TABLE pedidoproducto (
  pedido_id INT(11) NOT NULL,
  producto_id INT(11) NOT NULL,
  cantidad DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (pedido_id, producto_id),
  KEY fk_producto_id (producto_id),
  CONSTRAINT fk_pedidoproducto_pedido FOREIGN KEY (pedido_id) REFERENCES pedido(pedido_id) ON DELETE CASCADE,
  CONSTRAINT fk_pedidoproducto_producto FOREIGN KEY (producto_id) REFERENCES producto(producto_id) ON DELETE CASCADE
);

-- ================================================
-- 11. TRIGGER: trg_CalcularTotal
-- Actualiza el total del pedido automáticamente
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

-- ================================================
-- 12. TRIGGER: trg_DescontarStock
-- Descuenta del stock automáticamente según unidad y factor de conversión
-- ================================================
CREATE TRIGGER trg_DescontarStock
AFTER INSERT ON pedidoproducto
FOR EACH ROW
BEGIN
  DECLARE unidad_compra INT;
  DECLARE unidad_venta INT;
  DECLARE factor DECIMAL(10,4);

  SELECT unidad_compra_id, unidad_venta_id, factor_conversion
  INTO unidad_compra, unidad_venta, factor
  FROM producto
  WHERE producto_id = NEW.producto_id;

  IF unidad_compra = unidad_venta THEN
    UPDATE producto
    SET stock = stock - NEW.cantidad
    WHERE producto_id = NEW.producto_id;
  ELSE
    UPDATE producto
    SET stock = stock - (NEW.cantidad / factor)
    WHERE producto_id = NEW.producto_id;
  END IF;
END$$

DELIMITER ;

-- ================================================
-- FIN DEL SCRIPT
-- ================================================