<?php
require_once __DIR__ . '/../Model/TestDriveModel.php';
require_once __DIR__ . '/../Model/LoginModel.php';
require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/VehiclesModel.php';

class TestDriveController
{
    public static function showForm()
    {
        session_start();

        if (!isset($_SESSION['user']['username'])) {
            header('Location: ../View/LoginView.php');
            exit();
        }

        $vehicles = VehiclesModel::getAvailableVehicles();
        require_once '../View/Soporte/TestDriveView.php';
    }

    public static function handleRequest()
    {
        session_start();

        if (!isset($_SESSION['user']['username'])) {
            header('Location: ../View/LoginView.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 🔥 Asegúrate de que este índice sea correcto:
            $user_id = $_SESSION['user']['id_username']; // Cambia esto si el índice es diferente
            $vehicle_id = htmlspecialchars($_POST['vehicle_id']);
            $datetime = htmlspecialchars($_POST['datetime']);

            $scheduled_datetime = strtotime($datetime);
            $day_of_week = date('w', $scheduled_datetime); // 0 = domingo
            $hour = date('H', $scheduled_datetime); // 24h format

            // Validación de horario
            if ($day_of_week == 0 || $hour < 10 || $hour > 18) {
                $_SESSION['error'] = 'Las citas solo pueden ser agendadas de lunes a sábado, entre las 10:00 AM y las 6:00 PM.';
                header('Location: ../View/Soporte/TestDriveView.php');
                exit();
            }

            try {
                TestDriveModel::scheduleTestDrive($user_id, $vehicle_id, $datetime);
                $_SESSION['success'] = "Prueba agendada para: " . date('d/m/Y H:i', strtotime($datetime));
                header('Location: ../View/Soporte/TestDriveConfirmationView.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ../View/Soporte/TestDriveView.php');
                exit();
            }
        }
    }
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'schedule':
            TestDriveController::showForm();
            break;
        case 'submit':
            TestDriveController::handleRequest();
            break;
        default:
            header('Location: ../View/Soporte/TestDriveView.php');
            exit();
    }
}
