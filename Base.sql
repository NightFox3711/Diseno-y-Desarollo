
-- Crear la base de datos
CREATE DATABASE SCMotors2;

-- Usar la base de datos
USE SCMotors2;

-- Crear tabla para usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada usuario
    username VARCHAR(50) NOT NULL UNIQUE,      -- Nombre de usuario (único)
    password VARCHAR(255) NOT NULL,            -- Contraseña (almacenada con hash)
    role ENUM('admin', 'cliente') NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    cedula VARCHAR(20) UNIQUE not NULL
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla para vehículos (inventario)
CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada vehículo
    brand VARCHAR(50) NOT NULL,                -- Marca del vehículo
    model VARCHAR(50) NOT NULL,                -- Modelo del vehículo
    price DECIMAL(10, 2) NOT NULL,             -- Precio del vehículo
    status ENUM('Disponible', 'Reservado', 'Vendido')  DEFAULT 'Disponible', -- Estado del vehículo
    image_path VARCHAR(255) DEFAULT NULL,
    anio int NOT NULL       -- Ruta de la imagen del vehículo
);

-- Crear tabla para ventas
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    user_id INT NOT NULL,
    payment_method ENUM('efectivo', 'financiamiento') NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    months INT DEFAULT NULL, -- Solo aplica si es financiamiento
    interest DECIMAL(5, 2) DEFAULT NULL, -- Interés del financiamiento
    profit DECIMAL(10, 2) GENERATED ALWAYS AS (total * (1 + interest / 100)) STORED,
    status ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Si le da error el date_sale ca,biarlo por created_at
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Crear tabla para solicitudes de soporte (chat, citas y pruebas de manejo)
CREATE TABLE support_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada solicitud
    user_id INT NOT NULL,                      -- ID del usuario que realiza la solicitud
    type ENUM('chat', 'cita', 'prueba') NOT NULL, -- Tipo de solicitud (chat, cita, prueba)
    details TEXT NOT NULL,                     -- Detalles de la solicitud
    status ENUM('pendiente', 'resuelto') DEFAULT 'pendiente', -- Estado de la solicitud
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación de la solicitud
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Relación con usuarios
);


CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada cotización
    vehicle_id INT NOT NULL,                    -- ID del vehículo cotizado
    price_final DECIMAL(10,2) NOT NULL,         -- Precio final del vehículo
    financing_options TEXT, 
    email VARCHAR(100) DEFAULT NULL,             -- Columna añadida para email
    user_id INT DEFAULT NULL,                   -- ID del usuario al que se envió la cotización (NULL si está pendiente)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación de la cotización
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabla de promociones
CREATE TABLE offers (
    id_offer INT AUTO_INCREMENT PRIMARY KEY, 
    vehicles_id_offer INT NOT NULL,
    status_vehicle VARCHAR(10) NOT NULL,
    vehicle_offer VARCHAR (50) NOT NULL, 
    price_offer DECIMAL (10,2) NOT NULL,
    img_vehicle_offer VARCHAR (255) NOT NULL
);

-- Crear tabla Carrito
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    offer_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_name) REFERENCES users(username) ON DELETE CASCADE,
    FOREIGN KEY (offer_id) REFERENCES offers(id_offer) ON DELETE CASCADE
);

DROP TABLE IF EXISTS availability_requests;

CREATE TABLE availability_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vehicle_id INT NOT NULL,
  user_name VARCHAR(50) NOT NULL,
  is_notified TINYINT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
  FOREIGN KEY (user_name) REFERENCES users(username) ON DELETE CASCADE
);




-- Insertar usuarios de prueba
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),     -- Usuario administrador
('cliente1', 'cliente123', 'cliente'), -- Usuario cliente
('cliente2', 'cliente456', 'cliente'); -- Otro usuario cliente


