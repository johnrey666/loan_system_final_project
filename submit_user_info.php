<?php include  ('connection.php');
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    die('User ID not found in session');
}
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userId = $_SESSION['user_id'];
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    // Handle the file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert the form data into the database
    $sql = "INSERT INTO user_info (user_id, first_name, last_name, contact_number, address, email, image) VALUES ('$userId', '$firstName', '$lastName', '$contact', '$address', '$email', '$targetFile')";

    if (mysqli_query($conn, $sql)) {
        echo "User information submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>