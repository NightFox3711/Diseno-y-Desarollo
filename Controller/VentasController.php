<?php
require_once "../Model/VentasModel.php";

$cotizacionModel = new VentasModel();
$ventasModel = new VentasModel();
$devolucionesModel = new VentasModel();
$facturaModel = new VentasModel();
$pagosModel = new VentasModel();
$promocionModel = new VentasModel();
$reservaModel = new VentasModel();
$reportesModel = new VentasModel();


//Funciones de registrar

//Cotizacion

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST["id_cliente"];
    $id_vehiculo = $_POST["id_vehiculo"];
    $precio_estimado = $_POST["precio_estimado"];
    $plazo = $_POST["plazo"];
    $interes = $_POST["interes"];
    $descuento_aplicado = $_POST["descuento_aplicado"];

    $registrado = $cotizacionModel->registrarCotizacion($id_cliente, $id_vehiculo, $precio_estimado, $plazo, $interes, $descuento_aplicado);

    if ($registrado) {
        header("Location: ../View/VentasView.php?success=1");
    } else {
        header("Location: ../View/VentasView.php?error=1");
    }
} else {
    $cotizaciones = $cotizacionModel->obtenerCotizaciones();
}

//Ventas
if (isset($_POST['id_cliente'], $_POST['id_vehiculo'], $_POST['total'], $_POST['saldo_pendiente'], $_POST['estado'])) {
    $id_cliente = $_POST['id_cliente'];
    $id_vehiculo = $_POST['id_vehiculo'];
    $total = $_POST['total'];
    $saldo_pendiente = $_POST['saldo_pendiente'];
    $estado = $_POST['estado'];

    $resultado = $ventasModel->registrarVenta($id_cliente, $id_vehiculo, $total, $saldo_pendiente, $estado);

    if ($resultado) {
        header("Location: ../View/VentasView.php?success=true");
    } else {
        header("Location: ../View/VentasView.php?error=true");
    }
}


//Devoluciones 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_venta = $_POST["id_venta"];
    $id_usuario = $_POST["id_usuario"];
    $motivo = $_POST["motivo"];
    $estado = $_POST["estado"];

    $registrado = $devolucionesModel->registrarDevolucion($id_venta, $id_usuario, $motivo, $estado);

    if ($registrado) {
        header("Location: ../View/VentasView.php?success=1");
    } else {
        header("Location: ../View/VentasView.php?error=1");
    }
} else {
    $devoluciones = $devolucionesModel->obtenerDevoluciones();
}


//Facturas Y pagos 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

//Me gsutaría saber porque no pueden funcionar separados como registros normales 

    if (isset($_POST["registrar_factura"])) {
      
        $id_venta = $_POST["id_venta"];
        $total = $_POST["total"];

       
        $registrado = $facturaModel->registrarFactura($id_venta, $total);

        if ($registrado) {
            header("Location: ../View/VentasView.php?success=Factura registrada");
        } else {
            header("Location: ../View/VentasView.php?error=Error al registrar");
        }
    }



   
    if (isset($_POST["registrar_pago"])) {
        $id_venta = $_POST["id_venta"];
        $metodo_pago = $_POST["metodo_pago"];
        $monto = $_POST["monto"];
        $meses = $_POST["meses"];
        $saldo_pendiente = $_POST["saldo_pendiente"];

        $registrado = $pagosModel->registrarPago($id_venta, $metodo_pago, $monto, $meses, $saldo_pendiente);

        if ($registrado) {
           
            $pagos = $pagosModel->obtenerPagos();  
           
            include("../View/VentasView.php");  
        } else {
            header("Location: ../View/VentasView.php?error=Error al registrar pago");
        }
    } else {
        

        $facturas = $facturaModel->obtenerFacturas();
    }

}

//Promociones

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_vehiculo'], $_POST['descripcion'], $_POST['descuento'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
    $id_vehiculo = $_POST["id_vehiculo"];
    $descripcion = $_POST["descripcion"];
    $descuento = $_POST["descuento"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    $registrado = $promocionModel->registrarPromocion($id_vehiculo, $descripcion, $descuento, $fecha_inicio, $fecha_fin);

    if ($registrado) {
        header("Location: ../View/VentasView.php?success=1");
    } else {
        header("Location: ../View/VentasView.php?error=1");
    }
} else {
    $promociones = $promocionModel->obtenerPromociones();
}

//reservas

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id_cliente'], $_POST['id_vehiculo'], $_POST['monto_reserva'], $_POST['estado'])) {
        $id_cliente = intval($_POST["id_cliente"]);
        $id_vehiculo = intval($_POST["id_vehiculo"]);
        $monto_reserva = floatval($_POST["monto_reserva"]);
        $estado = $_POST["estado"]; 
