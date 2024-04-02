<?php
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

// Get the search term
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

// Prepare the SQL query to search only by name
$query = "SELECT * FROM car WHERE name LIKE ?";

$stmt = $conn->prepare($query);

// Bind parameter - since we are searching by name, it's a string
$searchTerm = "%$searchTerm%";
$stmt->bind_param("s", $searchTerm);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Dynamically create the table header based on the fetched data
if ($result->num_rows > 0) {
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
    echo "<tr><td colspan='5'>No results found</td></tr>"; // Adjust the colspan as needed
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
