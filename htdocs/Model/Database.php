<?php
class Database {
    public static function AbrirBaseDatos() {
        return mysqli_connect('localhost', 'root', '', 'SolisMotors3718');
    }

    public static function CerrarBaseDatos($conexion) {
        mysqli_close($conexion);
    }
}
?>