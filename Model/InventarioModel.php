<?php
include_once 'Database.php';

// Listar todos los vehículos
function listarVehiculos() {
    $conexion = AbrirBaseDatos();
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

    CerrarBaseDatos($conexion);
    return $vehiculos;
}


// Agregar un nuevo vehículo
function agregarVehiculo($brand, $model, $price, $image_path) {
    $conexion = AbrirBaseDatos();
    $brand = $conexion->real_escape_string($brand);
    $model = $conexion->real_escape_string($model);
    $price = $conexion->real_escape_string($price);
    $image_path = $conexion->real_escape_string($image_path);

    $sql = "INSERT INTO vehicles (brand, model, price, image_path) VALUES ('$brand', '$model', $price, '$image_path')";
    $resultado = $conexion->query($sql);
    CerrarBaseDatos($conexion);
    return $resultado;
}

// Eliminar un vehículo
function eliminarVehiculo($id) {
    $conexion = AbrirBaseDatos();
    $sql = "DELETE FROM vehicles WHERE id = $id";
    $resultado = $conexion->query($sql);
    CerrarBaseDatos($conexion);
    return $resultado;
}
?>
