<?php
require_once 'Database.php';

class TestDriveModel {
    public static function scheduleTestDrive($user_id, $vehicle_id, $datetime) {
        $conn = Database::AbrirBaseDatos();
        
        try {
            $stmt = $conn->prepare("CALL sp_registrar_prueba_manejo(?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $vehicle_id, $datetime);
            $result = $stmt->execute();
            
            Database::CerrarBaseDatos($conn);
            return $result;
        } catch (Exception $e) {
            Database::CerrarBaseDatos($conn);
            throw new Exception("Error al agendar prueba: " . $e->getMessage());
        }
    }

    public static function getScheduledTestDrives($user_id) {
        $conn = Database::AbrirBaseDatos();
        
        $stmt = $conn->prepare("SELECT * FROM test_drive_requests 
                              WHERE user_id = ? 
                              ORDER BY scheduled_datetime DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        Database::CerrarBaseDatos($conn);
        return $result;
    }
}
?>