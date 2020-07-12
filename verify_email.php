<?php 
require 'connection.php';
$conn = Connect();
$error="";
$type="";
$i=1;
$check=0;
if(isset($_GET['cd']) && !empty($_GET['cd'])){

    $hash = $conn->real_escape_string($_GET['cd']);
    $pass_code= substr($hash, 2);
    $type=substr($hash, 0,2);
    if($type=="cu"){
        $query = "SELECT pass_code FROM customers WHERE pass_code=?";
        $i=0;
    }
    elseif ($type=="cl") {
        $query = "SELECT pass_code FROM clients WHERE pass_code=?";
        $i=0;
    }

    if($i==0){
    // To protect MySQL injection for Security purpose
    $stmt2 = $conn->prepare($query);
    $stmt2 -> bind_param("s", $pass_code);
    $stmt2 -> execute();
    $stmt2 -> bind_result($pass_code);
    $stmt2 -> store_result();
    $newpass=$pass_code;
    //$newpass=md5(rand(0,10000));
    if($type=="cu"){
        $query = "UPDATE customers SET auth = 'Yes' , pass_code=? WHERE pass_code = ?";
    }
    elseif ($type=="cl") {
        $query = "UPDATE clients SET auth='Yes' , pass_code=? WHERE pass_code = ?";
    }
    $stmt = $conn->prepare($query);
    $stmt -> bind_param("ss", $newpass,$pass_code);
    $stmt -> execute();
    if ($stmt -> affected_rows != 0)  //fetching the contents of the row
    {
        $check=1;   
    }
    }
}

?>
<!DOCTYPE html>
    <html>

    <head>
        <title>  Email Verification | Car Rental </title>
        <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/clientlogin.css">
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
                    
                        <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<?php
if($check==1){
if($i==0 && $stmt2->fetch() ){
?>
         <div class="container" style="margin-top: 60px;margin-bottom: 60px;">
            <div class="jumbotron">
                <h1> </span>
                </h1>
                <br>
                <p>Email Verification Successful</p>
                <div class="col-xs-4">
                    <?php if($type=="cl"){ ?>
                    <a class="btn btn-primary" href="clientlogin.php" role="button">Login</a>
                    <?php }
                    elseif ($type=="cu") {
                    ?>
                    <a class="btn btn-primary" href="customerlogin.php" role="button">Login</a>
                    <?php } ?>
                </div>
                <br>
            </div>
        </div>

    </body>

    <?php
    }
    mysqli_close($conn); }
    ?>
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