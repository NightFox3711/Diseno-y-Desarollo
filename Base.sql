 -- Creación de la base de datos
CREATE DATABASE SolisMotors3718;

-- Utilización de la base de datos
USE SolisMotors3718; 

/*******************************************************************************
 * 
 *  Creación de las tablas de la base de datos
 * 
 ******************************************************************************/

CREATE TABLE users (
    id_username INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    location TEXT,
    id_card VARCHAR(20) UNIQUE NOT NULL,
    role ENUM('Administrador', 'Cliente') NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
);
 
 select * from users

-- Crear tabla para vehículos (inventario)
CREATE TABLE vehicles (
    id_vehicle INT AUTO_INCREMENT PRIMARY KEY,         
    brand VARCHAR(50) NOT NULL,          
    model VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('Disponible', 'Reservado', 'Vendido') DEFAULT 'Disponible' NOT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    headquarters ENUM('Sede Central - San Pablo, Heredia', 'Sede Secundaria - San Joaquín, Heredia') NOT NULL
);


CREATE TABLE sales (
    id_sales INT PRIMARY KEY AUTO_INCREMENT,
    id_vehicle INT NOT NULL,
    id_customer INT NOT NULL,
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    pending_balance DECIMAL(10,2),
    status ENUM('Completada', 'Pendiente', 'Anulada') NOT NULL,-- estado de la venta
    FOREIGN KEY (id_customer) REFERENCES users(id_username),
    FOREIGN KEY (id_vehicle) REFERENCES vehicles(id_vehicle)
);


-- Crear tabla para solicitudes de soporte (chat, citas y pruebas de manejo)
CREATE TABLE support_requests (
    id_supportRequests INT AUTO_INCREMENT PRIMARY KEY, 
    id_customer INT NOT NULL,
    type ENUM('Chat', 'Cita', 'Prueba') NOT NULL, -- Tipo de solicitud (chat, cita, prueba)
    details TEXT NOT NULL,     
    status ENUM('Pendiente', 'Resuelto') DEFAULT 'Pendiente', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY ( id_customer) REFERENCES users(id_username) ON DELETE CASCADE
);


-- Módulo de ventas
CREATE TABLE quotes (
    id_quote INT AUTO_INCREMENT PRIMARY KEY,
    id_customer INT,
    id_vehicle INT,
    estimated_price DECIMAL(10,2) NOT NULL,
    term VARCHAR(2) NOT NULL,  -- en meses para el financiamento
    interest DECIMAL(5,2) DEFAULT 0.00,  -- interes basado el el term
    quote_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    applied_discount DECIMAL(10,2),
    FOREIGN KEY (id_customer) REFERENCES users(id_username),
    FOREIGN KEY (id_vehicle) REFERENCES vehicles(id_vehicle)
);


CREATE TABLE refounds (
    id_refound INT PRIMARY KEY AUTO_INCREMENT,
    id_sales INT,
    id_username INT,  -- ID del usuario que pide la devolución
    reason TEXT NOT NULL,
    status ENUM('Pendiente', 'Aprobada', 'Rechazada') NOT NULL,
    return_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_sales) REFERENCES sales(id_sales),
    FOREIGN KEY (id_username) REFERENCES users(id_username)
);


CREATE TABLE invoices (
    id_invoice INT PRIMARY KEY AUTO_INCREMENT,
    id_sales INT,
    issue_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_sales) REFERENCES sales(id_sales)
);


CREATE TABLE payments (
    id_payment INT PRIMARY KEY AUTO_INCREMENT,
    id_sales INT,
    payment_method ENUM('Tarjeta', 'Efectivo', 'Financiamiento') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    months INT DEFAULT NULL,  -- si es financiamiento, número de meses a pagar
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    pending_balance DECIMAL(10,2),
    FOREIGN KEY (id_sales) REFERENCES sales(id_sales)
);


CREATE TABLE promotions (
    id_promotion INT PRIMARY KEY AUTO_INCREMENT,
    id_vehicle INT,
    description TEXT NOT NULL,
    discount DECIMAL(5,2) NOT NULL,  -- -- Descuento aplicado al vehicle
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (id_vehicle) REFERENCES vehicles(id_vehicle)
);


