<?php
// -------------------------------------------------------------------- CONNECT TO DATABASE --------------------------
include_once("database-connect.php");

// ------------------------------------------------------------------ WEBSITE MANAGER ------------------------------------
//get IP address
function getIP(){
$ip = $_SERVER['REMOTE_ADDR'];
	//lay IP neu user truy cap qua Proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
return $ip;
}
//return d/m/y:h:m:s HCMC time zone
function get_time(){
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	return date("y/m/d H:i:s");
}
// lưu nhật ký
function save_log($nk_action){
	global $conn;
    connect_db();
	
	//get guest info
	$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "undefined"; //truy cap tu trang nay
	$url = $_SERVER['REQUEST_URI']; //da truy cap vao trang nay
	$ip = getIP();//--IP của người truy cập
	$brs = $_SERVER['HTTP_USER_AGENT'];//--Thông tin về trình duyệt của người truy cập
	$time = get_time();
	
	//get location from IP
	@$ipinfo = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
	@$dbip = json_decode(file_get_contents("http://api.db-ip.com/v2/45655dcac459add3f04f5f8086a3a944c99fbed5/{$ip}"));
	@$mang = isset($ipinfo->org) ? $ipinfo->org : "undefined"; // -> "org: nha cung cap mang"
	@$city = isset($dbip->city) ? $dbip->city : "undefined";
	@$country = isset($dbip->countryName) ? $dbip->countryName : "undefined";
	
	// get user info
	$nk_user = "guess";
	$nk_level = "guess";
	$user_id = 15111996;
	if(isset($_SESSION['username'])){
		$nk_user = $_SESSION['username'];
		$nk_level = $_SESSION['level'];
		$user_id = $_SESSION['user_id'];
	}
	
	$sql = "INSERT INTO nhatky(nk_time, nk_user, nk_action, nk_ip, nk_location, nk_nhamang, nk_browser, nk_url, nk_refer, nk_level, user_id)
			VALUES ('$time', '$nk_user', '$nk_action', '$ip', '$city-$country', '$mang', '$brs', '$url', '$refer', '$nk_level', $user_id)";
	$query = mysqli_query($conn, $sql);
	//die("user id: ".$user_id);
}

 // Hàm chuyển đổi những ký tự đặc biệt để khỏi lỗi XML
function sanitizeXML($string)
{
    if (!empty($string)) 
    {
        $regex = '/(
            [\xC0-\xC1] # Invalid UTF-8 Bytes
            | [\xF5-\xFF] # Invalid UTF-8 Bytes
            | \xE0[\x80-\x9F] # Overlong encoding of prior code point
            | \xF0[\x80-\x8F] # Overlong encoding of prior code point
            | [\xC2-\xDF](?![\x80-\xBF]) # Invalid UTF-8 Sequence Start
            | [\xE0-\xEF](?![\x80-\xBF]{2}) # Invalid UTF-8 Sequence Start
            | [\xF0-\xF4](?![\x80-\xBF]{3}) # Invalid UTF-8 Sequence Start
            | (?<=[\x0-\x7F\xF5-\xFF])[\x80-\xBF] # Invalid UTF-8 Sequence Middle
            | (?<![\xC2-\xDF]|[\xE0-\xEF]|[\xE0-\xEF][\x80-\xBF]|[\xF0-\xF4]|[\xF0-\xF4][\x80-\xBF]|[\xF0-\xF4][\x80-\xBF]{2})[\x80-\xBF] # Overlong Sequence
            | (?<=[\xE0-\xEF])[\x80-\xBF](?![\x80-\xBF]) # Short 3 byte sequence
            | (?<=[\xF0-\xF4])[\x80-\xBF](?![\x80-\xBF]{2}) # Short 4 byte sequence
            | (?<=[\xF0-\xF4][\x80-\xBF])[\x80-\xBF](?![\x80-\xBF]) # Short 4 byte sequence (2)
        )/x';
        $string = preg_replace($regex, '', $string);
 
        $result = "";
        $current;
        $length = strlen($string);
        for ($i=0; $i < $length; $i++)
        {
            $current = ord($string{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF)))
            {
                $result .= chr($current);
            }
            else
            {
                $ret;    // use this to strip invalid character(s)
                // $ret .= " ";    // use this to replace them with spaces
            }
        }
        $string = $result;
    }

    return $string;
}

