<?php
/*session_start();
if (!isset($_SESSION['user']) || $_SESSION['rol'] !== 'admin') {
   header('Location: LoginView.php');
    exit();
}*/


session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../Controller/VentasController.php";

// Verificamos sesión
if (!isset($_SESSION['user']['username'])) {
    exit("No hay sesión activa.");
}

// Obtenemos al usuario actual
$user = $_SESSION['user'];

// Si el modelo espera un ID, por ejemplo id_card:
$id_customer = obtenerIdCliente($user['username']);

// Obtenemos vehículos disponibles
$vehiclesDisponibles = obtenervehiculosDisponibles();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Ventas</title>
    <link rel="stylesheet" href="../assets/css/Reportes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        function calcularprice() {
            let priceBase = parseFloat(document.getElementById("price_base").value);
            let term = parseInt(document.getElementById("term").value);
            let applied_discount = parseFloat(document.getElementById("applied_discount").value) / 100;
            let interest = term === 3 ? 5 : term === 6 ? 10 : 15;
            let priceFinal = priceBase * (1 + interest / 100) * (1 - applied_discount);
            document.getElementById("estimated_price").value = priceFinal.toFixed(2);
            document.getElementById("interest").value = interest;
        }

        function actualizarprice() {
            let vehicleSelect = document.getElementById("vehicle");
            let priceBase = vehicleSelect.options[vehicleSelect.selectedIndex].getAttribute("data-price");
            document.getElementById("price_base").value = priceBase;
            calcularprice();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("btnCotizacion");
            const contenedor = document.getElementById("contenedorCotizaciones");
            btn.addEventListener("click", () => {
                contenedor.style.display = contenedor.style.display === "none" ? "block" : "none";
            });

            new DataTable('#tablaCotizaciones');
        });
    </script>
    <style>
        /* Estilo para el encabezado */
        header {
            background:#1F3C6E;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 600;
        }

        header p {
            margin: 5px 0 0;
            font-size: 1rem;
            color: white; 
        }

        header a {
            color: white !important;
            font-weight: bold;
            text-decoration: none;
        }

        header a:hover {
            text-decoration: underline;
        }

        /* Estilo para el nav */
        nav.navbar {
            background-color: #1F3C6E;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        nav.navbar .navbar-brand {
            font-weight: 600;
            color: #ffffff;
            transition: color 0.3s ease;
        }

        nav.navbar .navbar-brand:hover {
            color: #1F3C6E;
        }

        nav.navbar .navbar-nav .nav-link {
            color: #ffffff; /* Asegura que el texto sea blanco por defecto */
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 8px;
            padding: 10px 16px;
        }

        nav.navbar .navbar-nav .nav-link:hover {
            background-color: #345c9c;
            transform: scale(1.05);
            color: #ffffff; /* Asegura que el texto permanezca blanco al pasar el mouse */
        }

        nav.navbar .navbar-nav {
            gap: 15px;
        }
        .btn-custom {
            background-color: #1F3C6E;
            color: white;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #345c9c;
        }
    </style>
</head>

