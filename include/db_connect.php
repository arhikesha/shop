<?php
	defined('myeshop') or die ('Доступ запрещён!');
	//defined('myeshop') or header(Location:error.php);
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'db_shop');
$link = mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);

mysqli_select_db($link, DB_NAME) or die("Нет соединения с БД".mysqli_error());
mysqli_query($link,"SET NAMES 'utf-8'");


?>