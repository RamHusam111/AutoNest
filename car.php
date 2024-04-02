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


$manufactureNames = [];
        $query = "SELECT name FROM manufacture";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $manufactureNames[] = $row['name'];
            }
        }


?>
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
    <input class='c' type="text" id="name" placeholder="Insert name"> 
    <input class='c' type="text" id="model" placeholder="Insert model"> 
    <input class='c' type="text" id="year" placeholder="Insert year"> 
<select id='made' class='c'>
    <option value=''>Select made</option>
    <?php foreach ($manufactureNames as $name): ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
</select><br> 
<div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-name" hidden>
        <input  class='c' type="text" id="edit-model" placeholder="Edit model">
        <input  class='c' type="text" id="edit-year" placeholder="Edit year">
        <select id='edit-made' class='c'>
            <option value=''>Select made</option>
            <?php foreach ($manufactureNames as $name): ?>
             <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
              <?php endforeach; ?>
        </select>
    </div>
    <br><br>
    </div>

    <table id="carTable">
    <tr>
            <th>name</th>
            <th>model</th>
            <th>year</th>
            <th>made</th>
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

        $sql = "SELECT * FROM car";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td class='row-building'>" . htmlspecialchars($row['model']) . "</td>";
                echo "<td class='row-street'>" . htmlspecialchars($row['year']) . "</td>";
                echo "<td class='row-city'>" . htmlspecialchars($row['made']) . "</td>";
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
                    url: 'searchCar.php', // PHP file to handle search
                    type: 'GET',
                    data: {searchTerm: value},
                    success: function(response) {
                        $('table').html(response); // Update the table with search results
                    }
                });
            });
            $('#insertDataButton').click(function() {
            var name = $('#name').val();
            var model = $('#model').val();
            var year = $('#year').val();
            var made = $('#made').val();

            // Validate inputs
            if (!$.isNumeric(year)) {
                alert("Please enter a valid number for 'year'");
                return; // Stop the function if validation fails
            }
            if(made === ''){
                alert("Please select an made.");
                    return;
            }

            // If validation passes, continue with AJAX request
            $.ajax({
                url: 'insertDataToCar.php',
                type: 'POST',
                data: {
                    name: name,
                    model: model,
                    year: year,
                    made: made
                },
                success: function(response) {
                    alert(response);
                    if (response.indexOf("Record inserted successfully") !== -1) {
                        // Assuming your server responds with "Record inserted successfully"
                        var newRow = '<tr>' +
                            '<td>' + name + '</td>' +
                            '<td>' + model + '</td>' +
                            '<td>' + year + '</td>' +
                            '<td>' + made + '</td>' +
                            '</tr>';
                        $('table').append(newRow);
                        // Clear the input fields
                        $('#name').val('');
                        $('#model').val('');
                        $('#year').val('');
                        $('#made').val('');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.status + ' ' + error);
                }
            });
        });
        $(document).on('click', '.edit-btn', function() {
                var row = $(this).closest('tr').find('td');
                $('#edit-name').val(row.eq(0).text());
                $('#edit-model').val(row.eq(1).text());
                $('#edit-year').val(row.eq(2).text());
                $('#edit-made').val(row.eq(3).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var name = $('#edit-name').val();
                var model = $('#edit-model').val();
                var year = $('#edit-year').val();
                var made = $('#edit-made').val();

                if (!$.isNumeric(year)) {
                alert("Please enter a valid number for 'year'");
                return; // Stop the function if validation fails
            }

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateCar.php',
                    type: 'POST',
                    data: {
                        name: name,
                        model: model,
                        year: year,
                        made: made,
                        
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    // Find the row with the matching ID and update its contents
    $('#carTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-id').text() === name) {
            row.find('.row-building').text(model);
            row.find('.row-street').text(year);
            row.find('.row-city').text(made);
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
