<?php
session_start();
include('connection.php');

include('header.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM user_info WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$query = "SELECT * FROM loan_applications WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $query);
$loanApplications = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/user-profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm profile-row">
            <div class="col-md-4 mb-4" style="height: 40px!important;">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                  <img src="<?php echo $user ? htmlspecialchars($user['image']) : 'images/profile.png'; ?>" alt="User" class="rounded-circle" width="100"  style="border-radius: 50%;">
                    <div class="mt-3">
                    <h4><?php echo $user ? htmlspecialchars($user['first_name']) : 'Username'; ?></h4>

                    <p class="text-secondary mb-1">Status <br> <?php echo $user && $user['verified'] == 1 ? '<i class="fas fa-check" style="color: green;"></i> Verified' : '<i class="fas fa-times" style="color: red;"></i> Not Verified'; ?></p>
                      
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $user ? htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) : 'Not available'; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $user ? htmlspecialchars($user['email']) : 'Not available'; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $user ? htmlspecialchars($user['contact_number']) : 'Not available'; ?>
                    </div>
                  </div>
                  
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $user ? htmlspecialchars($user['address']) : 'Not available'; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " target="__blank" href="#">Edit</a>
                    </div>
                  </div>
                </div>
              </div>


        </div>
    </div>
    <div class="row">
            <div class="col-md-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <h4>Loan Requests</h4>
                                            <table class="table">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Purpose</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loanApplications as $loanApplication): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($loanApplication['amount']); ?></td>
                                    <td><?php echo htmlspecialchars($loanApplication['purpose']); ?></td>
                                    <td><?php echo htmlspecialchars($loanApplication['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
</body>
</html>