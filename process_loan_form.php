<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Get the loan application ID and action from the URL
$applicationId = $_GET['id'];
$action = $_GET['action'];

if ($action == 'accept') {
    // Update the loan application's status to 'accepted'
    $updateQuery = "UPDATE loan_applications SET status = 'accepted' WHERE id = '$applicationId'";
    mysqli_query($conn, $updateQuery);
} elseif ($action == 'reject') {
    // Update the loan application's status to 'rejected'
    $updateQuery = "UPDATE loan_applications SET status = 'rejected' WHERE id = '$applicationId'";
    mysqli_query($conn, $updateQuery);
}
header('Location: admin_loan_form.php');
exit;
?>