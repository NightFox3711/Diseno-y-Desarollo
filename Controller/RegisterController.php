<?php
require_once '../Model/RegisterModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (registrarUsuario($username, $password, $role)) {
        header('Location: ../View/LoginView.php');
    } else {
        echo "Error al registrar usuario.";
    }
}
