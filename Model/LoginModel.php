<?php
require_once 'Database.php';

function validarUsuario($username, $password) {
    $conexion = AbrirBaseDatos();
    $username = mysqli_real_escape_string($conexion, $username);
    $password = mysqli_real_escape_string($conexion, $password);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $resultado = mysqli_query($conexion, $sql);

    $usuario = mysqli_fetch_assoc($resultado);
    CerrarBaseDatos($conexion);

    return $usuario;
}
