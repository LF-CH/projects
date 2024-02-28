<?php
require_once 'includes/functions.php';


$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_borrower'])) {

    $FirstName = filter_input(INPUT_POST, 'FirstName', FILTER_SANITIZE_STRING);
    $LastName = filter_input(INPUT_POST, 'LastName', FILTER_SANITIZE_STRING);
    $RegistrationDate = filter_input(INPUT_POST, 'RegistrationDate', FILTER_SANITIZE_STRING);

    
    $result = addBorrower($FirstName, $LastName, $RegistrationDate);
    $message = $result ? "Borrower added successfully." : "Failed to add borrower.";
}


   if (isset($_POST['update_borrower'])) {
    $BorrowerID = $_POST['BorrowerID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $RegistrationDate = $_POST['RegistrationDate']; 

    $result = updateBorrower($BorrowerID, $FirstName, $LastName, $RegistrationDate);
    $message = $result ? "Borrower updated successfully." : "Failed to update borrower.";
}


if (isset($_POST['delete_borrower'])) {
    $BorrowerID = $_POST['BorrowerID'];

    $result = deleteBorrower($BorrowerID);
    $message = $result ? "Borrower deleted successfully." : "Failed to delete borrower.";
}



$borrowers = getAllBorrowers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrowers Management</title>
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
        <h2>Library Customers</h2>
        <p><?php echo $message; ?></p>
        
    
        <form method="post" action="borrowers.php">
            <input type="text" name="FirstName" placeholder="First Name" required>
            <input type="text" name="LastName" placeholder="Last Name" required>
            <input type="date" name="RegistrationDate" placeholder="Registration Date" required>
            <input type="submit" name="add_borrower" value="Add Borrower">
        </form>

    
        <table>
            <tr>
                <th>Borrower ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Registration Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $borrowers->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['BorrowerID']); ?></td>
                <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                <td><?php echo htmlspecialchars($row['RegistrationDate']); ?></td>
                <td><?php echo htmlspecialchars($row['Status']); ?></td>
                <td>
            
<a href="updateborrower.php?borrower_id=<?php echo $row['BorrowerID']; ?>">Edit</a>

                    <form method="post" action="borrowers.php" style="display:inline;">
                        <input type="hidden" name="BorrowerID" value="<?php echo $row['BorrowerID']; ?>">
                        <input type="submit" name="delete_borrower" value="Delete" onclick="return confirm('Are you sure you want to delete this borrower?');">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>