// xóa dấu tiếng việt => xoa-dau-tieng-viet 
function title_makeup($string){
       $unicode = array(
	   		'-'=>' ',
           'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
           'd'=>'đ',
           'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
           'i'=>'í|ì|ỉ|ĩ|ị',
           'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
           'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
           'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
           'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
           'D'=>'Đ',
           'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
           'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
           'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
           'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
           'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
       );
      foreach($unicode as $nonUnicode=>$uni){
          $string = preg_replace("/($uni)/i", $nonUnicode, $string);
      }
      return strtolower($string);
}

function get_content($command,$quantity){
	global $conn;
    connect_db();
	switch($command) {
		case 'spcungloai':
			$query = mysqli_query($conn, "SELECT * FROM sanpham WHERE sanpham.sp_loai = '$quantity' ORDER BY sanpham.sp_km DESC LIMIT 4");
			break;
		case 'sanphambyuser':
			$query = mysqli_query($conn, "SELECT * FROM luotxem WHERE luotxem.user_id = $quantity ORDER BY lx_thoigian DESC");
			break;
		case 'sanphamvuaxem':
			$query = mysqli_query($conn, "SELECT * FROM luotxem WHERE luotxem.user_id = $quantity ORDER BY lx_thoigian DESC LIMIT 4");
			break;
		case 'luotxemtheosp':
			$query = mysqli_query($conn, "SELECT sum(lx_times) AS luotxem FROM luotxem WHERE luotxem.sp_id = $quantity");
			break;
		case 'cthd':
			$query = mysqli_query($conn, "SELECT * FROM chitiethd WHERE chitiethd.hd_id = '$quantity'");
			break;
		case 'laymothoadon':
			$query = mysqli_query($conn, "SELECT * FROM hoadon WHERE hoadon.hd_id = '$quantity'");
			break;
		case 'sptrongngay':
			$query = mysqli_query($conn, "SELECT sum(cthd_soluong) AS sptrongngay FROM chitiethd WHERE DATE(cthd_ngaylap)=CURDATE()");
			break;
		case 'motuser':
			$query = mysqli_query($conn, "SELECT * FROM user WHERE user.user_id = $quantity");
			break;
		case 'logbyuser':
			$query = mysqli_query($conn, "SELECT * FROM nhatky WHERE nhatky.user_id = $quantity ORDER BY nk_id DESC");
			break;
		case 'hoadonbyuser':
			$query = mysqli_query($conn, "SELECT * FROM hoadon WHERE hoadon.user_id = $quantity ORDER BY hd_id DESC");
			break;
		case 'tongthutrongngay':
			$query = mysqli_query($conn, "select sum(hd_tongtien) AS tongtien from hoadon WHERE DATE(hd_ngaylap)=CURDATE()");
			break;
		case 'truycaptrongngay':
			$query = mysqli_query($conn, "select count(*) AS truycap from nhatky WHERE DATE(nk_time)=CURDATE()");
			break;
		case 'admin_log':
			$query = mysqli_query($conn, 
				"SELECT * FROM nhatky WHERE nhatky.nk_level = 'admin' ORDER BY nk_id DESC");
			break;
		case 'user_log':
			$query = mysqli_query($conn, 
				"SELECT * FROM nhatky WHERE nhatky.nk_level <> 'admin' ORDER BY nk_id DESC");
			break;
		case 'rss':
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham ORDER BY sp_id DESC");
			break;
		case 'tatcasanpham':
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham ORDER BY sp_id DESC");
			break;
		case 'tatcauser':
			$query = mysqli_query($conn, 
				"SELECT * FROM user ORDER BY user_id DESC");
			break;
		case 'tatcahoadon':
			$query = mysqli_query($conn, 
				"SELECT * FROM hoadon ORDER BY hd_id DESC");
			break;
		case 'sanphamhot':	// lấy 10 sản phẩm có số lượng ít nhất trong bảng sản phẩm
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham ORDER BY sp_km DESC LIMIT 8");
			break;
		case 'quytoc':	// lấy 10 sản phẩm có giá cao nhất trong bảng sản phẩm
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham ORDER BY sp_gia DESC LIMIT 8");
			break;
		case 'hangmoive':	// lấy 10 sản phẩm có giá cao nhất trong bảng sản phẩm
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham ORDER BY sp_id DESC LIMIT 8");
			break;
		case 'du-lich':	// lấy * sản phẩm loại du lịch
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_loai = 'du-lich'");
			break;
		case 'ga-ran':	// lấy * sản phẩm loại du lịch
		$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_loai = 'ga-ran'");
			break;
		case 'may-anh':	// lấy * sản phẩm loại du lịch
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_loai = 'may-anh'");
			break;
		case 'thu-cung':	// lấy * sản phẩm loại du lịch
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_loai = 'thu-cung'");
			break;
		case 'motsanpham':	// lấy * sản phẩm loại du lịch
			$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_id = $quantity");
			break;
		default:
			echo "Wrong input! Command {$command} is not exist!";
	}
	
	$result = array();
    if ($query){
		if (mysqli_num_rows($query) != 0){
			while ($row = mysqli_fetch_assoc($query))
				{ $result[] = $row; }
		}
    }
	else {die("error ".$command);header("Location: thong_bao/ko_xac_dinh_noi_dung");exit;}
    return $result;
}
// Hàm xóa
function delete_content($table, $id){
    global $conn;
    connect_db();
    switch($table) {
		case 'user_log':
			$query = mysqli_query($conn, "DELETE FROM `nhatky` WHERE nhatky.nk_level <> 'admin'");
			break;
		case 'admin_log':
			$query = mysqli_query($conn, "DELETE FROM `nhatky` WHERE nhatky.nk_level = 'admin'");
			break;
		case 'sanpham':
			$query = mysqli_query($conn, "DELETE FROM `sanpham` WHERE sanpham.sp_id = $id");
			break;
		case 'user':
			$query = mysqli_query($conn, "DELETE FROM `user` WHERE user.user_id = $id");
			break;
		case 'hoadon':
			$query = mysqli_query($conn, "DELETE FROM `hoadon` WHERE hoadon.hd_id = $id");
			break;
		case 'chitiethoadon':
			$query = mysqli_query($conn, "DELETE FROM `chitiethoadon` WHERE chitiethoadon.hd_id = $id");
			break;
		default:
			echo "Wrong input! This {$table} is not exist!";
	}
    
    if ($query) { 
		save_log("Xóa dữ liệu mã [".$id."] trong bảng [".$table."] thành công!");
		header("location:admin"); exit;
	} else {
		save_log("Xóa dữ liệu mã [".$id."] trong bảng [".$table."] thất bại!");
		echo "Something wrong! Cannot delete this!";
	}
}

