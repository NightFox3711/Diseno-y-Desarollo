<?php
include_once 'Database.php';

function obtenerCarrito($user_name) {
    $conexion = Database::AbrirBaseDatos();
    $carrito = [];
    
    try {
       
        $stmt = $conexion->prepare("CALL sp_show_cart(?)");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ($row = $resultado->fetch_assoc()) {
            $carrito[] = $row;
        }
        
    } catch (Exception $e) {
        error_log("Error en obtenerCarrito: " . $e->getMessage());
    } finally {
        Database::CerrarBaseDatos($conexion);
    }
    
    return $carrito;
}

function agregarCarrito($user_name, $offer_id) {
    $conexion = Database::AbrirBaseDatos();
    $resultado = false;

    try {
        // 1) Prepara la llamada al procedimiento
        $stmt = $conexion->prepare("CALL sp_add_to_cart(?, ?)");
        if (!$stmt) {
            error_log("[CartModel] prepare failed: " . $conexion->error);
            return false;
        }

        $stmt->bind_param("si", $user_name, $offer_id);

        // 2) Ejecuta y comprueba
        if (!$stmt->execute()) {
            error_log("[CartModel] execute failed: " . $stmt->error);
        } else {
            $resultado = true;
        }

        // 3) Cierra el statement
        $stmt->close();

        // 4) Limpia cualquier result set pendiente (importantísimo en SP)
        while ($conexion->more_results() && $conexion->next_result()) {
            $res = $conexion->use_result();
            if ($res instanceof mysqli_result) {
                $res->free();
            }
        }
    } catch (Exception $e) {
        error_log("Error en agregarCarrito: " . $e->getMessage());
    } finally {
        Database::CerrarBaseDatos($conexion);
    }

    return $resultado;
}


function eliminarDelCarrito($cart_id) {
    $conexion = Database::AbrirBaseDatos();
    $resultado = false;
    
    try {
        $sql = "DELETE FROM cart WHERE id_cart = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $resultado = $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Error en eliminarDelCarrito: " . $e->getMessage());
    } finally {
        Database::CerrarBaseDatos($conexion);
    }
    
    return $resultado;
}
?>
