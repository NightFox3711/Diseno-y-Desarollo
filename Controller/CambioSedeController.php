<?php
include_once '../Model/CambioSedeModel.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $brand = $_POST['brand'];
                $model = $_POST['model'];
                $headquarters_change = $_POST['headquarters_change'];

                if (crearEnvio($brand, $model, $headquarters_change)) {
                    header('Location: ../View/CambioSedeView.php?mensaje=solicitud_creada');
                } else {
                    header('Location: ../View/CambioSedeView.php?mensaje=error');
                }
            }
            break;

        case 'resolve':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                marcarComoLlegado($id);
                header('Location: ../View/CambioSedeView.php?mensaje=actualizado');
            }
            break;
    }
}

// Obtener todas las solicitudes
function obtenerEnvios() {
    return listarEnvios();
}

// Obtener marcas, modelos y sedes desde vehicles
function obtenerOpciones() {
    return obtenerOpcionesVehiculos();
}
?>
