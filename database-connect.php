<?php
// -------------------------------------------------------------------- CONNECT TO DATABASE --------------------------
// Biến kết nối toàn cục
global $conn;
 
// Hàm kết nối database
function connect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu chưa kết nối thì thực hiện kết nối (host, username, pass, database name)
    if (!$conn){
		//$conn = mysqli_connect('localhost', 'id2461755_root', 'm*p15*11', 'id2461755_baaloo') or die ('Can\'t not connect to database');
        $conn = mysqli_connect('mysql.hostinger.vn', 'u423286300_baalo', 'm*p15*11phucbm', 'u423286300_baalo') or die ('Can\'t not connect to database');
        // Thiết lập font chữ kết nối
        mysqli_set_charset($conn, 'utf8');
    }
}
 
// Hàm ngắt kết nối
function disconnect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu đã kêt nối thì thực hiện ngắt kết nối
    if ($conn){
        mysqli_close($conn);
    }
}
?>