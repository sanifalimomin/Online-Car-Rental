<!DOCTYPE html>
<html>
<?php 
$check=0;
$error="";
include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}

if (isset($_POST['submit'])) {
    $type = $_POST['radio'];
    $charge_type = $_POST['radio1'];
    $driver_id = $_POST['driver_id_from_dropdown'];
    $customer_username = $_SESSION["login_customer"];
    $car_id = $conn->real_escape_string($_POST['hidden_carid']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
    $rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
    $return_status = "NR"; // not returned
    $fare = "NA";


    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }
    
    $err_date = dateDiff("$rent_start_date", "$rent_end_date");

    $sql0 = "SELECT * FROM cars WHERE car_id = '$car_id'";
    $result0 = $conn->query($sql0);

    if (mysqli_num_rows($result0) > 0) {
        while($row0 = mysqli_fetch_assoc($result0)) {

            if($type == "ac" && $charge_type == "km"){
                $fare = $row0["ac_price"];
            } else if ($type == "ac" && $charge_type == "days"){
                $fare = $row0["ac_price_per_day"];
            } else if ($type == "non_ac" && $charge_type == "km"){
                $fare = $row0["non_ac_price"];
            } else if ($type == "non_ac" && $charge_type == "days"){
                $fare = $row0["non_ac_price_per_day"];
            } else {
                $fare = "NA";
            }
        }
    }
    if($err_date >= 0) { 
    
    $sql2 = "UPDATE cars SET car_availability = 'no' WHERE car_id = '$car_id'";
    $result2 = $conn->query($sql2);

    //without driver
    if($driver_id==0){
        $result3=1;
        $sql1 = "INSERT into rentedcars(customer_username, car_id, booking_date, rent_start_date, rent_end_date, fare, charge_type, return_status)VALUES('" . $customer_username . "','" . $car_id . "','" . date("Y-m-d") ."','" . $rent_start_date ."','" . $rent_end_date . "','" . $fare . "','" . $charge_type . "','" . $return_status . "')";
        $result1 = $conn->query($sql1);
        $sql4 = "SELECT * FROM  cars c, clients cl, rentedcars rc WHERE c.car_id = '$car_id' AND cl.client_username = c.client";
        $result4 = $conn->query($sql4);


        if (mysqli_num_rows($result4) > 0) {
            while($row = mysqli_fetch_assoc($result4)) {
                $id = $row["id"];
                $car_name = $row["car_name"];
                $car_nameplate = $row["car_nameplate"];
                $client_name = $row["client_name"];
                $client_phone = $row["client_phone"];
            }
        }
    }

    //with driver
    else{
        $sql1 = "INSERT into rentedcars(customer_username, car_id,driver_id, booking_date, rent_start_date, rent_end_date, fare, charge_type, return_status)VALUES('" . $customer_username . "','" . $car_id . "','" . $driver_id . "','" . date("Y-m-d") ."','" . $rent_start_date ."','" . $rent_end_date . "','" . $fare . "','" . $charge_type . "','" . $return_status . "')";
        $result1 = $conn->query($sql1);
        $sql3 = "UPDATE driver SET driver_availability = 'no' WHERE driver_id = '$driver_id'";
        $result3 = $conn->query($sql3);

        $sql4 = "SELECT * FROM  cars c, clients cl, driver d, rentedcars rc WHERE c.car_id = '$car_id' AND d.driver_id = '$driver_id' AND cl.client_username = d.client_username";
        $result4 = $conn->query($sql4);


        if (mysqli_num_rows($result4) > 0) {
            while($row = mysqli_fetch_assoc($result4)) {
                $id = $row["id"];
                $car_name = $row["car_name"];
                $car_nameplate = $row["car_nameplate"];
                $driver_name = $row["driver_name"];
                $driver_gender = $row["driver_gender"];
                $dl_number = $row["dl_number"];
                $driver_phone = $row["driver_phone"];
                $client_name = $row["client_name"];
                $client_phone = $row["client_phone"];
            }
        }
    }
    if (!$result1 | !$result2 | !$result3){
        $error="Couldnot Enter Data! R1: ".$result1." r2: ".$result2." r3: ".$result3;
    }
    else{
        $check=1;
    }
}
    else{
        $error="You have selected an incorrect date!";
    }
}
?> 

