<?php

session_start();

require_once '../../Model/CartModel.php';
//require_once '../../Controller/CartController.php';

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

// ✅ Corrección aquí:
$carrito = obtenerCarrito($_SESSION['user']['username']);
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
    <link rel="stylesheet" href="../../assets/css/Cart.css">
</head>

<body>
    <!-- Encabezado -->
    <header>
        <h1>Carrito Compras </h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hola, <?= htmlspecialchars($_SESSION['user']['username']); ?> |
                <a href="../View/LoginView.php?action=logout">Cerrar sesión</a>
            </p>
        <?php else: ?>
            <a href="../LoginView.php">Iniciar sesión</a> |
            <a href="../RegisterView.php">Registrarse</a>
        <?php endif; ?>
    </header>

    <!-- Barra de navegación completa -->

    <?php include('../Nav/Nav.php'); ?>

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
                <?php if (is_array($carrito) && !empty($carrito)): ?>
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
            <a href="../MenuView.php" class="btn btn-custom btn-menu">
                <i class="bi bi-house-door-fill"></i> Volver al Menú
            </a>

            <button class="btn btn-custom btn-pago" type="button" onclick="irAMetodoPago()">
                <i class="bi bi-wallet-fill"></i> Confirmar Pago
            </button>


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
                    <p>Para realizar el pago con tarjeta de crédito o en efectivo, debes visitar una de nuestras sedes:
                    </p>
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
    <?php include('../Nav/Footer.php'); ?>


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
                            user: '<?= htmlspecialchars($_SESSION['user']['username']) ?>'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la red');
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


        function eliminarProducto(cart_id) {
            if (!confirm('¿Desea eliminar este vehículo?')) return;

            fetch(`../../Controller/CartController.php?cart_id=${cart_id}`, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en la red');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById(`fila-${cart_id}`).remove();
                        alert('Producto eliminado correctamente');
                    } else {
                        alert('Error al eliminar el producto');
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar:', error);
                    alert('No se pudo conectar con el servidor');
                });
        }


        //lleva al método de pago
        function irAMetodoPago() {
            window.location.href = 'MetodoPagoView.php';
        }
    </script>

</body>

</html>