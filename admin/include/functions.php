<?php
	defined('myeshop') or die ('Доступ запрещён!');

@session_start();

function clearInt($data)
{
	return abs((int)$data);
}
function clearStr($data)
{
	global $link;
	return mysqli_real_escape_string($link,trim(strip_tags($data)));
}

?>