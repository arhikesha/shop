<?php
	session_start();

	if($_SESSION['auth_admin']=="yes_auth"){
	define('myeshop',true);

if(isset ($_GET ["logout"]))//если есть ключевое слово в адресной строке "logout"
{
	unset ($_SESSION ['auth_admin']);
	header("Location:login.php");
}
$_SESSION ['urlpage'] = "<a href = 'index.php'>Главная </a> \ <a href = 'view_order.php'>Просмотр заказов </a>";

include ("include/db_connect.php");
include ("include/functions.php");
@$id=clearStr($_GET["id"]);
@$action=clearStr($_GET["action"]);
if(isset($action)){
	
switch($action){
	case 'accept':
	if($_SESSION['accept_orders']=='1'){
		$update = mysqli_query($link,"UPDATE orders SET order_confimed ='yes' WHERE order_id ='$id'");
		}else{
				$msgeerror = 'У вас нет прав на подтверждения заказов!';
		}
		break;
		
	
		case 'delete':
			if($_SESSION['delete_orders']=='1'){
		$delete = mysqli_query($link,"DELETE FROM orders WHERE order_id ='$id'");
		header("Location:orders.php");
			}else{
				$msgeerror = 'У вас нет прав на удаление заказов!';
			}
		break;
			}
	} 
 
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
		<title>Панель управления - Просмотр заказов</title>
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
			<p id ="title-page">Просмотр заказа </p>
		</div>
<?php
		if(isset ($msgeerror))echo'<p id="form-error"align="center">'.$msgeerror.'</p>';
		
		if($_SESSION['view_orders'] =='1')
		{
		$result = mysqli_query($link,"SELECT * FROM orders WHERE order_id='$id'");
	
		if(mysqli_num_rows($result)>0){
			$row = mysqli_fetch_array($result);
			do{
				if($row["order_confimed"] =="yes"){
					$status = '<span class="green">Обработан</span>';
				}else{
					$status = '<span class="red">Не обработан</span>';
				}
		echo'
				<p class="view-order-link"><a class="green" href="view_order.php?id='.$row["order_id"].'&action=accept">Подтвердить заказ</a> | <a class="delete" rel="view_order.php?id='.$row["order_id"].'&action=delete">Удалить заказ</a></p>
				<p class="order-datetime">'.$row["order_datetime"].'</p>
				<p class="order-number">Заказ №'.$row["order_id"].'-'.$status.'</p>
				
				<table align="center" cellpadding="10" width="100%">
				<tr>
				<th >№</th>
				<th>Наименование товара</th>
				<th>Цена</th>
				<th>Количество</th>
				</tr>			
				';
		$query_product = mysqli_query($link,"SELECT * FROM bay_products,table_products WHERE bay_products.buy_id_order ='$id' AND table_products.products_id=bay_products.buy_id_product");
		$result_query = mysqli_fetch_array($query_product);	
		do{
		@$price = $price + ($result_query["price"] * $result_query["buy_count_product"]);
		@$index_count = $index_count+1;
	
	echo'
		<tr>
		<td align="center">'.$index_count.'</td>
		<td align="center">'.$result_query["title"].'</td>
		<td align="center">'.$result_query["price"].'</td>
		<td align="center">'.$result_query["buy_count_product"].'</td>
		</tr>
		';
			}while($result_query=mysqli_fetch_array($query_product));
		
			if($row["order_pay"] =="accepted"){
				$statpay='<span class="green">Оплачено</span>';
			}else{
				$statpay ='<span class="red">Не оплачено</span>';
			}
		
		echo'
		</table>
		<ul id="info-order">
		<li>Общая цена - <span>'.$price.'</span> грн</li>
		<li>Способ доставки - <span>'.$row["order_dostavka"].'</span></li>
		<li>Статус облаты- '.$statpay.'</li>
		<li>Тип оплаты - <span>'.$row["order_type_pay"].'</span></li>
		<li>Дата оплаты - <span>'.$row["order_datetime"].'</span></li>
		</ul>
		
		<table align="center" cellpadding="10" width="100%">
		<tr>
		<th>ФИО</th>
		<th>Адрес</th>
		<th>Контакты</th>
		<th>Примечание</th>
		</tr>
		
		<tr>
		<td align="center">'.$row["order_fio"].'</td>
		<td align="center">'.$row["order_address"].'</td>
		<td align="center">'.$row["order_phone"].'<br />'.$row["order_email"].'</td>
		<td align="center">'.$row["order_note"].'</td>
		</tr>
		</table>
		';
		
			}while($row=mysqli_fetch_array($result));
		}
	}else{
		echo'<p id="form-error" align="center">У вас нет прав на просмотр данного раздела!</p>';
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