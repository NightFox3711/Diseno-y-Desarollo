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
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/MetodosPago.css">

</head>

<body>
    <header>
        <h1>Bienvenido(a) a Solis Motors</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hola, <?= htmlspecialchars($_SESSION['user']['username']); ?> | <a href="../View/LoginView.php?action=logout">Cerrar sesión</a></p>
        <?php else: ?>
            <a href="../LoginView.php">Iniciar sesión</a> | <a href="../RegisterView.php">Registrarse</a>
        <?php endif; ?>
    </header>
    <?php include('../Nav/Nav.php'); ?>
    <main>
        <h2>Pago del Vehículo</h2>
        <h4>Detalles del Tarjeta Habitante</h4>
        <form action="../../Controller/MetodoPagoController.php?action=add" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name_cardholder" required>
            </div>
            <div class="col-md-6">
                <label for="inputApellido" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="lastname_cardholder" required>
            </div>
            <div class="col-md-6">
                <label for="inputCorreo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email_cardholder" required>
            </div>
            <h4>Detalles de la Tarjeta</h4>
            <div class="col-md-4">
                <label for="inputTarjeta" class="form-label">Tipo de Tarjeta</label>
                <select id="inputTipoTarjeta" name="card_type" class="form-select">
                    <option>MasterCard</option>
                    <option>VISA</option>
                    <option>American Express</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputTarjeta" class="form-label">Número de Tarjeta</label>
                <input type="text"
                    class="form-control"
                    name="number_card"
                    id="numeroTarjeta"
                    placeholder="XXXX-XXXX-XXXX-XXXX"
                    maxlength="19"
                    required>
            </div>

            <script>
                document.getElementById('numeroTarjeta').addEventListener('input', function(e) {

                    let valor = e.target.value.replace(/\D/g, '');


                    valor = valor.match(/.{1,4}/g);

                    if (valor) {

                        valor = valor.join('-').substr(0, 19);
                        e.target.value = valor;
                    }
                });
            </script>

            <div class="col-md-3">
                <label for="inputCVV" class="form-label">CVV</label>
                <input type="text" class="form-control" name="pin_card" placeholder="Pin de 3 dígitos" required>
            </div>
            <div class="col-md-2">
                <label for="inputMes" class="form-label">Mes</label>
                <input type="text" class="form-control" name="expiration_month" placeholder="MM" required>
            </div>
            <div class="col-md-2">
                <label for="inputAno" class="form-label">Año</label>
                <input type="year" class="form-control" name="expiration_year" placeholder="YYYY" required>
            </div>
            <div class="col-12">
                <a href="CartView.php" class="btn btn-danger">Cancelar Pago</a>
                <button type="submit" class="btn btn-success">Confirmar Pago</button>
            </div>
        </form>
    </main>
    <?php include('../Nav/Footer.php'); ?>
</body>

</html>
