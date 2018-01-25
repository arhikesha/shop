<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");
/* 	 unset($_SESSION['auth']);//уничтожает сессию
	setcookie ('rememberme','',0,"/");//уничтожает cookie */ 
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Регестрация</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/shop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="jquery ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/shop-script.js"></script>
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

	<h2 class="h2-title">Регистрация</h2>
	<?php MassegeShowRed() ?>
	<?php MassegeShowGreen() ?>
	<form method="POST" id="form_reg" action="reg/accaunt.php">
	<p id = "reg_massage"></p>
		<div id= "block-form-register">
			<ul id="form-register">
				<li>
				<label>Логин</label>
				<span class="star">*</span>
				<input type ="text" name = "login" placeholder="Логин" maxlength="10" pattern="[A-Za-z-0-9]{3,10}" title ="не менее 3 или 10 латинских символов" id="reg_loin" required />
				</li>
					
				<li>
					<label>Пароль</label>
					<span class="star">*</span>
					<input type ="password" name = "password"placeholder="Пароль" maxlength="10" pattern="[A-Za-z-0-9]{5,15}" title ="не менее 5 или 15 латинских символов" id="reg_pass" required />
				</li>
				
				<li>
				<label>Фамилия</label>
				<span class="star">*</span>
				<input type ="text" name = "surname" placeholder="Фамилия" maxlength="10" pattern="[А-Яа-яЁе]{3,15}" title ="не менее 3 или 15 русских символов"  id="reg_surname" required />
				</li>
				
				<li>
				<label>Имя</label>
				<span class="star">*</span>
				<input type ="text"name = "name" placeholder="Имя" maxlength="10" pattern="[А-Яа-яЁе]{3,15}" title ="не менее 3 или 15 русских символов" id="reg_name"required />
				</li>
				
				<li>
				<label>Отчество</label>
				<span class="star">*</span>
				<input type ="text" name = "patronymid" placeholder="Отчество" maxlength="10" pattern="[А-Яа-яЁе]{6,30}" title ="не менее 6 или 30 русских символов" id="reg_patronymic"required />
				</li>
	
				<li>
				<label>E-mail</label>
				<span class="star">*</span>
				<input type ="email" name = "email"placeholder="Емейл" id="reg_email"required  />
				</li>
				
				<li>
				<label>Мобильный телефон</label>
				<span class="star">*</span>
				<input type ="text" name = "phone"maxlength="20"placeholder="Мобильный телефон"  pattern="[0-9]{10,20}" title ="только цифры" id="reg_phone"required />
				</li>
				
				<li>
				<label>Адрес доставки</label>
				<span class="star">*</span>
				<input type ="text" name = "address"placeholder="Адрес" maxlength="30" pattern="[А-Яа-яЁе]{10,30}" title ="не менее 10 или 30 русских символов"  id="reg_address"required />
				</li>
			
				<li>
				<div id = "block-captcha">
				<img src="reg/captcha.php" onclick="this.src = 'reg/captcha.php?' + Math.random();" />
				<input type="text" name ="captcha" maxlength="10" pattern="[A-Za-z-0-9]{1,5}" title ="от 1 до 5 символов"  id="reg_captcha" required />
			<!-- <p id = "reloadcaptcha"> Обновить </p> -->
				</div>
				</li>
	
			</ul>
			
		</div>
		
		<p align="right"><input type="submit" name="reg_submit" id ="form_submit" value="Регистрация" /></p>
	

	</form>
</div>
<?php
		include ("include/block-fotter.php");
?>
	
	</div>
</body>
</html>