<?php
session_start();
if(@$_SESSION['level']=='admin'){
	include_once("function.php");
	
	if(isset($_GET['table'])){ 
		if($_GET['table']=="hoadon"){
			delete_content("chitiethoadon",@$_GET['id']);	// nếu xóa hóa đơn thì xóa cthd trước
		}
		delete_content(@$_GET['table'],@$_GET['id']);
	}
	disconnect_db();
} else {
	header("location:dang-nhap");exit();
}
?>