<?php
require_once __DIR__ . '/../Model/VentasModel.php';


$cotizacionModel = new VentasModel();//Nombre fijo esto no se cambia 
$ventasModel = new VentasModel();//Nombre fijo esto no se cambia 
$devolucionesModel = new VentasModel();//Nombre fijo esto no se cambia 
$facturaModel = new VentasModel();//Nombre fijo esto no se cambia 
$pagosModel = new VentasModel();//Nombre fijo esto no se cambia 
$promocionModel = new VentasModel();//Nombre fijo esto no se cambia 
$reservaModel = new VentasModel();//Nombre fijo esto no se cambia 
$reportesModel = new VentasModel();//Nombre fijo esto no se cambia 
//El nombre de las funciones del model tambien se quedan fijos porque se quedan en español


//Funciones de registrar

//Cotizacion

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*var_dump($_POST);
    exit;*/

    $id_customer = $_POST["id_customer"];
    $id_vehicle = $_POST["id_vehicle"];
    $estimated_price = $_POST["estimated_price"];
    $term = $_POST["term"];
    $interest = $_POST["interest"];
    $applied_discount = $_POST["applied_discount"];

    $registrado = $cotizacionModel->registrarCotizacion($id_customer, $id_vehicle, $estimated_price, $term, $interest, $applied_discount);

    if ($registrado) {
        header("Location: ../View/Ventas/VentasView.php?success=1");
    } else {
        header("Location: ../View/Ventas/VentasView.php?error=1");
    }
} else {
    $cotizaciones = $cotizacionModel->obtenerCotizaciones();
}

//Ventas
if (isset($_POST['id_customer'], $_POST['id_vehicle'], $_POST['total'], $_POST['pending_balance'], $_POST['status'])) {
    

    $id_customer = $_POST['id_customer'];
    $id_vehicle = $_POST['id_vehicle'];
    $total = $_POST['total'];
    $pending_balance = $_POST['pending_balance'];
    $status = $_POST['status'];

    
    $resultado = $ventasModel->registrarVenta($id_customer, $id_vehicle, $total, $pending_balance, $status);


    if ($resultado) {
        header("Location: ../View/Ventas/VentasView.php?success=true");
    } else {
        header("Location: ../View/Ventas/VentasView.php?error=true");
    }
}


//Devoluciones 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $id_sales = $_POST["id_sales"];
    $id_username = $_POST["id_customer"];
    $reason = $_POST["reason"];
    $status = $_POST["status"];

    $registrado = $devolucionesModel->registrarDevolucion($id_sales, $id_username, $reason, $status);


    if ($registrado) {
        header("Location: ../View/Ventas/VentasView.php?success=1");
    } else {
        header("Location: ../View/Ventas/VentasView.php?error=1");
    }
} else {
    $devoluciones = $devolucionesModel->obtenerDevoluciones();
}


//Facturas Y pagos 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

//Me gsutaría saber porque no pueden funcionar separados como registros normales 

    if (isset($_POST["registrar_factura"])) {
      
        $id_sales = $_POST["id_sales"];
        $total = $_POST["total"];

       
        $registrado = $facturaModel->registrarFactura($id_sales, $total);

        if ($registrado) {
            header("Location: ../View/Ventas/VentasView.php?success=Factura registrada");
        } else {
            header("Location: ../View/Ventas/VentasView.php?error=Error al registrar");
        }
    }



   
    if (isset($_POST["registrar_pago"])) {
        $id_sales = $_POST["id_sales"];
        $payment_method = $_POST["payment_method"];
        $amount = $_POST["amount"];
        $months = $_POST["months"];
        $pending_balance = $_POST["pending_balance"];

        $registrado = $pagosModel->registrarPago($id_sales, $payment_method, $amount, $months, $pending_balance);

        if ($registrado) {
           
            $pagos = $pagosModel->obtenerPagos();  
           
            include("../View/VentasView.php");  
        } else {
            header("Location: ../View/Ventas/VentasView.php?error=Error al registrar pago");
        }
    } else {
        

        $facturas = $facturaModel->obtenerFacturas();
    }

}

//Promociones

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_vehicle'], $_POST['description'], $_POST['discount'], $_POST['start_date'], $_POST['end_date'])) {
    $id_vehicle = $_POST["id_vehicle"];
    $description = $_POST["description"];
    $discount = $_POST["discount"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    $registrado = $promocionModel->registrarPromocion($vehicle_id, $description, $discount, $start_date, $end_date);

    if ($registrado) {
        header("Location: ../View/Ventas/VentasView.php?success=1");
    } else {
        header("Location: ../View/Ventas/VentasView.php?error=1");
    }
} else {
    $promociones = $promocionModel->obtenerPromociones();
}

