<?php
session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $id = isset($_POST['id']) ? $_POST['id'] : ''; // Assuming 'id' is sent from the form
    $building = isset($_POST['building']) ? $_POST['building'] : '';
    $street = isset($_POST['street']) ? $_POST['street'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';


        // Create a prepared statement
        $stmt = $con->prepare("INSERT INTO address (id, buidling, street, city, country) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id, $building, $street, $city, $country); // 'issss' denotes the types of the columns (i for integer, s for string)
    
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
    
