<?php
// Database Configuration
$host = 'localhost'; // Database host
$username = 'db_user'; // Database username
$password = 'db_password'; // Database password
$dbname = 'helpdesk_db'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Session Management
session_start(); // Start session

// File Upload Settings
$uploadDir = 'uploads/'; // Upload directory
$maxFileSize = 1048576; // 1MB
$allowedFileTypes = ['jpg', 'png', 'jpeg', 'pdf']; // Allowed file types

// Security Constants
define('MAX_LOGIN_ATTEMPTS', 5); // Max login attempts
define('SESSION_TIMEOUT', 1800); // Session timeout in seconds

?>
