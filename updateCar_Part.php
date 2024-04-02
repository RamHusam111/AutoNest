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
if (isset($_POST['car'], $_POST['part']) &&
    !empty($_POST['car']) && !empty($_POST['part'])) {
    
    // Escape the input data and assign to variables
    $car = $conn->real_escape_string($_POST['car']);
    $part = $conn->real_escape_string($_POST['part']);
    
    // Prepare an update statement
    $query = "UPDATE car_part SET car = ? WHERE part = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('si', $car, $part);

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
