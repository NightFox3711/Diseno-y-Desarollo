<?php
require_once '../Model/RegisterModel.php';

class RegisterController {

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'location' => $_POST['location'],
                'id_card' => $_POST['id_card'],
                'role' => $_POST['role']
            ];

            $success = RegisterModel::registerUser($data);

            if ($success) {
                header("Location: LoginView.php?success=1");
            } else {
                echo "❌ Error al registrar el usuario.";
            }
        }
    }
}
?>
