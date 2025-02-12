<?php
include_once 'Database.php';

function sp_generar_cotizacion($vehicle_id) {
    $conexion = AbrirBaseDatos();
    $vehicle_id = $conexion->real_escape_string($vehicle_id);
    $sql = "CALL sp_generar_cotizacion($vehicle_id)";
    $result = $conexion->query($sql);
    if (!$result) {
        CerrarBaseDatos($conexion);
        return false;
    }
    $quote = $result->fetch_assoc();
    $result->close();
    CerrarBaseDatos($conexion);
    return $quote;
}

function sp_enviar_cotizacion($quote_id, $client_id) {
    $conexion = AbrirBaseDatos();
    $quote_id = $conexion->real_escape_string($quote_id);
    $client_id = $conexion->real_escape_string($client_id);
    $sql = "CALL sp_enviar_cotizacion($quote_id, $client_id)";
    $result = $conexion->query($sql);
    CerrarBaseDatos($conexion);
    return $result;
}

function sp_listar_quotes_pendientes() {
    $conexion = AbrirBaseDatos();
    $sql = "CALL sp_listar_quotes_pendientes()";
    $result = $conexion->query($sql);
    $quotes = array();
    if ($result) {
        while ($fila = $result->fetch_assoc()) {
            $quotes[] = $fila;
        }
        $result->close();
    }
    CerrarBaseDatos($conexion);
    return $quotes;
}

function sp_registrar_cuota($quote_id, $monto, $fecha_vencimiento) {
    $conexion = AbrirBaseDatos();
    $quote_id = $conexion->real_escape_string($quote_id);
    $monto = $conexion->real_escape_string($monto);
    $fecha_vencimiento = $conexion->real_escape_string($fecha_vencimiento);
    $sql = "CALL sp_registrar_cuota($quote_id, $monto, '$fecha_vencimiento')";
    $result = $conexion->query($sql);
    if (!$result) {
        CerrarBaseDatos($conexion);
        return false;
    }
    $cuota = $result->fetch_assoc();
    $result->close();
    CerrarBaseDatos($conexion);
    return $cuota;
}

function sp_obtener_cuotas($quote_id) {
    $conexion = AbrirBaseDatos();
    $quote_id = $conexion->real_escape_string($quote_id);
    $sql = "CALL sp_obtener_cuotas($quote_id)";
    $result = $conexion->query($sql);
    $cuotas = array();
    if ($result) {
        while ($fila = $result->fetch_assoc()) {
            $cuotas[] = $fila;
        }
        $result->close();
    }
    CerrarBaseDatos($conexion);
    return $cuotas;
}

function sp_listar_clientes() {
    $conexion = AbrirBaseDatos();
    $sql = "SELECT id, username FROM users WHERE role = 'cliente'";
    $result = $conexion->query($sql);
    $clientes = array();
    if ($result) {
        while ($fila = $result->fetch_assoc()) {
            $clientes[] = $fila;
        }
        $result->close();
    }
    CerrarBaseDatos($conexion);
    return $clientes;
}

function sp_listar_vehiculos() {
    $conexion = AbrirBaseDatos();
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $sql = "SELECT * FROM vehicles";
    $result = $conexion->query($sql);
    $vehiculos = array();
    if ($result) {
        while ($fila = $result->fetch_assoc()) {
            $vehiculos[] = $fila;
        }
        $result->close();
    }
    CerrarBaseDatos($conexion);
    return $vehiculos;
}
?>
