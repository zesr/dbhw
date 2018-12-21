<?php
include('connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	echo "<script>window.location.href = 'signInUp.html';</script>";
}
else{
    $uname = $_SESSION['userinfo']['uname'];
    echo $uname;
}
?>