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
if (isset($_POST['id'], $_POST['building'], $_POST['street'], $_POST['city'], $_POST['country']) &&
    !empty($_POST['id']) && !empty($_POST['building']) && !empty($_POST['street']) && 
    !empty($_POST['city']) && !empty($_POST['country'])) {
    
    // Escape the input data and assign to variables
    $id = $conn->real_escape_string($_POST['id']);
    $building = $conn->real_escape_string($_POST['building']);
    $street = $conn->real_escape_string($_POST['street']);
    $city = $conn->real_escape_string($_POST['city']);
    $country = $conn->real_escape_string($_POST['country']);

    // Prepare an update statement
    $query = "UPDATE address SET buidling = ?, street = ?, city = ?, country = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('ssssi', $building, $street, $city, $country, $id);

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
