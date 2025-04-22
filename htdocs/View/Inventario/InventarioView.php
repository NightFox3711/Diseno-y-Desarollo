<?php
$conexion = new mysqli("localhost", "root", "", "SolisMotors3718");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['brand'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $headquarters = $_POST['headquarters'];
    $status_available = $_POST['status_vehicle_available'];
    $km = $_POST['km_vehicle'];
    $type = $_POST['type_vehicle'];
    $traction = $_POST['traction_vehicle'];
    $motor = $_POST['motor_vehicle'];

    $image_path = NULL;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $nombre_imagen = basename($_FILES['image']['name']);
        $temporal = $_FILES['image']['tmp_name'];
        $carpeta = "imagenes/";
        $image_path = $carpeta . $nombre_imagen;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        move_uploaded_file($temporal, $image_path);
    }

    $sql = "INSERT INTO vehicles (brand, model, price, status, image_path, headquarters, status_vehicle_available, km_vehicle, type_vehicle, traction_vehicle, motor_vehicle)
            VALUES ('$brand', '$model', '$price', '$status', '$image_path', '$headquarters', '$status_available', '$km', '$type', '$traction', '$motor')";

    if ($conexion->query($sql)) {
        echo "<p style='color:green;'>✅ Vehículo registrado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . $conexion->error . "</p>";
    }
}

// Cambio de sede
if (isset($_POST['cambiarSede'])) {
    $idVehiculo = $_POST['id_vehicle'];
    $nuevaSede = $_POST['nueva_sede'];

    $updateSede = "UPDATE vehicles SET headquarters = '$nuevaSede' WHERE id_vehicle = $idVehiculo";
    if ($conexion->query($updateSede)) {
        echo "<p style='color:green;'>✅ Cambio de sede actualizado.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al cambiar la sede: " . $conexion->error . "</p>";
    }
}

// Cambio de estado
if (isset($_POST['cambiarEstado'])) {
    $idVehiculo = $_POST['id_vehicle_estado'];
    $nuevoEstado = $_POST['nuevo_estado'];

    $updateEstado = "UPDATE vehicles SET status = '$nuevoEstado' WHERE id_vehicle = $idVehiculo";
    if ($conexion->query($updateEstado)) {
        echo "<p style='color:green;'>✅ Estado del vehículo actualizado.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al cambiar el estado: " . $conexion->error . "</p>";
    }
}

// Eliminar Vehículo
if (isset($_POST['eliminarVehiculo'])) {
    $idVehiculoEliminar = $_POST['id_vehicle_eliminar'];

    // Opcional: eliminar la imagen del servidor si existe
    $imagenConsulta = $conexion->query("SELECT image_path FROM vehicles WHERE id_vehicle = $idVehiculoEliminar");
    $imagenData = $imagenConsulta->fetch_assoc();
    if ($imagenData && file_exists($imagenData['image_path'])) {
        unlink($imagenData['image_path']); // elimina la imagen del disco
    }

    $deleteQuery = "DELETE FROM vehicles WHERE id_vehicle = $idVehiculoEliminar";
    if ($conexion->query($deleteQuery)) {
        echo "<p style='color:green;'>✅ Vehículo eliminado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al eliminar el vehículo: " . $conexion->error . "</p>";
    }
}

