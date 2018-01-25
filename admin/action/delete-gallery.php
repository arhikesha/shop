<?php
	if($_SERVER["REQUEST_METHOD"]=="POST"){
	define('myeshop',true);
	include ("../include/db_connect.php");

	$path = $_SERVER['DOCUMENT_ROOT']."../upload_images/".$_POST["title"];// $_SERVER['DOCUMENT_ROOT']-полный пусть к картинки
	
	if(file_exists($path)){
		unlink($path);
		$delete = mysqli_query($link,"DELETE FROM uploads_images WHERE id='{$_POST["id"]}'");
		echo"delete";
	}else {
		echo"delete";
		$delete = mysqli_query($link,"DELETE FROM uploads_images WHERE id='{$_POST["id"]}'");
	}
	
}
?>