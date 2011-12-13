<?php
class Timeline {
	public static function fillEmptyDates($dates,$mindate,$show) {
		$diff = $mindate - count($dates);
		if($diff==$mindate){
			$current = mktime(0,0,0,date('m'),date('d'),date('y'));
			$list = Utility::getDateList($mindate,$current,'-',$show);
			$list = array_reverse($list);
			foreach ($list as $date){
				$dates[count($dates)] = 'nodata'.date(Utility::getDateFormat($show),$date);
			}
		}else{
			$last = strtotime($dates[count($dates)-1]);
			$lastday =strtotime('+1day',$last);
			$list = Utility::getDateList($diff,$lastday,'+',$show);
			foreach ($list as $date){
				$dates[count($dates)] = 'nodata'.date(Utility::getDateFormat($show),$date);
			}
		}
		return $dates;
	}
}

?>