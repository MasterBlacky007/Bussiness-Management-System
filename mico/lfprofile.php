<?php
// Include the database configuration file
require_once 'conf.php';

// Start session to manage login state
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['Email']) || !isset($_SESSION['Contact'])) {
    header('Location: lflogin.php'); // Redirect to login page if not logged in
    exit();
}

// Fetch user details from lfregister table using the session data (Email and Contact)
$email = $_SESSION['Email'];
$contact = $_SESSION['Contact'];

$sql = "SELECT * FROM lfregister WHERE Email = ? AND Contact = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $contact);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();  // Fetch the user data
} else {
    // If the user does not exist in the lfregister table
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="lcp.css">  <!-- Add your CSS file -->
</head>
<body>

    <header>
        <div class="container1">
            <div class="logo">
                <img src="images/i1.png" alt="Logo" class="logo-img">
            </div>
        </div>
    </header>

    <div class="main-content">
        <!-- Sidebar Section -->
        <aside class="sidebar">
            <div class="logo">Dashboard</div>
            <ul class="menu">
            <li><a href="lfproduct.html">View Product</a></li>
            <li><a href="lfaddorder.html">Add Order</a></li>
            <li><a href="vieworder2.php">View Order</a></li>
            <!--<li><a href="production-process.html">Make Payment</a></li>-->
            <li><a href="lffeedback.php">Feedback</a></li>
            <li><a href="lfprofile.php">My Profile</a></li>
            <li><a href="lflogin.php">LogOut</a></li>
            </ul>
        </aside>

        <!-- Main Profile Content Section -->
        <main>
            <div class="profile-container card">
                <h2>User Profile</h2>
                <table>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td><?php echo htmlspecialchars($user['Contact']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($user['Address']); ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?php echo htmlspecialchars($user['Country']); ?></td>
                    </tr>
                    <tr>
                        <th>IIC</th>
                        <td><?php echo htmlspecialchars($user['IIC']); ?></td>
                    </tr>
                </table>
            </div>
        </main>
    </div>

</body>
</html>