-- Insertar vehículos de prueba
INSERT INTO vehicles (brand, model, price, status, image_path) VALUES
('Toyota', 'Prado TX 2017', 44336.00, 'disponible', 'Toyota Prado TX 2017.jpg'),
('Toyota', 'Corolla Cross 2023', 24490.00, 'disponible', 'Toyota CoAzul Cross 2023.jpg'),
('Suzuki', 'Vitara 2023', 24990.00, 'disponible', 'Suzuki Vitara 2023.jpg'),
('Hyundai', 'Tucson 2017', 17000.00, 'disponible', 'Hyundai Tucson 2017.jpg'),
('Toyota', 'Land Cruiser 1993', 23000.00, 'disponible', 'Toyota Land Cruiser 1993.jpg'),
('Toyota', 'Rush 2022', 21990.00, 'disponible', 'Toyota Rush 2022.jpg'),
('Toyota', 'Rush 2023', 22990.00, 'disponible', 'Toyota Rush 2023.jpg'),
('Toyota', 'Corolla Cross 2023', 24490.00, 'disponible', 'Toyota CoBlanco Cross 2023.jpg'),
('Toyota', 'Raize 2023', 18490.00, 'disponible', 'Toyota Raize 2023.jpg'),
('Toyota', 'Prado TXL 2023', 64490.00, 'disponible', 'Toyota Prado TXL 2023.jpg'),
('Toyota', 'Rav4 2022', 32490.00, 'disponible', 'Toyota Rav4 2022.jpg'),
('Toyota', 'Fortuner 2020', 45490.00, 'disponible', 'Toyota Fortuner 2020.jpg'),
('Toyota', 'Fortuner 2022', 50490.00, 'disponible', 'Toyota Fortuner 2022.jpg'),
('Toyota', 'Prado VX 2016', 49415.00, 'disponible', 'Toyota Prado VX 2016.jpg'),
('Toyota', 'Hilux 2019', 36500.00, 'disponible', 'Toyota Hilux 2019.jpg');


-- Insertar ventas de prueba
INSERT INTO sales (vehicle_id, user_id, payment_method, total) VALUES
(1, 2, 'efectivo', 20000.00),  -- Cliente 2 compra Toyota Corolla
(2, 3, 'financiamiento', 18000.00); -- Cliente 3 compra Ford Focus

-- Insertar solicitudes de soporte de prueba
INSERT INTO support_requests (user_id, type, details, status) VALUES
(2, 'chat', 'Tengo preguntas sobre el Toyota Corolla.', 'pendiente'),  -- Cliente 2 solicita chat
(3, 'cita', 'Quiero agendar una cita para ver el Ford Focus.', 'pendiente'), -- Cliente 3 solicita cita
(2, 'prueba', 'Solicito prueba de manejo del Honda Civic.', 'resuelto'),
(2, 'prueba', 'Solicito prueba de manejo del Honda Civic.', 'pendiente');  -- Cliente 2 solicita prueba de manejo

