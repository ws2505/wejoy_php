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

// select logged in users detail
$event_res = $conn->query("SELECT * FROM events WHERE event_id=" . $_GET['eventID']);
$eventRow = mysqli_fetch_array($event_res, MYSQLI_ASSOC);


// $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>我的活动</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top" class="background-black">
  <!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/demo/backgrounds/01.png');"> 
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

<!-- 管理员登陆，可以浏览创建的活动 -->

<!-- ################################################################################################ -->
<!-- main body --> 
<div class="row7">
<center>
  <h2> <?php echo $eventRow['event_name']?></h2>
</center>



<?php 
$res = $conn->query("SELECT * FROM orders WHERE event_id=" . $_GET['eventID']);
//列出所有参加人员  
if ($res->num_rows > 0){ ?>

<br><table style="width:100%">
  <tr>
    <th>姓名</th>
    <th>电话</th> 
    <th>邮箱</th>
    <th>签到</th>
  </tr>
  <?php
  while($orderRow = mysqli_fetch_array($res,MYSQLI_ASSOC)){ ?>
  <?php $resUser = $conn->query("SELECT * FROM users WHERE user_id=" . $orderRow['user_id']);  
        $userRow = mysqli_fetch_array($resUser, MYSQLI_ASSOC);
     ?>
  <tr>
    <td><?php echo $userRow['user_name']; ?></td>
    <td><?php echo $userRow['user_phone']?></td>
    <td><?php echo $userRow['user_email']; ?></td>
    <td><?php if($orderRow['check_in'] > 0){ ?>
          <button class="checkin" type="submit" value="<?php echo $orderRow['order_id'] ?>" disabled>已签到</button> 
        <?php }else{ ?>
          <button class="checkin" type="submit" value="<?php echo $orderRow['order_id'] ?>">&nbsp签到 &nbsp</button> 
        <?php } ?></td>
  </tr>
  <?php  } ?>
<!-- This is the end of while loop -->
</table>
<!-- No one register -->
<?php }else {
?>
<!-- Didn't register any activity -->
<!-- this is a list of event -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
      <!-- ################################################################################################ -->
<!--       <img class="imgr borderedbox inspace-5" src="http://via.placeholder.com/500x300" alt=""> -->
      <h2>没有任何人注册活动</h2>
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- this is the end of a event-->
<?php  }
?>


</div>
<!-- this is the end of main body -->



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


<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<!-- <script src="../layout/scripts/jquery.mobilemenu.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $('.checkin').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'checkin.php',
        data =  {'orderID': clickBtnValue};
        $.post(ajaxurl, data, function (regMSG) {
            // Response div goes here.
            alert(regMSG);
            window.location.reload(false); 
        });
    });

});


</script>

</body>
</html>