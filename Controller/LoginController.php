<?php
require_once '../Model/LoginModel.php';
require_once '../Model/AuthModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_card = $_POST["id_card"];  
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $authModel = new AuthModel();
    $usuario = $authModel->validarUsuarioPorCedula($id_card, $password);

    /*  
    if (!$usuario) {
        $usuario = LoginModel::validarUsuario($username, $password);
    }
    */

    if ($usuario) {
        $_SESSION["id_usuario"] = $usuario["id_username"];
        $_SESSION["nombre"] = $usuario["username"];
        $_SESSION["email"] = $usuario["email"];
        $_SESSION["rol"] = $usuario["role"];
        header("Location: ../View/MenuView.php");
    } else {
        header("Location: ../View/LoginView.php?error=1");
    }
}
?>