INSERT INTO offers (vehicles_id_offer, vehicle_offer, status_vehicle, price_offer, img_vehicle_offer, km_vehicle, type_vehicle, traction_vehicle, motor_vehicle) VALUES
    (1, 'Toyota Prado TX 2017', 'Semi Nuevo', 44336.00, 'Toyota Prado TX 2017.jpg', 64.000, 'Automático', '4X4', 3.000 ),
    (2, 'Toyota Corolla Cross 2023', 'Semi Nuevo', 24490.00, 'Toyota CoAzul Cross 2023.jpg', 37.000, 'Automático', '4X2', 2.000 ),
    (3, 'Suzuki Vitara 2023', 'Semi Nuevo', 24990.00, 'Suzuki Vitara 2023.jpg', 29.500, 'Automático', '4X2', 1.600 ),
    (4, 'Hyundai Tucson 2017', 'Semi Nuevo', 17000.00, 'Hyundai Tucson 2017.jpg', 85.000, 'Automático', '4x2', 2.000 ),
    (5, 'Toyota Land Cruiser 1993', 'Semi Nuevo', 23000.00, 'Toyota Land Cruiser 1993.jpg', 30.000, 'Manual', '4x4', 4.164 ),
    (6, 'Toyota Rush 2022', 'Semi Nuevo', 21990.00, 'Toyota Rush 2022.jpg', 64.000, 'Automático', '4x2', 1.500 ),
    (7, 'Toyota Rush 2023', 'Semi Nuevo', 22990.00, 'Toyota Rush 2023.jpg', 51.000, 'Automático', '4x2', 1.500 ),
    (8, 'Toyota Corolla Cross 2023', 'Semi Nuevo', 24490.00, 'Toyota CoBlanco Cross 2023.jpg', 39.000, 'Automático', '4x2', 2.000 ),
    (9, 'Toyota Raize 2023', 'Semi Nuevo', 18490.00, 'Toyota Raize 2023.jpg', 14.000, 'Manual', '4x2', 1.200 ),
    (10, 'Toyota Prado TXL 2023', 'Semi Nuevo', 64490.00, 'Toyota Prado TXL 2023.jpg', 32.000, 'Automático', '4x4', 3.000 ),
    (11, 'Toyota Rav4 2022', 'Semi Nuevo', 32490.00, 'Toyota Rav4 2022.jpg', 41.000, 'Automático', '4x4', 2.000),
    (12, 'Toyota Fortuner 2020', 'Semi Nuevo', 45490.00, 'Toyota Fortuner 2020.jpg', 64.000, 'Automático', '4x4', 2.800 ),
    (13, 'Toyota Fortuner 2022', 'Semi Nuevo', 50490.00, 'Toyota Fortuner 2022.jpg', 48.000, 'Automático', '4x4', 2.8000 ),
    (14, 'Toyota Prado VX 2016', 'Semi Nuevo', 49415.00, 'Toyota Prado VX 2016.jpg', 72.000, 'Automático', '4X4', 3.000 ),
    (15, 'Toyota Hilux 2019', 'Semi Nuevo', 36500.00, 'Toyota Hilux 2019.jpg', 10.400, 'Manual', '4X4', 2.400 );
  
  -- Insertar cotización
INSERT INTO quotes (vehicle_id, price_final, financing_options, email)  
VALUES (2, 17500.00, '12 meses sin intereses', 'cliente@example.com');

    -- poner los carros que si son
SET SQL_SAFE_UPDATES = 0;
DELETE FROM offers;
SET SQL_SAFE_UPDATES = 1;

ALTER TABLE offers AUTO_INCREMENT = 1;

-- isertar en el carrito    
INSERT INTO cart (user_name, offer_id, quantity) VALUES ('cliente1', 1, 2);

select * from sales;
SELECT * FROM vehicles;
Select * From users;
Select * From support_requests;
select * from offers;
select * from cart;
select * from availability_requests;

DROP TABLE IF EXISTS availability_requests;
SHOW TABLES;


DELETE FROM cart WHERE id > 0;


Crear los sp

