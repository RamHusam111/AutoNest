<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Get the search parameters
$part = $_GET['part'] ?? '';
$car = $_GET['car'] ?? '';

// Check if the part is an integer
if (!ctype_digit($part)) {
    echo "<script>alert('The part number must be an integer.');</script>";
    exit; // Stop the execution of the script
}


// SQL query to search for car parts based on car and part parameters
$query = "SELECT * FROM car_part WHERE car LIKE ? AND part LIKE ?";

if ($stmt = $conn->prepare($query)) {
    echo "Statement prepared";
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Prepare parameters for the SQL query
$carParam = "%$car%";
$partParam = "%$part%";


// Bind parameters
if ($stmt->bind_param("ss", $carParam, $partParam)) {
    echo "Parameters bound";
} else {
    echo "Error binding parameters";
}

// Execute the query
if ($stmt->execute()) {
    echo "Statement executed";
} else {
    echo "Error executing statement";
}

$result = $stmt->get_result();

if ($result) {
    echo "Result fetched";
} else {
    echo "Error fetching result";
}

// Dynamically create the table header based on the fetched data
if ($result->num_rows > 0) {
    echo "Results found: " . $result->num_rows;
    echo "<tr>";
    while ($fieldinfo = $result->fetch_field()) {
        echo "<th>" . ucfirst($fieldinfo->name) . "</th>";
    }
    echo "</tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . $cell . "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