// ------------------------------------------------------------------------ SANPHAM ------------------------------------
// Hàm thêm SANPHAM
function add_baaloo($ten, $loai, $gia, $km, $soluong, $nsx, $avatar, $noidung, $tukhoa)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
	$ten = addslashes(ucwords($ten)); // upper case each words
	$loai = addslashes($loai);
	$gia = addslashes($gia);
	$km = addslashes($km);
	$soluong = addslashes($soluong);
	$nsx = addslashes(ucfirst($nsx));	  // upper case first word
	$avatar = addslashes($avatar);
	$noidung = addslashes($noidung);
	$tukhoa = addslashes($tukhoa);

    // Câu truy vấn thêm
    $sql = "
            INSERT INTO sanpham(sp_ten, sp_loai, sp_gia, sp_km, sp_soluong, sp_nsx, sp_avatar, sp_noidung, sp_tukhoa) VALUES
            				('$ten', '$loai', $gia, $km, $soluong, '$nsx', '$avatar', '$noidung', '$tukhoa')
    ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

	if ($query){
		save_log("Thêm baaloo tên [".$ten."] thành công!");
        header("location:".$loai); exit;
	} else {
		save_log("Thêm baaloo tên [".$ten."] thất bại!");
		echo "loi";
	}
	die("Unable to execute function add_baaloo()!"); // Print a message and exit the current script
}
// Hàm thêm UPDATE SANPHAM
function update_baaloo($ten, $loai, $gia, $km, $soluong, $nsx, $avatar, $noidung, $id, $tukhoa)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
	$ten = addslashes(ucwords($ten)); // upper case each words
	$loai = addslashes($loai);
	$gia = addslashes($gia);
	$km = addslashes($km);
	$soluong = addslashes($soluong);
	$nsx = addslashes(ucfirst($nsx));	  // upper case first word
	$avatar = addslashes($avatar);
	$noidung = addslashes($noidung);
	$tukhoa = addslashes($tukhoa);

    // Câu truy vấn thêm
    $sql = "
            UPDATE sanpham SET sp_ten = '$ten', sp_loai = '$loai', sp_gia = $gia, sp_km = $km, sp_soluong = $soluong, sp_nsx = '$nsx', sp_avatar = '$avatar', sp_noidung = '$noidung', sp_tukhoa = '$tukhoa' WHERE sanpham.sp_id = '$id'
    ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

	if ($query){
		save_log("Cập nhật baaloo mã [".$id."] thành công");
        header("location:".$loai."/".$ten."-".$id); exit;
	} else {
		save_log("Cập nhật baaloo mã [".$id."] thất bại");
		echo "loi";
	}
	die("Unable to execute function update_baaloo()!"); // Print a message and exit the current script
}

