<?php
include_once '../Model/Database.php';
include_once '../Model/CartModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_name'])) {
    $user_name = $_GET['user_name'];
    $carrito = obtenerCarrito($user_name);
    echo json_encode($carrito);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['user_name'], $data['offer_id'])) {
        $resultado = agregarCarrito($data['user_name'], $data['offer_id']);
        echo json_encode(['success' => $resultado]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = eliminarDelCarrito($id);
    echo json_encode(['success' => $resultado]);
    exit();
}
?>
