<?php session_start();

	include("../Connect.php");

	$do=$_GET['do'];
	
	//delete image
	if($do=="del_orchid")
	{
		$orchidID = $_GET['orchidID'];
		$NameTH = $_GET['NameTH'];
		$NameEN = $_GET['NameEN'];
		
		mysql_select_db($database_Connect, $Connect);	
		//Del orchid_varity
		$sql = "DELETE FROM orchid_varity WHERE orchid_id  = '".$orchidID."'";
		$result = mysql_query($sql, $Connect);
		//Del search_key
		$sqlTH="DELETE FROM search_key WHERE key_name = '".$NameTH ."' AND search_type_id='st004'";
		$resultTH = mysql_query($sqlTH, $Connect);

		$sqlEN="DELETE FROM search_key WHERE key_name = '".$NameEN ."' AND search_type_id='st004'";
		$resultEN = mysql_query($sqlEN, $Connect);
		
		//Del wp-post
		

		echo"<meta http-equiv='refresh' content='0;URL = manage_orchid.php'>";
	}
	
	else if($do=="del_disease")
	{
		mysql_select_db($database_Connect, $Connect);	
		
		$DiseaseID = $_REQUEST['DiseaseID'];
		
		$del_com="DELETE FROM disease WHERE disease_id='".$DiseaseID."'";
		mysql_query($del_com,$Connect) or die(mysql_error());
		
		echo"<meta http-equiv='refresh' content='0;URL = manage_disease.php'>";
	}
	
	// delete clip video
	else if($do=="del_research")
	{
		$RID = $_GET['RID'];
		
		mysql_select_db($database_Connect, $Connect);	
		
		$sql2 = "DELETE  FROM research WHERE ResearchID = '".$RID."'";
		$result2 = mysql_query($sql2, $Connect);
		echo"<meta http-equiv='refresh' content='0;URL = manage_research.php'>";
	}
	



?>