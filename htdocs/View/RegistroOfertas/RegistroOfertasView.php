<?php
$conexion = new mysqli("localhost", "root", "", "SolisMotors3718");
if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);

// Registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vehicle_offer'])) {
    $campos = ['vehicle_offer', 'status_vehicle', 'price_offer', 'km_vehicle', 'type_vehicle', 'traction_vehicle', 'motor_vehicle'];
    foreach ($campos as $campo) $$campo = $_POST[$campo];

    $img_vehicle_offer = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = uniqid() . "_" . basename($_FILES['image']['name']);
        $temporal = $_FILES['image']['tmp_name'];
        $carpeta = "ofertas/";
        $img_vehicle_offer = $carpeta . $nombre_imagen;
        if (!is_dir($carpeta)) mkdir($carpeta, 0777, true);
        move_uploaded_file($temporal, $img_vehicle_offer);
    }

    $stmt = $conexion->prepare("INSERT INTO offers (vehicle_offer, status_vehicle, price_offer, img_vehicle_offer, km_vehicle, type_vehicle, traction_vehicle, motor_vehicle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssss", $vehicle_offer, $status_vehicle, $price_offer, $img_vehicle_offer, $km_vehicle, $type_vehicle, $traction_vehicle, $motor_vehicle);
    echo $stmt->execute() ? "<div class='alert alert-success'>✅ Vehículo registrado correctamente.</div>" : "<div class='alert alert-danger'>❌ Error: {$stmt->error}</div>";
    $stmt->close();
}

// Eliminación
if (isset($_POST['eliminarOferta'])) {
    $id = intval($_POST['id_vehicle_eliminar']);
    $res = $conexion->query("SELECT img_vehicle_offer FROM offers WHERE id_offer = $id");
    if ($res && $row = $res->fetch_assoc()) if (file_exists($row['img_vehicle_offer'])) unlink($row['img_vehicle_offer']);
    $conexion->query("DELETE FROM offers WHERE id_offer = $id");
}

$resultado = $conexion->query("SELECT * FROM offers");
$cantidadVehiculos = $resultado->num_rows;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solis Motors - Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/inventario_moderno.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

<header class="main-header">
    <h1>Gestión de Inventario</h1>
</header>

<?php include('../Nav/Nav.php'); ?>

<main class="container py-5 fade-in">
    <h2 class="text-center mb-4">Registrar Vehículo</h2>
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm border-0 rounded-4 bg-light mb-5">
        <div class="row g-3">
            <!-- Columna 1 -->
            <div class="col-md-6">
                <input name="vehicle_offer" class="form-control" placeholder="Vehículo" required>
                <select name="status_vehicle" class="form-select" required>
                    <option value="">Estado</option>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Semi Nuevo">Semi Nuevo</option>
                </select>
                <input name="price_offer" type="number" class="form-control" placeholder="Precio" step="0.01" required>
                <input name="km_vehicle" type="number" class="form-control" placeholder="Kilometraje" required>
            </div>

            <!-- Columna 2 -->
            <div class="col-md-6">
                <input name="type_vehicle" class="form-control" placeholder="Tipo de vehículo" required>
                <input name="traction_vehicle" class="form-control" placeholder="Tracción" required>
                <input name="motor_vehicle" class="form-control" placeholder="Motor" required>
                <input type="file" name="image" class="form-control">
                <button type="submit" class="btn btn-dark w-100 mt-3"><i class="bi bi-save"></i> Registrar</button>
            </div>
        </div>
    </form>

    <h2 class="text-center">Vehículos registrados (<?php echo $cantidadVehiculos; ?>)</h2>

    <table id="tablaVehiculos" class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Kilometraje</th>
                <th>Tipo</th>
                <th>Tracción</th>
                <th>Motor</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $fila['id_offer'] ?></td>
                <td><?= $fila['vehicle_offer'] ?></td>
                <td><?= $fila['status_vehicle'] ?></td>
                <td>₡<?= number_format($fila['price_offer'], 2) ?></td>
                <td><?php if ($fila['img_vehicle_offer']): ?><img src="<?= $fila['img_vehicle_offer'] ?>" width="80" class="img-thumbnail"><?php endif; ?></td>
                <td><?= $fila['km_vehicle'] ?></td>
                <td><?= $fila['type_vehicle'] ?></td>
                <td><?= $fila['traction_vehicle'] ?></td>
                <td><?= $fila['motor_vehicle'] ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Eliminar esta oferta?');">
                        <input type="hidden" name="id_vehicle_eliminar" value="<?= $fila['id_offer'] ?>">
                        <button type="submit" name="eliminarOferta" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tablaVehiculos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
            },
            responsive: true
        });
    });
</script>
<?php include('../Nav/Footer.php'); ?>
</body>
</html>
