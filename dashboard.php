<?php
session_start();

include('connection.php');

if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true) {
    // User is not authenticated, redirect to the login page
    error_log('Redirecting to login. User_authenticated: ' . var_export($_SESSION['user_authenticated'], true));
    header('Location: http://localhost/loan_system_final_project/login.php');
    exit;
}
$role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Users List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- css -->
<style>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-image: url('images/bgg.jpg');
    background-size: cover;
    background-attachment: fixed;
    color: red; /* Set the text color to white */
    }
.error-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    background-color: white;
    padding: 5px 10px;
}
</style>

  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="images/logo.png">
</head>

<body>

<?php
if ($role == 'user') {
    include('includes/user.php');
} elseif ($role == 'admin') {
    include('includes/admin.php');
}
?>

</body>
</html>
