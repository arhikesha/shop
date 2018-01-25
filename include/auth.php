<?php
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		define('myeshop',true);
		include ("db_connect.php");
		include ("../functions/functions.php");
		
		$login = clearStr($_POST ["login"]);
		
		$pass = md5(clearStr($_POST["pass"]));
		
		
		
		if($_POST ["rememberme"] =="yes"){
				
				setcookie ('rememberme',$login.'+'.$pass,time()+3600*24*31,"/");
		}
		
		$result = mysqli_query ($link,"SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND password = '$pass'");
		if(mysqli_num_rows($result) >0){
			
		$row = mysqli_fetch_array($result);
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
		echo 'yes_auth';

	}else {
		echo 'no_auth';
	}
}





?>