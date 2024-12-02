<?php
include_once 'Database.php';

// Listar todas las ventas
function listarVentas() {
    $conexion = AbrirBaseDatos();
    $sql = "SELECT s.id AS sale_id, s.total, s.payment_method, v.brand AS vehicle_brand, v.model AS vehicle_model, u.username AS customer_username, s.sale_date 
            FROM sales s
            JOIN vehicles v ON s.vehicle_id = v.id
            JOIN users u ON s.user_id = u.id";

    // Verificar si la consulta fue exitosa
    $result = $conexion->query($sql);

    // Si la consulta falla, mostrar el error
    if (!$result) {
        die('Error en la consulta SQL: ' . $conexion->error);
    }

    $ventas = [];
    while ($fila = $result->fetch_assoc()) {
        $ventas[] = $fila;
    }

    CerrarBaseDatos($conexion);
    return $ventas;
}



// Registrar una nueva venta
function registrarVenta($vehicle_id, $user_id, $payment_method, $total) {
    $conexion = AbrirBaseDatos();
    $vehicle_id = $conexion->real_escape_string($vehicle_id);
    $user_id = $conexion->real_escape_string($user_id);
    $payment_method = $conexion->real_escape_string($payment_method);
    $total = $conexion->real_escape_string($total);

    $sql = "INSERT INTO sales (vehicle_id, user_id, payment_method, total) 
            VALUES ($vehicle_id, $user_id, '$payment_method', $total)";
    $resultado = $conexion->query($sql);
    CerrarBaseDatos($conexion);
    return $resultado;
}

// Listar vehículos disponibles para la venta
function listarVehiculosDisponibles() {
    $conexion = AbrirBaseDatos();
    $sql = "SELECT id, brand, model FROM vehicles WHERE status = 'disponible'";
    $result = $conexion->query($sql);
    $vehiculos = [];
    while ($fila = $result->fetch_assoc()) {
        $vehiculos[] = $fila;
    }
    CerrarBaseDatos($conexion);
    return $vehiculos;
}

// Listar clientes
function listarClientes() {
    $conexion = AbrirBaseDatos();
    $sql = "SELECT id, username FROM users WHERE role = 'cliente'";
    $result = $conexion->query($sql);
    $clientes = [];
    while ($fila = $result->fetch_assoc()) {
        $clientes[] = $fila;
    }
    CerrarBaseDatos($conexion);
    return $clientes;
}
?>
