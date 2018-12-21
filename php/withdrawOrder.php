<?php
include('connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: ../signInUp.html");
}

if(!isset($_POST['oid'])){
    echo "<script>alert('invalid access!');window.location.href = 'profile.php';</script>";
}
else{
    $uid = trim($_SESSION['userinfo']['uid']);
    $oid = trim($_POST['oid']);
    $query = "select * from userorder where oid = $oid and uid = $uid";
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
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
    if( mysqli_num_rows($result)<=0 ){
        echo "<script>alert('error sessionId');window.location.href = 'index.html';</script>";
    }
    // check the oid 
    $query = "Select S.price FROM userorder o,SESSION SE,STADIUM S,FIELD F WHERE o.sessionId = se.sessionId AND SE.FIELDID = F.FIELDID AND F.STADIUMID = S.STADIUMID AND o.oid = $oid";
    $result = $connection->query($query);
    if( !$result ){
        die('mysql error');
    }
    if( mysqli_num_rows($result)<=0 ){
        echo "<script>alert('error sessionId');window.location.href = 'index.html';</script>";
        exit;
    }
    $row = $result->fetch_assoc();
    $price = floatval($row['price']);

//获取剩余金钱
    $query = "select balance from user where uid = $uid;";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();
    $balance = floatval($row['balance']);

    //剩余金钱不足
    if($balance<$price){
        echo "<script>alert('your balance is not enough!please go to recharge.');window.location.href = 'profile.php';</script>";
        exit;
    }else{
        $new_balance = $balance+$price;
    }
    //check the money

//    删除对应数据
    $query = "delete from userorder where oid = $oid";
    $result = $connection->query($query);
    if( !$result ){
        echo "<script>alert('Sorry, there are some exceptions！');window.location.href = 'index.html';</script>";
    }
    else{
        $query = "drop event if exists e_$oid;";
        $result = $connection->query($query);
        if( !$result ){
            echo "<script>alert('Sorry, there are some exceptions！');window.location.href = 'index.html';</script>";
            exit;
        }
        $query = "update user set balance = $new_balance where uid = $uid";
        $result = $connection->query($query);
        if( !$result ){
            echo "<script>alert('Sorry, there are some exceptions！');window.location.href = 'index.html';</script>";
            exit;
        }
        else{
            echo "<script>alert('Withdraw successful!！');</script><script>$('#balance_value').text($new_balance);</script>";
        }
    }
}