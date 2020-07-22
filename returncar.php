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
<title> Car Return | Car Rental </title>
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
<?php
function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}
 $id = $_GET["id"];
 $sql1 = "SELECT c.car_name, c.car_nameplate, rc.rent_start_date, rc.rent_end_date, rc.fare, rc.charge_type, d.driver_name, d.driver_phone,c.car_id,d.driver_id,rc.booking_date FROM rentedcars rc, cars c, driver d WHERE id = '$id' AND c.car_id=rc.car_id AND (d.driver_id = rc.driver_id OR rc.driver_id IS NULL)";
 $result1 = $conn->query($sql1);
 if (mysqli_num_rows($result1) > 0) {
    while($row = mysqli_fetch_assoc($result1)) {
        $car_name = $row["car_name"];
        $car_nameplate = $row["car_nameplate"];
        $driver_name = $row["driver_name"];
        $driver_phone = $row["driver_phone"];
        $rent_start_date = $row["rent_start_date"];
        $rent_end_date = $row["rent_end_date"];
        $fare = $row["fare"];
        $charge_type = $row["charge_type"];
        $car_id=$row["car_id"];
        $driver_id=$row["driver_id"];
        $booking_date=$row["booking_date"];
        $no_of_days = dateDiff("$rent_start_date", "$rent_end_date");
    }
}
if(mysqli_num_rows($result1)>1){
    $driver_id=NULL;
    $driver_name="";
    $driver_phone="";
}
$err_date = dateDiff("$rent_start_date",date("Y-m-d") );
if($err_date>=0){
?>
    <div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="printbill.php?id=<?php echo $id ?>&type=R" method="POST">
        <br style="clear: both">
          <h3 style="margin-bottom: 5px; text-align: center; font-size: 40px;"> Journey Details </h3>
          <h6 style="margin-bottom: 25px; text-align: center; font-size: 15px;"> Allow your driver to fill the below form </h6>

           <h5> Car:&nbsp;  <?php echo $car_name;?></h5>

           <h5> Vehicle Number:&nbsp;  <?php echo($car_nameplate);?></h5>

           <h5> Rent date:&nbsp;  <?php echo($rent_start_date);?></h5>

           <h5> End Date:&nbsp;  <?php echo($rent_end_date);?></h5>

           <h5> Fare:&nbsp;Rs. <?php 
            if($charge_type == "days"){
                    echo ($fare . "/day");
                } else {
                    echo ($fare . "/km");
                }
            ?>
            </h5>
            <?php if($driver_name!="") {?>
           <h5> Driver Name:&nbsp;  <?php echo($driver_name);?></h5>

           <h5> Driver Contact:&nbsp;  <?php echo($driver_phone);?></h5>
          <?php }if($charge_type == "km") { ?>
          <div class="form-group">
            <input type="text" class="form-control" id="distance_or_days" name="distance_or_days" placeholder="Enter the distance travelled (in km)" required="" autofocus>
          </div>
          <?php }  else { ?>
            <h5> Number of Day(s):&nbsp;  <?php echo($no_of_days);?></h5>
            <input type="hidden" name="distance_or_days" value="<?php echo $no_of_days; ?>">
          <?php } ?>
          <input type="hidden" name="hid_fare" value="<?php echo $fare; ?>">

           <input type="submit" name="submit" value="submit" class="btn btn-primary pull-right">    
        </form>
      </div>
    </div>
   
    </div>
<?php } 
else{
?>
<div class="container">
<div class="col-md-12" style="float: none; margin: 50px auto; margin-bottom: 10px;">
<div class="form-area" style="padding: 50px 100px 50px 100px; margin: 0px">
    <h3 style="text-align: center; font-size: 40px; margin-top: 40px;"> Cancellation Done!</h3>
    <p style="margin-bottom: 40px; text-align: center; font-size: 20px;">Hope you enjoyed our service </p>
</div></div></div>
<?php 
$login_customer = $_SESSION['login_customer'];
$no_of_days = 0;
$total_amount=0;
$car_return_date = date('Y-m-d');
$return_status = "C";



$sql1="INSERT INTO returncars (customer_username, car_id,driver_id, booking_date, rent_start_date, rent_end_date, fare, charge_type,no_of_days,total_amount, return_status,car_return_date) VALUES ('" . $login_customer . "','" . $car_id . "','" . $driver_id . "','" .$booking_date ."','" . $rent_start_date ."','" . $rent_end_date . "','" . $fare . "','" . $charge_type . "','" . $no_of_days . "','" . $total_amount . "','" . $return_status . "','" . $car_return_date . "')";
$result1 = $conn->query($sql1);

if ($result1){
    $sql11="DELETE FROM rentedcars WHERE id='".$id."'";
    $result11= $conn->query($sql11);
    $sql2 = "UPDATE cars c SET c.car_availability='yes' WHERE c.car_id='$car_id'";
    $result2 = $conn->query($sql2);
    if($driver_id!=NULL){
        $sql22 = "UPDATE drivers c SET c.driver_availability='yes' WHERE c.driver_id='$driver_id'";
        $result222 = $conn->query($sql22);
     
    }    
}
else {
    echo $result1;
    echo $conn->error;
}

} ?>
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