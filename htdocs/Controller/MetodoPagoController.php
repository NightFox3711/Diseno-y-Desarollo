<?php

include_once '../Model/Database.php';
include_once '../Model/MetodoPagoModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_GET['action']) && $_GET['action'] === 'add') {
        $name_cardholder = $_POST['name_cardholder'];
        $lastname_cardholder = $_POST['lastname_cardholder'];
        $email_cardholder = $_POST['email_cardholder'];
        $card_type = $_POST['card_type'];
        $number_card = $_POST['number_card'];
        $pin_card = $_POST['pin_card'];
        $expiration_month = $_POST['expiration_month'];
        $expiration_year = $_POST['expiration_year'];

        if (agregarPago(
            $name_cardholder,
            $lastname_cardholder,
            $email_cardholder,
            $card_type,
            $number_card,
            $pin_card,
            $expiration_month,
            $expiration_year
        )) {
            header('Location: ../View/Ventas/MetodoPagoView.php?msg=success');
        } else {
            header('Location: ../View/Ventas/MetodoPagoView.php?msg=error');
        }
    }
}


header('Location: ../View/Ventas/MetodoPagoView.php');
exit;