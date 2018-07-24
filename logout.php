<?php
header("content-Type: text/html;char set=utf-8");
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
} else if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: index.php");
    exit;
}
