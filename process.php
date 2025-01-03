<?php<?php
// Database connection settings
$servername = "127.0.0.1"; // Use IP address instead of "localhost" for TCP/IP
$username = "root";
$password = ""; // Leave empty if no password is set
$dbname = "employee_db";
 // Specify the correct port number

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$table = "CREATE TABLE IF NOT EXISTS salary_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    basic_pay DECIMAL(10, 2) NOT NULL,
    da DECIMAL(10, 2) NOT NULL,
    hra DECIMAL(10, 2) NOT NULL
)";
if ($conn->query($table) === TRUE) {
    echo "Table created or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $basic_pay = $_POST['basic_pay'];
    $da = $_POST['da'];
    $hra = $_POST['hra'];

    // Insert data into database
    $sql = "INSERT INTO salary_details (name, basic_pay, da, hra) 
            VALUES ('$name', '$basic_pay', '$da', '$hra')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Display inserted data
    echo "<h3>Employee Details:</h3>";
    echo "Name: $name<br>";
    echo "Basic Pay: $basic_pay<br>";
    echo "DA: $da<br>";
    echo "HRA: $hra<br>";
}

$conn->close();
?>
"


























?>