<?php
require_once "Database.php"; // Archivo de conexión a la BD

class AuthModel {
    private $conexion;

    public function __construct() {
        $this->conexion = AbrirBaseDatos();
    }

    public function validarUsuarioPorCedula($cedula, $password) {
        try {
            $query = "CALL sp_validar_usuario_por_cedula(?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("s", $cedula);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                // Verificar contraseña
                if (password_verify($password, $usuario['password'])) {
                    return $usuario; // Devuelve los datos si la contraseña es correcta
                }
            }
            return false; // Usuario no encontrado o contraseña incorrecta
        } catch (Exception $e) {
            return false;
        } finally {
            $stmt->close();
            CerrarBaseDatos($this->conexion);
        }
    }
}
?>
