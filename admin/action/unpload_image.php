<?php
//defined('myeshop') or die ('Доступ запрещён!');
include ("../include/db_connect.php");
$error_img=array();

if($_FILES['unpload_image']['error'] >0){
	//В зависимости от номера ошибки выводим соответсвуещее сообщение
	switch ($_FILES['unpload_image']['error']){
		case 1:$error_img[] = 'Размер файла превышает допустимое значение UPLOAD_MAX_FILE_SIZE';break;
		case 2:$error_img[] = 'Размер файла превышает допустимое значение MAX_FILE_SIZE';break;
		case 3:$error_img[] = 'Не удалось загрузить часть файла';break;
		case 4:$error_img[] = 'Файн не был загружен';break;
		case 5:$error_img[] = 'Отсутсвует временная папка';break;
		case 6:$error_img[] = 'Не удалось записать файл на диск';break;
		case 7:$error_img[] = 'PHP-расширение остановило загрузку файла';break;
	}
}else{
	//Проверяем разширение
	if($_FILES['unpload_image']['type'] =='image/jpeg' || $_FILES['unpload_image']['type'] =='image/jpg' || $_FILES['unpload_image']['type'] =='image/png' ){
		
		$imgext = strtolower (preg_replace("#.+\.([a-z]+)$#i","$1",$_FILES['unpload_image']['name']));
		
		//Папка для загрузки 
		$unploaddir = '../upload_images/';
		//Новое сгенерированое имя файла 
		$newfilename = $_POST["form_type"].'-'.$id.rand(10,100).'.'.$imgext;
		//Путь к файлу (папка.файл)
		$unploadfile = $unploaddir.$newfilename;
		//Загружаем файл move_uploaded_filemove_uploaded_file
		if(@move_uploaded_file($_FILES['unpload_image']['tmp_name'],$unploadfile)){
			
			$update = mysqli_query($link,"UPDATE table_products SET image='$unploadfile' WHERE products_id ='$id'");
		}else {
			$error_img[] = "Ошибка загрузки файла";
		}
	}else {
		$error_img[] = "Допустимые разширение: jpeg,jpg,png";
	}
}

?>