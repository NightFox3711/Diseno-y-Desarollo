<?php
/*session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}*/
require_once '../Model/OfertasModel.php';
require_once '../Controller/OfertasController.php';
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
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
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
        /* Barra de navegación completa con animaciones */
        nav.navbar {
            background: #1F2ADB;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            margin: 30px auto;
            max-width: 800px;
            padding-top: 20px;
        }
        /* Estilos para las tarjetas de oferta */
        .titulo-principal {
            font-family: 'Roboto Condensed', sans-serif;
            color: #1F2ADB;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            margin: 2rem 0;
            text-align: center;
            font-size: 2.5rem;
        }
        .card-oferta {
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .card-oferta:hover {
            transform: translateY(-5px);
        }
        .card-img-custom {
            height: 300px;
            object-fit: contain;
            object-position: center;
            width: 100%;
            background: #f8f9fa;
            padding: 7px;
        }
        .btn-agregar {
            background-color: #1F2ADB !important;
            border-color: #1F2ADB !important;
            color: #FFFFFF !important;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-agregar:hover {
            background-color: #468EDB !important;
            border-color: #468EDB !important;
            transform: scale(1.05);
        }
        .btn-info {
            background-color: #468EDB !important;
            border-color: #468EDB !important;
            color: #FFFFFF !important;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-info:hover {
            background-color: #1F2ADB !important;
            border-color: #1F2ADB !important;
            transform: scale(1.05);
        }
        /* Estilos para el buscador */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }
        .search-container .input-group {
            max-width: 300px;
        }
        .terms-link {
            cursor: pointer;
            color: #1F2ADB;
            text-decoration: underline;
            font-weight: 600;
        }
        .terms-link:hover {
            color: #468EDB;
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
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <h1>Portafolio de Vehículos</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="LoginView.php">Iniciar sesión</a> | <a href="RegisterView.php">Registrarse</a></p>
        <?php endif; ?>
    </header>
    
    <!-- Barra de navegación completa justo debajo del encabezado -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="MenuView.php"><i class="bi bi-arrow-left"></i> Volver al menú</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOfertas"
                aria-controls="navbarOfertas" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarOfertas">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="SoporteView.php"><i class="bi bi-question-circle"></i> Soporte</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="VentasView.php"><i class="bi bi-cart"></i> Ventas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="InventarioView.php"><i class="bi bi-box"></i> Inventario</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="OfertasView.php"><i class="bi bi-gift"></i> Ofertas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="CartView.php"><i class="bi bi-cart3"></i> Carrito</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <!-- Contenedor principal de contenido -->
    <div class="container container-content">
        <h1 class="text-center titulo-principal">Catálogo de Ofertas</h1>
        <div class="search-container">
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
                        <img src="../assets/img/<?= $oferta['img_vehicle_offer'] ?>"
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
                                    onclick="agregarAlCarrito('<?= $_SESSION['user'] ?>', <?= $oferta['id_offer'] ?>)">
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
                                <img src="../assets/img/<?= $oferta['img_vehicle_offer'] ?>"
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
        <p>&copy; <?= date('Y'); ?> Solis Motors. Todos los derechos reservados.</p>
    </footer>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function agregarAlCarrito(userName, offerId) {
            fetch('../Controller/CartController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_name: userName,
                    offer_id: offerId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'CartView.php';
                } else {
                    alert('Error al agregar al carrito');
                }
            });
        }
    </script>
</body>
</html>
