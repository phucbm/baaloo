<?php
SESSION_START();
if(@$_SESSION['level']=="admin"){
	include_once("function.php");
	
	// Nếu người dùng submit form
	if (!empty($_POST['add_sanpham']))
	{
		// Lay data
		$data['avatar'] = upload_img();
		if($data['avatar'] == 'fail') {echo "upload image fail";}
		$data['ten'] = $_POST['ten'];
		$data['dongia'] = $_POST['dongia'];
		$data['loai'] = $_POST['loai'];
		$data['km'] = $_POST['km'];
		$data['sl'] = $_POST['sl'];
		$data['nsx'] = $_POST['nsx'];
		$data['noidung'] = $_POST['noidung'];
		$data['tukhoa'] = $_POST['tukhoa'];
	
		// Neu ko co loi thi insert
			add_baaloo($data['ten'] ,$data['loai'] ,$data['dongia'] ,$data['km'] ,$data['sl'] ,$data['nsx'] ,$data['avatar'] ,$data['noidung'], $data['tukhoa']);
	   // Trở về trang admin
	   header("location: admin");
	}
	disconnect_db();
}
else {
header("location:dang-nhap");
exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thêm BAALOO mới | BAALOO</title>
<?php include_once("link-ref.php");?>
</head>

<body id="admin">
<?php include_once("navbar.php");?>
<div class="container">

<!-- CONTENT -->
<div class="well">Thật vui mừng vì một BAALOO nữa sắp được hình thành</div>
<form class="form-horizontal" method="post" enctype = "multipart/form-data">
	<!-- TÊN -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="ten">Tên:</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="ten" name="ten" placeholder="Điền tên vào đây" maxlength="30" required>
    </div>
  </div>
  <!-- HÌNH ẢNH -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="hinh">Hình đại diện (CHỈ chọn hình có nền màu trắng hoặc trong suốt):</label>
    <div class="col-sm-8">
      <input type="file" class="form-control btn btn-default" id="hinh" name="file" accept="image/*" required>
    </div>
  </div>
  <!-- ĐƠN GIÁ VÀ KHUYẾN MÃI -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="dongia">Đơn giá:</label>
    <div class="col-sm-3"> 
      <input type="number" class="form-control" id="dongia" name="dongia" placeholder="Điền đơn giá (USD)" required min="1">
    </div>
    <label class="control-label col-sm-2" for="km">Khuyến mãi:</label>
    <div class="col-sm-3"> 
      <input type="number" class="form-control" id="km" name="km" placeholder="Điền phần trăm khuyến mãi (nếu có)" max="100" min="0" required>
    </div>
  </div>
  <!-- SỐ LƯỢNG & NSX -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="sl">Số lượng:</label>
    <div class="col-sm-3"> 
      <input type="number" class="form-control" id="sl" name="sl" placeholder="Điền số lượng sản phẩm" required min="1">
    </div>
    <label class="control-label col-sm-2" for="nsx">Nhà sản xuất:</label>
    <div class="col-sm-3"> 
      <input type="text" class="form-control" id="nsx" name="nsx" placeholder="Điền tên nhà sản xuất" maxlength="20" required>
    </div>
  </div>
  <!-- LOẠI SẢN PHẨM -->
  <div class="form-group">
  	<label class="control-label col-sm-2">Loại:</label>
    <div class="col-sm-8">
      <label class="radio-inline"><input type="radio" name="loai" value="du-lich" checked>DU LỊCH</label>
      <label class="radio-inline"><input type="radio" name="loai" value="may-anh">MÁY ẢNH</label>
      <label class="radio-inline"><input type="radio" name="loai" value="ga-ran">NHƯ</label>
      <label class="radio-inline"><input type="radio" name="loai" value="thu-cung">THÚ CƯNG</label>
    </div>
  </div>
  <!-- TỪ KHÓA -->
  <div class="form-group">
    <label class="control-label col-sm-2" for="tukhoa">Từ khóa (Bắt buộc phải liên quan đến tên sản phẩm, tối thiểu 3 từ khóa):</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="tukhoa" name="tukhoa" placeholder="Điền từ khóa (Vd: Balo Mikkor, Mikkor black, Mikkor siêu rẻ, Mikkor chính hãng" maxlength="100" required>
    </div>
  </div>
  <!-- NỘI DUNG -->
  <div class="form-group">
      <label for="noidung" class="control-label col-sm-2">Nội dung:</label>
      <div class="col-sm-8">
      <textarea class="form-control" rows="15" id="noidung" name="noidung" required></textarea>
      </div>
  </div>
<!-- SUBMIT -->
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-primary" value="Thêm" name="add_sanpham">
    </div>
  </div>
</form>
<!-- END CONTENT -->
</div>
<?php include_once("footer.php");?>
</body>