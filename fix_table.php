<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "course_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if registrations table exists
$result = $conn->query("SHOW TABLES LIKE 'registrations'");
if ($result->num_rows > 0) {
    echo "Table 'registrations' exists.<br>";
    
    // Get table structure
    $result = $conn->query("DESCRIBE registrations");
    if ($result) {
        echo "Current table structure:<br>";
        $columns = array();
        while ($row = $result->fetch_assoc()) {
            echo $row['Field'] . " - " . $row['Type'] . "<br>";
            $columns[] = $row['Field'];
        }
        
        // Check if full_name column exists
        if (!in_array('full_name', $columns)) {
            echo "<br>The 'full_name' column is missing. Attempting to add it...<br>";
            
            // Try to determine what the actual name might be
            $possible_name_columns = array_filter($columns, function($col) {
                return strpos($col, 'name') !== false || 
                       strpos($col, 'student') !== false || 
                       strpos($col, 'user') !== false;
            });
            
            if (!empty($possible_name_columns)) {
                $name_column = reset($possible_name_columns);
                echo "Found a possible name column: '$name_column'<br>";
                echo "You should update your code to use this column instead of 'full_name'<br>";
            } else {
                // Add the missing column
                $alter_sql = "ALTER TABLE registrations ADD full_name VARCHAR(100) NOT NULL AFTER id";
                if ($conn->query($alter_sql) === TRUE) {
                    echo "Added 'full_name' column successfully<br>";
                } else {
                    echo "Error adding column: " . $conn->error . "<br>";
                }
            }
        }
    } else {
        echo "Error getting table structure: " . $conn->error;
    }
} else {
    echo "Table 'registrations' does not exist. Creating it now...<br>";
    $sql = "CREATE TABLE registrations (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        course_id INT(11) NOT NULL,
        session VARCHAR(20) NOT NULL,
        comments TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

$conn->close();
echo "<br><a href='javascript:history.back()'>Go Back</a>";
?>