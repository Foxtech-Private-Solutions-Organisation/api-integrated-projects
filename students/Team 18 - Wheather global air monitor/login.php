<?php
session_start();

// DB credentials (update if needed)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'userdb'; // make sure this matches your database

// Connect to DB
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Look for user in DB
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        echo "Login successful! Redirecting...";
        header("Refresh: 2; URL=main.php"); // Redirect to main page
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that email.";
}

$conn->close();
?>
