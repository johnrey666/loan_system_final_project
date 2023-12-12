<?php
session_start();

if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true) {
    // User is already authenticated, redirect to the dashboard page
    header('Location: dashboard.php');
    exit;
}

include('connection.php');
$passwordError = '';
$usernameError = '';

if (isset($_POST['submit'])) {
date_default_timezone_set('Asia/Manila');

$u_name = $_POST['u_name'];
$u_pass = $_POST['u_pass'];
$role = $_POST['role'];

// Check if the username already exists
$checkUserQuery = "SELECT * FROM users WHERE u_name = '$u_name'";
$checkUserResult = mysqli_query($conn, $checkUserQuery);
    
if (mysqli_num_rows($checkUserResult) > 0) {
$usernameError = 'Username already exists. Please choose a different one.';
    
} else {
// Implement strong password policies
$passwordPolicy = [
    'minLength' => 8,           // Minimum password length
    'requireUppercase' => true,  // Require at least one uppercase letter
    'requireLowercase' => true,  // Require at least one lowercase letter
    'requireDigit' => true,     // Require at least one digit
    'requireSpecialChar' => true,  // Require at least one special character
];

if (!isPasswordStrong($u_pass, $passwordPolicy)) {
// Set the password error message
$passwordError = 'Enforce strong password policies, requiring a minimum of 8 characters with a combination of uppercase letters, lowercase letters, digits, and special characters.';
        
} else {
// Hash the password
$hashedPassword = password_hash($u_pass, PASSWORD_DEFAULT);

// Insert the user into the database
$sql = "INSERT INTO users (u_name, u_pass, role, added_date) VALUES ('$u_name', '$hashedPassword', '$role', '" . date('Y-m-d h:i:s') . "')";
$result = mysqli_query($conn, $sql);

if ($result) {
// Password change policy: Store the date of the last password change in the database
$passwordChangeDate = date('Y-m-d h:i:s');
$updatePasswordChangeDate = "UPDATE users SET password_change_date = '$passwordChangeDate' WHERE u_name = '$u_name'";
mysqli_query($conn, $updatePasswordChangeDate);

// Redirect to login.php upon successful registration
echo "<script> alert('Registered Successfully!'); </script>";
header('Location: login.php');
exit;
            
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}
}

// Function to check if a password meets the specified complexity rules
function isPasswordStrong($password, $policy)
{
$errors = [];

if ($policy['minLength'] > 0 && strlen($password) < $policy['minLength']) {
$errors[] = 'Password must be at least ' . $policy['minLength'] . ' characters long.';
}

if ($policy['requireUppercase'] && !preg_match('/[A-Z]/', $password)) {
$errors[] = 'Password must contain at least one uppercase letter.';
}

if ($policy['requireLowercase'] && !preg_match('/[a-z]/', $password)) {
$errors[] = 'Password must contain at least one lowercase letter.';
}

if ($policy['requireDigit'] && !preg_match('/[0-9]/', $password)) {
$errors[] = 'Password must contain at least one digit.';
}

if ($policy['requireSpecialChar'] && !preg_match('/[^A-Za-z0-9]/', $password)) {
$errors[] = 'Password must contain at least one special character.';
}

return empty($errors);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Loan | Registration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <!-- password toggle -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="background-image">
<header class="header">
<!-- nav -->
<div class="topnav">
    <a class="active" href="home.php">Home</a>
    <a href="registration.php" style="float: right;">Sign-up</a>
    <a href="login.php" style="float: right;">Sign-in</a>
</div>
<!-- end of nav -->

<!-- form section -->
<br><br><br><center>
<div class="container mt-3">
<h2 style="color: black;">Register</h2>
<div style="border: 1px solid #ccc; padding: 20px; border-radius: 10px; width:440px; background-color: white;">
<form method="post">
<div class="mb-3" style="width: 400px;">
    <label for="email">Username:</label>
    <input type="text" class="form-control" id="email" placeholder="Example: Renzo Zuniga" name="u_name" required>
    <!-- Display the username error message in red text -->
    <div style="color: red;"><?php echo $usernameError; ?></div>
</div>

<div class="mb-3" style="width: 400px;">
    <label for="pwd">Password:</label>
    <div class="input-group">
    <input type="password" class="form-control" id="pwd" placeholder="Example: @Abcd123" name="u_pass" required>
    <span class="input-group-text" id="password-toggle" onclick="togglePasswordVisibility()">
    <i class="fas fa-eye"></i> <!-- Show icon -->
    </span>
    </div>
    <!-- Display the password error message in red text -->
    <div style="color: red;"><?php echo $passwordError; ?></div>
</div>

<div class="mb-3" style="width: 400px;">
    <label for="pwd">Role:</label>
    <select class="form-control" name="role" required>
        <option>Select Role</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
</div>

<button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div></center>
<!-- end of form section -->
</header>
</body>
</html>

<!-- js -->
<script src="js/script.js"></script>
