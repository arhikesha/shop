<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'administrators.php'>Администраторы </a>";

include ("include/db_connect.php");
include ("include/functions.php");

@$id = clearStr ($_GET["id"]);
@$action = $_GET["action"];
if(isset($action)){
	switch($action){
		case'delete':
		if($_SESSION['boss']=='kesha'){
		$delete = mysqli_query($link,"DELETE FROM reg_admin WHERE id='$id'");
		}else{
			$msgeerror = 'У вас нет прав на удаление администроров!';
		}
	 break;
	}
}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления-администраторы</title>
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
		<p id ="title-page">Администраторы</p>
		<p align="right" id="add-style"><a href="add_admin.php">Добавить админа</a></p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		
		if($_SESSION['view_admin']=='1'){
			
		$result = mysqli_query($link,"SELECT * FROM reg_admin ORDER BY id DESC");
		
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_array($result);
			do{
				echo'
				<ul id="list-admin">
				<li>
				<h3>'.$row["fio"].'</h3>
				<p><strong>Должность</strong>-'.$row["role"].'</p>
				<p><strong>E-mail</strong>-'.$row["email"].'</p>
				<p><strong>Телефон</strong>-'.$row["phone"].'</p>
				<p class  = "link-actions"align="right"><a class = "green" href = "edit_administrators.php?id='.$row["id"].'">Изменить </a> | <a class="delete" rel="administrators.php?id='.$row["id"].'&action=delete" >Удалить</a></p>
				</li>
				</ul>
				';
			}while($row = mysqli_fetch_array($result));
		}
}else {
				echo'<p id="form-error" align="center">У вас нет прав на просмотр администраторов!</p>';
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