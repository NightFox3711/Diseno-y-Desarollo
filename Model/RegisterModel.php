<?php
require_once "Database.php"; // Archivo de conexión a la BD

class UsuarioModel {
    private $conexion;

    public function __construct() {
        $this->conexion = AbrirBaseDatos();
    }

    public function registrarUsuario($nombre, $email, $password, $telefono, $direccion, $cedula, $rol) {
        try {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "CALL sp_registrar_usuario(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sssssss", $nombre, $email, $passwordHash, $telefono, $direccion, $cedula, $rol);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        } finally {
            $stmt->close();
            CerrarBaseDatos($this->conexion);
        }
    }
}
?>
