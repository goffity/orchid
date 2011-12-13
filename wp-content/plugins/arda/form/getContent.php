<?
include"common.php";
	$id=$_GET["id"];
	$sql="SELECT * FROM setvariable WHERE  id=".$id;

	$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
	$row=mysql_fetch_array($r);
	$data = file_get_contents($row[0]);
	echo htmlspecialchars($data) ;
?>