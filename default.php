<?php
session_start();
include_once("function.php");
$sanphamhot = get_content("sanphamhot","");
$quytoc = get_content("quytoc","");
$hangmoive = get_content("hangmoive","");
save_log("Tải trang chủ");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Trang chủ | BAALOO</title>
<?php include_once("link-ref.php");?>
</head>

<body style="padding-top:48px;">
<?php include_once("navbar-fixed-top.php");?>
 
<div class="container">

<!-- BANNER -->
<img src="images/banner_baaloo_home.gif" width="100%">
<!-- END BANNER -->

<!-- DEVIDE TITLE -->
<bmp-title-home>
<img src="images/chili.png">
<p style="color:#D13834">SẢN PHẨM HOT</p>
</bmp-title-home>
<!-- END DEVIDE TITLE -->
<div class="row ">
<!-- PRODUCT -->
<?php foreach($sanphamhot as $item){?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
<bmp-project-frame>
	<bmp-promo>-<?php echo @$item['sp_km'];?>%</bmp-promo>
    <bmp-project-img><a href="<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>">
        <img src="<?php echo @$item['sp_avatar'];?>" alt="<?php echo @$item['sp_ten'];?>">
    </a></bmp-project-img>
    <bmp-project-nsx><?php echo @$item['sp_nsx'];?></bmp-project-nsx>
    <bmp-project-tit><?php echo @$item['sp_ten'];?></bmp-project-tit>
    <bmp-project-content>$<?php echo @$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100);?> - <span style="text-decoration:line-through">$<?php echo @$item['sp_gia'];?></span></bmp-project-content>
    <button type="button" class="btn btn-block btn-xs" onClick="addtocart(<?php echo @$item['sp_id'];?>)" style="border-radius:0">Thêm vào giỏ hàng</button>
</bmp-project-frame>
</div>
<?php }?>
<!-- END PRODUCT -->
</div>

<!-- DEVIDE TITLE -->
<bmp-title-home>
<img src="images/diamond.png">
<p style="color:#2EA2DB">DÀNH CHO QUÝ TỘC</p>
</bmp-title-home>
<!-- END DEVIDE TITLE -->
<div class="row ">
<!-- PRODUCT -->
<?php foreach($quytoc as $item){?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
<bmp-project-frame>
	<bmp-promo>-<?php echo @$item['sp_km'];?>%</bmp-promo>
    <bmp-project-img><a href="<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>">
        <img src="<?php echo @$item['sp_avatar'];?>" alt="<?php echo @$item['sp_ten'];?>">
    </a></bmp-project-img>
    <bmp-project-nsx><?php echo @$item['sp_nsx'];?></bmp-project-nsx>
    <bmp-project-tit><?php echo @$item['sp_ten'];?></bmp-project-tit>
    <bmp-project-content>$<?php echo @$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100);?> - <span style="text-decoration:line-through">$<?php echo @$item['sp_gia'];?></span></bmp-project-content>
    <button type="button" class="btn btn-block btn-xs" onClick="addtocart(<?php echo @$item['sp_id'];?>)" style="border-radius:0">Thêm vào giỏ hàng</button>
</bmp-project-frame>
</div>
<?php }?>
<!-- END PRODUCT -->
</div>

<!-- DEVIDE TITLE -->
<bmp-title-home>
<img src="images/rocket.png">
<p style="color:#FFD200">HÀNG MỚI VỀ</p>
</bmp-title-home>
<!-- END DEVIDE TITLE -->
<div class="row ">
<!-- PRODUCT -->
<?php foreach($hangmoive as $item){?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
<bmp-project-frame>
	<bmp-promo>-<?php echo @$item['sp_km'];?>%</bmp-promo>
    <bmp-project-img><a href="<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>">
        <img src="<?php echo @$item['sp_avatar'];?>" alt="<?php echo @$item['sp_ten'];?>">
    </a></bmp-project-img>
    <bmp-project-nsx><?php echo @$item['sp_nsx'];?></bmp-project-nsx>
    <bmp-project-tit><?php echo @$item['sp_ten'];?></bmp-project-tit>
    <bmp-project-content>$<?php echo @$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100);?> - <span style="text-decoration:line-through">$<?php echo @$item['sp_gia'];?></span></bmp-project-content>
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
