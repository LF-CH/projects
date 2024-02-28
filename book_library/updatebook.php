<?php
require_once 'includes/functions.php';


if (isset($_GET['edit_isbn'])) {
    $isbn_to_edit = $_GET['edit_isbn'];
    $book_to_edit = getBookByISBN($isbn_to_edit);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_book'])) {
 
    $ISBN = $_POST['ISBN'];
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $Publisher = $_POST['Publisher'];
    $Pub_year = $_POST['Pub_year'];
    $Genre = $_POST['Genre'];
    $ImagePath = $_POST['ImagePath'];
    
   
    $result = updateBook($ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath);
    if ($result) {
        header('Location: books.php'); 
        exit;
    } else {
        $message = "Failed to update book.";
    }
}


if (!isset($book_to_edit)) {
    header('Location: books.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <!-- ... -->
    <div class="container">
        <h2>Edit Book</h2>
        <p><?php echo $message ?? ''; ?></p>
        <form method="post" action="updatebook.php">
          
            <input type="hidden" name="originalISBN" value="<?php echo $book_to_edit['ISBN']; ?>">
            <input type="number" name="ISBN" value="<?php echo $book_to_edit['ISBN']; ?>" required>
            <input type="text" name="Title" value="<?php echo $book_to_edit['Title']; ?>" required>
            <input type="text" name="Author" value="<?php echo $book_to_edit['Author']; ?>" required>
            <input type="text" name="Publisher" value="<?php echo $book_to_edit['Publisher']; ?>" required>
            <input type="number" name="Pub_year" value="<?php echo $book_to_edit['Pub_year']; ?>" required>
            <input type="text" name="Genre" value="<?php echo $book_to_edit['Genre']; ?>" required>
            <input type="text" name="ImagePath" value="<?php echo $book_to_edit['ImagePath']; ?>">
            <input type="submit" name="update_book" value="Update Book">
        </form>
    </div>
    <!-- ... -->
</body>
</html>
