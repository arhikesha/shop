<?php
	session_start();
define('myeshop',true);
include ("include/db_connect.php");
include("include/functions.php");

if($_POST["submit_enter"]){
	
	$login = clearStr($_POST["input_login"]);
	$pass = clearStr($_POST["input_pass"]);
	
	if ($login && $pass){
		
		 $pass = md5($pass);
		$pass = strrev ($pass);//переворачиваем пароль
		$pass = strtolower ("kesha".$pass."oleg"); 
		
		$result = mysqli_query ($link ," SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'");
		
		if (mysqli_num_rows($result)>0){
			
			$row = mysqli_fetch_array($result);
			
			$_SESSION['auth_admin'] = 'yes_auth';
			// сессия должности
			$_SESSION['admin_role'] = $row["role"];
			//главный администратор
			$_SESSION['boss'] = $row["login"];
			//Привелегии 
				//Заказы
				$_SESSION['accept_orders'] =$row["accept_orders"];
				$_SESSION['view_orders'] =$row["view_orders"];
				$_SESSION['delete_orders'] =$row["delete_orders"];
				// Товары
				$_SESSION['add_tovar'] =$row["add_tovar"];
				$_SESSION['edit_tovar'] =$row["edit_tovar"];
				$_SESSION['delete_tovar'] =$row["delete_tovar"];
				//Отзывы
				$_SESSION['accept_reviews'] =$row["accept_reviews"];
				$_SESSION['delete_reviews'] =$row["delete_reviews"];
				//Клиенты
				$_SESSION['view_clients'] =$row["view_clients"];
				$_SESSION['delete_clients'] =$row["delete_clients"];
				//новости
				$_SESSION['add_news'] =$row["add_news"];
				$_SESSION['delete_news'] =$row["delete_news"];
				//Категории
				$_SESSION['add_category'] =$row["add_category"];
				$_SESSION['delete_category'] =$row["delete_category"];
				// администраторы
				$_SESSION['view_admin'] =$row["view_admin"];
				
			header ("Location:index.php");
		
		}else{
			$msgerror = "Неверный логин или Пароль";
		}
		}else {
			$msgerror = "Заполните все поля";
			
	}

}
?>












<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления - вход</title>
<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style-login.css" >
		
		
</head>
<body>
<div id= "block-pass-login">
<?php
	if($msgerror){
		echo '<p id ="msgerror">'.$msgerror.'</p>';
	}
?>
	<form method = "POST">
		<ul id = "pass-login">
			<li><label>Логин</label><input type ="text" name ="input_login" /></li>
			<li><label>Пароль</label><input type ="password" name ="input_pass" /></li>
		</ul>
		<p align = "right"><input type = "submit" name="submit_enter" id = "submit_enter" value ="Вход" /></p>
	</form>
</div>




</body>
</html>