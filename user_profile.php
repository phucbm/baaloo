<?php
session_start();
if(isset($_SESSION['username'])){
	include_once("function.php");
	$hoadon = false; $logs = false; $sanpham = false;	// kiểm tra đang ở trang nào
	if(isset($_GET['tab'])){
		if($_GET['tab']=="hoa_don_cua_toi"){
			$hoadon = true;
		}else if($_GET['tab']=="lich_su_truy_cap"){
			$logs = true;
		}else if($_GET['tab']=="san_pham_da_xem"){
			$sanpham = true;
		}
	}
	$hoadonbyuser = get_content("hoadonbyuser",$_SESSION['user_id']);
	$logbyuser = get_content("logbyuser",$_SESSION['user_id']);
	$motuser = get_content("motuser",$_SESSION['user_id']);
	$sanphambyuser = get_content("sanphambyuser",$_SESSION['user_id']);
	save_log("Tải trang user");
	
	// Nếu người dùng submit form
	if (!empty($_POST['update_user']))
	{
		// Lay data
		$data['ten'] = $_POST['ten'];
		$data['pass'] = $_POST['pwd'];
		$data['sdt'] = $_POST['sdt'];
		$data['diachi'] = $_POST['diachi'];
	
		// Neu ko co loi thi insert
		update_user($data['ten'], $data['pass'], $_SESSION['level'], $data['sdt'], $data['diachi'], $_SESSION['user_id']);
	}
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
<title>Tài khoản của tôi | BAALOO</title>
<?php include_once("link-ref.php");?>
</head>

<body id="admin">
<?php include_once("navbar.php");?>
<div class="container">
<div class="well">Xin chào <?php echo $_SESSION['username'];?></div>
<!-- CONTENT -->
<div class="row">

<div class="col-sm-3 col-lg-3">
	<div class="list-group">
      <a href="user" class="list-group-item <?php if(!$hoadon && !$logs && !$sanpham) echo 'active';?>">
      	<i class='fa fa-user-circle-o' aria-hidden='true'></i> Thông tin tài khoản</a>
        
      <a href="user/lich_su_truy_cap" class="list-group-item <?php if($logs) echo "active";?>" 
	  <?php if($_SESSION['level']=='admin') echo 'style="display:block"'; else echo 'style="display:none"'?>>
      	<i class="fa fa-globe" aria-hidden="true"></i> Lịch sử truy cập <span class="badge">
	  	<?php echo count($logbyuser);?></span></a>
        
      <a href="user/hoa_don_cua_toi" class="list-group-item <?php if($hoadon) echo "active";?>">
      	<i class="fa fa-credit-card" aria-hidden="true"></i> Hóa đơn của tôi <span class="badge">
	  	<?php echo count($hoadonbyuser);?></span></a>
        
       <a href="user/san_pham_da_xem" class="list-group-item <?php if($sanpham) echo "active";?>">
      	<i class="fa fa-cubes" aria-hidden="true"></i> Sản phẩm đã xem <span class="badge">
	  	<?php echo count($sanphambyuser);?></span></a>
    </div>
</div>

<div class="col-sm-9 col-lg-9">
<div class="row" style="padding-bottom:15px"><div class="col-sm-12">
<!-- form -->
<?php foreach($motuser as $item){?>
<form method="post" class="form-horizontal user-edit-form" <?php if(!$hoadon && !$logs && !$sanpham) echo 'style="display:block"'; else echo 'style="display:none"'?>>
  <div class="form-group">
    <label class="col-sm-2" for="ten">Tên:</label>
    <div class="col-sm-6">
    	<input type="text" class="form-control" id="ten" name="ten" required min="2" max="20" value="<?php echo @$item['user_ten']?>">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2" for="email">Email:</label>
    <div class="col-sm-6"><input type="email" class="form-control" id="email" value="<?php echo @$item['user_email'];?>" disabled></div>
  </div>
  <div class="form-group">
    <label class="col-sm-2" for="diachi">Địa chỉ:</label>
    <div class="col-sm-6"><input type="text" class="form-control" id="diachi" name="diachi" min="2" max="20" value="<?php echo @$item['user_diachi']?>"></div>
  </div>
  <div class="form-group">
    <label class="col-sm-2" for="sdt">Số điện thoại:</label>
    <div class="col-sm-6"><input type="text" class="form-control" id="sdt" name="sdt" min="2" max="20" value="<?php echo @$item['user_sdt']?>"></div>
  </div>
  <div class="form-group">
    <label class="col-sm-2" for="pwd">Mật khẩu:</label>
    <div class="col-sm-6"><input type="text" class="form-control" id="pwd" name="pwd" required value="<?php echo @$item['user_pass']?>"></div>
  </div>
  <div class="form-group">  
  	<div class="col-sm-offset-2 col-sm-10">
    	<p style="font-style:italic;color:grey;">(Mật khẩu chỉ hiển thị khi trang web trong trạng thái demo)</p>
        <input type="submit" class="btn btn-primary" value="Cập nhật" name="update_user">
    </div>
  </div>
</form>
<?php }?>
<!-- end form -->

<!-- Lịch sử truy cập -->
<div class="table-responsive" 
	style="height:500px;overflow:auto;<?php if($logs) echo 'display:block'; else echo 'display:none'?>">          
  <table class="table table-hover">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Hành động</th>
                  <th>Thời gian</th>
                  <th>Địa điểm</th>
                  <th>URL</th>
                  <th>Truy cập từ</th>
                  <th>IP</th>
                  <th>Nhà mạng</th>
                </tr>
              </thead>
              <tbody>
                <?php if($logs){ $stt=count($logbyuser); foreach($logbyuser as $item){?>
                <tr>
                  <td><?php echo $stt--;?></td>
                  <td><?php echo @$item['nk_action'];?></td>
                  <td><?php echo date_format(date_create(@$item['nk_time']),"d-m-Y H:i:s");?></td>
                  <td><?php echo @$item['nk_location'];?></td>
                  <td><?php echo @$item['nk_url'];?></td>
                  <td><?php echo @$item['nk_refer'];?></td>
                  <td><?php echo @$item['nk_ip'];?></td>
                  <td><?php echo @$item['nk_nhamang'];?></td>
                </tr>
                <?php }}?>
              </tbody>
            </table>
</div>
<!-- end Lịch sử truy cập -->

<!-- Hóa đơn của tôi -->
<div class='table-responsive' style='height:500px;overflow:auto;
<?php if($hoadon && count($hoadonbyuser)>0) echo 'display:block'; else echo 'display:none'?>'>
            <table class='table table-hover' style="">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã</th>
                  <th>Ngày lập</th>
                  <th>Tổng tiền</th>
                </tr>
              </thead>
              <tbody>
                <?php if($hoadon){ $stt=count($hoadonbyuser); foreach($hoadonbyuser as $item){?>
                <tr>
                  <td><?php echo $stt--;?></td>
                  <td><a href="hoa_don/<?php echo @$item['hd_id'];?>" target="_blank"><?php echo @$item['hd_id'];?></a></td>
                  <td><?php echo @$item['hd_ngaylap'];?></td>
                  <td>$<?php echo @$item['hd_tongtien'];?></td>
                </tr>
                <?php }}?>
              </tbody>
            </table>
          </div>
<?php if($hoadon && count($hoadonbyuser)==0){
	echo "
		<div class='row' style='text-align:center;padding-bottom:20px'><div class='col-sm-12'>
			<h1>Bạn chưa thực hiện giao dịch nào!</h1>
			<img src='images/sad.png' width='125px'/>
		</div></div>";
}
?>
<!-- end Hóa đơn của tôi -->

<!-- PRODUCT -->
<div class="row"><div class="col-sm-12">
<?php if($sanpham){foreach($sanphambyuser as $item){ $sp = get_content("motsanpham",$item['sp_id']); ?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-8">
<bmp-project-frame>
	<bmp-promo>-<?php echo @$sp[0]['sp_km'];?>%</bmp-promo>
    <bmp-project-img><a href="<?php echo @$sp[0]['sp_loai'];?>/<?php echo title_makeup(@$sp[0]['sp_ten']);?>-<?php echo @$sp[0]['sp_id'];?>">
        <img src="<?php echo @$sp[0]['sp_avatar'];?>" alt="<?php echo @$sp[0]['sp_ten'];?>">
    </a></bmp-project-img>
    <bmp-project-nsx><?php echo @$sp[0]['sp_nsx'];?></bmp-project-nsx>
    <bmp-project-tit><?php echo @$sp[0]['sp_ten'];?></bmp-project-tit>
    <bmp-project-content>$<?php echo (@$sp[0]['sp_gia']-(@$sp[0]['sp_km']*@$sp[0]['sp_gia']/100));?> - <span style="text-decoration:line-through">$<?php echo @$sp[0]['sp_gia'];?></span></bmp-project-content>
    <button type="button" class="btn btn-block btn-xs" onClick="addtocart(<?php echo @$sp[0]['sp_id'];?>)" style="border-radius:0">Thêm vào giỏ hàng</button>
</bmp-project-frame>
</div>
<?php }}?>
</div></div>
<?php if($sanpham && count($sanphambyuser)==0){
	echo "
		<div class='row' style='text-align:center;padding-bottom:20px'><div class='col-sm-12'>
			<h1>Bạn chưa xem sản phẩm nào!</h1>
			<img src='images/sad.png' width='125px'/>
		</div></div>";
}
?>
<!-- END PRODUCT -->
</div></div>
</div>

</div>
<!-- END CONTENT -->
</div>
<?php include_once("footer.php");?>
</body>