CREATE TABLE sales_Reports (
    id_report INT PRIMARY KEY AUTO_INCREMENT,
    report_date DATE NOT NULL,
    total_sales DECIMAL(10,2) NOT NULL,
    sales_count INT NOT NULL,
    id_sales INT,
    FOREIGN KEY (id_sales) REFERENCES sales(id_sales)
);


CREATE TABLE reservations (
    id_reservation INT PRIMARY KEY AUTO_INCREMENT,
    id_customer INT,
    id_vehicle INT,
    reservation_amount DECIMAL(10,2) NOT NULL,  -- Monto pagado por la reserva
    reservation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Reservado', 'Disponible') NOT NULL,
    FOREIGN KEY (id_customer) REFERENCES users(id_username),
    FOREIGN KEY (id_vehicle) REFERENCES vehicles(id_vehicle)
);
 
 
 CREATE TABLE headquarters_change (
    id_headquartersChange INT AUTO_INCREMENT PRIMARY KEY,  -- ID único para cada vehículo
    brand VARCHAR(50) NOT NULL,  -- Marca del vehículo
    model VARCHAR(50) NOT NULL,  -- Modelo del vehículo
    change_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    headquarters_change VARCHAR(40) NOT NULL,
    status_change ENUM('Llegó') DEFAULT 'Llegó'
);


CREATE TABLE offers (
	id_offer INT AUTO_INCREMENT PRIMARY KEY, 
    vehicles_id_offer INT NOT NULL,
    status_vehicle VARCHAR(10) NOT NULL,
    vehicle_offer VARCHAR (50) NOT NULL, 
    price_offer DECIMAL (10,2) NOT NULL,
    img_vehicle_offer VARCHAR (255) NOT NULL,
    km_vehicle DECIMAL (10,3) NOT NULL,
    type_vehicle VARCHAR (10) NOT NULL,
    traction_vehicle VARCHAR(3) NOT NULL,
    motor_vehicle VARCHAR (8) NOT NULL
);


CREATE TABLE cart (
    id_cart INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    offer_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_name) REFERENCES users(username) ON DELETE CASCADE,
    FOREIGN KEY (offer_id) REFERENCES offers(id_offer) ON DELETE CASCADE
);


CREATE TABLE card_payment (
    id_paymentMethod INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name_cardholder VARCHAR(50) NOT NULL,
    lastname_cardholder VARCHAR(50) NOT NULL,
    email_cardholder VARCHAR (50) NOT NULL,
    card_type VARCHAR (16) NOT NULL,
    number_card VARCHAR(16) NOT NULL CHECK (number_card REGEXP '^[0-9]{16}$'),
	pin_card int (3) not null,
    expiration_month TINYINT NOT NULL CHECK (expiration_month BETWEEN 1 AND 12),
    expiration_year YEAR NOT NULL
);


CREATE TABLE test_drive_requests (
    id_testDriveRequests INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    scheduled_datetime DATETIME NOT NULL,
    status ENUM('Pendiente', 'Confirmado', 'Cancelado') DEFAULT 'Pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_scheduled_datetime (scheduled_datetime),
    FOREIGN KEY (user_id) REFERENCES users(id_username) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id_vehicle) ON DELETE CASCADE
);

/*******************************************************************************
 * 
 *  Inserts para las tablas de la base de datos
 * 
 ******************************************************************************/

INSERT INTO users (username, email, password, id_card, role) VALUES
('admin1', 'admin1@example.com', 'admin123', 'IDADMIN1', 'Administrador'),
('cliente1', 'cliente1@example.com', 'cliente123', 'IDCLIENTE1', 'Cliente'),
('cliente2', 'cliente2@example.com', 'cliente456', 'IDCLIENTE2', 'Cliente');


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