DELIMITER $$
CREATE PROCEDURE sp_registrar_vehiculo(
    IN p_brand VARCHAR(50),
    IN p_model VARCHAR(50),
    IN p_price DECIMAL(10, 2),
    IN p_status ENUM('disponible', 'reservado'),
    IN p_image_path VARCHAR(255)
)
BEGIN
    INSERT INTO vehicles (brand, model, price, status, image_path)
    VALUES (p_brand, p_model, p_price, p_status, p_image_path);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_registrar_venta(
    IN p_vehicle_id INT,
    IN p_user_id INT,
    IN p_payment_method ENUM('efectivo', 'financiamiento'),
    IN p_total DECIMAL(10, 2)
)
BEGIN
    INSERT INTO sales (vehicle_id, user_id, payment_method, total)
    VALUES (p_vehicle_id, p_user_id, p_payment_method, p_total);
    
    -- Actualizar el estado del vehículo a 'reservado'
    UPDATE vehicles SET status = 'reservado' WHERE id = p_vehicle_id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_registrar_soporte(
    IN p_user_id INT,
    IN p_type ENUM('chat', 'cita', 'prueba'),
    IN p_details TEXT
)
BEGIN
    INSERT INTO support_requests (user_id, type, details, status)
    VALUES (p_user_id, p_type, p_details, 'pendiente');
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_actualizar_estado_soporte(
    IN p_request_id INT,
    IN p_status ENUM('pendiente', 'resuelto')
)
BEGIN
    UPDATE support_requests
    SET status = p_status
    WHERE id = p_request_id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_obtener_vehiculo(
    IN p_vehicle_id INT
)
BEGIN
    SELECT id, brand, model, price, status, image_path
    FROM vehicles
    WHERE id = p_vehicle_id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_consultar_ventas()
BEGIN
    SELECT s.id AS sale_id, v.brand AS vehicle_brand, v.model AS vehicle_model, u.username AS customer_username, 
           s.payment_method, s.total, s.created_at AS sale_date
    FROM sales s
    JOIN vehicles v ON s.vehicle_id = v.id
    JOIN users u ON s.user_id = u.id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_obtener_oferta(
    IN p_id_offer INT
)
BEGIN
    SELECT id_offer, vehicles_id_offer, vehicle_offer, price_offer, img_vehicle_offer
    FROM offers
    WHERE id_offer = p_id_offer;
END $$
DELIMITER ;

call sp_obtener_oferta(1);

DELIMITER $$
CREATE PROCEDURE sp_listar_clientes()
BEGIN
    SELECT id, username FROM users WHERE role = 'cliente';
END $$
DELIMITER ;

-- Cotizaciones

DELIMITER $$
CREATE PROCEDURE sp_listar_cotizaciones_pendientes()
BEGIN
    SELECT * FROM quotes;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_generar_cotizacion(IN p_vehicle_id INT)
BEGIN
    DECLARE v_price DECIMAL(10,2);
    DECLARE v_options TEXT;
   
    SELECT price
    INTO v_price 
    FROM vehicles
    WHERE id = p_vehicle_id;
    
    SET v_options = '["Financiamiento a 12 meses", "Financiamiento a 24 meses", "Financiamiento a 36 meses"]';
    INSERT INTO quotes (vehicle_id, price_final, financing_options)
    VALUES (p_vehicle_id, v_price, v_options);
    
    SELECT *
    FROM quotes
    WHERE id = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_obtener_cotizacion(IN p_quote_id INT)
BEGIN
    SELECT *
    FROM quotes
    WHERE id = p_quote_id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_enviar_cotizacion(IN p_quote_id INT, IN p_user_id INT)
BEGIN
    UPDATE quotes 
    SET user_id = p_user_id 
    WHERE id = p_quote_id;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_agregar_al_carrito(
    IN p_user_name VARCHAR(50),
    IN p_offer_id INT
)
BEGIN
    INSERT INTO cart (user_name, offer_id, quantity)
    VALUES (p_user_name, p_offer_id, 1)
    ON DUPLICATE KEY UPDATE quantity = quantity + 1;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE ShowCart(IN p_user_name VARCHAR(50))
BEGIN
    SELECT 
        c.id AS cart_id,
        c.user_name,
        c.offer_id,
        o.vehicle_offer,
        o.price_offer,
        c.quantity,
        (o.price_offer * c.quantity) AS total_price,
        o.img_vehicle_offer,
        c.created_at
    FROM cart c
    JOIN offers o ON c.offer_id = o.id_offer
    WHERE c.user_name = p_user_name;
END $$
DELIMITER ;

CALL sp_agregar_al_carrito('cliente1', 1);
CALL sp_agregar_al_carrito('cliente1', 1);

