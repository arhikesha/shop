<?php
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");
	
	$id = clearStr ($_GET ["id"]);

	$seoquery = mysqli_query($link,"SELECT seo_words, seo_description From table_products WHERE  products_id ='$id' AND visible='1'");
	
	if(mysqli_num_rows($seoquery)>0){
		$resquery = mysqli_fetch_array($seoquery);
	}
	/* if($id !=$_SESSION ['countid']){
		$querycount = mysqli_query ($link, "SELECT count FROM table_products,cart WHERE products_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}' ");
		$resultcount = mysqli_fetch_array ($querycount);
		
		$newcount = $resultcount["count"] + 1;
		
		$update = mysqli_query($link,"UPDATE table_products SET count ='$newcount' WHERE products_id='$id'");
	}
	$_SESSION['countid'] = '$id';
	if (!isset($_COOKIE['visited'])) setcookie("visited","1",0x6FFFFFFF); */
	if($id !=$_SESSION ['countid']){
		$querycount = mysqli_query ($link, "SELECT count FROM table_products WHERE products_id = '$id'");
		$resultcount = mysqli_fetch_array ($querycount);
		
		$newcount = $resultcount["count"] + 1;
		
		$update = mysqli_query($link,"UPDATE table_products SET count ='$newcount' WHERE products_id='$id'");
	}
	$_SESSION['countid'] = '$id';
	if (!isset($_COOKIE['visited'])) setcookie("visited","1",0x6FFFFFFF); 
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="description" content ="<?php echo $resquery["seo_description"];?>"/>
<meta name="keywords" content ="<?php echo $resquery["seo_words"];?>"/>

<title>Интернет магазин Цифровой техники</title>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/shop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="jquery ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/textchange.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/jTabs.js"></script>

<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
<link rel="stylesheet" type="text/css" href="jquery ui/jquery-ui.css" >
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" >

<script>
	$(document).ready (function(){
		
		$("ul.tabs").jTabs({content:".tabs_content",animate:true,effect:"fade"});
		$(".image-modal").fancybox();
		$(".send-review").fancybox();
		
	});

