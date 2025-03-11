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
    <title>Solis Motors - Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            color: #1F2ADB;
            line-height: 1.6;
        }
        header {
            background: #468EDB;
            color: #FFFFFF;
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
            color: #468EDB;
            text-decoration: none;
            font-weight: bold;
        }
        header a:hover {
            text-decoration: underline;
        }
        nav {
            background: #1F2ADB;
            color: #FFFFFF;
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
            color: #FFFFFF;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s, transform 0.2s;
        }
        nav ul li a:hover {
            background: #468EDB;
            color: #FFFFFF;
            transform: scale(1.05);
        }
        main {
            padding: 30px;
            text-align: center;
            background: #FFFFFF;
            margin: 30px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        main h2 {
            color: #1F2ADB;
            font-size: 2rem;
            font-weight: 300;
            margin-bottom: 15px;
        }
        main p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #1F2ADB;
        }
        .container {
            margin-bottom: 30px;
        }
        footer {
            text-align: center;
            padding: 15px;
            background: #468EDB;
            color: #FFFFFF;
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
            margin: 0 auto;
            overflow: hidden;
        }
        .card {
            width: 18rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .titulo-principal {
            font-family: 'Roboto Condensed', sans-serif;
            color: #1F2ADB;
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
            background-color: #1F2ADB !important;
            border-color: #1F2ADB !important;
            color: #FFFFFF !important;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-agregar:hover {
            background-color: #468EDB !important;
            border-color: #468EDB !important;
            transform: scale(1.05);
        }
        .card-img-custom {
            height: 300px;
            object-fit: contain;
            object-position: center;
            image-rendering: optimizeQuality;
            width: 100%;
            background: #f8f9fa;
            padding: 7px;
        }
        @media (min-width: 768px) {
            .row-cols-md-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
        }
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
        .btn-danger {
            background-color: #1F2ADB !important;
            border-color: #1F2ADB !important;
            color: #FFFFFF !important;
        }
        .btn-danger:hover {
            background-color: #468EDB !important;
            border-color: #468EDB !important;
        }
        .btn-success {
            background-color: #468EDB !important;
            border-color: #468EDB !important;
            color: #FFFFFF !important;
        }
        .btn-success:hover {
            background-color: #1F2ADB !important;
            border-color: #1F2ADB !important;
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
                <input type="text" class="form-control" name="nombre_tarjetahabitante" required>
            </div>
            <div class="col-md-6">
                <label for="inputApellido" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellido_tarjetahabitante" required>
            </div>
            <div class="col-md-6">
                <label for="inputCorreo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_tarjetahabitante" required>
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
                <input type="text" class="form-control" name="numero_tarjeta" required>
            </div>
            <div class="col-md-2">
                <label for="inputCVV" class="form-label">CVV</label>
                <input type="text" class="form-control" name="pin_tarjeta" required>
            </div>
            <div class="col-md-2">
                <label for="inputMes" class="form-label">Mes</label>
                <input type="text" class="form-control" name="mes_expiracion" required>
            </div>
            <div class="col-md-2">
                <label for="inputaAno" class="form-label">Año</label>
                <input type="year" class="form-control" name="ano_expiracion" required>
            </div>
            <div class="col-12">
                <a href="CartView.php" class="btn btn-danger">Cancelar Pago</a>
                <button type="submit" class="btn btn-success">Confirmar Pago</button>
            </div>
        </form>
    </main>
</body>
</html>
