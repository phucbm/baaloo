<?php
session_start();
// Thiết lập cấu trúc fiel là xml
header("Content-type: text/xml; charset=utf-8");
include_once("function.php");
save_log("Tải trang RSS");
$rss = get_content("rss","");
?>
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
  <atom:link href="http://baaloo.tk/baaloo_rss.php" rel="self" type="application/rss+xml" />
  <title>Danh sách sản phẩm từ BAALOO</title>
  <link>https://baaloo.tk</link>
  <description>Trang web bán BAALOO vô cùng hài hước</description>
  <?php foreach($rss as $item){?>
  <item>
    <title><?php echo sanitizeXML(@$item['sp_ten']);?></title>
    <link><?php echo sanitizeXML("http://baaloo.tk/".@$item['sp_loai']."/".title_makeup(@$item['sp_ten'])."-".@$item['sp_id']);?></link>
    <description><?php echo sanitizeXML(substr(@$item['sp_noidung'],0,50));?></description>
    <author>minhphuc1511one@gmail.com (Minh Phuc Bui)</author>
    <pubDate><?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date(DATE_RFC822);?></pubDate>
  </item>
  <?php }?>
</channel>

</rss>