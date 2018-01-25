<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'clients.php'>Клиенты </a>";

include ("include/db_connect.php");
include ("include/functions.php");

@$id = clearStr ($_GET["id"]);
@$action = $_GET["action"];
if(isset($action)){
	switch($action){
		case'delete':
		if($_SESSION['delete_clients']=='1'){
		$delete = mysqli_query($link,"DELETE FROM reg_user WHERE id='$id'");
		}else {
				$msgeerror = 'У вас нет прав на удаление клиентов!';
		}
		break;
	}
}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления-клиенты</title>
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
	$all_client = mysqli_query($link,"SELECT * FROM reg_user");
	$result_count = mysqli_num_rows($all_client);
?>
	<div id ="block-content">
		<div id ="block-parameters">
			<p id ="count-client">Клиенты - <strong><?echo $result_count; ?></strong> </p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		
		if($_SESSION['view_clients']=='1'){
			$num = 10;
			
			@$page = (int)$_GET ['page'];
			
			$count = mysqli_query($link,"SELECT COUNT(*) FROM `reg_user` ");
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
				 $result = mysqli_query($link,"SELECT * FROM reg_user ORDER BY id DESC LIMIT $start,$num");
				 
				 if(mysqli_num_rows($result)>0){
					 $row = mysqli_fetch_array ($result);
					 do {
			echo'
				<div class="block-clients">
			<p class="client-datetime">'.$row["datetime"].'</p>
			<p class="client-email"><strong>'.$row["email"].'</strong></p>
			<p class="client-links"><a class="delete"rel="clients.php?id='.$row["id"].'&action=delete">Удалить</a></p>
			
			<ul>
			<li><strong>E-mail</strong> - '.$row["email"].'</li>
			<li><strong>ФИО</strong> - '.$row["surname"].' '.$row["name"].' '.$row["patronymid"].'</li>
			<li><strong>Адрес</strong> - '.$row["address"].'</li>
			<li><strong>Телефон</strong> - '.$row["phone"].'</li>
			<li><strong>IP</strong> - '.$row["ip"].'</li>
			<li><strong>Дата регистрации</strong> - '.$row["datetime"].'</li>
			</ul>
			</div>
			';
		}while ($row = mysqli_fetch_array($result));
	 }
 }
			
	if($page !=1){$pstrprev = '<li><a class="pstrprev" href="clients.php?'.$url.'page='.($page-1).'">Назад</a></li>';}
	if($page !=$total)$pstrnext = '<li><a class="pstrnext" href="clients.php?'.$url.'page='.($page+1).'">Вперед</a></li>';
	  
		/////Формируем ссылкии со страницами
	if($page - 5 > 0) $page5left = '<li><a href ="clients.php?'.$url.'page='.($page-5).'">'.($page-5).'</a></li>';
	if($page - 4 > 0) $page4left = '<li><a href ="clients.php?'.$url.'page='.($page-4).'">'.($page-4).'</a></li>';
	if($page - 3 > 0) $page3left = '<li><a href ="clients.php?'.$url.'page='.($page-3).'">'.($page-3).'</a></li>';
	if($page - 2 > 0) $page2left = '<li><a href ="clients.php?'.$url.'page='.($page-2).'">'.($page-2).'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href ="clients.php?'.$url.'page='.($page-1).'">'.($page-1).'</a></li>'; 
	
	if($page + 5 <= $total) $page5rigth = '<li><a href ="clients.php?'.$url.'page='.($page+5).'">'.($page+5).'</a></li>';
	if($page + 4 <= $total) $page4rigth = '<li><a href ="clients.php?'.$url.'page='.($page+4).'">'.($page+4).'</a></li>';
	if($page + 3 <= $total) $page3rigth = '<li><a href ="clients.php?'.$url.'page='.($page+3).'">'.($page+3).'</a></li>';
	if($page + 2 <= $total) $page2rigth = '<li><a href ="clients.php?'.$url.'page='.($page+2).'">'.($page+2).'</a></li>';
	if($page + 1 <= $total) $page1rigth = '<li><a href ="clients.php?'.$url.'page='.($page+1).'">'.($page+1).'</a></li>';
	
		if($page + 5 <$total){
			$strtotal = '<li><p class="nav-point">..</p></li><li><a href="clients.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
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
			echo $pstrprev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class ='sptr_active' href='tovar.php?".$url."page=".$page."'>".$page."</a></li>".$page1rigth.$page2rigth.$page3rigth.$page4rigth.$page5rigth.$strtotal.$pstrnext;
			echo' 
			</center>
			</ul>
			</div>
			'; 
			}
		}else{
			echo'<p id="form-error" align="center">У вас нет прав на просмотр данного раздела!</p>';
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