<?php
require_once '../Model/CartModel.php';
require_once '../Controller/CartController.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

// Obtener datos del carrito
$carrito = obtenerCarrito($_SESSION['user']);
$carrito = is_array($carrito) ? $carrito : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #1F2ADB;
            line-height: 1.6;
        }
        /* Encabezado */
        header {
            background: #468EDB; 
            color: #FFFFFF;  
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
        /* Barra de navegación completa */
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
        .container-content {
            margin-top: 20px;
            padding-bottom: 40px;
        }
        /* Estilos para la tabla del carrito */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        th, td {
            text-align: center !important;
            padding: 15px;
            vertical-align: middle;
        }
        th {
            background-color: #468EDB; 
            color: #FFFFFF; 
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background: #468EDB; 
            color: #FFFFFF; 
            font-size: 0.9rem;
            margin-top: 40px;
        }
        footer p {
            margin: 0;
        }
        /* Botones y animaciones */
        .btn-custom {
            min-width: 220px;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
        }
        .btn-menu {
            background: linear-gradient(145deg, #1F2ADB, #468EDB); 
            color: #FFFFFF !important;
            position: relative;
            overflow: hidden;
        }
        .btn-menu:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(70,142,219,0.3);
        }
        .btn-menu::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.5s;
        }
        .btn-menu:hover::after {
            animation: btn-shine 1.5s;
        }
        @keyframes btn-shine {
            0% { left: -50%; }
            100% { left: 150%; }
        }
        .btn-pago {
            background: linear-gradient(145deg, #28a745, #218838);
            color: #FFFFFF !important;
            transition: all 0.3s ease;
        }
        .btn-pago:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(40,167,69,0.3);
        }
        .btn-eliminar {
            background: linear-gradient(145deg, #1F2ADB, #468EDB);
            color: #FFFFFF !important;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .btn-eliminar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(70,142,219,0.3);
        }
        .btn-eliminar i {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <h1>Carrito de Compras</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
    </header>

    <!-- Barra de navegación completa -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="MenuView.php"><i class="bi bi-arrow-left"></i> Volver al Menú</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCart"
                aria-controls="navbarCart" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCart">
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
              <a class="nav-link active" aria-current="page" href="CartView.php"><i class="bi bi-cart3"></i> Carrito</a>
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
    <div class="container container-content">
        <h2 class="text-center my-4">Lista de Productos</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($carrito) && !empty($carrito)): ?>
                    <?php foreach ($carrito as $item): ?>
                        <tr id="fila-<?= $item['cart_id'] ?>">
                            <td><?= htmlspecialchars($item['cart_id']) ?></td>
                            <td><?= htmlspecialchars($item['vehicle_offer']) ?></td>
                            <td>$<?= number_format($item['price_offer'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td>$<?= number_format($item['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <button class="btn btn-eliminar" onclick="eliminarProducto(<?= $item['cart_id'] ?>)">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay productos en el carrito</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center gap-3 mt-4 mb-4">
            <!-- Botón Menú -->
            <a href="MenuView.php" class="btn btn-custom btn-menu">
                <i class="bi bi-house-door-fill"></i> Volver al Menú
            </a>

            <!-- Botón Confirmar Pago -->
            <div class="dropdown">
                <button class="btn btn-custom btn-pago dropdown-toggle" type="button" id="dropdownPayment" data-bs-toggle="dropdown">
                    <i class="bi bi-wallet-fill"></i> Confirmar Pago
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownPayment">
                    <li>
                        <button class="dropdown-item" type="button" onclick="confirmPayment('transferencia')">
                            <i class="bi bi-bank me-2"></i> Transferencia Bancaria
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" onclick="showSedeMessage()">
                            <i class="bi bi-credit-card me-2"></i> Tarjeta de Crédito
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" onclick="showSedeMessage()">
                            <i class="bi bi-cash-coin me-2"></i> Efectivo
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Modal para métodos de pago en sede -->
        <div class="modal fade" id="sedeModal" tabindex="-1" aria-labelledby="sedeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sedeModalLabel">Pago en Sede</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p>Para realizar el pago con tarjeta de crédito o en efectivo, debes visitar una de nuestras sedes:</p>
                        <ul>
                            <li>Sede San Joaquín, Heredia</li>
                            <li>Sede San Pablo, Heredia</li>
                        </ul>
                        <p>Horario de atención: Lunes a Viernes de 8:00 am a 6:00 pm</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y'); ?> Solis Motors. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmPayment(metodo) {
            if (metodo === 'transferencia') {
                fetch('../Controller/PaymentController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        payment_method: metodo,
                        user: '<?= $_SESSION['user'] ?>'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la red');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('¡Pago procesado exitosamente!');
                        window.location.href = 'OrderConfirmationView.php';
                    } else {
                        alert('Error en el pago: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al procesar el pago: ' + error.message);
                });
            } else {
                alert('Selecciona un método de pago válido.');
            }
        }

        function showSedeMessage() {
            new bootstrap.Modal(document.getElementById('sedeModal')).show();
        }

        function eliminarProducto(cartId) {
            if (confirm('¿Está seguro de eliminar este producto del carrito?')) {
                fetch(`../Controller/CartController.php?id=${cartId}`, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`fila-${cartId}`).remove();
                        alert('Producto eliminado correctamente');
                    } else {
                        alert('Error al eliminar el producto');
                    }
                });
            }
        }
    </script>
</body>
</html>
