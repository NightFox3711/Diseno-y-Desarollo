<?php
require_once "Database.php";

class VentasModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::AbrirBaseDatos();
    }

public function listarVentas() {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT 
                s.id AS sale_id, 
                s.total, 
                s.payment_method, 
                s.months AS months_financing, 
                s.interest AS interest_rate, 
                s.status AS financing_status, 
                v.brand AS vehicle_brand, 
                v.model AS vehicle_model, 
                u.username AS customer_username, 
                s.added_at 
            FROM sales s
            JOIN vehicles v ON s.vehicle_id = v.id
            JOIN users u ON s.user_id = u.id";

        $result = $conexion->query($sql);

        if (!$result) {
            die('Error en la consulta SQL: ' . $conexion->error);
        }

        $ventas = [];
        while ($fila = $result->fetch_assoc()) {
            $ventas[] = $fila;
        }

    Database::CerrarBaseDatos($this->conexion);
    return $ventas;
}


    public function registrarCotizacion($id_cliente, $id_vehiculo, $precio_estimado, $plazo, $interes, $descuento_aplicado){
    {
        try {
            $query = "CALL sp_registrar_cotizacion(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("iidsss", $id_cliente, $id_vehiculo, $precio_estimado, $plazo, $interes, $descuento_aplicado);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            Database::CerrarBaseDatos($this->conexion);
        }
    }
}

    function obtenerCotizaciones()
    {
        try {
            $query = "CALL sp_mostrar_cotizaciones()";
            $result = $this->conexion->query($query);
            $cotizaciones = [];

            while ($row = $result->fetch_assoc()) {
                $cotizaciones[] = $row;
            }
            return $cotizaciones;
        } catch (Exception $e) {
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
}


function registrarVenta($vehicle_id, $user_id, $payment_method, $total, $months = null, $interest = null) {
    $conexion = Database::AbrirBaseDatos();

    $months = ($months !== null && $months !== '') ? $months : null;
    $interest = ($interest !== null && $interest !== '') ? $interest : null;

    $stmt = $conexion->prepare("CALL sp_registrar_venta(?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("iisddi", $vehicle_id, $user_id, $payment_method, $total, $months, $interest);

    $resultado = $stmt->execute();

    if (!$resultado) {
        die("Error en la ejecución: " . $stmt->error);
    }

    $stmt->close();
    Database::CerrarBaseDatos($this->conexion);

    return $resultado;
}

function listarVehiculosDisponibles() {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT id, brand, model FROM vehicles WHERE status = 'disponible'";
    $result = $conexion->query($sql);
    $vehiculos = [];
    while ($fila = $result->fetch_assoc()) {
        $vehiculos[] = $fila;
    }
    Database::CerrarBaseDatos($this->conexion);
    return $vehiculos;
}


function listarClientes() {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT id, username FROM users WHERE role = 'cliente'";
    $result = $conexion->query($sql);
    $clientes = [];
    while ($fila = $result->fetch_assoc()) {
        $clientes[] = $fila;
    }
    Database::CerrarBaseDatos($this->conexion);
    return $clientes;
}

    //Función para mostrar todas las ventas
    function obtenerVentas()
    {
        $conexion = Database::AbrirBaseDatos();
        $query = "CALL sp_mostrar_ventas()";
        $result = $conexion->query($query);

        $ventas = [];
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row;
        }

        Database::CerrarBaseDatos($this->conexion);
        return $ventas;
    }


// Registrar una devolución
    function registrarDevolucion($id_venta, $id_usuario, $motivo, $estado)
    {
        try {
            $query = "CALL sp_registrar_devoluciones(?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("iiss", $id_venta, $id_usuario, $motivo, $estado);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    // Obtener las devoluciones
    function obtenerDevoluciones()
    {
        try {
            $query = "CALL sp_Mostrar_devoluciones()";
            $result = $this->conexion->query($query);
            $devoluciones = [];

            while ($row = $result->fetch_assoc()) {
                $devoluciones[] = $row;
            }
            return $devoluciones;
        } catch (Exception $e) {
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    // Ajuste para la parte de facturación

    function registrarFactura($id_venta, $total)
    {
        try {
            $query = "CALL sp_registrar_factura(?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("id", $id_venta, $total);
            $resultado = $stmt->execute();
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            $stmt->close();
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function obtenerFacturas()
    {
        try {
            $query = "CALL sp_mostrar_facturas()";
            $result = $this->conexion->query($query);
            $facturas = [];
            while ($fila = $result->fetch_assoc()) {
                $facturas[] = $fila;
            }
            return $facturas;
        } catch (Exception $e) {
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function registrarPago($id_venta, $metodo_pago, $monto, $meses, $saldo_pendiente)
    {
        try {
            $query = "CALL sp_registrar_pago(?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("isdid", $id_venta, $metodo_pago, $monto, $meses, $saldo_pendiente);
            $resultado = $stmt->execute();
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            $stmt->close();
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    // Función para obtener los pagos registrados
    // Función para obtener todos los pagos registrados
    function obtenerPagos()
    {
        try {
            // Consulta para obtener todos los pagos
            $query = "CALL sp_mostrar_pago()";  // El procedimiento almacenado no necesita parámetros
            $result = $this->conexion->query($query); // Se ejecuta la consulta

            if ($result === false) {
                throw new Exception("Error al ejecutar la consulta");
            }

            $pagos = [];

            // Recorrer los resultados y almacenarlos en el array
            while ($fila = $result->fetch_assoc()) {
                $pagos[] = $fila;
            }

            return $pagos;
        } catch (Exception $e) {
            // En caso de error, se puede registrar el error para depuración
            return [];
        }

    }

    function registrarPromocion($id_vehiculo, $descripcion, $descuento, $fecha_inicio, $fecha_fin)
    {
        try {
            $query = "CALL sp_registrar_promociones(?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("isdss", $id_vehiculo, $descripcion, $descuento, $fecha_inicio, $fecha_fin);
            $resultado = $stmt->execute();
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            $stmt->close();
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function obtenerPromociones()
    {
        try {
            $query = "CALL sp_mostrar_promociones()";
            $result = $this->conexion->query($query);
            $promociones = [];
            while ($fila = $result->fetch_assoc()) {
                $promociones[] = $fila;
            }
            return $promociones;
        } catch (Exception $e) {
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function registrarReserva($id_cliente, $id_vehiculo, $monto_reserva, $estado)
    {
        try {
            $query = "CALL sp_registrar_reserva(?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }

            $stmt->bind_param("iids", $id_cliente, $id_vehiculo, $monto_reserva, $estado);

            $resultado = $stmt->execute();

            $stmt->close();
            return $resultado;
        } catch (Exception $e) {
            error_log("Error en registrarReserva: " . $e->getMessage());
            return false;
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function obtenerReservas()
    {
        try {
            $query = "CALL sp_mostrar_reservas()";
            $result = $this->conexion->query($query);

            if (!$result) {
                throw new Exception("Error al ejecutar la consulta: " . $this->conexion->error);
            }

            $reservas = [];
            while ($fila = $result->fetch_assoc()) {
                $reservas[] = $fila;
            }

            return $reservas;
        } catch (Exception $e) {
            error_log("Error en obtenerReservas: " . $e->getMessage());
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }


    function generarReporteVentas()
    {
        $query = "CALL sp_generar_reporte_ventas()";
        $resultado = $this->conexion->query($query);
        
        if (!$resultado) {
            die("Error al generar el reporte: " . $this->conexion->error);
        }

        return $resultado;
    }

    
    function obtenerReportes()
    {
        $query = "SELECT * FROM Reportes_Ventas";
        $result = $this->conexion->query($query);

        $reportes = [];
        while ($row = $result->fetch_assoc()) {
            $reportes[] = $row;
        }

        return $reportes;
    }
}
?>