<head>
    <title> Car Booking | Car Rental </title>
    <script type="text/javascript" src="assets/ajs/angular.min.js"> </script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>  
  <script type="text/javascript" src="assets/js/custom.js"></script> 
 <link rel="stylesheet" type="text/css" media="screen" href="assets/css/clientpage.css" />
</head>
<body ng-app=""> 


      <!-- Navigation -->
     <!-- Navigation -->
     <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">CAR RENTAL</a>
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
<?php if($check==0){ ?>    
<div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="" method="POST">
        <br style="clear: both">
          <h2 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> Rent your Dream Car here!</h2><br>

        <?php
        $car_id = $_GET["id"];
        $sql1 = "SELECT * FROM cars WHERE car_id = '$car_id'";
        $result1 = mysqli_query($conn, $sql1);

        if(mysqli_num_rows($result1)){
            while($row1 = mysqli_fetch_assoc($result1)){
                $car_name = $row1["car_name"];
                $car_nameplate = $row1["car_nameplate"];
                $ac_price = $row1["ac_price"];
                $non_ac_price = $row1["non_ac_price"];
                $ac_price_per_day = $row1["ac_price_per_day"];
                $non_ac_price_per_day = $row1["non_ac_price_per_day"];
            }
        }

        ?>
            <label><h5> Car:&nbsp;  <?php echo($car_name);?></h5></label><br>
            <label><h5> Vehicle Number:&nbsp; <?php echo($car_nameplate);?></h5></label><br>
            <?php $today = date("Y-m-d") ?>
            <label><h5>Start Date:</h5></label>
                <input type="date" name="rent_start_date" min="<?php echo($today);?>" required="">
                &nbsp;
            <label><h5>End Date:</h5></label>
            <input type="date" name="rent_end_date" min="<?php echo($today);?>" required="">

            <label><h5> Choose your car type:  &nbsp;</h5></label>
                <input onclick="reveal()" type="radio" name="radio" value="ac" ng-model="myVar" required> AC &nbsp;
                <input onclick="reveal()" type="radio" name="radio" value="non_ac" ng-model="myVar"> Non-AC
            <br>       
            <label><h5> Choose charge type:  &nbsp;</h5></label>
                <input onclick="reveal()" type="radio" name="radio1" value="km" required> per km(s) &nbsp;
                <input onclick="reveal()" type="radio" name="radio1" value="days"> per day(s)
            <br>

            <div ng-switch="myVar"> 
                <div ng-switch-default>
                    <label><h5>Fare: &nbsp; <h5></label>
                </div>
                <div ng-switch-when="ac">
                    <label><h5>Fare:  &nbsp;<?php echo("Rs. " . $ac_price . "/km and Rs. " . $ac_price_per_day . "/day");?><h5></label> 
                </div>
                <div ng-switch-when="non_ac">
                    <label><h5>Fare: &nbsp; <?php echo("Rs. " . $non_ac_price . "/km and Rs. " . $non_ac_price_per_day . "/day");?><h5></label>  
                </div>
            </div>
            <label><h5>Choose a driver: &nbsp;</h5></label>
                <select id="driver_sel" name="driver_id_from_dropdown" ng-model="myVar1" onchange=" if($('#driver_sel').val()==0){$('input[name=radio1][value=km]').attr('checked', false);$('input[name=radio1][value=days]').attr('checked', true);}">
                    <option value="0" selected>No Driver</option>
                        <?php
                        $sql2 = "SELECT * FROM driver d WHERE d.driver_availability = 'yes' AND d.client_username IN (SELECT cc.client FROM cars cc WHERE cc.car_id = '$car_id')";
                        $result2 = mysqli_query($conn, $sql2);

                        if(mysqli_num_rows($result2) > 0){
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $driver_id = $row2["driver_id"];
                                $driver_name = $row2["driver_name"];
                                $driver_gender = $row2["driver_gender"];
                                $driver_phone = $row2["driver_phone"];
                    ?>
                    
                    <option value="<?php echo($driver_id); ?>"><?php echo($driver_name); ?>
                    <?php }}
                    ?>
                </select>
                <!-- </form> -->
                <div ng-switch="myVar1">
                

                <?php
                        $sql3 = "SELECT * FROM driver d WHERE d.driver_availability = 'yes' AND d.client_username IN (SELECT cc.client FROM cars cc WHERE cc.car_id = '$car_id')";
                        $result3 = mysqli_query($conn, $sql3);

                        if(mysqli_num_rows($result3) > 0){
                            while($row3 = mysqli_fetch_assoc($result3)){
                                $driver_id = $row3["driver_id"];
                                $driver_name = $row3["driver_name"];
                                $driver_gender = $row3["driver_gender"];
                                $driver_phone = $row3["driver_phone"];

                ?>

                <div ng-switch-when="<?php echo($driver_id); ?>">
                    <h5>Driver Name:&nbsp; <?php echo($driver_name); ?></h5>
                    <p>Gender:&nbsp; <?php echo($driver_gender); ?> </p>
                    <p>Contact:&nbsp; <?php echo($driver_phone); ?> </p>
                </div>
                <?php }} ?>
                </div>
                <input type="hidden" name="hidden_carid" value="<?php echo $car_id; ?>">
                
            <label style="margin-left: 5px;color: red;"><span> <?php echo $error;  ?> </span></label>
           <input type="submit"name="submit" value="Book Now" class="btn btn-primary pull-right">     
        </form>
        
      </div>
      <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6><strong>Kindly Note:</strong> You will be charged <span class="text-danger">Rs. 1000/-</span> for each day after the due date.</h6>
        </div>
    </div>
