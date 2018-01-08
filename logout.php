<?php session_start(); 
include_once("function.php");
save_log($_SESSION['level']." ".$_SESSION['username']." đăng thoát!");
if (isset($_SESSION['username'])){
    unset($_SESSION['username']); // xóa session login
	unset($_SESSION['level']); // xóa session login
}

header("location: default.php");
?>