<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

require_once '../Model/CotizacionModel.php';
$clientes = sp_listar_clientes();/**No tocar */
$vehiculos = sp_listar_vehiculos();/**No tocar */
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Cotizaciones</title>
  <!-- Google Fonts: Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Roboto', sans-serif;
    }
    .header {
      background-color: #dc3545;
      color: #fff;
      padding: 40px 20px;
      text-align: center;
      margin-bottom: 30px;
    }
    .header h1 {
      margin: 0;
      font-size: 2.5rem;
    }
  </style>
</head>
<body>
  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">SC Motors</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="InventarioView.php">Inventario</a></li>
          <li class="nav-item"><a class="nav-link" href="VentasView.php">Ventas</a></li>
          <li class="nav-item"><a class="nav-link" href="SoporteView.php">Soporte</a></li>
          <li class="nav-item"><a class="nav-link" href="FinanciamientoView.php">Financiamiento</a></li>
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="CotizacionView.php">Cotizaciones</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Encabezado principal -->
  <div class="header">
    <h1>Gestión de Cotizaciones</h1>
    <p class="lead">Administra tus cotizaciones de forma rápida y sencilla</p>
  </div>

  <div class="container">
    <!-- Mostrar mensaje (si existe) -->
    <?php if (!empty($msg)): ?>
      <div class="alert alert-info">
        <?php echo htmlspecialchars($msg); ?>
      </div>
    <?php endif; ?>

    <!-- Primer fila: Crear Cotización y Registrar Cuota -->
    <div class="row">
      <!-- Crear Cotización -->
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Crear Cotización
          </div>
          <div class="card-body">
            <form method="POST" action="../Controller/CotizacionController.php">
              <!-- Indicador para crear cotización -->
              <input type="hidden" name="create_quote">
              <div class="mb-3">
                <label for="client_id" class="form-label">Cliente:</label> <!--No tocar -->
                <select name="client_id" id="client_id" class="form-select" required><!--No tocar -->
                  <option value="">Seleccione un cliente</option><!--No tocar -->
                  <?php foreach ($clientes as $client): ?><!--No tocar -->
                    <option value="<?php echo $client['id']; ?>"><!--No tocar -->
                      <?php echo $client['username']; ?><!--No tocar -->
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="vehicle_id" class="form-label">Vehículo:</label><!--No tocar -->
                <select name="vehicle_id" id="vehicle_id" class="form-select" required><!--No tocar -->
                  <option value="">Seleccione un vehículo</option><!--No tocar -->
                  <?php foreach ($vehiculos as $vehicle): ?><!--No tocar -->
                    <option value="<?php echo $vehicle['id']; ?>"><!--No tocar -->
                      <?php echo $vehicle['brand'] . " " . $vehicle['model']; ?><!--No tocar -->
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-dark w-100">Crear Cotización</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Registrar Cuota -->
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Registrar Cuota
          </div>
          <div class="card-body">
            <form method="POST" action="../Controller/CotizacionController.php">
              <!-- Indicador para registrar cuota -->
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

    <!-- Segunda fila: Consultar Cotizaciones y Consultar Cuotas -->
    <div class="row">
      <!-- Consultar Cotizaciones -->
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white">
            Consultar Cotizaciones
          </div>
          <div class="card-body">
            <form method="GET" action="../Controller/CotizacionController.php">
              <input type="hidden" name="action" value="list">
              <div class="mb-3">
                <label for="client_id_list" class="form-label">Cliente:</label><!--No tocar -->
                <select name="client_id" id="client_id_list" class="form-select" required><!--No tocar -->
                  <option value="">Seleccione un cliente</option><!--No tocar -->
                  <?php foreach ($clientes as $client): ?><!--No tocar -->
                    <option value="<?php echo $client['id']; ?>"><!--No tocar -->
                      <?php echo $client['username']; ?><!--No tocar -->
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-dark w-100">Consultar Cotizaciones</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Consultar Cuotas -->
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
            <!-- Resultado de la consulta de cuotas se mostrará aquí -->
            <div id="cuotasResult" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.container -->

  <!-- Bootstrap 5 JS Bundle con Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script para consultar cuotas vía AJAX -->
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
