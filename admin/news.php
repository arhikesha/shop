<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'news.php'>Новости </a>";

include ("include/db_connect.php");
include ("include/functions.php");

if(@$_POST["submit_news"]){
	if($_SESSION['add_news']=='1'){
	if($_POST["news_title"] =="" || $_POST["news_text"]==""){
		$massege = "<p id='form-error'>Заполните все поля!</p>";
	}else{
		mysqli_query($link,"INSERT INTO news (title,text,date)
							VALUES (
							'".$_POST["news_title"]."',
							'".$_POST["news_text"]."',
							NOW())");
		$massege = "<p id='form-success'>Новость добавлена!</p>";
							
	}
	}else{
				$msgeerror = 'У вас нет прав на добавление новостей!';
		}
}

@$id = clearStr ($_GET["id"]);
@$action = $_GET["action"];
if(isset($action)){
	switch($action){
		case'delete':
		if($_SESSION['delete_news']=='1'){
		$delete = mysqli_query($link,"DELETE FROM news WHERE id='$id'");
		}else{
			$msgeerror = 'У вас нет прав на удаление новостей!';
		}
		break;
	}
}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления-новости</title>
<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="js/script.js"></script>	
<script type="text/javascript" src="jquery-confirm/jquery-confirm.js"></script>	
<script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>		
		
<link rel="stylesheet" type="text/css" href="css/reset.css" >
<link rel="stylesheet" type="text/css" href="css/style.css" >
<link rel="stylesheet" type="text/css" href="jquery-confirm/jquery-confirm.css" >
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" >		
		<script>
		$(document).ready(function(){
			$(".news").fancybox();
		});
		</script>
</head>
<body>
<div id= "block-body">
<?php
	include ("include/block-header.php");
	$all_count = mysqli_query($link,"SELECT * FROM news");
	$result_count = mysqli_num_rows($all_count);
?>
	<div id ="block-content">
		<div id ="block-parameters">
			<p id ="count-client">Новости - <strong><?echo $result_count; ?></strong> </p>
		<p align="right" id="add-style"><a class="news" href="#news">Добавить новость</a></p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		if(@$massege!="")echo $massege;
		$result= mysqli_query($link,"SELECT * FROM news ORDER BY id DESC");
		if(mysqli_num_rows($result)>0){
			$row =mysqli_fetch_array($result);
			do{
				echo'
				<div class="block-news">
				<h3>'.$row["title"].'</h3>
				<span>'.$row["date"].'</span>
				<p>'.$row["text"].'</p>
				
				<p class="links-action" align="right"><a class="delete" rel="news.php?id='.$row["id"].'&action=delete">Удалить</a></p>
				</div>
				
				';
			}while($row=mysqli_fetch_array($result));
		}
?>
		<div id="news">
		<form method="POST">
		<div id="block-input">
			<label>Заголовок<input type="text"name="news_title" /></label>
			<label>Описание<textarea name="news_text"></textarea></label>
		</div>
		<p align="right">
		<input type="submit" name="submit_news"id="submit_news" value="Добавить" />
		</p>
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