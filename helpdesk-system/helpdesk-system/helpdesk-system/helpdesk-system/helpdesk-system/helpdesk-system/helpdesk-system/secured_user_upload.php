<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload files.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // File upload logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if(!in_array($fileType, ['jpg', 'png', 'pdf', 'doc', 'docx'])) {
        echo "Sorry, only JPG, PNG, PDF, DOC & DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Mark as pending for admin approval in the database (pseudo code)
        // saveFileToDatabase($target_file, $_SESSION['user_id'], 'pending'); // Assume existence of this function
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded and is pending admin approval.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Document</title>
</head>
<body>
    <h2>Upload Document</h2>
    <form action="" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" required>
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
