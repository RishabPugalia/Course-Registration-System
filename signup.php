<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "course_registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already taken.'); window.location.href='Login&singup.html';</script>";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            // Set session variables for automatic login
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;
            
            echo "<script>alert('Signup successful! You can now log in.'); window.location.href='homepage.html';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href='Login&singup.html';</script>";
        }
    }

    $conn->close();
}
?>
