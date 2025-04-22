<head>
    <!-- Bootstrap CSS primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tu CSS personalizado después -->
    <link rel="stylesheet" href="../assets/css/Nav.css">
</head>


<nav class="navbar navbar-expand-lg">
    <div class="container justify-content-between">
        <a class="navbar-brand" href="../MenuView.php"><i class="bi bi-arrow-left"></i> Volver al Menú</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCart"
                aria-controls="navbarCart" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCart">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Ventas/VentasView.php"><i class="bi bi-piggy-bank"></i> Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Inventario/InventarioView.php"><i class="bi bi-box"></i> Inventario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../Ventas/CartView.php"><i class="bi bi-cart3"></i> Carrito</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

  