<?php

require_once '../Controller/LoginController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motors Realty - Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/Login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="login-container">
        <img src="../assets/img/IconoEmpresa.jpg" alt="Logo de Solis Motors" class="mb-4 shadow rounded-circle">
        <h2>SC Motors</h2>
        <h3>Inicio de Sesión</h3>

        <?php if (isset($_GET['error'])) { echo "<p class='error-msg'>Usuario o contraseña incorrectos.</p>"; } ?>

        <form action="../Controller/LoginController.php" method="POST">
            <div class="input-group">
                <label for="Cedula">
                    <i class="bi bi-person-vcard label-icon"></i> Cédula
                </label>
                <input type="text" name="id_card" id="id_card" required>
            </div>

            <div class="input-group">
                <label for="password">
                    <i class="bi bi-lock-fill label-icon"></i> Contraseña
                </label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Ingresar</button>
        </form>

  
        <p class="register-link">¿No tienes cuenta? <a href="RegisterView.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