//Otro que no funciona de forma normal

        if (!in_array($estado, ['Reservado', 'Disponible'])) {
            header("Location: ../View/VentasView.php?error=estado_invalido");
            exit();
        }

        $registrado = $reservaModel->registrarReserva($id_cliente, $id_vehiculo, $monto_reserva, $estado);

        if ($registrado) {
            header("Location: ../View/VentasView.php?success=1");
        } else {
            header("Location: ../View/VentasView.php?error=1");
        }
    }
} else {
    
    $reservas = $reservaModel->obtenerReservas();
}

//Reportes

if (isset($_POST['generar_reporte'])) {
    $resultado = $reportesModel->generarReporteVentas();

    if ($resultado) {
        header("Location: ../View/VentasView.php?success=true");
    } else {
        header("Location: ../View/VentasView.php?error=true");
    }
}



//Funciones de Obtener/Mostar


//Cotizacion no tiene porque ? no sé 

//Ventas

function mostrarVentas()
{
    $conexion = AbrirBaseDatos();
    $query = "CALL sp_mostrar_ventas()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }

    CerrarBaseDatos($conexion);
    return $ventas;
}

function obtenerVentas()
{
    return mostrarVentas();
}


//Devoluciones

function mostrarDevoluciones()
{
    $conexion = AbrirBaseDatos();
    $query = "CALL sp_Mostrar_devoluciones()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }

    CerrarBaseDatos($conexion);
    return $ventas;
}


function obtenerDevoluciones()
{
    return mostrarDevoluciones();
}

//Facturas no tiene supongo que esta dentro del registro 

//Pagos


function mostrarPagos()
{
    $conexion = AbrirBaseDatos();
    $query = "CALL sp_mostrar_pago()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $pagos = [];
    while ($row = $result->fetch_assoc()) {
        $pagos[] = $row;
    }

    CerrarBaseDatos($conexion);
    return $pagos;
}

//Porque pagos si tiene cuando esta en la misma basura que facuturas?????

function obtenerPagos()
{
    return mostrarPagos();
}



//Reservas no tiene 

//Reportes 


function obtenerReportes()
{
    global $reportesModel;
    return $reportesModel->obtenerReportes();
}



//Osea -_-


//Funciones varias de busqueda 


//Obtener clientes por ID

function obtenerIdCliente($nombre)
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();
    $stmt = $conn->prepare("SELECT id_usuario FROM Usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->bind_result($id_usuario);
    $stmt->fetch();
    $stmt->close();
    CerrarBaseDatos($conn);
    return $id_usuario;
}


//Vehiculos disponibles Motos

function obtenerVehiculosDisponibles()
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    $sql = "SELECT id_vehiculo, marca, modelo, precio FROM Vehiculos WHERE estado = 'Disponible'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $vehiculos = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $vehiculos;
}


// Lo mismo que los vehiculos oslo que con clientes

function obtenerClientesDisponibles()
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    $sql = "SELECT id_usuario, nombre FROM Usuarios WHERE rol = 'Cliente'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $cliente = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $cliente;
}



//Lo mismo pero con ventas


function obtenerVentasId()
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    $sql = "SELECT id_venta, total FROM Ventas";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $ventas;
}


function obtenerPrecio($id_vehiculo)
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    $stmt = $conn->prepare("SELECT precio FROM Vehiculos WHERE id_vehiculo = ?");
    $stmt->bind_param("i", $id_vehiculo);
    $stmt->execute();
    $stmt->bind_result($precio);
    $stmt->fetch();
    
    $stmt->close();
    CerrarBaseDatos($conn);
    
    return $precio;
}


if (isset($_POST['id_vehiculo'])) {
    $id_vehiculo = $_POST['id_vehiculo'];

    function obtenerPrecio($id_vehiculo)
    {
        $conn = AbrirBaseDatos();

        $stmt = $conn->prepare("SELECT precio FROM Vehiculos WHERE id_vehiculo = ?");
        $stmt->bind_param("i", $id_vehiculo);
        $stmt->execute();
        $stmt->bind_result($precio);
        $stmt->fetch();
        $stmt->close();

        CerrarBaseDatos($conn);

        echo json_encode(['precio' => $precio]);
    }

    obtenerPrecio($id_vehiculo);
} 


// Función para obtener ventas con estado Pendiente
function obtenerVentasPendientes()
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    $sql = "SELECT id_venta, total FROM Ventas WHERE estado = 'Pendiente'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $ventas;
}


// Función para obtener ventas con estado Pendiente y Completada
function obtenerVentasPendientesYCompletadas()
{
    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    
    $sql = "SELECT id_venta, total, estado FROM Ventas WHERE estado IN ('Pendiente', 'Completada')";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $ventas;
}


function obtenerfacturas(){

    require_once "../Model/Database.php";
    $conn = AbrirBaseDatos();

    
    $sql = "SELECT id_factura, total FROM facturas";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    CerrarBaseDatos($conn);
    return $ventas;
}