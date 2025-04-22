<?php
require_once 'Database.php';

class RegisterModel {

    public static function registerUser($data) {
        $conn = Database::AbrirBaseDatos();

        if (!$conn) {
            die("💥 Error de conexión: " . mysqli_connect_error());
        }

        $stmt = $conn->prepare("CALL sp_register_user(?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("💀 Error en prepare(): " . $conn->error);
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bind_param("sssssss", 
            $data['username'], 
            $data['email'], 
            $hashedPassword, 
            $data['phone'], 
            $data['location'], 
            $data['id_card'], 
            $data['role']
        );

        $result = $stmt->execute();
        if (!$result) {
            die("☠️ Error en execute(): " . $stmt->error);
        }

        Database::CerrarBaseDatos($conn);
        return $result;
    }
}
