<?php
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookName = $_POST['book_name'];
    $fileType = $_POST['file_type'];
    
    
    $bookFile = $_FILES['book_file']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($bookFile);
    $uploadOk = 1;
    $fileTypeExt = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
    if (!in_array($fileTypeExt, ['pdf', 'word', 'ppt'])) {
        echo "Sorry, only PDF, Word & PPT files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && move_uploaded_file($_FILES['book_file']['tmp_name'], $targetFile)) {
        $imagePath = null;

        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $imageName = basename($image['name']);
            $imageTmpName = $image['tmp_name'];
            $imageDestination = 'images/' . $imageName;

            
            if (!file_exists('images')) {
                mkdir('images', 0777, true);
            }

            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                $imagePath = $imageDestination;
            } else {
                echo "Error uploading image file.";
                exit;
            }
        }

        
        $query = "INSERT INTO book (book_name, book_file, file_type, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $bookName, $bookFile, $fileType, $imagePath);

        if ($stmt->execute()) {
            
            header("Location: admin.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, your book file was not uploaded.";
    }
}
?>
