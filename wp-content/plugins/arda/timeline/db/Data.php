<?php
require 'DatabaseUtil.php';

class Data{
	
	public function getNewsHeadline($showtype,$from ,$to){
		$db = new DatabaseUtil();
		$query="SELECT id,category,title,timestamp FROM document_metadata where category='disease' AND timestamp >= '".$from."' AND timestamp < '".$to."' ";
		$result = $db->getResult($query);
		
		$dates = array();
		while($row = mysql_fetch_array($result)){
			$key = date($this->getDateFormat($showtype),strtotime($row['timestamp']));
			if (!array_key_exists($key, $dates)) {
				$dates[$key] = array($row);
			}else{
				$value = $dates[$key];
				$dates[$key][count($value)] = $row;
			}
		}
		return $dates;
	}
	
	public function getNewsDetail($id){
		$db = new DatabaseUtil();
		$query= 'SELECT detail , title FROM document_metadata where id="'.$id.'"';
		$result = $db->getResult($query);
				
		$detail;
		while($row = mysql_fetch_array($result)){
			$detail = $row;
		}
		return $detail;
	}
	
	private  function getDateFormat($showtype){
		$types = array('day' => 'd M Y','week' => 'M Y' ,'month' => 'M Y', 'year' => 'Y');
		$result = "d M Y";
		if ($types[$showtype]) $result = $types[$showtype];
		return $result;
	}
}
?>
