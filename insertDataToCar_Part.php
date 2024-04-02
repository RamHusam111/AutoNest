<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $no = isset($_POST['no']) ? $_POST['no'] : '';
    
    

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO car_part (car, part) VALUES (?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param("si", $name, $no);
    
    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "No data received";
}
?>
