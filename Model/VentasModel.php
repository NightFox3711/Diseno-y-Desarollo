<?php
require_once "Database.php"; // Archivo de conexión a la BD

class VentasModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = AbrirBaseDatos();
    }

    public function registrarCotizacion($id_cliente, $id_vehiculo, $precio_estimado, $plazo, $interes, $descuento_aplicado)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    public function obtenerCotizaciones()
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
            CerrarBaseDatos($this->conexion);
        }
    }

    
    public function registrarVenta($id_cliente, $id_vehiculo, $total, $saldo_pendiente, $estado)
    {
        $conexion = AbrirBaseDatos();
        $query = "CALL sp_registrar_venta(?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);

        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }

        $stmt->bind_param("iidds", $id_cliente, $id_vehiculo, $total, $saldo_pendiente, $estado);
        $resultado = $stmt->execute();

        if (!$resultado) {
            die("Error en la ejecución: " . $stmt->error);
        }

        $stmt->close();
        CerrarBaseDatos($conexion);
        return $resultado;
    }


    // Función para mostrar todas las ventas
    public function obtenerVentas()
    {
        $conexion = AbrirBaseDatos();
        $query = "CALL sp_mostrar_ventas()";
        $result = $conexion->query($query);

        $ventas = [];
        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row;
        }

        CerrarBaseDatos($conexion);
        return $ventas;
    }


// Registrar una devolución
    public function registrarDevolucion($id_venta, $id_usuario, $motivo, $estado)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    // Obtener las devoluciones
    public function obtenerDevoluciones()
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
            CerrarBaseDatos($this->conexion);
        }
    }

    // Ajuste para la parte de facturación

    public function registrarFactura($id_venta, $total)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    public function obtenerFacturas()
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
            CerrarBaseDatos($this->conexion);
        }
    }

    public function registrarPago($id_venta, $metodo_pago, $monto, $meses, $saldo_pendiente)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    // Función para obtener los pagos registrados
    // Función para obtener todos los pagos registrados
    public function obtenerPagos()
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

    public function registrarPromocion($id_vehiculo, $descripcion, $descuento, $fecha_inicio, $fecha_fin)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    public function obtenerPromociones()
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
            CerrarBaseDatos($this->conexion);
        }
    }



    public function registrarReserva($id_cliente, $id_vehiculo, $monto_reserva, $estado)
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
            CerrarBaseDatos($this->conexion);
        }
    }

    public function obtenerReservas()
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
            CerrarBaseDatos($this->conexion);
        }
    }


    public function generarReporteVentas()
    {
        $query = "CALL sp_generar_reporte_ventas()";
        $resultado = $this->conexion->query($query);
        
        if (!$resultado) {
            die("Error al generar el reporte: " . $this->conexion->error);
        }

        return $resultado;
    }

    
    public function obtenerReportes()
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