-- ver contenido del carrito
CALL ShowCart('cliente1');

ALTER TABLE cart ADD CONSTRAINT uc_user_offer UNIQUE (user_name, offer_id);

ALTER TABLE sales
MODIFY COLUMN payment_method ENUM('efectivo', 'financiamiento', 'transferencia') NOT NULL,
ADD COLUMN user_name VARCHAR(50) NOT NULL AFTER user_id;







CREATE TABLE Cotizaciones (
    id_cotizacion INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_vehiculo INT,
    precio_estimado DECIMAL(10,2) NOT NULL,
    plazo VARCHAR(2) NOT NULL,  -- Plazo en meses para financiamiento
    interes DECIMAL(5,2) DEFAULT 0.00,     -- Interés según el plazo
    fecha_cotizacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    descuento_aplicado DECIMAL(10,2),
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculos(id_vehiculo)
);




CREATE TABLE Ventas (
    id_venta INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_vehiculo INT,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    saldo_pendiente DECIMAL(10,2),
    estado ENUM('Completada', 'Pendiente', 'Anulada') NOT NULL,  -- Estado de la venta
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculos(id_vehiculo)
);


-- Agregar columna actualizar o hacer un update 


CREATE TABLE Devoluciones (
    id_devolucion INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT,
    id_usuario INT,  -- ID del usuario que solicita la devolución
    motivo TEXT NOT NULL,
    estado ENUM('Pendiente', 'Aprobada', 'Rechazada') NOT NULL,
    fecha_devolucion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);


CREATE TABLE Facturas (
    id_factura INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT,
    fecha_emision DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta)
);



CREATE TABLE Pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT,
    metodo_pago ENUM('Tarjeta', 'Efectivo', 'Financiamiento') NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    meses INT DEFAULT NULL,  -- Si es financiamiento, número de meses a pagar
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    saldo_pendiente DECIMAL(10,2),
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta)
);




CREATE TABLE Promociones (
    id_promocion INT PRIMARY KEY AUTO_INCREMENT,
    id_vehiculo INT,
    descripcion TEXT NOT NULL,
    descuento DECIMAL(5,2) NOT NULL,  -- Descuento aplicado a la moto
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculos(id_vehiculo)
);


CREATE TABLE Reportes_Ventas (
    id_reporte INT PRIMARY KEY AUTO_INCREMENT,
    fecha_reporte DATE NOT NULL,
    total_ventas DECIMAL(10,2) NOT NULL,
    cantidad_ventas INT NOT NULL,
    id_venta INT,
    FOREIGN KEY (id_venta) REFERENCES Ventas(id_venta)
);


CREATE TABLE Reservas (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_vehiculo INT,
    monto_reserva DECIMAL(10,2) NOT NULL,  -- Monto pagado por la reserva
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Reservado', 'Disponible') NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES Vehiculos(id_vehiculo)
);




-- Sp de prueba Registro y validacion

DELIMITER $$

CREATE PROCEDURE sp_registrar_usuario(
    IN p_nombre VARCHAR(100),
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_telefono VARCHAR(15),
    IN p_direccion TEXT,
    IN p_cedula VARCHAR(20),
    IN p_rol ENUM('Admin', 'Cliente', 'Empleado')
)
BEGIN
    INSERT INTO Usuarios (nombre, email, password, telefono, direccion, cedula, rol)
    VALUES (p_nombre, p_email, p_password, p_telefono, p_direccion, p_cedula, p_rol);
END$$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_validar_usuario_por_cedula(
    IN p_cedula VARCHAR(20)
)
BEGIN
    SELECT id_usuario, nombre, email, password, rol 
    FROM Usuarios 
    WHERE cedula = p_cedula;
END$$

DELIMITER ;





-- Cotizaciones 

