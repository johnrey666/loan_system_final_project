<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// Check if the user has already submitted a form
$checkFormQuery = "SELECT * FROM user_info WHERE user_id = '$userId' AND verified = 0";
$checkFormResult = mysqli_query($conn, $checkFormQuery);

if (mysqli_num_rows($checkFormResult) > 0) {
    echo "<script>alert('You have already submitted a form. Please wait for it to be approved.'); window.location.href='dashboard.php';</script>";
    exit;
}

include('header.php');

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../images/icon.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-section {
    background-color: #f8f9fa;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
}
    </style>
</head>
<body>


    <div class="container mt-5">
        <h2>User Information</h2>
        <form action="submit_user_info.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>

            <div class="mb-3">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">Contact Number:</label>
                <input type="tel" class="form-control" id="contact" name="contact" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>