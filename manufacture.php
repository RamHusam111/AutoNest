<html>
<head>
<style>
    @media (max-width: 1110px) {
        .mmm{
            display: flex;
            flex-direction: column;

        }
        table{
            width: 2%; /* Make the table full width */
        max-width: 100%; /* Ensure it doesn't exceed the width of its container */
        font-size: 18px; /* Increase font size */
        }
        
    }
    @media (max-width: 595px) {
        table{
            width: 2%; /* Make the table full width */
        max-width: 100%; /* Ensure it doesn't exceed the width of its container */
        font-size: 10px; /* Increase font size */
        }
        
    }
    .btn {
    margin-bottom: 10px; /* Adjust the value as needed */
}

.c {
    margin-top: 10px; /* Adjust the value as needed */
}
        .edit-btn{
            background: rgba(76,68,182,0.808);
            color: #fff;
            transition: all .3s;
        }
        .edit-btn:hover{
    opacity: 0.82;
}
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class = "mmm">
    <button class="btn" id="searchButton">Search</button>
    <input class='c' type="text" id="search" placeholder="Enter Name"> <br>
    <button class="btn" id="insertDataButton">Insert Data</button>
    <input class='c' type="text" id="name" placeholder="Insert Name"> 
    <input class='c' type="text" id="type" placeholder="Insert Type"> 
    <input class='c' type="text" id="city" placeholder="Insert City"> 
    <input class='c' type="text" id="country" placeholder="Insert country"> <br>
    <div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-name" hidden>
        <input  class='c' type="text" id="edit-type" placeholder="Edit type">
        <input  class='c' type="text" id="edit-city" placeholder="Edit city">
        <input  class='c' type="text" id="edit-country" placeholder="Edit country">
        
        
    </div>
    
    </div>
    <br> <br>
    <table id="addressTable">
    <tr>
            <th>name</th>
            <th>type</th>
            <th>city</th>
            <th>country</th>
            <th>Actions</th>
        </tr>
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

        $sql = "SELECT * FROM manufacture";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td class='row-building'>" . htmlspecialchars($row['type']) . "</td>";
                echo "<td class='row-street'>" . htmlspecialchars($row['city']) . "</td>";
                echo "<td class='row-city'>" . htmlspecialchars($row['country']) . "</td>";
                echo "<td><button class='edit-btn'>Edit</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() { // Updated to use click event
                var value = $('#search').val();
                $.ajax({
                    url: 'searchManufacture.php', // PHP file to handle search
                    type: 'GET',
                    data: {searchTerm: value},
                    success: function(response) {
                        $('table').html(response); // Update the table with search results
                    }
                });
            });

            $('#insertDataButton').click(function() {
    // Collect data from input fields
    var name = $('#name').val();
    var type = $('#type').val();
    var city = $('#city').val();
    var country = $('#country').val();

    // Send data to insertDataToAddress.php using AJAX
    $.ajax({
        url: 'insertDataToManufacture.php',
        type: 'POST',
        data: {
            name: name,
            type: type,
            city: city,
            country: country
        },
        success: function(response) {
            // Alert the response from the server
            alert(response);

            // Assuming the server returns a success message
            if (response.indexOf("Record inserted successfully") !== -1) {
                // Create a new row HTML string
                var newRow = '<tr>' +
                    '<td>' + name + '</td>' +
                    '<td>' + type + '</td>' +
                    '<td>' + city + '</td>' +
                    '<td>' + country + '</td>' +
                    '</tr>';

                // Append the new row to the table
                $('table').append(newRow);

                // Clear the input fields
                $('#name').val('');
                $('#type').val('');
                $('#city').val('');
                $('#country').val('');
            }
        },
        error: function(xhr, status, error) {
            // Handle errors here
            alert('An error occurred: ' + xhr.status + ' ' + error);
        }
    });
});
$(document).on('click', '.edit-btn', function() {
                var row = $(this).closest('tr').find('td');
                $('#edit-name').val(row.eq(0).text());
                $('#edit-type').val(row.eq(1).text());
                $('#edit-city').val(row.eq(2).text());
                $('#edit-country').val(row.eq(3).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var name = $('#edit-name').val();
                var type = $('#edit-type').val();
                var city = $('#edit-city').val();
                var country = $('#edit-country').val();
                

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateManufacture.php',
                    type: 'POST',
                    data: {
                        name: name,
                        type: type,
                        city: city,
                        country: country
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    // Find the row with the matching ID and update its contents
    $('#addressTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-name').text() === name) {
            row.find('.row-type').text(type);
            row.find('.row-city').text(city);
            row.find('.row-country').text(country);
            return false; // breaks the loop
        }
    });
},
    error: function(xhr, status, error) {
    alert('Error: ' + error);
    }
    });
    });
        });
    </script>
</body>
</html>
