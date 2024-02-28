<?php
require_once 'includes/functions.php';


if (isset($_GET['borrower_id'])) {
    $borrower_id = $_GET['borrower_id'];
    $borrower = getBorrowerByID($borrower_id);
} else {

    header('Location: borrowers.php');
    exit;
}

$message = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_borrower'])) {
    $BorrowerID = $_POST['BorrowerID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $RegistrationDate = $_POST['RegistrationDate'];

  
    $result = updateBorrower($BorrowerID, $FirstName, $LastName, $RegistrationDate);
    $message = $result ? "Borrower updated successfully." : "Failed to update borrower.";
    
    
    $borrower = getBorrowerByID($BorrowerID);
}

function getBorrowerByID($BorrowerID) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM borrower WHERE BorrowerID = ?");
    $stmt->bind_param("i", $BorrowerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Borrower</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Borrower</h2>
        <p><?php echo $message; ?></p>
        
      
        <?php if ($borrower): ?>
        <form method="post" action="updateborrower.php">
            <input type="hidden" name="BorrowerID" value="<?php echo $borrower['BorrowerID']; ?>">
            <input type="text" name="FirstName" placeholder="First Name" value="<?php echo $borrower['FirstName']; ?>" required>
            <input type="text" name="LastName" placeholder="Last Name" value="<?php echo $borrower['LastName']; ?>" required>
            <input type="date" name="RegistrationDate" placeholder="Registration Date" value="<?php echo $borrower['RegistrationDate']; ?>" required>
            <input type="submit" name="update_borrower" value="Update Borrower">
        </form>
        <?php else: ?>
        <p>Borrower not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
