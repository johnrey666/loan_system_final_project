<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;


}

// Get the user ID and action from the URL
$userId = $_GET['id'];
$action = $_GET['action'];

if ($action == 'accept') {
    // Update the user's verified status to 1 in users table
    $updateQuery = "UPDATE users SET verified = 1 WHERE id = (SELECT user_id FROM user_info WHERE id = '$userId')"; 
    mysqli_query($conn, $updateQuery);

    // Update the user's verified status to 1 in user_info table
    $updateQuery1 = "UPDATE user_info SET verified = 1 WHERE id = '$userId'"; 
    mysqli_query($conn, $updateQuery1);
}
elseif ($action == 'reject') {
    // Delete the user's information from the database
    $deleteQuery = "DELETE FROM user_info WHERE id = '$userId'";
    mysqli_query($conn, $deleteQuery);
}

header('Location: admin_dashboard.php');
exit;
?>