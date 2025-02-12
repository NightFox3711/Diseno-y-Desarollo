<?php
include_once 'Database.php';

function listarVentas() {
    $conexion = AbrirBaseDatos();
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

    CerrarBaseDatos($conexion);
    return $ventas;
}


function registrarVenta($vehicle_id, $user_id, $payment_method, $total, $months = null, $interest = null) {
    $conexion = AbrirBaseDatos();

    
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
    CerrarBaseDatos($conexion);

    return $resultado;
}



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
