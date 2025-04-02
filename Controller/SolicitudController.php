<?php
include_once '../Models/SolicitudModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $vehicle_interest = $_POST['vehicle_interest'];
    $requested_amount = $_POST['requested_amount'];
    $payment_method = $_POST['payment_method'];
    $comments = $_POST['comments'];

    
    FinancingRequestModel::saveRequest($full_name, $email, $phone, $vehicle_interest, $requested_amount, $payment_method, $comments);

    
    header("Location: ../Views/SolicitudCView.php");
}
?>