//reservas

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id_customer'], $_POST['id_vehicle'], $_POST['monto_reserva'], $_POST['status'])) {
        $customer_id = intval($_POST["id_customer"]);
        $vehicle_id = intval($_POST["id_vehicle"]);
        $amount_reserva = floatval($_POST["monto_reserva"]);
        $status = $_POST["status"];
    
//Otro que no funciona de forma normal

        if (!in_array($status, ['Reservado', 'Disponible'])) {
            header("Location: ../View/Ventas/VentasView.php?error=status_invalido");
            exit();
        }

        $registrado = $reservaModel->registrarReserva($id_customer, $vehicle_id, $amount_reserva, $status);

        if ($registrado) {
            header("Location: ../View/Ventas/VentasView.php?success=1");
        } else {
            header("Location: ../View/Ventas/VentasView.php?error=1");
        }
    }
} else {
    
    $reservas = $reservaModel->obtenerReservas();
}

//Reportes

if (isset($_POST['generar_reporte'])) {
    $resultado = $reportesModel->generarReporteVentas();

    if ($resultado) {
        header("Location: ../View/Ventas/VentasView.php?success=true");
    } else {
        header("Location: ../View/Ventas/VentasView.php?error=true");
    }
}



//Funciones de Obtener/Mostar


//Cotizacion no tiene porque ? no sé 

//Ventas

function mostrarVentas()
{
    $conexion = Database::AbrirBaseDatos();
    $query = "CALL sp_show_sales()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }

    Database::CerrarBaseDatos($conexion);
    return $ventas;
}

function obtenerVentas()
{
    return mostrarVentas();
}


//Devoluciones

function mostrarDevoluciones()
{
    $conexion = Database::AbrirBaseDatos();
    $query = "CALL sp_show_refunds()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }

    Database::CerrarBaseDatos($conexion);
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
    $conexion = Database::AbrirBaseDatos();
    $query = "CALL sp_show_payments()";
    $result = $conexion->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conexion->error);
    }

    $pagos = [];
    while ($row = $result->fetch_assoc()) {
        $pagos[] = $row;
    }

    Database::CerrarBaseDatos($conexion);
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

function obtenerIdCliente($username)
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();
    $stmt = $conn->prepare("SELECT id_username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id_username);
    $stmt->fetch();
    $stmt->close();
    Database::CerrarBaseDatos($conn);
    return $id_username;
}


//Vehiculos disponibles Motos

function obtenerVehiculosDisponibles()
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    $sql = "SELECT id_vehicle, brand, model, price FROM vehicles WHERE status = 'Disponible'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $vehicles = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $vehicles;
}


// Lo mismo que los vehiculos oslo que con clientes

function obtenerClientesDisponibles()
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    $sql = "SELECT id_username, username FROM users WHERE role = 'Cliente'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $cliente = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $cliente;
}



//Lo mismo pero con ventas


function obtenerVentasId()
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    $sql = "SELECT id_sales, total FROM sales";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $ventas;
}


function obtenerPrecio($vehicle_id)
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    $stmt = $conn->prepare("SELECT price FROM vehicles WHERE id_vehicle = ?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    
    $stmt->close();
    Database::CerrarBaseDatos($conn);
    
    return $price;
}


if (isset($_POST['id_vehicle'])) {
    $id_vehicle = $_POST['id_vehicle'];

    function obtenerPrecio($id_vehicle)
    {
        $conn = Database::AbrirBaseDatos();

        $stmt = $conn->prepare("SELECT price FROM vehicles WHERE id_vehicle = ?");
        $stmt->bind_param("i", $id_vehicle);
        $stmt->execute();
        $stmt->bind_result($price);
        $stmt->fetch();
        $stmt->close();

        Database::CerrarBaseDatos($conn);

        echo json_encode(['price' => $price]);
    }

    obtenerPrecio($id_vehicle);
} 


// Función para obtener ventas con status Pendiente
function obtenerVentasPendientes()
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    $sql = "SELECT id_sales, total FROM sales WHERE status = 'Pendiente'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $ventas;
}


// Función para obtener ventas con status Pendiente y Completada
function obtenerVentasPendientesYCompletadas()
{
    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    
    $sql = "SELECT id_sales, total, status FROM sales WHERE status IN ('Pendiente', 'Completada')";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $ventas;
}


function obtenerfacturas(){

    require_once "../../Model/Database.php";
    $conn = Database::AbrirBaseDatos();

    
    $sql = "SELECT id_invoice, total FROM invoices";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $ventas = $result->fetch_all(MYSQLI_ASSOC);
    Database::CerrarBaseDatos($conn);
    return $ventas;
}