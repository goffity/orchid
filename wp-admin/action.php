<?php session_start();

	include("../Connect.php");

	$do=$_GET['do'];
	
	//delete image
	if($do=="del_orchid")
	{
		$orchidID = $_REQUEST['orchidID'];
		$nameTH = $_REQUEST['nameTH'];
		$nameEN = $_REQUEST['nameEN'];
		$key_id = $_REQUEST['key_id'];
		
		mysql_select_db($database_Connect, $Connect);	
		//Del orchid_varity
		$sql = "DELETE FROM orchid_varity WHERE orchid_id  = '".$orchidID."'";
		$result = mysql_query($sql, $Connect);
		
		//Del search_key
		$sqlTH="DELETE FROM search_key WHERE key_name = '".$nameTH ."' AND key_id='".$key_id."' AND search_type_id='st004'";
		$resultTH = mysql_query($sqlTH, $Connect);

		$sqlEN="DELETE FROM search_key WHERE key_name = '".$nameEN ."' AND key_id='".$key_id."' AND search_type_id='st004'";
		$resultEN = mysql_query($sqlEN, $Connect);
		
		//Del wp-post
		
		echo"<meta http-equiv='refresh' content='0;URL = manage_orchid.php'>";
	}
	
	else if($do=="del_disease")
	{
		mysql_select_db($database_Connect, $Connect);	
		
		$disease_id = $_REQUEST['disease_id'];
		$nameTH = $_REQUEST['nameTH'];
		$nameEN = $_REQUEST['nameEN'];
		$key_id = $_REQUEST['key_id'];


		$del_com="DELETE FROM disease WHERE disease_id='".$disease_id."'";
		mysql_query($del_com,$Connect) or die(mysql_error());
		
		//Del search_key
		$sqlTH="DELETE FROM search_key WHERE key_name = '".$nameTH ."' AND key_id='".$key_id."' AND search_type_id='st002'";
		$resultTH = mysql_query($sqlTH, $Connect);

		$sqlEN="DELETE FROM search_key WHERE key_name = '".$nameEN ."' AND key_id='".$key_id."' AND search_type_id='st002'";
		$resultEN = mysql_query($sqlEN, $Connect);
		
		//Del disease_ref
		$sql_ref="DELETE FROM disease_ref WHERE disease_id = '".$disease_id ."' ";
		$result_ref = mysql_query($sql_ref, $Connect);
		
		echo"<meta http-equiv='refresh' content='0;URL = manage_disease.php'>";
	}
	
	
	
	
	
	// delete clip video
	else if($do=="del_research")
	{
		$RID = $_GET['RID'];
		
		mysql_select_db($database_Connect, $Connect);	
		
		$sql2 = "DELETE  FROM research_content WHERE rc_content_id = '".$RID."'";
		$result2 = mysql_query($sql2, $Connect);
		echo"<meta http-equiv='refresh' content='0;URL = manage_research.php'>";
	}
	



?>