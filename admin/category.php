<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'category.php'>Категории </a>";

include ("include/db_connect.php");
include ("include/functions.php");

if(@$_POST["sybmit_cat"]){
	if($_SESSION['add_category']=='1'){
	$error= array();
	
	if(!$_POST["cat_type"]){ 
		$error[] = "Укажите тип товара";
	}
	if(!$_POST["cat_brend"]){
		$error[] = "Укажите название категории";
	}
	if(count($error)){
	$_SESSION ['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
}else {
		$cat_type = clearStr ($_POST["cat_type"]);
		$cat_brend = clearStr ($_POST["cat_brend"]);

							mysqli_query($link,"INSERT INTO category(`type`, `brend`)
										VALUES(
											'".$cat_type."',
											'".$cat_brend."')");
										
					$_SESSION['message'] = "<p id='form-success'>Категория успешно добавлена!</p>";
	}
	}else{
		$msgeerror = 'У вас нет прав на добавлении категории!';
	}
}


?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления-категории</title>
			
<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/script.js"></script>	

<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
		
		
</head>
<body>
<div id= "block-body">
<?php
	include ("include/block-header.php");
?>
	<div id ="block-content">
		<div id ="block-parameters">
			<p id ="title-page">Категориии</p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
			if(isset($_SESSION ['message'])){
			echo $_SESSION ['message'];
			unset ($_SESSION['message']);
		}
		
		
?>
		<form method ="POST">
		<ul id="cat_product">
		<li>
		<label>Категории</label>
		<div>
<?php
		if($_SESSION['delete_category']=='1'){
			echo'<a class="delete-cat">Удалить</a>';
			}
?>
		</div>
		<select name ="cat_type" id ="cat_type"size="10">
<?php
		$result= mysqli_query($link,"SELECT * FROM category ORDER BY type ASC");
		
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_array($result);
			do{
				echo '
				<option value = "'.$row["id"].'">'.$row["type"].'-'.$row["brend"].'</option>
				';
			}while($row = mysqli_fetch_array($result));
		}
?>
		</select>
		</li>
		<li>
			<label>Тип товара</label>
			<input type="text" name="cat_type" />
		</li>
		<li>
			<label>Бренд</label>
			<input type="text" name="cat_brend" />
		</li>
			</ul>
		<p align="right"><input type ="submit" name="sybmit_cat" id ="submit_form"value="Добавить" /></p>
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