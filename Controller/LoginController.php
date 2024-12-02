<?php
require_once '../Model/LoginModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $usuario = validarUsuario($username, $password);

    if ($usuario) {
        session_start();
        $_SESSION['user'] = $usuario['username'];
        $_SESSION['role'] = $usuario['role'];
        header('Location: ../View/MenuView.php');
    } else {
        echo "Credenciales incorrectas.";
    }
}
