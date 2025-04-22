<?php
require_once "Database.php";

class VentasModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::AbrirBaseDatos();
    }

    public function listarVentas()
    {
        $conexion = Database::AbrirBaseDatos();
        $sql = "SELECT 
                s.id AS id_sales, 
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
            JOIN vehicles v ON s.id_vehicle = v.id
            JOIN users u ON s.id_username = u.id";

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


    public function registrarCotizacion($id_customer, $id_vehicle, $estimated_price, $term, $interest, $applied_discount)
    {
        try {
            $query = "CALL sp_register_quote(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("iidsss", $id_customer, $id_vehicle, $estimated_price, $term, $interest, $applied_discount);
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

    function obtenerCotizaciones()
    {
        try {
            $query = "CALL sp_show_quotes()";
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



    public function registrarVenta($id_customer, $id_vehicle, $total, $pending_balance, $status)//puede dar error
    {
        $conexion = Database::AbrirBaseDatos();

      
        $stmt = $conexion->prepare("CALL sp_register_sale(?, ?, ?, ?, ?)");

        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }

        $stmt->bind_param("iidds", $id_customer, $id_vehicle, $total, $pending_balance, $status);

        $resultado = $stmt->execute();

        if (!$resultado) {
            die("Error en la ejecución: " . $stmt->error);
        }

        $stmt->close();
        Database::CerrarBaseDatos($conexion);

        return $resultado;
    }


    function listarVehiculosDisponibles()
    {
        $conexion = Database::AbrirBaseDatos();
        $sql = "SELECT id_vehicle, brand, model FROM vehicles WHERE status = 'Disponible'";
        $result = $conexion->query($sql);
        $vehiculos = [];

        while ($fila = $result->fetch_assoc()) {
            $vehiculos[] = $fila;
        }

        Database::CerrarBaseDatos($conexion);
        return $vehiculos;
    }


    function listarClientes()
    {
        $conexion = Database::AbrirBaseDatos();
        $sql = "CALL sp_list_customers()";
        $result = $conexion->query($sql);
        $clientes = [];

        while ($fila = $result->fetch_assoc()) {
            $clientes[] = $fila;
        }

        Database::CerrarBaseDatos($conexion);
        return $clientes;
    }


    //Función para mostrar todas las ventas
    function obtenerVentas()
    {
        $conexion = Database::AbrirBaseDatos();
        $query = "CALL sp_show_sales()";
        $result = $conexion->query($query);

        $ventas = [];
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row;
        }

        Database::CerrarBaseDatos($conexion);
        return $ventas;
    }


    // Registrar una devolución
    function registrarDevolucion($id_sales, $id_username, $reason, $status)
    {
        try {
            $query = "CALL sp_register_refund(?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("iiss", $id_sales, $id_username, $reason, $status);
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
            $query = "CALL sp_show_refunds()";
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

    function registrarFactura($id_invoice, $total)
    {
        try {
            $query = "CALL sp_register_invoice(?, ?)"; // Procedimiento corregido
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("id", $id_invoice, $total); // id_venta = id_sale
            $resultado = $stmt->execute();
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            Database::CerrarBaseDatos($this->conexion);
        }
    }

    function obtenerFacturas()
    {
        try {
            $query = "CALL sp_show_invoices()"; // Nombre correcto del procedimiento
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


    function registrarPago($id_sales, $payment_method, $amount, $months, $pending_balance)
    {
        try {
            $query = "CALL sp_register_payment(?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("isdid", $id_sales, $payment_method, $amount, $months, $pending_balance);
            $result = $stmt->execute();
            return $result;
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
            $query = "CALL sp_show_payments()";  // El procedimiento almacenado no necesita parámetros
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
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }


    function registrarPromocion($id_vehicle, $description, $discount, $start_date, $end_date)
    {
        try {
            $query = "CALL sp_register_promotion(?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("isdss", $id_vehicle, $description, $discount, $start_date, $end_date);
            $resultado = $stmt->execute();
            return $resultado;
        } catch (Exception $e) {
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            Database::CerrarBaseDatos($this->conexion);
        }
    }


    function obtenerPromociones()
    {
        try {
            $query = "CALL sp_show_promotions()"; // Nombre correcto del procedimiento
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


    function registrarReserva($id_customer, $id_vehicle, $reservation_amount, $status)
    {
        try {
            $query = "CALL sp_register_reservation(?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }

            $stmt->bind_param("iids", $id_customer, $id_vehicle, $reservation_amount, $status);

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
            $query = "CALL sp_show_reservations()"; // ← Nombre correcto
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
        try {
            $query = "CALL sp_generate_sales_report()"; // Procedimiento en inglés
            $resultado = $this->conexion->query($query);

            if (!$resultado) {
                throw new Exception("Error al generar el reporte: " . $this->conexion->error);
            }

            return $resultado;
        } catch (Exception $e) {
            error_log("Error en generarReporteVentas: " . $e->getMessage());
            return false;
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }



    function obtenerReportes()
    {
        try {
            $query = "CALL sp_show_sales_reports()";  // Llamada al procedimiento en la DB
            $result = $this->conexion->query($query);

            if (!$result) {
                throw new Exception("Error al ejecutar la consulta: " . $this->conexion->error);
            }

            $reportes = [];
            while ($row = $result->fetch_assoc()) {
                $reportes[] = $row;
            }

            return $reportes;
        } catch (Exception $e) {
            error_log("Error en obtenerReportes: " . $e->getMessage());
            return [];
        } finally {
            Database::CerrarBaseDatos($this->conexion);
        }
    }
}
?>