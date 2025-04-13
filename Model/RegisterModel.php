<?php
require_once "Database.php";

/* class UsuarioModel {
    private $conexion;

    public function __construct() {
        $this->conexion = AbrirBaseDatos();
    } */

function registrarUsuario($username, $password, $role) {
    $conexion = Database::AbrirBaseDatos();
    $username = mysqli_real_escape_string($conexion, $username);
    $password = mysqli_real_escape_string($conexion, $password); 
    $role = mysqli_real_escape_string($conexion, $role);

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    $resultado = mysqli_query($conexion, $sql);
    Database::CerrarBaseDatos($conexion);


    /*
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
    } */
}
?>
