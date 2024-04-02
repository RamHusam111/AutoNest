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
if (isset($_POST['name'], $_POST['type'], $_POST['city'], $_POST['country']) &&
    !empty($_POST['name']) && !empty($_POST['type']) && !empty($_POST['city']) && !empty($_POST['country'])) {
    
    // Escape the input data and assign to variables
    $name = $conn->real_escape_string($_POST['name']);
    $type = $conn->real_escape_string($_POST['type']);
    $city = $conn->real_escape_string($_POST['city']);
    $country = $conn->real_escape_string($_POST['country']);

    // Prepare an update statement
    $query = "UPDATE manufacture SET type = ?, city = ?, country = ? WHERE name = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('ssss', $type, $city, $country, $name);

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
