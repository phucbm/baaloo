<?php
session_start();
$mess = "";
$button = "";
if(isset($_GET['loai'])){
	switch($_GET['loai']){
	case "ko_xac_dinh_noi_dung":
		$mess = "Không xác định được nội dung bạn đang tìm. Xin hãy thử lại sau.";
		$button = "<a class='btn hvr-bounce-to-top' href='home'>Đến trang chủ</a>";
		break;
	case "email_dang_nhap_khong_ton_tai":
		$mess = "Email đăng nhập không tồn tại. Bạn có muốn tạo một tài khoản?";
		$button = "<a class='btn hvr-bounce-to-left' href='javascript:history.go(-1)'>Không!</a>
					<a class='btn hvr-bounce-to-right' href='dang-ky'>Ừ đăng ký cho vui :))</a>";
		break;
	case "sai_mat_khau":
		$mess = "Sai mật khẩu rồi!";
		$button = "<a class='btn hvr-bounce-to-left' href='javascript:history.go(-1)'>Đăng nhập lại</a>
					<a class='btn hvr-bounce-to-right' href='dang-ky'>Tạo tài khoản mới</a>";
		break;
	case "xin_chao_admin":
		$mess = "Xin chào, <kbd>{$_SESSION['username']}</kbd>";
		$button = "
		<p style='background-color:red;border-radius:3px;padding:15px;color:white;font-size:20px'>
		Administrator Mode</p>
		<a class='btn hvr-bounce-to-top' href='admin'>Đến trang admin</a>
		<a class='btn hvr-bounce-to-top' href='home'>Đến trang chủ</a>";
		break;
	case "xin_chao":
		$mess = "Xin chào, <kbd>{$_SESSION['username']}</kbd>";
		$button = "<a class='btn hvr-bounce-to-top' href='home'>Đến trang chủ</a>";
		break;
	case "email_da_duoc_su_dung":
		$mess = "Email này đã được đăng ký. Hãy thử lại.";
		$button = "<a class='btn hvr-bounce-to-left' href='javascript:history.go(-1)'>Trở về</a>
					<a class='btn hvr-bounce-to-right' href='dang-ky'>Tạo tài khoản mới</a>";
		break;
	case "dang_ky_thanh_cong":
		$mess = "Xin chào <kbd>{$_SESSION['username']}</kbd>! Bạn đã đăng ký tài khoản thành công!</p>";
		$button = "<a class='btn hvr-bounce-to-left' href='dang-nhap'>Đăng nhập</a>";
		break;
	case "dang_ky_thanh_cong_admin":
		$mess = "Xin chào <kbd>{$_SESSION['username']}</kbd>! Bạn đã đăng ký tài khoản thành công!</p>";
		$button = "<p style='background-color:red;border-radius:3px;padding:15px;color:white;font-size:20px'>Tài khoản được kích hoạt Administrator</p>
				<a class='btn hvr-bounce-to-left' href='dang-nhap'>Đăng nhập</a>";
		break;
	case "dang_ky_khong_thanh_cong":
		$mess = "Đăng ký không thành công! Hãy thử lại.</p>";
		$button = "<a class='btn hvr-bounce-to-left' href='javascript:history.go(-1)'>Trở về</a>";
		break;
	case "mat_khau_qua_ngan":
		$mess = "Mật khẩu của bạn trước khi thêm chuỗi 'admin' phải dài hơn 8 kí tự.</p>";
		$button = "<a class='btn hvr-bounce-to-left' href='javascript:history.go(-1)'>Trở về</a>";
		break;
	case "thanh_toan_thanh_cong":
		$mess = "Thanh toán thành công! Cảm ơn bạn đã sử dụng trang web của chúng mình.";
		$button = "<a class='btn hvr-bounce-to-left' href='home'>Trở về trang chủ</a>";
		break;
	default:break;}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Baaloo | Thông báo</title>
<?php include_once("link-ref.php");?>
</head>

<body id="login">
<?php include_once("navbar.php");?>
<div class="container">

<!-- CONTENT -->
<div class="row">
<div class="noti">
<h3><?php echo $mess;?></h3>
<?php echo $button;?>
</div>
</div>
<!-- END CONTENT -->
</div>
<?php //include_once("footer.php");?>
</body>