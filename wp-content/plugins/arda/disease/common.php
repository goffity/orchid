<? 
	mysql_connect("localhost","root","1q2w3e4r");
	mysql_select_db("doe");
	$charset = "SET character_set_results=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	$charset = "SET character_set_client=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	//$charset = "SET character_set_results=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
	$charset = "SET character_set_connection=utf8"; mysql_query($charset) or die('Invalid query: ' . mysql_error()); 
?>

