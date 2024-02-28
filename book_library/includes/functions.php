<?php
require_once 'db.php';

function getAllBooks() {
    global $conn;
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
    return $result;
}

function getBookByISBN($ISBN) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM books WHERE ISBN = ?");
    $stmt->bind_param("i", $ISBN);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

function addBook($ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO books (ISBN, Title, Author, Publisher, Pub_year, Genre, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiss", $ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath);
    $stmt->execute();
    $stmt->close();
}

function updateBook($ISBN, $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath) {
    global $conn;
    $stmt = $conn->prepare("UPDATE books SET Title = ?, Author = ?, Publisher = ?, Pub_year = ?, Genre = ?, ImagePath = ? WHERE ISBN = ?");
    $stmt->bind_param("sssisii", $Title, $Author, $Publisher, $Pub_year, $Genre, $ImagePath, $ISBN);
    $stmt->execute();
    $stmt->close();
}

function deleteBook($ISBN) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM books WHERE ISBN = ?");
    $stmt->bind_param("i", $ISBN);
    $stmt->execute();
    $stmt->close();
}

function getAllBorrowers() {
    global $conn;
    $sql = "SELECT * FROM borrower";
    $result = $conn->query($sql);
    
    if ($result === false) {
       
        return "Error: " . $conn->error;
    }
    
    return $result;
}


function addBorrower($FirstName, $LastName, $RegistrationDate) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO borrower (FirstName, LastName, RegistrationDate) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $FirstName, $LastName, $RegistrationDate);
    $stmt->execute();
    $stmt->close();
}

function updateBorrower($BorrowerID, $FirstName, $LastName) {
    global $conn;
    $stmt = $conn->prepare("UPDATE borrower SET FirstName = ?, LastName = ? WHERE BorrowerID = ?");
    $stmt->bind_param("ssi", $FirstName, $LastName, $BorrowerID);
    $stmt->execute();
    $stmt->close();
}

function deleteBorrower($BorrowerID) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM borrower WHERE BorrowerID = ?");
    $stmt->bind_param("i", $BorrowerID);
    $stmt->execute();
    $stmt->close();
}

function checkOutBook($ISBN, $BorrowerID, $BorrowDate, $DueDate) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO borrowing (ISBN, BorrowerID, BorrowDate, DueDate) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $ISBN, $BorrowerID, $BorrowDate, $DueDate);
    $stmt->execute();
    $stmt->close();
}

function returnBook($BorrowID, $ReturnDate) {
    global $conn;
    $stmt = $conn->prepare("UPDATE borrowing SET ReturnDate = ? WHERE BorrowID = ?");
    $stmt->bind_param("si", $ReturnDate, $BorrowID);
    $stmt->execute();
    $stmt->close();
}

//search
function searchBooks($searchTerm) {
    global $conn;
    $searchTerm = "%" . $conn->real_escape_string($searchTerm) . "%";
    $stmt = $conn->prepare("SELECT * FROM books WHERE Title LIKE ? OR Author LIKE ? OR ISBN LIKE ?");
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getAllBorrowingRecords() {
    global $conn;
    $sql = "SELECT * FROM borrowing";
    $result = $conn->query($sql);
    
    if ($result === false) {
        
        return "Error: " . $conn->error;
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>