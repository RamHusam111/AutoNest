<?php
// updateAddress.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BigH";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form data is set and not empty
if (isset($_POST['id'], $_POST['date'], $_POST['customer'], $_POST['car']) &&
    !empty($_POST['id']) && !empty($_POST['date']) && !empty($_POST['customer']) && !empty($_POST['car'])) {
    
    // Escape the input data and assign to variables
    $id = $conn->real_escape_string($_POST['id']);
    $date = $conn->real_escape_string($_POST['date']);
    $customer = $conn->real_escape_string($_POST['customer']);
    $car = $conn->real_escape_string($_POST['car']);

    // Prepare an update statement
    $query = "UPDATE orders SET date = ?, customer = ?, car = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('iisi', $date, $customer, $car, $id);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error: Not all fields were filled out.";
}

// Close connection
$conn->close();
?>
