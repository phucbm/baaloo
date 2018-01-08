<?php
SESSION_START();
include_once("function.php");
if(isset($_GET['id']) && $_GET['id'] != "10_7.css"){
	$sanpham = get_content("motsanpham",$_GET['id']);
	$cungloai = get_content("spcungloai",$sanpham[0]['sp_loai']);
	if(isset($_SESSION['user_id'])){$sanphamvuaxem = get_content("sanphamvuaxem",$_SESSION['user_id']);}
	save_views_on_product($_GET['id']);
	$luotxem = get_content("luotxemtheosp",$_GET['id']);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php foreach($sanpham as $item){?>
<title><?php echo @$item['sp_ten'];?> | BAALOO</title>
<?php include_once("link-ref.php");?>

<!-- SEO meta -->
<meta name="description" content="<?php echo substr(@$item['sp_noidung'],0,50);?>">
<meta name="keywords" content="<?php echo @$item['sp_tukhoa'];?>">
<!-- end SEO meta -->

<!-- facebook share meta -->
<meta property="og:url"           content="http://baaloo.tk/<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="BAALOO - <?php echo @$item['sp_ten'];?>" />
<meta property="og:description"   content="<?php echo substr(@$item['sp_noidung'],0,50);?>" />
<meta property="og:image"         content="http://baaloo.tk/<?php echo @$item['sp_avatar'];?>" />
<!-- end facebook share meta -->

</head>
<style>
.button {
	display: inline-block;
	background-color: #0F647F;
	border: none;
	color: #FFFFFF;
	text-align: center;
	font-size: 15px;
	padding: 6px;
	width: 200px;
	transition: all 0.5s;
	cursor: pointer;
	margin: 1px;
	margin-bottom: 15px;
}
.button span {
	cursor: pointer;
	display: inline-block;
	position: relative;
	transition: 0.5s;
}
.button span:after {
	content: '»';
	position: absolute;
	opacity: 0;
	top: 0;
	right: -15px;
	transition: 0.5s;
}
.button:hover span {
	padding-right: 20px;
}
.button:hover span:after {
	opacity: 1;
	right: 0;
}
.col-sm-5 h2 {
	margin-top: 0;
	margin-bottom: 30px;
}
.col-sm-5 h3 {
	color: rgba(12,84,106,0.69);
 font-family: Consolas font-size: 50px;
	font-weight: normal;
	line-height: 20px;
	padding: 0;
}
.col-sm-5 h4 {
	color: rgba(243,70,73,0.92);
	text-decoration: line-through;
	font-style: italic;
	font-size: 15px;
}
.col-sm-5 p {
	color: rgba(69,64,64,0.89);
}
</style>
<body id="admin">

<?php include_once("navbar.php");?>
<div class="container" style="background-color:transparent"> 
  <!-- CONTENT -->
  <div class="row" style="background-color:white;padding-top:15px">
  <!-- IMAGE -->
    <div class="col-sm-4 col-sm-offset-1">
      <p> <img src="<?php echo @$item['sp_avatar'];?>" width="100%" alt="<?php echo @$item['sp_ten'];?>"/> </p>
    </div>
    <!-- END IMAGE -->
    <!-- TEXT -->
    <div class="col-sm-5">
    	<!-- NSX -->
      <p style="font-style:italic; margin-bottom:0; color: rgba(12,84,106,0.69);"><?php echo @$item['sp_nsx'];?></p>
      <!-- NAME -->
      <h2><?php echo @$item['sp_ten'];?></h2>
      <!-- NỘI DUNG -->
      <p style="text-align: justify; text-justify: inter-word;"><?php echo @$item['sp_noidung'];?></p>
      <!-- GIÁ -->
      <h3 style="font-size:15px; text-align:right;">Còn lại <?php echo @$item['sp_soluong'];?> sản phẩm - <?php echo $luotxem[0]['luotxem'];?> lượt xem</h3>
      <h3>$<?php echo @$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100);?></h3>
      <h4 style="margin-bottom:0;">$<?php echo @$item['sp_gia'];?></h4>
      <p style="font-style:italic; margin-top:0; font-size:10px;">Tiết kiệm được $<?php echo @$item['sp_gia']-(@$item['sp_gia']-(@$item['sp_km']*@$item['sp_gia']/100));?> (<?php echo @$item['sp_km'];?>%)</p>
      
      <!-- THÊM VÀO GIỎ -->
      <button class="button" style="vertical-align:middle" onClick="addtocart(<?php echo @$item['sp_id'];?>)">Thêm vào giỏ hàng</button>
      
      <!-- facebook share btn -->    
      <div class="fb-like" data-href="http://baaloo.tk/<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
      <!-- end facebook share btn --> 
    </div>
    <!-- END TEXT -->
  </div>
  <!-- END CONTENT -->
  
  <!-- FB comment -->
  <div class="row" style="background-color:white;margin-top:20px">
  <div class="col-sm-offset-1 col-sm-9">
  	<div class="fb-comments" data-width="100%" data-href="http://baaloo.tk/<?php echo @$item['sp_loai'];?>/<?php echo title_makeup(@$item['sp_ten']);?>-<?php echo @$item['sp_id'];?>" data-numposts="5"></div>
  </div>
  </div>
  <!-- end FB comment -->
  
  <!-- DEVIDE TITLE -->
    <bmp-title-home>
    <img src="images/like.png">
    <p style="color:#2196F3">SẢN PHẨM CÙNG LOẠI</p>
    </bmp-title-home>
    <!-- END DEVIDE TITLE -->
    <div class="row ">
    <!-- PRODUCT -->
    <?php foreach($cungloai as $item){?>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-8">
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
    <bmp-title-home <?php if(isset($_SESSION['username'])) echo "style='display:block'"; else echo "style='display:none'";?>>
    <img src="images/visibility.png">
    <p style="color:#FF8E31">SẢN PHẨM VỪA XEM</p>
    </bmp-title-home>
    <!-- END DEVIDE TITLE -->
    <div class="row" <?php if(isset($_SESSION['username'])) echo "style='display:block'"; else echo "style='display:none'";?>>
    <!-- PRODUCT -->
    <?php foreach($sanphamvuaxem as $item){ $sp = get_content("motsanpham",$item['sp_id']); ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-8">
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
<?php } ?>
</html>
