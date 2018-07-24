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


$check_in_order_sql = "UPDATE orders SET check_in = 1 WHERE order_id = '$_POST[orderID]'";
$check_in_order_res = $conn->query($check_in_order_sql);
// $orderRow = mysqli_fetch_array($check_in_order_res, MYSQLI_ASSOC);




// $request_event_sql = "SELECT * FROM events WHERE event_id='$orderRow[event_id]'";
// $request_event_res = $conn->query($request_event_sql);
// $eventRow = mysqli_fetch_array($request_event_res, MYSQLI_ASSOC);


if($check_in_order_res === false){
    $regMSG = $conn->error;
}else{
  $regMSG = "签到成功";
}

echo $regMSG;
?>