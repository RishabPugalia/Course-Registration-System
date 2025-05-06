<?php
// Start the session to store registration data
session_start();

// Enable mysqli exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "course_registration");
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the database exists, if not create it
$check_db = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'course_registration'");
if ($check_db->num_rows == 0) {
    $conn->query("CREATE DATABASE course_registration");
    $conn->select_db("course_registration");
    
    // Create users table
    $conn->query("CREATE TABLE users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create payments table
    $conn->query("CREATE TABLE payments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        transaction_id VARCHAR(100),
        payment_status VARCHAR(20) DEFAULT 'pending',
        payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");
}

// Get form data
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
$payment_method = $conn->real_escape_string($_POST['payment_method']);

try {
    // Insert user data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    $conn->query($sql);
    
    // Get the user ID for the payment record
    $user_id = $conn->insert_id;
    
    // Store data in session for the payment page
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['payment_method'] = $payment_method;
    
    // Redirect to payment page
    header("Location: Payment.html");
    exit();
    
} catch (mysqli_sql_exception $e) {
    // Check if the error is due to duplicate email
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
        echo "<script>alert('Email already exists. Please login instead.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Database Error: " . $e->getMessage() . "'); window.location.href='Registration.html';</script>";
    }
    exit();
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='Registration.html';</script>";
    exit();
}

$conn->close();
?>