<?php
header("content-Type: text/html;char set=utf-8");
ob_start();
session_start();
require_once 'dbconnect.php';

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$login = "";
if (!isset($_SESSION['user'])) {
    $login = false;
} else{
  $login = true;
  // select logged in users detail
  $res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
  $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
}


$sql = "SELECT * FROM events where event_id='$_GET[eventID]'";
$result = $conn->query($sql);
$eventRow = mysqli_fetch_array($result, MYSQLI_ASSOC);
//测试用
// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["event_id"]. " - event: " . $row["event_name"]. " " . $row["event_location"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }


// $conn->close();
?>

<!DOCTYPE html>
<!--
Template Name: Geodarn
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html>
<head>
<title>Welcome</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top" class="background-black">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" "> 
  <!-- ################################################################################################ -->
  <!-- Top bar -->
  <div class="wrapper row1" >
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left" >
        <h1><a href="index.php">EventChina</a></h1>
      </div>
      <div id="navi" class="fl_right">
        <nav id="mainav_" class="fl_right">
            <a href="index.php">首页</a>

            <!-- Didn't login -->
            <?php
            if (!isset($_SESSION['user'])) {
            ?>

            <a href="register.php" type="button" name="btn-register" class="nav_grey">注册</a>
            <a href="login.php" type="button" name="btn-login" class="nav_grey">登陆</a>
            <a href="login.php" type="button" name="btn-login" class="nav_grey">创建活动</a>
            <!--have login -->
            <!-- // select logged in users detail-->
            <?php 
            }else{ 
            ?>

            <a href="myActivity.php" class="nav_grey">我的活动</a>
            <a href="create_event.php" class="nav_grey">创建活动</a>
            <a href="logout.php?logout" class="nav_grey">退出登录</a>
            <?php } ?>

        </nav>
      </div>
      <!-- ################################################################################################ -->
    </header>
  </div>
  <!-- end of the top bar -->

</div>
<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->



<div class="row7">
<div class="wrapper row3" >
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="clear row6" style="padding:20px;"> 
      <!-- ################################################################################################ -->

      <div class="one_half first fl_left ">
        <img src="./images/event_by_id/<?php echo $_GET['eventID']; ?>.jpg" alt="Nature" >
        
      </div>

      <div class="one_half center"  >
        
        <h2><?php echo $eventRow["event_name"]; ?></h2>
        <br><h4>日期: <?php echo $eventRow["event_date"] ?> </h4>
        <h4>时间: <?php echo $eventRow["event_start_time"] ?> - <?php echo $eventRow["event_end_time"] ?> </h4>
        <h4>地点: <?php echo $eventRow["event_location"] ?></h4>
        <h4><?php echo $eventRow["event_introduction"] ?></h4>
        <!-- this is the top of register event -->
        <!-- 判断是否有余票 -->
        <!-- 有余票 可以注册-->
        <?php 
          if($eventRow['event_capacity'] > 0) {
          ?>
                  <!-- 判断是否已经注册该事件，如果注册按钮变灰 -->
                  <!-- 未登录 -->
                  <?php
                    if (!isset($_SESSION['user'])) {
                  ?>

                  <button class="green_button" type="submit" name="signup" id="reg">注册</button>
                  <!-- 已经登陆 -->
                  <?php }else{ ?>
                    <!-- 已经注册该事件 -->
                    <?php 
                      $sql2 = "SELECT * FROM orders where event_id='$_GET[eventID]' AND user_id=" . $_SESSION['user'];
                      $eventres = $conn->query($sql2);
                      if ($eventres->num_rows > 0){
                    ?>
                        <button class="gray_button" type="submit" name="signup" id="reg" disabled>已注册</button>
                    <!-- 没有注册该事件 -->
                    <?php }else{ ?>
                        <button class="green_button" type="submit" name="signup" id="reg">注册</button> 
                    <?php }
                    ?>
                 <?php } ?>
                  <!-- this is the end of register event -->
              
        
        <!-- 票已售完 -->
          <?php }else{ ?>
                <button class="gray_button" type="submit" name="signup" id="reg" disabled>票已售完</button>
          <?php }
          ?>

                  
      </div>
    </div>


      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->





<!-- this is the footer part -->
<div class="wrapper footer bgded overlay" >
  <footer class="hoc clear topspace-30"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h3 class="heading">EventChina</h3>
      <ul class="faico clear">
<!--         <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
        <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a class="faicon-vk" href="#"><i class="fa fa-vk"></i></a></li> -->
      </ul>
    </div>
    <div class="one_third">
      <ul class="nospace meta">
        <li class="btmspace-15"><i class="fa fa-phone"></i> +1 (917) 815 7753</li>
      </ul>
    </div>

    <div class="one_third">
      <ul class="nospace meta">
        <li class="btmspace-15"><i class="fa fa-envelope-o"></i> eventchina@hotmail.com</li>
      </ul>
    </div>


<!--     <div class="one_half">
      <form method="post" action="#">
        <fieldset>
          <legend>Newsletter:</legend>
          <div class="clear">
            <input type="text" value="" placeholder="Type Email Here&hellip;">
            <button class="fa fa-share" type="submit" title="Submit"><em>Submit</em></button>
          </div>
        </fieldset>
      </form>
    </div> -->
    <!-- ################################################################################################ -->

  </footer>
  
  <div align="center">
  Copyright &copy; 2018 EventChina Inc. All rights reserved.
  <div>

</div>



<!-- this is the end of footer part -->

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<!-- <script src="../layout/scripts/jquery.mobilemenu.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Determine whether login or not when register the event-->
<script>
// $(document).ready(function(){
//     $("#reg").click(function(){
//         window.location.href="regevent<?php echo $login;?>.php?eventID=<?php echo $_GET['eventID']; ?>";
//     })
// })

$(document).ready(function(){
    $('#reg').click(function(){
        var isLogin = "<?php echo $login ?>"; 
        if(!isLogin){
            window.location.href="regevent_unlogin.php?eventID=<?php echo $_GET['eventID']; ?>";
        }else{
            var clickBtnValue = <?php echo $_GET['eventID']; ?>;
            var ajaxurl = "regevent.php?eventID=<?php echo $_GET['eventID']; ?>",
            data =  {'eventID': clickBtnValue};
            $.post(ajaxurl, data, function (regMSG) {
            // Response div goes here.
                alert(regMSG);
                window.location.reload(false); 
        });
        }
        
    });
});

</script>

</body>
</html>


