<?php
include_once 'Database.php';

class FiltroModel {
    public static function filterMotorcycles($brands, $engine_cc, $status) {
        $conn = AbrirBaseDatos();
        
        // Base de la consulta
        $sql = "SELECT * FROM motorcycles WHERE status = ?";
        $params = ["s", &$status];

        // Filtro por marca
        if (!empty($brands)) {
            $placeholders = implode(",", array_fill(0, count($brands), "?"));
            $sql .= " AND brand IN ($placeholders)";
            foreach ($brands as $brand) {
                $params[0] .= "s"; // Cada marca es string
                $params[] = &$brand;
            }
        }

        // Filtro por cilindrada
        if (!empty($engine_cc)) {
            $sql .= " AND engine_cc = ?";
            $params[0] .= "i"; // Engine CC es integer
            $params[] = &$engine_cc;
        }

        $stmt = $conn->prepare($sql);
        call_user_func_array([$stmt, 'bind_param'], $params);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $motorcycles = $result->fetch_all(MYSQLI_ASSOC);
        
        $stmt->close();
        $conn->close();
        return $motorcycles;
    }
}
?>
