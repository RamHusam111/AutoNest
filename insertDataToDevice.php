<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $no = isset($_POST['no']) ? $_POST['no'] : ''; 
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
    $made = isset($_POST['made']) ? $_POST['made'] : '';

    // Server-side validation for numeric values
    if (!ctype_digit($no)) {
        echo "Error: 'no' must be an integer.";
        exit;
    }
    if (!is_numeric($price)) {
        echo "Error: 'price' must be a number.";
        exit;
    }
    if (!is_numeric($weight)) {
        echo "Error: 'weight' must be a number.";
        exit;
    }

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO device (no, name, price, weight, made) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param("isdds", $no, $name, $price, $weight, $made);
    
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
