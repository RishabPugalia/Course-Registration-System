<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // Change this to your database username
$password = "";      // Change this to your database password
$dbname = "course_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $course = $conn->real_escape_string($_POST['course']);
    $session = $conn->real_escape_string($_POST['session']);
    $comments = $conn->real_escape_string($_POST['comments']);

    // Prepare SQL statement
    $sql = "INSERT INTO registrations (full_name, email, phone, course_id, session, comments, registration_date) 
            VALUES ('$fullName', '$email', '$phone', '$course', '$session', '$comments', NOW())";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'coursereg.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'coursereg.html';
              </script>";
    }
}

// Close database connection
$conn->close();
?>
