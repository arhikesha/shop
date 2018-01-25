<?php	
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");

	$id = clearStr($_GET ["id"]);
	$action = clearStr ($_GET ["action"]);
	
	switch ($action){
		
		case 'clear':
		$clear = mysqli_query($link,"DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
		break;
		
		case 'delete':
		$delete = mysqli_query($link,"DELETE FROM cart WHERE cart_id = '$id' AND cart_ip ='{$_SERVER['REMOTE_ADDR']}'");
		break;
	}
	
	if(isset($_POST["submitdata"])){
		if($_SESSION['auth']=='yes_auth'){
			
			mysqli_query($link,"INSERT INTO `orders`(`order_datetime` ,`order_confimed`,`order_dostavka` ,`order_pay`,`order_type_pay`,`order_fio` ,`order_address` ,`order_phone` ,`order_note` ,`order_email`)
																VALUES (
																NOW(),
																'no',
																'".$_POST["order_delivery"]."',  
																'',
																'',
																'".$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymid']."',  
																'".$_SESSION['auth_address']."',  
																'".$_SESSION['auth_phone']."',
																'".$_POST["order_note"]."',  
																'".$_SESSION['auth_email']."')");
															
													
		}	else{
		$_SESSION["order_delivery"] = $_POST["order_delivery"];
		$_SESSION["order_fio"] = $_POST["order_fio"];
		$_SESSION["order_email"] = $_POST["order_email"];
		$_SESSION["order_phone"] = $_POST["order_phone"];
		$_SESSION["order_address"] = $_POST["order_address"];
		$_SESSION["order_note"] = $_POST["order_note"];
		
			
			mysqli_query($link,"INSERT INTO `orders`(`order_datetime` ,`order_confimed`,`order_dostavka` ,`order_pay`,`order_type_pay`,`order_fio` ,`order_address` ,`order_phone` ,`order_note` ,`order_email`)
																VALUES (
																NOW(),
																'',
																'".clearStr($_POST["order_delivery"])."',
																'',
																'',
																'".clearStr($_POST["order_fio"])."',
																'".clearStr($_POST["order_address"])."',
																'".clearStr($_POST["order_phone"])."',
																'".clearStr($_POST["order_note"])."',
																'".clearStr($_POST["order_email"])."')");
		}
		
		$_SESSION["order_id"] = mysqli_insert_id($link);
	
		$result= mysqli_query($link,"SELECT * FROM cart WHERE cart_ip = '{$_SERVER ['REMOTE_ADDR']}'");
		if(mysqli_num_rows($result)>0){
			$row =mysqli_fetch_array($result);
			do{
		
				mysqli_query($link,"INSERT INTO `bay_products` (`buy_id_order`, `buy_id_product`, `buy_count_product`)
													VALUES(
													'".$_SESSION["order_id"]."',
													'".$row["cart_id_products"]."',
													'".$row["cart_count"]."'
													)");
			}while($row = mysqli_fetch_array($result));
		}
		
	
		header("Location:cart.php?action=complection");	
}
		$result = mysqli_query($link,"SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER ['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
		
		if(mysqli_num_rows($result)>0){
			
			$row = mysqli_fetch_array($result);
			do{
				$int =$int + ($row ["price"] * $row ["cart_count"]);
			}while ($row = mysqli_fetch_array($result));
				
				$itogpricecart = $int;
		}
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Корзина заказов</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/shop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="jquery ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/shop-script.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/textchange.js"></script>

<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
<link rel="stylesheet" type="text/css" href="jquery ui/jquery-ui.css" >


</head>
<body>
	
	<div id="block-body"> 
	<?php
		include ("include/block-header.php");
	?>
	<div id="block-rigth"> 
	<?php
		include ("include/block-category.php");
		include ("include/block-parametr.php");
		include ("include/block-news<.php");
	?>
	</div>
	
	<div id="block-content"> 
	<?
		$action = clearStr($_GET["action"]);
		switch ($action){
			
				case 'oneclick':
		echo '
			<div id = "block-step">
				<div id ="name-step">
					<ul>
						<li><a class="active">1.Корзина товаров</a></li>
						<li><span>&rarr;</span></li>
						<li><a>2.Контактная информация</a></li>
						<li><span>&rarr;</span></li>
						<li><a>3.Завершение</a></li>
					</ul>
				</div>
				<p>Шаг 1 из 3</p>
				<a href= "cart.php?action=clear" >Очистить</a>
						
			</div>
			';			
			
			
		
		$result = mysqli_query($link,"SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER ['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
		
		if(mysqli_num_rows($result)>0){
			
			$row = mysqli_fetch_array($result);
			echo '
				
				<div id ="header-list-cart">
				<div id ="head1">Изображение</div>
				<div id ="head2">Наименование товара</div>
				<div id ="head3">Кол-во</div>
				<div id ="head4">Цена</div>
				</div>
			';
			
			do{
				$int = $row ["cart_price"] * $row ["cart_count"];//цена товара
				$all_price = $all_price +$int;//прибавление к непосредственно товару
				
				if(strlen($row["image"])>0 && file_exists("./upload_images/".$row["image"]))//file_exists -если фаил существует
			{
				$img_path = './upload_images/'.$row["image"];
				$max_width = 100;
				$max_height = 100;
					list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);
				
				$width = intval($ratio*$width);
				$height = intval($ratio*$height);
			}else
			{
				$img_path = "/image/no-image.png";
				$width = 120;
				$height = 105;
				
				
			}
				echo '
			
		<div class = "block-list-start">
			
			<div class = "img-cart">
			<p align="center"><img src = "'.$img_path .'" width="'.$width.'" height="'.$height.'"/></p>
			</div>
			<div class="title-cart">
			<p><a href ="">'.$row["title"].'</a></p>
			<p class = "cart-mini_features">'.$row["mini_features"].'</p>
			</div>
			
			<div class = "couth-cart">
				<ul class = "input-count-style">
			
			<li>
				<p align="center" iid="'.$row["cart_id"].'" class="count-minus">-</p>
			</li>
			
			<li>
				<p align="center"><input iid="'.$row["cart_id"].'" id = "input-id'.$row["cart_id"].'" class="count-input"  '.$row["cart_id"].' maxlength="3" type="text" value="'.$row["cart_count"].'"/></p>
			</li>
			
			<li>
				<p align="center"  iid="'.$row["cart_id"].'" class="count-plus" '.$row["cart_id"].'>+</p>
			</li>
			
				</ul>
			</div>
			
			<div id = "tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">"'.$row["cart_count"].'"</span> x <span>'.$row["cart_price"].'руб</span></h5><p price ="'.$row["cart_price"].'">'.group_numerals($int).'руб</p></div>
			<div class="delete-cart"><a href ="cart.php?id='.$row["cart_id"].'&action=delete"><img src ="image/krest.png" /></a></div>
			
			<div id ="bottom-cart-line"></div>
		</div>
			
			';
	
			}while ($row = mysqli_fetch_array($result));
			echo'
			<h2 class = "itog-price" align="right">Итого:<strong>'.group_numerals($all_price).'</strong> руб.</h2>
			<p align = "right" class="button-next"><a href="cart.php?action=confirm">Далее </a></p>
			';
		}else{
			echo '<h3 id ="clear-cart" align="center">Корзина пуста</h3>';
		}
				break;
				
				case 'confirm':
				echo '
			<div id = "block-step">
				<div id ="name-step">
					<ul>
						<li><a href="cart.php?action=oneclick">1.Корзина товаров</a></li>
						<li><span>&rarr;</span></li>
						<li><a class="active">2.Контактная информация</a></li>
						<li><span>&rarr;</span></li>
						<li><a>3.Завершение</a></li>
					</ul>
				</div>
				<p>Шаг 2 из 3</p>	
			</div>
			';		
				
				
				if($_SESSION ['order_delivery'] == "По почте")$chck1 = "checked";
				if($_SESSION ['order_delivery'] == "Курьером")$chck2 = "checked";
				if($_SESSION ['order_delivery'] == "Самовывоз")$chck3 = "checked";
				
				echo '
				
				<h3 class = "title-h3">Способы доставки:</h3>
				<form method = "POST">
				<ul id ="info-radio">
				
				<li>
				<input type ="radio" name ="order_delivery" class ="order_delivery" id="order_delivery1" value = "По почте" '.$chck1.'/>
				<label class ="label_delivery" for ="order_delivery1">По почте</label>
				</li>
				
				<li>
				<input type ="radio" name ="order_delivery" class ="order_delivery" id="order_delivery2" value ="Курьером" '.$chck2.'/>
				<label class ="label_delivery" for ="order_delivery2">Курьером</label>
				</li>
				
				<li>
				<input type ="radio" name ="order_delivery" class ="order_delivery" id="order_delivery3" value ="Самовывоз" '.$chck3.'/>
				<label class ="label_delivery" for ="order_delivery3">Самовывоз</label>
				</li>
				</ul>
				
				<h3 class="title-h3">Информация для доставки </h3>
				<ul id="info-order">
				';
				if ($_SESSION ['auth'] != "yes_auth"){
					echo '
					<li><label for = "order_fio">ФИО</label><input type="text" name="order_fio" id="order_fio" value ="'.$_SESSION["order_fio"].'" /><span class ="order_span_style">Пример: Иванов Иван Иванович </span></li>
					<li><label for = "order_email">E-mail</label><input type="text" name="order_email" id="order_email" value ="'.$_SESSION["order_email"].'" /><span class ="order_span_style">Пример: ivanov@gmail.ru </span></li>
					<li><label for = "order_phone">Телефон</label><input type="text" name="order_phone" id="order_phone" value ="'.$_SESSION["order_phone"].'" /><span class ="order_span_style">Пример: 099 468 40 53 </span></li>
					<li><label class ="order_label_style" for = "order_address">Адрес</label><input type="text" name="order_address" id="order_address" value ="'.$_SESSION["order_address"].'" /><span class ="order_span_style">Пример: г.Днепропетровск,ул.Каменская 38, кв.7 </span></li>
					';
				}
				echo '
				<li><label class = "order_label_style" for ="order_note">Примечание</label><textarea name = "order_note" >'.$_SESSION["order_note"].'</textarea><span>Уточните информацию о заказе.<br /> Например , удобное время для звонка <br /> нашего менеджера</span></li>
				</ul>
				<p align ="right" ><input type ="submit" name = "submitdata" id="confirm_botton_next" value= "Далее" /></p>
				</form>
				';
				
				break;
				
				case 'complection':
				
					echo '
			<div id = "block-step">
				<div id ="name-step">
					<ul>
						<li><a href = "cart.php?action=oneclick" >1.Корзина товаров</a></li>
						<li><span>&rarr;</span></li>
						<li><a href ="cart.php?action=confirm">2.Контактная информация</a></li>
						<li><span>&rarr;</span></li>
						<li><a class="active">3.Завершение</a></li>
					</ul>
				</div>
				<p>Шаг 3 из 3</p>
			</div>
			<h3>Конечная информация</h3>
			';	
			
			if($_SESSION ['auth'] =='yes_auth'){
				
			
			echo '
			<ul id ="list-info">
			<li><strong>Способ доставки:</strong> '.$_SESSION['order_delivery'].'</li>
			<li><strong>Email:</strong> '.$_SESSION['auth_email'].'</li>
			<li><strong>ФИО:</strong> '.$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymid'].'</li>
			<li><strong>Адрес доставки:</strong> '.$_SESSION['auth_address'].'</li>
			<li><strong>Телефон:</strong> '.$_SESSION['auth_phone'].'</li>
			<li><strong>Примечание:</strong> '.$_SESSION['order_note'].'</li>
			</ul>
			';
			}else {
				echo'
				<ul id ="list-info">
			<li><strong>Способ доставки:</strong> '.$_SESSION['order_delivery'].'</li>
			<li><strong>Email:</strong> '.$_SESSION['order_email'].'</li>
			<li><strong>ФИО:</strong> '.$_SESSION['order_fio'].' </li>
			<li><strong>Адрес доставки:</strong> '.$_SESSION['order_address'].'</li>
			<li><strong>Телефон:</strong> '.$_SESSION['order_phone'].'</li>
			<li><strong>Примечание:</strong> '.$_SESSION['order_note'].'</li>
			</ul>
				';
			}
			echo '
			<h2 class = "itog-price" align="right">Итого:<strong>'.group_numerals($itogpricecart).'</strong> руб.</h2>
			<p align = "right" class="button-next"><a href="">Оплатить </a></p>
			';
			
				break;
				
				default :
					echo '
			<div id = "block-step">
				<div id ="name-step">
					<ul>
						<li><a class="active">1.Корзина товаров</a></li>
						<li><span>&rarr;</span></li>
						<li><a>2.Контактная информация</a></li>
						<li><span>&rarr;</span></li>
						<li><a>3.Завершение</a></li>
					</ul>
				</div>
				<p>Шаг 1 из 3</p>
				<a href= "cart.php?action=clear" >Очистить</a>
						
			</div>
			';			
			
			
		
		$result = mysqli_query($link,"SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER ['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
		
		if(mysqli_num_rows($result)>0){
			
			$row = mysqli_fetch_array($result);
			echo '
				
				<div id ="header-list-cart">
				<div id ="head1">Изображение</div>
				<div id ="head2">Наименование товара</div>
				<div id ="head3">Кол-во</div>
				<div id ="head4">Цена</div>
				</div>
			';
			
			do{
				$int = $row ["cart_price"] * $row ["cart_count"];//цена товара
				$all_price = $all_price +$int;//прибавление к непосредственно товару
				
				if(strlen($row["image"])>0 && file_exists("./upload_images/".$row["image"]))//file_exists -если фаил существует
			{
				$img_path = './upload_images/'.$row["image"];
				$max_width = 100;
				$max_height = 100;
					list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);
				
				$width = intval($ratio*$width);
				$height = intval($ratio*$height);
			}else
			{
				$img_path = "/image/no-image.png";
				$width = 120;
				$height = 105;
				
				
			}
				echo '
			
			<div class = "block-list-start">
			
			<div class = "img-cart">
			<p align="center"><img src = "'.$img_path .'" width="'.$width.'" height="'.$height.'"/></p>
			</div>
			<div class="title-cart">
			<p><a href ="">'.$row["title"].'</a></p>
			<p class = "cart-mini_features">'.$row["mini_features"].'</p>
			</div>
			
			<div class = "couth-cart">
				<ul class = "input-count-style">
			
			<li>
				<p align="center" iid="'.$row["cart_id"].'" class="count-minus" >-</p>
			</li>
			
			<li>
				<p align="center"><input iid="'.$row["cart_id"].'" id = "input-id'.$row["cart_id"].'" class="count-input"  '.$row["cart_id"].' maxlength="3" type="text" value="'.$row["cart_count"].'"/></p>
			</li>
			
			<li>
				<p align="center" iid="'.$row["cart_id"].'" class="count-plus"  '.$row["cart_id"].'>+</p>
			</li>
			
				</ul>
			</div>
			
			<div id = "tovar'.$row["cart_id"].'" class="price-product"><h5><span class="span-count">"'.$row["cart_count"].'"</span> x <span>'.$row["cart_price"].'руб</span></h5><p price ="'.$row["cart_price"].'">'.group_numerals($int).'руб.</p></div>
			<div class="delete-cart"><a href ="cart.php?id='.$row["cart_id"].'&action=delete"><img src ="image/krest.png" /></a></div>
			
			<div id ="bottom-cart-line"></div>
		</div>
			
			';
	
			}while ($row = mysqli_fetch_array($result));
			echo'
				<h2 class = "itog-price" align="right">Итого:<strong>'.group_numerals($all_price).'</strong> руб</h2>
			<p align = "right" class="button-next"><a href="cart.php?action=confirm">Далее </a></p>
			';
		}else{
			echo '<h3 id ="clear-cart" align="center">Корзина пуста</h3>';
		}
				break;
		}
	
	?>
	
	</div>
	<?php
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>