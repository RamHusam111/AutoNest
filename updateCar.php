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
if (isset($_POST['name'], $_POST['model'], $_POST['year'], $_POST['made']) &&
    !empty($_POST['name']) && !empty($_POST['model']) && !empty($_POST['year']) && 
    !empty($_POST['made'])) {
    
    // Escape the input data and assign to variables
    $name = $conn->real_escape_string($_POST['name']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = $conn->real_escape_string($_POST['year']);
    $made = $conn->real_escape_string($_POST['made']);

    // Prepare an update statement
    $query = "UPDATE car SET model = ?, year = ?, made = ? WHERE name = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('siss', $model, $year, $made, $name);

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
