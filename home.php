<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        header{
            width: 100%;
        }
       

       @media (max-width: 462px) {
        .ooo{
            display: flex;
            flex-direction: column;

        }
        
    }
    @media (max-width: 918px) {
    .nav p {
        font-size: 18px; /* Smaller font size for mobile phones */
        
    }
    .nav .btn{
    height: 35px;
    width: 140px;
    font-size: 13px;
    }

    .logo{
        padding-left: 180px;
    }


}

@media (max-width: 740px) {
    .nav p {
        font-size: 15px; /* Smaller font size for mobile phones */
        
    }
    .nav .btn{
    height: 28px;
    width: 95px;
    font-size: 11px;
    }


}
@media (max-width: 650px) {
    .nav p {
        font-size: 10px; /* Smaller font size for mobile phones */   
    }
    .logo{
        padding-left: 180px;
    }
    .nav .btn{
    height: 20px;
    width: 75px;
    font-size: 11px;
    }


}
@media (max-width: 450px) {
    
    .logo{
        padding-left: 80px;
    }

}
@media (max-width: 343px) {
    
    .nav .btn{
    height: 20px;
    width: 75px;
    font-size: 11px;
    }
    .logo{
        padding-left: 30px;
    }

}




        .c{
        font-size: 16px; /* Increase font size */
        width: 220px; /* Set the width for input */
        height: 40px; /* Set the height */
        padding: 5px; /* Optional: add some padding inside the text box */
        margin-left: 2px; /* Add left margin */
    }
    .btn {
        font-size: 16px; /* Increase font size */
        width: 200px; /* Set the width for input */
        height: 50px; /* Set the height */
        padding: 5px; /* Optional: add some padding inside the text box */
        margin-left: 20px; /* Add left margin */
    }

    table {
        
        
        width: 100%; /* Make the table full width */
        max-width: 100%; /* Ensure it doesn't exceed the width of its container */
        font-size: 18px; /* Increase font size */
    }
    th, td {
        padding: 10px; /* Add more padding for table cells */
        text-align: left; /* Align text to the left, optional */
    }

    td, th, tr {
            border: 2px solid #484898;
        }
    </style>

</head>
<body>
    <header>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Husam Database for cars Tables</a> </p>
        </div>
        
        <a href="php/logout.php"> <button class="btn">Log Out</button> </a> 

    </div>
        </header>
        <div class = "ooo">
    <br>
    <button class="btn" id="address">Address</button> &nbsp
    <button class="btn" id="car_part">Car_Part</button> &nbsp
    <button class="btn" id="car">Car</button> &nbsp
    <button class="btn" id="customer">Customer</button> &nbsp
    <button class="btn" id="device">Device</button> &nbsp
    <button class="btn" id="manufacture">Manufacture</button> &nbsp
    <button class="btn" id="orders">Orders</button>  <br> <br><hr> <br> <hr>
    </div>

    <div id="content"></div>

    <script>
    $(document).ready(function(){
        $("#address").click(function(){
            $("#content").load("address.php");
        });
        $("#car_part").click(function(){
            $("#content").load("car_part.php");
        });
        $("#car").click(function(){
            $("#content").load("car.php");
        });
        $("#customer").click(function(){
            $("#content").load("customer.php");
        });
        $("#device").click(function(){
            $("#content").load("device.php");
        });
        $("#manufacture").click(function(){
            $("#content").load("manufacture.php");
        });
        $("#orders").click(function(){
            $("#content").load("orders.php");
        });
        // Repeat for other buttons
    });
    </script>
    
</body>
</html>