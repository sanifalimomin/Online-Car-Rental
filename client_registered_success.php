<html>

  <head>
    <title> Client Signup | Car Rental </title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
</head>

  <link rel="stylesheet" type = "text/css" href ="assets/css/manager_registered_success.css">
  <link rel="stylesheet" type = "text/css" href ="assets/bootstrap/css/bootstrap.min.css">
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

  <body>

  <!--Back to top button..................................................................................-->
    <button onclick="topFunction()" id="myBtn" title="Go to top">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </button>
  <!--Javacript for back to top button....................................................................-->
    <script type="text/javascript">
      window.onscroll = function()
      {
        scrollFunction()
      };

      function scrollFunction(){
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          document.getElementById("myBtn").style.display = "block";
        } else {
          document.getElementById("myBtn").style.display = "none";
        }
      }

      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>

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

            <?php
                if(isset($_SESSION['login_client'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="entercar.php">Add Car</a></li>
              <li> <a href="enterdriver.php"> Add Driver</a></li>
              <li> <a href="clientview.php">View</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>
            
            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Garagge <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="prereturncar.php">Return Now</a></li>
              <li> <a href="mybookings.php"> My Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
            }
                else {
            ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="clientlogin.php">Client</a>
                    </li>
                    <li>
                        <a href="customerlogin.php">Customer</a>
                    </li>
                    <li>
                        <a href="#"> FAQ </a>
                    </li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<?php

require 'connection.php';
$conn = Connect();
$i=0;
$client_name = $conn->real_escape_string($_POST['client_name']);
$client_username = $conn->real_escape_string($_POST['client_username']);
$client_email = $conn->real_escape_string($_POST['client_email']);
$client_phone = $conn->real_escape_string($_POST['client_phone']);
$client_address = $conn->real_escape_string($_POST['client_address']);
$client_password = md5($conn->real_escape_string($_POST['client_password']));
$pass_code=md5(rand(0,10000));
//checking email
// SQL query to fetch information of registerd users and finds user match.
$query = "SELECT client_email, pass_code, client_username FROM clients WHERE client_email=? OR pass_code=? OR client_username=?";

// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($query);
$stmt -> bind_param("sss", $client_email, $pass_code,$client_username);
$stmt -> execute();
$stmt -> bind_result($customer_email, $pass_code,$customer_username);
$stmt -> store_result();

if($stmt -> affected_rows == 0){
$query = "INSERT into clients(client_name,client_username,client_email,client_phone,client_address,client_password,pass_code,auth) VALUES('" . $client_name . "','" . $client_username . "','" . $client_email . "','" . $client_phone . "','" . $client_address ."','" . $client_password ."','" . $pass_code ."','No')";
$success = $conn->query($query);

if (!$success){
	die("Couldnt enter data: ".$conn->error);
}
else{
    $email=$client_email;
    $url="http://localhost/carproject/verify_email.php?cd=cl".$pass_code;
    $subject="Email Verification";
    $body="<div><h1>Email Verification</h1><h2>" . $client_username. "</h2>,<br><br><h3>Click the <a href='".$url."'>Link</a> to Verify Email</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
    $altbody=$client_username. " , Click this link to Verify Email". $url. "Regards, Admin, Car Rental.";
    require_once("email.php");
}
}
else{
  $i=1;
}
$conn->close();



if($i==0){
?>

<div class="container">
	<div class="jumbotron" style="text-align: center;">
		<h2> <?php echo "Welcome $client_name!" ?> </h2>
		<h1>Your account has been created.</h1>
    <h2>Please Verify Email by clicking link in Email</h2>
		<p>Login Now from <a href="clientlogin.php" style="color: #6699ff;">HERE</a></p>
	</div>
</div>

    </body>
    <footer class="site-footer">
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <h5>Car Rental</h5>
            </div>
        </div>
    </div> 
<?php 
}
else{
 ?>

<div class="container">
  <div class="jumbotron" style="text-align: center;">
    <h2> Duplicate Email or Username </h2>
    <h1>Try Again.</h1>
    <p>SignUp <a href="clientsignup.php">HERE</a></p>
  </div>
</div>

</body>
<?php } ?>
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