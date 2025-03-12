<?php
session_start();
require_once "../Model/LoginModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"];
    $password = $_POST["password"];

    $authModel = new AuthModel();
    $usuario = $authModel->validarUsuarioPorCedula($cedula, $password);

    if ($usuario) {
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["email"] = $usuario["email"];
        $_SESSION["rol"] = $usuario["rol"];
        header("Location: ../View/MenuView.php");
    } else {
        header("Location: ../View/LoginView.php?error=1");
    }
}
?>
