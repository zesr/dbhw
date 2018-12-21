<?php
session_start();
if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
    echo "<script>alert('error access')</script>";
}
else{
//    删除session中的数据，返回到登录页面
    $_SESSION['userinfo'] = null;
    header("location: ../signInUp.html");
}
?>