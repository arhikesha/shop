$(document).ready(function() {
  $('#newsticker').jCarouselLite({
  btnPrev: "#news-prev",
  btnNext: "#news-next",
        btnGo: null,
        mouseWheel: false,
        auto: 3000,
        hoverPause: true,
        speed: 500,
        easing: null,
        vertical: true,
        circular: true,
        visible: 2,
        start: 1,
        scroll: 1,
        beforeStart: null,
        afterEnd: null
 });
 //обновление корзины
 loadcart();
 //////////////Блок Вида сортировки товара grid и list
 $("#style-grid").click(function() {
	 $("#block-tovar-grid").show();
	 $( "#block-tovar-list" ).hide();
	 
	 $("#style-grid").attr("src","image/Gnome-View-Sort-Ascending-red.png");
	 $("#style-list").attr("src","image/Gnome-View-Sort-Descending-green.png");
	 
	 $.cookie('select_style','grid');
 });
 
  $("#style-list").click(function() {
		$( "#block-tovar-grid" ).hide();
		$("#block-tovar-list").show();
		
	 $("#style-list").attr("src","image/Gnome-View-Sort-Ascending-red.png");
	 $("#style-grid").attr("src","image/Gnome-View-Sort-Descending-green.png");
 
	  $.cookie('select_style','list');
 });

 if($.cookie('select_style') =='grid')
 {
	 $("#block-tovar-grid").show();
	 $( "#block-tovar-list" ).hide();
	 
	 $("#style-grid").attr("src","image/Gnome-View-Sort-Ascending-red.png");
	 $("#style-list").attr("src","image/Gnome-View-Sort-Descending-green.png");
 }
 else
 {
	$( "#block-tovar-grid" ).hide();
	$("#block-tovar-list").show();
		
	$("#style-list").attr("src","image/Gnome-View-Sort-Ascending-red.png");
	$("#style-grid").attr("src","image/Gnome-View-Sort-Descending-green.png");
	 
 }
 
 
 //Меню сортировки товаров (от дешевых к дорогим и тд)
 $("#select-sort").click(function() {
 
	$("#sorting-list").slideToggle(200);

 });
 ////////////////Барабан на категориях mobile notebook notepad
 $('#block-category > ul >li > a').click (function(){
	 if($(this).attr('class') != 'active'){
		 
		 $('#block-category >ul >li > ul').slideUp(400);//если открыто закрывает
		 $(this).next().slideToggle(400);//если закрыто закрывает next (открывает список 	<ul class="category-section">)
				
				$('#block-category >ul >li >a').removeClass('active');// Удаление всех классов
				$(this).addClass('active');//присвоенние конкретной категории
				$.cookie ('select_cat' , $(this).attr('id'));// id категорий
	
	}else{
		
		$('#block-category >ul >li >a').removeClass('active');//удаляет все активные классы
		$('#block-category >ul >li > ul').slideUp(400);//закрыть все списки
		$.cookie('select_cat', '');
	}
 });
 
 if($.cookie('select_cat') !=''){
	 
	 $('#block-category >ul >li >#'+$.cookie('select_cat')).addClass('active').next().show();
 }
	 
 $('#reloadcaptcha').click(function(){
 $('#block-captcha > img').attr("src","reg/captcha.php");
	 
 });
 ////////БЛОК ВХОДА
$(".top-auth").click(function(){
	$("#block-top-auth").toggle("slow");
});
 	 
	 //////////////////////
	$("#botton_auth").click(function(){
	
	var auth_login = $("#auth_login").val();
	var auth_pass = $("#auth_pass").val();
	
	if(auth_login == "" || auth_login.length >= 30 ){
			 $("#auth_login").css ("borderColor","#FDB6B6");
			 send_login = 'no';
	}else {
			 $("#auth_login").css ("borderColor","DBDBDB");
			 send_login ='yes';
		 }
		 if(auth_pass == "" || auth_pass.length >= 30 ){
			 $("#auth_pass").css ("borderColor","#FDB6B6");
			 send_pass = 'no';
	}else {
			 $("#auth_pass").css ("borderColor","DBDBDB");
			 send_pass ='yes';
		 }
	if ($("#rememberme").prop('checked')){
			 auth_rememberme = 'yes';
		 }else { auth_rememberme = 'no';}
	if(send_login =='yes' && send_pass == 'yes'){
			// $("#botton_auth").hide();
			// $(".loading").hide();
	$.ajax({
			type: "POST",
			url:"include/auth.php",
			data:"login="+auth_login+"&pass="+auth_pass+"&rememberme="+auth_rememberme,
			dataType:"html",
			cache:false,
			success:function(data){
				if(data == 'yes_auth'){
					location.reload();
				}else {
					$("#massege-auth").slideDown(400);
					
					}
				}	
		});
	}
});
	  ///////////////
	 $('#remindpass').click(function (){
		 $('#input-email-pass').fadeOut(200,function(){
			 $('#block-remind').fadeIn(300);
		 });
		 $('#prev-auth').click(function(){
			 $('#block-remind').fadeOut(200,function(){
			 $('#input-email-pass').fadeIn(300);
			}); 
		 });
	 });
	 /////////////////БЛОК ЗАБЫЛИ ПАРОЛЬ
	 $('#button-remind').click(function (){
		 
		 var recall_email = $('#remind-email').val();//val()- это значение инпута value
		 
		 if(recall_email =="" || recall_email.length >25){
			 $("#remind-email").css("borderColor","#FDB6B6");
		 }else {
			 $("#remind-email").css("#borderColor","#DBDBDB");
			 
			 //$("#button-remind").hide();-кнопка прчется
			 //$("#load").show();- картинка загрузки появляется
		 
				$.ajax({
			 type:"POST",
			 url:"include/remind-pass.php",
			 data:"email="+recall_email,
			 dataType:"html",
			 cache:false,
			 success:function(data){
				 
				  if(data =="yes"){
					 $('#massege-remind').attr ("class","massege-remind-success").html("На ваш email выслан новый пароль.").slideDown(400);
				 
					setTimeout ("$('#massege-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()",3000);
				
				}else {
					  $('#massege-remind').attr ("class","massege-remind-error").html(data).slideDown(400);
					} 
				}			 
			}); 
		 } 
	 });
	 /////////////////////Блок входа в профиль
	 $('#auth-user-info').click(function(){
			$("#block-user").toggle(100);
	 });
	 ///////////////////////аякс зарос выхода из профился
	$("#logout").click(function(){
		
		$.ajax ({
			type:"POST",
			url:"include/logout.php",
			dataType:"html",
			cache:false,
			success:function(data){
				
				if(data =='logout'){
					location.reload();
				}
			}
		});
	});
	$('#input-search').bind('textchange',function(){
		var input_search = $('#input-search').val();
		
		if(input_search.length >= 1 && input_search.length <64){
			$.ajax({
				type:"POST",
				url:"include/search.php",
				data:"text="+input_search,
				dataType:"html",
				cache:false,
				success:function(data){
				
				if(data >''){
					$("#result-search").show().html(data);
				}else{
					$("#result-search").hide();
					}
				}
			});
		}else{
			$("#result-search").hide();
		}
	});
	
	//Шаблон проверки на email на правильность
	 function isValidEmailAddress (emailAddress){
		var pattern = new RegExp (/^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$/i);
		return pattern.test(emailAddress);
	} 
	// контактные данные
	 $('#confirm_botton_next').click(function(e){
		
		var order_fio = $("#order_fio").val();
		var order_email = $("#order_email").val();
		var order_phone = $("#order_phone").val();
		var order_address = $("#order_address").val();
		
		
		if(!$(".order_delivery").is(":checked")){
			$(".label_delivery").css ("color","#E07B7B");
			send_order_delivery = '0';//переменная определяющая заполнены ли радиобоксы
		}else {$(".label_delivery").css("color","black");send_order_delivery ='1';
		
		//Проверка ФИО
		if(order_fio =="" || order_fio.length > 50){
			$("#order_fio").css ("borderColor","#FDB6B6");
			send_order_fio = '0';
		}else {$("#order_fio").css("borderColor","#DBDBDB");send_order_fio='1';}
		//Проверка email
		 if(order_email =="" || isValidEmailAddress(order_email)==false){
			$("#order_email").css ("borderColor","#FDB6B6");
			send_order_email = '0';
		}else {$("#order_email").css("borderColor","#DBDBDB");send_order_email='1';} 
		//Проверка адреса
		if(order_address =="" || order_address.length > 150){
			$("#order_address").css ("borderColor","#FDB6B6");
			send_order_address = '0';
		}else {$("#order_address").css("borderColor","#DBDBDB");send_order_address='1';}
		}
		// глобальная проверка
		if (send_order_delivery =="1" && send_order_fio =="1" && send_order_email =="1" && send_order_address =="1"){
			return true;
		}
		e.preventDefault(); //если не прошла проверка на true то не перегружает страницу
	});
	
	//добавление товара в корзину
	$('.add-cart-style-grid ,.add-cart-style-list ,.add-cart,.random-add-cart').click (function (){
		
		var tid = $(this).attr("tid");
		
		$.ajax ({
			type:"POST",
			url:"include/addtocart.php",
			data:"id="+tid,
			dataType:"html",
			cache:false,
			success:function(data){
				loadcart();
			}
		});
	});
	
	function loadcart(){
				$.ajax ({
			type:"POST",
			url:"include/loadcart.php",
			dataType:"html",
			cache:false,
			success:function(data){
				if (data =="0"){
					$("#block-basket > a").html ("Корзина пуста");
				}else{
					$("#block-basket > a").html(data);
					$(".itog-price > strong").html(fun_group_price(itogprice));
					}	
				}
			});
	}
	// фунция группировки по разрядам 
	function fun_group_price(itogprice){
		var result_total = String (intprice);
		var lenstr = result_total.length;
		
			switch (lenstr){
				
				case 4:{
					groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
					break;
				}
					case 5:{
					groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
					break;
				}
					case 6:{
					groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6);
					break;
				}
					case 6:{
					groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7);
					break;
				}
				default:{
					groupprice = result_total;
				}
			}
			return groupprice;
		}
		///////Добавление , отбавление товара
	$('.count-minus').click(function (){
		
		var iid = $(this).attr("iid");
		
		$.ajax ({
			type:"POST",
			url:"include/count-minus.php",
			data:"id="+iid,
			dataType:"html",
			cache:false,
			success:function(data){
				$("#input-id"+iid).val(data);
				loadcart();
				
				//Переменная с ценной продука
				var priceproduct = $("#tovar"+iid+" > p").attr("price");
				//Цену умножаем на колличество
				result_total = Number(priceproduct) * Number(data);
				//fun_group_price(result_total)
			
				$("#tovar"+iid+" > p").html (result_total+" руб");
				$("#tovar"+iid+" > h5 >.span-count").html (data);
			

				itog_price();
			}	
		});
	});
	
		$('.count-plus').click(function (){
		
		var iid = $(this).attr("iid");
		
		$.ajax ({
			type:"POST",
			url:"include/count-plus.php",
			data:"id="+iid,
			dataType:"html",
			cache:false,
			success:function(data){
				$("#input-id"+iid).val(data);
				loadcart();
				
				//Переменная с ценной продука
				var priceproduct = $("#tovar" +iid+" >p").attr("price");
				//Цену умножаем на колличество
				result_total = Number (priceproduct)  * Number (data);
				//fun_group_price(result_total)
				
				$("#tovar"+iid+" > p").html (result_total+" руб");
				$("#tovar"+iid+" > h5 >.span-count").html (data);
				
				itog_price();
			}	
		});
	});
	
	$('.count-input').keypress(function (e){
		
		if(e.keyCode == 13){
		var iid = $(this).attr("iid");
		var incount = $("#input-id"+iid).val();
		
		$.ajax ({
			type:"POST",
			url:"include/count-input.php",
			data:"id="+iid+"&count="+incount,
			dataType:"html",
			cache:false,
			success:function(data){
				$("#input-id"+iid).val(data);
				loadcart();
				
				//Переменная с ценной продука
				var priceproduct = $ ("#tovar" +iid+" >p").attr("price");
				//Цену умножаем на колличество
				result_total = Number (priceproduct)  * Number (data);
				//fun_group_price(result_total)
				$("#tovar"+iid+">h5 >.span-count").html (data);
				$("#tovar"+iid+">p").html (result_total+" руб");
				
				
				itog_price();
				}	
			});
		}	
	});
	function itog_price (){
			$.ajax ({
			type:"POST",
			url:"include/itog_price.php",
			dataType:"html",
			cache:false,
			success:function(data){
				$(".itog-price > strong").html(data);
		
			}
		});
	}
	
	$('#button-send-review').click(function (){
		
		var name = $("#name_review").val();
		var good = $("#good_review").val();
		var bad = $("#bad_review").val();
		var comment = $("#comment_review").val();
		var iid = $("#button-send-review").attr("iid");
		
		if(name != ""){
			name_review = '1';
			$("#name_review").css("borderColor","#DBDBDB");	
		}else {
			name_review = '0';
			$("#name_review").css("borderColor","#FDB6B6");	
		}
		if(good != ""){
			good_review = '1';
			$("#good_review").css("borderColor","#DBDBDB");	
		}else {
			good_review = '0';
			$("#good_review").css("borderColor","#FDB6B6");	
		}
		if(bad != ""){
			bad_review = '1';
			$("#bad_review").css("borderColor","#DBDBDB");	
		}else {
			bad_review = '0';
			$("#bad_review").css("borderColor","#FDB6B6");	
		}
		//глобальная проверка и оптравка отзыва
		if( name_review == '1' && good_review =='1' && bad_review =='1'){
			$("#button-send-review").hide();
			$("#reload-img").show();
			
				$.ajax ({
					type:"POST",
					url:"include/add_review.php",
					data: "id="+iid+"&name="+name+"&good="+good+"&bad="+bad+"&comment="+comment,
					dataType:"html",
					cache:false,
					success:function(response) 
                {
                   if(response == "OK")
                   {
										 setTimeout("$.fancybox.close()",1000);
                     location.reload();
									 }	
                 }
				});	
		}
	});
	//Like
	$('#likegood').click(function (){
		var tid = $(this).attr("tid");
		
		$.ajax ({
					type:"POST",
					url:"include/like.php",
					data: "id="+tid,
					dataType:"html",
					cache:false,
					success:function(data) {
                  
									if(data == "no")
                   {
										alert ('Вы уже голосовали');
									 }else {
										 $("#likegoodcount").html(data);
									 }	
                 }
				});	
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});