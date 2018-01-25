<?php
error_reporting(E_ALL & ~E_NOTICE);
if($_SERVER["REQUEST_METHOD"]=="POST"){
		define('myeshop',true);
		include ("db_connect.php");
		include ("../functions/functions.php");
		$result = mysqli_query($link,"SELECT * FROM cart, table_products WHERE cart.cart_ip = '{$_SERVER ['REMOTE_ADDR']}' AND table_products.products_id = cart.cart_id_products");
		if(mysqli_num_rows($result)>0){

		$row = mysqli_fetch_array($result);
		
		do{
			$count = $count +$row ["cart_count"];
			$int = $int + ($row["price"] * $row ["cart_count"]);
		}while($row = mysqli_fetch_array($result));
		
		if ($count == 1 or $count == 21 or $count == 31 or $count == 41 or $count == 51 or $count == 61 or $count == 71 or $count == 81)($str = 'товар');
		if ($count == 2 or $count == 3 or $count == 4 or $count == 22 or $count == 23 or $count == 24 or $count == 32 or $count == 33 or $count == 34 or $count == 42 or $count == 43 or $count == 44 or $count == 52  or $count == 53 or $count == 54 )($str = 'товара');
		if ($count == 5 or $count == 6 or $count == 7 or $count == 8 or $count == 9 or $count == 10 or $count == 32 or $count == 11 or $count == 12 or $count == 13 or $count == 14 or $count == 15 or $count == 16 or $count == 17 or $count == 18 )($str = 'товаров');
			
			if ($count > 54 ){
				$str = "тов";
			}
			
			echo '<span>'.$count.' '.$str.'</span> на сумму <span>'.group_numerals($int).'</span> руб';
		
		}else {
			echo '0';
		}


}
?>