-- Procedimiento para registrar una cotización  
DELIMITER $$  
CREATE PROCEDURE sp_registrar_cotizacion(
    IN p_id_cliente INT,
    IN p_id_vehiculo INT,
    IN p_precio_estimado DECIMAL(10,2),
    IN p_plazo VARCHAR(2),  -- Cambiado a VARCHAR(2)
    IN p_interes DECIMAL(5,2),
    IN p_descuento_aplicado DECIMAL(10,2)
)
BEGIN
    INSERT INTO Cotizaciones (id_cliente, id_vehiculo, precio_estimado, plazo, interes, descuento_aplicado)
    VALUES (p_id_cliente, p_id_vehiculo, p_precio_estimado, p_plazo, p_interes, p_descuento_aplicado);
END$$  
DELIMITER ;  


-- Procedimiento para mostrar todas las cotizaciones  
DELIMITER $$  
CREATE PROCEDURE sp_mostrar_cotizaciones()
BEGIN
    SELECT 
        c.id_cotizacion, 
        u.nombre AS cliente, 
        v.modelo AS vehiculo, 
        c.precio_estimado, 
        c.plazo, 
        c.interes, 
        c.descuento_aplicado, 
        c.fecha_cotizacion
    FROM Cotizaciones c
    JOIN Usuarios u ON c.id_cliente = u.id_usuario
    JOIN Vehiculos v ON c.id_vehiculo = v.id_vehiculo;
END$$  
DELIMITER ;  


-- Ventas 

DELIMITER $$

CREATE PROCEDURE sp_mostrar_ventas()
BEGIN
    SELECT v.id_venta, u.nombre AS cliente, vh.marca, vh.modelo, v.total, v.saldo_pendiente, v.estado, v.fecha_venta
    FROM Ventas v
    JOIN Usuarios u ON v.id_cliente = u.id_usuario
    JOIN Vehiculos vh ON v.id_vehiculo = vh.id_vehiculo;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_registrar_venta(
    IN p_id_cliente INT,
    IN p_id_vehiculo INT,
    IN p_total DECIMAL(10,2),
    IN p_saldo_pendiente DECIMAL(10,2),
    IN p_estado ENUM('Completada', 'Pendiente', 'Anulada')
)
BEGIN
    -- Insertar venta
    INSERT INTO Ventas (id_cliente, id_vehiculo, total, saldo_pendiente, estado)
    VALUES (p_id_cliente, p_id_vehiculo, p_total, p_saldo_pendiente, p_estado);
    
    -- Si la venta está completada, actualizar el estado del vehículo a 'Vendido'
    IF p_estado = 'Completada' THEN
        UPDATE Vehiculos
        SET estado = 'Vendido'
        WHERE id_vehiculo = p_id_vehiculo;
    END IF;
END $$

DELIMITER ;






	-- Devoluciones

	-- Registrar devoluciones

	DELIMITER $$

	CREATE PROCEDURE sp_registrar_devoluciones(
		IN p_id_venta INT,
		IN p_id_usuario INT,
		IN p_motivo TEXT,
		IN p_estado ENUM('Pendiente', 'Aprobada', 'Rechazada')
	)
	BEGIN
		INSERT INTO Devoluciones (id_venta, id_usuario, motivo, estado)
		VALUES (p_id_venta, p_id_usuario, p_motivo, p_estado);
	END $$

	DELIMITER ;





	-- Mostrar devolociones 

	DELIMITER $$

	CREATE PROCEDURE sp_Mostrar_devoluciones()
	BEGIN
		SELECT d.id_devolucion, v.id_venta, u.nombre AS cliente, d.motivo, d.estado, d.fecha_devolucion
		FROM Devoluciones d
		JOIN Ventas v ON d.id_venta = v.id_venta
		JOIN Usuarios u ON d.id_usuario = u.id_usuario;
	END $$

	DELIMITER ;









-- ------------------------------------------------------------------------------

-- Copiar para implmentar en casa


-- Fcaturas

DELIMITER $$

