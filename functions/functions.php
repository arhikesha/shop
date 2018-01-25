<?php
	defined('myeshop') or die ('Доступ запрещён!');
session_start();
function clearInt($data)
{
	return abs((int)$data);
}
function clearStr($data)
{
	global $link;
	return mysqli_real_escape_string($link,trim(strip_tags($data)));
}

function MassegeSendRed($p1, $p2){ 
	if($p1 == 1) $p1 = 'Ошибка';
	else if($p1 == 2)$p1 = 'Подсказка';
	else if ($p1 == 3)$p1 ='Информация';
	$_SESSION['massege'] = '<div class="MassageRed"><b>'.$p1.'</b>: '.$p2.'</div>';
	//if ($p3) $_SERVER ['HTTP_REFERER'] =$p3;
	exit(header('Location:'.$_SERVER['HTTP_REFERER']));
	}

function MassegeShowRed(){
	if($_SESSION['massege'])$Massege = $_SESSION['massege'];
	echo $Massege;
	$_SESSION['massege'] = array();
}
function MassegeSendGreen($p1, $p2){ 
	if($p1 == 1) $p1 = 'Ошибка';
	else if($p1 == 2)$p1 = 'Подсказка';
	else if ($p1 == 3)$p1 ='Информация';
	$_SESSION['massege'] = '<div class="MassageGreen"><b>'.$p1.'</b>: '.$p2.'</div>';
	//if ($p3) $_SERVER ['HTTP_REFERER'] =$p3;
	exit(header('Location:'.$_SERVER['HTTP_REFERER']));
	}

function MassegeShowGreen(){
	if($_SESSION['massege'])$Massege = $_SESSION['massege'];
	echo $Massege;
	$_SESSION['massege'] = array();
}

// функция генерации случайного пароля
function fungenpass(){
	$number = 8;//длина пароля
	
	$arr = array ('a','b','c','d','e','f',
								'g','h','i','j','k','l',
								'm','n','o','p','r','s',
								't','u','v','x','y','w','z',
								'1','2','3','4','5','6','7',
								'8','9','0');
	//генерируем пароль
	$pass = "";
	for ($i = 0; $i < $number;$i++){
		//вычисляем случайный индекс
		$index = rand (0,count ($arr) - 1);
		$pass.= $arr[$index];
	}
		return $pass;
}

function send_mail ($from,$to,$subject,$body){
	$charset = 'utf-8';
	mb_language ("ru");
	$headers = "MIME-Version 1.0 \n";
	$headers .="from:<".$from.">\n";
	$headers .="Reply-To: <".$from.">\n";
	$headers .="Content-Type: text/html; charset =$charset \n";
	
	$subject = '=?'.$charset.'?B?'.base64_encode($subject).'?=';
	
	mail ($to,$subject,$body,$headers);
}

//Группировка цен по разрядам
function group_numerals ($int){
	
	switch (strlen($int)){
		
		case '4':
		$price = substr($int,0,1).' '.substr($int,1,4);
		break;
		
		case '5':
		$price = substr($int,0,2).' '.substr($int,2,5);
		break; 
		
		case '6':
		$price = substr($int,0,3).' '.substr($int,3,6);
		break; 
		
		case '7':
		$price = substr($int,0,1).' '.substr($int,1,3).' '.substr($int,4,7);
		break; 
		
		default :
		$price = $int;
		break;
	}
	return $price;
}


?>
