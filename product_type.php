<?php
SESSION_START();
include_once("function.php");

if(isset($_GET['loai'])){
	$loai="LOẠI SẢN PHẨM";
	switch($_GET['loai']){
		case "du-lich": $loai = "DU LỊCH";break;
		case "may-anh": $loai = "MÁY ẢNH";break;
		case "thu-cung": $loai = "THÚ CƯNG";break;
		case "ga-ran": $loai = "GÀ RÁN";break;
		default:break;	
	}
	$sanpham = get_content($_GET['loai'],"");
	save_log("Tải trang sản phẩm loại ".$loai);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ba lô <?php echo $loai;?> | BAALOO</title>
<?php include_once("link-ref.php");?>
 
</head>

<body style="padding-top:48px;">
<?php include_once("navbar-fixed-top.php");?>
 
<div class="container">

<!-- DEVIDE TITLE -->
<div class="row">
<div class="col-lg-12 col-sm-12 product-type-title">
<p><?php echo $loai;?></p>
</div>
</div>
<!-- END DEVIDE TITLE -->

<div class="row">
<!-- PRODUCT -->
<?php foreach($sanpham as $item){?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
<bmp-project-frame>
	<bmp-promo>-<?php echo @$item['sp_km'];?>%</bmp-promo>
    <bmp-project-img><a href="<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>">
        <img src="<?php echo @$item['sp_avatar'];?>" alt="<?php echo @$item['sp_ten'];?>">
    </a></bmp-project-img>
    <bmp-project-nsx><?php echo @$item['sp_nsx'];?></bmp-project-nsx>
    <bmp-project-tit><?php echo @$item['sp_ten'];?></bmp-project-tit>
    <bmp-project-content>$<?php echo (@$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100));?> - <span style="text-decoration:line-through">$<?php echo @$item['sp_gia'];?></span></bmp-project-content>
    <button type="button" class="btn btn-block btn-xs" onClick="addtocart(<?php echo @$item['sp_id'];?>)" style="border-radius:0">Thêm vào giỏ hàng</button>
</bmp-project-frame>
</div>
<?php }?>
<!-- END PRODUCT -->
</div>

</div>
<?php include_once("footer.php");?>
</body>
</html>
