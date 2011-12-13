<?php
class Utility {
	static function getDateBefore($date , $month , $year , $diff) {
		$from = mktime(0,0,0,$month,$date,$year);
		$to = strtotime('-'.$diff.'day',$from);
		return $to;
	}
	static function getThisWeek() {
		$to = mktime(0,0,0,date('m'),date('d'),date('y'));
		$from = strtotime('-7day',$to);
		return  array($from,$to);
	}
	static function getDateList($day,$current,$move,$show) {
		$list = array();
		$i = 1;
		if($show == "day")
			$list[0] = $current;
		
		for ($i = 1; $i <= $day; $i++) {
			$from = strtotime(''.$move.''.$i.$show,$current);
			$list[$i] = $from;
		}
		return $list;
	}
	
	static  function getDateFormat($showtype){
		$types = array('day' => 'd M Y','week' => 'M Y' ,'month' => 'M Y', 'year' => 'Y');
		$result = "d M Y";
		if ($types[$showtype]) $result = $types[$showtype];
		return $result;
	}
	
	static function getThisMonth() {
		$to = mktime(0,0,0,date('m'),date('d'),date('y'));
		$diff = date('d') -1;
		$from = strtotime('-'.$diff.'day',$to);
		return  array($from,$to);
	}
	
	static function getDateBetween($from , $to){
		list($day, $month, $year) = split('-', $from);
		$from = mktime(0,0,0,$month,$day,$year);
		list($day, $month, $year) = split('-', $to);
		$to = mktime(0,0,0,$month,$day,$year);
		return  array($from,$to);
	}
	static function getThisYear() {
		$to = mktime(0,0,0,date('m'),date('d'),date('y'));
		$diff = date('d') -1;
		$from = strtotime('-'.$diff.'day',$to);
		return  array($from,$to);
	}
	static function getStringOfTime($time){
		return date("Y-m-d H:i:s",$time);
	}
	static function getStringOfDate($time){
		return date("d-m-Y",$time);
	}
}
?>