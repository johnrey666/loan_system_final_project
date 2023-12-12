<?php
session_start();
include('connection.php');

$query = "SELECT * FROM user_info WHERE user_id = " . $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM user_info WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $query);
$userInfo = mysqli_fetch_assoc($result);

$query = "SELECT verified FROM users WHERE id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['verified'] != 1) {
  echo "<script>
  alert('You are not verified. Please wait for the user info to be verified.');
  window.location.href='dashboard.php';
</script>";
    exit;
}


$query = "SELECT * FROM loan_applications WHERE user_id = " . $_SESSION['user_id'] . " AND status = 'pending'";
$result = mysqli_query($conn, $query);
$pendingLoanApplication = mysqli_fetch_assoc($result);

if ($pendingLoanApplication) {
    echo "<script>
    alert('You cannot send multiple loan requests. Please wait for your current request to be processed.');
    window.location.href='dashboard.php';
    </script>";
    exit;
}
include('header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Loan Application Form</title>
</head>
<body>

<div class="container mt-5">
  <h2 class="mb-4">Loan Application Form</h2>
  <form action="submit_loan_application.php" method="post">
  <div class="form-row">
  <div class="form-group col-md-6">
  <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" value="<?php echo $userInfo ? htmlspecialchars($userInfo['first_name']) : 'Not available'; ?>" required readonly>
  </div>
  <div class="form-group col-md-6">
  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" value="<?php echo $userInfo ? htmlspecialchars($userInfo['last_name']) : 'Not available'; ?>" required readonly>

  </div>
</div>
<div class="form-group">
<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $userInfo ? htmlspecialchars($userInfo['email']) : 'Not available'; ?>" required readonly>

</div>
<div class="form-group">
  <label for="amount">Loan Amount</label>
  <input type="range" class="form-control-range" id="amount" name="amount" min="5000" max="20000" step="1000" value="10000">
  <span id="amountValue">Loan Amount: 10,000 PHP</span>
</div>
<div class="form-group">
  <label for="purpose">Loan Purpose</label>
  <select class="form-control" id="purpose" name="purpose" required>
    <option value="" selected disabled>Select a purpose</option>
    <option value="home">Home Loan</option>
    <option value="auto">Auto Loan</option>
    <option value="personal">Personal Loan</option>
  </select>
</div>
<div class="form-group">
  <label for="message">Additional Information</label>
  <textarea class="form-control" id="message" name="message" rows="3" placeholder="Any additional information or comments"></textarea>
</div>

  <img src="captcha.php" alt="CAPTCHA">
  <input type="text" name="captcha" required>

    <button type="submit" class="btn btn-primary">Submit Application</button>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Display the loan amount dynamically
  $(document).ready(function(){
    $('#amount').on('input', function(){
      $('#amountValue').text('Loan Amount: ' + $('#amount').val() + ' PHP');
    });
  });
</script>

</body>
</html>
