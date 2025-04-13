<?php
require_once 'Database.php';

class LoginModel {
    public static function validarUsuario($username, $password) {
        $conexion = Database::AbrirBaseDatos();
        $username = mysqli_real_escape_string($conexion, $username);
        $password = mysqli_real_escape_string($conexion, $password);

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $resultado = mysqli_query($conexion, $sql);

        $usuario = mysqli_fetch_assoc($resultado);
        Database::CerrarBaseDatos($conexion);

        return $usuario;
    }

    public static function getUserId($username) {
        $conexion = Database::AbrirBaseDatos();
        $stmt = $conexion->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        Database::CerrarBaseDatos($conexion);
        return $result['id'] ?? null;
    }
}
?>