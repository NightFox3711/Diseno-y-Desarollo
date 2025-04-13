<?php
include_once '../Model/Database.php';

// Obtener opciones de vehículos desde la tabla `vehicles`
function obtenerOpcionesVehiculos() {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT DISTINCT brand, model, headquarters FROM vehicles";
    $result = $conexion->query($sql);
    
    $opciones = [];
    while ($row = $result->fetch_assoc()) {
        $opciones[] = $row;
    }
    return $opciones;
}

// Insertar nueva solicitud de envío
function crearEnvio($brand, $model, $headquarters_change) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "INSERT INTO headquarters_change (brand, model, headquarters_change, status_change) 
            VALUES (?, ?, ?, 'Enviando')";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $brand, $model, $headquarters_change);
    return $stmt->execute();
}

// Obtener todas las solicitudes
function listarEnvios() {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT * FROM headquarters_change";
    $result = $conexion->query($sql);
    
    $envios = [];
    while ($row = $result->fetch_assoc()) {
        $envios[] = $row;
    }
    return $envios;
}

// Marcar un envío como "Llegó"
function marcarComoLlegado($id) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "UPDATE headquarters_change SET status_change = 'llegó' WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
