<?php

include_once 'Database.php';

function agregarPago($name_cardholder, $lastname_cardholder, $email_cardholder, $card_type, $number_card, $pin_card, $expiration_month, $expiration_year) {
    $conexion = Database::AbrirBaseDatos();

    $name_cardholder = $conexion->real_escape_string($name_cardholder);
    $lastname_cardholder = $conexion->real_escape_string($lastname_cardholder);
    $email_cardholder = $conexion->real_escape_string($email_cardholder);
    $card_type = $conexion->real_escape_string($card_type);
    
    
    $number_card = $conexion->real_escape_string($number_card); // mantiene los guiones


    $pin_card = $conexion->real_escape_string($pin_card);
    $expiration_month = $conexion->real_escape_string($expiration_month);
    $expiration_year = $conexion->real_escape_string($expiration_year);

    // acá se hace la validación de los datos
    $sql = "INSERT INTO card_payment 
            (name_cardholder, lastname_cardholder, email_cardholder, card_type, number_card, pin_card, expiration_month, expiration_year)
            VALUES 
            ('$name_cardholder', '$lastname_cardholder', '$email_cardholder', '$card_type', '$number_card', '$pin_card', '$expiration_month', '$expiration_year')";

    $resultado = $conexion->query($sql);

    Database::CerrarBaseDatos($conexion);

    return $resultado;
}
?>
