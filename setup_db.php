<?php
// Database connection to MySQL without selecting a database
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS course_registration";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db("course_registration");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating users table: " . $conn->error);
}

// Create registrations table
$sql = "CREATE TABLE IF NOT EXISTS registrations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    course_id INT(11) NOT NULL,
    session VARCHAR(20) NOT NULL,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating registrations table: " . $conn->error);
}

// Create payments table
$sql = "CREATE TABLE IF NOT EXISTS payments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    registration_id INT(11),
    billing_name VARCHAR(100) NOT NULL,
    billing_email VARCHAR(100) NOT NULL,
    card_number VARCHAR(20),
    amount DECIMAL(10,2) NOT NULL,
    transaction_id VARCHAR(100),
    payment_status VARCHAR(20) DEFAULT 'completed',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating payments table: " . $conn->error);
}

echo "Database and tables created successfully!";
echo "<br><a href='Login&singup.html'>Go to Login/Signup</a>";

$conn->close();
?>