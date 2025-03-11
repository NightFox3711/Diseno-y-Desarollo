<?php

    function AbrirBaseDatos()
    {
        return mysqli_connect('localhost', 'root', '', 'SCMotors2', '3307');
    }

    function CerrarBaseDatos($conexion)
    {
        mysqli_close($conexion);
    }

?>