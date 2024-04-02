<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $customer = isset($_POST['customer']) ? $_POST['customer'] : '';
    $carName = isset($_POST['carName']) ? $_POST['carName'] : '';

    // Server-side validation for numeric values
    if (!ctype_digit($id)) {
        echo "Error: 'id' must be valid integer.";
        exit;
    }
    if (!ctype_digit($date)) {
        echo "Error: 'date' must be valid integer.";
        exit;
    }
    

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO orders (id, date, customer, car) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param("iiis", $id, $date, $customer, $carName);
    
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
