<?php
include('connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: ../signInUp.html");
}
if(!isset($_POST['money'])||$_POST['money']<=0){
    echo "<script>alert('please input the valid number of money!');window.location.href = 'profile.php';</script>";
}
else{
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $uid = trim($_SESSION['userinfo']['uid']);
    $money = trim($_POST['money']);
    $money = floatval($money);
    $query = "select balance from user where uid = $uid";

    if ($connection->connect_errno) {
		echo "Sorry, this website is experiencing problems.";
		echo "Error: Failed to make a MySQL connection, here is why: \n";
		echo "Errno: " . $connection->connect_errno . "\n";
		echo "Error: " . $connection->connect_error . "\n";
		exit;
    }

    $result = $connection->query($query);
    if( !$result ){
        die('mysql error');
    }
    else{
        $row = $result->fetch_assoc();
        $balance = floatval($row['balance']);
        $new_balance = $balance+$money;
        $query = "update user set balance = $new_balance where uid = $uid";
        $result = $connection->query($query);
        if( !$result ){
            echo "<script>alert('Sorry, there are some exceptions！');window.location.href = 'index.html';</script>";
            exit;
        }
        else{
            echo $new_balance;
        }
    }
}
?>