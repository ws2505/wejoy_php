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
$res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);


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
<?php 
if ($userRow['user_permission'] == 1){ ?>
 

<!-- ################################################################################################ -->
<!-- main body --> 
<div class="row7">
<center>
  <h2> 我管理的活动</h2>
</center>

<?php 
$res = $conn->query("SELECT * FROM events WHERE event_organizer_id=" . $_SESSION['user']);
  
if ($res->num_rows > 0){
  while($eventRow = mysqli_fetch_array($res,MYSQLI_ASSOC)){ ?>

<!-- this is a list of event -->
<!-- have registed in some events -->
<div class="row3">
  <main class="hoc"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="clear" style="padding:20px; border-bottom: 1px solid #d9d9d9; "> 
      <!-- ################################################################################################ -->
      
      <div class="fl_right one_half first">
        <a href = "<?php echo "eventpage.php?eventID=".$eventRow['event_id'] ?>">
          <img src="./images/event_by_id/<?php echo $eventRow['event_id']; ?>.jpg" alt="Nature">
        </a>
        
      </div>
      <!-- get event details according to the activity id -->
      <center>
        <div class="fl_right one_half" >
        <h3>名称 <?php echo $eventRow['event_name']; ?></h3>

        <br><br>时间: <?php echo $eventRow['event_start_time']; ?> - <?php echo $eventRow['event_end_time']; ?>
        <br><br>地点: <?php echo $eventRow['event_location']; ?>
        <br><br><button class="green_button" type="submit" onClick="window.location = '<?php echo "manageActivity.php?eventID=".$eventRow['event_id'] ?>' ">查看活动信息</button> 

        </p>
        </div>
      </center>
      
      
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- this is the end of a event-->
<?php  } 
}else {
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
      <h2>你没有创建任何活动</h2>
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
<!-- main body --> 
<div class="row7">
<center>
  <h2> 我参加的活动</h2>
</center>

<?php 
$res = $conn->query("SELECT * FROM orders WHERE user_id=" . $_SESSION['user']);
  
if ($res->num_rows > 0){
  while($orderRow = mysqli_fetch_array($res,MYSQLI_ASSOC)){ ?>
  <?php $res2 = $conn->query("SELECT * FROM events WHERE event_id=" . $orderRow['event_id']);  
        $eventRow = mysqli_fetch_array($res2, MYSQLI_ASSOC);
     ?>
<!-- this is a list of event -->
<!-- have registed in some events -->
<div class="row3">
  <main class="hoc"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="clear" style="padding:20px; border-bottom: 1px solid #d9d9d9; "> 
      <!-- ################################################################################################ -->
      
      <div class="fl_right one_half first">
        <a href = "<?php echo "eventpage.php?eventID=".$eventRow['event_id'] ?>">
          <img src="./images/event_by_id/<?php echo $eventRow['event_id']; ?>.jpg" alt="Nature">
        </a>
        
      </div>
      <!-- get event details according to the activity id -->
      <center>
        <div class="fl_right one_half" >
        <h3>名称 <?php echo $eventRow['event_name']; ?></h3>
        <p class="font-15">
          订单号: <?php echo $orderRow['order_id']; ?>
        <br><br>时间: <?php echo $eventRow['event_start_time']; ?> - <?php echo $eventRow['event_end_time']; ?>
        <br><br>地点: <?php echo $eventRow['event_location']; ?>
        <br><br><button class="green_button cancel" type="submit" value="<?php echo $orderRow['order_id'] ?>">退订</button> 
<!--         <?php echo $orderRow['order_id'] ?> -->
        </p>
        </div>
      </center>
      
      
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- this is the end of a event-->
<?php  } 
}else {
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
      <h2>你没有注册任何活动</h2>
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

<?php }else{ ?>
  
  <div class="row7">
<!-- ################################################################################################ -->
<!-- main body -->
<?php 
$res = $conn->query("SELECT * FROM orders WHERE user_id=" . $_SESSION['user']);
  
if ($res->num_rows > 0){
  while($orderRow = mysqli_fetch_array($res,MYSQLI_ASSOC)){ ?>
  <?php $res2 = $conn->query("SELECT * FROM events WHERE event_id=" . $orderRow['event_id']);  
        $eventRow = mysqli_fetch_array($res2, MYSQLI_ASSOC);
     ?>
<!-- this is a list of event -->
<!-- have registed in some events -->
<div class="row3">
  <main class="hoc"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="clear" style="padding:20px; border-bottom: 1px solid #d9d9d9; "> 
      <!-- ################################################################################################ -->
      
      <div class="fl_right one_half first">
        <a href = "<?php echo "eventpage.php?eventID=".$eventRow['event_id'] ?>">
          <img src="./images/event_by_id/<?php echo $eventRow['event_id']; ?>.jpg" alt="Nature">
        </a>
        
      </div>
      <!-- get event details according to the activity id -->
      <center>
        <div class="fl_right one_half" >
        <h3>名称 <?php echo $eventRow['event_name']; ?></h3>
        <p class="font-15">
          订单号: <?php echo $orderRow['order_id']; ?>
        <br><br>时间: <?php echo $eventRow['event_start_time']; ?> - <?php echo $eventRow['event_end_time']; ?>
        <br><br>地点: <?php echo $eventRow['event_location']; ?>
        <br><br><button class="green_button cancel" type="submit" value="<?php echo $orderRow['order_id'] ?>">退订</button> 
<!--         <?php echo $orderRow['order_id'] ?> -->
        </p>
        </div>
      </center>
      
      
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- this is the end of a event-->
<?php  } 
}else {
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
      <h2>你没有注册任何活动</h2>
    </div>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
<!-- this is the end of a event-->
<?php  }
?>

<!-- this is the end of main body -->
</div>

<?php } ?>





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
    $('.cancel').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'cancelOrder.php',
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