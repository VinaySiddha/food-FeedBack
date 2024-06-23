<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";
$username = "id22356034_vinay";
$password = "$!0foFUd>a*&lfEE";
$dbname = "id22356034_food";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Basic user authentication (for demonstration purposes)
    if ($user === "admin" && $pass === "password") {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .input-field {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .btn-submit {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
        .forgot-password {
            margin-top: 20px;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .forgot-password a:hover {
            color: #0056b3;
        }
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .loader img {
            width: 150px; /* Adjust the size as needed */
            animation: spin 2s linear infinite;
        }
        .loader p {
            font-family: 'Quicksand', sans-serif;
            font-size: 20px;
            margin-top: 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
     <div class="loader" id="loader">
        <img src="load.png" alt="Loading..."> <!-- Replace 'your-image.png' with the path to your image -->
        <p>Loading, please wait...</p>
    </div>
    <div class="container">
        <h1>Login</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Username" class="input-field" required>
            <input type="password" name="password" placeholder="Password" class="input-field" required>
            <button type="submit" class="btn-submit">Login</button>
        </form>
        <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
        <div class="forgot-password">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
<script>
     window.onload = function() {
            setTimeout(function() {
                document.getElementById('loader').style.display = 'none';
                document.getElementById('content').style.display = 'block';
            }, 3000); // Adjust the timeout duration as needed (5000ms = 5 seconds)
        };
</script>