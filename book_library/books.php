<?php
require_once 'includes/functions.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $ISBN = $_POST['ISBN'];
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $Publisher = $_POST['Publisher'];
    $Pub_year = $_POST['Pub_year'];
    $ImagePath = $_POST['ImagePath']; 
    
    addBook($ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
    
    $originalISBN = $_POST['originalISBN'];
    $ISBN = $_POST['ISBN'];
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $Publisher = $_POST['Publisher'];
    $Pub_year = $_POST['Pub_year'];
    $ImagePath = $_POST['ImagePath'];
    
    updateBook($originalISBN, $ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book'])) {
    $ISBN = $_POST['ISBN'];
  
    deleteBook($ISBN);
}
$books = getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books Management</title>
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
        <h2>Books Management</h2>
        
      
        <form method="post" action="books.php">
            <input type="number" name="ISBN" placeholder="ISBN" required>
            <input type="text" name="Title" placeholder="Title" required>
            <input type="text" name="Author" placeholder="Author" required>
            <input type="text" name="Publisher" placeholder="Publisher" required>
            <input type="number" name="Pub_year" placeholder="Publication Year" required>
            <input type="text" name="ImagePath" placeholder="Image Path">
            <input type="submit" name="add_book" value="Add Book">
        </form>

        <h3>Update or Delete Books</h3>
        <div class="table-responsive">
        <table>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Book cover</th>
                <th>Publisher</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Last Borrowed</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $books->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['ISBN']); ?></td>
                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                <td><?php echo htmlspecialchars($row['Author']); ?></td>
                <td>
          
            <?php if ($row['ImagePath']): ?>
                <img src="images/<?php echo htmlspecialchars($row['ImagePath']); ?>" alt="Book Cover" style="max-width:100px;max-height:150px;">
            <?php else: ?>
                No cover available
            <?php endif; ?>
        </td>
                <td><?php echo htmlspecialchars($row['Publisher']); ?></td>
                <td><?php echo htmlspecialchars($row['Pub_year']); ?></td>
                <td><?php echo htmlspecialchars($row['Genre']); ?></td>
                <td><?php echo htmlspecialchars($row['Status']); ?></td>
                <td><?php echo htmlspecialchars($row['DateAdded']); ?></td>
                <td><?php echo htmlspecialchars($row['LastBorrowed']); ?></td>
                <td>
   
    <a href="updatebook.php?edit_isbn=<?php echo $row['ISBN']; ?>">Edit</a>
   
    <form method="post" action="books.php" style="display:inline;">
        <input type="hidden" name="ISBN" value="<?php echo $row['ISBN']; ?>">
        <input type="submit" name="delete_book" value="Delete">
    </form>
</td>
                </tr>
                <?php endwhile; ?>
            </table>
    </div>
        </div>
    </div>
</body>
</html>
