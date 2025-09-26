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

// Check if user already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "User already exists. Try logging in instead.";
} else {
    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ss", $email, $hashed_password);

    if ($insert_stmt->execute()) {
        echo "Registration successful! Redirecting to login...";
        header("Refresh: 2; URL=login.html"); // Change to your login page
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
