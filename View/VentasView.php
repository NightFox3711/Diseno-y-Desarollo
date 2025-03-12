<?php
/*session_start();
if (!isset($_SESSION['user']) || $_SESSION['rol'] !== 'admin') {
   header('Location: LoginView.php');
    exit();
}*/
?>
<?php
session_start();
require_once "../Controller/VentasController.php";

if (!isset($_SESSION['nombre'])) {
    exit();
}

$id_cliente = obtenerIdCliente($_SESSION['nombre']);
$vehiculosDisponibles = obtenerVehiculosDisponibles();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
    <script>
        function calcularPrecio() {
            let precioBase = parseFloat(document.getElementById("precio_base").value);
            let plazo = parseInt(document.getElementById("plazo").value);
            let descuento = parseFloat(document.getElementById("descuento").value) / 100;

            let interes = plazo === 3 ? 5 : plazo === 6 ? 10 : 15;
            let precioFinal = precioBase * (1 + interes / 100) * (1 - descuento);

            document.getElementById("precio_estimado").value = precioFinal.toFixed(2);
            document.getElementById("interes").value = interes;
        }
    </script>
</head>

<body>
    <h2>Registrar Cotización</h2>
    <?php if (isset($_GET['success']))
        echo "<p>Cotización registrada correctamente.</p>"; ?>
    <?php if (isset($_GET['error']))
        echo "<p>Error al registrar la cotización.</p>"; ?>

    <form action="../Controller/VentasController.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

        <label>Vehículo:</label>
        <select name="id_vehiculo" id="vehiculo" onchange="actualizarPrecio()" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculosDisponibles as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>" data-precio="<?= $vehiculo['precio'] ?>">
                    <?= $vehiculo['marca'] . " " . $vehiculo['modelo'] ?>
                </option>
            <?php } ?>
        </select><br>

        <input type="hidden" id="precio_base" value="">

        <label>Plazo:</label>
        <select name="plazo" id="plazo" onchange="calcularPrecio()" required>
            <option value="3">3 meses</option>
            <option value="6">6 meses</option>
            <option value="12">12 meses</option>
        </select><br>

        <label>Descuento:</label>
        <select name="descuento" id="descuento" onchange="calcularPrecio()">
            <option value="0">Sin descuento</option>
            <option value="5">5%</option>
            <option value="10">10%</option>
            <option value="15">15%</option>
        </select><br>

        <label style="display:none;">Interés (%):</label>
        <input type="text" name="interes" id="interes" readonly style="display:none;"><br>

        <label style="display:none;">Precio Estimado:</label>
        <input type="text" name="precio_estimado" id="precio_estimado" readonly style="display:none;"><br>


        <button type="submit">Consultar</button>
    </form>

    <h2>Listado de Cotizaciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Precio Estimado</th>
            <th>Plazo</th>
            <th>Interés</th>
            <th>Descuento</th>
            <th>Fecha</th>
        </tr>
        <?php
        foreach ($cotizaciones as $cotizacion) {
            echo "<tr>";
            echo "<td>{$cotizacion['id_cotizacion']}</td>";
            echo "<td>{$cotizacion['cliente']}</td>";
            echo "<td>{$cotizacion['vehiculo']}</td>";
            echo "<td>{$cotizacion['precio_estimado']}</td>";
            echo "<td>{$cotizacion['plazo']}</td>";
            echo "<td>{$cotizacion['interes']}</td>";
            echo "<td>{$cotizacion['descuento_aplicado']}%</td>";
            echo "<td>{$cotizacion['fecha_cotizacion']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <script>
        function actualizarPrecio() {
            let vehiculoSelect = document.getElementById("vehiculo");
            let precioBase = vehiculoSelect.options[vehiculoSelect.selectedIndex].getAttribute("data-precio");
            document.getElementById("precio_base").value = precioBase;
            calcularPrecio();
        }
    </script>
</body>

</html>

<?php
require_once "../Model/Database.php";
require_once "../Model/VentasModel.php";

// Obtener datos de vehículos y clientes
$vehiculosDisponibles = obtenerVehiculosDisponibles();
$clientesDisponibles = obtenerClientesDisponibles();
$ventas = obtenerVentas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
    <script>
        function calcularPrecio() {
            let precioBase = parseFloat(document.getElementById("precio_base").value);
            let plazo = parseInt(document.getElementById("plazo").value);
            let descuento = parseFloat(document.getElementById("descuento").value) / 100;

            let interes = plazo === 3 ? 5 : plazo === 6 ? 10 : 15;
            let precioFinal = precioBase * (1 + interes / 100) * (1 - descuento);

            document.getElementById("precio_estimado").value = precioFinal.toFixed(2);
            document.getElementById("interes").value = interes;
        }
    </script>
</head>

<body>
    <h2>Registrar Venta</h2>


    <form action="../Controller/VentasController.php" method="POST">

        <label>Cliente:</label>
        <select name="id_cliente" id="cliente" required>
            <option value="">Seleccione un Cliente</option>
            <?php foreach ($clientesDisponibles as $cliente) { ?>
                <option value="<?= $cliente['id_usuario'] ?>"><?= $cliente['nombre'] ?></option>
            <?php } ?>
        </select><br>

        <label>Vehículo:</label>
        <select name="id_vehiculo" id="vehiculo" onchange="actualizarPrecio()" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculosDisponibles as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>" data-precio="<?= $vehiculo['precio'] ?>">
                    <?= $vehiculo['marca'] . " " . $vehiculo['modelo'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Total:</label>
        <input type="text" name="total" id="total" required><br>

        <label>Monto Cancelado:</label>
        <input type="number" name="monto_cancelado" id="monto_cancelado" min="0" required><br>

        <label>Saldo Pendiente:</label>
        <input type="text" name="saldo_pendiente" id="saldo_pendiente" readonly required><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Completada">Completada</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Anulada">Anulada</option>
        </select><br>

        <button type="submit">Registrar Venta</button>
    </form>

    <h2>Listado de Ventas</h2>
    <table border="1">
        <tr>
            <th>ID Venta</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Total</th>
            <th>Saldo Pendiente</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($ventas as $venta) { ?>
            <tr>
                <td><?= $venta['id_venta'] ?></td>
                <td><?= $venta['cliente'] ?></td>
                <td><?= $venta['marca'] . " " . $venta['modelo'] ?></td>
                <td><?= $venta['total'] ?></td>
                <td><?= $venta['saldo_pendiente'] ?></td>
                <td><?= $venta['estado'] ?></td>
                <td><?= $venta['fecha_venta'] ?></td>
            </tr>
        <?php } ?>
    </table>
    <script>
        function actualizarPrecio() {
            let vehiculoSelect = document.getElementById("vehiculo");
            let precioBase = vehiculoSelect.options[vehiculoSelect.selectedIndex].getAttribute("data-precio");
            document.getElementById("precio_base").value = precioBase;
            calcularPrecio();
        }
    </script>

    <script>
        // Cambia el valor del total cuando se elija un vehículo.
        document.getElementById("vehiculo").addEventListener("change", function () {
            var vehiculo = this.options[this.selectedIndex];
            var precio = vehiculo.getAttribute("data-precio");
            document.getElementById("total").value = precio;

            // Recalcular el saldo pendiente
            actualizarSaldo();
        });

        // Actualiza el saldo pendiente.
        document.getElementById("monto_cancelado").addEventListener("input", function () {
            actualizarSaldo();
        });

        function actualizarSaldo() {
            var total = parseFloat(document.getElementById("total").value) || 0;
            var cancelado = parseFloat(document.getElementById("monto_cancelado").value) || 0;
            var saldoPendiente = total - cancelado;
            document.getElementById("saldo_pendiente").value = saldoPendiente.toFixed(2);
        }
    </script>
</body>

</html>


</body>

</html>
<?php

require_once "../Controller/VentasController.php"; // Cargar el controlador

if (!isset($_SESSION['nombre'])) {
    exit();
}

// Obtener el ID del usuario logueado
$id_usuario = obtenerIdCliente($_SESSION['nombre']);

// Obtener las ventas pendientes
$ventasDisponibles = obtenerVentasPendientes(); // Obtener solo ventas pendientes
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>

<body>
    <h2>Registrar Devolución</h2>
    <?php if (isset($_GET['success']))
        echo "<p>Devolución registrada correctamente.</p>"; ?>
    <?php if (isset($_GET['error']))
        echo "<p>Error al registrar la devolución.</p>"; ?>

    <form action="../Controller/VentasController.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

        <label>Venta:</label>
        <select name="id_venta" id="venta" required>
            <option value="">Seleccione una Venta</option>
            <?php foreach ($ventasDisponibles as $venta) { ?>
                <option value="<?= $venta['id_venta'] ?>">
                    <?= "Venta ID: " . $venta['id_venta'] . " - Total: " . $venta['total'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Motivo de la Devolución:</label>
        <textarea name="motivo" required></textarea><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Pendiente">Pendiente</option>
            <option value="Aprobada">Aprobada</option>
            <option value="Rechazada">Rechazada</option>
        </select><br>

        <button type="submit">Registrar Devolución</button>
    </form>

    <h2>Listado de Devoluciones</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Venta</th>
            <th>Cliente</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
        <?php
        // Mostrar listado de devoluciones
        foreach ($devoluciones as $devolucion) {
            echo "<tr>";
            echo "<td>{$devolucion['id_devolucion']}</td>";
            echo "<td>{$devolucion['id_venta']}</td>";
            echo "<td>{$devolucion['cliente']}</td>";
            echo "<td>{$devolucion['motivo']}</td>";
            echo "<td>{$devolucion['estado']}</td>";
            echo "<td>{$devolucion['fecha_devolucion']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>


</html>

<?php

require_once "../Controller/VentasController.php";

// Obtener las facturas registradas
$facturaModel = new VentasModel();
$facturas = $facturaModel->obtenerFacturas();

// Obtener las ventas con estado Pendiente y Completada
$ventasDisponibles = obtenerVentasPendientesYCompletadas();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <h2>Registrar Factura</h2>
    <form action="../Controller/VentasController.php" method="post">
        <label>Venta:</label>
        <select name="id_venta" id="venta" required>
            <option value="">Seleccione una Venta</option>
            <?php foreach ($ventasDisponibles as $venta) { ?>
                <option value="<?= $venta['id_venta'] ?>">
                    <?= "Venta ID: " . $venta['id_venta'] . " - Total: " . $venta['total'] . " - Estado: " . $venta['estado'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="total">Total:</label>
        <input type="number" step="0.01" name="total" required>

        <button type="submit" name="registrar_factura">Registrar Factura</button>
    </form>

    <h2>Lista de Facturas</h2>
    <table border="1">
        <tr>
            <th>ID Factura</th>
            <th>ID Venta</th>
            <th>Fecha Emisión</th>
            <th>Total</th>
        </tr>
        <?php
        // Mostrar las facturas
        foreach ($facturas as $factura) {
            echo "<tr>";
            echo "<td>{$factura['id_factura']}</td>";
            echo "<td>{$factura['id_venta']}</td>";
            echo "<td>{$factura['fecha_emision']}</td>";
            echo "<td>$" . number_format($factura['total'], 2) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    </body>

</html>

<?php

require_once "../Controller/VentasController.php";
$ventasDisponibles = obtenerVentasPendientesYCompletadas();
$facturas = obtenerfacturas();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
</head>

<body>

    <h2>Registrar Pago</h2>
    <form action="../Controller/VentasController.php" method="post">
        <label>Venta:</label>
        <select name="id_venta" id="venta" required>
            <option value="">Seleccione una Venta</option>
            <?php foreach ($facturas as $factura) { ?>
                <option value="<?= $factura['id_factura'] ?>">
                    <?= "Factura ID: " . $factura['id_factura'] . " - Total: " . $factura['total'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="metodo_pago">Método de Pago:</label>
        <select name="metodo_pago" required>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Financiamiento">Financiamiento</option>
        </select>

        <label for="monto">Monto:</label>
        <input type="number" step="0.01" name="monto" required>

        <label for="meses">Meses (solo si es financiamiento):</label>
        <select name="meses">
            <option value="0">0 Meses </option>
            <option value="3">3 meses</option>
            <option value="6">6 meses</option>
            <option value="12">12 meses</option>
        </select>


        <label for="saldo_pendiente">Saldo Pendiente:</label>
        <input type="number" step="0.01" name="saldo_pendiente" required>

        <button type="submit" name="registrar_pago">Registrar Pago</button>
    </form>

    <h2>Lista de Pagos</h2>
    <table border="1">
        <tr>
            <th>ID Pago</th>
            <th>ID Venta</th>
            <th>Método de Pago</th>
            <th>Monto</th>
            <th>Meses</th>
            <th>Fecha Pago</th>
            <th>Saldo Pendiente</th>
        </tr>

        <?php
        $pagos = obtenerPagos();
        foreach ($pagos as $pago) {
            echo "<tr>";
            echo "<td>{$pago['id_pago']}</td>";
            echo "<td>{$pago['id_venta']}</td>";
            echo "<td>{$pago['metodo_pago']}</td>";
            echo "<td>$" . number_format($pago['monto'], 2) . "</td>";
            echo "<td>" . ($pago['meses'] ? $pago['meses'] : '-') . "</td>";
            echo "<td>{$pago['fecha_pago']}</td>";
            echo "<td>$" . number_format($pago['saldo_pendiente'], 2) . "</td>";
            echo "</tr>";
        }


        ?>
    </table>

</body>

</html>



<?php
require_once "../Model/VentasModel.php";

$promocionModel = new VentasModel();
$promociones = $promocionModel->obtenerPromociones();
$vehiculosDisponibles = obtenerVehiculosDisponibles();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>

<body>

    <!-- Formulario para registrar promociones -->
    <h3>Registrar Nueva Promoción</h3>
    <form action="../Controller/VentasController.php" method="POST">
        <label>Vehículo:</label>
        <select name="id_vehiculo" id="vehiculo" onchange="actualizarPrecio()" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculosDisponibles as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>" data-precio="<?= $vehiculo['precio'] ?>">
                    <?= $vehiculo['marca'] . " " . $vehiculo['modelo'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea>
        <label>Descuento:</label>
        <select name="descuento" id="descuento" onchange="calcularPrecio()">
            <option value="0">Sin descuento</option>
            <option value="5">5%</option>
            <option value="10">10%</option>
            <option value="15">15%</option>
        </select><br>
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" required>

        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" name="fecha_fin" required>

        <button type="submit">Registrar Promoción</button>
    </form>

    <hr>

    <!-- Lista de promociones -->
    <h3>Promociones Registradas</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Promoción</th>
                <th>Vehículo</th>
                <th>Descripción</th>
                <th>Descuento (%)</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($promociones)): ?>
                <?php foreach ($promociones as $promo): ?>
                    <tr>
                        <td><?= $promo['id_promocion'] ?></td>
                        <td><?= $promo['marca'] . " " . $promo['modelo'] ?></td>
                        <td><?= $promo['descripcion'] ?></td>
                        <td><?= $promo['descuento'] ?>%</td>
                        <td><?= $promo['fecha_inicio'] ?></td>
                        <td><?= $promo['fecha_fin'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay promociones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>

<?php

require_once "../Controller/VentasController.php";

if (!isset($_SESSION['nombre'])) {
    exit();
}

$id_cliente = obtenerIdCliente($_SESSION['nombre']);
$vehiculosDisponibles = obtenerVehiculosDisponibles();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>

<body>
    <h2>Registrar Nueva Reserva</h2>

    <?php if (isset($_GET['success']))
        echo "<p>Reserva registrada correctamente.</p>"; ?>
    <?php if (isset($_GET['error']))
        echo "<p>Error al registrar la reserva.</p>"; ?>

    <form action="../Controller/VentasController.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">

        <label>Vehículo:</label>
        <select name="id_vehiculo" id="vehiculo" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculosDisponibles as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>" data-precio="<?= $vehiculo['precio'] ?>">
                    <?= $vehiculo['marca'] . " " . $vehiculo['modelo'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Duración de la Reserva:</label>
        <select type="number" name="monto_reserva" id="monto_reserva" step="0.01" required>
            <option value="1000.00">1 mes - $1000</option>
            <option value="2000.00">2 meses - $2000</option>
            <option value="3000.00">3 meses - $3000</option>
        </select><br>

        <style>
            #estado,
            label[for="estado"] {
                display: none;
            }
        </style>

        <label> </label>
        <select name="estado" id="estado" required>
            <option value="Reservado">Reservado</option>
            <option value="Disponible">Disponible</option>
        </select><br>



        <button type="submit">Registrar Reserva</button>
    </form>

    <hr>

    <h2>Lista de Reservas</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Monto</th>
                <th>Fecha Reserva</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reservas)): ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['cliente']) ?></td>
                        <td><?= htmlspecialchars($reserva['marca'] . " " . $reserva['modelo']) ?></td>
                        <td><?= htmlspecialchars($reserva['monto_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay reservas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>



<?php
// Incluir el controlador para obtener los reportes
require_once "../Controller/VentasController.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Ventas</title>
    <link rel="stylesheet" href="../View/dist/css/style.css">
</head>

<body>
    <h2>Generar Reporte de Ventas</h2>

    <!-- Mensajes de éxito o error -->
    <?php if (isset($_GET['success']))
        echo "<p>Reporte generado correctamente.</p>"; ?>
    <?php if (isset($_GET['error']))
        echo "<p>Error al generar el reporte.</p>"; ?>

    <!-- Formulario para generar reporte -->
    <form action="../Controller/VentasController.php" method="POST">
        <button type="submit" name="generar_reporte">Generar Reporte</button>
    </form>

    <h2>Listado de Reportes</h2>
    <table border="1">
        <tr>
            <th>ID Reporte</th>
            <th>Fecha Reporte</th>
            <th>Total Ventas</th>
            <th>Cantidad de Ventas</th>
        </tr>
        <?php
        $reportes = obtenerReportes();
        foreach ($reportes as $reporte) {
            echo "<tr>";
            echo "<td>{$reporte['id_reporte']}</td>";
            echo "<td>{$reporte['fecha_reporte']}</td>";
            echo "<td>{$reporte['total_ventas']}</td>";
            echo "<td>{$reporte['cantidad_ventas']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>