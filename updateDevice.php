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
if (isset($_POST['no'], $_POST['name'], $_POST['price'], $_POST['weight'], $_POST['made']) &&
    !empty($_POST['no']) && !empty($_POST['name']) && !empty($_POST['price']) && 
    !empty($_POST['weight']) && !empty($_POST['made'])) {
    
    // Escape the input data and assign to variables
    $id = $conn->real_escape_string($_POST['no']);
    $building = $conn->real_escape_string($_POST['name']);
    $street = $conn->real_escape_string($_POST['price']);
    $city = $conn->real_escape_string($_POST['weight']);
    $country = $conn->real_escape_string($_POST['made']);

    // Prepare an update statement
    $query = "UPDATE device SET name = ?, price = ?, weight = ?, made = ? WHERE no = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to the prepared statement
    $stmt->bind_param('siisi', $name, $price, $weight, $made, $no);

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
