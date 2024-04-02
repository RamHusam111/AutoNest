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
    <input class='c' type="text" id="search" placeholder="Enter no"> <br>
    <button class="btn" id="insertDataButton">Insert Data</button>
    <input class='c' type="text" id="no" placeholder="Insert no"> 
    <input class='c' type="text" id="name" placeholder="Insert name"> 
    <input class='c' type="text" id="price" placeholder="Insert price"> 
    <input class='c' type="text" id="weight" placeholder="Insert weight"> 
<select id='made' class='c'>
    <option value=''>Select made</option>
    <?php foreach ($manufactureNames as $name): ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
</select><br> 
<div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-no" hidden>
        <input  class='c' type="text" id="edit-name" placeholder="Edit name">
        <input  class='c' type="text" id="edit-price" placeholder="Edit price">
        <input  class='c' type="text" id="edit-weight" placeholder="Edit weight">
        <select id='edit-made' class='c'>
    <option value=''>Select made</option>
    <?php foreach ($manufactureNames as $name): ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
</select>
        
    </div>
</div>
<br><br>
    <table id="deviceTable">
    <tr>
            <th>no</th>
            <th>name</th>
            <th>price</th>
            <th>weight</th>
            <th>made</th>
            <th>Actions</th>
        </tr>
        <?php
        

        $sql = "SELECT * FROM device";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['no']) . "</td>";
                echo "<td class='row-building'>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td class='row-street'>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td class='row-city'>" . htmlspecialchars($row['weight']) . "</td>";
                echo "<td class='row-country'>" . htmlspecialchars($row['made']) . "</td>";
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
                url: 'searchDevice.php', // PHP file to handle search
                type: 'GET',
                data: {searchTerm: value},
                success: function(response) {
                    $('table').html(response); // Update the table with search results
                }
            });
        });

        $('#insertDataButton').click(function() {
            var no = $('#no').val();
            var name = $('#name').val();
            var price = $('#price').val();
            var weight = $('#weight').val();
            var made = $('#made').val();

            // Validate inputs
            if (!$.isNumeric(no)) {
                alert("Please enter a valid number for 'no'");
                return; // Stop the function if validation fails
            }
            if (!$.isNumeric(price)) {
                alert("Please enter a valid number for 'price'");
                return; // Stop the function if validation fails
            }
            if (!$.isNumeric(weight)) {
                alert("Please enter a valid number for 'weight'");
                return; // Stop the function if validation fails
            }

            // If validation passes, continue with AJAX request
            $.ajax({
                url: 'insertDataToDevice.php',
                type: 'POST',
                data: {
                    no: no,
                    name: name,
                    price: price,
                    weight: weight,
                    made: made
                },
                success: function(response) {
                    alert(response);
                    if (response.indexOf("Record inserted successfully") !== -1) {
                        // Assuming your server responds with "Record inserted successfully"
                        var newRow = '<tr>' +
                            '<td>' + no + '</td>' +
                            '<td>' + name + '</td>' +
                            '<td>' + price + '</td>' +
                            '<td>' + weight + '</td>' +
                            '<td>' + made + '</td>' +
                            '</tr>';
                        $('table').append(newRow);
                        // Clear the input fields
                        $('#no').val('');
                        $('#name').val('');
                        $('#price').val('');
                        $('#weight').val('');
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
                $('#edit-no').val(row.eq(0).text());
                $('#edit-name').val(row.eq(1).text());
                $('#edit-price').val(row.eq(2).text());
                $('#edit-weight').val(row.eq(3).text());
                $('#edit-made').val(row.eq(4).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var no = $('#edit-no').val();
                var name = $('#edit-name').val();
                var price = $('#edit-price').val();
                var weight = $('#edit-weight').val();
                var made = $('#edit-made').val();

                if (!$.isNumeric(price)) {
                alert("Please enter a valid number for 'price'");
                return; // Stop the function if validation fails
            }
            if (!$.isNumeric(weight)) {
                alert("Please enter a valid number for 'weight'");
                return; // Stop the function if validation fails
            }

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateDevice.php',
                    type: 'POST',
                    data: {
                        no: no,
                        name: name,
                        price: price,
                        weight: weight,
                        made: made
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    // Find the row with the matching ID and update its contents
    $('#deviceTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-no').text() === no) {
            row.find('.row-name').text(name);
            row.find('.row-price').text(price);
            row.find('.row-weight').text(weight);
            row.find('.row-made').text(made);
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
