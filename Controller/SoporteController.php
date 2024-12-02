<?php
include_once '../Model/Database.php';
include_once '../Model/SoporteModel.php';

function obtenerSolicitudes() {
    return listarSolicitudes();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'add') {
        $type = $_POST['type'];
        $details = $_POST['details'];
        $userId = $_SESSION['user_id'];

        if (crearSolicitud($type, $details, $userId)) {
            header('Location: ../View/SoporteView.php?msg=success');
        } else {
            header('Location: ../View/SoporteView.php?msg=error');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'resolve') {
        $id = $_GET['id'];
        if (resolverSolicitud($id)) {
            header('Location: ../View/SoporteView.php?msg=resolved');
        } else {
            header('Location: ../View/SoporteView.php?msg=error');
        }
    }
}

