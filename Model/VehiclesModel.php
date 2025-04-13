<?php
require_once 'Database.php';

class VehiclesModel {
    public static function getAvailableVehicles() {
        $conn = Database::AbrirBaseDatos();
        
        $stmt = $conn->prepare("SELECT id, brand, model, price, status FROM vehicles WHERE status = ?");
        $status = 'disponible';
        $stmt->bind_param("s", $status);
        $stmt->execute();
        
        //vincular resultados manualmente
        $stmt->bind_result($id, $brand, $model, $price, $status);
        $vehicles = [];
        
        while ($stmt->fetch()) {
            $vehicles[] = [
                'id' => $id,
                'brand' => $brand,
                'model' => $model,
                'price' => $price,
                'status' => $status
            ];
        }
        //print_r($vehicles);
        Database::CerrarBaseDatos($conn);
        return $vehicles;
    }
}
?>