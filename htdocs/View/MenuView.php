<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "SolisMotors3718");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta de vehículos
$sql = "SELECT * FROM vehicles";
$resultado = $conexion->query($sql);

$vehiculos = [];
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $vehiculos[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solis Motors - Menú Principal</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/Menu.css">

  <!-- chat -->

</head>
<body>

<!-- HEADER -->
<header class="text-white text-center py-4 shadow-sm">
  <h1 class="mb-2">Bienvenido(a) a Solis Motors</h1>
  <?php if (isset($_SESSION['user'])): ?>
    <p class="mb-0">Hola, <?= htmlspecialchars($_SESSION['user']['username']); ?> | 
      <a href="../View/LoginView.php?action=logout" class="text-warning">Cerrar sesión</a>
    </p>
  <?php else: ?>
    <a href="LoginView.php" class="text-light me-3">Iniciar sesión</a> | 
    <a href="RegisterView.php" class="text-light">Registrarse</a>
  <?php endif; ?>
</header>

<!-- NAV -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="Ventas/VentasView.php"><i class="bi bi-piggy-bank"></i> Ventas</a></li>
            <li class="nav-item"><a class="nav-link" href="Inventario/InventarioView.php"><i class="bi bi-box"></i> Inventario</a></li>
            <li class="nav-item"><a class="nav-link" href="Ventas/CartView.php"><i class="bi bi-cart3"></i> Carrito</a></li>
            <li class="nav-item"><a class="nav-link" href="OfertasView.php"><i class="bi bi-gift"></i> Ofertas</a></li>
        </ul>
    </div>
</nav>

<!-- PRESENTACIÓN -->
<main class="container my-5 text-center p-5 shadow rounded bg-white">
  <img src="../assets/img/IconoEmpresa.jpg" alt="Logo de Solis Motors" class="mb-4 img-fluid rounded-circle shadow" style="max-width: 200px; height: auto;">
  <h2 class="text-dark mb-4">Acerca de Solís Motors CR</h2>
  <p class="descripcion-elegante">
        Descubre el universo Solis Motors, donde la pasión por la carretera se fusiona con la excelencia automotriz...
        ¡Atrévete a conducir el futuro y siente la emoción de pertenecer a la familia Solis Motors!
  </p>
</main>

<!-- CATÁLOGO -->
<div class="container py-5">
    <h2 class="text-center mb-4">Catálogo de Vehículos</h2>

    <div class="d-flex flex-wrap justify-content-center">
        <?php if (!empty($vehiculos)): ?>
            <?php foreach ($vehiculos as $vehiculo): ?>
                <div class="card m-2 shadow-sm" style="width: 18rem;">
                    <img src="Inventario/<?= htmlspecialchars($vehiculo['image_path']) ?>" class="card-img-top" style="height: 180px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($vehiculo['brand']) ?> <?= htmlspecialchars($vehiculo['model']) ?></h5>
                        <p class="card-text"><strong>Estado:</strong> <?= htmlspecialchars($vehiculo['status']) ?></p>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal<?= $vehiculo['id_vehicle'] ?>">
                            Ver más
                        </button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal<?= $vehiculo['id_vehicle'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($vehiculo['brand']) . " " . htmlspecialchars($vehiculo['model']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <img src="Inventario/<?= htmlspecialchars($vehiculo['image_path']) ?>" width="100%" class="mb-3">
                                <p><strong>Marca:</strong> <?= htmlspecialchars($vehiculo['brand']) ?></p>
                                <p><strong>Modelo:</strong> <?= htmlspecialchars($vehiculo['model']) ?></p>
                                <p><strong>Precio:</strong> $<?= htmlspecialchars($vehiculo['price']) ?></p>
                                <p><strong>Sede:</strong> <?= htmlspecialchars($vehiculo['headquarters']) ?></p>
                                <p><strong>Tipo:</strong> <?= htmlspecialchars($vehiculo['type_vehicle']) ?></p>
                                <p><strong>Tracción:</strong> <?= htmlspecialchars($vehiculo['traction_vehicle']) ?></p>
                                <p><strong>Motor:</strong> <?= htmlspecialchars($vehiculo['motor_vehicle']) ?> CC</p>
                                <p><strong>Kilometraje:</strong> <?= htmlspecialchars($vehiculo['km_vehicle']) ?> km</p>
                                <p><strong>Estado del vehículo:</strong> <?= htmlspecialchars($vehiculo['status_vehicle_available']) ?></p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay vehículos registrados.</div>
        <?php endif; ?>
    </div>
</div>

<!-- CONTACTO -->
<section class="contacto-section py-4 text-center bg-light">
  <div class="contacto-container">
    <a href="tel:60157555" class="contacto-item"><i class="bi bi-telephone-fill"></i></a>
    <a href="mailto:Jsolis@scmotors.com" class="contacto-item"><i class="bi bi-envelope-fill"></i></a>
    <a href="https://maps.app.goo.gl/..." class="contacto-item" target="_blank"><i class="bi bi-geo-alt-fill"></i></a>
    <a href="https://www.instagram.com/solismotorscr/" class="contacto-item" target="_blank"><i class="bi bi-instagram"></i></a>
    <a href="https://www.facebook.com/MotorsSC" class="contacto-item" target="_blank"><i class="bi bi-facebook"></i></a>
  </div>
</section>

<!-- FOOTER -->
<?php include('Nav/Footer.php'); ?>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




</body>
</html>
