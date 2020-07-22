<?php
include('session_client.php');
if(!isset($_SESSION['login_client'])){
    session_destroy();
    header("location: clientlogin.php");
}
//require 'connection.php';
$conn = Connect();
$error="";
if (isset($_POST['submit'])) {
  $driver_name = $conn->real_escape_string($_POST['driver_name']);
  $dl_number = $conn->real_escape_string($_POST['dl_number']);
  $driver_phone = $conn->real_escape_string($_POST['driver_phone']);
  $driver_address = $conn->real_escape_string($_POST['driver_address']);
  $driver_gender = $conn->real_escape_string($_POST['driver_gender']);
  $client_username = $_SESSION['login_client'];
  $driver_availability = "yes";

  $query = "INSERT into driver(driver_name,dl_number,driver_phone,driver_address,driver_gender,client_username,driver_availability) VALUES('" . $driver_name . "','" . $dl_number . "','" . $driver_phone . "','" . $driver_address . "','" . $driver_gender ."','" . $client_username ."','" . $driver_availability ."')";
  $success = $conn->query($query);
  if(!$success){
    $error="Driver with the same License number already exists!";
  }
}

if (isset($_GET['rem'])) {
  $id = $conn->real_escape_string($_GET['rem']);
  $query = "DELETE FROM driver WHERE driver_id=?";
  $stmt = $conn->prepare($query);
  $stmt -> bind_param("s", $id);
  $sucess=$stmt -> execute();
  if(!$sucess){
    $error="Driver can`t be removed. Driver is Booked!";
  }
  else{
    $error="Driver Removed!";
  }  
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
      <title> Enter Driver | Car Rental </title>

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
<body>
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
              <li> <a href="entercar.php">Add/Remove Car</a></li>
              <li> <a href="enterdriver.php"> Add/Remove Driver</a></li>
              <li> <a href="clientview.php">View Bookings</a></li>

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
                    <li>
                        <a href="#">History</a>
                    </li>
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

    <div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="enterdriver.php" method="POST">
        <br style="clear: both">
          <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> Enter Driver Details </h3>

          <div class="form-group">
            <input type="text" class="form-control" id="driver_name" name="driver_name" placeholder="Driver Name " required autofocus="">
          </div>

          <div class="form-group">
            <input type="number" class="form-control" id="dl_number" name="dl_number" placeholder="Driving License Number" required>
          </div>     

          <div class="form-group">
            <input type="number" class="form-control" id="driver_phone" name="driver_phone" placeholder="Contact" required>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="driver_address" name="driver_address" placeholder="Address" required>
          </div>

          <div class="form-group">
            <select class="form-control" id="driver_gender" name="driver_gender" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
            <label style="margin-left: 5px;color: red;"><span> <?php echo $error;  ?> </span></label>
           <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right fa fa-plus-square"> Add Driver</button>   

        </form>
      </div>
    </div>
    <div class="col-md-12" style="float: none; margin: 0 auto;">
    <div class="form-area" style="padding: 0px 100px 100px 100px;">
    <form action="" method="POST">
        <br style="clear: both">
          <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> Your Drivers </h3>
<?php
// Storing Session
$conn=Connect();
$user_check=$_SESSION['login_client'];
$sql = "SELECT * FROM driver d WHERE d.client_username='$user_check' ORDER BY driver_name";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  ?>
  <div style="overflow-x:auto;">
  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>     </th>
        <th width="15%"> Name</th>
        <th width="5%"> Gender </th>
        <th width="12%"> DL Number </th>
        <th width="10%"> Contact </th>
        <th width="47%"> Address </th>
        <th width="3%"> Availability </th>
        <th width="8%"> Remove</th>
      </tr>
    </thead>

    <?PHP
      //OUTPUT DATA OF EACH ROW
      while($row = mysqli_fetch_assoc($result)){
    ?>

  <tbody>
    <tr>
      <td> <span class="glyphicon glyphicon-menu-right"></span> </td>
      <td><?php echo $row["driver_name"]; ?></td>
      <td><?php echo $row["driver_gender"]; ?></td>
      <td><?php echo $row["dl_number"]; ?></td>
      <td><?php echo $row["driver_phone"]; ?></td>
      <td><?php echo $row["driver_address"]; ?></td>
      <td><?php echo $row["driver_availability"]; ?></td>
      <td><a class="btn btn-primary fa fa-minus-square" href="enterdriver.php?rem=<?php echo $row['driver_id'] ?>" role="button">  Remove Driver</a></td>
    </tr>
  </tbody>
  
  <?php } 
  $conn->close();?>
  </table>
</div>
    <br>


  <?php } else { ?>

  <h4><center>No Drivers to show</center> </h4>

  <?php } ?>

</form>

</div>        
        </div>
    </div>

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