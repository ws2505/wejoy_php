<?php
header("content-Type: text/html;char set=utf-8");
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    $login = "_unlogin";
} else{
  // select logged in users detail
  $res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
  $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
}

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
<title>EventChina</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="icon" href="./images/icon/icons-header.png">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top" class="background-black">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->

  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left">
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
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <!-- ################################################################################################ -->
  <div class="imgcontainer-header"> 
    <!-- ################################################################################################ -->
    <img class="mySlides" src="./images/background/background1.jpg">
    <img class="mySlides" src="./images/background/background2.jpg">
    <img class="mySlides" src="./images/background/background3.jpg">


    <div class="centered">Welcome</div>

    <!-- ################################################################################################ -->
  </div>
  <!-- ################################################################################################ -->

<!-- End Top Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="btmspace-80 center">
      <img src="./images/icon/slogan.png"></img>
<!--       <h2 class="nospace" style="font-family:楷书 ">发现身边事</h2> -->
<!--       <p class="nospace">Erat in diam eu placerat purus est ac nisi integer sed rutrum dictum.</p> -->
    </div>

<!--This is the event list -->
    <!-- generating event boxes -->
    <?php
    $sql = "SELECT * FROM events order by event_id asc limit 4";
    $result = $conn->query($sql);
    $event_id=Array();
    $event_name=Array();
    $event_start_time=Array();
    $event_end_time=Array();
		$event_pic=Array();
    $event_date=Array();
    $event_location=Array();
		while($row=mysqli_fetch_array($result)){
      array_push($event_id,$row["event_id"]);
			array_push($event_name,$row["event_name"]);
      array_push($event_start_time,$row["event_start_time"]);
      array_push($event_end_time,$row["event_end_time"]);
      array_push($event_date,$row["event_date"]);
      array_push($event_location,$row["event_location"]);
		}
    ?>
<!--     <?php $var1 = $event_id[0];?>
    <?php $var2 = $event_id[1];?>
    <?php $var3 = $event_id[2];?>
    <?php $var4 = $event_id[3];?> -->

    <ul class="nospace group services">
    <?php
    for ($i=0; $i<sizeof($event_name)/2; $i++){
      ?>
      <li class="one_half first">
        <a href = "<?php echo "eventpage.php?eventID=".$event_id[2*$i] ?>">
          <div class="imgcontainer">
            <img src="./images/event_by_id/<?php echo $event_id[2*$i]?>.jpg" alt="Nature">  
            <div class="text_block">
              <h3><?php echo $event_name[2*$i]?></h3>
              <p class="font-15"><?php echo $event_date[2*$i]?>  <?php echo $event_start_time[2*$i].'~'.$event_end_time[2*$i] ?> <br> <?php echo $event_location[2*$i]?></p>
            </div>
          </div>
        </a> 
      </li> 
<!--       <div class="one_half first module" style=" background: url(./images/event_by_id/<?php echo $event_id[2*$i]?>.jpg);">
        <a href = "<?php echo "eventpage.php?eventID=".$event_id[2*$i] ?>">
        <header>
          <h1>
            Skyscraper
          </h1>
        </header>
      </div> -->


      <li class="one_half">
        <a href = "<?php echo "eventpage.php?eventID=".$event_id[2*$i+1] ?>">
          <div class="imgcontainer">
            <img src="./images/event_by_id/<?php echo $event_id[2*$i+1]?>.jpg" alt="Nature"> 
            <div class="text_block">
              <h3><?php echo $event_name[2*$i+1] ?></h3>
              <p class="font-15"><?php echo $event_date[2*$i+1]?> <?php echo $event_start_time[2*$i+1].'~'.$event_end_time[2*$i+1] ?> <br> <?php echo $event_location[2*$i+1]?> </p>
            </div>
          </div>
        </a> 
      </li>
      <?php
    }
    ?>


    </ul>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>




<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- 暂时不用 -->
<!-- <div class="wrapper">
  <article id="shout" class="hoc container clear">  -->
    <!-- ################################################################################################ -->
<!--     <div class="three_quarter first">
      <h2 class="heading btmspace-10">这里是第四段</h2>
      <p class="nospace">Porta erat cras vitae maximus purus suspendisse blandit nec justo mollis etiam vitae.</p>
    </div>
    <footer class="one_quarter"><a class="btn" href="#">Accumsan metus</a></footer> -->
    <!-- ################################################################################################ -->
<!--   </article>
</div>
 -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<!-- 暂时不用
<div class="wrapper row3">
  <section class="hoc container clear">  -->
    <!-- ################################################################################################ -->
<!--     <div class="btmspace-80 center">
      <h3 class="nospace">Gravida nulla aliquam</h3>
      <p class="nospace">Erat volutpat integer vestibulum purus et sagittis rhoncus.</p>
    </div>
    <div class="group">
      <div class="one_half first">
        <h6 class="nospace font-x1">Elit vel porttitor</h6>
        <p>Ex suspendisse vestibulum turpis luctus pretium posuere vestibulum feugiat non metus quis vitae&hellip;</p>
        <footer><a class="btn" href="#">Read More</a></footer>
      </div>
      <article class="one_half"><a href="#"><img class="btmspace-30" src="images/demo/320x210.png" alt=""></a>
        <h6 class="nospace font-x1">Sapien porttitor ut</h6>
        <p>Dignissim praesent consectetur nec tellus ut rutrum nam laoreet finibus mattis integer ullamcorper arcu&hellip;</p>
      </article>
      <article class="one_half"><a href="#"><img class="btmspace-30" src="images/demo/320x210.png" alt=""></a>
        <h6 class="nospace font-x1">Praesent sed blandit</h6>
        <p>Pellentesque vehicula dictum ligula tellus convallis nisl vel scelerisque quam ligula a mauris quisque&hellip;</p>
      </article>
    </div> -->
    <!-- ################################################################################################ -->
<!--   </section>
</div> -->
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
<!-- <div class="wrapper row5">
  <div id="copyright" class="hoc clear">  -->
    <!-- ################################################################################################ -->
<!--     <p class="fl_left">Copyright &copy; 2016 - All Rights Reserved - <a href="#">Domain Name</a></p>
    <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p> -->
    <!-- ################################################################################################ -->
<!--   </div>
</div> -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->



<!-- <a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a> -->
<!-- JAVASCRIPTS -->


<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<!-- <script src="layout/scripts/jquery.mobilemenu.js"></script> -->
<script src="layout/scripts/jquery.flexslider-min.js"></script>


<!-- 滚动效果 -->
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 4000); // Change image every 2 seconds
}
</script>

</body>
</html>