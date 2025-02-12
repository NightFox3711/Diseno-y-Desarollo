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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        /* ===== ESTILOS GENERALES ===== */
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #808080;
            color: #ffffff;
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
            color: #ff0000;
            text-decoration: none;
            font-weight: bold;
        }

        header a:hover {
            text-decoration: underline;
        }

        nav {
            background: #333;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            display: block;
            padding: 15px 25px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }

        nav ul li a:hover {
            background: #ff0000;
            color: #ffffff;
            transform: scale(1.05);
        }

        .titulo-principal {
            font-family: 'Roboto Condensed', sans-serif;
            color: #b80b0b;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            margin: 2rem 0;
            font-size: 2.5rem;
        }

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
            background-color: #b80b0b;
            color: white;
            padding: 15px;
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

        footer {
            text-align: center;
            padding: 15px;
            background: #808080; /* Gris oscuro */
            color: #ffffff; /* Blanco */
            position: relative;
            bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
        }

        .dropdown-menu {
            border: 1px solid #b80b0b;
        }

        .dropdown-item:active {
            background-color: #b80b0b !important;
            color: white !important;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #b80b0b;
        }

        .modal-title {
            color: #b80b0b;
            font-weight: bold;
        }

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
        background: linear-gradient(145deg, #b80b0b, #9a0909);
        color: white !important;
        position: relative;
        overflow: hidden;
    }

        .btn-menu:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(184, 11, 11, 0.3);
        }

        .btn-pago {
            background: linear-gradient(145deg, #28a745, #218838);
            color: white !important;
        }

        .btn-pago:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
        }

        /* Efecto de brillo al hacer hover */
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

        /* Mejoras para el dropdown */
        .dropdown-menu {
            border-radius: 15px;
            padding: 0.5rem;
            border: 1px solid #b80b0b;
        }

        .dropdown-item {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            margin: 0.3rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #b80b0b15 !important;
            color: #b80b0b !important;
        }

        @media (max-width: 768px) {
            .btn-custom {
                width: 100%;
                max-width: 300px;
            }
            
            .d-flex {
                flex-direction: column;
                gap: 1.5rem !important;
            }
        }


        .btn-eliminar {
            background: linear-gradient(145deg, #dc3545, #c82333);
            color: white !important;
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
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-eliminar i {
            font-size: 1.1rem;
        }

        /* Nueva columna en la tabla */
        th:last-child, td:last-child {
            width: 15%;
        }

        .text-center.py-4 {
            padding: 2rem 0;
            color: #666;
            font-style: italic;
        }
        </style>
</head>

<body>
    <header>
        <h1>Carrito de Compras</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
    </header>

    <nav>
        <ul>
            <li><a href="LoginView.php">Login</a></li>
            <li><a href="RegisterView.php">Registro</a></li>
            <li><a href="SoporteView.php">Soporte</a></li>
            <li><a href="VentasView.php">Ventas</a></li>
            <li><a href="InventarioView.php">Inventario</a></li>
            <li><a href="OfertasView.php">Ofertas</a></li>
            <li><a href="CartView.php">Carrito</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="contenedor-principal">
        <h2 class="titulo-principal text-center">Lista de Productos</h2>
        
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
                <?php foreach ($carrito as $carritos): ?>
                <tr id="fila-<?= $carritos['cart_id'] ?>">
                    <td><?= htmlspecialchars($carritos['cart_id']) ?></td>
                    <td><?= htmlspecialchars($carritos['vehicle_offer']) ?></td>
                    <td>$<?= number_format($carritos['price_offer'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($carritos['quantity']) ?></td>
                    <td>$<?= number_format($carritos['total_price'], 0, ',', '.') ?></td>
                    <td>
                        <button class="btn btn-eliminar" 
                                onclick="eliminarProducto(<?= $carritos['cart_id'] ?>)">
                            <i class="bi bi-trash"></i>
                            Eliminar
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
                <i class="bi bi-house-door-fill"></i>Volver al Menú</a>

            <!-- Botón Confirmar Pago -->
            <div class="dropdown">
        <button class="btn btn-custom btn-pago dropdown-toggle" type="button" id="dropdownPayment" data-bs-toggle="dropdown">
            <i class="bi bi-wallet-fill"></i>
            Confirmar Pago
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownPayment">
            <li>
                <button class="dropdown-item" type="button" onclick="confirmPayment('transferencia')">
                    <i class="bi bi-bank me-2"></i>
                    Transferencia Bancaria
                </button>
            </li>
            <li>
                <button class="dropdown-item" type="button" onclick="showSedeMessage()">
                    <i class="bi bi-credit-card me-2"></i>
                    Tarjeta de Crédito
                </button>
            </li>
            <li>
                <button class="dropdown-item" type="button" onclick="showSedeMessage()">
                    <i class="bi bi-cash-coin me-2"></i>
                    Efectivo
                </button>
            </li>
        </ul>
    </div>
</div>

        <!-- Modal para métodos de pago en sede -->
        <div class="modal fade" id="sedeModal" tabindex="-1">

            <!-- Modal para métodos de pago en sede -->
            <div class="modal fade" id="sedeModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pago en Sede</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<script>
// Función para confirmar pago por transferencia
        function confirmPayment(metodo) {
            console.log("Método de pago seleccionado:", metodo); // Debug
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
                    console.log("Respuesta del servidor:", data); // Debug
                    if (data.success) {
                        alert('Pago procesado exitosamente!');
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

// Función para mostrar mensaje de sede
        function showSedeMessage() {
            new bootstrap.Modal(document.getElementById('sedeModal')).show();
        }

// Función para eliminar producto del carrito
        function eliminarProducto(cartId) {
            if(confirm('¿Está seguro de eliminar este producto del carrito?')) {
                fetch(`../Controller/CartController.php?id=${cartId}`, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Eliminar fila visualmente
                        document.getElementById(`fila-${cartId}`).remove();
                        // Actualizar totales si es necesario
                        alert('Producto eliminado correctamente');
                    } else {
                        alert('Error al eliminar el producto');
                    }
                });
            }
        }
</script>

    </a>
    </div>

    <footer>
        <p>&copy; <?= date('Y'); ?> SC Motors. Todos los derechos reservados.</p>
    </footer>
</body>
</html>