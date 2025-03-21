<?php
// Include the database configuration file
require_once 'conf.php';

// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to check user
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        $message = "<span style='color: green;'>Login successful! </span><a href='Home.html' style='color: #0072ff; text-decoration: none;'>&#8594; Go to Dashboard</a>";
    } else {
        // Failed login
        $message = "<span style='color: red;'>Invalid email or password!</span>";
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Header */
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
        }

        header .container1 {
            width: 90%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo img {
            width: 150px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        header .buttons {
            display: flex;
            gap: 10px;
        }

        header .buttons .btn {
            color: white;
            padding: 5px 15px;
            background-color: #0072ff;
            text-decoration: none;
            border-radius: 4px;
        }

        header .buttons .btn:hover {
            background-color: #005bb5;
        }

        /* Login Container */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #0072ff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005bb5;
        }

        /* Message Styles */
        .message {
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }

        .message span {
            display: block;
        }

        .message a {
            color: #0072ff;
            text-decoration: none;
        }

        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container1">
            <div class="logo">
                <img src="images/i1.png" alt="Logo" class="logo-img">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="Products.html">Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
                <div class="buttons">
                    <a href="RegDashboard.html" class="btn">Register</a>
                    <a href="StDashboard.html" class="btn">Staff</a>
                    <a href="ClDashboard.html" class="btn">Client</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main content section -->
    <main>
        <div class="login-container">
            <h2>Login</h2>
            <form action="i1.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Login</button>
                <!-- Display message -->
                <div class="message"><?php echo $message; ?></div>
            </form>
        </div>
    </main>
</body>
</html>
