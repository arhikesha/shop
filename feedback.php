<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");
	
if ($_POST ["send_massege"]){

	$error = array();
	
	if(!$_POST["feed_name"]) $error[] = "Укажите свое имя";
	
	/* if(!preg_match("/^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,5})$/i",trim($_POST["feed_email"]));
		{
			$error[] = "Укажите корректный Email";
		} */
		if(!$_POST["feed_subject"]) $error[] = "Укажите тему письма";
		if(!$_POST["feed_text"]) $error[] = "Укажите текст письма";
		
		if ($_SESSION['captcha'] != md5($_POST["captcha"]))
		{
			$error[] = "Неверный код с картинки";
		}
		
		if(count($error)){
			$_SESSION['message'] = "<p id = 'form-error'>".implode('<br />',$error)."</p>";
		}else{
						
							send_mail($_POST["feed_email"],
											'zachariy@gmail.com',
											$_POST["feed_subject"],
											'От: '.$_POST["feed_name"].'<br />'.$_POST ["feed_text"]);
											
				$_SESSION['message'] = "<p id ='form-success'>Ваше сообщения успешно отправленно</p>";											
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
	<?
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset ($_SESSION['message']);
	}
	
	
	?>
	<form method = "POST">
		<div id ="block-feedback">
		<ul id = "feedback">
		
		<li><label>Ваше имя</label><input type = "text" name ="feed_name" /></li>
		<li><label>Ваш Email</label><input type = "text" name ="feed_email" /></li>
		<li><label>Тема</label><input type = "text" name ="feed_subject" /></li>
		<li><label>Текст сообщения</label><textarea type = "text" name ="feed_text"></textarea></li>
		
		<li>
				<label for ="reg_captcha">Защитный код</label>
				<div id = "block-captcha">
				<img src ="reg/captcha.php"onclick="this.src = 'reg/captcha.php?' + Math.random();"/>
				<input type="text" name ="captcha" maxlength="10" pattern="[A-Za-z-0-9]{1,5}" title ="от 1 до 5 символов"  id="reg_captcha"  />
				<p id = "reloadcaptcha"> Обновить </p>
				</div>
		</li>
		</ul>
		</div>
		<p align="right"><input type="submit" name="send_massege" id ="form_submit" value="Отправить" /></p>
		</form>
	
	</div>
	<?php
		include ("include/block-random.php");
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>