<?php
session_start();

if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true) {
    // User is already authenticated, redirect to the dashboard page
    header('Location: dashboard.php');
    exit;
}

include('connection.php');



$usernameError = '';
$passwordError = '';


$maxLoginAttempts = 2;  
$lockoutDuration = 10; 

if (isset($_POST['submit'])) {
    $u_name = $_POST['u_name'];
    $u_pass = $_POST['u_pass'];

    if (isset($_SESSION['lockout_time']) && $_SESSION['lockout_time'] > time()) {
        $remainingTime = $_SESSION['lockout_time'] - time();
        $usernameError = 'Account is locked for ' . $remainingTime . ' seconds. Please try again later.';
    } else {
        // Check if the account exists in the database
            $sql = "SELECT * FROM users WHERE u_name='$u_name'";
            $result = mysqli_query($conn, $sql);
    
    

        if ($result) {
            $data = mysqli_fetch_array($result);

            if ($data) {
               
                if (password_verify($u_pass, $data['u_pass'])) {
                    
                    $passwordChangeDate = strtotime($data['password_change_date']);
                    $currentDate = strtotime(date('Y-m-d h:i:s'));
                    $daysSinceLastChange = ($currentDate - $passwordChangeDate) / (60 * 60 * 24);
                
                    if ($daysSinceLastChange > 90) {
                        $_SESSION['change_password'] = true;
                        header('location: change_password.php');
                    } else {
                        unset($_SESSION['login_attempts']);
                        $_SESSION['user_role'] = $data['role'];
                        $_SESSION['username'] = $data['u_name'];
                        $_SESSION['user_id'] = $data['id'];  
                        $_SESSION['user_authenticated'] = true;  
                
                       
                        if ($data['role'] == 'admin') {
                            header('location: admin_dashboard.php');
                        } else {
                            header('location: dashboard.php');
                        }
                    }
                } else {
                    $passwordError = 'Incorrect password';
                    if (isset($_SESSION['login_attempts'])) {
                        $_SESSION['login_attempts']++;
                        if ($_SESSION['login_attempts'] >= $maxLoginAttempts) {
                            $_SESSION['lockout_time'] = time() + $lockoutDuration;
                        }
                    } else {
                        $_SESSION['login_attempts'] = 1;
                    }
                }
            } else {
                $usernameError = 'Username not registered';
            }
        } else {
            
            echo 'Database query error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Loan | Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="images/icon.png">
  <!-- eye icon -->
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
<br><br><br>
<center>
<div class="container mt-3">
<h2 style="color: black;">Login</h2>
<div style="border: 1px solid #ccc; padding: 20px; border-radius: 10px; width:440px; background-color: white;">
<form method="post">

<div class="mb-3" style="width: 400px;">
    <label for="email">Username:</label>
    <input type="text" class="form-control" id="email" placeholder="Enter username" name="u_name" required oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">    <!-- Display username error message -->
    <div style="color: red;"><?php echo $usernameError; ?></div>
</div>

<div class="mb-3" style="width: 400px;">
   <label for="pwd">Password:</label>
   <div class="input-group">
   <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="u_pass">
   <span class="input-group-text" id="password-toggle" onclick="togglePasswordVisibility()">
   <i class="fas fa-eye"></i>
   </span>
   </div>
   
   <div style="color: red;"><?php echo $passwordError; ?></div>
</div>

<button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</center>

</header>
</body>
</html>


<script src="js/script.js"></script>


<script>

function hideErrorMessage() {
    var errorMessage = document.getElementById("error-message");
    if (errorMessage) {
        errorMessage.style.display = "block"; // Display the error message
        setTimeout(function() {
            errorMessage.style.display = "none"; 
            if (<?php echo isset($_SESSION['lockout_time']) && $_SESSION['lockout_time'] > time() ? 'true' : 'false'; ?>) {
                startCountdown();
            }
        }, 10000); 
    }
}

function startCountdown() {
    setTimeout(hideErrorMessage, 0); 
}

window.onload = hideErrorMessage;
</script>


