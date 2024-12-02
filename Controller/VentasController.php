<?php
include_once '../Model/Database.php';
include_once '../Model/VentasModel.php';

function obtenerVentas() {
    return listarVentas();
}

function obtenerVehiculosDisponibles() {
    return listarVehiculosDisponibles();
}

function obtenerClientes() {
    return listarClientes();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_GET['action'] === 'add') {
        $vehicleId = $_POST['vehicle_id'];
        $userId = $_POST['user_id'];
        $paymentMethod = $_POST['payment_method'];
        $total = $_POST['total'];

        if (registrarVenta($vehicleId, $userId, $paymentMethod, $total)) {
            header('Location: ../View/VentasView.php?msg=success');
        } else {
            header('Location: ../View/VentasView.php?msg=error');
        }
    }
}
?>
