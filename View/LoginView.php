<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <?php if (isset($_GET['error'])) { echo "<p>Usuario o contraseña incorrectos.</p>"; } ?>

    <form action="../Controller/LoginController.php" method="POST">
        <label>Cédula:</label>
        <input type="text" name="cedula" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
