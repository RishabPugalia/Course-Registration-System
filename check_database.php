<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check tables
echo "<h2>Database Tables</h2>";

$tables = array("users", "registrations", "payments", "billing_details");

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<p>Table '$table' exists.</p>";
        
        // Show table structure
        echo "<h3>Structure of '$table':</h3>";
        $columns = $conn->query("SHOW COLUMNS FROM $table");
        echo "<ul>";
        while ($column = $columns->fetch_assoc()) {
            echo "<li>" . $column['Field'] . " - " . $column['Type'] . "</li>";
        }
        echo "</ul>";
        
        // Show row count
        $count = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count_result = $count->fetch_assoc();
        echo "<p>Number of rows in '$table': " . $count_result['count'] . "</p>";
    } else {
        echo "<p>Table '$table' does not exist.</p>";
    }
    echo "<hr>";
}

$conn->close();
?>