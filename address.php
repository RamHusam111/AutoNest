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
    <input class='c' type="text" id="search" placeholder="Enter ID"> <br> 
    <button class="btn" id="insertDataButton">Insert Data</button>
    <input class='c' type="text" id="id" placeholder="Insert ID"> 
    <input class='c' type="text" id="building" placeholder="Insert building"> 
    <input class='c' type="text" id="street" placeholder="Insert street"> 
    <input class='c' type="text" id="city" placeholder="Insert city"> 
    <input class='c' type="text" id="country" placeholder="Insert country"> 
    <br> 
    <div class = "mmm" id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-id" hidden>
        <input  class='c' type="text" id="edit-building" placeholder="Edit Building">
        <input  class='c' type="text" id="edit-street" placeholder="Edit Street">
        <input  class='c' type="text" id="edit-city" placeholder="Edit City">
        <input  class='c' type="text" id="edit-country" placeholder="Edit Country">
        
    </div>
    
    <br> <br>
</div>
    <table id="addressTable">
    <tr>
            <th>ID</th>
            <th>Building</th>
            <th>Street</th>
            <th>City</th>
            <th>Country</th>
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

        $sql = "SELECT * FROM address";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td class='row-building'>" . htmlspecialchars($row['buidling']) . "</td>";
                echo "<td class='row-street'>" . htmlspecialchars($row['street']) . "</td>";
                echo "<td class='row-city'>" . htmlspecialchars($row['city']) . "</td>";
                echo "<td class='row-country'>" . htmlspecialchars($row['country']) . "</td>";
                echo "<td><button class='edit-btn'>Edit</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    

    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() { 
                var value = $('#search').val();
                $.ajax({
                    url: 'searchAddress.php', 
                    type: 'GET',
                    data: {searchTerm: value},
                    success: function(response) {
                        $('table').html(response); 
                    }
                });
            });
            $('#insertDataButton').click(function() {
    // Collect data from input fields
    var id = $('#id').val();
    var building = $('#building').val();
    var street = $('#street').val();
    var city = $('#city').val();
    var country = $('#country').val();
    if (!$.isNumeric(id)) {
                alert("Please enter a valid number for 'id'");
                return; // Stop the function if validation fails
            }
            if (!$.isNumeric(building)) {
                alert("Please enter a valid number for 'building'");
                return; // Stop the function if validation fails
            }

    // Send data to insertDataToAddress.php using AJAX
    $.ajax({
        url: 'insertDataToAddress.php',
        type: 'POST',
        data: {
            id: id,
            building: building,
            street: street,
            city: city,
            country: country
        },
        success: function(response) {
            // Alert the response from the server
            alert(response);

            if (response.indexOf("Record inserted successfully") !== -1) {
                // Create a new row HTML string
                var newRow = '<tr>' +
                    '<td>' + id + '</td>' +
                    '<td>' + building + '</td>' +
                    '<td>' + street + '</td>' +
                    '<td>' + city + '</td>' +
                    '<td>' + country + '</td>' +
                    '</tr>';

                // Append the new row to the table
                $('table').append(newRow);

                // Clear the input fields
                $('#id').val('');
                $('#building').val('');
                $('#street').val('');
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
                $('#edit-id').val(row.eq(0).text());
                $('#edit-building').val(row.eq(1).text());
                $('#edit-street').val(row.eq(2).text());
                $('#edit-city').val(row.eq(3).text());
                $('#edit-country').val(row.eq(4).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var id = $('#edit-id').val();
                var building = $('#edit-building').val();
                var street = $('#edit-street').val();
                var city = $('#edit-city').val();
                var country = $('#edit-country').val();

                if (!$.isNumeric(building)) {
                alert("Please enter a valid number for 'building'");
                return; // Stop the function if validation fails
            }

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateAddress.php',
                    type: 'POST',
                    data: {
                        id: id,
                        building: building,
                        street: street,
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
        if (row.find('.row-id').text() === id) {
            row.find('.row-building').text(building);
            row.find('.row-street').text(street);
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
