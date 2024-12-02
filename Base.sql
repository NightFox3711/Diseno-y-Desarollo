-- Crear la base de datos
CREATE DATABASE SCMotors2;

-- Usar la base de datos
USE SCMotors2;

-- Crear tabla para usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada usuario
    username VARCHAR(50) NOT NULL UNIQUE,      -- Nombre de usuario (único)
    password VARCHAR(255) NOT NULL,            -- Contraseña (almacenada con hash)
    role ENUM('admin', 'cliente') NOT NULL     -- Rol del usuario (admin o cliente)
);

-- Crear tabla para vehículos (inventario)
CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada vehículo
    brand VARCHAR(50) NOT NULL,                -- Marca del vehículo
    model VARCHAR(50) NOT NULL,                -- Modelo del vehículo
    price DECIMAL(10, 2) NOT NULL,             -- Precio del vehículo
    status ENUM('disponible', 'reservado') DEFAULT 'disponible', -- Estado del vehículo
    image_path VARCHAR(255) DEFAULT NULL       -- Ruta de la imagen del vehículo
);

-- Crear tabla para ventas
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID único para cada venta
    vehicle_id INT NOT NULL,                   -- ID del vehículo vendido
    user_id INT NOT NULL,                      -- ID del usuario que realizó la compra
    payment_method ENUM('efectivo', 'financiamiento') NOT NULL, -- Método de pago
    total DECIMAL(10, 2) NOT NULL,             -- Precio total de la venta
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE, -- Relación con vehículos
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE      -- Relación con usuarios
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

-- Insertar usuarios de prueba
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),     -- Usuario administrador
('cliente1', 'cliente123', 'cliente'), -- Usuario cliente
('cliente2', 'cliente456', 'cliente'); -- Otro usuario cliente

-- Insertar vehículos de prueba
INSERT INTO vehicles (brand, model, price, status, image_path) VALUES
('Toyota', 'Corolla', 20000.00, 'disponible', 'uploads/toyota_corolla.jpg'),
('Ford', 'Focus', 18000.00, 'disponible', 'uploads/ford_focus.jpg'),
('Honda', 'Civic', 22000.00, 'reservado', 'uploads/honda_civic.jpg');

-- Insertar ventas de prueba
INSERT INTO sales (vehicle_id, user_id, payment_method, total) VALUES
(1, 2, 'efectivo', 20000.00),  -- Cliente 2 compra Toyota Corolla
(2, 3, 'financiamiento', 18000.00); -- Cliente 3 compra Ford Focus

-- Insertar solicitudes de soporte de prueba
INSERT INTO support_requests (user_id, type, details, status) VALUES
(2, 'chat', 'Tengo preguntas sobre el Toyota Corolla.', 'pendiente'),  -- Cliente 2 solicita chat
(3, 'cita', 'Quiero agendar una cita para ver el Ford Focus.', 'pendiente'), -- Cliente 3 solicita cita
(2, 'prueba', 'Solicito prueba de manejo del Honda Civic.', 'resuelto');

INSERT INTO support_requests (user_id, type, details, status) VALUES (6, 'prueba', 'Solicito prueba de manejo del Honda Civic.', 'pendiente');
INSERT INTO support_requests (user_id, type, details, status) VALUES(2, 'prueba', 'Solicito prueba de manejo del Honda Civic.', 'pendiente');  -- Cliente 2 solicita prueba de manejo

select * from sales;
SELECT * FROM vehicles;
Select * From users;
Select * From support_requests;




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
