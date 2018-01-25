<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	session_start();
if($_SESSION['auth'] == 'yes_auth'){
	include ("include/db_connect.php");
	include("functions/functions.php");

		if($_POST["save_submit"]){
			
		  //$newpassquery = "`password`='".$newpass."',";
			$info_surname = clearStr ($_POST["info_surname"]);
			$info_name = clearStr ($_POST["info_name"]);
			$info_patronymid = clearStr ($_POST["info_patronymid"]);
			$info_address = clearStr ($_POST["info_address"]);
			$info_phone = clearStr ($_POST["info_phone"]);
			$info_email = clearStr ($_POST["info_email"]);
			
			$error = array();
			//сверка паролей
			$pass = md5($_POST["info_pass"]);
			
			if( $_SESSION['auth_pass'] != $pass){
					$error[] = 'Неверный текущий пароль';
			}else{
				 if($_POST['info_new_pass'] !=""){
					 if(strlen($_POST["info_new_pass"]) < 7 || strlen ($_POST["info_new_pass"]) >20){
						 $error [] = 'Укажите новый пароль от 7 до 20 символов';
					 }else{
						 $newpass = md5(clearStr($_POST["info_new_pass"]));
						 $newpassquery="pass='".$newpass."',";
						 
					 }
				} 
			}
				  if(strlen($info_surname) < 3 || strlen($info_surname)>20 ){
					$error[] = 'Укажите Фамилию от 3 до 20 символов';
				}
				if(strlen($info_name) < 3 || strlen($info_name)>20 ){
					$error[] = 'Укажите Имя от 3 до 20 символов';
				}
				if(strlen($info_patronymid) < 3 || strlen($info_patronymid)>20 ){
					$error[] = 'Укажите Отчество от 3 до 20 символов';
				}
				/* if(!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z{2,5})$/i",trim($info_email))){
					$error[] = 'Укажите корректный email';
				} */
				if(strlen($info_phone) =="" ){
					$error[] = 'Укажите номер телефона';
				}
				if(strlen($info_address) =="" ){
					$error[] = 'Укажите адрес доставки';
				} 
				if(count($error)){
					$_SESSION['msg'] = "<p align='left' id ='form-error'>".implode('<br />',$error)."</p>";
				} else{
					$_SESSION['msg'] = "<p align='left' id ='form-success'>Данные успешно сохранены</p>";  
				
					$dataquery = $newpassquery."`surname`='".$info_surname."',`name`='".$info_name."'
					,`patronymid`='".$info_patronymid."',`email`='".$info_email."',`phone`='".$info_phone."',`address`='".$info_address."'";
					$update =  mysqli_query($link,"UPDATE `reg_user` SET $dataquery WHERE `login` ='{$_SESSION['auth_login']}'");
				
				if($newpass){$_SESSION['auth_pass'] = $newpass;}
				
				$_SESSION['auth_surname'] = $info_surname;
				$_SESSION['auth_name'] = $info_name;
				$_SESSION['auth_patronymid'] = $info_patronymid;
				$_SESSION['auth_address'] = $info_address;
				$_SESSION['auth_phone'] = $info_phone;
				$_SESSION['auth_email'] = $info_email;
				
				}
			
		}
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Интернет магазин Цифровой техники</title>

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

	<h3 class="h3-title">Изменение профиля</h3>
	<?
		if($_SESSION['msg']){
			echo $_SESSION['msg'];
			unset ($_SESSION['msg']);
		}
	
	?>
	<form method="POST">
	<p id = "reg_massage"></p>
		
			<ul id="info-profile">
				<li>
				<label for="info_pass">Текущий пароль</label>
				<span class="star">*</span>
				<input type ="text" name = "info_pass" id="info_pass" value =""  />
				</li>
					
				<li>
				<label for="info_new_pass">Новый пароль</label>
				<span class="star">*</span>
				<input type ="text" name = "info_new_pass" id="info_new_pass" value =""  />
				</li>
				
				<li>
				<label for="info_surname">Фамилия</label>
				<span class="star">*</span>
				<input type ="text" name = "info_surname" id="info_surname" value ="<? echo $_SESSION['auth_surname'];  ?>"  />
				</li>
				
				<li>
				<label for="info_name">Имя</label>
				<span class="star">*</span>
				<input type ="text" name = "info_name" id="info_name" value ="<? echo 	$_SESSION['auth_name'];?>"  />
				</li>
				
				<li>
				<label for="info_patronymid">Отчество</label>
				<span class="star">*</span>
				<input type ="text" name = "info_patronymid" id="info_patronymid" value ="<? echo 	$_SESSION['auth_patronymid'];?>"  />
				</li>
	
				<li>
				<label for="info_email">Email</label>
				<span class="star">*</span>
				<input type ="text" name = "info_email" id="info_email" value ="<? echo 	$_SESSION['auth_email']; ?>"  />
				</li>
				
				<li>
				<label for="info_phone">Мобильный телефон</label>
				<span class="star">*</span>
				<input type ="text" name = "info_phone" id="info_phone" value ="<? echo 	$_SESSION['auth_phone']; ?>"  />
				</li>
				
				<li>
				<label for="info_address">Адрес доставки</label>
				<span class="star">*</span>
				<textarea name = "info_address"> <? echo $_SESSION['auth_address']; ?> </textarea>
				</li>
	
			</ul>
			

		
		<p align="right"><input type="submit" name="save_submit" id ="form_submit" value="Сохранить" /></p>
	<?php MassegeShowRed() ?>
	<?php MassegeShowGreen() ?>

	</form>
</div>
	<?php
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>
<?
}else {
	header("location:index.php");
}
?>