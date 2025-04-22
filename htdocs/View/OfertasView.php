<?php
session_start();

require_once '../Model/OfertasModel.php';
require_once '../Controller/OfertasController.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
    header('Location: LoginView.php');
    exit();
}

$user_name = isset($_SESSION['user']['user_name']) ? htmlspecialchars($_SESSION['user']['user_name']) : '';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$ofertas = obtenerOfertas($searchTerm);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solis Motors - Menú Ofertas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/Ofertas.css">
</head>

<body>
    <!-- Encabezado -->
    <header style="margin: 0; padding: 0;">
        <h1 class="text-white" style="margin: 0; padding: 0;">Portafolio de Vehículos</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p class="text-white" style="margin: 0; padding: 0;">Hola, <?= htmlspecialchars($_SESSION['user']['username']); ?> | <a class="text-white" href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
        <?php else: ?>
            <p style="margin: 0; padding: 0;"><a class="text-white" href="../LoginView.php">Iniciar sesión</a> | <a class="text-white" href="../RegisterView.php">Registrarse</a></p>
        <?php endif; ?>
    </header>

    <!-- Barra de navegación completa justo debajo del encabezado -->
    <nav class="navbar navbar-expand-lg" style="background-color: #1F3C6E;">
        <div class="container-fluid px-3"> <!-- px-3 reduce el padding horizontal -->
            <a class="navbar-brand text-white volver-menu" href="MenuView.php">
                <i class="bi bi-arrow-left"></i> Volver al menú
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOfertas"
                aria-controls="navbarOfertas" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarOfertas">
                <ul class="navbar-nav d-flex justify-content-center w-100">

                    <li class="nav-item">
                        <a class="nav-link text-white" href="Ventas/VentasView.php"><i class="bi bi-piggy-bank"></i> Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Inventario/InventarioView.php"><i class="bi bi-box"></i> Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Ventas/CartView.php"><i class="bi bi-cart3"></i> Carrito</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal de contenido -->
    <div class="container container-content">
        <h1 class="text-center titulo-principal">Catálogo de Ofertas</h1>
        <div class="search-container mb-4">
            <div class="d-flex justify-content-center mb-4">
                <a href="../View/RegistroOfertas/RegistroOfertasView.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Registrar Nueva Oferta
                </a>
            </div>
            <!-- <-- margen inferior agregado -->
            <form method="GET" class="d-flex justify-content-center">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Buscar marca de vehículo"
                        value="<?= isset($searchTerm) ? htmlspecialchars($searchTerm) : ''; ?>"
                        aria-label="Buscar marca de vehículo">
                    <button class="btn btn-outline-success ms-4" type="submit" aria-label="Buscar vehículo">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-4">
            <?php foreach ($ofertas as $oferta): ?>
                <div class="col">
                    <div class="card h-100 card-oferta">
                        <img src="RegistroOfertas/<?= $oferta['img_vehicle_offer'] ?>"
                            class="card-img-top card-img-custom"
                            alt="<?= htmlspecialchars($oferta['vehicle_offer']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold mb-3"><?= $oferta['vehicle_offer'] ?></h5>
                            <p class="card-text fs-4 mb-4" style="color: #1F2ADB;">
                                $<?= number_format($oferta['price_offer'], 0, ',', '.') ?>
                            </p>
                            <p class="card-text fs-5 mb-3" style="color: #1F2ADB;">
                                Estado: <strong><?= htmlspecialchars($oferta['status_vehicle']) ?></strong>
                            </p>

                            <button class="btn btn-agregar"
                                onclick="agregarAlCarrito('<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?>', <?= $oferta['id_offer'] ?>)"
                                <?= !isset($_SESSION['user']) ? 'disabled title="Debe iniciar sesión para agregar un vehículo a las Ofertas"' : '' ?>>
                                Agregar al Carrito
                            </button>

                            <button class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#infoModal_<?= $oferta['id_offer'] ?>">
                                Ver Información
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Modal de Información -->
                <div class="modal fade" id="infoModal_<?= $oferta['id_offer'] ?>" tabindex="-1"
                    aria-labelledby="infoModalLabel_<?= $oferta['id_offer'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModalLabel_<?= $oferta['id_offer'] ?>">
                                    Información de la Oferta
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="RegistroOfertas/<?= $oferta['img_vehicle_offer'] ?>"
                                    class="card-img-top card-img-custom mb-3"
                                    alt="<?= htmlspecialchars($oferta['vehicle_offer']) ?>">
                                <p><strong>Vehículo:</strong> <?= htmlspecialchars($oferta['vehicle_offer']) ?></p>
                                <p><strong>Precio:</strong> $<?= number_format($oferta['price_offer'], 0, ',', '.') ?></p>
                                <p><strong>Estado:</strong> <?= htmlspecialchars($oferta['status_vehicle']) ?></p>
                                <p><strong>Kilometraje:</strong> <?= htmlspecialchars($oferta['km_vehicle']) ?> km</p>
                                <p><strong>Tipo:</strong> <?= htmlspecialchars($oferta['type_vehicle']) ?></p>
                                <p><strong>Tracción:</strong> <?= htmlspecialchars($oferta['traction_vehicle']) ?></p>
                                <p><strong>Motor:</strong> <?= htmlspecialchars($oferta['motor_vehicle']) ?> CC</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <span class="terms-link" data-bs-toggle="modal" data-bs-target="#termsModal">
                Términos y Condiciones
            </span>
        </div>
        <!-- Modal de Términos y Condiciones -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" style="text-align: justify;">
                        <p>
                            A continuación se detallan los términos y condiciones aplicables a todas las ofertas publicadas en nuestro sitio:
                        </p>
                        <ul>
                            <li><strong>Disponibilidad:</strong> Las ofertas están sujetas a la disponibilidad de los vehículos en el inventario.</li>
                            <li><strong>Validez:</strong> Las ofertas tienen una validez limitada y pueden cambiar sin previo aviso.</li>
                            <li><strong>Precios:</strong> Los precios incluyen impuestos, pero pueden variar según la región o el tipo de financiamiento.</li>
                            <li><strong>Responsabilidad:</strong> El comprador es responsable de verificar las características y condiciones finales del vehículo antes de concretar la compra.</li>
                            <li><strong>Garantía:</strong> Las garantías ofrecidas pueden variar en función del modelo, año y estado del vehículo.</li>
                            <li><strong>Financiamiento:</strong> Cualquier opción de financiamiento está sujeta a la aprobación de crédito y a los términos de la entidad financiera.</li>
                        </ul>
                        <p>
                            Para más información, contáctanos a través de nuestros canales de atención o visita nuestras sucursales.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p class="text-white">&copy; <?= date('Y'); ?> Solis Motors. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function agregarAlCarrito(user_name, offer_id) {
            if (!user_name) {
                alert('Debe iniciar sesión para agregar un vehículo a Ofertas.');
                window.location.href = '../../View/LoginView.php';
                return;
            }
            try {
                const res = await fetch('../Controller/CartController.php', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        user_name,
                        offer_id
                    })
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                if (data.success) {
                    window.location.href = '../../View/Ventas/CartView.php';
                } else {
                    alert('Hubo un error al agregar el producto al carrito.');
                }
            } catch (err) {
                console.error('Fetch carrito:', err);
                alert('Ocurrió un error inesperado: ' + err.message);
            }
        }
    </script>

    </script>
</body>

</html>