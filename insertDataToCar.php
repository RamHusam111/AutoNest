<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $model = isset($_POST['model']) ? $_POST['model'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $made = isset($_POST['made']) ? $_POST['made'] : '';

    // Server-side validation for numeric values
    if (!ctype_digit($year)) {
        echo "Error: 'year' must be an integer.";
        exit;
    }
    

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO car (name, model, year, made) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param("ssis", $name, $model, $year, $made);
    
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
