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
    $regMSG = $conn->error;
} 
// $login = "";
// if (!isset($_SESSION['user'])) {
//     $login = "_unlogin";
// } else{
//   // select logged in users detail
//   $res = $conn->query("SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
//   $userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
// }


$request_order_sql = "SELECT * FROM orders where order_id='$_POST[orderID]'";
$request_order_res = $conn->query($request_order_sql);
$orderRow = mysqli_fetch_array($request_order_res, MYSQLI_ASSOC);

//delete order in table orders
$delete_order_sql = "DELETE FROM `orders` WHERE `orders`.`order_id` = '$orderRow[order_id]'";
$delete_order_res = $conn->query($delete_order_sql);
//minus event_capacity by 1 in table events
$minus_event_sql = "UPDATE events SET event_capacity = event_capacity + 1 WHERE event_id = '$orderRow[event_id]'";
$minus_event_res = $conn->query($minus_event_sql);


// $request_event_sql = "SELECT * FROM events WHERE event_id='$orderRow[event_id]'";
// $request_event_res = $conn->query($request_event_sql);
// $eventRow = mysqli_fetch_array($request_event_res, MYSQLI_ASSOC);


if($request_order_res === false or $delete_order_res === false or $minus_event_res === false){
    $regMSG = $conn->error;
}else{
  $regMSG = "取消成功";
}

echo $regMSG;
?>