</script>

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
	$result1 = mysqli_query($link,"SELECT * FROM table_products WHERE products_id='$id' AND visible= '1' ");
	
	if(mysqli_num_rows($result1)>0)
	{
		$row1= mysqli_fetch_array($result1);
		do
		{
			//функция по преобразованию картинки в нужный размер
			if(strlen($row1["image"])>0 && file_exists("./upload_images/".$row1["image"]))//file_exists -если фаил существует
			{
				$img_path = './upload_images/'.$row1["image"];
				$max_width = 160;
				$max_height = 300;
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
				$height = 80;
			}
			//Количество отзывов
			$query_reviews = mysqli_query ($link,"SELECT * FROM table_reviews WHERE products_id ='$id' AND moderat ='1' ORDER BY reviews_id DESC");
			$count_reviews = mysqli_num_rows ($query_reviews);
			
			
			echo '
			<div id ="block-breacrumbs-and-rating">
			<p id = "nav-breacrumbs"><a href = "view_cat.php?type=mobile">Мобильные телефоны</a>\<span>'.$row1["brend"].'</span></p>
				<div id ="block-like">
					<p id = "likegood" tid ="'.$id.'" >Нравится</p><p id="likegoodcount">'.$row1["yes_like"].'</p>
				</div>
			</div>
			
			<div id = "block-content-info">
			
			<img src = "'.$img_path.'" width = "'.$width.'" height ="'.$height.'" />
				
				<div id ="block-mini-description">
					<p id ="content-title" >'.$row1["title"].'</p>
						
				<ul class="reviews-and-counts-content">
					<li><img src="image/eye.png" /><p>'.$row1["count"].'</p></li>
					<li><img src="image/bubble.png"/><p>'.$count_reviews.'</p></li>
				</ul>
				
				<p id= "style-price">'.group_numerals( $row1["price"]).'руб</p>
			
				<a id ="add-cart-view" class="add-cart"  tid ="'.$row1["products_id"].'"></a>
				
				<p id="content-text">'.$row1["mini_description"].'</p>	
				</div>
			</div>
			
			';

		}	while($row1 = mysqli_fetch_array($result1));
	}
	
		$result = mysqli_query($link,"SELECT * FROM uploads_images WHERE product_id='$id' ");
	
	if(mysqli_num_rows($result)>0)
	{
		$row= mysqli_fetch_array($result);
			echo '<div id = "block-img-slide">
			<ul>';
		do
		{
			//функция по преобразованию картинки в нужный размер
				$img_path = './upload_images/'.$row["image"];
				$max_width = 70;
				$max_height = 70;
				list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);
				
				$width = intval($ratio*$width);
				$height = intval($ratio*$height);
				
				echo '
				<li>
					<a class = "image-modal" href ="#image'.$row["id"].'"><img src ="'.$img_path.'" width ="'.$width.'" height ="'.$height.'" /></a>
				</li>
				<a style = "display:none;" class = "image-modal" rel = "group" id ="image'.$row["id"].'"><img src = "./upload_images/'.$row["image"].'"/></a>
				';
		}while ($row = mysqli_fetch_array($result));
		echo '
			</ul>
			</div>
		';
		$result = mysqli_query($link,"SELECT * FROM table_products WHERE products_id = '$id' AND visible= '1' ");
		$row = mysqli_fetch_array($result);
		echo '
		<ul class = "tabs">
			<li class="active"><a href ="#" >Описание </a></li>
			<li><a  href ="#" >Характеристики </a></li>
			<li><a  href ="#" >Отзывы </a></li>
		</ul>
		
		<div class ="tabs_content">
			<div>'.$row["description"].'</div>
			<div>'.$row["features"].'</div>
			<div>
			<p id="link-send-review"> <a class = "send-review" href ="#send-review">Написать отзыв</a></p>
		';
		$query_reviews = mysqli_query ($link,"SELECT * FROM table_reviews WHERE products_id = '$id' AND moderat = '1' ORDER BY reviews_id DESC ");
		if(mysqli_num_rows($query_reviews) > 0){
			$row_reviews = mysqli_fetch_array ($query_reviews);
			do{
				echo '
					<div class ="block-review" >
						<p class = "author-date">'.$row_reviews["name"].', '.$row_reviews["date"].'</p>
						<img src="image/plus.png" />
						<p class = "rextrev">'.$row_reviews["good_reviews"].'</p>
						<img src="image/minus.png" />
						<p class = "rextrev">'.$row_reviews["bad_reviews"].'</p>
						
						<p class ="text-comment" >'.$row_reviews["comment"].'</p>
					</div>
				';
			}while ($row_reviews = mysqli_fetch_array($query_reviews));
		}else{
			echo '<p class = "title-info">Отзывов нету</p>';
		}
		echo '
		</div>
		</div>
			<div id ="send-review">
		
			<p align="right" id ="title-review">Публикация отзыва производиться после предварительной модерации.</p>
		
		<ul>
				<li><p align="right"><label id ="label-name">Имя</label><input maxlength="15" type = "text" id = "name_review" /></p></li>
				<li><p align="right"><label id ="label-good">Достоинства</label><textarea id="good_review"></textarea></p></li>
				<li><p align="right"><label id ="label-bad">Недостатки</label><textarea id= "bad_review" ></textarea></p></li>
				<li><p align="right"><label id ="label-comment">Коментарий </label><textarea id= "comment_review" ></textarea></p></li>
			</ul>
			<p id = "reload-img"><img src ="image/load.gif" /></p> <p id = "button-send-review" iid="'.$id.'"></p>
			</div>
		';
		
	}
	?>
		
	</div>
	<?php
		include ("include/block-random.php");
		include ("include/block-fotter.php");
	?>
	
	</div>
</body>
</html>