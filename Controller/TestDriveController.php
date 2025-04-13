<?php
require_once '../Model/TestDriveModel.php';
require_once '../Model/LoginModel.php';
require_once '../Model/Database.php';
require_once '../Model/VehiclesModel.php'; //new model necesario para obtener los vehiculos disponibles

class TestDriveController {

    public static function showForm() {
        $vehicles = VehiclesModel::getAvailableVehicles();
        require_once '../View/TestDriveView.php';
    }

    public static function handleRequest() {
        session_start();
        
        if (!isset($_SESSION['user'])) {
            header('Location: ../View/LoginView.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = LoginModel::getUserId($_SESSION['user']);
            $vehicle_id = htmlspecialchars($_POST['vehicle_id']);
            $datetime = htmlspecialchars($_POST['datetime']);
            
            try {
                TestDriveModel::scheduleTestDrive($user_id, $vehicle_id, $datetime);
                $_SESSION['success'] = "Prueba agendada para: " . date('d/m/Y H:i', strtotime($datetime));
                header('Location: ../View/TestDriveConfirmationView.php');
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ../View/TestDriveView.php');
            }
        }
    }
}

if (isset($_GET['action'])) {
    session_start();
    $action = $_GET['action'];
    switch ($action) {
        case 'schedule':
            break;
        case 'submit':
            TestDriveController::handleRequest();
            break;
        default:
            header('Location: ../View/TestDriveView.php');
    }
}
?>