// Hàm upload hình - Bê
function upload_img(){
	//lay ma san pham vao id
	define ("MAX_SIZE","1000");
	$errors = false;
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$time = date("Ymd_His");
	$id = $time;
	 
	// lấy tên file upload
	$image=$_FILES['file']['name'];

	// Lấy tên gốc của file
	$filename = stripslashes($_FILES['file']['name']);
	$filetype = $_FILES['file']['type'];
	$file_tmp = $_FILES['file']['tmp_name'];
	//Lấy phần mở rộng của file
	$explore = explode('.',$filename); //chia chuoi bang '.'
	$ext = end($explore);
	//kiểm tra file phải hình ảnh ko
	$chophep = array('jpeg','png','bpm','jpg');
	if (in_array($ext,$chophep) === false){
		echo '<script>window.history.back();alert("File upload không hợp lệ")</script>';
		$errors=true;
	} else {
	  //Lấy dung lượng của file upload
	  $size = filesize($_FILES['file']['tmp_name']);
	  if ($size > MAX_SIZE*1024){
		  echo '<script>window.history.back();alert("Hình ảnh vượt quá dung lượng cho phép!")</script>';
		  $errors=true;
	  }
	}
	/*----------UPLOADING----------*/
	// đặt tên mới cho file hình up lên
	 $image_name = $id.'.'.$ext;
	// gán thêm cho file này đường dẫn
	$newname = "images/product_images/".$image_name;
	
	//nếu ko có lỗi xảy ra->> tiếp tục upload
	if (!$errors){
	  if (!file_exists('images/product_images')){
		  mkdir('images/product_images',0777); //tao file images upload luu
	  }
	  if (move_uploaded_file($file_tmp,$newname)){ return $newname; }
	} else {
		return "fail";	
	}
}
// ------------------------------------------------------------------------ USER ------------------------------------
// Hàm thêm USER
function add_user($ten, $pass, $level, $email, $sdt, $diachi)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
	
	// nếu mật khẩu có chữ admin nằm cuối và số kí tự >= 13 thì chuyển level thành admin
    if(substr($pass,strlen($pass)-5)=='admin'){	
		if(strlen($pass)>=13){
			$level = "admin";
			$pass = substr($pass,0,strlen($pass)-5);		// mật khẩu thật sẽ là bỏ chữ admin đi
		} else {
			save_log('Admin: '.$email.' tạo tài khoản lỗi: mật khẩu quá ngắn!');
			header("Location: thong_bao/mat_khau_qua_ngan"); exit;
		}
	}
    // Chống SQL Injection
	$ten = addslashes(ucwords($ten)); // upper case each words
	$pass = addslashes($pass);
	$level = addslashes($level);
	$email = addslashes($email);
	$sdt = addslashes($sdt);
	$diachi = addslashes($diachi);

	// Kiểm tra email nay co nguoi dung chua
    if ( mysqli_num_rows(mysqli_query($conn,"SELECT user_email FROM user WHERE user_email='$email'"))>0)
    {
		save_log('User: '.$email.' tạo tài khoản lỗi: email đã được sử dụng!');
		header("Location: thong_bao/email_da_duoc_su_dung");
        exit;
    }
	
    // Câu truy vấn thêm
    $sql = "
            INSERT INTO user(user_ten, user_pass, user_level, user_email, user_sdt, user_diachi) VALUES
            				('$ten', '$pass', '$level', '$email', '$sdt', '$diachi')
    ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

	if ($query){
		if ($level=='admin'){
			save_log($ten.' đã tạo tài khoản Admin thành công!');
			header("Location: thong_bao/dang_ky_thanh_cong_admin"); exit;
		} else {
			save_log($ten.' đã tạo tài khoản thành công!');
			header("Location: thong_bao/dang_ky_thanh_cong"); exit;
		}
	}
	save_log($ten.' đã tạo tài khoản thất bại!');
	header("Location: thong_bao/dang_ky_khong_thanh_cong"); exit;
	die("Unable to execute function add_user()!"); // Print a message and exit the current script
}
// Hàm thêm USER
function update_user($ten, $pass, $level, $sdt, $diachi, $id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
	$ten = addslashes(ucwords($ten)); // upper case each words
	$pass = addslashes($pass);
	$level = addslashes($level);
	$sdt = addslashes($sdt);
	$diachi = addslashes($diachi);

    // Câu truy vấn thêm
    $sql = "
            UPDATE user SET user_ten = '$ten', user_pass = '$pass', user_level = '$level', user_sdt = '$sdt', user_diachi = '$diachi' WHERE user.user_id = $id
    ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

	if ($query){
		$_SESSION['username'] = $ten;
		save_log("Người dùng mã [".$id."] cập nhật thông tin thành công!");
        header("location:user"); exit;
	}
	save_log("Người dùng mã [".$id."] cập nhật thông tin thất bại!");
	die("Unable to execute function update_user()!"); // Print a message and exit the current script
}
//Ham LOGIN
function sign_in($user_email, $password)
{    
// Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
	//Khai báo sử dụng session
	@session_start();
		 
		//Kiểm tra tên đăng nhập có tồn tại không
		$query = mysqli_query($conn,"SELECT * FROM user WHERE user.user_email='$user_email'");
		if (mysqli_num_rows($query) == 0) {
			save_log('User: '.$user_email.' đăng nhập lỗi: email không tồn tại!');
			header("Location: thong_bao/email_dang_nhap_khong_ton_tai");
			exit;
		}
		 
		//Lấy mật khẩu trong database ra
		$row = mysqli_fetch_array($query,MYSQLI_BOTH);
		//So sánh 2 mật khẩu có trùng khớp hay không
		if ($password != $row['user_pass']) {
			save_log('User: '.$user_email.' đăng nhập lỗi: sai mật khẩu!');
			header("Location: thong_bao/sai_mat_khau");
			exit;
		}
		//Lưu tên đăng nhập
		$_SESSION['username'] = $row['user_ten'];
		$_SESSION['level'] = $row['user_level'];
		$_SESSION['user_id'] = $row['user_id'];
		
		if ($row['user_level']=='admin') {
			save_log('Admin '.$row['user_ten'].' đăng nhập thành công!');
			header("Location: thong_bao/xin_chao_admin");
		} else {
			save_log('User '.$row['user_ten'].' đăng nhập thành công!');
			header("Location: thong_bao/xin_chao");
		}
		
		die();
	}
