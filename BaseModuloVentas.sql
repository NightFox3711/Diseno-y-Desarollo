Create database scmotors371

use scmotors371


CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(15),
    direccion TEXT,
    cedula VARCHAR(20) UNIQUE NOT NULL,
    rol ENUM('Admin', 'Cliente') NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE Vehiculos (
    id_vehiculo INT PRIMARY KEY AUTO_INCREMENT,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    año INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado ENUM('Disponible', 'Reservado', 'Vendido') NOT NULL,  -- Estado del vehículo
    imagen VARCHAR(255)  -- URL o nombre de la imagen
);




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


INSERT INTO Vehiculos (marca, modelo, año, precio, estado, imagen) VALUES
('Kawasaki', 'Ninja H2R', 2023, 55000.00, 'Disponible', 'imagenes/ninja_h2r.jpg'),
('Yamaha', 'YZF-R6', 2022, 14500.00, 'Disponible', 'imagenes/yzf_r6.jpg'),
('Honda', 'CBR1000RR-R Fireblade', 2023, 28500.00, 'Disponible', 'imagenes/cbr1000rr.jpg'),
('Ducati', 'Panigale V4', 2023, 28000.00, 'Disponible', 'imagenes/panigale_v4.jpg'),
('Suzuki', 'GSX-R1000', 2022, 17000.00, 'Disponible', 'imagenes/gsx_r1000.jpg'),
('BMW', 'S1000RR', 2023, 22500.00, 'Disponible', 'imagenes/s1000rr.jpg'),
('Aprilia', 'RSV4 Factory', 2023, 24900.00, 'Disponible', 'imagenes/rsv4.jpg'),
('MV Agusta', 'F4 RC', 2022, 42000.00, 'Reservado', 'imagenes/f4_rc.jpg'),
('Triumph', 'Daytona Moto2 765', 2023, 18000.00, 'Disponible', 'imagenes/daytona_moto2.jpg'),
('KTM', 'RC 8C', 2023, 39000.00, 'Vendido', 'imagenes/rc_8c.jpg');


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


select * from usuarios;
select * from vehiculos;
select * from Cotizaciones;
select * from Ventas;
select * from Devoluciones;
select * from pagos; 
Select *from facturas;
Select * from promociones;
select * From reservas;
select * From reportes_ventas;


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


