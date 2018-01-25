<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'add_administrators.php'>Изменение администраторов </a>";

include ("include/db_connect.php");
include ("include/functions.php");
$id=clearStr($_GET["id"]);

if(@$_POST["submit_edit"]){
	if($_SESSION['boss']=='kesha'){
	$error =array();
		
	 if(!$_POST["admin_login"])$error[]= "Укажите логин!";
		
	if($_POST["admin_pass"])	{
		$pass = md5(clearStr($_POST["admin_pass"]));
		$pass = strrev($pass);
		$pass ="pass='".strtolower("kesha".$pass."oleg")."',";
	}
	if(!$_POST["admin_fio"])$error[]="Укажите ФИО!";
	if(!$_POST["admin_role"])$error[]="Укажите должность!";
	if(!$_POST["admin_email"])$error[]="Укажите E-mail!";
	
	if (isset($_POST["view_orders"])) $view_orders_query='1'; else $view_orders_query='0';
	if (isset($_POST["accept_orders"])) $accept_orders_query='1'; else $accept_orders_query='0';
	if (isset($_POST["delete_orders"])) $delete_orders_query='1'; else $delete_orders_query='0';
	if (isset($_POST["add_tovar"])) $add_tovar_query='1'; else $add_tovar_query='0';
	if (isset($_POST["edit_tovar"])) $edit_tovar_query='1'; else $edit_tovar_query='0';
	if (isset($_POST["delete_tovar"])) $delete_tovar_query='1'; else $delete_tovar_query='0';
	if (isset($_POST["accept_reviews"])) $accept_reviews_query='1'; else $accept_reviews_query='0';
	if (isset($_POST["delete_reviews"])) $delete_reviews_query='1'; else $delete_reviews_query='0';
	if (isset($_POST["view_clients"])) $view_clients_query='1'; else $view_clients_query='0';
	if (isset($_POST["delete_clients"])) $delete_clients_query='1'; else $delete_clients_query='0';
	if (isset($_POST["add_news"])) $add_news_query='1'; else $add_news_query='0';
	if (isset($_POST["delete_news"])) $delete_news_query='1'; else $delete_news_query='0';
	if (isset($_POST["add_category"])) $add_category_query='1'; else $add_category_query='0';
	if (isset($_POST["delete_category"])) $delete_category_query='1'; else $delete_category_query='0';
	if (isset($_POST["view_admin"])) $view_admin_query='1'; else $view_admin_query='0';
	
	if(count($error)){
		$_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
	}else{ 
		
		$querynew = "login='{$_POST["admin_login"]}',$pass fio='{$_POST["admin_fio"]}',role='{$_POST["admin_role"]}',email= '{$_POST["admin_email"]}',
									phone='{$_POST["admin_phone"]}',view_orders='$view_orders_query',accept_orders='$accept_orders_query',delete_orders='$delete_orders_query',
									add_tovar='$add_tovar_query',edit_tovar='$edit_tovar_query',delete_tovar='$delete_tovar_query',accept_reviews='$accept_reviews_query',
									delete_reviews=	'$delete_reviews_query',view_clients='$view_clients_query',delete_clients='$delete_clients_query',add_news='$add_news_query',
									delete_news='$delete_news_query',add_category='$add_category_query',delete_category='$delete_category_query',view_admin='$view_admin_query'";
												
			$update = mysqli_query($link,"UPDATE reg_admin SET $querynew WHERE id='$id'");									
					$_SESSION['message'] = "<p id='form-success'>Администратор успешно изменен!</p>";
	 }
	}else{
		$msgeerror = 'У вас нет прав на изменение администроров!';
	}
}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Изменение администраторов</title>
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
?>
	<div id ="block-content">
		<div id ="block-parameters">
			<p id ="title-page">Изменение администраторов </p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		
			if(isset($_SESSION ['message'])){
			echo $_SESSION ['message'];
			unset ($_SESSION['message']);
				}
			$result = mysqli_query($link,"SELECT * FROM reg_admin WHERE id ='$id'");
			if(mysqli_num_rows($result)>0){
				$row=mysqli_fetch_array($result);
				do{
				if($row["view_orders"] == "1")$view_orders ="checked";	
				if($row["accept_orders"] == "1")$accept_orders ="checked";	
				if($row["delete_orders"] == "1")$delete_orders ="checked";	
				if($row["add_tovar"] == "1")$add_tovar ="checked";	
				if($row["edit_tovar"] == "1")$edit_tovar ="checked";	
				if($row["delete_tovar"] == "1")$delete_tovar ="checked";	
				if($row["accept_reviews"] == "1")$accept_reviews ="checked";	
				if($row["delete_reviews"] == "1")$delete_reviews ="checked";	
				if($row["view_clients"] == "1")$view_clients ="checked";	
				if($row["delete_clients"] == "1")$delete_clients ="checked";	
				if($row["add_news"] == "1")$add_news ="checked";	
				if($row["delete_news"] == "1")$delete_news ="checked";	
				if($row["view_admin"] == "1")$view_admin ="checked";	
				if($row["add_category"] == "1")$add_category ="checked";	
				if($row["delete_category"] == "1")$delete_category ="checked";	
					
					echo'
		<form method="POST" id="form-info">
		<ul id="info-admin">
		<li><label>Логин</label><input type="text" name="admin_login" value="'.$row["login"].'" /></li>
		<li><label>Пароль</label><input type="password" name="admin_pass" value="" /></li>
		<li><label>ФИО</label><input type="text" name="admin_fio" value="'.$row["fio"].'" /></li>
		<li><label>Должность</label><input type="text" name="admin_role" value="'.$row["role"].'" /></li>
		<li><label>E-mail</label><input type="text" name="admin_email" value="'.$row["email"].'" /></li>
		<li><label>Телефон</label><input type="text" name="admin_phone" value="'.$row["phone"].'"  /></li>
		</ul>
		
		<h3 id="title-privilege">Привилегии</h3>
		
		<p id="link-privilege"><a id="select-all">Выбрать все</a> | <a id="remove-all">Снять все</a></p>
		
		<div class="block-privilege">
		
		<ul class="privilege">
		<li><h3>Заказы</h3></li>
		
		<li>
		<input type="checkbox" name="view_orders" id="view_orders" value="1" '.$view_orders.'/>
		<label for="view_orders">Просмотр заказов</label>
		</li>
		
		<li>
		<input type="checkbox" name="accept_orders" id="accept_orders" value="1"'.$accept_orders.' />
		<label for="accept_orders">Обработка заказов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_orders" id="delete_orders" value="1"'.$delete_orders.'/>
		<label for="delete_orders">Удаление заказов</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Товары</h3></li>
		
		<li>
		<input type="checkbox" name="add_tovar" id="add_tovar" value="1" '.$add_tovar.'/>
		<label for="add_tovar">Добавление товаров</label>
		</li>
		
		<li>
		<input type="checkbox" name="edit_tovar" id="edit_tovar" value="1"'.$edit_tovar.'/>
		<label for="edit_tovar">Изменение товаров</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_tovar" id="delete_tovar" value="1" '.$delete_tovar.'/>
		<label for="delete_tovar">Удаление товаров</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Отзывы</h3></li>
		
		<li>
		<input type="checkbox" name="accept_reviews" id="accept_reviews" value="1" '.$accept_reviews.'/>
		<label for="accept_reviews">Одобрение отзывов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_reviews" id="delete_reviews" value="1"'.$delete_reviews.'/>
		<label for="delete_reviews">Удаление отзывов</label>
		</li>
		</ul>
		</div>
		
		<div class="block-privilege">
		<ul class="privilege">
		<li><h3>Клиенты</h3></li>
		
		<li>
		<input type="checkbox" name="view_clients" id="view_clients" value="1"'.$view_clients.'/>
		<label for="view_clients">Просмотр клиентов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_clients" id="delete_clients" value="1"'.$delete_clients.'/>
		<label for="delete_clients">Удаление клиентов</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Новости</h3></li>
		
		<li>
		<input type="checkbox" name="add_news" id="add_news" value="1"'.$add_news.'/>
		<label for="add_news">Добавление новостей</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_news" id="delete_news" value="1"'.$delete_news.'/>
		<label for="delete_news">Удаление новостей</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Категории</h3></li>
		
		<li>
		<input type="checkbox" name="add_category" id="add_category" value="1"'.$add_category.'/>
		<label for="add_category">Добавление категории</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_category" id="delete_category" value="1"'.$delete_category.'/>
		<label for="delete_category">Удаление категории</label>
		</li>
		</ul>
		</div>
		
		<div class="block-privilege">
			<ul class="privilege">
				<li><h3>Администраторы</h3></li>
				<li>
					<input type="checkbox" name="view_admin" id="view_admin" value="1"'.$view_admin.'/>
					<label for="view_admin">Просмотр администраторов</label>
				</li>
			</ul>
		</div>
		
		<p align="right"><input type="submit" id="submit_form" name="submit_edit" value="изменить"/></p>
		</form>
		';
				}while($row=mysqli_fetch_array($result));
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