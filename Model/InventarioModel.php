<?php
include_once 'Database.php';

// Listar todos los vehículos
function listarVehiculos() {
    $conexion = Database::AbrirBaseDatos();
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT * FROM vehicles";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $vehiculos = [];
    while ($fila = $result->fetch_assoc()) {
        $vehiculos[] = $fila;
    }

    Database::CerrarBaseDatos($conexion);
    return $vehiculos;
}


// Agregar un nuevo vehículo
function agregarVehiculo($brand, $model, $price, $image_path) {
    $conexion = Database::AbrirBaseDatos();
    $brand = $conexion->real_escape_string($brand);
    $model = $conexion->real_escape_string($model);
    $price = $conexion->real_escape_string($price);
    $image_path = $conexion->real_escape_string($image_path);

    $sql = "INSERT INTO vehicles (brand, model, price, image_path) VALUES ('$brand', '$model', $price, '$image_path')";
    $resultado = $conexion->query($sql);
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}

// Eliminar un vehículo
function eliminarVehiculo($id) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "DELETE FROM vehicles WHERE id = $id";
    $resultado = $conexion->query($sql);
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}

//Editar el estado de un vehículo
function editarEstado($id, $nuevo_estado) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "UPDATE vehicles SET status = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $id);
    $resultado = $stmt->execute();
    $stmt->close();

    if ($resultado && $nuevo_estado === 'disponible') {

        $solicitudes = obtenerSolicitudesVehiculo($id);
        
        if (!empty($solicitudes)) {
            marcarNotificacionesEnviadas($id);
          
        }
    }
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}

//Escenario 3 SCRUM-35 

// Registrar solicitud de notificación (cuando el vehículo no está disponible)
function registrarSolicitudNotificacion($vehicleId, $userName) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "INSERT INTO availability_requests (vehicle_id, user_name) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $vehicleId, $userName);
    $resultado = $stmt->execute();
    $stmt->close();
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}

// Obtener las solicitudes pendientes (is_notified = 0) para un vehículo
function obtenerSolicitudesVehiculo($vehicleId) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "SELECT id, vehicle_id, user_name, is_notified, created_at 
            FROM availability_requests 
            WHERE vehicle_id = ? AND is_notified = 0";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $vehicleId);
    $stmt->execute();
    $result = $stmt->get_result();

    $solicitudes = [];
    while ($fila = $result->fetch_assoc()) {
        $solicitudes[] = $fila;
    }
    $stmt->close();
    Database::CerrarBaseDatos($conexion);
    return $solicitudes;
}

// Marcar solicitudes como notificadas
function marcarNotificacionesEnviadas($vehicleId) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "UPDATE availability_requests SET is_notified = 1 
            WHERE vehicle_id = ? AND is_notified = 0";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $vehicleId);
    $resultado = $stmt->execute();
    $stmt->close();
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}
?>