<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
		define('myeshop',true);
		include ("db_connect.php");
		include ("../functions/functions.php");

		$id = $_POST ['id'];
		$name = $_POST ['name'];
		$good = $_POST ['good'];
		$bad = $_POST ['bad'];
		$comment = $_POST ['comment'];
		
   mysqli_query ($link,"INSERT INTO `table_reviews`(`products_id`, `name`,`good_reviews`,`bad_reviews`,`comment`,`date`)
													VALUES(
														'".$id."',
														'".$name."',
														'".$good."',
														'".$bad."',
														'".$comment."',
														NOW()
														
														)");
																						
		echo 'OK';
	}													
?>