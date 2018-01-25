<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");


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
	<p id="o-nas">
	Поможем выбрать, не дадим скучать!
	Наша задача состоит не только в том, чтобы просто продать нужный товар, но и в том, чтобы информировать и просвещать покупателя. Для этого мы снимаем видеообзоры «горячих» новинок, готовим статьи и новости. Вооружившись всесторонней информацией об интересном устройстве и его главных конкурентах, Вы сможете самостоятельно принять взвешенное решение о покупке именно того товара, который Вам нужен.
	</p>
	<img align="center"id ="img-kart" src = "image/logo2.jpg"/>
	<p id="o-nas1">
	Наш сайт в среднем посещает более 800 000 уникальных посетителей в день, и это число продолжает расти. Не останавливаясь на достигнутом, мы продолжаем наращивать обороты, стремясь стать лучшим в стране порталом об электронике и бытовой технике — местом, где Вы сможете выбрать и приобрести любую технику — осознанно, недорого и удобно.
	</p>
	</div>
	<?php
		include ("include/block-random.php");
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>