<?php
SESSION_START();
include_once("function.php");
$tongsanpham = 0;
if(isset($_SESSION['baaloocart'])) { $tongsanpham = $_SESSION['baaloocart']['tongsoluong']; }
?>
<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Giỏ hàng | BAALOO</title>
      <?php include_once("link-ref.php");?>
      <script src="https://www.paypalobjects.com/api/checkout.js"></script>
   </head>
   <body id="login">
      <?php include_once("navbar.php");?>
      <div class="container">
         <!-- CONTENT -->
         <div class="well">Giỏ hàng (<span id="giohangsoluong"><?php echo $tongsanpham;?></span> sản phẩm)</div>
         <div class="row">
            <!-- DANH SÁCH SẢN PHẨM -->
            <div class="col-lg-9 col-sm-9">
               <div style="background-color:white">
                  <!-- product line -->
                  <?php
				  	$stt=0; 		
                    if ($tongsanpham==0){
                     			echo "
								<div class='row' style='text-align:center;padding-bottom:20px'><div class='col-sm-12'>
									<h1>Bạn chưa chọn sản phẩm nào!</h1>
									<img src='images/sad.png' width='125px'/>
								</div></div>";
                     			}
                    else {
                     	foreach($_SESSION['baaloocart'] as $key=>$value) {
						  $spincart = array();
						  if(strcmp($key,"tongsoluong") !=0 && strcmp($key,"sosp")!=0){
							  $stt++;
							// lấy sản phẩm
							$spincart = get_content("motsanpham",$key);?>
                        
                  <div class="row product-line" id="baaloo<?php echo @$spincart[0]['sp_id'];?>">
                  		
                        <!-- image -->
                     <div class="col-lg-2 col-sm-2 col-xs-2">
                        <img src="<?php echo @$spincart[0]['sp_avatar'];?>" width="100%">
                     </div>
                     <!-- info -->
                     <div class="col-lg-6 col-sm-6 col-xs-6">
                        <p><a href="<?php echo @$spincart[0]['sp_loai'];?>/<?php echo title_makeup(@$spincart[0]['sp_ten']);?>-<?php echo @$spincart[0]['sp_id'];?>"><?php echo @$spincart[0]['sp_ten'];?></a></p>
                        <p><?php echo @$spincart[0]['sp_nsx'];?></p>
                        <button type="button" class="btn btn-default" 
                        	onclick="location.href = 'xulygiohang.php?xoasanpham=<?php echo @$spincart[0]['sp_id'];?>'">
                           <i class="fa fa-trash" onClick="" aria-hidden="true"></i> Xóa
                        </button>
                        <!--<button type="button" class="btn btn-default" 
                        	onclick="xoasanpham(<?php echo @$spincart[0]['sp_id'];?>)">
                           <i class="fa fa-trash" onClick="" aria-hidden="true"></i> Xóa
                        </button>-->
                     </div>
                     <!-- gia -->
                     <div class="col-lg-2 col-sm-2 col-xs-2" style="text-align:center">
                     	<!-- don gia x so luong -->
                        <p style="font-size:20px;font-weight:bold">$<span
                        	class="element<?php echo $stt;?>" 
                            id="sanpham<?php echo @$spincart[0]['sp_id'];?>">
							<?php 
								$dongiadakm = @$spincart[0]['sp_gia']-(@$spincart[0]['sp_km']*@$spincart[0]['sp_gia']/100);
								echo $dongiadakm*$value;
							?></span>
                        </p>
                        <span style="display:none" id="dongiadakm<?php echo @$spincart[0]['sp_id'];?>"><?php echo $dongiadakm;?></span>
                        <!-- gia goc -->
                        <p style="text-decoration:line-through;color:grey">
                        	$<?php echo @$spincart[0]['sp_gia'];?>
                        </p>
						<!-- khuyen mai -->
                        <p><span class="badge" style="background-color:red">-<?php echo @$spincart[0]['sp_km'];?>%</span></p>
                     </div>
                     <!-- so luong -->
                     <div class="col-lg-2 col-sm-2 col-xs-2">
                        <input type="number" min="1" max="99" 
                        	id="soluong<?php echo @$spincart[0]['sp_id'];?>"
                        	onchange="updatecart(<?php echo @$spincart[0]['sp_id'];?>)" 
                            value="<?php echo $value;?>"/>
                     </div>
                  </div>
                  <?php }}} echo "<span id='elements' style='display:none'>".$stt."</span>";?>
                  <!-- end product line -->
               </div>
            </div>
            <!-- END DANH SÁCH SẢN PHẨM -->
            <!-- HÓA ĐƠN -->
            <div class="col-lg-3 col-sm-3">
               <div class="product-bill" style="background-color:white">
                  <p><b>Thành tiền:</b></p>
                  <p style="text-align:right;font-size:25px"><span id="tongtien">0</span>$</p>
                  <p style="text-align:right;font-style:italic">(Đã bao gồm VAT)</p>
                  <div id="paypal-button-container"></div>
                  <script>
					paypal.Button.render({

            env: 'sandbox', // sandbox | production

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
                production: "HD" + Math.round(Date.now() / 1000)
            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: parseFloat($('#tongtien').text()), currency: 'USD' }
                            }
                        ]
                    }
                });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                    window.location.href = "xulygiohang.php?tonghoadon="+parseFloat($('#tongtien').text());
                });
            }

        }, '#paypal-button-container');
                     
                  </script>
                  
                  <!-- GỢI Ý TÀI KHOẢN THANH TOÁN -->
                  	<div class="panel-group" style="margin:10px 0">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h6 class="panel-title">
                            <a data-toggle="collapse" href="#collapse1">Thanh toán bằng tài khoản của BAALOO 
                            	<i class="fa fa-hand-o-down" aria-hidden="true"></i>
                            </a>
                          </h6>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                          <ul class="list-group">
                            <li class="list-group-item">saigon@baaloo.tk</li>
                            <li class="list-group-item">danang@baaloo.tk</li>
                            <li class="list-group-item">hanoi@baaloo.tk</li>
                          </ul>
                          <div class="panel-footer">Mật khẩu: nguoimua</div>
                        </div>
                      </div>
                    </div>
                  <!-- END GỢI Ý TÀI KHOẢN THANH TOÁN -->
               </div>
            </div>
            <!-- END HÓA ĐƠN -->
         </div>
         <!-- END CONTENT -->
      </div>
      <?php include_once("footer.php");?>
   </body>