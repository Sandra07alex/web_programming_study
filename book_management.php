<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
</head>
<body>
    <h1>Book Management System</h1>
    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set the character set
    $conn->set_charset("utf8mb4");

    // Automatic setup: Create the database and table if they don't exist
    $setup_queries = [
        "CREATE DATABASE IF NOT EXISTS LibraryDB",
        "USE LibraryDB",
        "CREATE TABLE IF NOT EXISTS Books (
            id INT AUTO_INCREMENT PRIMARY KEY,
            accession_number VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            authors VARCHAR(255),
            edition VARCHAR(50),
            publisher VARCHAR(255)
        )"
    ];

    foreach ($setup_queries as $query) {
        if (!$conn->query($query)) {
            die("Setup error: " . $conn->error);
        }
    }

    echo "<p>Database and table setup completed successfully!</p>";

    // Reconnect to the `LibraryDB` database
    $conn->select_db('LibraryDB');

    // Add book functionality
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
        $accession_number = $conn->real_escape_string($_POST['accession_number']);
        $title = $conn->real_escape_string($_POST['title']);
        $authors = $conn->real_escape_string($_POST['authors']);
        $edition = $conn->real_escape_string($_POST['edition']);
        $publisher = $conn->real_escape_string($_POST['publisher']);

        $stmt = $conn->prepare("INSERT INTO Books (accession_number, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $accession_number, $title, $authors, $edition, $publisher);

        if ($stmt->execute()) {
            echo "<p>New book added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }

    // Search functionality
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_book'])) {
        $search_title = $conn->real_escape_string($_POST['search_title']);

        $stmt = $conn->prepare("SELECT * FROM Books WHERE title LIKE ?");
        $like_title = "%" . $search_title . "%";
        $stmt->bind_param("s", $like_title);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>Search Results:</h2>";
                echo "<table border='1'>
                      <tr>
                          <th>Accession Number</th>
                          <th>Title</th>
                          <th>Authors</th>
                          <th>Edition</th>
                          <th>Publisher</th>
                      </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['accession_number']) . "</td>
                            <td>" . htmlspecialchars($row['title']) . "</td>
                            <td>" . htmlspecialchars($row['authors']) . "</td>
                            <td>" . htmlspecialchars($row['edition']) . "</td>
                            <td>" . htmlspecialchars($row['publisher']) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No books found with the title: " . htmlspecialchars($search_title) . "</p>";
            }
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    }

    $conn->close();
    ?>

    <h2>Add a New Book</h2>
    <form method="post">
        <input type="hidden" name="add_book" value="1">
        Accession Number: <input type="text" name="accession_number" required><br>
        Title: <input type="text" name="title" required><br>
        Authors: <input type="text" name="authors"><br>
        Edition: <input type="text" name="edition"><br>
        Publisher: <input type="text" name="publisher"><br>
        <input type="submit" value="Add Book">
    </form>

    <h2>Search for a Book</h2>
    <form method="post">
        <input type="hidden" name="search_book" value="1">
        Enter Title: <input type="text" name="search_title" required><br>
        <input type="submit" value="Search">
    </form>
</body>
</html>
