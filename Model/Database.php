<?php

    function AbrirBaseDatos()
    {
        return mysqli_connect('localhost', 'root', '', 'SolisMotors371', '3307');
    }

    function CerrarBaseDatos($conexion)
    {
        mysqli_close($conexion);
    }

?>