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
$sql = "SELECT courses.course_name FROM registrations
        JOIN courses ON registrations.course_id = courses.id
        WHERE registrations.user_id = '$user_id' LIMIT 1";

$result = $conn->query($sql);

$selected_course = "No course selected";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selected_course = $row['course_name'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    <p>Selected Course: <?php echo $selected_course; ?></p>
    <a href="courses.php">Browse Courses</a>
</body>
</html>
