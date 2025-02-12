<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../Model/PaymentModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $resultado = procesarPago(
            $data['user'],
            $data['payment_method']
        );
        
        echo json_encode(['success' => $resultado]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
?>