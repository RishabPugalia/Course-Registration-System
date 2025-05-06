<?php
// Enable mysqli exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Database connection to MySQL without selecting a database
    $conn = new mysqli("localhost", "root", "");
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS course_registration";
    $conn->query($sql);
    echo "Database created successfully or already exists<br>";
    
} catch (mysqli_sql_exception $e) {
    die("Connection or database creation failed: " . $e->getMessage());
}

try {
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
    $conn->query($sql);
    echo "Users table created successfully or already exists<br>";
    
    // Create payments table
    $sql = "CREATE TABLE IF NOT EXISTS payments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        transaction_id VARCHAR(100),
        payment_status VARCHAR(20) DEFAULT 'pending',
        payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->query($sql);
    echo "Payments table created successfully or already exists<br>";
    
    // Create billing_details table
    $sql = "CREATE TABLE IF NOT EXISTS billing_details (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        billing_name VARCHAR(100) NOT NULL,
        billing_email VARCHAR(100) NOT NULL,
        address VARCHAR(255) NOT NULL,
        city VARCHAR(50) NOT NULL,
        state VARCHAR(50) NOT NULL,
        zip_code VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $conn->query($sql);
    echo "Billing details table created successfully or already exists<br>";
    
    echo "<br>Database setup complete. <a href='Registration.html'>Go to Registration</a>";
    
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
} finally {
    $conn->close();
}
?>