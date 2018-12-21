<?php
include('connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: ../signInUp.html");
}

if(!isset($_POST['session_id'])){
    echo "<script>alert('invalid access!');window.location.href = 'index.html';</script>";
}
else{
    $session_id = trim($_POST['session_id']);
    $uid = trim($_SESSION['userinfo']['uid']);
    $entry_time = trim($_POST['time']);
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if ($connection->connect_errno) {
        echo "Sorry, this website is experiencing problems.";
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $connection->connect_errno . "\n";
        echo "Error: " . $connection->connect_error . "\n";
        exit;
    }

    $query = "select sessionId from session where sessionId = $session_id AND sessionId NOT IN (SELECT sessionId from userorder where valid = 1)";
    $result = $connection->query($query);
    if( !$result ){
        die('mysql error');
    }
    if( mysqli_num_rows($result)<=0 ){
        echo "<script>alert('error sessionId');window.location.href = 'index.html';</script>";
    }
    //check session id
    $query = "Select S.price FROM SESSION SE,STADIUM S,FIELD F WHERE SE.FIELDID = F.FIELDID AND F.STADIUMID = S.STADIUMID AND SE.sessionId = $session_id";
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
    //get the price of this bill

    $query = "select max(oid) from userorder";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();
    $max_oid = intval($row['max(oid)']);
    $oid = $max_oid+1;
    //get the oid of this order

    $query = "select balance from user where uid = $uid;";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();
    $balance = floatval($row['balance']);

//    余额不足
    if($balance<$price){
        echo "<script>alert('your balance is not enough!please go to recharge.');window.location.href = 'profile.php';</script>";
        exit;
    }else{
        $new_balance = $balance-$price;
    }


    $query = "insert INTO userorder (oid,sessionid,uid,entrytime,booktime,valid) VALUES ($oid,$session_id,$uid,'$entry_time', CURRENT_TIMESTAMP,'1');";
    $result = $connection->query($query);
    if( !$result ){
        echo "<script>alert('insert error！');window.location.href = 'index.html';</script>";
    }
    else{
        $tomorrow=date("Y-m-d",strtotime("1 day"))." 00:00:00";
        $query = "create event e_$oid on schedule at str_to_date('$tomorrow', '%Y-%m-%d %H:%i:%s') do update userorder set valid = 0 where oid = $oid;";
        $result = $connection->query($query);
        if( !$result ){
            echo "<script>alert('$tomorrow');window.location.href = 'index.html';</script>";
            exit;
        }
        $query = "update user set balance = $new_balance where uid = $uid";
        $result = $connection->query($query);
        if( !$result ){
            echo "<script>alert('Sorry, there are some exceptions！');window.location.href = 'index.html';</script>";
            exit;
        }
        else{
            echo "<script>alert('Booking successful!！');</script>";
        }
    }
    //insert the order
    //get the new balance
}
    //需要获取session_id,获取userid,根据session_id找到价格，
    //接着插入订单，用户扣钱

?>