<?php }
elseif($check==1){?>
        <div class="container">
        <div class="jumbotron box">
            <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
        </div>
    </div>
    <br>

    <h2 class="text-center"> Thank you for visiting Car Rental! We wish you have a safe ride. </h2>

 <?php 
        $user=$_SESSION['login_customer'];
        $query = "SELECT customer_email FROM customers WHERE customer_username=?";
        $stmt2 = $conn->prepare($query);
        $stmt2 -> bind_param("s", $user);
        $stmt2 -> execute();
        $stmt2 -> bind_result($email);
        $stmt2 -> store_result();
        if($stmt2->fetch()){
            $email=$email;
        }
        $subject="Booking Confirmation";
        if($driver_id!=0){
            $body="<div><h1>Thank you for visiting Car Rental! We wish you have a safe ride.</h1><h2>Your Order Number:".$id."</h2>,<br><h2>Please read the following information about your order.</h2><br><h3><strong>Vehicle Name: ".$car_name."</h3><br><h3>Vehicle Number: ".$car_nameplate."</h3><br><h3>Fare: ".$fare."/".$charge_type."</h3><br><h3><strong>Booking Date: ".date("Y-m-d")."</h3><br><h3>Start Date: ".$rent_start_date."</h3><br><h3>Return Date: ".$rent_end_date."</h3><br><h3>Client Name: ".$client_name."</h3><br><h3>Client Contact: ".$client_phone."</h3><br><h3>Driver Name: ".$driver_name."</h3><br><h3>Driver Contact: ".$driver_phone."</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
            $altbody="<div><h1>Thank you for visiting Car Rental! We wish you have a safe ride.</h1><h2>Your Order Number:".$id."</h2>,<br><h2>Please read the following information about your order.</h2><br><h3>Vehicle Name: ".$car_name."</h3><br><h3>Vehicle Number: ".$car_nameplate."</h3><br><h3>Fare: ".$fare."/".$charge_type."</h3><br><h3>Booking Date: ".date("Y-m-d")."</h3><br><h3>Start Date: ".$rent_start_date."</h3><br><h3>Return Date: ".$rent_end_date."</h3><br><h3>Client Name: ".$client_name."</h3><br><h3>Client Contact: ".$client_phone."</h3><br><h3>Driver Name: ".$driver_name."</h3><br><h3>Driver Contact: ".$driver_phone."</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
        }
        else{
            $body="<div><h1>Thank you for visiting Car Rental! We wish you have a safe ride.</h1><h2>Your Order Number:".$id."</h2>,<br><h2>Please read the following information about your order.</h2><br><h3>Vehicle Name: ".$car_name."</h3><br><h3>Vehicle Number: ".$car_nameplate."</h3><br><h3>Fare: ".$fare."/".$charge_type."</h3><br><h3>Booking Date: ".date("Y-m-d")."</h3><br><h3>Start Date: ".$rent_start_date."</h3><br><h3>Return Date: ".$rent_end_date."</h3><br><h3>Client Name: ".$client_name."</h3><br><h3>Client Contact: ".$client_phone."</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
            $altbody="<div><h1>Thank you for visiting Car Rental! We wish you have a safe ride.</h1><h2>Your Order Number:".$id."</h2>,<br><h2>Please read the following information about your order.</h2><br><h3>Vehicle Name: ".$car_name."</h3><br><h3>Vehicle Number: ".$car_nameplate."</h3><br><h3>Fare: ".$fare."/".$charge_type."</h3><br><h3>Booking Date: ".date("Y-m-d")."</h3><br><h3>Start Date: ".$rent_start_date."</h3><br><h3>Return Date: ".$rent_end_date."</h3><br><h3>Client Name: ".$client_name."</h3><br><h3>Client Contact: ".$client_phone."</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
        }
        require_once("email.php");
    ?>

    <h3 class="text-center"> <strong>Your Order Number:</strong> <span style="color: blue;"><?php echo "$id"; ?></span> </h3>


    <div class="container">
        <h5 class="text-center">Please read the following information about your order.</h5>
        <div class="box">
            <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
                <h3 style="color: orange;">Your booking has been received and placed.</h3>
                <br>
                <h4>Please make a note of your <strong>order number</strong> now and keep in the event you need to communicate with us about your order.</h4>
                <br>
                <h4>Email of this Invoice is also sent to you.</h4>
                <br>
                <h3 style="color: orange;">Invoice</h3>
                <br>
            </div>
            <div class="col-md-10" style="float: none; margin: 0 auto; ">
                <h4> <strong>Vehicle Name: </strong> <?php echo $car_name; ?></h4>
                <br>
                <h4> <strong>Vehicle Number:</strong> <?php echo $car_nameplate; ?></h4>
                <br>
                
                <?php     
                if($charge_type == "days"){
                ?>
                     <h4> <strong>Fare:</strong> Rs. <?php echo $fare; ?>/day</h4>
                <?php } else {
                    ?>
                    <h4> <strong>Fare:</strong> Rs. <?php echo $fare; ?>/km</h4>

                <?php } ?>

                <br>
                <h4> <strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
                <br>
                <h4> <strong>Start Date: </strong> <?php echo $rent_start_date; ?></h4>
                <br>
                <h4> <strong>Return Date: </strong> <?php echo $rent_end_date; ?></h4>
                <br>
                <h4> <strong>Client Name:</strong>  <?php echo $client_name; ?></h4>
                <br>
                <h4> <strong>Client Contact: </strong> <?php echo $client_phone; ?></h4>
                <br>
                <?php if($driver_id!=0){ ?>
                <h4> <strong>Driver Name: </strong> <?php echo $driver_name; ?> </h4>
                <br>
                <h4> <strong>Driver Contact:</strong>  <?php echo $driver_phone; ?></h4>
                <br>
            <?php } ?>
            </div>
        </div>
        <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6>Warning! <strong>Do not reload this page</strong> or the above display will be lost. If you want a hardcopy of this page, please print it now.</h6>
        </div>
    </div>
<?php } ?>
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