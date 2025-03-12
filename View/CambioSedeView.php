<?php
include_once '../Controller/CambioSedeController.php';

// Obtener datos
$envios = obtenerEnvios();
$opciones = obtenerOpciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cambio de Sede</title>
</head>
<body>
    <h2>Solicitar Cambio de Sede</h2>
    
    <form action="../Controller/CambioSedeController.php?action=add" method="POST">
        <label for="brand">Marca:</label>
        <select name="brand" id="brand" required>
            <option value="">Seleccione una marca</option>
            <?php foreach ($opciones as $op) { ?>
                <option value="<?= $op['brand']; ?>"><?= $op['brand']; ?></option>
            <?php } ?>
        </select>

        <label for="model">Modelo:</label>
        <select name="model" id="model" required>
            <option value="">Seleccione un modelo</option>
        </select>

        <label for="headquarters_change">Nueva Sede:</label>
        <select name="headquarters_change" id="headquarters_change" required>
            
            <?php foreach ($opciones as $op) { ?>
                <option value="<?= $op['headquarters']; ?>"><?= $op['headquarters']; ?></option>
            <?php } ?>
        </select>

        <button type="submit">Solicitar Envío</button>
    </form>

    <hr>

    <h2>Solicitudes de Envío</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nueva Sede</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($envios as $envio) { ?>
            <tr>
                <td><?= $envio['id']; ?></td>
                <td><?= $envio['brand']; ?></td>
                <td><?= $envio['model']; ?></td>
                <td><?= $envio['headquarters_change']; ?></td>
                <td><?= $envio['change_date']; ?></td>
                <td><?= $envio['status_change']; ?></td>
                <td>
                    <?php if ($envio['status_change'] == 'Enviando') { ?>
                        <a href="../Controller/CambioSedeController.php?action=resolve&id=<?= $envio['id']; ?>">Marcar como Llegó</a>
                    <?php } else { ?>
                        ✅
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <script>
        // Filtrar modelos según la marca seleccionada
        document.getElementById('brand').addEventListener('change', function() {
            let selectedBrand = this.value;
            let modelSelect = document.getElementById('model');
            modelSelect.innerHTML = '<option value="">Seleccione un modelo</option>';

            <?php foreach ($opciones as $op) { ?>
                if ('<?= $op['brand']; ?>' === selectedBrand) {
                    let option = document.createElement('option');
                    option.value = '<?= $op['model']; ?>';
                    option.textContent = '<?= $op['model']; ?>';
                    modelSelect.appendChild(option);
                }
            <?php } ?>
        });
    </script>
</body>
</html>
