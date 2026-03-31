<?php
// secured_upload.php

// Define allowed file types and size limit
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
$sizeLimit = 2 * 1024 * 1024; // 2MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if file has been uploaded
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // Validate file size
        if ($file['size'] > $sizeLimit) {
            die('File is too large.');
        }

        // Validate MIME type
        if (!in_array($file['type'], $allowedTypes)) {
            die('Invalid file type.');
        }

        // Generate a secure filename
        $filename = bin2hex(random_bytes(16)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        // Define upload directory
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            echo 'File uploaded successfully: ' . htmlspecialchars($filename);
        } else {
            die('Error during file upload.');
        }
    } else {
        die('No file uploaded.');
    }
}
?>
