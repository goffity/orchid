<?php
class DatabaseUtil {
	var $link;
	function getConnection(){
		$db_host		= 'localhost';
		$db_user		= 'root';
		$db_pass		= 'onmodao';
		$db_database	= 'newscrawler_utf8'; 

		$this->link = mysql_connect('localhost',$db_user,$db_pass) or die('Unable to establish a DB connection');
		mysql_select_db($db_database,$this->link);
		mysql_query("SET names UTF8");
	}
	
	function close(){
		mysql_close($this->link);
	}
	
	public function getResult($query){
		$this->getConnection();
		$result = mysql_query($query);
		$this->close();
		return $result;	
	}
}

?>
