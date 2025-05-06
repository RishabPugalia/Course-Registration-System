<?php
// Start the session
session_start();

// Check if user is logged in
$logged_in = isset($_SESSION['user_id']) ? true : false;

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['logged_in' => $logged_in]);
?>