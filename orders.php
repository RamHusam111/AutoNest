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


$carNames = [];
        $query = "SELECT name FROM car";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $carNames[] = $row['name'];
            }
        }

        $customerNums = [];
        $query = "SELECT id FROM customer";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customerNums[] = $row['id'];
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
    <div class= "mmm">
    
    <button class="btn" id="searchButton">Search</button> 
    <input class='c' type="text" id="search" placeholder="Enter ID"> <br>
    <button class="btn" id="insertDataButton">Insert Data</button>
    <input class='c' type="text" id="id" placeholder="Insert id"> 
    <input class='c' type="text" id="date" placeholder="Insert date"> 
<select id='cus' class='c'>
    <option value=''>Select customer</option>
    <?php foreach ($customerNums as $customer): ?>
        <option value="<?= htmlspecialchars($customer) ?>"><?= htmlspecialchars($customer) ?></option>
    <?php endforeach; ?>
</select>
<select id='carName' class='c'>
    <option value=''>Select car</option>
    <?php foreach ($carNames as $carName): ?>
        <option value="<?= htmlspecialchars($carName) ?>"><?= htmlspecialchars($carName) ?></option>
    <?php endforeach; ?>
</select>
<br>
<div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-id" hidden>
        <input  class='c' type="text" id="edit-date" placeholder="Edit date">
        <select id='edit-customer' class='c'>
    <option value=''>Select customer</option>
    <?php foreach ($customerNums as $customer): ?>
        <option value="<?= htmlspecialchars($customer) ?>"><?= htmlspecialchars($customer) ?></option>
    <?php endforeach; ?>
</select>
<select id='edit-car' class='c'>
    <option value=''>Select car</option>
    <?php foreach ($carNames as $carName): ?>
        <option value="<?= htmlspecialchars($carName) ?>"><?= htmlspecialchars($carName) ?></option>
    <?php endforeach; ?>
</select>
        
        
    </div>
</div>
    <br> <br>

    <table id="addressTable">
    <tr>
            <th>id</th>
            <th>date</th>
            <th>customer</th>
            <th>car</th>
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

        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td class='row-building'>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td class='row-street'>" . htmlspecialchars($row['customer']) . "</td>";
                echo "<td class='row-city'>" . htmlspecialchars($row['car']) . "</td>";
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
                    url: 'searchOrders.php', // PHP file to handle search
                    type: 'GET',
                    data: {searchTerm: value},
                    success: function(response) {
                        $('table').html(response); // Update the table with search results
                    }
                });
            });
            $('#insertDataButton').click(function() {
            var id = $('#id').val();
            var date = $('#date').val();
            var customer = $('#cus').val();
            var carName = $('#carName').val();

            // Validate inputs
            if (!$.isNumeric(id)) {
                alert("Please enter a valid number for 'id'");
                return; // Stop the function if validation fails
            }
            if (!$.isNumeric(date)) {
                alert("Please enter a valid number for 'date'");
                return; // Stop the function if validation fails
            }
            if(customer === ''){
                alert("Please select an customer.");
                    return;
            }
            if(carName === ''){
                alert("Please select an car.");
                    return;
            }

            // If validation passes, continue with AJAX request
            $.ajax({
                url: 'insertDataToOrders.php',
                type: 'POST',
                data: {
                    id: id,
                    date: date,
                    customer: customer,
                    carName: carName
                },
                success: function(response) {
                    alert(response);
                    if (response.indexOf("Record inserted successfully") !== -1) {
                        // Assuming your server responds with "Record inserted successfully"
                        var newRow = '<tr>' +
                            '<td>' + id + '</td>' +
                            '<td>' + date + '</td>' +
                            '<td>' + customer + '</td>' +
                            '<td>' + carName + '</td>' +
                            '</tr>';
                        $('table').append(newRow);
                        // Clear the input fields
                        $('#id').val('');
                        $('#date').val('');
                        $('#customer').val('');
                        $('#carName').val('');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.status + ' ' + error);
                }
            });
        });
        $(document).on('click', '.edit-btn', function() {
                var row = $(this).closest('tr').find('td');
                $('#edit-id').val(row.eq(0).text());
                $('#edit-date').val(row.eq(1).text());
                $('#edit-customer').val(row.eq(2).text());
                $('#edit-car').val(row.eq(3).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var id = $('#edit-id').val();
                var date = $('#edit-date').val();
                var customer = $('#edit-customer').val();
                var car = $('#edit-car').val();
                
                if (!$.isNumeric(date)) {
                alert("Please enter a valid number for 'date'");
                return; // Stop the function if validation fails
            }
                

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateOrders.php',
                    type: 'POST',
                    data: {
                        id: id,
                        date: date,
                        customer: customer,
                        car: car
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    // Find the row with the matching ID and update its contents
    $('#addressTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-id').text() === id) {
            row.find('.row-date').text(date);
            row.find('.row-customer').text(customer);
            row.find('.row-car').text(car);
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
