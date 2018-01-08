<!-- NAV BAR 2.4 -->
<div class="row">
  <nav class="navbar bmp-navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <i class="fa fa-bars fa-2x" aria-hidden="true"></i>                        
      </button>
    </div>
          
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
          <li><a href="home"><img src="images/baaloo_logo.png" width="100"></a></li>
          <li><a href="thu-cung">THÚ CƯNG</a></li>
          <li><a href="may-anh">MÁY ẢNH</a></li>
          <li><a href="ga-ran">GÀ RÁN</a></li>
          <li><a href="du-lich">DU LỊCH</a></li>
          <li>
              <!-- KIỂM TRA SESSION ĐĂNG NHẬP -->
              <?php
              if(@$_SESSION['level']==""){
                  echo "<a href='dang-nhap'><i class='fa fa-user' aria-hidden='true'></i> ĐĂNG NHẬP</a>";
              } else if(@$_SESSION['level']=="admin"){
                  echo "
                    <div class='dropdown'>
                        <button class='btn btn-danger dropdown-toggle' type='button' data-toggle='dropdown'>					{$_SESSION['username']} <span class='caret'></span>
                        </button>
                        <ul class='dropdown-menu'>
                          <li><a href='admin'><i class='fa fa-cog' aria-hidden='true'></i> Admin</a></li>
						  <li><a href='user'><i class='fa fa-user-circle-o' aria-hidden='true'></i> Tài khoản của tôi</a></li>
						  <li><a href='user/hoa_don_cua_toi'>
      	<i class='fa fa-credit-card' aria-hidden='true'></i> Hóa đơn của tôi</a></li>
                          <li><a href='dang-thoat'><i class='fa fa-sign-out' aria-hidden='true'></i> Logout</a></li>
                        </ul>
                      </div>";
              } if(@$_SESSION['level']=="user"){
                  echo "
                    <div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>					{$_SESSION['username']} <span class='caret'></span>
                        </button>
                        <ul class='dropdown-menu'>
						  <li><a href='user'><i class='fa fa-user-circle-o' aria-hidden='true'></i> Tài khoản của tôi</a></li>
                          <li><a href='user/hoa_don_cua_toi'><i class='fa fa-credit-card' aria-hidden='true'></i> Hóa đơn của tôi</a></li>
						  <li><a href='dang-thoat'><i class='fa fa-sign-out' aria-hidden='true'></i> Logout</a></li>
                        </ul>
                      </div>";
              }
              ?>
              <!-- END KIỂM TRA SESSION ĐĂNG NHẬP -->
          </li>
          <li><nav-cart>
          	<a href="gio-hang"><i class="fa fa-cart-plus" aria-hidden="true"></i> GIỎ HÀNG
            <span id="soluongsp" class="badge"> 
			<?php 
				if(isset($_SESSION['baaloocart'])) echo $_SESSION['baaloocart']['tongsoluong'];
				else echo "0";
			?>
            </span>
            </a>
          </nav-cart></li>
      </ul>
    </div>
  </div>
</nav>
</div>