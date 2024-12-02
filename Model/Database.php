<?php

    function AbrirBaseDatos()
    {
        return mysqli_connect('127.0.0.1:3306', 'root', '', 'SCMotors2');
    }

    function CerrarBaseDatos($conexion)
    {
        mysqli_close($conexion);
    }

?>