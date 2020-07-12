<?php 
require 'connection.php';
$conn = Connect();
$error="";
$type="";
$i=1;
$check=0;
if(isset($_GET['type']) && !empty($_GET['type'])){

    $type = $conn->real_escape_string($_GET['type']);
    if (isset($_POST['submit']) && ($type=='cl' || $type=='cu')) {

        $user=$conn->real_escape_string($_POST['user']);

        if($type=="cu"){
            $query = "SELECT pass_code,customer_email FROM customers WHERE customer_username=? or customer_email=?";
            $i=0;
        }
        elseif ($type=="cl") {
            $query = "SELECT pass_code,client_email FROM clients WHERE client_username=? or client_email=?";
            $i=0;
        }

        if($i==0){
        // To protect MySQL injection for Security purpose
            $stmt2 = $conn->prepare($query);
            $stmt2 -> bind_param("ss", $user,$user);
            $stmt2 -> execute();
            $stmt2 -> bind_result($pass_code,$email);
            $stmt2 -> store_result();
            if($stmt2->fetch()){
                $url="http://localhost/carproject/reset_password.php?cd=".$type.$pass_code;
                $subject="Password Reset";
                $body="<div><h1>Password Reset</h1><h2>" . $user. "</h2>,<br><br><h3>Click the <a href='".$url."'>Link</a> to recover your password</h3><br><br>Regards,<br> Admin, Car Rental.</div>";
                $altbody=$user. " , Click this link to recover your password". $url. "Regards, Admin, Car Rental.";
                require_once("email.php");
                $check=1;
            }
            else{
                $error="Username/Email not found";
            }
        }

    }    
}

?>
<!DOCTYPE html>
    <html>
<h1></h1>
    <head>
        <title> Forget Password | Car Rental </title>
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
<?php if ($check==0) {
 ?>
        <div class="container" style="margin-top:60px; margin-bottom: 2%;">
            <div class="col-md-5 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading"> Forget Password </div>
                    <div class="panel-body">

                        <form action="" method="POST">

                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <label for="client_password"><span class="text-danger" style="margin-right: 5px;">*</span> Username/Email: </label>
                                    <div class="input-group">
                                        <input class="form-control" id="Username" type="text" name="user" placeholder="Username/Email" required="">
                                        <span class="input-group-btn">
                <label class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></label>
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <label style="margin-left: 5px;color: red;"><span> <?php echo $error;  ?> </span></label>
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <button class="btn btn-primary" name="submit" type="submit" value=" Login ">Submit</button>

                                </div>

                            </div>
                            <?php if($type=="cl"){ ?>
                            <label style="margin-left: 5px; color: #6699ff;"><a href="clientlogin.php">Login.</a></label><br>
                            <label style="margin-left: 5px;">or</label> <br>
                            <label style="margin-left: 5px;color: #6699ff;"><a href="clientsignup.php">Create a new account.</a></label>
                            <?php }
                                elseif ($type=="cu") {
                            ?>
                            <label style="margin-left: 5px; color: #6699ff;"><a href="customerlogin.php">Login.</a></label><br>
                            <label style="margin-left: 5px;">or</label> <br>
                            <label style="margin-left: 5px;color: #6699ff;"><a href="customersignup.php">Create a new account.</a></label>
                            <?php 
                                } 
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }
        else{
        ?>
        <div class="container" style="margin-top: 60px;">
            <div class="jumbotron">
                <h1> </span>
                </h1>
                <br>
                <p>Email has been send to <?php echo substr($email,0,2)."*****".substr(strtok($email, '@'),-1).substr($email, strpos($email, '@'),2)."****".substr($email,-1); ?> </p>
                <h4>Click link in email to Reset Password</h4>
            </div>
        </div>
    </body>
    <?php
    }
    mysqli_close($conn); 
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