<?php
//defined('myeshop') or die ('Доступ запрещён!');
define('myeshop',true);
include ("../include/db_connect.php");
if($_FILES ['gelleryimg']['name'][0]){
	
	for($i =0;$i< count($_FILES['gelleryimg']['name']);$i++){
		$error_gelleryimg = "";
		
	if($_FILES['gelleryimg']['name'][$i]){
		
		$galleryimgType = $_FILES['gelleryimg']['type'][$i];//тип файла
		$types = array ("image/gif","image/png","image/jpeg","image/jpg","image/x-png");//массив разширение
		
		// разширение картини
		$imgext = strtolower (preg_replace("#.+\.([a-z]+)$#i","$1",$_FILES['gelleryimg']['name'][$i]));	
		//Папка для загрузки
		$unploaddir = '../upload_images/';
		//Новое сгенерированое имя файла 
		$newfilename = $_POST["form_type"].'-'.$id.rand(10,200).'.'.$imgext;
		//Путь к файлу (папка.файл)
		$unploadfile = $unploaddir.$newfilename;
	
		if(!in_array($galleryimgType,$types))//!in_array - проверяет массив на тип файла $types
		{
			$error_gelleryimg ="<p id ='form-error'>Допустимые разширение -gif, .jpg, .png</p>";
			$_SESSION['answer'] =$error_gelleryimg;
			continue;
		}
			
				if (@move_uploaded_file($_FILES['gelleryimg']['tmp_name'][$i],$unploadfile)){
					
				$unpload_img =mysqli_query ($link,"INSERT INTO `db_shop`.`uploads_images`(`id`, `product_id`, `image`)
									VALUES (NULL, 
									'".$id."',
									'".$newfilename."')");
				}else {
					$_SESSION ['answer'] = "Ошибка загрузки файла";
				}
			
		
		}
	}
}


?>