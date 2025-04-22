<?php
require_once 'Database.php';

class LoginModel {

    public static function validateUser($id_card, $password) {
        $conn = Database::AbrirBaseDatos();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id_card = ?");
        $stmt->bind_param("s", $id_card);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        Database::CerrarBaseDatos($conn);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
?>
