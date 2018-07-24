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
// $login = "";
// if (!isset($_SESSION['user'])) {
//     $login = false;

// } else{
//   $login = true;

//   // select logged in users detail
//   $res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
//   $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
//   $_SESSION['permission'] = $userRow['permission'];
//   $max = (int)$_GET[max];
//   if($_SESSION['permission'] > 0){
//     $sql = "INSERT INTO events(event_name, event_start_time, event_end_time, event_location, event_introduction, event_organizer_id, event_date) VALUES ('$_GET[name]','$_GET[start]','$_GET[end]','$_GET[location]','$_GET[intro]','$_SESSION[user]','$_GET[date]')";

//     

//   }
// }
$sql = "INSERT INTO events(event_name, event_start_time, event_end_time, event_location, event_introduction, event_organizer_id, event_date) VALUES ('$_GET[name]','$_GET[start]','$_GET[end]','$_GET[location]','$_GET[intro]','$_SESSION[user]','$_GET[date]')";
$create_res = $conn->query($sql);
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
            <!--have login -->
            <!-- // select logged in users detail-->
            <?php 
            }else{ 
            ?>

            <a href="myActivity.php" class="nav_grey">我的活动</a>
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


<?php 
if($create_res === true){
?>
    <div class="row7">
    <main class="hoc container clear"> 
      <!-- main body -->
      <!-- ################################################################################################ -->
        <!-- ################################################################################################ -->
        创建成功。
    
        <!-- ################################################################################################ -->
      <!-- ################################################################################################ -->
      <!-- / main body -->
      <div class="clear"></div>
    </main>
  </div>
  <!-- ################################################################################################ -->
<?php
}else{
?>
    <div class="row7">
    <main class="hoc container clear"> 
      <!-- main body -->
      <!-- ################################################################################################ -->
        <!-- ################################################################################################ -->
        创建失败，请重试.<?php echo $regMSG?>
<?php echo $_GET[name], $_GET[start],$_GET[end],$_GET[location],$_GET[intro],$_SESSION[user],$_GET[date]?> 
        <!-- ################################################################################################ -->
      <!-- ################################################################################################ -->
      <!-- / main body -->
      <div class="clear"></div>
    </main>
  </div>
  <!-- ################################################################################################ -->
<?php
}
?>






<!-- this is the footer part -->
<div class="wrapper footer bgded overlay" >
  <footer class="hoc clear topspace-30"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h3 class="heading">EventChina</h3>
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



<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<!-- <script src="../layout/scripts/jquery.mobilemenu.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</script>

</body>
</html>