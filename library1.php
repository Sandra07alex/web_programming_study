// library
<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = ''; // Use an empty password for XAMPP
$dbname = 'library';

// Connect to the database
$conn = new mysqli($host, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
$conn->select_db($dbname);

// Create the books table if not exists
$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accession_number VARCHAR(50),
    title VARCHAR(255),
    authors VARCHAR(255),
    edition VARCHAR(50),
    publisher VARCHAR(255)
)";
$conn->query($sql);

// Insert book information into the database
if (isset($_POST['add_book'])) {
    $accession_number = $_POST['accession_number'];
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    $stmt = $conn->prepare("INSERT INTO books (accession_number, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $accession_number, $title, $authors, $edition, $publisher);

    if ($stmt->execute()) {
        echo "Book information added successfully.<br>";
    } else {
        echo "Error adding book information: " . $stmt->error;
    }
    $stmt->close();
}

// Search for a book by title
if (isset($_GET['search'])) {
    $search_title = $_GET['search_title'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
    $like_search_title = "%" . $search_title . "%";
    $stmt->bind_param("s", $like_search_title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Search Results</h2>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr><th>Accession Number</th><th>Title</th><th>Authors</th><th>Edition</th><th>Publisher</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["accession_number"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["authors"] . "</td>";
            echo "<td>" . $row["edition"] . "</td>";
            echo "<td>" . $row["publisher"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No books found with the title '$search_title'.";
    }
    $stmt->close();
}

$conn->close();
?>