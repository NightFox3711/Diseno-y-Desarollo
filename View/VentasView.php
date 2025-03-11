<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: LoginView.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SC Motors - Ventas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #FFFFFF;
      color: #1F2ADB;
      line-height: 1.6;
    }
    header {
      background: #468EDB;
      color: #FFFFFF; 
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    header h1 {
      margin: 0;
      font-size: 2.5rem;
      font-weight: 300;
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
    main {
      padding: 30px;
      max-width: 1000px;
      margin: 40px auto;
      background: #FFFFFF;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    h2 {
      font-family: 'Roboto Condensed', sans-serif;
      color: #1F2ADB;
      text-transform: uppercase;
      text-align: center;
      letter-spacing: 2px;
      margin: 2rem 0;
      font-size: 2.2rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 2rem auto;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    th, td {
      text-align: center;
      padding: 15px;
      vertical-align: middle;
      border-bottom: 1px solid #eee;
    }
    th {
      background-color: #1F2ADB;
      color: #FFFFFF;
      text-transform: uppercase;
      font-size: 0.9rem;
    }
    tr:hover {
      background-color: #f9f9f9;
    }
    tr:nth-child(even) {
      background-color: #f7f7f7;
    }
    form {
      margin-top: 30px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    select,
    input[type="number"] {
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ddd;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    select:focus,
    input[type="number"]:focus {
      border-color: #1F2ADB;
      box-shadow: 0 0 8px rgba(31,42,219, 0.3);
      outline: none;
    }
    button {
      background: linear-gradient(145deg, #1F2ADB, #468EDB);
      color: #FFFFFF !important;
      padding: 1rem 2rem;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      grid-column: span 2;
      width: 60%;
      justify-self: center;
      text-transform: uppercase;
      font-weight: bold;
      letter-spacing: 1px;
    }
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(31,42,219,0.3);
      background: linear-gradient(145deg, #468EDB, #1F2ADB);
    }
    td {
      font-size: 0.95rem;
      color: #1F2ADB;
    }
    .total-price {
      font-weight: bold;
      color: #1F2ADB;
    }
  </style>
</head>
<body>
  <header>
    <h1>Gestión de Ventas</h1>
    <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
  </header>

  <!-- Barra de navegación con sección para "Volver al menú" -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <!-- Sección Volver al menú -->
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
    <h2>Ventas realizadas</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Vehículo</th>
          <th>Cliente</th>
          <th>Método de Pago</th>
          <th>Total</th>
          <th>Interés</th>
          <th>Financiamiento</th>
          <th>Estado</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include_once '../Controller/VentasController.php';
          $ventas = obtenerVentas();
          foreach ($ventas as $venta):
        ?>
          <tr>
            <td><?= htmlspecialchars($venta['sale_id']); ?></td>
            <td><?= htmlspecialchars($venta['vehicle_brand'] . ' ' . $venta['vehicle_model']); ?></td>
            <td><?= htmlspecialchars($venta['customer_username']); ?></td>
            <td><?= htmlspecialchars($venta['payment_method']); ?></td>
            <td class="total-price">$<?= number_format($venta['total'], 2); ?></td>
            <td><?= $venta['interest_rate'] ? $venta['interest_rate'] . '%' : 'N/A'; ?></td>
            <td><?= $venta['months_financing'] ? $venta['months_financing'] . ' meses' : 'N/A'; ?></td>
            <td><?= htmlspecialchars($venta['financing_status']); ?></td>
            <td><?= htmlspecialchars($venta['added_at']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>Registrar nueva venta</h2>
    <form action="../Controller/VentasController.php?action=add" method="POST">
      <select name="vehicle_id" required>
        <option value="">Seleccionar vehículo</option>
        <?php
          $vehiculosDisponibles = obtenerVehiculosDisponibles();
          foreach ($vehiculosDisponibles as $vehiculo):
        ?>
          <option value="<?= $vehiculo['id']; ?>"><?= $vehiculo['brand'] . ' ' . $vehiculo['model']; ?></option>
        <?php endforeach; ?>
      </select>
      <select name="user_id" required>
        <option value="">Seleccionar cliente</option>
        <?php
          $clientes = obtenerClientes();
          foreach ($clientes as $cliente):
        ?>
          <option value="<?= $cliente['id']; ?>"><?= $cliente['username']; ?></option>
        <?php endforeach; ?>
      </select>
      <select name="payment_method" required>
        <option value="efectivo">Efectivo</option>
        <option value="financiamiento">Financiamiento</option>
      </select>
      <input type="number" name="Monto total" placeholder="Monto Total" required>
      <input type="number" name="months" placeholder="Meses de financiamiento" min="1">
      <input type="number" name="interest" placeholder="Tasa de interés (%)" step="0.01">
      <button type="submit">Registrar Venta</button>
    </form>
  </main>
</body>
</html>
