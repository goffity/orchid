<? 
	$db_host="localhost:3307";
	$db_user="root";
	$db_pwd="root";
	$db="arda";
	mysql_connect($db_host,$db_user,$db_pwd);
	mysql_select_db($db);
	$charset = "SET character_set_results=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	$charset = "SET character_set_client=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	//$charset = "SET character_set_results=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	$charset = "SET character_set_connection=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
?>