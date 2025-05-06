<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if registrations table exists
$result = $conn->query("SHOW TABLES LIKE 'registrations'");
if ($result->num_rows > 0) {
    echo "Table 'registrations' exists.\n";
    
    // Get table structure
    $result = $conn->query("DESCRIBE registrations");
    if ($result) {
        echo "Table structure:\n";
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . " - " . $row['Type'] . "\n";
        }
    } else {
        echo "Error getting table structure: " . $conn->error;
    }
} else {
    echo "Table 'registrations' does not exist.";
}

$conn->close();
?>