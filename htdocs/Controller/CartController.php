<?php

session_start();

include_once '../Model/Database.php';
include_once '../Model/CartModel.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_name'])) {
    $user_name = $_GET['user_name'];
    $carrito = obtenerCarrito($user_name);
    echo json_encode($carrito);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json; charset=utf-8');

    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['user_name'], $data['offer_id'])) {
        $ok = agregarCarrito($data['user_name'], $data['offer_id']);
        echo json_encode(['success' => (bool)$ok]);
        exit;
    }
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $resultado = eliminarDelCarrito($cart_id);
    echo json_encode(['success' => $resultado]);
    exit();
}
?>
