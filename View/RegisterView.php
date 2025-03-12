<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <p>Únete a <b>SC Motors</b> - "Liderando el camino hacia el futuro"</p>

    <form method="POST" action="../Controller/RegisterController.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>
        
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>
        
        <label for="direccion">Dirección:</label>
        <select id="direccion" name="direccion">
            <option value="SanJose">San José</option>
            <option value="Limon">Limón</option>
            <option value="Puntarenas">Puntarenas</option>
            <option value="Heredia">Heredia</option>
            <option value="Guanacaste">Guanacaste</option>
            <option value="Cartago">Cartago</option>
            <option value="Alajuela">Alajuela</option>
        </select>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="Admin">Administrador</option>
            <option value="Cliente">Cliente</option>
            <option value="Empleado">Empleado</option>
        </select>

        <input type="hidden" id="fecha_creacion" name="fecha_creacion">

        <button type="submit">Registrar</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let fechaInput = document.getElementById("fecha_creacion");
            let fechaActual = new Date().toISOString().split('T')[0];
            fechaInput.value = fechaActual;
        });
    </script>
</body>
</html>
