<?php
include_once 'Database.php';

function obtenerCarrito($user_name) {
    $conexion = AbrirBaseDatos();
    $carrito = [];
    
    try {
        $stmt = $conexion->prepare("CALL ShowCart(?)");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ($row = $resultado->fetch_assoc()) {
            $carrito[] = $row;
        }
        
    } catch (Exception $e) {
        error_log("Error en obtenerCarrito: " . $e->getMessage());
    } finally {
        CerrarBaseDatos($conexion);
    }
    
    return $carrito;
}

function agregarCarrito($user_name, $offer_id) {
    $conexion = AbrirBaseDatos();
    $resultado = false;
    
    try {
        $stmt = $conexion->prepare("CALL sp_agregar_al_carrito(?, ?)");
        $stmt->bind_param("si", $user_name, $offer_id);
        $resultado = $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Error en agregarCarrito: " . $e->getMessage());
    } finally {
        CerrarBaseDatos($conexion);
    }
    
    return $resultado;
}

function eliminarDelCarrito($id) {
    $conexion = AbrirBaseDatos();
    $resultado = false;
    
    try {
        $sql = "DELETE FROM cart WHERE id = $id";
        $resultado = $conexion->query($sql);
        
    } catch (Exception $e) {
        error_log("Error en eliminarDelCarrito: " . $e->getMessage());
    } finally {
        CerrarBaseDatos($conexion);
    }
    
    return $resultado;
}
?>