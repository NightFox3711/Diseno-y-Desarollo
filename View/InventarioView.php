<?php
/*
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: LoginView.php');
    exit();
} 
*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solis Motors - Inventario</title>
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
        header {
            background-color: #468EDB;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        /* Barra de navegación */
        nav.navbar {
            background-color: #1F2ADB;
        }
        nav.navbar .navbar-brand {
            color: #FFFFFF;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }
        nav.navbar .navbar-brand:hover {
            color: #468EDB;
        }
        nav.navbar .navbar-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav.navbar .nav-item {
            position: relative;
        }
        nav.navbar .nav-link {
            color: #FFFFFF;
            font-size: 1.2rem;
            font-weight: 600;
            padding: 16px 24px;
            border-radius: 5px;
            text-decoration: none;
            transition: transform 0.3s, background 0.3s;
        }
        nav.navbar .nav-link:hover {
            background: #1F2ADB;
            transform: scale(1.05);
        }
        nav.navbar .nav-item:before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background-color: #FFFFFF;
            transition: width 0.3s;
        }
        nav.navbar .nav-item:hover:before {
            width: 100%;
        }
        /* Estilos para el Inventario */
        main {
            padding: 20px;
            max-width: 900px;
            margin: 30px auto;
            background: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
        table th,
        table td {
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
        form {
            margin-top: 20px;
        }
        select,
        textarea,
        button,
        input[type="text"],
        input[type="number"],
        input[type="file"] {
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
            transition: background-color 0.3s ease, transform 0.2s;
        }
        button:hover {
            background-color: #468EDB;
            transform: scale(1.03);
        }
        a {
            color: #1F2ADB;
            text-decoration: none;
        }
        a:hover {
            color: #468EDB;
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
        .inline-form {
            display: inline-block;
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Inventario</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
    </header>
    
    <!-- Barra de navegación completa con todas las opciones -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <!-- Sección para volver al menú -->
        <a class="navbar-brand" href="MenuView.php"><i class="bi bi-arrow-left"></i> Volver al menú</a>
        <!-- Opciones de navegación -->
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="VentasView.php"><i class="bi bi-cart"></i> Ventas</a></li>
          <li class="nav-item"><a class="nav-link" href="InventarioView.php"><i class="bi bi-box"></i> Inventario</a></li>
          <li class="nav-item"><a class="nav-link" href="CotizacionView.php"><i class="bi bi-file-text"></i> Cotizaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="OfertasView.php"><i class="bi bi-gift"></i> Ofertas</a></li>
          <li class="nav-item"><a class="nav-link" href="CartView.php"><i class="bi bi-cart3"></i> Carrito</a></li>
          <li class="nav-item"><a class="nav-link" href="TestDriveView.php"><i class="bi bi-car-front"></i> Prueba Manejo</a></li>
          <li class="nav-item"><a class="nav-link" href="NotificacionesView.php"><i class="bi bi-bell"></i> Notificaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="SoporteView.php"><i class="bi bi-question-circle"></i> Soporte</a></li>
        </ul>
      </div>
    </nav>

    <main>
        <h2>Vehículos disponibles</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once '../Controller/InventarioController.php';
                $vehiculos = obtenerVehiculos();
                foreach ($vehiculos as $vehiculo):
                    $vehiculoId = htmlspecialchars($vehiculo['id']);
                    $vehiculoBrand = htmlspecialchars($vehiculo['brand']);
                    $vehiculoModel = htmlspecialchars($vehiculo['model']);
                    $vehiculoPrice = number_format($vehiculo['price'], 2);
                    $vehiculoStatus = htmlspecialchars($vehiculo['status']);
                ?>
                    <tr>
                        <td><?= $vehiculoId; ?></td>
                        <td><?= $vehiculoBrand; ?></td>
                        <td><?= $vehiculoModel; ?></td>
                        <td>$<?= $vehiculoPrice; ?></td>
                        <td><?= $vehiculoStatus; ?></td>
                        <td>
                            <form action="../Controller/InventarioController.php?action=edit" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?= $vehiculoId; ?>">
                                <select name="nuevo_estado">
                                    <option value="disponible" <?= ($vehiculoStatus === 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                                    <option value="reservado" <?= ($vehiculoStatus === 'reservado') ? 'selected' : ''; ?>>Reservado</option>
                                </select>
                                <button type="submit">Actualizar</button>
                            </form>
                            <a href="../Controller/InventarioController.php?action=delete&id=<?= $vehiculoId; ?>">Eliminar</a>
                            <?php if ($vehiculoStatus !== 'disponible'): ?>
                                <form action="../Controller/InventarioController.php?action=notify" method="POST" class="inline-form">
                                    <input type="hidden" name="vehicle_id" value="<?= $vehiculoId; ?>">
                                    <input type="hidden" name="user_name" value="<?= $_SESSION['user']; ?>">
                                    <button type="submit">Notificarme</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Registrar nuevo vehículo</h2>
        <form action="../Controller/InventarioController.php?action=add" method="POST" enctype="multipart/form-data">
            <input type="text" name="brand" placeholder="Marca" required>
            <input type="text" name="model" placeholder="Modelo" required>
            <input type="number" name="price" placeholder="Precio" required>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Registrar vehículo</button>
        </form>
        <a href="MenuView.php" class="menu-link">Volver al menú</a>
    </main>
</body>
</html>
