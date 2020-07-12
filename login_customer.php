<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
if (empty($_POST['customer_username']) || empty($_POST['customer_password'])) {
$error = "Username or Password is invalid";
}
else
{
// Define $username and $password
$customer_username=$_POST['customer_username'];
$customer_password=md5($_POST['customer_password'])	;
$auth="";
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
require 'connection.php';
$conn = Connect();

// SQL query to fetch information of registerd users and finds user match.
$query = "SELECT customer_username, customer_password , auth FROM customers WHERE customer_username=? AND customer_password=? LIMIT 1";

// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($query);
$stmt -> bind_param("ss", $customer_username, $customer_password);
$stmt -> execute();
$stmt -> bind_result($customer_username, $customer_password,$auth);
$stmt -> store_result();

if ($stmt->fetch())  //fetching the contents of the row
{
	if($auth=='Yes'){
		$_SESSION['login_customer']=$customer_username; // Initializing Session
		header("location: index.php"); // Redirecting To Other Page
	}
	else{
		$error="Account not Verified!";
	}
} else {
$error = "Username or Password is invalid";
}
mysqli_close($conn); // Closing Connection
}
}
?>