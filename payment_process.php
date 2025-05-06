<?php
// Start the session to retrieve registration data
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if payments table exists, if not create it
$check_table = $conn->query("SHOW TABLES LIKE 'payments'");
if ($check_table->num_rows == 0) {
    $sql = "CREATE TABLE payments (
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
        die("Error creating table: " . $conn->error);
    }
}

// Get payment form data
$billing_name = $_POST['billing_name'];
$billing_email = $_POST['billing_email'];
$card_name = $_POST['card_name'];
$card_number = $_POST['card_number'];
$amount = isset($_POST['amount']) ? $_POST['amount'] : '999.00'; // Default amount if not provided

// Generate a transaction ID
$transaction_id = 'TXN' . rand(100000, 999999);

// Get registration ID from session if available
$registration_id = isset($_SESSION['registration_id']) ? $_SESSION['registration_id'] : null;

// Insert payment data
$sql = "INSERT INTO payments (registration_id, billing_name, billing_email, card_number, amount, transaction_id) 
        VALUES (" . ($registration_id ? $registration_id : "NULL") . ", '$billing_name', '$billing_email', '$card_number', '$amount', '$transaction_id')";

if ($conn->query($sql) === TRUE) {
    // Clear registration session data
    unset($_SESSION['registration_id']);
    unset($_SESSION['full_name']);
    unset($_SESSION['email']);
    unset($_SESSION['course_id']);
    unset($_SESSION['course_session']);
    
    echo "<script>alert('Payment successful! Transaction ID: " . $transaction_id . "'); window.location.href='homepage.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

$conn->close();
?>