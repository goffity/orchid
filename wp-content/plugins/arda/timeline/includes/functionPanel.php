<DIV id="logoandname" align="left"><span style="color: white;">Event News Timeline</span></DIV>
<DIV id="search">
<DIV id="search-col1">
<span style="color: white;">
<form name="showform" action="index.php" method="POST">
	<input type="hidden" name="from" value="<?php echo $from;?>"> 
	<input type="hidden" name="to" value="<?php echo $to;?>"> 
	<input type="hidden" name="userinput" value="no">
	<input type="hidden" name="fastsearch" value="no">
	<label for="dates">Show</label> 
	<select name="show" id="dates" onChange="showform.submit();">
		<?php
		foreach ($types as $type){
			echo ($type == $show) ? '<option value="'.$type.'" selected="selected">'.$type.'</option>':'<option value="'.$type.'">'.$type.'</option>';
		}
		?>
	</select>
</form>
</span>
</DIV>
<div id="search-col2">
<form name="form1" action="index.php" method="POST"><span style="color: #fff;"> <input type="hidden" name="show" value="<?php echo $show; ?>"> 
	<label for="from" style="margin-right: 10px">From</label> 
	<a href="#" title="Date-Month-Year"><input type="text" size="11" name="from" id="from" style="margin-right: 10px"	value="<?php echo Utility::getStringOfDate($from); ?>"></a>
	<label for="to" style="margin-right: 10px">To</label> 
	<a href="#" title="Date-Month-Year"><input type="text" size="11" name="to" id="to" style="margin-right: 10px" value="<?php echo Utility::getStringOfDate($to); ?>"></a>
	<input type="hidden" name="show" value="<?php echo $show; ?>">
	<input type="hidden" name="userinput" value="yes">
	<input type="hidden" name="fastsearch" value="no">
	<input type="submit" name="search" value="Search"> </span>
</form>
</div>

<div id="search-col3">
<form name="monthform" action="index.php" method="POST">
	<?php list($monthform, $monthto) = Utility::getThisMonth();?>
	<input type="hidden" name="userinput" value="no">
	<input type="hidden" name="show" value="<?php echo $show; ?>">
	<input type="hidden" name="from" value="<?php echo $monthform; ?>">
	<input type="hidden" name="to" value="<?php echo $monthto;?>"> 
	<input type="hidden" name="fastsearch" value="yes">
	<input type="submit" name="thismonth" value="This month">
</form>
</div>

<div id="search-col3">
<form name="weekform" action="index.php" method="POST">
	<?php list($weekfrom, $weekto) = Utility::getThisWeek();?>
	<input type="hidden" name="userinput" value="no">
	<input type="hidden" name="fastsearch" value="yes">
	<input type="hidden" name="show" value="<?php echo $show; ?>"> 
	<input type="hidden" name="from" value="<?php echo $weekfrom ?>"> 
	<input type="hidden" name="to" value="<?php echo  $weekto;?>"> 
	<input type="submit" name="this week" value="This week""></form>
</div>
</DIV>
