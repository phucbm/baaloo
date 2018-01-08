<?php
SESSION_START();
include_once("function.php");
// Nếu người dùng submit form, truy cập theo thuộc tính name trên thẻ html
if (!empty($_POST['logup']))
{
    // Lay data
    $data['ten'] = $_POST['ten'];
	$data['email'] = $_POST['email'];
	$data['pwd'] = $_POST['pwd'];
	$data['level'] = "user";
	$data['sdt'] = "";
	$data['diachi'] = "";
    // Neu ko co loi thi insert
    add_user($data['ten'], $data['pwd'], $data['level'], $data['email'], $data['sdt'], $data['diachi']);
    // Trở về trang danh sách
}
disconnect_db();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đăng ký tài khoản | BAALOO</title>
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
<div class="well">Baaloo hưng phấn vì bạn sắp đăng ký</div>
<form class="form" method="post">
  <div class="form-group">
    <label for="ten">Tên:</label>
    <input type="text" class="form-control" id="ten" name="ten" required min="2" max="20">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="pwd">Mật khẩu:</label>
    <input type="password" class="form-control" id="pwd" name="pwd" required min="8" max="20">
  </div>
  <input type="submit" class="btn btn-primary" name="logup" value="Đăng ký">
  <p>Bạn có tài khoản rồi? Hãy <a href="dang-nhap">đăng nhập</a></p>
</form>
</div>

</div>
<!-- END CONTENT -->
</div>
<?php include_once("footer.php");?>
</body>