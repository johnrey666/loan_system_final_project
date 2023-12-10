<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $purpose = $_POST['purpose'];
    $message = $_POST['message'];

    $sql = "INSERT INTO loan_applications (user_id, first_name, last_name, email, amount, purpose, message, status) VALUES ('$userId', '$firstName', '$lastName', '$email', '$amount', '$purpose', '$message', 'pending')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Loan application submitted successfully.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>