<?php
session_start();
include('connection.php');

// Check if the user is logged in and is not an admin
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] === 'admin') {
    // User is not authenticated or is an admin, redirect to the admin dashboard page
    header('Location: admin_dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        <a class="nav-item nav-link active" href="user-profile.php">Profile <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="user_info_form.php">User Form</a>
        <a class="nav-item nav-link" href="loan_form.php">Loan Form</a>
        </div>
       
        <div class="navbar-nav ml-auto">
        <a class="nav-item nav-link" href="logout.php">Logout</a>
        </div>
    </div>
    </nav>
</body>
</html>