INSERT INTO vehicles (brand, model, price, status, headquarters) VALUES
('Toyota', 'Corolla', 20000.00, 'Disponible', 'Sede Central - San Pablo, Heredia'),
('Ford', 'Focus', 18000.00, 'Disponible', 'Sede Central - San Pablo, Heredia'),
('Honda', 'Civic', 22000.00, 'Reservado', 'Sede Secundaria - San Joaquín, Heredia');


-- Insertar solicitudes de soporte de prueba
INSERT INTO support_requests (id_customer, type, details, status) VALUES
(2, 'Chat', 'Tengo preguntas sobre el Toyota Prado TX 2017.', 'Pendiente'),  -- Cliente 2 solicita chat
(3, 'Cita', 'Quiero agendar una cita para ver el Suzuki Vitara 2023.', 'Pendiente'), -- Cliente 3 solicita cita
(2, 'Prueba', 'Solicito prueba de manejo del Hyundai Tucson 2017.', 'Resuelto'),
(2, 'Prueba', 'Solicito prueba de manejo del Toyota Hilux 2019.', 'Pendiente');  -- Cliente 2 solicita prueba de manejo


/*INSERT INTO quotes (vehicle_id, price_final, financing_options, email) VALUES 
(2, 17500.00, '12 meses sin intereses', 'cliente@example.com');*/


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
    (15, 'Toyota Hilux 2019', 'Semi Nuevo', 36500.00, 'Toyota Hilux 2019.jpg', 10.400, 'Manual', '4X4', 2.400);


 INSERT INTO cart (user_name, offer_id, quantity) VALUES
 ('cliente1', 1, 2);

/*******************************************************************************
 * 
 *  Selects de las tablas de la base de datos
 * 
 ******************************************************************************/

select * from users;
select * from vehicles;
select * from sales;
select * from support_requests;
select * from quotes;
select * from offers;
select * from cart;
select * from test_drive_requests;

/*******************************************************************************
 * 
 *  Procedimientos almacenados
 * 
 ******************************************************************************/

-- SP VEHICLES
DELIMITER $$
CREATE PROCEDURE sp_register_vehicle(
    IN p_brand VARCHAR(50),
    IN p_model VARCHAR(50),
    IN p_price DECIMAL(10, 2),
    IN p_status ENUM('Disponible', 'Reservado'),
    IN p_image_path VARCHAR(255)
)
BEGIN
    INSERT INTO vehicles (brand, model, price, status, image_path)
    VALUES (p_brand, p_model, p_price, p_status, p_image_path);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_get_vehicle(
    IN p_vehicle_id INT
)
BEGIN
    SELECT id_vehicle AS id, brand, model, price, status, image_path
    FROM vehicles
    WHERE id_vehicle = p_vehicle_id;
END $$
DELIMITER ;


-- SP CLIENTES
DELIMITER $$
CREATE PROCEDURE sp_list_customers()
BEGIN
    SELECT id_username AS id, username 
    FROM users 
    WHERE role = 'Cliente';
END $$
DELIMITER ;


-- SP OFFERS
DELIMITER $$
CREATE PROCEDURE sp_get_offer(
    IN p_offer_id INT
)
BEGIN
    SELECT id_offer, vehicles_id_offer, vehicle_offer, price_offer, img_vehicle_offer
    FROM offers
    WHERE id_offer = p_offer_id;
END $$
DELIMITER ;


-- SP COTIZACIONES
DELIMITER $$
CREATE PROCEDURE sp_register_quote(
    IN p_id_customer INT,
    IN p_id_vehicle INT,
    IN p_estimated_price DECIMAL(10,2),
    IN p_term VARCHAR(2),
    IN p_interest DECIMAL(5,2),
    IN p_applied_discount DECIMAL(10,2)
)
BEGIN
    INSERT INTO quotes (id_customer, id_vehicle, estimated_price, term, interest, applied_discount)
    VALUES (p_id_customer, p_id_vehicle, p_estimated_price, p_term, p_interest, p_applied_discount);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_quotes()
BEGIN
    SELECT 
        q.id_quote, 
        u.username AS customer, 
        v.model AS vehicle, 
        q.estimated_price, 
        q.term, 
        q.interest, 
        q.applied_discount, 
        q.quote_date
    FROM quotes q
    JOIN users u ON q.id_customer = u.id_username
    JOIN vehicles v ON q.id_vehicle = v.id_vehicle;
