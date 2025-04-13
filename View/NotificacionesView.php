<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}
require_once '../Model/Database.php';
require_once '../Model/InventarioModel.php';
$userName = $_SESSION['user'];
$conexion = AbrirBaseDatos();
$sql = "
    SELECT 
        ar.id AS request_id,
        ar.vehicle_id,
        ar.is_notified,
        ar.created_at AS requested_at,
        v.brand,
        v.model,
        v.price,
        v.status
    FROM availability_requests ar
    JOIN vehicles v ON ar.vehicle_id = v.id
    WHERE ar.user_name = ?
    ORDER BY ar.created_at DESC
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
$solicitudes = [];
while ($fila = $result->fetch_assoc()) {
    $solicitudes[] = $fila;
}
$stmt->close();
CerrarBaseDatos($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Notificaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #FFFFFF;
      color: #1F2ADB;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #468EDB;
      color: #FFFFFF;
      padding: 20px;
      text-align: center;
    }
    header a {
      color: #FFFFFF;
      text-decoration: none;
      font-weight: bold;
    }
    header a:hover {
      text-decoration: underline;
    }
    h1 {
      margin-top: 20px;
      text-align: center;
      color: #1F2ADB;
    }
    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background: #FFFFFF;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      text-align: center;
      color: #1F2ADB;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 12px;
    }
    table th {
      background-color: #468EDB;
      color: #FFFFFF;
      text-transform: uppercase;
    }
    table tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    table tr:hover {
      background-color: #dddddd;
    }
    .menu-link {
      display: block;
      text-align: center;
      margin: 20px auto;
      padding: 10px;
      font-size: 1rem;
      font-weight: bold;
      color: #1F2ADB;
      text-decoration: none;
    }
    .menu-link:hover {
      color: #468EDB;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <h2>Notificaciones de Disponibilidad</h2>
    <p>
      Hola, <?= htmlspecialchars($userName); ?> |
      <a href="MenuView.php">Menú principal</a> |
      <a href="LoginView.php?action=logout">Cerrar sesión</a>
    </p>
  </header>
  <div class="container">
    <h1>Mis Solicitudes</h1>
    <?php if (empty($solicitudes)): ?>
      <p>No tienes solicitudes de notificación registradas.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID Solicitud</th>
            <th>Vehículo</th>
            <th>Precio</th>
            <th>Estado actual</th>
            <th>¿Disponible?</th>
            <th>Fecha de solicitud</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($solicitudes as $solic): ?>
            <tr>
              <td><?= $solic['request_id']; ?></td>
              <td><?= htmlspecialchars($solic['brand'] . ' ' . $solic['model']); ?></td>
              <td>$<?= number_format($solic['price'], 2); ?></td>
              <td><?= htmlspecialchars($solic['status']); ?></td>
              <td>
                <?php if ($solic['is_notified'] == 1 && $solic['status'] === 'disponible'): ?>
                  <span style="color:green; font-weight:bold;">¡Ya disponible!</span>
                <?php else: ?>
                  <span style="color:orange; font-weight:bold;">En espera</span>
                <?php endif; ?>
              </td>
              <td><?= $solic['requested_at']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
    <a href="MenuView.php" class="menu-link">Regresar al Menú</a>
  </div>
</body>
</html>
