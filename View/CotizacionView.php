<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}
require_once '../Model/CotizacionModel.php';
$clientes = sp_listar_clientes();
$vehiculos = sp_listar_vehiculos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Cotizaciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #FFFFFF;
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
    }
    /* Encabezado */
    .header {
      background-color: #468EDB;
      color: #FFFFFF;
      padding: 40px 20px;
      text-align: center;
      margin-bottom: 30px;
    }
    .header h1 {
      margin: 0;
      font-size: 2.5rem;
    }
    .header p {
      margin-top: 10px;
      font-size: 1.1rem;
    }
    /* Barra de navegación con animaciones */
    nav.navbar {
      background-color: #1F2ADB !important;
      margin-bottom: 20px; /* Espacio debajo de la barra */
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
      gap: 20px;
    }
    nav.navbar .nav-item {
      position: relative;
    }
    nav.navbar .nav-link {
      color: #FFFFFF !important;
      font-size: 1.2rem;
      font-weight: 600;
      padding: 16px 24px;
      border-radius: 5px;
      text-decoration: none;
      transition: transform 0.3s ease, background 0.3s ease;
    }
    nav.navbar .nav-link:hover {
      background-color: #1F2ADB;
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
      transition: width 0.3s ease;
    }
    nav.navbar .nav-item:hover:before {
      width: 100%;
    }
    /* Contenedor del contenido principal */
    .content-container {
      margin-top: 20px;
      padding-bottom: 40px;
    }
    /* Estilos para tarjetas y formularios */
    .card-header.bg-dark {
      background-color: #1F2ADB !important;
      color: #FFFFFF !important;
      transition: background-color 0.3s ease;
    }
    .btn-dark {
      background-color: #1F2ADB !important;
      border-color: #1F2ADB !important;
      color: #FFFFFF !important;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .btn-dark:hover {
      background-color: #468EDB !important;
      border-color: #468EDB !important;
      transform: scale(1.03);
    }
  </style>
</head>
<body>
  <!-- Encabezado -->
  <div class="header">
    <h1>Gestión de Cotizaciones</h1>
    <p class="lead">Administra tus cotizaciones de forma rápida y sencilla</p>
  </div>
  
  <!-- Barra de navegación completa justo debajo del encabezado -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="MenuView.php"><i class="bi bi-arrow-left"></i> Volver al menú</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

        <li class="nav-item">
            <a class="nav-link" href="VentasView.php"><i class="bi bi-cart"></i> Ventas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="InventarioView.php"><i class="bi bi-box"></i> Inventario</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="CotizacionView.php"><i class="bi bi-file-text"></i> Cotizaciones</a>
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
            <a class="nav-link" href="SoporteView.php"><i class="bi bi-question-circle"></i> Soporte</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contenido principal -->
  <div class="container content-container">
    <?php if (!empty($msg)): ?>
      <div class="alert alert-info">
        <?php echo htmlspecialchars($msg); ?>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Crear Cotización
          </div>
          <div class="card-body">
            <form method="POST" action="../Controller/CotizacionController.php">
              <input type="hidden" name="create_quote">
              <div class="mb-3">
                <label for="client_id" class="form-label">Cliente:</label>
                <select name="client_id" id="client_id" class="form-select" required>
                  <option value="">Seleccione un cliente</option>
                  <?php foreach ($clientes as $client): ?>
                    <option value="<?php echo $client['id']; ?>">
                      <?php echo $client['username']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="vehicle_id" class="form-label">Vehículo:</label>
                <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                  <option value="">Seleccione un vehículo</option>
                  <?php foreach ($vehiculos as $vehicle): ?>
                    <option value="<?php echo $vehicle['id']; ?>">
                      <?php echo $vehicle['brand'] . " " . $vehicle['model']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-dark w-100">Crear Cotización</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Registrar Cuota
          </div>
          <div class="card-body">
            <form method="POST" action="../Controller/CotizacionController.php">
              <input type="hidden" name="create_cuota">
              <div class="mb-3">
                <label for="quote_id_cuota" class="form-label">Cotización:</label>
                <select name="quote_id" id="quote_id_cuota" class="form-select" required>
                  <option value="">Seleccione una cotización</option>
                  <?php foreach ($unsentQuotes as $quote): ?>
                    <option value="<?php echo $quote['id']; ?>">
                      Cotización #<?php echo $quote['id']; ?><?php echo isset($quote['cliente']) ? " - " . $quote['cliente'] : ""; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="monto" class="form-label">Monto:</label>
                <input type="number" name="monto" id="monto" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-dark w-100">Registrar Cuota</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Consultar Cotizaciones
          </div>
          <div class="card-body">
            <form method="GET" action="../Controller/CotizacionController.php">
              <input type="hidden" name="action" value="list">
              <div class="mb-3">
                <label for="client_id_list" class="form-label">Cliente:</label>
                <select name="client_id" id="client_id_list" class="form-select" required>
                  <option value="">Seleccione un cliente</option>
                  <?php foreach ($clientes as $client): ?>
                    <option value="<?php echo $client['id']; ?>">
                      <?php echo $client['username']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-dark w-100">Consultar Cotizaciones</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Consultar Cuotas
          </div>
          <div class="card-body">
            <form id="consultarCuotasForm">
              <div class="mb-3">
                <label for="quote_id_cuotas" class="form-label">Cotización:</label>
                <select name="quote_id" id="quote_id_cuotas" class="form-select" required>
                  <option value="">Seleccione una cotización</option>
                  <?php foreach ($unsentQuotes as $quote): ?>
                    <option value="<?php echo $quote['id']; ?>">
                      Cotización #<?php echo $quote['id']; ?><?php echo isset($quote['cliente']) ? " - " . $quote['cliente'] : ""; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-dark w-100">Ver Cuotas</button>
            </form>
            <div id="cuotasResult" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('consultarCuotasForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const quoteId = document.getElementById('quote_id_cuotas').value;
      if (!quoteId) {
        alert('Seleccione una cotización.');
        return;
      }
      fetch(`../Controller/CotizacionController.php?action=cuotas&quote_id=${quoteId}`)
        .then(response => response.json())
        .then(data => {
          let html = '';
          if (data.length === 0) {
            html = '<p>No se encontraron cuotas para esta cotización.</p>';
          } else {
            html += `<table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Meses</th>
                          <th>Pago Mensual</th>
                        </tr>
                      </thead>
                      <tbody>`;
            data.forEach(cuota => {
              html += `<tr>
                        <td>${cuota.id}</td>
                        <td>${cuota.months}</td>
                        <td>${cuota.monthly_payment}</td>
                      </tr>`;
            });
            html += '</tbody></table>';
          }
          document.getElementById('cuotasResult').innerHTML = html;
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('cuotasResult').innerHTML = '<p>Error al obtener cuotas.</p>';
        });
    });
  </script>
</body>
</html>
