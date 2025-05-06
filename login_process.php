<?php
// Start the session
session_start();

// Enable mysqli exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "course_registration");
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get form data
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

try {
    // Check if the email exists in the database
    $sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // User found, verify password
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to payment page or dashboard
            header("Location: Payment.html");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        // User not found
        echo "<script>alert('Email not found. Please register first.'); window.location.href='Registration.html';</script>";
        exit();
    }
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='login.html';</script>";
    exit();
}

$conn->close();
?>