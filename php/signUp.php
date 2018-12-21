<?php
include('connectvars.php');
session_start();
$err_msg = '';

$uid=trim($_POST["uid"]);
$password=trim($_POST["password"]);
$uname=trim($_POST["uname"]);
$phone=trim($_POST["phone"]);
$balance = "0";

if($uid=='' || $password=='' || $uname==''||$phone==''){
    $err_msg = "you should fill up the form ^_^";  
}
else{
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if ($connection->connect_errno) {
		echo "Sorry, this website is experiencing problems.";
		echo "Error: Failed to make a MySQL connection, here is why: \n";
   		echo "Errno: " . $connection->connect_errno . "\n";
   		echo "Error: " . $connection->connect_error . "\n";
   		exit;
	}
	$uid = stripslashes($uid);
    $password = stripslashes($password);
    $uname = stripslashes($uname);
    $phone = stripslashes($phone);
    $balance = stripslashes($balance);

	$uid = $connection->real_escape_string($uid);
    $password = $connection->real_escape_string($password);
    $uname = $connection->real_escape_string($uname);
    $phone = $connection->real_escape_string($phone);
    $balance = $connection->real_escape_string($balance);

	$query="select * from user where uid='$uid'";
    $result = $connection->query($query);
    
	if( !$result ){
        die('mysql error');
	}
	if( mysqli_num_rows($result)>0 ){
		$err_msg = "User already exists!";
    }
    else{
        $query = "insert into user (uid,uname,balance,password,phone) values('$uid', '$uname','$balance','$password','$phone')";
        $result = $connection->query($query);
        if($result)
        {  
            echo "<script>alert('Sign in successful!');history.back(-1);</script>";
        }  
        else  
        {  
            echo "<script>alert('Sorry, there are some exceptions！'); history.go(-1);</script>";  
        } 
    }
	$connection->close(); // Closing Connection
}
if($err_msg!=''){
	echo "<script>alert('$err_msg')</script>";
	echo "<script>javascript:history.back(-1);</script>";
}
?>