END $$
DELIMITER ;


-- SP SALES
DELIMITER $$
CREATE PROCEDURE sp_register_sale(
    IN p_id_customer INT,
    IN p_id_vehicle INT,
    IN p_total DECIMAL(10,2),
    IN p_pending_balance DECIMAL(10,2),
    IN p_status ENUM('Completada', 'Pendiente', 'Anulada')
)
BEGIN
    -- Insertar venta
    INSERT INTO sales (id_customer, id_vehicle, total, pending_balance, status)
    VALUES (p_id_customer, p_id_vehicle, p_total, p_pending_balance, p_status);
    
    -- Si la venta está completada, actualizar el estado del vehículo a 'Vendido'
    IF p_status = 'Completada' THEN
        UPDATE vehicles
        SET status = 'Vendido'
        WHERE id_vehicle = p_id_vehicle;
    END IF;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_sales()
BEGIN
    SELECT 
        s.id_sales, 
        u.username AS customer, 
        v.brand, 
        v.model, 
        s.total, 
        s.pending_balance, 
        s.status, 
        s.sale_date
    FROM sales s
    JOIN users u ON s.id_customer = u.id_username
    JOIN vehicles v ON s.id_vehicle = v.id_vehicle;
END $$
DELIMITER ;


-- SP DEVOLUCIONES
DELIMITER $$
CREATE PROCEDURE sp_register_refund(
    IN p_id_sale INT,
    IN p_id_user INT,
    IN p_reason TEXT,
    IN p_status ENUM('Pendiente', 'Aprobada', 'Rechazada')
)
BEGIN
    INSERT INTO refounds (id_sales, id_username, reason, status)
    VALUES (p_id_sale, p_id_user, p_reason, p_status);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_refunds()
BEGIN
    SELECT 
        r.id_refound, 
        s.id_sales, 
        u.username AS customer, 
        r.reason, 
        r.status, 
        r.return_date
    FROM refounds r
    JOIN sales s ON r.id_sales = s.id_sales
    JOIN users u ON r.id_username = u.id_username;
END $$
DELIMITER ;



-- SP FACTURAS
DELIMITER $$
CREATE PROCEDURE sp_register_invoice(
    IN p_id_sale INT,
    IN p_total DECIMAL(10,2)
)
BEGIN
    INSERT INTO invoices (id_sales, total)
    VALUES (p_id_sale, p_total);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_invoices()
BEGIN
    SELECT * FROM invoices;
END $$
DELIMITER ;


-- SP PAGOS
DELIMITER $$
CREATE PROCEDURE sp_register_payment(
    IN p_id_sale INT,
    IN p_payment_method ENUM('Tarjeta', 'Efectivo', 'Financiamiento'),
    IN p_amount DECIMAL(10,2),
    IN p_months INT,
    IN p_pending_balance DECIMAL(10,2)
)
BEGIN
    INSERT INTO payments (id_sales, payment_method, amount, months, pending_balance)
    VALUES (p_id_sale, p_payment_method, p_amount, p_months, p_pending_balance);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_payments()
BEGIN
    SELECT * FROM payments;
END $$
DELIMITER ;


