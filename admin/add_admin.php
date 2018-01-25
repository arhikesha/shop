<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'add_admin.php'>Добавление администраторов </a>";

include ("include/db_connect.php");
include ("include/functions.php");

if(@$_POST["submit_add"]){
	if($_SESSION['boss']=='kesha'){
	$error =array();
	
	if($_POST["admin_login"]){
		$login = clearStr ($_POST["admin_login"]);
		$query = mysqli_query($link,"SELECT login FROM reg_admin WHERE login='$login'");
	
	
	if(mysqli_num_rows($query)>0){
		$error[]= "Логин занят!";
		}
	}else{
			$error[]= "Укажите логин!";
	}
	if(!$_POST["admin_pass"])$error[]="Укажите пароль!";
	if(!$_POST["admin_fio"])$error[]="Укажите ФИО!";
	if(!$_POST["admin_role"])$error[]="Укажите должность!";
	if(!$_POST["admin_email"])$error[]="Укажите E-mail!";
		
	if(count($error)){
		$_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
	}else{
		$pass = md5(clearStr($_POST["admin_pass"]));
		$pass = strrev($pass);
		$pass =strtolower("kesha".$pass."oleg");
		
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
		
													mysqli_query($link,"INSERT INTO reg_admin(`login`, `pass`, `fio`, `role`, `email`, `phone`, `view_orders`, `accept_orders`, 
													`delete_orders`, `add_tovar`, `edit_tovar`, `delete_tovar`, `accept_reviews`, `delete_reviews`, `view_clients`, `delete_clients`, 
													`add_news`, `delete_news`, `add_category`, `delete_category`, `view_admin`)
													VALUES(
													'".clearStr($_POST["admin_login"])."',
													'".$pass."',
													'".clearStr($_POST["admin_fio"])."',
													'".clearStr($_POST["admin_role"])."',
													'".clearStr($_POST["admin_email"])."',
													'".clearStr($_POST["admin_phone"])."',
													'".$view_orders_query."',
													'".$accept_orders_query."',
													'".$delete_orders_query."',
													'".$add_tovar_query."',
													'".$edit_tovar_query."',
													'".$delete_tovar_query."',
													'".$accept_reviews_query."',
													'".$delete_reviews_query."',
													'".$view_clients_query."',
													'".$delete_clients_query."',
													'".$add_news_query."',
													'".$delete_news_query."',
													'".$add_category_query."',
													'".$delete_category_query."',
													'".$view_admin_query."'
													)");
					$_SESSION['message'] = "<p id='form-success'>Администратор успешно добавлен!</p>";
	}
	}else{
		$msgeerror = 'У вас нет прав на добавление администроров!';
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
			<p id ="title-page">Добавление администраторов </p>
		</div>
		<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		
			if(isset($_SESSION ['message'])){
			echo $_SESSION ['message'];
			unset ($_SESSION['message']);
		}
		?>
		<form method="POST" id="form-info">
		
		<ul id="info-admin">
		<li><label>Логин</label><input type="text" name="admin_login" /></li>
		<li><label>Пароль</label><input type="password" name="admin_pass" /></li>
		<li><label>ФИО</label><input type="text" name="admin_fio" /></li>
		<li><label>Должность</label><input type="text" name="admin_role" /></li>
		<li><label>E-mail</label><input type="text" name="admin_email" /></li>
		<li><label>Телефон</label><input type="text" name="admin_phone" /></li>
		</ul>
		
		<h3 id="title-privilege">Привилегии</h3>
		
		<p id="link-privilege"><a id="select-all">Выбрать все</a> | <a id="remove-all">Снять все</a></p>
		
		<div class="block-privilege">
		
		<ul class="privilege">
		<li><h3>Заказы</h3></li>
		
		<li>
		<input type="checkbox" name="view_orders" id="view_orders" value="1"/>
		<label for="view_orders">Просмотр заказов</label>
		</li>
		
		<li>
		<input type="checkbox" name="accept_orders" id="accept_orders" value="1"/>
		<label for="accept_orders">Обработка заказов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_orders" id="delete_orders" value="1"/>
		<label for="delete_orders">Удаление заказов</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Товары</h3></li>
		
		<li>
		<input type="checkbox" name="add_tovar" id="add_tovar" value="1"/>
		<label for="add_tovar">Добавление товаров</label>
		</li>
		
		<li>
		<input type="checkbox" name="edit_tovar" id="edit_tovar" value="1"/>
		<label for="edit_tovar">Изменение товаров</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_tovar" id="delete_tovar" value="1"/>
		<label for="delete_tovar">Удаление товаров</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Отзывы</h3></li>
		
		<li>
		<input type="checkbox" name="accept_reviews" id="accept_reviews" value="1"/>
		<label for="accept_reviews">Одобрение отзывов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_reviews" id="delete_reviews" value="1"/>
		<label for="delete_reviews">Удаление отзывов</label>
		</li>
		</ul>
		</div>
		
		<div class="block-privilege">
		<ul class="privilege">
		<li><h3>Клиенты</h3></li>
		
		<li>
		<input type="checkbox" name="view_clients" id="view_clients" value="1"/>
		<label for="view_clients">Просмотр клиентов</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_clients" id="delete_clients" value="1"/>
		<label for="delete_clients">Удаление клиентов</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Новости</h3></li>
		
		<li>
		<input type="checkbox" name="add_news" id="add_news" value="1"/>
		<label for="add_news">Добавление новостей</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_news" id="delete_news" value="1"/>
		<label for="delete_news">Удаление новостей</label>
		</li>
		</ul>
		
		<ul class="privilege">
		<li><h3>Категории</h3></li>
		
		<li>
		<input type="checkbox" name="add_category" id="add_category" value="1"/>
		<label for="add_category">Добавление категории</label>
		</li>
		
		<li>
		<input type="checkbox" name="delete_category" id="delete_category" value="1"/>
		<label for="delete_category">Удаление категории</label>
		</li>
		</ul>
		</div>
		
		<div class="block-privilege">
			<ul class="privilege">
				<li><h3>Администраторы</h3></li>
				<li>
					<input type="checkbox" name="view_admin" id="view_admin" value="1"/>
					<label for="view_admin">Просмотр администраторов</label>
				</li>
			</ul>
		</div>
		
		<p align="right"><input type="submit" id="submit_form" name="submit_add" value="Добавить"/></p>
		</form>
	</div>
</div>
</body>
</html>
<?php
}else{
		header("Location:login.php");
	}
?>