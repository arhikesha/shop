<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'reviews.php'>Отзывы </a>";

include ("include/db_connect.php");
include ("include/functions.php");

 @$id = clearStr($_GET["id"]);
 @$sort = $_GET["sort"];
 
 switch ($sort){
	 
	 case 'accept':
	 $sort = "moderat='1' DESC";
	 $sort_name ='Проверенные';
	 break;
	 
	  case 'no-accept':
	 $sort = "moderat='0' DESC";
	 $sort_name =' Не проверенные';
	 break;
	 
	 default:
	 
	 $sort = "reviews_id DESC";
	 $sort_name =' Без сортировки';
	 break;
 }
 @$action = $_GET["action"];
 if(isset($action)){
	 switch ($action){
		 case 'accept':
		  if($_SESSION['accept_reviews']=='1'){
		 $update = mysqli_query ($link,"UPDATE table_reviews SET moderat ='1' WHERE reviews_id ='$id'");
			}else {
				$msgeerror = 'У вас нет прав на одобрение отзывов!';
			}
		break;
		 case 'delete':
		 if($_SESSION['delete_reviews']=='1'){
		 $delete = mysqli_query($link,"DELETE FROM table_reviews WHERE reviews_id ='$id'");
		 }else {
				$msgeerror = 'У вас нет прав на удалние отзывов!';
			}
		 break;
	 }
 }
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления - отзывы</title>
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
	
	$all_count= mysqli_query($link,"SELECT * FROM table_reviews");
	$all_count_result = mysqli_num_rows($all_count);
	
	$no_accept_count = mysqli_query($link,"SELECT * FROM table_reviews WHERE moderat = '0'");
	$no_accept_count_result = mysqli_num_rows($no_accept_count);
	
?>
	<div id ="block-content">
		<div id ="block-parameters">
		<ul id ="options-list">
		<li>Сортировать</li>
		<li><a id = "select-links" href = "#"><?echo $sort_name;?></a>
		<ul id = "list-links-sort">
		<li><a href="reviews.php?sort=accept">Проверенные </a></li>
		<li><a href="reviews.php?sort=no-accept">Не проверенные</a></li>
		</ul>
	</li>
	</ul>
			
		</div>
		<div id = "block-info">
		<ul id ="review-info-count">
			<li>Всего отзывов -<strong><? echo $all_count_result;?></strong></li>
			<li>Не проверенные -<strong><? echo $no_accept_count_result;?></strong></li>
		</ul>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		$num = 6;
			
			@$page = strip_tags($_GET ['page']);
			//$page = mysqli_real_query($link,$page);
			
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
			$start = $page * $num - $num;
		
		 $result = mysqli_query($link,"SELECT * FROM table_reviews,table_products WHERE table_products.products_id=table_reviews.products_id ORDER BY $sort  LIMIT $start,$num");
				 
				 if(mysqli_num_rows($result)>0){
					 $row = mysqli_fetch_array ($result);
					 do {
						 if (strlen($row["image"]) > 0 && file_exists("../upload_images/".$row["image"])){
							 $img_path = '../upload_images/'.$row["image"];
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
						$width = 90;
						$height = 164;
						}
		if($row["moderat"] ==0){$link_accept ='<a class="green" href="reviews.php?id='.$row["reviews_id"].'&action=accept">Принять </a>';}else{$link_accept='';}
			
	echo	'
	<div class="block-reviews">
	<div class="block-title-img">
	<p>'.$row["title"].'</p>
	<center>
	<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
	</center>
	</div>
	<p class="author-date"><strong>'.$row["name"].'</strong>,'.$row["datetime"].'</p>
	<div class="plus-minus">
				<img src="../image/plus.png"/><p>'.$row["good_reviews"].'</p>
				<img src="../image/minus.png"/><p>'.$row["bad_reviews"].'</p>
	</div>
	
	<p class="reviews-comment">'.$row["comment"].'</p>
	<p class="links-action" align="right">'.$link_accept.'<a class="delete" rel="reviews.php?id='.$row["reviews_id"].'&action=delete">Удалить</a></p>
	</div>
	
	'	;	 
					 }while( $row = mysqli_fetch_array ($result));
				 }
	if($page !=1){$pstrprev = '<li><a class="pstrprev" href="reviews.php?page='.($page-1).'">Назад</a></li>';}
	if($page !=$total)$pstrnext = '<li><a class="pstrnext" href="reviews.php?page='.($page+1).'">Вперед</a></li>';
	  
		/////Формируем ссылкии со страницами
	if($page - 5 > 0) $page5left = '<li><a href ="reviews.php?page='.($page-5).'">'.($page-5).'</a></li>';
	if($page - 4 > 0) $page4left = '<li><a href ="reviews.php?page='.($page-4).'">'.($page-4).'</a></li>';
	if($page - 3 > 0) $page3left = '<li><a href ="reviews.php?page='.($page-3).'">'.($page-3).'</a></li>';
	if($page - 2 > 0) $page2left = '<li><a href ="reviews.php?page='.($page-2).'">'.($page-2).'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href ="reviews.php?page='.($page-1).'">'.($page-1).'</a></li>'; 
	
	if($page + 5 <= $total) $page5rigth = '<li><a href ="reviews.php?page='.($page+5).'">'.($page+5).'</a></li>';
	if($page + 4 <= $total) $page4rigth = '<li><a href ="reviews.php?page='.($page+4).'">'.($page+4).'</a></li>';
	if($page + 3 <= $total) $page3rigth = '<li><a href ="reviews.php?page='.($page+3).'">'.($page+3).'</a></li>';
	if($page + 2 <= $total) $page2rigth = '<li><a href ="reviews.php?page='.($page+2).'">'.($page+2).'</a></li>';
	if($page + 1 <= $total) $page1rigth = '<li><a href ="reviews.php?page='.($page+1).'">'.($page+1).'</a></li>';
	
		if($page + 5 <$total){
			$strtotal = '<li><p class="nav-point">..</p></li><li><a href="reviews.php?page='.$total.'">'.$total.'</a></li>';
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
			echo $pstrprev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class ='sptr_active' href='reviews.php?page=".$page."'>".$page."</a></li>".$page1rigth.$page2rigth.$page3rigth.$page4rigth.$page5rigth.$strtotal.$pstrnext;
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