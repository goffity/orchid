<?php
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
if($_POST['chk_edit']=="YES")
{
	
	$disease_id = $_POST['disease_id'];
	$disease_url= $_POST['disease_url'];
	$disease_url2 = $_POST['disease_url2'];
	$disease_detail=$_POST['disease_detail'];
	
		
	
	$sql="UPDATE disease SET  disease_characteristic='".$disease_detail."',  disease_url='".$disease_url."', disease_source='".$disease_url2."', disease_update_date=now() WHERE disease_id='".$disease_id."' ";
	$result=mysql_query($sql,$Connect)or die(mysql_error());
	
	echo '<meta http-equiv="refresh" content="2;URL=view_disease.php?disease_id='.$disease_id.'">';
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
