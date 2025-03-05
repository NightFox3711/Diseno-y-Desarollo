<?php
include_once 'Database.php';

function agregarPago($nombre_tarjetahabitante, $apellido_tarjetahabitante, $correo_tarjetahabitante, $tipo_tarjeta, $numero_tarjeta, $pin_tarjeta, $mes_expiracion, $ano_expiracion){
    $conexion = AbrirBaseDatos() ;
    $nombre_tarjetahabitante = $conexion->real_escape_string($nombre_tarjetahabitante);
    $apellido_tarjetahabitante = $conexion->real_escape_string($apellido_tarjetahabitante);
    $correo_tarjetahabitante = $conexion->real_escape_string($correo_tarjetahabitante);
    $tipo_tarjeta = $conexion->real_escape_string($tipo_tarjeta);
    $numero_tarjeta = $conexion->real_escape_string($numero_tarjeta);
    $pin_tarjeta = $conexion->real_escape_string($pin_tarjeta );
    $mes_expiracion = $conexion->real_escape_string($mes_expiracion);
    $ano_expiracion = $conexion->real_escape_string($ano_expiracion);

    $sql = "INSERT INTO pago_tarjeta (nombre_tarjetahabitante, apellido_tarjetahabitante, correo_tarjetahabitante, tipo_tarjeta, numero_tarjeta, pin_tarjeta, mes_expiracion, ano_expiracion)
    VALUES ('$nombre_tarjetahabitante', '$apellido_tarjetahabitante', '$correo_tarjetahabitante', '$tipo_tarjeta', '$numero_tarjeta', '$pin_tarjeta', '$mes_expiracion', '$ano_expiracion')";
    $resultado = $conexion->query($sql);
    CerrarBaseDatos($conexion);
    return $resultado;
}
?>