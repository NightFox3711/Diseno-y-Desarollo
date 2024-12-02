<?php
require_once 'Database.php';

function registrarUsuario($username, $password, $role) {
    $conexion = AbrirBaseDatos();
    $username = mysqli_real_escape_string($conexion, $username);
    $password = mysqli_real_escape_string($conexion, $password); 
    $role = mysqli_real_escape_string($conexion, $role);

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    $resultado = mysqli_query($conexion, $sql);
    CerrarBaseDatos($conexion);

    return $resultado;
}
