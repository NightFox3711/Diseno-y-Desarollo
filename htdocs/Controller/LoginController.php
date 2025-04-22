<?php
require_once '../Model/LoginModel.php';

class LoginController {

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
            $id_card = $_POST['id_card'];
            $password = $_POST['password'];

            $user = LoginModel::validateUser($id_card, $password);

            if ($user) {
                session_start();  
                $_SESSION['user'] = $user;  
                header("Location: ../View/MenuView.php");  
                exit();  
            } else {
                
                header("Location: ../View/MenuView.php");  
                exit();
            }
        }
    }
}


$controller = new LoginController();
$controller->login();

