<?php
include('connectvars.php');
session_start();

if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: ../signInUp.html");
}
if(!isset($_POST['valid'])){
    echo "<script>alert('invalid access!');window.location.href = 'profile.php';</script>";
}
else{
    $return_data = "";
    $uid = trim($_SESSION['userinfo']['uid']);
    $valid = trim($_POST['valid']);
    $query = "select o.oid,F.fieldname,o.entrytime,o.booktime from userorder O,field F,session se where O.uid = $uid AND O.valid = $valid AND se.sessionid = O.sessionid AND f.fieldid=se.fieldid";
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $result = $connection->query($query);
    $plus_col = "";

    if ($connection->connect_errno) {
		echo "Sorry, this website is experiencing problems.";
		echo "Error: Failed to make a MySQL connection, here is why: \n";
		echo "Errno: " . $connection->connect_errno . "\n";
		echo "Error: " . $connection->connect_error . "\n";
		exit;
    }
    if( !$result ){
        die('mysql error');
    }
    if( mysqli_num_rows($result)<=0 ){
        $return_data = "<p class='error_msg'>No order data</p>";
    }
    else{
        $return_data = "<tr><th>Field name</th><th>Entry time</th><th>Book time</th></tr>";
        if($valid==1)
        {
            $return_data = "<tr><th>Field name</th><th>Entry time</th><th>Book time</th><th>withdraw</th></tr>";
            $plus_col = "<td><button class='red waves-effect waves-light btn-large'>withdraw</button></td></tr>";
        }
        while($row=$result->fetch_array()){
            $return_data = $return_data."<tr><td>".$row['fieldname']."</td>";
            $return_data = $return_data."<td>".$row['entrytime']."</td>";
            $return_data = $return_data."<td>".$row['booktime']."</td>";
            $return_data = $return_data."<td>".$row['oid']."</td>";
            $return_data = $return_data."".$plus_col;
        }
        $return_data = $return_data."<script>$('table tr').find('td:eq(3)').hide();</script>";
        if($valid == 1){
            $return_data = $return_data."<script>
            $('td button').click(function(e){
                var oid = $(this).parent().prev().text();
                var field_name = $(this).parent().prev().prev().prev().prev().text();
                var booktime = $(this).parent().prev().prev().text();
                var entrytime = $(this).parent().prev().prev().prev().text();
                var msg = confirm('are you sure to withdraw this order?'+'\\nfield name:'+field_name+'\\nentry time:'+entrytime+'\\nbooktime:'+booktime);
                if(msg==true)
                {
                    $.post('php/withdrawOrder.php',{oid:oid},function(data) { 
                        $('#msg').html(data); 
                    })
                    $(this).parent().parent().hide();
                }
            });</script>";
        }
    }
    echo $return_data;
}