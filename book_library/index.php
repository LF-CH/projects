<?php require_once 'includes/functions.php'; 


$searchResults = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchResults = searchBooks($searchTerm);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Search</a>
        <a href="books.php">Books Management</a>
        <a href="borrowers.php">Customer Management</a>
        <a href="borrowing.php">Borrowing Returns</a>
    </div>

    <div class="container">
    <h2>Search for Books</h2>
    <form action="index.php" method="get">
        <input type="text" name="search" placeholder="Search by title, author, or ISBN">
        <input type="submit" value="Search">
    </form>
    <?php if ($searchResults !== null): ?>
        <h3>Search Results</h3>
        <table>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Book cover</th>
                <!-- Add more columns as needed -->
            </tr>
            <?php while($row = $searchResults->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['ISBN']); ?></td>
        <td><?php echo htmlspecialchars($row['Title']); ?></td>
        <td><?php echo htmlspecialchars($row['Author']); ?></td>
        <td>
            <!-- Display image here -->
            <?php if ($row['ImagePath']): ?>
                <img src="images/<?php echo htmlspecialchars($row['ImagePath']); ?>" alt="Book Cover" style="max-width:100px;max-height:150px;">
            <?php else: ?>
                No cover available
            <?php endif; ?>
        </td>
        <!-- Output more data as needed -->
    </tr>
<?php endwhile; ?>

        </table>
    <?php elseif (isset($_GET['search'])): ?>
        <p>No results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</p>
    <?php endif; ?>
</div>
</body>
</html>
