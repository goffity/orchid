<?php
$hostname_Connect2 = "localhost:3307";
$database_Connect2 = "arda";
$username_Connect2 = "root";
$password_Connect2 = "root";

$Connect2 = mysql_pconnect($hostname_Connect2, $username_Connect2, $password_Connect2) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_db_query($database_Connect2, "SET NAMES utf8", $Connect2);

?>
