<?php
include_once 'Database.php';

function obtenerCarrito($user_name) {
    $conexion = AbrirBaseDatos();
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Llamar al procedimiento almacenado
    $stmt = $conexion->prepare("CALL ShowCart(?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $user_name);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    $resultado = $stmt->get_result();
    $carrito = [];
    while ($row = $resultado->fetch_assoc()) {
        $carrito[] = $row;
    }

    CerrarBaseDatos($conexion);
    return $carrito;
}

function agregarCarrito($user_name, $offer_id) {
    $conexion = AbrirBaseDatos();
    
    // Llamar al procedimiento almacenado sp_agregar_al_carrito
    $stmt = $conexion->prepare("CALL sp_agregar_al_carrito(?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("si", $user_name, $offer_id);
    $resultado = $stmt->execute();

    CerrarBaseDatos($conexion);
    return $resultado;
}

function eliminarDelCarrito($id) {
    $conexion = AbrirBaseDatos();
    
    // Eliminar un registro del carrito por su ID
    $sql = "DELETE FROM cart WHERE id = $id";
    $resultado = $conexion->query($sql);

    CerrarBaseDatos($conexion);
    return $resultado;
}
?>