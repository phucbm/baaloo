<?php
SESSION_START();
if(isset($_SESSION['username']) && isset($_GET['hd_id'])){
	include_once("function.php");
	$isAllowed = false;
	if($_SESSION['level']=='admin'){
		// được xem mọi hóa đơn
		$isAllowed = true;
	} else {
		// kiểm tra user_id, chỉ đc xem của mình
		$isAllowed = checkPermisson($_GET['hd_id'],$_SESSION['user_id']);
	}
	if($isAllowed){
		// lấy chi tiết hóa đơn
		$cthd = get_content("cthd",$_GET['hd_id']);
		$hd = get_content("laymothoadon",$_GET['hd_id']);
		save_log("Tải chi tiết hóa đơn mã [".$_GET['hd_id']."]");
	}else{
		header("Location: thong_bao/ko_xac_dinh_noi_dung");exit;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chi tiết hóa đơn | <?php echo $hd[0]['hd_id'];?> | BAALOO</title>
<?php include_once("link-ref.php");?>
</head>
   <body id="login">
      <?php include_once("navbar.php");?>
      <div class="container">
         <!-- CONTENT -->
         <div class="well">Chi tiết hóa đơn mã [<?php echo $hd[0]['hd_id'];?>]</div>
         <div class="row">
            <!-- DANH SÁCH SẢN PHẨM -->
            <div class="col-lg-9 col-sm-9">
               <div style="background-color:white">
               		
                  <!-- product line -->
                  <?php foreach($cthd as $item){
						$sp = get_content("motsanpham",$item['sp_id']);  
				  ?>
                  <div class="row product-line">
                     <div class="col-lg-2 col-sm-2 col-xs-2">
                        <a href="<?php echo @$sp[0]['sp_loai'];?>/<?php echo title_makeup(@$sp[0]['sp_ten']);?>-<?php echo @$sp[0]['sp_id'];?>" target="_blank">
                        <img src="<?php echo $sp[0]['sp_avatar']?>" width="100%">
                        </a>
                     </div>
                     <div class="col-lg-6 col-sm-6 col-xs-6">
                        <p><b><a href="<?php echo @$sp[0]['sp_loai'];?>/<?php echo title_makeup(@$sp[0]['sp_ten']);?>-<?php echo @$sp[0]['sp_id'];?>" target="_blank"><?php echo @$sp[0]['sp_ten'];?></a></b></p>
                        <p><?php echo @$sp[0]['sp_nsx'];?></p>
                     </div>
                     <div class="col-lg-2 col-sm-2 col-xs-2" style="text-align:center">
                        <p><b style="font-size:20px">$<?php echo @$item['sp_dongia'];?></b></p>
                        <p style="text-decoration:line-through;color:grey"><?php echo @$sp[0]['sp_gia'];?></p>
                        <p><span class="badge" style="background-color:red">-<?php echo @$sp[0]['sp_km'];?>%</span></p>
                     </div>
                     <div class="col-lg-2 col-sm-2 col-xs-2">
                        <button type="button" class="btn btn-default" disabled>Số lượng: <?php echo @$item['cthd_soluong'];?></button>
                     </div>
                  </div>
                  <?php }?>
                  <!-- end product line -->
                  
               </div>
            </div>
            <!-- END DANH SÁCH SẢN PHẨM -->
            <!-- HÓA ĐƠN -->
            <div class="col-lg-3 col-sm-3">
               <div class="product-bill" style="background-color:white">
                  <p><b>Thành tiền:</b></p>
                  <p style="text-align:right;font-size:25px">$<?php echo $hd[0]['hd_tongtien'];?></p>
                  <p style="text-align:right;font-style:italic"><?php echo "Ngày lập: ".$hd[0]['hd_ngaylap'];?></p>
                  
                  <div class="alert alert-success"><strong>ĐÃ THANH TOÁN</strong></div>
               </div>
            </div>
            <!-- END HÓA ĐƠN -->
         </div>
         <!-- END CONTENT -->
      </div>
      <?php include_once("footer.php");?>
   </body>