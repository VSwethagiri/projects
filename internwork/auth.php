<?php
session_start();

//auto login using cookies
if(!isset($_SESSION['user'])&& isset($_COOKIE['user'])){
    $_SESSION['user']=$_COOKIE['user'];
}
//if still not logged in, redirect
if(!isset($_SESSION['user'])){
    header("Location: front.php");
    exit();
}
?>