<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'tovar.php'>Товары </a>";

include ("include/db_connect.php");
include ("include/functions.php");

@$cat = $_GET["cat"];
@$type = $_GET ["type"];

if(isset($cat)){
	switch ($cat){
		
		case 'all':
		
		$cat_name = 'Все товары';
		$url = "cat=all&";
		$cat = "";
		break;
		
		case 'mobile':
		
		$cat_name = 'Мобильные телефоны';
		$url = "cat=mobile&";
		$cat = "WHERE type_tovara='mobile'";
		break;
		
		case 'notebook':
			
		$cat_name = 'Ноутбуки';
		$url = "cat=notebook&";
		$cat = "WHERE type_tovara='notebook'";
		break;
		
		case 'notepad':
			
		$cat_name = 'Планшеты';
		$url = "cat=notepad&";
		$cat = "WHERE type_tovara='notepad'";
		break;
		
		default:
		
		$cat_name = $cat;
		$url = "type=".clearStr($type)."&cat=".clearStr($cat)."&";
		$cat = "WHERE type_tovara='".clearStr($type)."' AND brend='".clearStr($cat)."'";
		break;
	}
}else{
		$cat_name = 'Все товары';
		$url = "";
		$cat = "";
}



@$action = $_GET["action"];
//if(isset ($action)){
	@$id = (int)$_GET["id"];
	switch ($action){
		case 'delete':
		if($_SESSION['delete_tovar'] =='1'){
			$delete = mysqli_query ($link,"DELETE FROM table_products WHERE products_id = '$id'");
			}else{
				$msgeerror = 'У вас нет прав на удаление товара!';
		}
			break;
	}


?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления</title>
	<script type="text/javascript" src="js/jquery.js"></script>	
	<script type="text/javascript" src="js/script.js"></script>	
	<script type="text/javascript" src="jquery-confirm/jquery-confirm.js"></script>	
		
		
<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
<link rel="stylesheet" type="text/css" href="jquery-confirm/jquery-confirm.css" >
		
		
</head>
<body>
<div id= "block-body">
<?php
	include ("include/block-header.php");
	
	$all_count = mysqli_query($link,"SELECT * FROM table_products");
	$all_count_result = mysqli_num_rows ($all_count);
	
?>
	<div id ="block-content">
		<div id ="block-parameters">
		<ul id ="options-list">
		<li>Товары</li>
		<li><a id = "select-links" href = "#"><?echo $cat_name;?></a>
		<div id = "list-links">
		<ul>
		<li><a href = "tovar.php?cat=all"><strong>Все товары</strong></a></li>
		<li><a href = "tovar.php?cat=mobile"><strong>Телефоны</strong></a></li>
<?php
		$result1 = mysqli_query ($link,"SELECT * FROM category WHERE type ='mobile'");
			if (mysqli_num_rows($result1)>0){
				$row1 = mysqli_fetch_array($result1);
				do{
					echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brend"].'">'.$row1["brend"].'</a></li>';
				}while ($row1 = mysqli_fetch_array($result1));
		}
?>
		</ul>
		<ul>
		<li><a href = "tovar.php?cat=all"><strong>Ноутбуки</strong></a></li>
<?php
		$result1 = mysqli_query ($link,"SELECT * FROM category WHERE type ='notebook'");
			if (mysqli_num_rows($result1)>0){
				$row1 = mysqli_fetch_array($result1);
				do{
					echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brend"].'">'.$row1["brend"].'</a></li>';
				}while ($row1 = mysqli_fetch_array($result1));
			}
?>
		</ul>
		<ul>
		<li><a href = "tovar.php?cat=all"><strong>Планшеты</strong></a></li>
