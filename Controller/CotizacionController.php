<?php
include_once '../Model/Database.php';
include_once '../Model/CotizacionModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (isset($_POST['create_quote'])) {
        $client_id = $_POST['client_id'];
        $vehicle_id = $_POST['vehicle_id'];

        $quote = sp_generar_cotizacion($vehicle_id);
        if ($quote && isset($quote['id'])) {
            if (!empty($client_id)) {
                $result = sp_enviar_cotizacion($quote['id'], $client_id);
                if ($result) {
                    header("Location: ../View/CotizacionView.php?msg=Cotización creada y asignada exitosamente");
                } else {
                    header("Location: ../View/CotizacionView.php?msg=Cotización creada pero error al asignar al cliente");
                }
            } else {
                header("Location: ../View/CotizacionView.php?msg=Cotización creada exitosamente");
            }
        } else {
            header("Location: ../View/CotizacionView.php?msg=Error al crear cotización");
        }
        exit;
    }
    else if (isset($_POST['create_cuota'])) {
        $quote_id = $_POST['quote_id'];
        $monto = $_POST['monto'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];

        $resultado = sp_registrar_cuota($quote_id, $monto, $fecha_vencimiento);
        if ($resultado) {
            header("Location: ../View/CotizacionView.php?msg=Cuota registrada exitosamente");
        } else {
            header("Location: ../View/CotizacionView.php?msg=Error al registrar cuota");
        }
        exit;
    }
} 
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'list' && isset($_GET['client_id'])) {
        $client_id = $_GET['client_id'];
        echo "Consultar cotizaciones para el cliente: " . htmlspecialchars($client_id);
        exit;
    } 
    else if (isset($_GET['action']) && $_GET['action'] === 'cuotas' && isset($_GET['quote_id'])) {
        $quote_id = $_GET['quote_id'];
        $cuotas = sp_obtener_cuotas($quote_id);
        echo json_encode($cuotas);
        exit;
    } 
    else {
        $vehiculos = sp_listar_vehiculos();/**no tocar */
        $clientes  = sp_listar_clientes();/**no tocar */
        $unsentQuotes = sp_listar_quotes_pendientes();
        $msg = isset($_GET['msg']) ? $_GET['msg'] : "";
        include_once '../View/CotizacionView.php';
    }
}
?>
