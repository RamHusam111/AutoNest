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

// Check if the searchTerm is an integer
if (!ctype_digit($searchTerm) && $searchTerm !== '') {
    echo "<script>alert('ID must be an integer');</script>";
    echo "<tr><td colspan='5'>Please enter a valid ID</td></tr>";
} else {
    // Prepare the SQL query to search only by ID
    $query = "SELECT * FROM customer WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind parameter - as the ID is a numeric field, ensure the type is integer
    $stmt->bind_param("i", $searchTerm);

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
        echo "<tr><td colspan='5'>No results found</td></tr>";
    }
}

// Close statement and connection
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
