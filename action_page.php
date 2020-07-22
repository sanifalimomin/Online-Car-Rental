<!DOCTYPE html>
<html>
<?php 
session_start(); 
require 'connection.php';
$conn = Connect();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
</head>

<body>
            <!-- Navigation -->
    <nav class="navbar navbar-custom" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="/../Stribon Technologies/index.php">
                   CAR RENTAL </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_client'])){
            ?>
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/carproject/index.php">Home</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_client']; ?></a>
                        </li>
                        <li>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                                    <ul class="dropdown-menu">
                                        <li> <a href="/carproject/entercar.php">Add Car</a></li>
                                        <li> <a href="/carproject/enterdriver.php"> Add Driver</a></li>
                                        <li> <a href="/carproject/clientview.php">View</a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/carproject/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
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
                                <a href="/carproject/index.php">Home</a>
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
                                <a href="/carproject/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
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
                                    <a href="/carproject/index.php">Home</a>
                                </li>
                                <li>
                                    <a href="/carproject/clientlogin.php">Client</a>
                                </li>
                                <li>
                                    <a href="/carproject/customerlogin.php">Customer</a>
                                </li>
                                <li>
                                    <a href="faq/index.html"> FAQ </a>
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
    if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $e_mail = $conn->real_escape_string($_POST['e_mail']);
    $message = $conn->real_escape_string($_POST['message']);
    $type = $conn->real_escape_string($_GET['type']);
    
    if($type=="question"){
        $sql = "INSERT INTO questions values ('" . $name . "','" . $e_mail ."','" . $message ."')";

    }
    elseif($type=="feedback"){
        $sql = "INSERT INTO feedback values ('" . $name . "','" . $e_mail ."','" . $message ."')";
    }

    $success = $conn->query($sql);
    if(!$success) {
        echo $conn->error;
    }
    else { ?>
        <div class="container">
        <div class="jumbotron" style="text-align: center;">
            Thank you for your <?php echo $type ?>!    
            <br><br>
            <a href="index.php" class="btn btn-primary"> Go Back </a>
    </div>
     <?php
    }}
    else{
        echo "string";
    }
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