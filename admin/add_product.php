<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'tovar.php'>Товары </a> \ <a>Добавление товара </a>";

include ("include/db_connect.php");
include ("include/functions.php");

if(@$_POST["submit_add"]){
		if($_SESSION['add_tovar'] =='1'){
			
		
	$error = array();
	
	//Проверка полей
	
	if(!$_POST ["form_title"]){
		$error[] ="Укажите название товара";
	}
	if(!$_POST["form_price"]){
		$error[] ="Укажите цену";
	}
	if(!$_POST["form_category"]){
		$error[] ="Укажите категорию";
	}else{
		$result = mysqli_query($link,"SELECT * FROM category WHERE id ='{$_POST["form_category"]}'");//{$_POST["form_category]} =<select name = "form_category" size="10">
		$row = mysqli_fetch_array($result);
		$selectbrend = $row["brend"];
	}
// проверка чекбоксов
if($_POST["chk_visible"]){
	$chk_visible ="1";
}else {$chk_visible ="0";}
	
if($_POST["chk_new"]){
	$chk_new ="1";
}else {$chk_new ="0";}	

if($_POST["chk_leader"]){
	$chk_leader ="1";
}else {$chk_leader ="0";}	

if($_POST["chk_sale"]){
	$chk_sale ="1";
}else {$chk_sale ="0";}		
	
if(count($error)){
	$_SESSION ['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
}else{ 
	
	mysqli_query($link,"INSERT INTO `db_shop`.`table_products`  (`products_id`, `title`, `price`, `brend`, `seo_words`, `seo_description`, `mini_description`, `image`, `description`, `mini_features`, `features`, `datetime`, `new`, `leader`, `sale`, `visible`, `count`, `type_tovara`, `brend_id`, `yes_like`)
	VALUES (NULL, '".$_POST["form_title"]."','".$_POST["form_price"]."','".$selectbrend."','".$_POST["form_seo_words"]."',	'".$_POST["form_seo_description"]."',	
	'".$_POST["txt1"]."','".$update."', '".$_POST["txt2"]."', '".$_POST["txt3"]."', '".$_POST["txt4"]."', NOW(),'".$chk_new."','".$chk_leader."','".$chk_sale."','".$chk_visible."', '0','".$_POST["form_type"]."','".$_POST["form_category"]."', '1')");		
						
											
		$_SESSION['message'] = "<p id='form-success'>Товар успешно добавлен!</p>";
		$id = mysqli_insert_id($link);
		
		if(empty($_POST ["unpload_image"])){
			include("action/unpload_image.php");
			unset($_POST["unpload_image"]);
		}	 						
		if(empty($_POST["gelleryimg"])){
			include("action/unpload_gelleryimg.php");
			unset($_POST["gelleryimg"]);
		}				
} 
}else{
		$msgeerror = 'У вас нет прав на добавление товара!';
}
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
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>	
		
		
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
		<p id ="title-page">Добавление товара </p>
		</div>
<?php
if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		if(isset($_SESSION ['message'])){
			echo $_SESSION ['message'];
			unset ($_SESSION['message']);
		}
		if(isset($_SESSION ['answer'])){
			echo $_SESSION ['answer'];
			unset ($_SESSION['answer']);
		}
		
?>
		<form enctype="multipart/form-data" method ="POST">
		<ul id ="edit-tovar">
		
		<li>
		<label>Название товара</label>
		<input type="text" name="form_title" />
		</li>
		
		<li>
		<label>Цена</label>
		<input type="text" name="form_price" />
		</li>
		
		<li>
		<label>Ключевые слова</label>
		<input type="text" name="form_seo_words" />
		</li>
		
		<li>
		<label>Краткое описание</label>
		<textarea type="text" name="form_seo_description"></textarea>
		</li>
		
		<li>
		<label>Тип товара</label>
		<select name="form_type" id = "type" size="1">
		
		<option value ="mobile">Мобильные телефоны</option>
		<option value ="notebook">Ноутбуки</option>
		<option value ="notepad">Планшеты</option>
		</select>
		</li>
		
		<li>
		<label>Категория</label>
		<select name = "form_category" size="10">
		
		<?php
		 $category = mysqli_query ($link,"SELECT * FROM category");
		if(mysqli_num_rows($category)>0){
			$result_category = mysqli_fetch_array($category);
			do{
				echo ' 
					<option value ="'.$result_category["id"].'">'.$result_category["brend"].'</option>

				';
			}while ($result_category = mysqli_fetch_array($category));
		} 
		?>
		</select>
		</ul>
		<label class="stylelabel">Основаня картинка </label>
		
		<div id ="beseimg-unpload">
		<input type="hidden" name="MAX_FILE_SIZE" value ="5000000" />
		<input type ="file" name="unpload_image" />
		
		</div>
		
		<h3 class="h3click"></p>Краткое описание товара</h3>
		<div class = "div-editor1">
		<textarea id ="editor1" name = "txt1" cols="100" rows="20"></textarea>
			<script type="text/javascript">
				var ckeditor1 = CKEDITOR.replace ("editor1");
					AjexFileManager.init({
						returnTo:"ckeditor",
						editor:ckeditor1
					});
					</script>
		</div>
		
	
		<h3 class="h3click"></p>Oписание товара</h3>
		<div class = "div-editor2">
		<textarea id ="editor2" name = "txt2" cols="100" rows="20"></textarea>
			<script type="text/javascript">
				var ckeditor1 = CKEDITOR.replace ("editor2");
					AjexFileManager.init({
						returnTo:"ckeditor",
						editor:ckeditor1
					});
					</script>
		</div>
		
		<h3 class="h3click"></p>Краткие характеристики</h3>
		<div class = "div-editor3">
		<textarea id ="editor3" name = "txt3" cols="100" rows="20"></textarea>
			<script type="text/javascript">
				var ckeditor1 = CKEDITOR.replace ("editor3");
					AjexFileManager.init({
						returnTo:"ckeditor",
						editor:ckeditor1
					});
					</script>
		</div>
		
		<h3 class="h3click"></p>Характеристики</h3>
		<div class = "div-editor4">
		<textarea id ="editor4" name = "txt4" cols="100" rows="20"></textarea>
			<script type="text/javascript">
				var ckeditor1 = CKEDITOR.replace ("editor4");
					AjexFileManager.init({
						returnTo:"ckeditor",
						editor:ckeditor1
					});
					</script>
		</div>
	
		<label class="stylelabel1">Галлерея картинок</label>
		
		<div id ="objects">
		
		<div id ="addimage1" class ="addimage">
		<input type="hidden" name="MAX_FILE_SIZE" value ="20000000" />
		<input type="file" name="gelleryimg[]" />
		</div>
		
		</div>

		<p id ="add-input">Добивить</p>
		
		<h3 class="h3title">Настройка товара</h3>
		<ul id ="chkbox">
		<li><input type="checkbox" name="chk_visible" id="chk_visible" /><label for="chk_visible">Показыать товар </label></li>
		<li><input type="checkbox" name="chk_new" id="chk_new" /><label for="chk_new">Новый товар </label></li>
		<li><input type="checkbox" name="chk_leader" id="chk_leader" /><label for="chk_leader">Популярный товар </label></li>
		<li><input type="checkbox" name="chk_sale" id="chk_sale" /><label for="chk_sale">Товар со скидкой </label></li>
		</ul>
		
		<p align ="right"><input type="submit" id="submit_form" name="submit_add" value ="Добавить товар" /></p>
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