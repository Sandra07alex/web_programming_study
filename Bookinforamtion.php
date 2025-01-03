<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f0f5f1;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #3c6e71;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form input[type="text"], form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        form input[type="text"] {
            background-color: #f9f9f9;
        }

        form input[type="text"]:focus {
            border-color: #3c6e71;
            background-color: #ffffff;
        }

        form button {
            background-color: #3c6e71;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #2c4f58;
        }

        /* Error Styles */
        p.error {
            color: #e74c3c;
            font-size: 14px;
            margin: 10px 0;
        }

        p.success {
            color: #2ecc71;
            font-size: 14px;
            margin: 10px 0;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Book Information</h2>
        <form action="" method="post">
            <input type="text" name="accession_number" placeholder="Accession Number" required><br>
            <input type="text" name="title" placeholder="Title" required><br>
            <input type="text" name="authors" placeholder="Authors" required><br>
            <input type="text" name="edition" placeholder="Edition" required><br>
            <input type="text" name="publisher" placeholder="Publisher" required><br>
            <button type="submit" name="add_book">Add Book</button>
        </form>
    </div>
</body>
</html>

<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = ''; // Default password for XAMPP
$dbname = 'db';
$tablenm = 'tb';

// Connect to the database
$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
mysqli_query($conn, $sql);
mysqli_select_db($conn, $dbname);

// Create books table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS $tablenm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accession_number VARCHAR(50),
    title VARCHAR(255),
    authors VARCHAR(255),
    edition VARCHAR(50),
    publisher VARCHAR(255)
)";
mysqli_query($conn, $sql);

// Initialize error messages array
$errors = [];

// Insert book information into the database
if (isset($_POST['add_book'])) {
    $accession_number = trim($_POST['accession_number']);
    $title = trim($_POST['title']);
    $authors = trim($_POST['authors']);
    $edition = trim($_POST['edition']);
    $publisher = trim($_POST['publisher']);

    if (empty($accession_number) || !ctype_digit($accession_number)) {
        $errors[] = "Accession number is required and should be numeric.";
    }
    if (empty($title) || !preg_match('/^[a-zA-Z0-9 ]+$/', $title)) {
        $errors[] = "Title is required and should be alphanumeric.";
    }
    if (empty($authors) || !preg_match('/^[a-zA-Z ]+$/', $authors)) {
        $errors[] = "Authors should contain only letters.";
    }
    if (empty($edition) || !ctype_digit($edition)) {
        $errors[] = "Edition should contain only numbers.";
    }
    if (empty($publisher)) {
        $errors[] = "Publisher is required.";
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO $tablenm (accession_number, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $accession_number, $title, $authors, $edition, $publisher);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p class='success'>Book information added successfully.</p>";
        } else {
            echo "<p class='error'>Error adding book information: " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}

mysqli_close($conn);
?>