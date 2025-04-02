<?php
include_once 'Database.php';

class FinancingRequestModel {

    public static function saveRequest($full_name, $email, $phone, $vehicle_interest, $requested_amount, $payment_method, $comments) {
   
        $conn = AbrirBaseDatos();

      
        $sql = "INSERT INTO financing_requests (full_name, email, phone, vehicle_interest, requested_amount, payment_method, comments)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

  
        if ($stmt = $conn->prepare($sql)) {
           
            $stmt->bind_param("sssssss", $full_name, $email, $phone, $vehicle_interest, $requested_amount, $payment_method, $comments);

           
            if ($stmt->execute()) {
                
                $stmt->close();
                CerrarBaseDatos($conn); 
                return true;
            } else {
                
                $stmt->close();
                CerrarBaseDatos($conn); 
                return false;
            }
        } else {
            
            CerrarBaseDatos($conn); 
            return false;
        }
    }
}
?>
