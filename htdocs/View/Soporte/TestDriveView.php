<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Model/VehiclesModel.php';
$vehicles = VehiclesModel::getAvailableVehicles();

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
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
    <title>SC Motors - Prueba de Manejo</title>
    
</head>

<body>
    

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.querySelector('button[type="submit"]');
        const datetimeInput = document.getElementById('datetime');

        submitButton.addEventListener('click', function(event) {
            const datetimeValue = new Date(datetimeInput.value);
            const dayOfWeek = datetimeValue.getDay();  
            const hours = datetimeValue.getHours();   

            
            if (dayOfWeek === 0 || hours < 10 || hours > 18) {
                alert("Solo puedes agendar citas de lunes a sábado entre las 10:00 AM y las 6:00 PM.");
                event.preventDefault(); 
            }
        });
    });
</script>


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

  <?php include('../Nav/Nav.php'); ?>

    <div class="container">
        <div class="form-container">
        <h2 class="text-center titulo-principal" style="padding-top: 2rem;">Agendar Prueba de Manejo</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="../../Controller/TestDriveController.php?action=submit" method="POST">
                <div class="mb-4">
                    <label for="vehicle_id" class="form-label">Vehículo:</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                        <?php if(empty($vehicles)): ?>
                            <option value="">No hay vehículos disponibles</option>
                        <?php else: ?>
                            <?php foreach ($vehicles as $vehicle): ?>
                                <option value="<?= $vehicle['id'] ?>">
                                    <?= htmlspecialchars($vehicle['brand']) ?> 
                                    <?= htmlspecialchars($vehicle['model']) ?> -
                                    $<?= number_format($vehicle['price'], 0, ',', '.') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="datetime" class="form-label">Fecha y Hora:</label>
                    <input type="datetime-local" 
                        class="form-control" 
                        id="datetime" 
                        name="datetime" 
                        required
                        min="<?= date('Y-m-d\TH:i') ?>">
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-calendar-check"></i> Confirmar Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include('../Nav/Footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>