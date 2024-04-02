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

        $partNums = [];
        $query = "SELECT no FROM device";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $partNums[] = $row['no'];
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
    <input class='c' type="text" id="search2" placeholder="Enter car">
    <input class='c' type="text" id="search" placeholder="Enter part"> <br> 
    <button class="btn" id="insertDataButton">Insert Data</button>
    <select id='name' class='c'>
    <option value=''>Select car</option>
    <?php foreach ($carNames as $name): ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
</select>
<select id='no' class='c'>
    <option value=''>Select part</option>
    <?php foreach ($partNums as $no): ?>
        <option value="<?= htmlspecialchars($no) ?>"><?= htmlspecialchars($no) ?></option>
    <?php endforeach; ?>
</select> <br>
<div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <select id='edit-car' class='c'>
    <option value=''>Select car</option>
    <?php foreach ($carNames as $name): ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
</select>
<select id='edit-part' class='c'>
    <option value=''>Select part</option>
    <?php foreach ($partNums as $no): ?>
        <option value="<?= htmlspecialchars($no) ?>"><?= htmlspecialchars($no) ?></option>
    <?php endforeach; ?>
</select> <br>
        
    </div>
<br><br>
</div>
    <table id="carPartTable">
    <tr>
            <th>car</th>
            <th>part</th>
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

        $sql = "SELECT * FROM car_part";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-car'>" . htmlspecialchars($row['car']) . "</td>";
                echo "<td class='row-part'>" . htmlspecialchars($row['part']) . "</td>";
                echo "<td><button class='edit-btn'>Edit</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() { // Updated to use click event
                var partValue = $('#search').val();
                var carValue = $('#search2').val();
                $.ajax({
                    url: 'searchCar_part.php', // PHP file to handle search
                    type: 'GET',
                    data: {
                        part: partValue,
                        car: carValue
        },                    success: function(response) {
                        $('table').html(response); // Update the table with search results
                    }
                });
            });
            $('#insertDataButton').click(function() {
            var name = $('#name').val();
            var no = $('#no').val();
            

            if(name === ''){
                alert("Please select an car.");
                    return;
            }
            if(no === ''){
                alert("Please select an part.");
                    return;
            }

            // If validation passes, continue with AJAX request
            $.ajax({
                url: 'insertDataToCar_Part.php',
                type: 'POST',
                data: {
                    name: name,
                    no: no
                },
                success: function(response) {
                    alert(response);
                    if (response.indexOf("Record inserted successfully") !== -1) {
                        // Assuming your server responds with "Record inserted successfully"
                        var newRow = '<tr>' +
                            '<td>' + name + '</td>' +
                            '<td>' + no + '</td>' +
                            '</tr>';
                        $('table').append(newRow);
                        // Clear the input fields
                        $('#name').val('');
                        $('#no').val('');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.status + ' ' + error);
                }
            });
        });
        $(document).on('click', '.edit-btn', function() {
                var row = $(this).closest('tr').find('td');
                $('#edit-car').val(row.eq(0).text());
                $('#edit-part').val(row.eq(1).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var car = $('#edit-car').val();
                var part = $('#edit-part').val();

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateCar_Part.php',
                    type: 'POST',
                    data: {
                        car: car,
                        part: part
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    //  update  the row its contents
    $('#carPartTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-car').text() === car && row.find('.row-part').text() === part) {
            row.find('.row-car').text(car);
            row.find('.row-part').text(part);
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
