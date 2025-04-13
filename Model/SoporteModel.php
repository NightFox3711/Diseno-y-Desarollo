<?php
include_once 'Database.php';

// Listar todas las solicitudes de soporte

function listarSolicitudes() {
    $conexion = Database::AbrirBaseDatos();
    
    // Consulta SQL
    $sql = "SELECT s.id, u.username AS user, s.type, s.details, s.status
            FROM support_requests s
            JOIN users u ON s.user_id = u.id";
    
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);
    
    // Verificar si la consulta se ejecutó correctamente
    if ($resultado === false) {
        // Capturar el error de la consulta
        echo "Error en la consulta SQL: " . mysqli_error($conexion);
        return []; // Retornar un array vacío en caso de error
    }

    // Si la consulta es exitosa, obtener los resultados
    $solicitudes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    
    // Cerrar la conexión
    Database:: CerrarBaseDatos($conexion);
    
    return $solicitudes;
}

// Crear una nueva solicitud de soporte
function crearSolicitud($user_id, $type, $details) {
    $conexion = Database::AbrirBaseDatos();
    $user_id = $conexion->real_escape_string($user_id);
    $type = $conexion->real_escape_string($type);
    $details = $conexion->real_escape_string($details);

    $sql = "INSERT INTO support_requests (user_id, type, details) VALUES ($user_id, '$type', '$details')";
    $resultado = $conexion->query($sql);
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}

// Resolver una solicitud de soporte
function resolverSolicitud($id) {
    $conexion = Database::AbrirBaseDatos();
    $sql = "UPDATE support_requests SET status = 'resuelto' WHERE id = $id";
    $resultado = $conexion->query($sql);
    Database::CerrarBaseDatos($conexion);
    return $resultado;
}
?>
