<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solis Motors - Soporte</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html, body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            color: #1F2ADB;
        }
        /* Encabezado */
        header {
            background-color: #468EDB;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        header h1 {
            margin: 0;
            font-weight: 300;
            font-size: 2.5rem;
        }
        header p {
            margin: 5px 0;
            font-size: 1.1rem;
        }
        header a {
            color: #468EDB;
            text-decoration: none;
            font-weight: bold;
        }
        header a:hover {
            text-decoration: underline;
        }
        nav.navbar {
            background: #1F2ADB;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px; 
        }
        nav.navbar .navbar-brand {
            color: #FFFFFF !important;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        nav.navbar .navbar-brand:hover {
            color: #468EDB !important;
        }
        nav.navbar .navbar-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        nav.navbar .nav-item {
            position: relative;
        }
        nav.navbar .nav-link {
            color: #FFFFFF !important;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 15px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
        }
        nav.navbar .nav-link:hover {
            background: #468EDB;
            transform: scale(1.05);
        }
        /* Contenedor de contenido */
        main {
            padding: 20px;
            max-width: 900px;
            margin: 30px auto;
            background: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        h2 {
            color: #1F2ADB;
            text-align: center;
            font-weight: 300;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        table th {
            background-color: #1F2ADB;
            color: #FFFFFF;
            text-transform: uppercase;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #1F2ADB15;
        }
        form {
            margin-top: 20px;
        }
        select, textarea, button, input[type="text"], input[type="number"], input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: block;
        }
        button {
            background-color: #1F2ADB;
            color: #FFFFFF;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #468EDB;
        }
        a {
            color: #1F2ADB;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .menu-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            color: #1F2ADB;
        }
        .menu-link:hover {
            color: #468EDB;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <h1>Soporte al Cliente</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
    </header>
    
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="MenuView.php"><i class="bi bi-arrow-left"></i> Volver al menú</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSoporte" aria-controls="navbarSoporte" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSoporte">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="VentasView.php"><i class="bi bi-cart"></i> Ventas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="InventarioView.php"><i class="bi bi-box"></i> Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="CotizacionView.php"><i class="bi bi-file-text"></i> Cotizaciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="OfertasView.php"><i class="bi bi-gift"></i> Ofertas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="CartView.php"><i class="bi bi-cart3"></i> Carrito</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="TestDriveView.php"><i class="bi bi-car-front"></i> Prueba Manejo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="NotificacionesView.php"><i class="bi bi-bell"></i> Notificaciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="SoporteView.php"><i class="bi bi-question-circle"></i> Soporte</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <!-- Contenido principal -->
    <main>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <h2>Solicitudes de Soporte</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../Controller/SoporteController.php';
                    $solicitudes = obtenerSolicitudes();
                    foreach ($solicitudes as $solicitud):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($solicitud['id']); ?></td>
                        <td><?= htmlspecialchars($solicitud['user']); ?></td>
                        <td><?= htmlspecialchars($solicitud['type']); ?></td>
                        <td><?= htmlspecialchars($solicitud['details']); ?></td>
                        <td><?= htmlspecialchars($solicitud['status']); ?></td>
                        <td>
                            <?php if ($solicitud['status'] === 'pendiente'): ?>
                                <a href="../Controller/SoporteController.php?action=resolve&id=<?= $solicitud['id']; ?>">Resolver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h2>Crear solicitud de soporte</h2>
            <form action="../Controller/SoporteController.php?action=add" method="POST">
                <select name="type" required>
                    <option value="chat">Chat</option>
                    <option value="cita">Cita</option>
                    <option value="prueba">Prueba de Manejo</option>
                </select>
                <textarea name="details" placeholder="Detalles" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        <?php endif; ?>
        <a href="MenuView.php" class="menu-link">Volver al menú</a>
    </main>
    
  
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
