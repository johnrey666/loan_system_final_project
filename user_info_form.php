<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    die('User ID not found in session');
}

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
    <header class="header-section">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
   
            <a href="user_info_form.php" class="btn btn-primary">Update Information</a>
            <a href="lend_request.php" class="btn btn-primary">Lend Request</a>
            <a href="logout.php" style="float: right;">Sign-out</a> 
        
    </header>

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