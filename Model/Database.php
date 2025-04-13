<?php
class Database {
    public static function AbrirBaseDatos() {
        return mysqli_connect('localhost', 'root', '', 'SolisMotors', '3306');
    }

    public static function CerrarBaseDatos($conexion) {
        mysqli_close($conexion);
    }
}
?>