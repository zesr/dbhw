<?php
session_start();
if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
    echo "<script>alert('error access')</script>";
}
else{
    $_SESSION['userinfo'] = null;
    header("location: ../signInUp.html");
}
?>