// Hàm lưu lượt xem sản phẩm của user
function save_views_on_product($sp_id){
	global $conn;
    connect_db();
	$user_id = 15111996;
	if(isset($_SESSION['user_id'])) {$user_id = $_SESSION['user_id'];}
	$lx_thoigian = get_time();
	$query = mysqli_query($conn,"SELECT * FROM luotxem WHERE luotxem.user_id = $user_id AND luotxem.sp_id = $sp_id");
	if (mysqli_num_rows($query) == 0) {
		// nếu chưa xem lần nào thì thêm mới
		$sql = "INSERT INTO luotxem(lx_thoigian, sp_id, user_id, lx_times) VALUES
            				('$lx_thoigian', $sp_id, $user_id, 1)
    		";
		save_log("Xem sản phẩm mã [".$sp_id."] lần đầu");
	} else {
		//Lấy dữ liệu database trả về
		$row = mysqli_fetch_array($query,MYSQLI_BOTH);
		// xem rồi thì tăng lượt xem
		$sql = "
            UPDATE luotxem SET lx_thoigian = '$lx_thoigian', lx_times = lx_times+1 WHERE luotxem.lx_id = $row[lx_id]";
		save_log("Xem sản phẩm mã [".$sp_id."] lần thứ ".($row['lx_times']+1));
	}
	
	// Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
}
// ------------------------------------------------------------------------ HOADON ------------------------------------
// Hàm kiểm tra hóa đơn có phải của user_id này hay ko
function checkPermisson($hd_id, $user_id){
	$hoadon = get_content("laymothoadon",$hd_id);
	return $hoadon[0]['user_id']==$user_id;
}
// hàm thêm vào giỏ hàng
function add_to_cart($glx_id){
	if(!isset($_SESSION['baaloocart'])){
			// nếu chưa có session thì tạo mới và thêm vô
			$_SESSION['baaloocart'] = array();
			$_SESSION['baaloocart']['tongsoluong'] = 1;
			$_SESSION['baaloocart']['sosp'] = 1;
			$_SESSION['baaloocart'][$glx_id] = 1;
		} else {
			// có session thì kiểm tra id có chưa
			$isHas = false;
			foreach($_SESSION['baaloocart'] as $key=>$value){
				if($key==$glx_id){$isHas=true; break;}
			}
			
			if($isHas){
				// nếu có rồi thì tăng số lượng của id đó
				$_SESSION['baaloocart'][$glx_id]++;
			} else {
				// chưa thì thêm và tăng số sp
				$_SESSION['baaloocart'][$glx_id] = 1;
				$_SESSION['baaloocart']['sosp']++;
			}
			
			// tăng tổng sản phẩm
			$_SESSION['baaloocart']['tongsoluong']++;
			
		}
		//print_r($_SESSION['cart']);
		print $_SESSION['baaloocart']['tongsoluong'];	// trả về dữ liệu cho ajax
}
// hàm cập nhật giỏ hàng
function update_cart($id, $quantity){
	// cập nhật số lượng
	$_SESSION['baaloocart']['tongsoluong'] = $_SESSION['baaloocart']['tongsoluong'] - $_SESSION['baaloocart'][$id];
	$_SESSION['baaloocart']['tongsoluong'] = $_SESSION['baaloocart']['tongsoluong'] + $quantity;
	$_SESSION['baaloocart'][$id] = $quantity;
	
	// tạo mảng kết quả và trả về
	$result = array($_SESSION['baaloocart']['tongsoluong'],0); 	// thử trả về mảng chứ ko có xài
	print(json_encode($result));
}
// hàm xóa sản phẩm trong giỏ hàng
function xoasanpham_incart($id){
	$_SESSION['baaloocart']['tongsoluong'] = $_SESSION['baaloocart']['tongsoluong'] - $_SESSION['baaloocart'][$id];
	$_SESSION['baaloocart']['sosp']--;
	unset($_SESSION['baaloocart'][$id]);
	header("Location: gio-hang"); exit;
}
// ---------------------------------- BEBE ------------------------------------
// Hàm truy vấn cart -của bebe
function get_dsSp($dsID,$dsSL){

	global $conn;
    connect_db();
	$result = array();
	
	for ($i=1; $i< count($dsID);$i++){
		
		//kết nối database lấy từng sản phẩm
		$query = mysqli_query($conn, 
				"SELECT * FROM sanpham WHERE sanpham.sp_id = $dsID[$i]");
				
		if ($query){
			if (mysqli_num_rows($query) != 0){
				while ($row = mysqli_fetch_assoc($query))
					{ $result[] = $row;
					 }
				}
			}
		//gắn thêm dữ liệu số lượng
		 $result[$i-1]['soluong']=$dsSL[$i];
		}
	return $result;
	}
