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
    $regMSG = "error 1";
} 

// 已登陆，直接读取用户信息select logged in users detail
if (!isset($_SESSION['user'])){
  header("Location:regevent_unlogin.php");
}else{
  $res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
  $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
}


//读取订单中该用户注册该事件信息
$sql = "SELECT * FROM orders where event_id='$_POST[eventID]' and user_id='$_SESSION[user]'";
$result = $conn->query($sql);

//已经注册该事件,防止直接输入url进入该界面
if ($result->num_rows > 0) {

    $sql = "SELECT * FROM events where event_id='$_POST[eventID]'";
    $result = $conn->query($sql);
    $eventRow = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $regMSG = "您已注册"; 
//  没注册的情况    
}else {
  $sql = "SELECT * FROM events where event_id='$_POST[eventID]'";
  $result = $conn->query($sql);
  $eventRow = mysqli_fetch_array($result, MYSQLI_ASSOC);

  //登陆信息插入order表格
  $order_id=date('YmdHis').$_SESSION["user"].$_POST["eventID"];
  $ordersql = "INSERT INTO orders (order_id, user_id, event_id) VALUES('$order_id','$_SESSION[user]','$_POST[eventID]')";

  //update event table set event_capacity to event_capacity + 1
  $eventsql = "UPDATE events SET event_capacity = event_capacity - 1 WHERE event_id = '$_POST[eventID]'";

  if(mysqli_connect_error()){
        $regMSG = mysqli_connect_error();
        $regMSG = "error 2";
  }
    //设置编码
    //$mysqli->set_charset("utf8");
  //record in order table
  $insert_order_result = $conn->query($ordersql);
  //event_capacity ++
  $increment_event_result = $conn->query($eventsql);

  if($insert_order_result === false or $increment_event_result === false){
     $regMSG = $conn->error;
     $regMSG = "error 3";
  }else{
     $regMSG = "注册成功";
  }

echo $regMSG;

$conn->close();
}
?>



