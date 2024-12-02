
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SC Motors - Soporte</title>
    <style>
        /* Estilo general */
        html, body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Gris claro */
            color: #333; /* Gris oscuro */
        }

        /* Cabecera */
        header {
            background-color: #808080; /* Gris oscuro */
            color: #ffffff; /* Blanco */
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-weight: 300;
            font-size: 2.5rem;
        }

        /* Contenedor principal */
        main {
            padding: 20px;
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff; /* Blanco */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #000000; /* Negro */
            text-align: center;
            font-weight: 300;
            margin-bottom: 20px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        table th {
            background-color: #ff0000; /* Rojo */
            color: #ffffff; /* Blanco */
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2; /* Gris claro */
        }

        table tr:hover {
            background-color: #dddddd; /* Gris más oscuro */
        }

        /* Formulario */
        form {
            margin-top: 20px;
        }

        select, textarea, button, input[type="text"], input[type="number"], input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            border: 1px solid #ccc; /* Gris */
            display: block;
        }

        button {
            background-color: #ff0000; /* Rojo */
            color: #ffffff; /* Blanco */
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #cc0000; /* Rojo más oscuro */
            transition: 0.3s;
        }

        /* Enlaces */
        a {
            color: #ff0000; /* Rojo */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Enlace al menú */
        .menu-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            color: #ff0000; /* Rojo */
        }

        .menu-link:hover {
            color: #cc0000; /* Rojo más oscuro */
        }
    </style>
</head>
<body>
    <header>
        <h1>Soporte al Cliente</h1>
    </header>

    <main>
        <h2>Solicitudes de Soporte</h2>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../Controller/SoporteController.php';
                    $solicitudes = obtenerSolicitudes();

                    foreach ($solicitudes as $solicitud):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($solicitud['id']); ?></td>
                        <td><?= htmlspecialchars($solicitud['user']); ?></td>
                        <td><?= htmlspecialchars($solicitud['type']); ?></td>
                        <td><?= htmlspecialchars($solicitud['details']); ?></td>
                        <td><?= htmlspecialchars($solicitud['status']); ?></td>
                        <td>
                            <?php if ($solicitud['status'] === 'pendiente'): ?>
                                <a href="../Controller/SoporteController.php?action=resolve&id=<?= $solicitud['id']; ?>">Resolver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h2>Crear solicitud de soporte</h2>
            <form action="../Controller/SoporteController.php?action=add" method="POST">
                <select name="type" required>
                    <option value="chat">Chat</option>
                    <option value="cita">Cita</option>
                    <option value="prueba">Prueba de Manejo</option>
                </select>
                <textarea name="details" placeholder="Detalles" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        <?php endif; ?>

        <a href="MenuView.php" class="menu-link">Volver al menú</a>
    </main>
</body>
</html>