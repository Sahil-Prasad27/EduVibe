<?php
session_start();
@include 'config.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$bookId = $data['id'];


$sql = "SELECT image FROM book WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $bookId);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($book) {
    $imagePath = $book['image'];

    
    $deleteSql = "DELETE FROM book WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('i', $bookId);

    if ($deleteStmt->execute()) {
        
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No book found with ID: " . $bookId;
}

$conn->close();
?>
