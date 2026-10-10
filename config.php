<?php
// DB configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Lab_Session_DB');

// Establish DB connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Auto-create DB if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
$conn->select_db(DB_NAME);

// Auto-create 'users' table
$table_query = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($table_query);

// Helper function to seed users
function seedUser($conn, $username, $plainPassword) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hashedPassword);
        $insert->execute();
        $insert->close();
    }
    $stmt->close();
}

// Seed default users
seedUser($conn, 'Ezralala', 'ezrasabina17');
?>

<!-- http://localhost/WST%20Activity/Mendoza%20E.%20Lab_Session/login.php -->