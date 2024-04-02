<?php
session_start();
include("php/config.php"); // Include your database configuration

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract data from POST
    $name = isset($_POST['name']) ? $_POST['name'] : ''; // Assuming 'id' is sent from the form
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';


        // Create a prepared statement
        $stmt = $con->prepare("INSERT INTO manufacture (name, type, city, country) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $type, $city, $country); // 'issss' denotes the types of the columns (i for integer, s for string)
    
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
    
