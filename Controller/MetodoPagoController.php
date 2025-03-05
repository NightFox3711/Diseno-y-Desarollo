<?php
include_once '../Model/Database.php';
include_once '../Model/MetodoPagoModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_GET['action']) && $_GET['action'] === 'add') {
        $nombre_tarjetahabitante = $_POST['nombre_tarjetahabitante'];
        $apellido_tarjetahabitante = $_POST['apellido_tarjetahabitante'];
        $correo_tarjetahabitante = $_POST['correo_tarjetahabitante'];
        $tipo_tarjeta = $_POST['tipo_tarjeta'];
        $numero_tarjeta = $_POST['numero_tarjeta'];
        $pin_tarjeta = $_POST['pin_tarjeta'];
        $mes_expiracion = $_POST['mes_expiracion'];
        $ano_expiracion = $_POST['ano_expiracion'];

        if (agregarPago(
            $nombre_tarjetahabitante,
            $apellido_tarjetahabitante,
            $correo_tarjetahabitante,
            $tipo_tarjeta,
            $numero_tarjeta,
            $pin_tarjeta,
            $mes_expiracion,
            $ano_expiracion
        )) {
            header('Location: ../View/MetodoPagoView.php?msg=success');
        } else {
            header('Location: ../View/MeotodoPagoView.php?msg=error');
        }
    }
}
