<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../Model/VehiclesModel.php';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SC Motors - Prueba de Manejo</title>
    
    <style>
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
            transform: scale(1.05);
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-danger {
            background-color: #b80b0b !important;
            border-color: #b80b0b !important;
            padding: 0.75rem 2rem;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #808080;
            color: white;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>SC Motors</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']) ?> | 
            <a href="../View/LoginView.php?action=logout">Cerrar sesión</a>
        </p>
    </header>

    <nav>
        <ul>
            <li><a href="MenuView.php">Menú</a></li>
            <li><a href="TestDriveView.php">Prueba de Manejo</a></li>
            <li><a href="CartView.php">Carrito</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="text-center titulo-principal">Agendar Prueba de Manejo</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="../Controller/TestDriveController.php?action=submit" method="POST">
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

    <footer>
        <p>&copy; <?= date('Y') ?> SC Motors. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>