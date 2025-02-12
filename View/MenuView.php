<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SC Motors - Menú Principal</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Estilos generales */
    body {
      font-family: 'Open Sans', Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
      color: #333;
      line-height: 1.6;
    }

    /* Cabecera con degradado rojo */
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

        header a:hover {
            text-decoration: underline;
        }

    /* Menú de navegación */
    nav {
      background-color: #333;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    nav:hover {
      background-color: #444;
    }

    .navbar-nav {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .navbar-nav .nav-item {
      position: relative;
    }

    .navbar-nav .nav-link {
      color: #fff;
      font-size: 1.2rem;
      font-weight: 600;
      padding: 16px 24px;
      border-radius: 5px;
      text-decoration: none;
      transition: transform 0.3s, background 0.3s;
    }

    .navbar-nav .nav-link:hover {
      background: #555;
      transform: scale(1.05);
    }

    .navbar-nav .nav-item:before {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0%;
      height: 2px;
      background-color: #fff;
      transition: width 0.3s;
    }

    .navbar-nav .nav-item:hover:before {
      width: 100%;
    }

    /* Contenido principal */
    main {
      padding: 40px;
      margin: 30px auto;
      max-width: 900px;
      border-radius: 10px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      background-color: #fff;
      transition: all 0.3s ease;
    }

    main h2 {
      font-size: 2.5rem;
      font-weight: 600;
      color: #000;
      margin-bottom: 20px;
    }

    main p {
      font-size: 1.2rem;
      line-height: 1.8;
      color: #000;
      margin-bottom: 20px;
    }

    main:hover {
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
    }

    /* Sección de Contacto: Solo íconos interactivos */
    .contacto-section {
      background-color: #fff;
      padding: 40px;
      margin: 30px auto;
      max-width: 900px;
      border-radius: 10px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .contacto-items {
      display: flex;
      justify-content: center;
      gap: 30px;
      font-size: 2rem;
    }

    .contacto-item {
      color: #333;
      transition: transform 0.5s ease;
    }

    .contacto-item:hover {
      transform: scale(1.2) rotate(360deg);
      color: #f44336;
    }

    /* Pie de página */
    footer {
            text-align: center;
            padding: 15px;
            background: #808080; /* Gris oscuro */
            color: #ffffff; /* Blanco */
            position: relative;
            bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
        }
  </style>
</head>
<body>
  <header>
    <h1>Bienvenido(a) a SC Motors</h1>
    <?php if (isset($_SESSION['user'])): ?>
      <p>Hola, <?= htmlspecialchars($_SESSION['user']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
    <?php else: ?>
      <p><a href="LoginView.php">Iniciar sesión</a> | <a href="RegisterView.php">Registrarse</a></p>
    <?php endif; ?>
  </header>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="LoginView.php"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
        <li class="nav-item"><a class="nav-link" href="RegisterView.php"><i class="bi bi-person-plus"></i> Registro</a></li>
        <li class="nav-item"><a class="nav-link" href="SoporteView.php"><i class="bi bi-question-circle"></i> Soporte</a></li>
        <li class="nav-item"><a class="nav-link" href="VentasView.php"><i class="bi bi-cart"></i> Ventas</a></li>
        <li class="nav-item"><a class="nav-link" href="InventarioView.php"><i class="bi bi-box"></i> Inventario</a></li>
        <li class="nav-item"><a class="nav-link" href="CotizacionView.php"><i class="bi bi-file-text"></i> Cotizaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="OfertasView.php"><i class="bi bi-gift"></i> Ofertas</a></li>
        <li class="nav-item"><a class="nav-link" href="CartView.php"><i class="bi bi-cart3"></i> Carrito</a></li>   
      </ul>
    </div>
  </nav>

  <main>
    <h2>Acerca de SC Motors</h2>
    <p>
      Descubre el universo SC Motors, donde la pasión por la carretera se fusiona con la excelencia automotriz. Explora nuestra exclusiva selección de vehículos nuevos, seminuevos y usados, cuidadosamente elegidos para ofrecerte calidad, innovación y el máximo rendimiento. Nuestro equipo de expertos está listo para asesorarte y acompañarte en cada paso, transformando cada viaje en una experiencia inolvidable. ¡Atrévete a conducir el futuro y siente la emoción de pertenecer a la familia SC Motors!
    </p>
  </main>

  <!-- Sección de Contacto: Solo íconos interactivos -->
  <section class="contacto-section">
    <div class="contacto-items">
      <a href="tel:60157555" class="contacto-item" title="Llamar">
        <i class="bi bi-telephone-fill"></i>
      </a>
      <a href="mailto:Jsolis@scmotors.com" class="contacto-item" title="Enviar correo">
        <i class="bi bi-envelope-fill"></i>
      </a>
      <a href="https://maps.app.goo.gl/31cdokzzmLRCmc2g8" class="contacto-item" target="_blank" rel="noopener noreferrer" title="Ver ubicación">
        <i class="bi bi-geo-alt-fill"></i>
      </a>
      <a href="https://www.instagram.com/scmotors" class="contacto-item" target="_blank" rel="noopener noreferrer" title="Instagram">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://www.facebook.com/scmotors" class="contacto-item" target="_blank" rel="noopener noreferrer" title="Facebook">
        <i class="bi bi-facebook"></i>
      </a>
    </div>
  </section>

  <footer>
    <p>&copy; <?= date('Y'); ?> SC Motors. Todos los derechos reservados.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
