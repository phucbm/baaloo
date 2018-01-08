function addtocart(id){
        var ajaxurl = 'xulygiohang.php',					// gọi tới trang này
        data =  {'addtocart': id};							// gửi biến $_POST['addtocart'] = id;
        $.post(ajaxurl, data, function (response) {
			 $('span#soluongsp').text(response);
        });
}

function updatetongtien(){
	var sophantu = parseInt($('#elements').text());
	var tongtien = 0;
	for(var i=1; i<=sophantu; i++){
		//alert($('.element'+i).text());
		tongtien += parseFloat($('.element'+i).text());
	}
	$('#tongtien').text(tongtien);
}
/*function xoasanpham(id){
	var ajaxurl = 'xulygiohang.php',					// gọi tới trang này
        data =  {'xoasanpham': id};							// gửi biến $_POST['addtocart'] = id;
        $.post(ajaxurl, data, function () {
        });
	$("#baaloo"+id).css("display","none");
}*/
window.onload = function() {
  updatetongtien();
};
function updatecart(id){
		var quantity = parseInt($('#soluong'+id).val());
		var dongia = parseFloat($('#dongiadakm'+id).text());
		var newprice = dongia*quantity;
		$('#sanpham'+id).text(newprice);
        var ajaxurl = 'xulygiohang.php',					// gọi tới trang này
        data =  {'update': id, 'quantity': quantity};							// gửi biến $_POST['addtocart'] = id;
        $.post(ajaxurl, data, function (response) {
			 if(response){
				var resultObj = eval(response);	// chuyển json từ php thành array
				$('span#soluongsp').text(resultObj[0]);
				$('span#giohangsoluong').text(resultObj[0]);
			  }else{
				alert("error");
			  }
        });
		updatetongtien();
}