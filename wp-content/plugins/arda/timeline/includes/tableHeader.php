<?php
for ( $i = 0; $i < count($dates); $i++){
	$dispdate;
	if(substr_count($dates[$i], 'nodata')){
		$dispdate = str_replace("nodata", "", $dates[$i]);
	}else{
		$dispdate = $dates[$i];
	}
		
	if($i==0){
		echo '<TH class="first-cell" width="'.$columm_width.'"><DIV class="empty-cell" style="width:'.$columm_width.';">'.$dispdate.'</DIV></TH>';
	}elseif($i==$lastdate){
		echo '<TH class="last-cell" width="'.$columm_width.'"><DIV class="empty-cell" style="width:'.$columm_width.';">'.$dispdate.'</DIV></TH>';
	}else{
		echo '<TH width="'.$columm_width.'"><DIV class="empty-cell" style="width:'.$columm_width.';">'.$dispdate.'</DIV></TH>';
	}
}
?>