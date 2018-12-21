<?php
include('php/connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: signInUp.html");
}
$uname = $_SESSION['userinfo']['uname'];
$uid = $_SESSION['userinfo']['uid'];
$connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($connection->connect_errno) {
	echo "Sorry, this website is experiencing problems.";
	echo "Error: Failed to make a MySQL connection, here is why: \n";
   	echo "Errno: " . $connection->connect_errno . "\n";
   	echo "Error: " . $connection->connect_error . "\n";
   	exit;
}
$query="select * from user where uid='$uid'";
$result = $connection->query($query);
if( !$result ){
    die('mysql error');
}
else{
    $rows = $result->fetch_assoc();
//    查询失败则返回登录界面
    if($rows){
        $balance = $rows['balance'];
        $phone = $rows['phone'];
    }
    else{
        header("location: signInUp.html");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link type="text/css" rel="stylesheet" href="css/profile.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User profile</title>
</head>
<body>

<!--导航栏-->
    <nav>
        <div class="nav-wrapper pink darken-4">
            <div class="container">
                <a href="index.html" class="brand-logo">
                    <div id="logo-div"></div>
                </a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="index.html">Booking hall</a></li>
                    <li><a href="introduce.html">Stadium introduce</a></li>
                    <li><a href="about.html">About us</a></li>
                    <li><a id="username"></a></li>
                     <!-- Dropdown Trigger of user -->
                    <li class="active">
                        <a class='dropdown-button' href='#' data-activates='dropdown1'>
                            <i class="material-icons">person</i>
                        </a>
                    </li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="index.html"><i class="material-icons">home</i>Booking hall</a></li>
                    <li><a href="introduce.html"><i class="material-icons">description</i>Stadium introduce</a></li>
                    <li><a href="about.html"><i class="material-icons">group</i>About us</a></li>
                    <li  class="active"><a href="profile.php"><i class="material-icons">account_circle</i>User profile</a></li>
                    <li><a href="php/logout.php"><i class="material-icons">keyboard_arrow_right</i>exit</a></li>
                </ul>
                <!-- Dropdown Structure of user  -->
                <ul id='dropdown1' class='dropdown-content'>
                    <li  class="active"><a href="profile.php"><i class="material-icons">account_circle</i>profile</a></li>
                    <li><a href="php/logout.php"><i class="material-icons">keyboard_arrow_right</i>exit</a></li>
                </ul>
            </div>
        </div>
    </nav>
<!--导航栏-->

<!--欢迎标语-->
        <div class="row">
                <div class="slider">
                    <ul class="slides">
                        <li>
                        <img src="images/user_slogan.jpg" id="slogan">

                        <div class="caption center-align">
                            <h2 class="pink-text text-darken-2">User center</h2>
                            <h4 class="light pink-text text-darken-4">check your info and order there</h4>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

<!--用户资料模块-->
    <div class="page_container">
        <div class="row">
            <div class="col s10 m8 l3 offset-s1 offset-m2">
                <div class="card">
                    <div class="card-content pink-text darken-4">
                        <span class="card-title">User info</span>

                        <table class="table" id="user_info_table">
                            <tr>
                                <td>School id:</td>
                                <td id="uid"><?php echo $uid ?></td>
                            </tr>
                            <tr>
                                <td>User Name:</td>
                                <td><?php echo $uname ?></td>
                            </tr>
                            <tr>
                                <td>Telephone:</td>
                                <td><?php echo $phone ?></td>
                            </tr>
                            <tr>
                                <td>Balance:</td>
                                <td id="balance_value"><?php echo $balance ?></td>
                            </tr>
                        </table>
                    </div>

<!--                    充值-->
                    <div class="card-action">
                        <a class="waves-effect waves-light btn modal-trigger" href="#modal1"><i class="material-icons left">add</i>recharge</a>
                    </div>
                </div>
            </div>

<!--            订单-->
            <div class="col s10 m8 l9 offset-s1 offset-m2">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons">assignment_late</i> Today Order</span>
                        <div id="valid_order">
                            <table class="responsive-table bordered" id="valid_order_table"></table>
                        </div>
                    </div>
                </div>

<!--                历史订单    -->
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons">assignment_turned_in</i> History Order</span>
                        <div id="history_order">
                            <table class="responsive-table bordered" id="history_order_table"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Recharge page</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">attach_money</i>
                        <input type="number" name="money" id="money">
                        <label for="money">Recharge amount</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect yellow btn" id="recharge">recharge</a>
            </div>
        </div>

        <div id="msg"></div>
    </div>

<!--下边栏-->
    <footer class="page-footer pink darken-4">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">SZU stadium e-booking system</h5>
                    <p class="grey-text text-lighten-4">
                        This system is to strengthen the physical fitness of students and build, daily exercise, enjoy a healthy life.
                    </p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li>
                            <a class="grey-text text-lighten-3" href="http://www.szu.edu.cn/">SZU official website</a>
                        </li>
                        <li>
                            <a class="grey-text text-lighten-3" href="http://www1.szu.edu.cn/">SZU inner website</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © Life is fantasy.
                <a class="grey-text text-lighten-4 right" href="#!"></a>
            </div>
        </div>
    </footer>
</body>

<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    $(function(){
        //初始化
        $(".button-collapse").sideNav();
        $('.dropdown-button').dropdown('close');
        $('#username').load("php/getUserInfo.php");
        $('.dropdown-button').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrainWidth: false, // Does not change width of dropdown to that of the activator
                hover: false, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'left', // Displays dropdown with edge aligned to the left of button
                stopPropagation: false // Stops event propagation
              }
            );
        $('.modal').modal();
        $('.slider').slider();
        $('.indicators').hide();
        //充值功能实现
        $("#recharge").click(function(){
            var money = $('#money').val();
            $.post('php/recharge.php',{money:money},function(data) { 
                $("#balance_value").html(data);
            }) 
            Materialize.toast('balance +'+money, 2000)
        });
        $("#valid_order_table").load("php/getOrder.php",{"valid":"1"});
        $("#history_order_table").load("php/getOrder.php",{"valid":"0"});
    })
</script>
</html>