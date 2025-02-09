<?php
require_once '../Model/CartModel.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            /* Gris claro */
            color: #333;
            /* Gris oscuro */
            line-height: 1.6;
        }

        /* Cabecera */
        header {
            background: #808080;
            /* Gris oscuro */
            color: #ffffff;
            /* Blanco */
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
            /* Rojo */
            text-decoration: none;
            font-weight: bold;
        }

        header a:hover {
            text-decoration: underline;
        }

        /* Menú de navegación */
        nav {
            background: #333;
            /* Negro */
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

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            display: block;
            padding: 15px 25px;
            color: #fff;
            /* Blanco */
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }

        nav ul li a:hover {
            background: #ff0000;
            /* Rojo */
            color: #ffffff;
            /* Blanco */
            transform: scale(1.05);
        }

        /* Sección principal */
        main {
            padding: 30px;
            text-align: center;
            background: #ffffff;
            /* Blanco */
            margin: 30px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        main h2 {
            color: #000000;
            /* Negro */
            font-size: 2rem;
            font-weight: 300;
            margin-bottom: 15px;
        }

        main p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            /* Gris medio */
        }

        /* Pie de página */
        footer {
            text-align: center;
            padding: 15px;
            background: #808080;
            /* Gris oscuro */
            color: #ffffff;
            /* Blanco */
            position: relative;
            bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
        }

        .contenedor {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            /* Asegura que los elementos estén centrados verticalmente */
            margin: 0 auto;
            overflow: hidden;
        }

        /* Estilos para centrar el texto en las tarjetas */
        .card {
            width: 18rem;
            /* Ajusta el tamaño de cada tarjeta */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Centra el contenido horizontalmente */
            text-align: center;
            /* Centra el texto */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Centrar el contenido dentro de la tarjeta */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centra verticalmente */
            align-items: center;
            /* Centra horizontalmente */
            text-align: center;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <header>
        <h1>Carrito de Compras</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar
                sesión</a></p>
    </header>

    <nav>
        <ul>
            <li><a href="LoginView.php">Login</a></li>
            <li><a href="RegisterView.php">Registro</a></li>
            <li><a href="SoporteView.php">Soporte</a></li>
            <li><a href="VentasView.php">Ventas</a></li>
            <li><a href="InventarioView.php">Inventario</a></li>
            <li><a href="OfertasView.php">Ofertas</a></li>
            <li><a href="CartView.php">Carrito</a></li>
        </ul>
    </nav>

    <main>
        <h2>Lista de Productos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo del Vehículo</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include_once '../Controller/CartController.php';
                $carrito = obtenerCarrito($_SESSION['user']);



                foreach ($carrito as $carritos):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($carritos['cart_id']) ?></td>
                        <td><?= htmlspecialchars($carritos['vehicle_offer']) ?></td>
                        <td><?= htmlspecialchars($carritos['price_offer']) ?></td>
                        <td><?= htmlspecialchars($carritos['quantity']) ?></td>
                        <td><?= htmlspecialchars($carritos['total_price']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> SC Motors. Todos los derechos reservados.</p>
    </footer>
</body>

</html>