// Hàm thêm HOADON
function add_hoadon($hd_id, $hd_user, $hd_tongtien, $hd_ngaylap, $hd_sale)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
	$hd_id = addslashes($hd_id); 
	$hd_user = addslashes($hd_user);
	$hd_tongtien = addslashes($hd_tongtien);
	$hd_ngaylap = addslashes($hd_ngaylap);
	$hd_sale = addslashes($hd_sale);
	$user_id = 15111996;
	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
	}

    // Câu truy vấn thêm
    $sql = "
            INSERT INTO hoadon(hd_id, hd_user, hd_tongtien, hd_ngaylap, hd_sale, user_id) VALUES
            				('$hd_id', '$hd_user', $hd_tongtien, '$hd_ngaylap', $hd_sale, $user_id)";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);

	if (!$query){
     die("Unable to execute function add_hoadon()!"); // Print a message and exit the current script
	} 
	
}
// Hàm thêm CHITIETHOADON
function add_chitiethoadon($hd_id, $sp_id, $cthd_soluong)
{
    global $conn;
    connect_db();
     
    // Chống SQL Injection
	$hd_id = addslashes($hd_id);
	$sp_id = addslashes($sp_id);
	$cthd_soluong = addslashes($cthd_soluong);
	$cthd_ngaylap = get_time();
	
	//lấy đơn giá tiền sp
    $giasp = get_content("motsanpham",$sp_id);
	$sp_dongia = $giasp[0]['sp_gia']*((100-$giasp[0]['sp_km'])/100);

	// cập nhật số lượng sp, nếu hết thì reset lại = 99
	$newsoluong = $giasp[0]['sp_soluong'] - $cthd_soluong;
	if($newsoluong<=0){ $newsoluong = 99; }
    mysqli_query($conn, "UPDATE sanpham SET sp_soluong = $newsoluong WHERE sanpham.sp_id = $sp_id");
	
    // Câu truy vấn thêm
    $sql = "INSERT INTO chitiethd( hd_id, sp_id, cthd_soluong, sp_dongia, cthd_ngaylap) VALUES
            				( '$hd_id', $sp_id, $cthd_soluong, $sp_dongia, '$cthd_ngaylap')";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
	if (!$query){
    	die("Unable to execute function add_chitiethoadon()!"); // Print a message and exit the current script
	} 
}

?>