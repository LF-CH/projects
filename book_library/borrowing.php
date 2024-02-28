<?php
require_once 'includes/functions.php';

$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow_book'])) {
   
    $ISBN = $_POST['ISBN'];
    $BorrowerID = $_POST['BorrowerID'];
    $BorrowDate = $_POST['BorrowDate'];
    $DueDate = $_POST['DueDate'];

  
    $result = checkOutBook($ISBN, $BorrowerID, $BorrowDate, $DueDate);
    $message = $result ? "Book borrowed successfully." : "Failed to borrow book.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return_book'])) {
  
    $BorrowID = $_POST['BorrowID'];
    $ReturnDate = $_POST['ReturnDate'];

   
    $result = returnBook($BorrowID, $ReturnDate);
    $message = $result ? "Book returned successfully." : "Failed to return book.";
}


$borrowingRecords = getAllBorrowingRecords();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book returns</title>
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
        <h2>Borrowing Activities</h2>
        <p><?php echo $message; ?></p>
        
        <form method="post" action="borrowing.php">
            <input type="number" name="ISBN" placeholder="ISBN" required>
            <input type="number" name="BorrowerID" placeholder="Borrower ID" required>
            <input type="date" name="BorrowDate" placeholder="Borrow Date" required>
            <input type="date" name="DueDate" placeholder="Due Date" required>
            <input type="submit" name="borrow_book" value="Borrow Book">
        </form>

      
        <form method="post" action="borrowing.php">
            <input type="number" name="BorrowID" placeholder="Borrow ID" required>
            <input type="date" name="ReturnDate" placeholder="Return Date" required>
            <input type="submit" name="return_book" value="Return Book">
        </form>

       
        <h3>Borrowing Records</h3>
        <table>
            <tr>
                <th>Borrow ID</th>
                <th>ISBN</th>
                <th>Borrower ID</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
            </tr>
            <?php foreach ($borrowingRecords as $record): ?>
            <tr>
                <td><?php echo htmlspecialchars($record['BorrowID']); ?></td>
                <td><?php echo htmlspecialchars($record['ISBN']); ?></td>
                <td><?php echo htmlspecialchars($record['BorrowerID']); ?></td>
                <td><?php echo htmlspecialchars($record['BorrowDate']); ?></td>
                <td><?php echo htmlspecialchars($record['DueDate']); ?></td>
                <td><?php echo htmlspecialchars($record['ReturnDate'] ?? 'Not Returned Yet'); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
