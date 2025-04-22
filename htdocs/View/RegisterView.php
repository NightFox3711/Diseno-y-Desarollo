<?php
require_once '../Controller/RegisterController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegisterController();
    $controller->register();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SC Motors - Registro</title>
    <link rel="stylesheet" href="../assets/css/Register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="register-container">
        <h1>Registro de Usuario</h1>
        <p>Únete a <b>SC Motors</b> - "Liderando el camino hacia el futuro"</p>

        <form method="POST" action="">
            <label for="username"><i class="bi bi-person-fill"></i> Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password"><i class="bi bi-lock-fill"></i> Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="email"><i class="bi bi-envelope-fill"></i> Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="phone"><i class="bi bi-telephone-fill"></i> Teléfono:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="id_card"><i class="bi bi-credit-card-2-front-fill"></i> Cédula:</label>
            <input type="text" id="id_card" name="id_card" required>

            <label for="location"><i class="bi bi-geo-alt-fill"></i> Dirección:</label>
            <select id="location" name="location">
                <option value="SanJose">San José</option>
                <option value="Limon">Limón</option>
                <option value="Puntarenas">Puntarenas</option>
                <option value="Heredia">Heredia</option>
                <option value="Guanacaste">Guanacaste</option>
                <option value="Cartago">Cartago</option>
                <option value="Alajuela">Alajuela</option>
            </select>

            <label for="role"><i class="bi bi-person-badge-fill"></i> Rol:</label>
            <select id="role" name="role">
                <option value="Administrador">Administrador</option>
                <option value="Cliente">Cliente</option>
            </select>

            <button type="submit">Registrar</button>
        </form>
    </div>

</body>
</html>
