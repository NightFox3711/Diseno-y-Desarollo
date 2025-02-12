<?php
include_once 'Database.php';

function listarOfertas($searchTerm = '') {
    $conexion = AbrirBaseDatos();
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Sentencia para filtrar los resultados por medio del nombre del vehículo
    $sentencia = "SELECT * FROM offers WHERE vehicle_offer LIKE ?";
    $stmt = $conexion->prepare($sentencia);
    
    // Agregar comodín al término de búsqueda
    $searchTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $searchTerm); // "s" indica que es una cadena string
    $stmt->execute();
    
    $resultado = $stmt->get_result();

    if (!$resultado) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ofertas = [];
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $ofertas[] = $row;
        }
    }

    CerrarBaseDatos($conexion);
    return $ofertas;
}
