<?php
include_once '../Model/Database.php';

// Obtener opciones de vehículos desde la tabla `vehicles`
function obtenerOpcionesVehiculos()
{
    $conexion = AbrirBaseDatos();
    $sql = "SELECT DISTINCT brand, model, headquarters FROM vehicles";
    $result = $conexion->query($sql);

    $opciones = [];
    while ($row = $result->fetch_assoc()) {
        $opciones[] = $row;
    }
    return $opciones;
}

//Obtener sedes

function obtenerSedesVehiculos()
{
    $conexion = AbrirBaseDatos();
    $sql = "SELECT DISTINCT headquarters FROM vehicles";
    $result = $conexion->query($sql);

    $sedes = [];
    while ($row = $result->fetch_assoc()) {
        $sedes[] = $row;
    }
    return $sedes;
}

// Insertar nueva solicitud de envío
function crearEnvio($brand, $model, $headquarters_change)
{
    $conexion = AbrirBaseDatos();
    $sql = "INSERT INTO headquarters_change (brand, model, headquarters_change, status_change) 
            VALUES (?, ?, ?, 'Llegó')";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $brand, $model, $headquarters_change);
    return $stmt->execute();
}

// Obtener todas las solicitudes
function listarEnvios()
{
    $conexion = AbrirBaseDatos();
    $sql = "SELECT * FROM headquarters_change";
    $result = $conexion->query($sql);

    $envios = [];
    while ($row = $result->fetch_assoc()) {
        $envios[] = $row;
    }
    return $envios;
}
