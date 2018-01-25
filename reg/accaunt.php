
<?php
define('myeshop',true);
include ("../include/db_connect.php");
include ("../functions/functions.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
if( $_POST["reg_submit"]){

$login= clearStr($_POST['login']);
$password = md5(clearStr($_POST['password']));
$surname = clearStr($_POST['surname']);
$name = clearStr($_POST['name']); 
$patronymid = clearStr ($_POST['patronymid']); 
$email= clearStr ($_POST['email']);
$phone= clearStr ($_POST['phone']);
$address= clearStr ($_POST['address']);
$captcha= clearStr ($_POST['captcha']);

    

if(!$login or !$password or !$surname or !$name or !$patronymid  or !$email or !$phone or !$address  or !$captcha ) MassegeSendRed (1,'Неправильная валидация формы');
if ($_SESSION['captcha'] != md5($_POST["captcha"]))MassegeSendRed (1,'Неправильная капча');

$row = mysqli_fetch_array(mysqli_query($link, "SELECT `login`
 FROM reg_user WHERE `login` = '$login'"));
if($row['login'])MassegeSendRed (1,'Логин <b>'.$login.'</b> уже используется' ); 

$row = mysqli_fetch_array(mysqli_query($link, "SELECT `email`
 FROM reg_user WHERE `email` = '$email'"));
if($row['email'])MassegeSendRed (1,'Email <b>'.$email.'</b> уже используется' ); 

$ip = $_SERVER ['REMOTE_ADDR'];

 $sql= mysqli_query($link,"INSERT INTO reg_user (login,password,surname,name,patronymid,email,phone,address,ip) 
														VALUES(
														'$login',
														'$password',
														'$surname',
														'$name',
														'$patronymid',
														'$email',
														'$phone',
														'$address','$ip')"
														); 

}
}
header("location:../register.php");
MassegeSendGreen (3,'Вы успешно зарегестрировались');
?>

