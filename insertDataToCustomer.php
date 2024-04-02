<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("php/config.php"); 

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $id = isset($_POST['id']) ? $_POST['id'] : ''; 
    $f_name = isset($_POST['f_name']) ? $_POST['f_name'] : '';
    $l_name = isset($_POST['l_name']) ? $_POST['l_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $job = isset($_POST['job']) ? $_POST['job'] : '';

    // Server-side validation for numeric values
    if (!ctype_digit($id)) {
        echo "Error: 'id' must be an integer.";
        exit;
    }

    // Check if address ID exists in the address table
    $addressQuery = $con->prepare("SELECT id FROM address WHERE id = ?");
    $addressQuery->bind_param("i", $address);
    $addressQuery->execute();
    $result = $addressQuery->get_result();
    if ($result->num_rows == 0) {
        echo "Error: Address ID does not exist.";
        exit;
    }
    $addressQuery->close();

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO customer (id, f_name,  l_name, address, job) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param("issis", $id, $f_name, $l_name, $address, $job);
    
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
