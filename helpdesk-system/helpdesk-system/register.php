<?php
// Start session
session_start();

// Include database connection file
equire 'db_connection.php';

// Initialize variables
$email = $password = $confirm_password = '';
$errors = array();

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate email
eif (empty($_POST['email'])) {
        array_push($errors, 'Email is required');
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, 'Invalid email format');
        }
    }

    // Validate password
    if (empty($_POST['password'])) {
        array_push($errors, 'Password is required');
    } else {
        $password = $_POST['password'];
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            array_push($errors, 'Password must be at least 8 characters long, contain at least one uppercase letter and one number');
        }
    }

    // Confirm password
    if ($_POST['password'] !== $_POST['confirm_password']) {
        array_push($errors, 'Passwords do not match');
    }

    // Register user if no errors
    if (count($errors) == 0) {
        // Perform registration logic (e.g. insert into database)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
        mysqli_query($conn, $query);
        $_SESSION['success'] = 'You are now registered!';
        header('location: welcome.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="POST" action="register.php">
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <br>
        <label>Password:</label>
        <input type="password" name="password">
        <br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password">
        <br>
        <button type="submit">Register</button>
    </form>
    <p><?php foreach ($errors as $error) echo $error; ?></p>
</body>
</html>
