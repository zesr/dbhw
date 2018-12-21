<?php
include('connectvars.php');
session_start();
$err_msg = '';
if(isset($_POST['action'])){
	$code=trim($_POST["passcode"]);
	$uid=trim($_POST["uid"]);
	$password=trim($_POST["password"]);
	if($code != $_SESSION["passcode"]){
		$err_msg = "Verification code error";
	}
	elseif($uid=='' || $password==''){
		$err_msg = "Username or Password is invalid";  
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
		$uid = $connection->real_escape_string($uid);
		$password = $connection->real_escape_string($password);

		$query="select * from user where password='$password' AND uid='$uid'";
		$result = $connection->query($query);
		if( !$result ){
			die('mysql error');
		}
		if( mysqli_num_rows($result)<=0 ){
			$err_msg = "No matching record found, please retype your info";
		}
		$rows = $result->fetch_assoc();

		if ($rows) {
			$_SESSION['userinfo']=array(
				'uid'=>$uid,
				'uname'=>$rows['uname']
			);
			header("location: ../index.html"); // Redirecting To Other Page
		} 
		else {
			$err_msg = "Username or Password is invalid";
		}
		$connection->close(); // Closing Connection
	}
}
else{
	$err_msg="error access!";
}
if($err_msg!=''){
	echo "<script>alert('$err_msg')</script>";
	echo "<script>javascript:history.go(-1);</script>";
}
?>