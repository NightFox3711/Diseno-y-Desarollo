<?php
include_once '../Model/Database.php';
include_once '../Model/InventarioModel.php';

function obtenerVehiculos() {
    return listarVehiculos();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si 'action' está definido en la URL
    if (isset($_GET['action']) && $_GET['action'] === 'add') {
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];

        // Subir imagen
        $targetDir = "../assets/img/vehiculos/";
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

        if (agregarVehiculo($brand, $model, $price, $image)) {
            header('Location: ../View/InventarioView.php?msg=success');
        } else {
            header('Location: ../View/InventarioView.php?msg=error');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica si 'action' está definido en la URL
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        $id = $_GET['id'];
        if (eliminarVehiculo($id)) {
            header('Location: ../View/InventarioView.php?msg=deleted');
        } else {
            header('Location: ../View/InventarioView.php?msg=error');
        }
    }
}

//Editar estado del vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $id = $_POST['id'];
        $nuevo_estado = $_POST['nuevo_estado'];
        if (editarEstado($id, $nuevo_estado)) {
            header('Location: ../View/InventarioView.php?msg=updated');
        } else {
            header('Location: ../View/InventarioView.php?msg=error');
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'notify') {
    $vehicleId = $_POST['vehicle_id'];
    $userName = $_POST['user_name'];  
    
    if (registrarSolicitudNotificacion($vehicleId, $userName)) {
        header("Location: ../View/InventarioView.php?msg=notif_success");
    } else {
        header("Location: ../View/InventarioView.php?msg=notif_error");
    }
    exit();
}

