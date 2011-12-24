<?php

if($_POST['chk_edit']=="YES")
{
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$orchid_id = $_POST['orchidID'];
	$orchid_family= $_POST['orchid_family'];
	$orchid_url = $_POST['orchid_url'];
	$detail=$_POST['detail'];
	
	
	$sql="UPDATE orchid_varity SET family_id='".$orchid_family."', Orchid_Content1='".$detail."',  orchid_url='".$orchid_url."', UpdateDate=now() WHERE orchid_id='".$orchid_id."' ";
	$result=mysql_query($sql,$Connect)or die(mysql_error());
	
	
	echo '<meta http-equiv="refresh" content="2;URL=edit_orchid.php?orchidID='.$orchid_id.'">';
	//inset wp post

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orchid Portal</title>
<style type="text/css">
<!--
.style1 {color: #333333}
body {
	background-color: #FFF;
}
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<p align="center"><img src="images/indicator_medium.gif" width="32" height="32" /></p>
<p align="center" class="style1">Please...Waiting</p>
</body>
</html>
<?php }else{
echo "can't open pages.";
}?>
