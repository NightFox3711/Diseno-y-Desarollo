<?php
include_once 'Database.php';


function listarOfertas() {
    $conexion = AbrirBaseDatos();
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sentencia = "SELECT * FROM offers";
    $resultado = $conexion->query($sentencia);

    if (!$resultado) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ofertas = [];
    if ($resultado ->num_rows > 0) {
        while($row = $resultado -> fetch_assoc()) {
            $ofertas[] = $row;
        }
    }

    CerrarBaseDatos($conexion);
    return $ofertas;
}
