<?php
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
    echo "<script>window.location.href = 'signInUp.html';</script>";
    exit;
}
?>