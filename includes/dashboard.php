<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

// Function to fetch all rows from a table
function fetchTableData($conn, $tableName) {
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);
    $rows = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    return $rows;
}

// Fetch all tables from the database
$sql = "SHOW TABLES";
$result = $conn->query($sql);
$tables = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

$conn->close(); // Close connection after fetching tables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" type="text/css" href="styles.css">-->

    <title>Dashboard</title>
    <style>
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
            width: 80%;
            overflow-x: auto; /* Enable horizontal scrolling */
        }
        table {
            width: 100%; /* Table occupies full width of container */
            border-collapse: collapse;
            margin-top: 20px;
            white-space: nowrap; /* Prevent line breaks within table cells */
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn-logout {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-logout:hover {
            background-color: #c82333;
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
        <h1>Dashboard</h1>
        <h2>All Tables</h2>
        <?php if (!empty($tables)) { ?>
            <?php foreach ($tables as $table) { ?>
                <h3><?php echo $table; ?></h3>
                <?php
                // Reconnect to the database for each table query
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $rows = fetchTableData($conn, $table);
                ?>
                <table>
                    <tr>
                        <?php foreach (array_keys($rows[0]) as $column) { ?>
                            <th><?php echo $column; ?></th>
                        <?php } ?>
                    </tr>
                    <?php foreach ($rows as $row) { ?>
                        <tr>
                            <?php foreach ($row as $value) { ?>
                                <td><?php echo $value; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
                <?php
                $conn->close(); // Close connection after each table query
                ?>
            <?php } ?>
        <?php } else { ?>
            <p>No tables found in the database.</p>
        <?php } ?>
        <a href="logout.php" class="btn-logout">Logout</a>
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
