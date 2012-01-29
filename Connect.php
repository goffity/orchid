<?php
$hostname_Connect = "localhost:3309";
$database_Connect = "wordpress2";
$username_Connect = "root";
$password_Connect = "root";

$Connect = mysql_pconnect($hostname_Connect, $username_Connect, $password_Connect) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_db_query($database_Connect, "SET NAMES utf8", $Connect);

?>