// Consulta
$resultado = $conexion->query("SELECT * FROM vehicles");
$cantidadVehiculos = $resultado->num_rows;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solis Motors - Inventario</title>
    <link rel="stylesheet" href="../../assets/css/Inventario.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', sans-serif; background-color: #FFFFFF; color: #1F3C6E;">

    <header
        style="background-color: #1F3C6E; color: #FFFFFF; padding: 20px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-weight: 300; font-size: 2.5rem;">Gestión de Inventario</h1>
    </header>

    <?php include('../Nav/Nav.php'); ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Gestión de Vehículos y Cambios de Sede</h2>

        <!-- Pestañas de navegación -->
        <div class="d-flex justify-content-center mb-4">
            <ul class="nav nav-pills gap-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-vehiculo-tab" data-bs-toggle="pill" href="#pills-vehiculo"
                        role="tab" aria-controls="pills-vehiculo" aria-selected="true"
                        style="background-color: #1F3C6E; border: none; color: white;">Vehículo</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-cambio-sede-tab" data-bs-toggle="pill" href="#pills-cambio-sede"
                        role="tab" aria-controls="pills-cambio-sede" aria-selected="false"
                        style="background-color: #1F3C6E; border: none; color: white;">Cambio de Sede</a>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <!-- Sección Vehículo -->
            <div class="tab-pane fade show active" id="pills-vehiculo" role="tabpanel"
                aria-labelledby="pills-vehiculo-tab">
                <h3 class="text-center mb-4">Registrar Vehículo</h3>

                <div class="card shadow-lg p-4" style="border-radius: 1rem; background-color: #f8f9fa;">
                    <form method="post" enctype="multipart/form-data" class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Marca:</label>
                            <input type="text" name="brand" class="form-control" required>

                            <label class="form-label">Modelo:</label>
                            <input type="text" name="model" class="form-control" required>

                            <label class="form-label">Precio:</label>
                            <input type="number" name="price" step="0.01" class="form-control" required>

                            <label class="form-label">Estado:</label>
                            <select name="status" class="form-select" required>
                                <option value="Disponible">Disponible</option>
                                <option value="Reservado">Reservado</option>
                                <option value="Vendido">Vendido</option>
                            </select>

                            <label class="form-label">Sede:</label>
                            <select name="headquarters" class="form-select" required>
                                <option value="Sede Central - San Pablo, Heredia">Sede Central - San Pablo, Heredia
                                </option>
                                <option value="Sede Secundaria - San Joaquín, Heredia">Sede Secundaria - San Joaquín,
                                    Heredia</option>
                            </select>

                            <label class="form-label">Estado del Vehículo:</label>
                            <select name="status_vehicle_available" class="form-select" required>
                                <option value="Nuevo">Nuevo</option>
                                <option value="Semi Nuevo">Semi Nuevo</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kilometraje:</label>
                            <input type="number" name="km_vehicle" step="0.001" class="form-control" required>

                            <label class="form-label">Tipo de vehículo:</label>
                            <input type="text" name="type_vehicle" class="form-control" required>

                            <label class="form-label">Tracción:</label>
                            <input type="text" name="traction_vehicle" maxlength="3" class="form-control" required>

                            <label class="form-label">Motor:</label>
                            <input type="text" name="motor_vehicle" maxlength="8" class="form-control" required>

                            <label class="form-label">Imagen:</label>
                            <input type="file" name="image" class="form-control">

                            <div class="text-center">
                                <input type="submit" value="Registrar" class="btn btn-primary mt-4"
                                    style="background-color: #1F3C6E; border: none; padding: 0.5rem 2rem;">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <hr class="my-5">

        <h2 class="text-center">Vehículos registrados</h2>
        <p class="text-center">Total de vehículos: <strong><?php echo $cantidadVehiculos; ?></strong></p>

        <table id="tablaVehiculos" class="table table-striped table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Sede</th>
                    <th>Estado Vehículo</th>
                    <th>Kilometraje</th>
                    <th>Tipo</th>
                    <th>Tracción</th>
                    <th>Motor</th>
                    <th>Cambiar Sede</th>
                    <th>Cambiar Estado</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $fila['id_vehicle']; ?></td>
                        <td><?php echo $fila['brand']; ?></td>
                        <td><?php echo $fila['model']; ?></td>
                        <td>₡<?php echo number_format($fila['price'], 2); ?></td>
                        <td><?php echo $fila['status']; ?></td>
                        <td>
                            <?php if ($fila['image_path']) { ?>
                                <img src="<?php echo $fila['image_path']; ?>" width="100" class="img-thumbnail">
                            <?php } ?>
                        </td>
                        <td><?php echo $fila['headquarters']; ?></td>
                        <td><?php echo $fila['status_vehicle_available']; ?></td>
                        <td><?php echo $fila['km_vehicle']; ?> km</td>
                        <td><?php echo $fila['type_vehicle']; ?></td>
                        <td><?php echo $fila['traction_vehicle']; ?></td>
                        <td><?php echo $fila['motor_vehicle']; ?> cc</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id_vehicle" value="<?php echo $fila['id_vehicle']; ?>">
                                <select name="nueva_sede" class="form-select mb-1" required>
                                    <option value="">--Seleccionar sede--</option>
                                    <option value="Sede Central - San Pablo, Heredia">Sede Central</option>
                                    <option value="Sede Secundaria - San Joaquín, Heredia">Sede Secundaria</option>
                                </select>
                                <input type="submit" name="cambiarSede" value="Confirmar"
                                    class="btn btn-sm btn-outline-primary">
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id_vehicle_estado" value="<?php echo $fila['id_vehicle']; ?>">
                                <select name="nuevo_estado" class="form-select mb-1" required>
                                    <option value="">--Seleccionar estado--</option>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Reservado">Reservado</option>
                                    <option value="Vendido">Vendido</option>
                                </select>
                                <input type="submit" name="cambiarEstado" value="Confirmar"
                                    class="btn btn-sm btn-outline-success">
                            </form>
                        </td>
                        <td>
                            <form method="post" onsubmit="return confirm('¿Está seguro que desea eliminar este vehículo?');">
                                <input type="hidden" name="id_vehicle_eliminar" value="<?php echo $fila['id_vehicle']; ?>">
                                <button type="submit" name="eliminarVehiculo" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Sección Cambio de Sede -->
    <div class="tab-pane fade" id="pills-cambio-sede" role="tabpanel" aria-labelledby="pills-cambio-sede-tab">
        <h3 class="text-center mb-4">Registrar Cambio de Sede</h3>
        <form method="post" class="form-container">
            <div class="form-column">
                <label>Marca:</label>
                <select name="brand_change" required>
                    <option value="">-- Seleccionar marca --</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Honda">Honda</option>
                    <option value="BMW">BMW</option>
                    <!-- Agregar más marcas aquí -->
                </select>

                <label>Modelo:</label>
                <input type="text" name="model_change" required>

                <label>Cambio de sede:</label>
                <select name="new_headquarters" required>
                    <option value="">-- Seleccionar nueva sede --</option>
                    <option value="Sede Central - San Pablo, Heredia">Sede Central</option>
                    <option value="Sede Secundaria - San Joaquín, Heredia">Sede Secundaria</option>
                </select>

                <input type="submit" value="Registrar" class="btn btn-primary mt-3"
                    style="background-color: #1F3C6E; border: none;">
            </div>
        </form>

        <?php
        $resultadoCambios = $conexion->query("SELECT * FROM headquarters_change");
        ?>

        <h2 class="text-center">Historial de cambios de sede</h2>

        <table id="tablaHistorial" class="table table-striped table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Fecha de Cambio</th>
                    <th>Nueva Sede</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultadoCambios->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $fila['id_headquartersChange']; ?></td>
                        <td><?php echo $fila['brand_change']; ?></td>
                        <td><?php echo $fila['model_change']; ?></td>
                        <td><?php echo $fila['change_date']; ?></td>
                        <td><?php echo $fila['headquarters_change']; ?></td>
                        <td><?php echo $fila['status_change']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            var vehiculosTable = $('#tablaVehiculos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                },
                pageLength: 10,
                paging: true,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true  // Habilita el diseño responsivo
            });

            var historialTable = $('#tablaHistorial').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                },
                pageLength: 10,
                paging: true,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true  // Habilita el diseño responsivo
            });
        });
    </script>

    <?php include('../Nav/Footer.php'); ?>
</body>

</html>