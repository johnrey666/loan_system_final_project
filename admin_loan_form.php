<?php
session_start();
include('connection.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch user information from the database
$query = "SELECT * FROM user_info WHERE verified = 0"; 
$result = mysqli_query($conn, $query);

$queryPending = "SELECT * FROM loan_applications WHERE status = 'pending'"; 
$resultPending = mysqli_query($conn, $queryPending);

$queryHistory = "SELECT * FROM loan_applications WHERE status IN ('accepted', 'rejected')"; 
$resultHistory = mysqli_query($conn, $queryHistory);

include('admin_dashboard.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php


// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch loan applications from the database
$query = "SELECT * FROM loan_applications"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <!-- Your navigation code here -->
    
    <div class="container mt-5">
        <h2>Loan Applications</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultPending)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td>
                            <a href="process_loan_form.php?id=<?php echo $row['id']; ?>&action=accept" class="btn btn-success">Accept</a>
                            <a href="process_loan_form.php?id=<?php echo $row['id']; ?>&action=reject" class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <br><br><br><br><br>
    <div class="container mt-5">
        <h2>Loan Application History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultHistory)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
        </table>
    </div>
</body>
</html>
    
</body>
</html>