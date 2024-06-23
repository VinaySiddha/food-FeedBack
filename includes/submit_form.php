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

function validateRollNo($rollNo) {
    // Roll number format: 22A81A4359
    return preg_match('/^\d{2}[A-Z]\d{2}[A-Z]\d{4}$/', $rollNo);
}

function validatePhone($phone) {
    // Phone number format: 10 digit phone number
    return preg_match('/^[0-9]{10}$/', $phone);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rollNo = $_POST['rollNo'];
    $phone = $_POST['phone'];
    $breakfast = $_POST['breakfast'];
    $breakfastComments = $_POST['breakfastComments'];
    $lunch = $_POST['lunch'];
    $lunchComments = $_POST['lunchComments'];
    $snacks = $_POST['snacks'];
    $snacksComments = $_POST['snacksComments'];
    $dinner = $_POST['dinner'];
    $dinnerComments = $_POST['dinnerComments'];
    $foodQuality = $_POST['foodQuality'];
    $serviceQuality = $_POST['serviceQuality'];
    $cleanliness = $_POST['cleanliness'];
    $suggestions = $_POST['suggestions'];

    // Validate roll number and phone number
    if (validateRollNo($rollNo) && validatePhone($phone)) {
        // Insert data into database
        $sql = "INSERT INTO feedback (rollNo, phone, breakfast, breakfastComments, lunch, lunchComments, snacks, snacksComments, dinner, dinnerComments, foodQuality, serviceQuality, cleanliness, suggestions)
        VALUES ('$rollNo', '$phone', '$breakfast', '$breakfastComments', '$lunch', '$lunchComments', '$snacks', '$snacksComments', '$dinner', '$dinnerComments', '$foodQuality', '$serviceQuality', '$cleanliness', '$suggestions')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Your feedback has been recorded successfully.";
            $_SESSION['submitted'] = true; // Indicate that the form has been submitted
        } else {
            $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
            $_SESSION['submitted'] = true; // Still indicate that an attempt was made
        }
    } else {
        $_SESSION['message'] = "Invalid Roll Number or Phone Number.";
        $_SESSION['submitted'] = true; // Indicate that an attempt was made
    }

    $conn->close();

    // Redirect to the same page to avoid resubmission
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Confirmation</title>
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
        .btn-home, .btn-login {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-home:hover, .btn-login:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['submitted']) && $_SESSION['submitted'] === true) {
            echo "<h1>" . $_SESSION['message'] . "</h1>";
            echo '<a href="index.php" class="btn-home">Return to Homepage</a>';
            echo '<a href="login.php" class="btn-login">Login</a>';
        }
        ?>
    </div>
</body>
</html>