-- SP PROMOCIONES
DELIMITER $$
CREATE PROCEDURE sp_register_promotion(
    IN p_id_vehicle INT,
    IN p_description TEXT,
    IN p_discount DECIMAL(5,2),
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    INSERT INTO promotions (id_vehicle, description, discount, start_date, end_date) 
    VALUES (p_id_vehicle, p_description, p_discount, p_start_date, p_end_date);
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_promotions()
BEGIN
    SELECT 
        p.id_promotion, 
        p.id_vehicle, 
        v.brand, 
        v.model, 
        p.description, 
        p.discount, 
        p.start_date, 
        p.end_date
    FROM promotions p
    JOIN vehicles v ON p.id_vehicle = v.id_vehicle;
END $$
DELIMITER ;


-- SP RESERVAS
DELIMITER $$
CREATE PROCEDURE sp_register_reservation(
    IN p_id_customer INT,
    IN p_id_vehicle INT,
    IN p_reservation_amount DECIMAL(10,2),
    IN p_status ENUM('Reservado', 'Disponible')
)
BEGIN
    INSERT INTO reservations (id_customer, id_vehicle, reservation_amount, status) 
    VALUES (p_id_customer, p_id_vehicle, p_reservation_amount, p_status);
    
    -- Actualizar el estado del vehículo a 'Reservado'
    IF p_status = 'Reservado' THEN
        UPDATE vehicles
        SET status = 'Reservado'
        WHERE id_vehicle = p_id_vehicle;
    END IF;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_show_reservations()
BEGIN
    SELECT 
        r.id_reservation, 
        u.username AS customer, 
        v.brand, 
        v.model, 
        r.reservation_amount, 
        r.reservation_date, 
        r.status
    FROM reservations r
    JOIN users u ON r.id_customer = u.id_username
    JOIN vehicles v ON r.id_vehicle = v.id_vehicle;
END $$
DELIMITER ;


-- SP REPORTE VENTAS
DELIMITER $$
CREATE PROCEDURE sp_generate_sales_report()
BEGIN
    INSERT INTO sales_Reports (report_date, total_sales, sales_count, id_sales)
    SELECT CURDATE(), SUM(total), COUNT(*), s.id_sales
    FROM sales s
    WHERE s.sale_date >= CURDATE() - INTERVAL 1 MONTH -- Se puede agustar el intervalo según lo que se necesite
    GROUP BY s.id_sales;
END $$
DELIMITER ;


-- SP REGISTRAR SOPORTE
DELIMITER $$
CREATE PROCEDURE sp_register_support_request(
    IN p_customer_id INT,
    IN p_type ENUM('Chat', 'Cita', 'Prueba'),
    IN p_details TEXT
)
BEGIN
    INSERT INTO support_requests (id_customer, type, details, status)
    VALUES (p_customer_id, p_type, p_details, 'Pendiente');
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_update_support_status(
    IN p_request_id INT,
    IN p_status ENUM('Pendiente', 'Resuelto')
)
BEGIN
    UPDATE support_requests
    SET status = p_status
    WHERE id_supportRequests = p_request_id;
END $$
DELIMITER ;


-- SP CARRITO
DELIMITER $$
CREATE PROCEDURE sp_add_to_cart(
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
CREATE PROCEDURE sp_show_cart(IN p_user_name VARCHAR(50))
BEGIN
    SELECT 
        c.id_cart AS cart_id,
        c.user_name,
        c.offer_id,
        o.vehicle_offer,
        o.price_offer,
        c.quantity,
        (o.price_offer * c.quantity) AS total_price,
        o.img_vehicle_offer,
        c.added_at
    FROM cart c
    JOIN offers o ON c.offer_id = o.id_offer
    WHERE c.user_name = p_user_name;
END $$
DELIMITER ;


-- SP PRUEBA DE MANEJO
DELIMITER $$
CREATE PROCEDURE sp_register_test_drive(
    IN p_user_id INT,
    IN p_vehicle_id INT,
    IN p_scheduled_datetime DATETIME
)
BEGIN
    INSERT INTO test_drive_requests (user_id, vehicle_id, scheduled_datetime)
    VALUES (p_user_id, p_vehicle_id, p_scheduled_datetime);
END $$
DELIMITER ;

-- SP REGISTRO  


DELIMITER //
CREATE PROCEDURE sp_register_user(
    IN p_username VARCHAR(50),
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_phone VARCHAR(15),
    IN p_location TEXT,
    IN p_id_card VARCHAR(20),
    IN p_role VARCHAR(20) -- <-- Cambio aquí
)
BEGIN
    INSERT INTO users (username, email, password, phone, location, id_card, role)
    VALUES (p_username, p_email, p_password, p_phone, p_location, p_id_card, p_role);
END;
//
DELIMITER ;

/*******************************************************************************
 * 
 *  ALTER TABLES necesarios
 * 
 ******************************************************************************/
