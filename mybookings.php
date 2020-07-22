<!DOCTYPE html>
<html>
<?php 
session_start();
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}
require 'connection.php';
$conn = Connect();
?>
<head>
    <title> Previous Bookings | Car Rental </title>
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
<link rel="stylesheet" type="text/css" href="assets/css/customerlogin.css">
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   CAR RENTAL </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Car Bookings <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="bookcar.php">Book Car</a></li>     
              <li> <a href="prereturncar.php">Return Car</a></li>
              <li> <a href="mybookings.php">Previous Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
 
<?php $login_customer = $_SESSION['login_customer']; 

    $sql1 = "SELECT * FROM returncars rc, cars c
    WHERE rc.customer_username='$login_customer' AND c.car_id=rc.car_id";
    $result1 = $conn->query($sql1);

    if (mysqli_num_rows($result1) > 0) {
?>
<!--start-->

<div class="container">
<div class="col-md-12" style="float: none; margin: 50px auto; margin-bottom: 10px;">
    <div class="form-area" style="padding: 0px 50px 50px 50px;">
        <form action="" method="POST">
        <br style="clear: both">
          <h3 style="text-align: center; font-size: 40px;"> Your Previous Bookings </h3>
          <p style="margin-bottom: 40px; text-align: center; font-size: 20px;">Hope you enjoyed our service </p>
<div style="overflow-x:auto;">
  <table class="table table-striped">
    <thead class="thead-dark">
        <tr>
        <th></th>
        <th width="10%">Car</th>
        <th width="12%">Rent Start Date</th>
        <th width="13%">Rent End Date</th>
        <th width="15%">Fare</th>
        <th width="15%">Distance (in kms)</th>
        <th width="10%">Number of Days</th>
        <th width="15%">Total Amount</th>
        <th width="10%">Return Status</th>
        </tr>
    </thead>
<?php
        while($row = mysqli_fetch_assoc($result1)) {
?>
    <tbody>
    
    <tr>
    <td> <span class="glyphicon glyphicon-menu-right"></span> </td>
    <td><?php echo $row["car_name"]; ?></td>
    <td><?php echo $row["rent_start_date"] ?></td>
    <td><?php echo $row["rent_end_date"]; ?></td>
<td>Rs. <?php 
            if($row["charge_type"] == "days"){
                    echo ($row["fare"] . "/day");
                } else {
                    echo ($row["fare"] . "/km");
                }
            ?></td>
<td><?php  if($row["charge_type"] == "days"){
                    echo ("-");
                } else {
                    echo ($row["distance"]);
                } ?></td>
<td><?php echo $row["no_of_days"]; ?> </td>
<td>Rs. <?php echo $row["total_amount"]; ?></td>
<td><?php 
        if($row['return_status']=='R'){
            echo "Returned";
        }
        else{
            echo "Canceled";
        }
 ?></td>
</tr>
  </tbody>
  <?php } ?>
  </table>
  </div>
    <br>
            </form>
</div>        
</div> 
</div>
  <?php } else { ?>
 <div class="container">
<div class="col-md-12" style="float: none; margin: 50px auto; margin-bottom: 10px;">
<div class="form-area" style="padding: 50px 100px 50px 100px; margin: 0px">
    <h3 style="text-align: center; font-size: 40px; margin-top: 40px;"> No Bookings to show!</h3>
    <p style="margin-bottom: 40px; text-align: center; font-size: 20px;">Hope you enjoyed our service </p>
</div></div></div>
  <?php } 
    $conn->close();
  ?>

</body>
<footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>© 2020 Car Rental. All Right Reserved.</h5>
                </div>
                <div class="col-sm-6">
                  <h5 style="text-align: right;">Developed by: <span style="color:#000000; font-weight:500;">Sanif Ali Momin</span></h5>
                </div>
            </div>
        </div>
</footer>
</html>