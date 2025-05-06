<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "course_registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session and redirect to homepage
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['logged_in'] = true;
            
            header("Location: homepage.html");  // Redirect to the homepage after login
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='Login&singup.html';</script>";
        }
    } else {
        // No user found with the given email
        echo "<script>alert('No user found with that email. Please sign up first.'); window.location.href='Login&singup.html';</script>";
    }

    $conn->close();
}
?>
