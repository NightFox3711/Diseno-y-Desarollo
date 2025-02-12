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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'add') {
    $vehicleId = $_POST['vehicle_id'];
    $userId = $_POST['user_id'];
    $paymentMethod = $_POST['payment_method'];
    $total = $_POST['total'];
    $months = $_POST['months'] ?? NULL;
    $interest = $_POST['interest'] ?? NULL;

    if (registrarVenta($vehicleId, $userId, $paymentMethod, $total, $months, $interest)) {
        header('Location: ../View/VentasView.php?msg=success');
    } else {
        header('Location: ../View/VentasView.php?msg=error');
    }
}
?>