-- Procedimiento para registrar una factura
CREATE PROCEDURE sp_registrar_factura(IN p_id_venta INT, IN p_total DECIMAL(10,2))
BEGIN
    INSERT INTO Facturas (id_venta, total) VALUES (p_id_venta, p_total);
END$$


DELIMITER $$
-- Procedimiento para mostrar todas las facturas
CREATE PROCEDURE sp_mostrar_facturas()
BEGIN
    SELECT * FROM Facturas;
END$$

DELIMITER ;




-- pagosssss

DELIMITER //

CREATE PROCEDURE sp_mostrar_pago()
BEGIN
    SELECT * FROM Pagos;
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE sp_registrar_pago(
    IN p_id_venta INT,
    IN p_metodo_pago ENUM('Tarjeta', 'Efectivo', 'Financiamiento'),
    IN p_monto DECIMAL(10,2),
    IN p_meses INT,
    IN p_saldo_pendiente DECIMAL(10,2)
)
BEGIN
    INSERT INTO Pagos (id_venta, metodo_pago, monto, meses, saldo_pendiente)
    VALUES (p_id_venta, p_metodo_pago, p_monto, p_meses, p_saldo_pendiente);
END //

DELIMITER ;



-- Promciones


DELIMITER $$

CREATE PROCEDURE sp_mostrar_promociones()
BEGIN
    SELECT P.id_promocion, P.id_vehiculo, V.marca, V.modelo, P.descripcion, P.descuento, P.fecha_inicio, P.fecha_fin
    FROM Promociones P
    JOIN Vehiculos V ON P.id_vehiculo = V.id_vehiculo;
END$$

DELIMITER ;





DELIMITER $$

CREATE PROCEDURE sp_registrar_promociones(
    IN p_id_vehiculo INT,
    IN p_descripcion TEXT,
    IN p_descuento DECIMAL(5,2),
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    INSERT INTO Promociones (id_vehiculo, descripcion, descuento, fecha_inicio, fecha_fin) 
    VALUES (p_id_vehiculo, p_descripcion, p_descuento, p_fecha_inicio, p_fecha_fin);
END$$

DELIMITER ;





-- Reservas



DELIMITER $$

CREATE PROCEDURE sp_registrar_reserva(
    IN p_id_cliente INT,
    IN p_id_vehiculo INT,
    IN p_monto_reserva DECIMAL(10,2),
    IN p_estado ENUM('Reservado', 'Disponible')
)
BEGIN
    -- Insertar reserva
    INSERT INTO Reservas (id_cliente, id_vehiculo, monto_reserva, estado) 
    VALUES (p_id_cliente, p_id_vehiculo, p_monto_reserva, p_estado);
    
    -- Actualizar el estado del vehículo a 'Reservado'
    IF p_estado = 'Reservado' THEN
        UPDATE Vehiculos
        SET estado = 'Reservado'
        WHERE id_vehiculo = p_id_vehiculo;
    END IF;
END $$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE sp_mostrar_reservas()
BEGIN
    SELECT R.id_reserva, U.nombre AS cliente, V.marca, V.modelo, R.monto_reserva, R.fecha_reserva, R.estado
    FROM Reservas R
    JOIN Usuarios U ON R.id_cliente = U.id_usuario
    JOIN Vehiculos V ON R.id_vehiculo = V.id_vehiculo;
END$$

DELIMITER ;




-- reportes 


DELIMITER $$

CREATE PROCEDURE sp_generar_reporte_ventas()
BEGIN
    INSERT INTO Reportes_Ventas (fecha_reporte, total_ventas, cantidad_ventas, id_venta)
    SELECT CURDATE(), SUM(total), COUNT(*), v.id_venta
    FROM Ventas v
    WHERE v.fecha_venta >= CURDATE() - INTERVAL 1 MONTH -- Puedes ajustar el intervalo según tus necesidades
    GROUP BY v.id_venta;
END $$

DELIMITER ;


