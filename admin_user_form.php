<?php
session_start();
include('connection.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch user information from the database
$query = "SELECT * FROM user_info WHERE verified = 0"; // Assuming there's a 'verified' column
$result = mysqli_query($conn, $query);

include('admin_dashboard.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
        <h2>User Submissions</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['image']); ?>" width="100" height="100"></td>
                        <td>
                            <a href="verify_user.php?id=<?php echo $row['id']; ?>&action=accept" class="btn btn-success">Accept</a>
                            <a href="verify_user.php?id=<?php echo $row['id']; ?>&action=reject" class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>