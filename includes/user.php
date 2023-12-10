<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan | User</title>
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="../images/icon.png">

<style>
.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 5px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {background-color: #008CBA;} 

h2{
    color: black;
}

.header-section {
    background-color: #f8f9fa;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
}
</style>
</head>

<body>

<!-- nav -->

  
<header class="header-section">
    <?php if ($role === 'user'): ?>
        <a href="user_info_form.php" class="btn btn-primary">Update Information</a>
        <a href="lend_request.php" class="btn btn-primary">Lend Request</a>
    <?php endif; ?>

  <a href="logout.php" style="float: right;">Sign-out</a> 
  <a href="change_password.php" style="float: right;">Change Password</a>
  </header>
<!-- end of nav -->

</body>
</html>