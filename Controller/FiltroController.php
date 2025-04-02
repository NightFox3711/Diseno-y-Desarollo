<?php
include_once '../Models/FiltroModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $brands = isset($_GET['brand']) ? $_GET['brand'] : [];
    $engine_cc = isset($_GET['engine_cc']) ? intval($_GET['engine_cc']) : null;
    
    $motorcycles = FiltroModel::filterMotorcycles($brands, $engine_cc, 'Disponible');

    include '../Views/FiltroRView.php';
}
?>
