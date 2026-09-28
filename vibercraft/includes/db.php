<?php
// Database configuration credentials
$db_host = "localhost";
$db_user = "root";       // Default XAMPP/WAMP username
$db_pass = "";           // Default XAMPP/WAMP password (leave empty if none)
$db_name = "vibecraft_db"; // Your database name

// Create database connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection status
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set default charset to UTF-8 to support special characters & Arabic text
mysqli_set_charset($conn, "utf8mb4");
?>