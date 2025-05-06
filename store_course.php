<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
}

$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id']; // Get the selected course ID

// Insert the selected course into the registrations table for the user
$sql = "INSERT INTO registrations (user_id, course_id) VALUES ('$user_id', '$course_id')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Course selected successfully!'); window.location.href='homepage.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href='courses.php';</script>";
}

$conn->close();
?>
