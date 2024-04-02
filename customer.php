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


$addressIDs = [];
        $query = "SELECT id FROM address";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $addressIDs[] = $row['id'];
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
    
<div class ="mmm">
    <button class="btn" id="searchButton">Search</button> 
    <input class='c' type="text" id="search" placeholder="Enter ID"> <br>
    <button class="btn" id="insertDataButton">Insert Data</button>
    <input class='c' type="text" id="id" placeholder="Insert id"> 
    <input class='c' type="text" id="f_name" placeholder="Insert f_name"> 
    <input class='c' type="text" id="l_name" placeholder="Insert l_name"> 
    <select id='asx' class='c'>
    <option value=''>Select address</option>
    <?php foreach ($addressIDs as $id): ?>
    <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($id) ?></option>
<?php endforeach; ?>
</select>
    <input class='c' type="text" id="job" placeholder="Insert job"> <br> 
    <div id="updateForm" style="display:none;">
        <button class='btn' id="updateButton">Update</button>
        <input  class='c' type="text" id="edit-id" hidden>
        <input  class='c' type="text" id="edit-f_name" placeholder="Edit f_name">
        <input  class='c' type="text" id="edit-l_name" placeholder="Edit l_name">
        <select id='edit-address' class='c'>
    <option value=''>Select address</option>
    <?php foreach ($addressIDs as $id): ?>
    <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($id) ?></option>
<?php endforeach; ?>
</select>
        <input  class='c' type="text" id="edit-job" placeholder="Edit job">
        
    </div>
    </div>
    <br><br>


    <table id="customerTable">
    <tr>
            <th>id</th>
            <th>f_name</th>
            <th>l_name</th>
            <th>address</th>
            <th>job</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "BigH";

        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM customer";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='row-id'>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td class='row-f_name'>" . htmlspecialchars($row['f_name']) . "</td>";
                echo "<td class='row-l_name'>" . htmlspecialchars($row['l_name']) . "</td>";
                echo "<td class='row-address'>" . htmlspecialchars($row['address']) . "</td>";
                echo "<td class='row-job'>" . htmlspecialchars($row['job']) . "</td>";
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
                    url: 'searchCustomer.php', 
                    type: 'GET',
                    data: {searchTerm: value},
                    success: function(response) {
                        $('table').html(response); 
                    }
                });
            });
            $('#insertDataButton').click(function() {
            var id = $('#id').val();
            var f_name	 = $('#f_name').val();
            var l_name = $('#l_name').val();
            var address = $('#asx').val(); 
            var job = $('#job').val();
            

            if (!$.isNumeric(id)) {
                alert("Please enter a valid number for 'no'");
                return; 
            }
            if(address === ''){
                alert("Please select an address.");
                    return;
            }
            
            $.ajax({
                url: 'insertDataToCustomer.php',
                type: 'POST',
                data: {
                    id: id,
                    f_name: f_name,
                    l_name: l_name,
                    address: address,
                    job: job
                },
                success: function(response) {
                    alert(response);
                    if (response.indexOf("Record inserted successfully") !== -1) {
                        var newRow = '<tr>' +
                            '<td>' + id + '</td>' +
                            '<td>' + f_name + '</td>' +
                            '<td>' + l_name + '</td>' +
                            '<td>' + address + '</td>' +
                            '<td>' + job + '</td>' +
                            '</tr>';
                        $('table').append(newRow);
                        // Clear the input fields
                        $('#id').val('');
                        $('#f_name').val('');
                        $('#l_name').val('');
                        $('#asx').val('');
                        $('#job').val('');
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
                $('#edit-f_name').val(row.eq(1).text());
                $('#edit-l_name').val(row.eq(2).text());
                $('#edit-address').val(row.eq(3).text());
                $('#edit-job').val(row.eq(4).text());
                $('#updateForm').show();
            });

            // Update button event handler
            $('#updateButton').click(function() {
                // Collect data from the update form
                var id = $('#edit-id').val();
                var f_name = $('#edit-f_name').val();
                var l_name = $('#edit-l_name').val();
                var address = $('#edit-address').val();
                var job = $('#edit-job').val();

                // Send data to updateAddress.php using AJAX
                $.ajax({
                    url: 'updateCustomer.php',
                    type: 'POST',
                    data: {
                        id: id,
                        f_name: f_name,
                        l_name: l_name,
                        address: address,
                        job: job
                    },
                    success: function(response) {
    alert(response);
    // Hide the update form
    $('#updateForm').hide();

    // Find the row with the matching ID and update its contents
    $('#customerTable tr').each(function() {
        var row = $(this);
        if (row.find('.row-id').text() === id) {
            row.find('.row-f_name').text(f_name);
            row.find('.row-l_name').text(l_name);
            row.find('.row-address').text(address);
            row.find('.row-job').text(job);
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
