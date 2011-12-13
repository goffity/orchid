<?php
require 'db/Data.php';
require 'lib/Util.php';
require 'lib/Timeline.php';
date_default_timezone_set('Asia/Bangkok');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- saved from url=(0037)http://fixedheadertable.com/demo.html -->
<HTML>
<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<TITLE>Timeline : Event news</TITLE>
	<LINK href="css/fixedtable.css" type="text/css" rel="stylesheet">
	<LINK href="css/style.css" type="text/css" rel="stylesheet">
	
	<link media="screen" rel="stylesheet" href="colorbox/colorbox.css" />
	<script src="colorbox/jquery.min.js"></script>
	<script src="colorbox/jquery.colorbox.js"></script>
	
	<link rel="stylesheet" type="text/css" href="colortips/colortip-1.0/colortip-1.0-jquery.css"/>
	<script type="text/javascript" src="colortips/colortip-1.0/colortip-1.0-jquery.js"></script>
	<script type="text/javascript" src="colortips/script.js"></script>
	
	<SCRIPT type="text/javascript" src="js/jquery.fixedheadertable.1.1.2.min.js"></SCRIPT>
	<SCRIPT type="text/javascript">
		jQuery(document).ready(function() {
			var adjustWidth;
			var adjustHeight;
			if ($.browser.msie == true) {
				adjustWidth = 5;
				adjustHeight = 110;
			}
	                else if (jQuery.browser.safari == true) {
				adjustWidth = 20;
				adjustHeight = 110;
	                }
	                else {
				adjustWidth = 5;
				adjustHeight = 110;
	                }
			var windowWidth = $(window).width() - adjustWidth;
			var windowHeight = $(window).height() - adjustHeight;
			
			$(window).resize(function() {
				var windowWidth = $(window).width() - adjustWidth;
				var windowHeight = $(window).height() - adjustHeight;
			
				$('#list').css({'width': windowWidth+'px', 'height': windowHeight+'px'});
			});
			
			$('#list').css({'width': windowWidth+'px', 'height': windowHeight+'px'});
	
			jQuery('#list').fixedHeaderTable({autoResize:true, footer:true,cloneHeaderToFooter:true});
	
			$(".popup").colorbox({
				transition:"none", width:"60%", height:"75%"
			});
		});
		
	</SCRIPT>

</HEAD>
<BODY>

<?php

$show; //day month year
$from; // start date
$to; //end date

if(array_key_exists('show', $_POST)){
	$userinput = $_POST['userinput'];
	if($userinput == 'yes'){
		$from = strtotime($_POST['from']);
		$to = strtotime($_POST['to']);
	}else{
		$from = $_POST['from'];
		$to = $_POST['to'];
	}
	if($_POST['fastsearch']=="no"){
		$show = $_POST['show'];
	}else{
		$show = 'day';
	}
	
}else{
	//Initilize data
	list($from,$to) = Utility::getThisWeek();
//	$to = mktime(0,0,0,'8','2','2010');
//	$from = mktime(0,0,0,'7','26','2007');
	$show = 'day';
}

$data = new Data();
$news = $data->getNewsHeadline($show,Utility::getStringOfTime($from),Utility::getStringOfTime($to));

$dates = array_keys($news);
$mindate = 7;
$columm_width = "150px";

// if dates is less than "mindate"-- fill it.
if(count($dates) < $mindate) 
	$dates =  Timeline::fillEmptyDates($dates, $mindate,$show);


$lastdate = count($dates)-1;
$types = array('day','month','year');
?>

<?php include 'includes/functionPanel.php';?>

<DIV id="list" style="width: 1229px; height: 522px;">
<DIV class="fht_fixed_header" style="width: 1229px; height: 56px;">
<TABLE width="1214px">
	<THEAD>
		<TR>
		<?php  include 'includes/tableHeader.php';?>
		</TR>
	</THEAD>
</TABLE>
</DIV>


<DIV class="fht_table_body"
	style="width: 1229px; height: 410px; overflow-x: auto; overflow-y: auto;">
<TABLE style="width: 1214px; margin-top: -56px;">
	<THEAD>
		<TR>
		<?php  include 'includes/tableHeader.php';?>
		</TR>
	</THEAD>
	<TBODY>
		<TR>
		<?php
		foreach ($dates as $date){
			if(substr_count($date, 'nodata')){
				echo '<TD width="'.$columm_width.'" valign="top" bgcolor="grey"><DIV style="width:'.$columm_width.';overflow:hidden;height:450px;">';
				echo '</DIV></TD>';
			}else{
				echo '<TD width="'.$columm_width.'" valign="top"><DIV style="width:'.$columm_width.';overflow:hidden;">';
				$titles = $news[$date];
				foreach ($titles as $title){
					echo '<A HREF="detail.php?id='.$title['id'].'" class="popup" ><DIV class="content">'.$title['title'].'</DIV></A>';
				}
				echo '</DIV></TD>';
			}
		}
		?>
		</TR>
	</TBODY>
</TABLE>
</DIV>
<DIV class="fht_fixed_header" style="width: 1229px; height: 56px;">
<TABLE width="1214px">
	<THEAD>
		<TR>
		<?php  include 'includes/tableHeader.php';?>
		</TR>
	</THEAD>
</TABLE>
</DIV>
</DIV>

</BODY>
</HTML>
