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
if (isset($_POST['id'], $_POST['f_name'], $_POST['l_name'], $_POST['address'], $_POST['job']) &&
    !empty($_POST['id']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && 
    !empty($_POST['address']) && !empty($_POST['job'])) {
    
    // Escape the input data and assign to variables
    $id = $conn->real_escape_string($_POST['id']);
    $f_name = $conn->real_escape_string($_POST['f_name']);
    $l_name = $conn->real_escape_string($_POST['l_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $job = $conn->real_escape_string($_POST['job']);

    // Prepare an update statement
    $query = "UPDATE customer SET f_name = ?, l_name = ?, address = ?, job = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('ssisi', $f_name, $l_name, $address, $job, $id);

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