<body>
    <header>
        <h1>Gestión de Ventas</h1>
    </header>
     

    <?php include('../Nav/Nav.php'); ?>
        
        <div class="container mt-5">
            <div class="text-center">
                <button type="button" class="btn btn-custom w-25 mb-4" id="btnCotizacion">
                    <i class="bi bi-file-earmark-text"></i> Cotizaciones
                </button>
            </div>
        
            <div id="contenedorCotizaciones" style="display: none;" class="container-fluid">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCotizacion">
                        Registrar Cotización
                    </button>
                </div>
        
                <div class="table-responsive">
                    <table id="tablaCotizaciones" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Precio Estimado</th>
                                <th>Plazo</th>
                                <th>Interés</th>
                                <th>Descuento</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <tr>
                                    <td><?= $cotizacion['id_quote'] ?></td>
                                    <td><?= $cotizacion['customer'] ?></td>
                                    <td><?= $cotizacion['vehicle'] ?></td>
                                    <td><?= $cotizacion['estimated_price'] ?></td>
                                    <td><?= $cotizacion['term'] ?></td>
                                    <td><?= $cotizacion['interest'] ?></td>
                                    <td><?= $cotizacion['applied_discount'] ?>%</td>
                                    <td><?= $cotizacion['quote_date'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Modal Cotización -->
        <div class="modal fade" id="modalCotizacion" tabindex="-1" aria-labelledby="modalCotizacionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="../../Controller/VentasController.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCotizacionLabel">Registrar Cotización</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <input type="hidden" name="id_customer" value="<?= $id_customer ?>">
        
                            <div class="col-md-6">
                                <label class="form-label">Vehículo:</label>
                                <select class="form-select" name="id_vehicle" id="vehicle" onchange="actualizarprice()" required>
                                    <option value="">Seleccione un vehículo</option>
                                    <?php foreach ($vehiclesDisponibles as $vehicle) : ?>
                                        <option value="<?= $vehicle['id_vehicle'] ?>" data-price="<?= $vehicle['price'] ?>">
                                            <?= $vehicle['brand'] . " " . $vehicle['model'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" id="price_base" value="">
                            </div>
        
                            <div class="col-md-6">
                                <label class="form-label">Plazo:</label>
                                <select class="form-select" name="term" id="term" onchange="calcularprice()" required>
                                    <option value="3">3 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="12">12 meses</option>
                                </select>
                            </div>
        
                            <div class="col-md-6">
                                <label class="form-label">Descuento:</label>
                                <select class="form-select" name="applied_discount" id="applied_discount" onchange="calcularprice()">
                                    <option value="0">Sin descuento</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                </select>
                            </div>
        
                            <div class="col-md-6">
                                <label class="form-label">Interés (%):</label>
                                <input class="form-control" type="text" name="interest" id="interest" readonly>
                            </div>
        
                            <div class="col-md-12">
                                <label class="form-label">Precio Estimado:</label>
                                <input class="form-control" type="text" name="estimated_price" id="estimated_price" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Guardar Cotización</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
        
        </body>
        </html>





<?php
require_once "../../Model/Database.php";
require_once "../../Model/VentasModel.php";

// Obtener datos de vehículos y clientes
$vehiclesDisponibles = obtenervehiculosDisponibles();
$clientesDisponibles = obtenerClientesDisponibles();
$ventas = obtenerVentas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar Venta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="text-center">
            <button type="button" class="btn btn-custom w-25 mb-4" id="btnRegistrarVenta">
                <i class="bi bi-cart-plus-fill"></i> Registrar Venta
            </button>
        </div>
    
        <div id="contenedorVentas" style="display: none;" class="container-fluid">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarVenta">
                    Registrar Venta
                </button>
            </div>
    
            <div class="table-responsive">
                <table id="tablaVentas" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Total</th>
                            <th>Saldo Pendiente</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta) : ?>
                            <tr>
                                <td><?= $venta['id_sales'] ?></td>
                                <td><?= $venta['customer'] ?></td>
                                <td><?= $venta['brand'] . " " . $venta['model'] ?></td>
                                <td>₡<?= number_format($venta['total'], 2) ?></td>
                                <td>₡<?= number_format($venta['pending_balance'], 2) ?></td>
                                <td><?= $venta['status'] ?></td>
                                <td><?= $venta['sale_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Registrar Venta -->
    <div class="modal fade" id="modalRegistrarVenta" tabindex="-1" aria-labelledby="modalRegistrarVentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../../Controller/VentasController.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistrarVentaLabel">Registrar Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body row g-3">
                       
    
                        <div class="col-md-6">
                            <label class="form-label">Cliente:</label>
                            <select class="form-select" name="id_customer" id="cliente" required>
                                <option value="">Seleccione un Cliente</option>
                                <?php foreach ($clientesDisponibles as $cliente) : ?>
                                    <option value="<?= $cliente['id_username'] ?>"><?= $cliente['username'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Vehículo:</label>
                            <select class="form-select" name="id_vehicle" id="vehicle" onchange="actualizarTotal()" required>
                                <option value="">Seleccione un vehículo</option>
                                <?php foreach ($vehiclesDisponibles as $vehicle) : ?>
                                    <option value="<?= $vehicle['id_vehicle'] ?>" data-price="<?= $vehicle['price'] ?>">
                                        <?= $vehicle['brand'] . " " . $vehicle['model'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Total:</label>
                            <input class="form-control" type="text" name="total" id="total" readonly>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Monto Cancelado:</label>
                            <input class="form-control" type="number" name="monto_cancelado" id="monto_cancelado" required>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Saldo Pendiente:</label>
                            <input class="form-control" type="text" name="pending_balance" id="pending_balance" readonly required>
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Estado:</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="Completada">Completada</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Anulada">Anulada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Venta</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById("btnRegistrarVenta").addEventListener("click", function () {
            var contenedorVentas = document.getElementById("contenedorVentas");
            if (contenedorVentas.style.display === "none") {
                contenedorVentas.style.display = "block";
            } else {
                contenedorVentas.style.display = "none";
            }
        });
    document.getElementById("vehicle").addEventListener("change", function () {
      var vehicle = this.options[this.selectedIndex];
      var price = vehicle.getAttribute("data-price");
      document.getElementById("total").value = price;
      actualizarSaldo();
    });

    document.getElementById("monto_cancelado").addEventListener("input", function () {
      actualizarSaldo();
    });

    function actualizarSaldo() {
      var total = parseFloat(document.getElementById("total").value) || 0;
      var cancelado = parseFloat(document.getElementById("monto_cancelado").value) || 0;
      var saldoPendiente = total - cancelado;
      document.getElementById("pending_balance").value = saldoPendiente.toFixed(2);
    }
  </script>

</body>

</html>



<?php

require_once "../../Controller/VentasController.php"; // Cargar el controlador

if (!isset($_SESSION['user'])) {
    exit("No hay sesión activa.");
}

// Obtenemos al usuario actual
$user = $_SESSION['user'];

$id_customer = obtenerIdCliente($user['username']);

// Obtenemos vehículos disponibles
$vehiclesDisponibles = obtenervehiculosDisponibles();
$ventasDisponibles = obtenerVentasPendientes();// Obtener solo ventas pendientes
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones</title>
    <!-- Agrega Bootstrap CSS para estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="text-center">
            <button type="button" class="btn btn-custom w-25 mb-4" id="btnDevoluciones">
                <i class="bi bi-arrow-left-right"></i> Devoluciones
            </button>
        </div>

        <div id="contenedorDevoluciones" style="display: none;" class="container-fluid">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDevolucion">
                    Registrar Devolución
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaDevoluciones" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Venta</th>
                            <th>Cliente</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($devoluciones as $devolucion) : ?>
                            <tr>
                                <td><?= $devolucion['id_refound'] ?></td>
                                <td><?= $devolucion['id_sales'] ?></td>
                                <td><?= $devolucion['customer'] ?></td>
                                <td><?= $devolucion['reason'] ?></td>
                                <td><?= $devolucion['status'] ?></td>
                                <td><?= $devolucion['return_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Devolución -->
    <div class="modal fade" id="modalDevolucion" tabindex="-1" aria-labelledby="modalDevolucionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../../Controller/VentasController.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDevolucionLabel">Registrar Devolución</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="id_customer" value="<?= $id_customer ?>">

                        <div class="col-md-6">
                            <label class="form-label">Venta:</label>
                            <select class="form-select" name="id_sales" id="sales" required>
                                <option value="">Seleccione una Venta</option>
                                <?php foreach ($ventasDisponibles as $venta) : ?>
                                    <option value="<?= $venta['id_sales'] ?>">
                                        <?= "Venta ID: " . $venta['id_sales'] . " - Total: " . $venta['total'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Motivo de la Devolución:</label>
                            <textarea class="form-control" name="reason" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado:</label>
                            <select class="form-select" name="status" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Aprobada">Aprobada</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Devolución</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Agregar Bootstrap JS para la funcionalidad del modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar y ocultar el contenedor de devoluciones al hacer clic en el botón
        document.getElementById('btnDevoluciones').addEventListener('click', function () {
            const contenedor = document.getElementById('contenedorDevoluciones');
            contenedor.style.display = contenedor.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>






</html>

<?php

require_once "../../Controller/VentasController.php";

// Obtener las facturas registradas
$facturaModel = new VentasModel();
$facturas = $facturaModel->obtenerFacturas();

// Obtener las ventas con status Pendiente y Completada
$ventasDisponibles = obtenerVentasPendientesYCompletadas();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registrar Factura</title>
    <!-- Agrega los enlaces de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <!-- Botón para mostrar el formulario de facturas -->
        <div class="text-center">
            <button type="button" class="btn btn-custom w-25 mb-4" id="btnFactura">
                <i class="bi bi-file-earmark-check"></i> Facturas
            </button>
        </div>

        <!-- Contenedor de facturas, que se mostrará/ocultará dinámicamente -->
        <div id="contenedorFacturas" style="display: none;" class="container-fluid">
            <!-- Botón para abrir el modal de registrar factura -->
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFactura">
                    Registrar Factura
                </button>
            </div>

            <!-- Tabla de facturas -->
            <div class="table-responsive">
                <table id="tablaFacturas" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>ID Venta</th>
                            <th>Fecha Emisión</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facturas as $factura) : ?>
                            <tr>
                                <td><?= $factura['id_invoice'] ?></td>
                                <td><?= $factura['id_sales'] ?></td>
                                <td><?= $factura['issue_date'] ?></td>
                                <td>$<?= number_format($factura['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Registrar Factura -->
    <div class="modal fade" id="modalFactura" tabindex="-1" aria-labelledby="modalFacturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../../Controller/VentasController.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFacturaLabel">Registrar Factura</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <!-- Selección de venta -->
                        <div class="col-md-12">
                            <label class="form-label">Venta:</label>
                            <select class="form-select" name="id_sales" id="venta" required>
                                <option value="">Seleccione una Venta</option>
                                <?php foreach ($ventasDisponibles as $venta) : ?>
                                    <option value="<?= $venta['id_sales'] ?>">
                                        <?= "Venta ID: " . $venta['id_sales'] . " - Total: " . $venta['total'] . " - status: " . $venta['status'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Total -->
                        <div class="col-md-12">
                            <label class="form-label" for="total">Total:</label>
                            <input class="form-control" type="number" step="0.01" name="total" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="registrar_factura" class="btn btn-success">Registrar Factura</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Lógica para mostrar/ocultar el contenedor de facturas cuando se hace clic en el botón
        document.getElementById('btnFactura').addEventListener('click', function() {
            var contenedor = document.getElementById('contenedorFacturas');
            contenedor.style.display = contenedor.style.display === 'none' ? 'block' : 'none';
        });
    </script>

</body>

</html>





<?php

require_once "../../Controller/VentasController.php";
$ventasDisponibles = obtenerVentasPendientesYCompletadas();
$facturas = obtenerfacturas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
    <!-- Agregar Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <div class="text-center">
            <button type="button" class="btn btn-custom w-25 mb-4" id="btnMostrarPagos">
                <i class="bi bi-file-earmark-text"></i> Pagos Registrados
            </button>
        </div>

        <div id="contenedorPagos" style="display: none;" class="container-fluid">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPago">
                    Registrar Pago
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaPagos" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID Pago</th>
                            <th>ID Venta</th>
                            <th>Método de Pago</th>
                            <th>Monto</th>
                            <th>Meses</th>
                            <th>Fecha Pago</th>
                            <th>Saldo Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $pagos = obtenerPagos();
                        foreach ($pagos as $pago) : ?>
                            <tr>
                                <td><?= $pago['id_payment'] ?></td>
                                <td><?= $pago['id_sales'] ?></td>
                                <td><?= $pago['payment_method'] ?></td>
                                <td>$<?= number_format($pago['amount'], 2) ?></td>
                                <td><?= $pago['months'] ?: '-' ?></td>
                                <td><?= $pago['payment_date'] ?></td>
                                <td>$<?= number_format($pago['pending_balance'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Pago -->
    <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../../Controller/VentasController.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagoLabel">Registrar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <label>Venta:</label>
                        <select name="id_sales" id="venta" required>
                            <option value="">Seleccione una Venta</option>
                            <?php foreach ($facturas as $factura) { ?>
                                <option value="<?= $factura['id_invoice'] ?>">
                                    <?= "Factura ID: " . $factura['id_invoice'] . " - Total: " . $factura['total'] ?>
                                </option>
                            <?php } ?>
                        </select><br>

                        <label for="payment_method">Método de Pago:</label>
                        <select name="payment_method" required>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Financiamiento">Financiamiento</option>
                        </select>

                        <label for="amount">Monto:</label>
                        <input type="number" step="0.01" name="amount" required>

                        <label for="months">Meses (solo si es financiamiento):</label>
                        <select name="months">
                            <option value="0">0 Meses </option>
                            <option value="3">3 meses</option>
                            <option value="6">6 meses</option>
                            <option value="12">12 meses</option>
                        </select>

                        <label for="pending_balance">Saldo Pendiente:</label>
                        <input type="number" step="0.01" name="pending_balance" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Registrar Pago</button>
                        <input type="hidden" name="registrar_pago" value="1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script para mostrar y ocultar la tabla de pagos
        document.getElementById('btnMostrarPagos').addEventListener('click', function () {
            var contenedorPagos = document.getElementById('contenedorPagos');
            if (contenedorPagos.style.display === 'none') {
                contenedorPagos.style.display = 'block';
            } else {
                contenedorPagos.style.display = 'none';
            }
        });
    </script>

</body>

</html>









<?php

require_once "../../Controller/VentasController.php";




// Verificamos sesión
if (!isset($_SESSION['user'])) {
    exit("No hay sesión activa.");
}

// Obtenemos al usuario actual
$user = $_SESSION['user'];
$id_customer = obtenerIdCliente($user['username']);
$vehiclesDisponibles = obtenervehiculosDisponibles();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
    <!-- Asegúrate de incluir Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <!-- Botón para mostrar la sección de reservas -->
        <div class="text-center">
            <button type="button" class="btn btn-custom w-25 mb-4" id="btnReservas">
                <i class="bi bi-file-earmark-text"></i> Reservas
            </button>
        </div>

        <!-- Contenedor de reservas -->
        <div id="contenedorReservas" style="display: none;" class="container-fluid">
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReserva">
                    Registrar Reserva
                </button>
            </div>

            <!-- Tabla de Reservas -->
            <div class="table-responsive">
                <table id="tablaReservas" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>ID Reserva</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Monto</th>
                            <th>Fecha Reserva</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $reserva): ?>
                            <tr>
                                <td><?= htmlspecialchars($reserva['id_reservation']) ?></td>
                                <td><?= htmlspecialchars($reserva['customer']) ?></td>
                                <td><?= htmlspecialchars($reserva['brand'] . " " . $reserva['model']) ?></td>
                                <td><?= htmlspecialchars($reserva['reservation_amount']) ?></td>
                                <td><?= htmlspecialchars($reserva['reservation_date']) ?></td>
                                <td><?= htmlspecialchars($reserva['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="../../Controller/VentasController.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReservaLabel">Registrar Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="id_customer" value="<?= $id_customer ?>">

                        <div class="col-md-6">
                            <label class="form-label">Vehículo:</label>
                            <select class="form-select" name="id_vehicle" id="vehicle" required>
                                <option value="">Seleccione un vehículo</option>
                                <?php foreach ($vehiclesDisponibles as $vehicle): ?>
                                    <option value="<?= $vehicle['id_vehicle'] ?>" data-price="<?= $vehicle['price'] ?>">
                                        <?= $vehicle['brand'] . " " . $vehicle['model'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Duración de la Reserva:</label>
                            <select class="form-select" name="monto_reserva" required>
                                <option value="1000.00">1 mes - $1000</option>
                                <option value="2000.00">2 meses - $2000</option>
                                <option value="3000.00">3 meses - $3000</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado:</label>
                            <select class="form-select" name="status" required>
                                <option value="Reservado">Reservado</option>
                                <option value="Disponible">Disponible</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Registrar Reserva</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Muestra y oculta la sección de reservas al hacer clic en el botón
        document.getElementById("btnReservas").onclick = function () {
            var contenedor = document.getElementById("contenedorReservas");
            contenedor.style.display = contenedor.style.display === "none" ? "block" : "none";
        };
    </script>
</body>

</html>



<?php
// Incluir el controlador para obtener los reportes
require_once "../../Controller/VentasController.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Ventas</title>
    <style>
        body {
          background-color: #f4f6fa;
          font-family: 'Segoe UI', sans-serif;
        }
    
        .container {
          max-width: 900px;
          margin-top: 30px;
        }
    
        .form-label {
          font-weight: 600;
        }
    
        .form-section {
          background: #ffffff;
          border-radius: 15px;
          padding: 30px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    
        h2 {
          color: #1F3C6E;
          font-weight: bold;
          margin-bottom: 20px;
        }
    
        .btn-custom {
          background-color: #1F3C6E;
          color: #fff;
          font-weight: 600;
        }
    
        .btn-custom:hover {
          background-color: #4A90E2;
          color: #fff;
        }
    
        table {
          background-color: #fff;
        }
    
        th {
          background-color: #1F3C6E;
          color: #fff;
        }
    
        td,
        th {
          text-align: center;
          vertical-align: middle;
        }
        .table th {
  background-color: #1F3C6E;
  color: white;
  font-weight: bold;
  text-transform: uppercase;
}

.table td {
  background-color: #f9fbff;
  color: #333;
  vertical-align: middle;
}

.form-section {
  background: #ffffff;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

      </style>
</head>

<body>
<div class="text-center">
    <form action="../../Controller/VentasController.php" method="POST">
        <button type="submit" name="generar_reporte" class="btn btn-custom w-25 mb-4">
            <i class="bi bi-file-earmark-text"></i> Generar Reporte
        </button>
    </form>
</div>
<div class="container mt-5">
  <div class="form-section">
    <h2 class="text-center mb-4">Historial de Reportes de Ventas</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead>
          <tr>
            <th>ID Reporte</th>
            <th>Fecha del Reporte</th>
            <th>Total de Ventas</th>
            <th>Cantidad de Ventas</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $reportes = obtenerReportes(); 
          foreach ($reportes as $reporte) : ?>
            <tr>
              <td><?= $reporte['id_report'] ?></td>
              <td><?= $reporte['report_date'] ?></td>
              <td>$<?= number_format($reporte['total_sales'], 2) ?></td>
              <td><?= $reporte['sales_count'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>

</html>
