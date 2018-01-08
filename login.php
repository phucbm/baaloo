<?php
SESSION_START();
include_once("function.php");
// Nếu người dùng submit form
if (!empty($_POST['login']))
{
	//Lấy dữ liệu nhập vào
	$data['username'] = $_POST['email'];
	$data['password'] = $_POST['pwd'];
	
	sign_in($data['username'],$data['password']);
}
if (!empty($_POST['quicklogin']))
{	
	sign_in("user@user.user","thisisuser");
}
disconnect_db();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng nhập | BAALOO</title>
<?php include_once("link-ref.php");?>
</head>

<body id="login">
<?php include_once("navbar.php");?>
<div class="container">

<!-- CONTENT -->
<div class="row login">

<div class="col-lg-6 col-sm-12" style="text-align:center">
<img src="images/baaloo_logo.jpg">
</div>

<div class="col-lg-6 col-sm-12">
<div class="well">Baaloo hào hứng đón chờ lượt đăng nhập này</div>
<form method="post" class="form">
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="pwd">Mật khẩu:</label>
    <input type="password" class="form-control" id="pwd" name="pwd">
  </div>
  <input type="submit" class="btn btn-primary" value="Đăng nhập" name="login">
  <p>Bạn chưa có tài khoản? Hãy <a href="dang-ky">đăng ký</a></p>
  	<p>Chỉ muốn dùng thử? Hãy sử dụng chức năng 
    	<input type="submit" class="btn btn-basic" value="Đăng nhập nhanh" name="quicklogin"/></p>
</form>
</div>

</div>
<!-- END CONTENT -->
</div>
<?php include_once("footer.php");?>
</body>