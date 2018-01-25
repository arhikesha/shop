<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
		define('myeshop',true);
		include ("db_connect.php");
		include ("../functions/functions.php");
		
		$email = clearStr($_POST ["email"]);//принимаем переменную email с аякс обработки(data:"email="+recall_email,)

		if($email !=""){
				
		$result = mysqli_query ($link,"SELECT email FROM reg_user WHERE  email = '$email'");
		if(mysqli_num_rows($result) >0){

		//Генерация пароля 
		$newpass = fungenpass();
		//шифрование пароля 
		
			
				 $pass = md5($newpass);
					$pass = clearStr($pass);
					$pass = strtolower ("kesha".$pass."oleg"); 
					
					
				//обновление пароля на новый
				$update = mysqli_query ($link,"UPDATE reg_user SET  pass='$pass'WHERE email = '$email' ");
				//отправка нового пароля
					send_mail ('zachariy@gmail.com',
											$email,
											'Новый пароль для сайта MyShop.ru',
											'Ваш пароль:'.$pass);
					echo 'yes';
			}else {
				echo 'Данный Email не найден!';
			}
		}
	}
?>