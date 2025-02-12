<?php
include_once 'Database.php';

function procesarPago($user_name, $metodo_pago) {
    $conexion = AbrirBaseDatos();
    
    try {
        // 1. Obtener carrito del usuario
        $stmt = $conexion->prepare("CALL ShowCart(?)");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $carrito = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // 2. Registrar en sales
        $stmt = $conexion->prepare("INSERT INTO sales (user_id, user_name, vehicle_id, payment_method, total) 
                                   SELECT u.id, u.username, o.vehicles_id_offer, ?, o.price_offer * c.quantity
                                   FROM users u 
                                   JOIN cart c ON u.username = c.user_name 
                                   JOIN offers o ON c.offer_id = o.id_offer 
                                   WHERE u.username = ?");
        $stmt->bind_param("ss", $metodo_pago, $user_name);
        $resultado = $stmt->execute();

        // 3. Vaciar carrito
        if($resultado) {
            $stmtDelete = $conexion->prepare("DELETE FROM cart WHERE user_name = ?");
            $stmtDelete->bind_param("s", $user_name);
            $stmtDelete->execute();
        }

        CerrarBaseDatos($conexion);
        return $resultado;

    } catch (Exception $e) {
        CerrarBaseDatos($conexion);
        throw new Exception($e->getMessage());
    }
}
?>