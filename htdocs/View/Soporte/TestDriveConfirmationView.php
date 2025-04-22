<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

$success = $_SESSION['success'] ?? 'Prueba agendada exitosamente';
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/Testdrive.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SC Motors - Confirmación de Prueba</title>
</head>

<body>
<header>
    <h1>Bienvenido(a) a Solis Motors</h1>
    <?php if (isset($_SESSION['user'])): ?>
      <p>Hola, <?= htmlspecialchars($_SESSION['user']['username']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>    
    <?php else: ?>
      <a href="LoginView.php">Iniciar sesión</a> | <a href="RegisterView.php">Registrarse</a>
    <?php endif; ?>
  </header>

  <?php include('../Nav/Nav.php'); ?>

    <div class="container">
        <div class="confirmation-container">
            <h2 class="titulo-principal">¡Prueba Agendada!</h2>
            
            <div class="alert alert-success mt-4">
                <i class="bi bi-check-circle-fill"></i>
                <?= $success ?>
            </div>

            <div class="mt-4">
                <a href="../MenuView.php" class="btn btn-danger">
                    <i class="bi bi-house-door"></i> Volver al Menú
                </a>
            </div>
        </div>
    </div>

    <?php include('../Nav/Footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>