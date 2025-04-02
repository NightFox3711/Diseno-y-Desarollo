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
                    header('Location: ../View/InventarioView.php?mensaje=solicitud_creada');
                } else {
                    header('Location: ../View/InventarioView.php?mensaje=error');
                }
            }
            break;
    }
}

// Obtener todas las solicitudes
function obtenerEnvios()
{
    return listarEnvios();
}

// Obtener marcas, modelos y sedes desde vehicles
function obtenerOpciones()
{
    return obtenerOpcionesVehiculos();
}

function obtenerSedes()
{
    return obtenerSedesVehiculos();
}
