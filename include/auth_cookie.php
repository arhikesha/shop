<?php

if($_SESSION['auth'] != 'yes_auth' && $_COOKIE ["rememberme"]){
	
	$str = $_COOKIE["rememberme"] ;//setcookie ('rememberme',$login.'+'.$pass,time()+3600*24*31,"/")- принимаем этот файл и затем делим на строки
	
	//Вся длина строки
	$all_len = strlen	($str);
	//длина логина
	$login_len = strpos ($str,'+');//количество симолов до знака +
	
	//Обрезаем троку дo плюса и получаем Логин
	$login = clearStr (substr($str,0,$login_len));
	
	//получаем пароль
	$pass = clearStr(substr($str,$login_len +1 , $all_len));//обрезать без плюса
	
	$result = mysqli_query ($link, "SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND password = '$pass'");
	if(mysqli_num_rows($result)>0 ){
		
		$row = mysqli_fetch_array ($result);
		session_start();
		$_SESSION['auth'] = 'yes_auth';
		$_SESSION['auth_pass'] = $row ["password"];
		$_SESSION['auth_login'] = $row ["login"];
		$_SESSION['auth_surname'] = $row ["surname"];
		$_SESSION['auth_name'] = $row ["name"];
		$_SESSION['auth_patronymid'] = $row ["patronymid"];
		$_SESSION['auth_address'] = $row ["address"];
		$_SESSION['auth_phone'] = $row ["phone"];
		$_SESSION['auth_email'] = $row ["email"];
		}
	}

?>