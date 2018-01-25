<?php	
error_reporting(E_ALL & ~E_NOTICE);
	define('myeshop',true);
	include ("include/db_connect.php");
	include("functions/functions.php");
	session_start();
	include ("include/auth_cookie.php");
	
	
	$go = clearStr($_GET['go']);
	
	switch ($go){
			
		case "news":
		$query_aystopper = " WHERE `visible` = '1' AND `new` = '1' ";
		$name_aystopper = "Новинки товаров";
		break;
		
		case "leaders":
		$query_aystopper = "WHERE `visible` = '1' AND `leader` = '1'";
		$name_aystopper = "Лидеры продаж";
		break;
		
		case "sale":
		$query_aystopper = "WHERE `visible` = '1' AND `sale` = '1'";
		$name_aystopper = "Распродажа товара";
		break;
		
		default:
		$query_aystopper = "";
		break;
	}
	
	
$sorting = $_GET["sort"];

switch($sorting)
{
	case 'price-asc';
	$sorting = 'price ASC';
	$sort_name = 'От дешевых к дорогим ';
	break;
	
	case 'price-desc';
	$sorting = 'price DESC';
	$sort_name = 'От дорогим к дешевым ';
	break;
	
	case 'popular';
	$sorting = 'count DESC';
	$sort_name = 'Популярный ';
	break;
	
	case 'news';
	$sorting = 'datetime DESC';
	$sort_name = 'Новинки ';
	break;
	
	case 'brend';
	$sorting = 'brend';
	$sort_name = 'От A до Я ';
	break;
	
	default:
		$sorting = 'products_id DESC ';
		$sort_name = 'Нет сортировки ';
	break;
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
	if ($query_aystopper !=""){
		
	

	  // Количество страниц и выводимого товара
		$num = 3; //Здесь указываем сколько хотим выводить товара
		$page = (int)$_GET['page']; //помешение значение page(1,2,3 и тд)
		
		$count = mysqli_query($link,"SELECT COUNT(*) FROM `table_products` $query_aystopper ");//COUNT (*)- подсчитывает количество товара
		$temp = mysqli_fetch_array($count);
		
		if($temp[0] >0)//проверка найдены ли товары если больше 0 то да
		{
			$tempcount = $temp[0];// помещаем общее количество товара
			
			//находим общее число страница
			$total = (($tempcount - 1)/$num) +1;
			$total = intval ($total);
			
			$page = intval($page);
			
			if(empty($page) or $page < 0) $page = 1;//если $gape 0 или меньше то $page = 1 Выводим с 1 страницы
				if($page > $total) $page = $total;//если $page Больше количество страниц то $page = макс количество страниц
		
		//Вычисляем начиная с какого нормера следует вывводить товара
		$start = $page * $num - $num;//Количество товара на странице (4-*2 - 2) от 6 до 8 пример
		
		$query_start_num = " LIMIT $start, $num";// $start - от какого товара выводить $num -сколько товара выводить 
		
			$result = mysqli_query($link,"SELECT * FROM table_products WHERE visible= '1' ORDER BY $sorting $query_start_num ");
		}
	if($temp[0] >0)
		{
			
	
	?>
	<div id="block-sorting">
			<p id="nav-breadcrumbs"><a href="index.php">Главная страница<a/> \ <span><? echo $name_aystopper; ?></span> </p>
		
			<ul id="option-list">
				<li>Вид:</li>
				
				<li><img id="style-grid" src="image/Gnome-View-Sort-Ascending-green.png"/></li>
				<li><img id="style-list" src="image/Gnome-View-Sort-Descending-green.png"/></li>
			
				<li>Сортировка:</li>
			
			<li><a id="select-sort"><?php echo $sort_name; ?></a>
					<ul id="sorting-list">
						<li><a href="view_aystopper.php?go=<? print $go; ?>&sort=price-asc">От дешевых к дорогим</a></li>
						<li><a href="view_aystopper.php?go=<? echo $go; ?>&sort=price-desc">От дорогим к дешевым</a></li>
						<li><a href="view_aystopper.php?go=<? echo $go; ?>&sort=popular">Популярный</a></li>
						<li><a href="view_aystopper.php?go=<? echo $go; ?>&sort=news">Новинки</a></li>
						<li><a href="view_aystopper.php?go=<? echo $go; ?>&sort=brand">От A до Я</a></li>
					</ul>
				</li>
			</ul>
		</div>
	<ul id="block-tovar-grid">
	<?	
		$result = mysqli_query($link,"SELECT * FROM table_products $query_aystopper ORDER BY $sorting $query_start_num ");
	
	if(mysqli_num_rows($result)>0)
	{
		$row = mysqli_fetch_array($result);
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
				<a class="add-cart-style-grid"tid ="'.$row["products_id"].'"></a>
				<p class="style-price-grid"><strong>'.group_numerals($row["price"]).'</strong>грн</p>
				<div class="mini-features"> 
				'.$row["mini_features"].'
				</div>
			</li>
			
			';
		}
		while($row = mysqli_fetch_array($result));
	}
	
	 
	?>
	</ul>
	<!--блок Сортировки Лист -->
	<ul id="block-tovar-list">
	
	<?php

		$result = mysqli_query($link,"SELECT * FROM table_products $query_aystopper  ORDER BY $sorting  $query_start_num ");
	
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
				
				<a class="add-cart-style-list"tid ="'.$row["products_id"].'"></a>
				<p class="style-price-list"><strong>'.group_numerals($row["price"]).'</strong>грн</p>
				<div class="syle-text-list"> 
				'.$row["mini_description"].'
				</div>
			</li>
			
			';
		}
		while($row = mysqli_fetch_array($result));
	}
	echo '</ul>';
		}else {
			echo '<p>Товаров нету</p>';
		}
	 }else{
		 echo '<p>Данная категория не найдена</p>';
	 }
	// формируем переключатель
	if($page !=1){$pstr_prev = '<li><a class="pstr-prev" href="view_aystopper.php?go='.$go.'&page='.($page-1).'">&lt;</a></li>';}
	if($page !=$total)$pstr_next = '<li><a class="pstr-next" href="view_aystopper.php?go='.$go.'&page='.($page+1).'">&gt;</a></li>';

		/////Формируем ссылкии со страницами
	if($page - 5 > 0) $page5left = '<li><a href =view_aystopper.php?go='.$go.'&page='.($page-5).'">'.($page-5).'</a></li>';
	if($page - 4 > 0) $page4left = '<li><a href =view_aystopper.php?go='.$go.'&page='.($page-4).'">'.($page-4).'</a></li>';
	if($page - 3 > 0) $page3left = '<li><a href =view_aystopper.php?go='.$go.'&page='.($page-3).'">'.($page-3).'</a></li>';
	if($page - 2 > 0) $page2left = '<li><a href =view_aystopper.php?go='.$go.'&page='.($page-2).'">'.($page-2).'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href =view_aystopper.php?go='.$go.'&page='.($page-1).'">'.($page-1).'</a></li>'; 

	if($page + 5 <= $total) $page5rigth = '<li><a href ="view_aystopper.php?go='.$go.'&page='.($page+5).'">'.($page+5).'</a></li>';
	if($page + 4 <= $total) $page4rigth = '<li><a href ="view_aystopper.php?go='.$go.'&page='.($page+4).'">'.($page+4).'</a></li>';
	if($page + 3 <= $total) $page3rigth = '<li><a href ="view_aystopper.php?go='.$go.'&page='.($page+3).'">'.($page+3).'</a></li>';
	if($page + 2 <= $total) $page2rigth = '<li><a href ="view_aystopper.php?go='.$go.'&page='.($page+2).'">'.($page+2).'</a></li>';
	if($page + 1 <= $total) $page1rigth = '<li><a href ="view_aystopper.php?go='.$go.'&page='.($page+1).'">'.($page+1).'</a></li>';
	
		if($page + 5 <$total){
			$strtotal = '<li><p class="nav-point">..</p></li><li><a href="view_aystopper.php?go='.$go.'&page='.$total.'">'.$total.'</a></li>';
		}else{
			$strtotal ="";
		}
		if($total > 1){
			echo'
				<div class = "pstrnav">
				<ul>';
			echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class ='sptr_active' href='view_aystopper.php?go=".$go."&page=".$page."'>".$page."</a></li>".$page1rigth.$page2rigth.$page3rigth.$page4rigth.$page5rigth.$strtotal.$pstr_next;
			echo '
				</ul>
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