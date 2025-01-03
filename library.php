//Libarary search.
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
</head>
<body>
    <h2>Add Book Information</h2>
    <form action="library1.php" method="post">
        <input type="text" name="accession_number" placeholder="Accession Number" required><br>
        <input type="text" name="title" placeholder="Title" required><br>
        <input type="text" name="authors" placeholder="Authors" required><br>
        <input type="text" name="edition" placeholder="Edition" required><br>
        <input type="text" name="publisher" placeholder="Publisher" required><br>
        <button type="submit" name="add_book">Add Book</button>
    </form>

    <h2>Search Book by Title</h2>
    <form action="library1.php" method="get">
        <input type="text" name="search_title" placeholder="Enter Title" required>
        <button type="submit" name="search">Search</button>
    </form>
</body>
</html>