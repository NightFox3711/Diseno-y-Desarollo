<?php
require_once "../Model/RegisterModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $cedula = $_POST["cedula"];
    $rol = $_POST["rol"];

    $usuarioModel = new UsuarioModel();
    $resultado = $usuarioModel->registrarUsuario($nombre, $email, $password, $telefono, $direccion, $cedula, $rol);

    if ($resultado) {
        header("Location: ../View/LoginView.php?success=1");
    } else {
        header("Location: ../View/RegisterView.php?error=1");
    }
}
?>
