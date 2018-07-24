<?php
header("content-Type: text/html;char set=utf-8");
ob_start();
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}
include_once 'dbconnect.php';

if (isset($_POST['btn-register'])) {

    $uname = trim($_POST['uname']); // get posted data and remove whitespace
    $email = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    $uphone = trim($_POST['phone']);
    $ulocation = trim($_POST['user_location']);

    // hash password with SHA256;
    $password = hash('sha256', $upass);

    // check email exist or not
    $stmt = $conn->prepare("SELECT user_email FROM users WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $count = $result->num_rows;

    if ($count == 0) { // if email is not found add user


        $stmts = $conn->prepare("INSERT INTO users(user_name,user_password,user_email,user_phone,user_location) VALUES(?, ?, ?, ?, ?)");
        $stmts->bind_param("sssss", $uname, $password, $email, $uphone, $ulocation);
        $res = $stmts->execute();//get result
        $stmts->close();

        $user_id = mysqli_insert_id($conn);
        if ($user_id > 0) {
            $_SESSION['user'] = $user_id; // set session and redirect to index page
            $_SESSION["email"]=$email;
            if (isset($_SESSION['user'])) {
                print_r($_SESSION);
                header("Location: index.php");
                exit;
            }

        } else {
            $errTyp = "danger";
            $errMSG = "服务器错误，请重新输入";
        }

    } else {
        $errTyp = "warning";
        $errMSG = "邮箱已被占用";
    }

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
<title>用户注册</title>
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
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3 center">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
      <div id="comments">
        <h2>注册</h2>
        <center>
          <form action="#" method="post">

          <?php
                if (isset($errMSG)) {
                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

          <div class="list">
            <label for="name">用户名/学号 <span>*</span></label>
            <!-- <input type="text" name="name" id="name" value="" size="22" required> -->
            <input type="text" name="uname" class="form-control" required/>
          </div>
          <div class="list">
            <label for="email">邮箱 <span>*</span></label>
            <!-- <input type="email" name="email" id="email" value="" size="22" required> -->
            <input type="email" name="email" class="form-control" required/>
          </div>

          <div class="list">
            <label for="email">密码 <span>*</span></label>
            <input type="password" name="pass" class="form-control" required/>             
          </div>

          <div class="list">
            <label for="email">电话 <span>*</span></label>
            <input type="phone" name="phone" class="form-control" required/>         
          </div>

          <div class="list">
            <label for="email">位置 <span>*</span></label>
            <input type="text" name="user_location" class="form-control" required/>     
          </div>

<!--           <div class="list">
            <label><input type="checkbox" id="TOS" value="This"><a href="#">I agree with terms of service</a></label>
              
          </div>
 -->

          

<!--           <div class="list">
            <label for="url">Website</label>
            <input type="url" name="url" id="url" value="" size="22">
          </div> -->
<!--           <div class="block clear">
            <label for="comment">Your Comment</label>
            <textarea name="comment" id="comment" cols="25" rows="10"></textarea>
          </div> -->
          <div class="list topspace-50 right">
<!--             <input type="submit" name="btn-login" value="登陆" onclick="location.href='login.php';">
            &nbsp; -->
           <input class="active" type="submit" name="btn-register" value="注册">

          </div>
          </form>
        </center>
        
      </div>
      <!-- ################################################################################################ -->
    </div>
   
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
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
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<!-- <script src="../layout/scripts/jquery.mobilemenu.js"></script> -->
</body>
</html>