<?php
include('connectvars.php');
include('Page.php');

session_start();
if(!isset($_SESSION['userinfo'])|| empty($_SESSION['userinfo'])){
	header("location: ../signInUp.html");
}
else{
    $pageSize=8;
    $stadiumId = "";
    $periodId = "";
    $query="Select SE.sessionId,S.stadiumName,F.fieldName,S.price,P.STARTTIME,P.ENDTIME FROM SESSION SE,STADIUM S,FIELD F,PERIOD P WHERE SE.FIELDID = F.FIELDID AND SE.PERIODID = P.PERIODID AND F.STADIUMID = S.STADIUMID ";
    $last_query = "SE.sessionId NOT IN (SELECT sessionId from userorder where valid = 1) order by sessionId";
    $return_data = "<table id='field_table' class='responsive-table striped'><tr><th>Stadium name</th><th>Field name</th><th>price</th><th>entry time</th><th>book</th></tr>";

    if(isset($_GET['stadium'])&&isset($_GET['period'])){
        $stadiumId = trim($_GET["stadium"]);
        $periodId = trim($_GET["period"]);
//        分场馆以及时间段显示
        if($stadiumId!="0")
        {
            $query= $query." and S.STADIUMID = $stadiumId ";
        }
        if($periodId!="0")
        {
            $query= $query." and P.PERIODID = $periodId ";
        }
    }

    $query = $query." and ".$last_query;
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
        echo "No field data, change the conditions and try again~";
    }
    else{
        $totalRows = mysqli_num_rows($result);
//        创建表格页面
        $_page = new Page($totalRows,$pageSize);
        $limit = $_page->limit;
        $query = $query."".$limit;
        $result = $connection->query($query);
        $show_page = $_page->showpage();
        $today = date("l",strtotime("1 day"));

//        创建表格页面
        while($row=$result->fetch_array()){
            $time = $today." ".$row['STARTTIME']."-".$row['ENDTIME'];
            $return_data = $return_data."<tr><td>".$row['stadiumName']."</td>";
            $return_data = $return_data."<td>".$row['fieldName']."</td>";
            $return_data = $return_data."<td>".$row['price']."</td>";
            $return_data = $return_data."<td>".$time."</td>";
            $return_data = $return_data."<td>".$row['sessionId']."</td>";
            $return_data = $return_data."<td><button class='waves-effect waves-light btn'>book</button></td></tr>";
        }
        $return_data = $return_data."</table>"."<div id='pagination_container' style='text-align: center;'><ul class='pagination' style='display:inline-block'>".$show_page."</ul></div>";
        $return_data = $return_data."<script>
            $('.page_lab').click(function(e){
                var request_url = $(this).attr('href');
                $.get(request_url,function(data) { 
                    $('#display_field').html(data); 
                })
                e.preventDefault();
            });
            $('table tr').find('td:eq(4)').hide();
            
            $('td button').click(function(e){
                var session_id = $(this).parent().prev().text();
                var time = $(this).parent().prev().prev().text();
                var price = $(this).parent().prev().prev().prev().text();
                var field_name = $(this).parent().prev().prev().prev().prev().text();
                
                var msg = confirm('are you sure to make this order?'+'\\nfield name:'+field_name+'\\nprice:'+price+'\\ntime:'+time);
                if(msg==true)
                {
                    $.post('php/makeOrder.php',{session_id:session_id,time:time},function(data) { 
                        $('#msg').html(data); 
                    })
                    $(this).attr('disabled','disabled');
                }
               
            });

        </script>";
        echo $return_data;
    }
}
?>