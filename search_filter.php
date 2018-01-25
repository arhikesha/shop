<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include ("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");
	$cat = clearStr( $_GET["cat"]);
	$type = clearStr ($_GET["type"]);
	
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Поиск по параметрам</title>

<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
<link rel="stylesheet" type="text/css" href="jquery ui/jquery-ui.css" >

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/shop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="jquery ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/shop-script.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/textchange.js"></script>

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
		include ("include/block-news.php");
	?>
	</div>
	
	<div id="block-content"> 
	
	
	
	<?php
	
	if($_GET["brend"]){
		$check_brend = implode(',',$_GET["brend"]);//массив разделяет в переменную
	}
	$start_price = (int)$_GET["start_price"];
	$end_price = (int)$_GET["end_price"];
		
		if(!empty ($check_brend) OR !empty($end_price)){
			if(!empty ($check_brend)) $query_brend = "AND brend_id IN($check_brend)";
			if(!empty($end_price)) $query_price = "AND price BETWEEN $start_price  AND  $end_price";
		}
	
	
		$result = mysqli_query($link,"SELECT * FROM table_products WHERE visible= '1' $query_brend  $query_price   ORDER BY products_id DESC ");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
		
		echo '<div id="block-sorting">
			<p id="nav-breadcrumbs"><a href="index.php">Главная страница<a/>  <span></span> </p>
		
			<ul id="option-list">
				<li>Вид:</li>
				
				<li><img id="style-grid" src="image/Gnome-View-Sort-Ascending-green.png"/></li>
				<li><img id="style-list" src="image/Gnome-View-Sort-Descending-green.png"/></li>
					</ul>
				</li>
			</ul>
		</div>
		<ul id="block-tovar-grid">
		';
		
		do
		{
			//функция по преобразованию картинки в нужный размер
			if($row["image"] !="" && file_exists("./upload_images/".$row["image"]))//file_exists -если фаил существует
			{
				$img_path = './upload_images/'.$row["image"];
				$max_width = 200;
				$max_height = 200;
					list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);
				$width = intval($ratio*$width);
				$height = intval($ratio*$height);
			}else
			{
				$img_path = "/image/no-image.png";
				$width = 110;
				$height = 200;
			}
			$query_reviews = mysqli_query ($link,"SELECT * FROM table_reviews WHERE products_id ='{$row["products_id"]}' AND moderat ='1' ORDER BY reviews_id DESC");
			$count_reviews = mysqli_num_rows ($query_reviews);
			echo ' 
			<li>
				<div class="block-images-grid">
				<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
				</div>
				<p class="style-title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
				<ul class="reviews-and-counts-grid">
				<li><img src="image/eye.png" /><p>'.$row["count"].'</p></li>
				<li><img src="image/bubble.png"/><p>'.$count_reviews.'</p></li>
				</ul>
				<a class="add-cart-style-grid" tid ="'.$row["products_id"].'"></a>
				<p class="style-price-grid"><strong>'.group_numerals($row["price"]).'</strong>грн</p>
				<div class="mini-features"> 
				'.$row["mini_features"].'
				</div>
			</li>
			
			';
		}
		while($row = mysqli_fetch_array($result));
	
	
	?>
	</ul>
	<ul id="block-tovar-list">
	
	<?php
		$result = mysqli_query($link,"SELECT * FROM table_products WHERE visible= '1' $query_brend  $query_price ORDER BY products_id DESC ");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
		do
		{
			//функция по преобразованию картинки в нужный размер
			if($row["image"] !="" && file_exists("./upload_images/".$row["image"]))//file_exists -если фаил существует
			{
				$img_path = './upload_images/'.$row["image"];
				$max_width = 150;
				$max_height = 150;
					list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);
				$width = intval($ratio*$width);
				$height = intval($ratio*$height);
			}else
			{
				$img_path = "/image/no-image.png";
				$width = 80;
				$height = 70;
			}
			$query_reviews = mysqli_query ($link,"SELECT * FROM table_reviews WHERE products_id ='{$row["products_id"]}' AND moderat ='1' ORDER BY reviews_id DESC");
			$count_reviews = mysqli_num_rows ($query_reviews);
			echo ' 
			<li>
				<div class="block-images-list">
				<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
				</div>
		
				<ul class="reviews-and-counts-list">
				<li><img src="image/eye.png" /><p>'.$row["count"].'</p></li>
				<li><img src="image/bubble.png"/><p>'.$count_reviews.'</p></li>
				</ul>
				
				<p class="style-title-list"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
				
				<a class="add-cart-style-list" tid ="'.$row["products_id"].'"></a>
				<p class="style-price-list"><strong>'.group_numerals($row["price"]).'</strong>грн</p>
				<div class="syle-text-list"> 
				'.$row["mini_description"].'
				</div>
			</li>
			
			';
		}
		while($row = mysqli_fetch_array($result));
		}
	}else {
		echo '<h3>Категория не доступна или не создана!</h3>';
	}
	?>
	</ul>
	</div>
	
	<?php
		include ("include/block-random.php");
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>


