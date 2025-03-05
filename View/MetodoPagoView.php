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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SC Motors - Inventario</title>
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

        .container {
            margin-bottom: 30px;
            /* Espacio entre últimas tarjetas y footer */
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
            margin-top: auto;
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
    </style>

    <style>
        /* ESTILOS PERSONALIZADOS */
        .titulo-principal {
            font-family: 'Roboto Condensed', sans-serif;
            color: #b80b0b;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .card-oferta {
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
            border: 1px solid #eee;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card-oferta:hover {
            transform: translateY(-5px);
        }

        .btn-agregar {
            background-color: #b80b0b !important;
            border-color: #b80b0b !important;
            color: white !important;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-agregar:hover {
            background-color: #9a0909 !important;
            border-color: #9a0909 !important;
            transform: scale(1.05);
        }

        .card-img-custom {
            height: 300px;
            object-fit: contain;
            object-position: center;
            image-rendering: optimizeQuality;
            width: 100%;
            background: #f8f9fa;
            /* Fondo gris claro para espacios vacíos */
            padding: 7px;
            /* Espacio alrededor de la imagen */
        }

        @media (min-width: 768px) {
            .row-cols-md-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
        }

        /*FILTER*/
        /* Estilos para centrar y alinear el buscador */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .search-container input {
            max-width: 250px;
            width: 100%;
        }

        .search-container button {
            width: auto;
        }

        .catalogo-container h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Estilos para centrar y alinear el buscador */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-container input {
            max-width: 300px;
            flex-grow: 1;
        }

        .search-container button {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <header>
        <h1>Método de Pago</h1>
        <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
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
        <h2>Pago del Vehículo</h2>
        <h3>Detalles del Tarjeta Habitante</h3>
        <form action="../Controller/MetodoPagoController.php?action=add" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre_tarjetahabitante" placeholder="" required>
            </div>
            <div class="col-md-6">
                <label for="inputApellido" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellido_tarjetahabitante" placeholder="" required>
            </div>
            <div class="col-md-6">
                <label for="inputCorreo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_tarjetahabitante" placeholder="" required>
            </div>
            <h3>Detalles de la Tarjeta</h3>
            <div class="col-md-4">
                <label for="inputTarjeta" class="form-label">Tipo de Tarjeta</label>
                <select id="inputTipoTarjeta" name="tipo_tarjeta" class="form-select">
                    <option>MasterCard</option>
                    <option>VISA</option>
                    <option>American Express</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputTarjeta" class="form-label">Número de Tarjeta</label>
                <input type="text" class="form-control" name="numero_tarjeta" placeholder="" required>
            </div>
            <div class="col-md-2">
                <label for="inputCVV" class="form-label">CVV</label>
                <input type="text" class="form-control" name="pin_tarjeta" placeholder="" required>
            </div>
            <div class="col-md-2">
                <label for="inputMes" class="form-label">Mes</label>
                <input type="text" class="form-control" name="mes_expiracion" placeholder="" required>
            </div>
            <div class="col-md-2">
                <label for="inputaAno" class="form-label">Año</label>
                <input type="year" class="form-control" name="ano_expiracion" placeholder="" required>
            </div>
            <div class="col-12">
                <a href="CartView.php" class="btn btn-danger">Cancelar Pago</a>
                <button type="submit" class="btn btn-success">Confirmar Pago</button>
            </div>
        </form>

    </main>
</body>

</html>