<?php
		$result1 = mysqli_query ($link,"SELECT * FROM category WHERE type ='notepad'");
			if (mysqli_num_rows($result1)>0){
				$row1 = mysqli_fetch_array($result1);
				do{
					echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brend"].'">'.$row1["brend"].'</a></li>';
				}while ($row1 = mysqli_fetch_array($result1));
			}
		?>
		</ul>
	</div>
	</li>
	</ul>
			<p id ="title-page"> </p>
		</div>
		<div id = "block-info">
			<p id ="count-style">Всего товаров - <strong><? echo $all_count_result; ?></strong></p>
					<p align="right"id ="add-style"><a href = "add_product.php">Добавить товар </a></p>
		</div>
		<ul id= "block-tovar">
		<?
			if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
			$num = 9;
			
			@$page = (int)$_GET ['page'];
			
			$count = mysqli_query($link,"SELECT COUNT(*) FROM `table_products` ");
			$temp = mysqli_fetch_array ($count);
			$post = $temp[0];
			//Находим общее число страниц
			$total = (($post - 1)/$num) +1;
			$total = intval ($total);
			//Определяем начало сообщений для текущей страницы
			$page = intval($page);
			//Если значение $page менье единицы или отрицательное
			//переходим на первую страницу
			//А если слишком большое, то переходим на последнию
			if(empty($page) or $page < 0 )$page =1;
				if ($page >$total)$page = $total;
			//Вычисляем начиная с какого номера следует выводить сообщение
			$start = $page * $num -$num;
			 
			 if($temp[0]>0){
				 $result = mysqli_query($link,"SELECT * FROM table_products $cat ORDER BY products_id DESC LIMIT $start,$num");
				 
				 if(mysqli_num_rows($result)>0){
					 $row = mysqli_fetch_array ($result);
					 do {
						 if (strlen($row["image"]) > 0 && file_exists("../upload_images/".$row["image"])){
							 $img_path = '../upload_images/'.$row["image"];
						$max_width = 160;
						$max_height = 160;
							list($width, $height) = getimagesize($img_path);
						$ratioh = $max_height/$height;
						$ratiow = $max_width/$width;
						$ratio = min($ratioh, $ratiow);
						$width = intval($ratio*$width);
						$height = intval($ratio*$height);
					}else
					{
						$img_path = "/image/no-image.png";
						$width = 90;
						$height = 164;
						}
					echo'
						<li>
							<p>'.$row["title"].'</p>
							<center>
									<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
							</center>
							<p align = "center" class ="link-action">
							<a class  = "green" href = "edit_product.php?id='.$row["products_id"].'">Изменить </a> | <a rel="tovar.php?'.$url.'id='.$row["products_id"].'&action=delete" class="delete">Удалить</a>
					</p>
					</li>
					';	
		
					 }while ($row = mysqli_fetch_array($result));
					 echo '</ul>';
				 }
			 }
			
	if($page !=1){$pstrprev = '<li><a class="pstrprev" href="tovar.php?'.$url.'page='.($page-1).'">Назад</a></li>';}
	if($page !=$total)$pstrnext = '<li><a class="pstrnext" href="tovar.php?'.$url.'page='.($page+1).'">Вперед</a></li>';
	  
		/////Формируем ссылкии со страницами
	if($page - 5 > 0) $page5left = '<li><a href ="tovar.php?'.$url.'page='.($page-5).'">'.($page-5).'</a></li>';
	if($page - 4 > 0) $page4left = '<li><a href ="tovar.php?'.$url.'page='.($page-4).'">'.($page-4).'</a></li>';
	if($page - 3 > 0) $page3left = '<li><a href ="tovar.php?'.$url.'page='.($page-3).'">'.($page-3).'</a></li>';
	if($page - 2 > 0) $page2left = '<li><a href ="tovar.php?'.$url.'page='.($page-2).'">'.($page-2).'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href ="tovar.php?'.$url.'page='.($page-1).'">'.($page-1).'</a></li>'; 
	
	if($page + 5 <= $total) $page5rigth = '<li><a href ="tovar.php?'.$url.'page='.($page+5).'">'.($page+5).'</a></li>';
	if($page + 4 <= $total) $page4rigth = '<li><a href ="tovar.php?'.$url.'page='.($page+4).'">'.($page+4).'</a></li>';
	if($page + 3 <= $total) $page3rigth = '<li><a href ="tovar.php?'.$url.'page='.($page+3).'">'.($page+3).'</a></li>';
	if($page + 2 <= $total) $page2rigth = '<li><a href ="tovar.php?'.$url.'page='.($page+2).'">'.($page+2).'</a></li>';
	if($page + 1 <= $total) $page1rigth = '<li><a href ="tovar.php?'.$url.'page='.($page+1).'">'.($page+1).'</a></li>';
	
		if($page + 5 <$total){
			$strtotal = '<li><p class="nav-point">..</p></li><li><a href="tovar.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
		}else{
			$strtotal =" ";
		}
?>
		<div id ="footerfix"></div>
<?php
		if($total > 1){
			echo'
			<center>
				<div class = "pstrnav">
				<ul>';
			echo @$pstrprev.@$page5left.@$page4left.@$page3left.@$page2left.@$page1left."<li><a class ='sptr_active' href='tovar.php?".$url."page=".$page."'>".$page."</a></li>".@$page1rigth.@$page2rigth.@$page3rigth.@$page4rigth.@$page5rigth.$strtotal.@$pstrnext;
			echo' 
			</center>
			</ul>
			</div>
			'; 
		}
?>
	</div>
</div>
</body>
</html>
<?php
}else{
		header("Location:login.php");
	}
?>