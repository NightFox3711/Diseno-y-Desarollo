<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit();
}

require_once '../Model/OfertasModel.php';
$ofertas = listarOfertas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Agregar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SC Motors - Menú Ofertas</title>
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

        .card-img-top{
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Bienvenido(a) a SC Motors</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar
                    sesión</a></p>
        <?php else: ?>
            <p><a href="LoginView.php">Iniciar sesión</a> | <a href="RegisterView.php">Registrarse</a></p>
        <?php endif; ?>
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

    <div class="container p-3 contenedor">
        <div>
            <strong>
                <h1>Catálogo de Ofertas</h1>
            </strong>
        </div>

    </div>
    <br>
    <div class="container p-3 contenedor">
    <div class="row">
        <?php
        foreach ($ofertas as $oferta) {
        ?>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="../assets/img/<?php echo $oferta['img_vehicle_offer']; ?>" alt="<?php echo $oferta['vehicle_offer']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $oferta['vehicle_offer']; ?></h5>
                        <p class="card-text">$<?php echo $oferta['price_offer']; ?></p>
                    </div>
                    <div class="d-flex justify-content-center gap-3 p-3 mb-4">
                        <a href="MenuView.php" class="btn btn-secondary w-40">Menú</a>
                        <button class="btn btn-success w-40" 
                                onclick="agregarAlCarrito('<?= $_SESSION['user'] ?>', <?= $oferta['id_offer'] ?>)">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>



    <div>
        <footer>
            <p>&copy; <?= date('Y'); ?> SC Motors. Todos los derechos reservados.</p>
        </footer>
    </div>
    <!-- Agregar Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
function agregarAlCarrito(userName, offerId) {
    fetch('../Controller/CartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_name: userName,
            offer_id: offerId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            window.location.href = 'CartView.php'; // Redirige al carrito
        } else {
            alert('Error al agregar al carrito');
        }
    });
}
</script>

</body>

</html>