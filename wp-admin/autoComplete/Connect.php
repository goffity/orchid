<?php
$hostname_Connect = "localhost";
$database_Connect = "pangsakcom_doe";
$username_Connect = "pangsakcom_saruns";
$password_Connect = "123456";
//$username_Connect = "root";
//$password_Connect = "";

$pangsakcom_doe ="pangsakcom_doe";
$tbl_amphur="tbl_amphur";
$tbl_province ="tbl_province";
$tbl_tumbol ="tbl_tumbol";
$tbl_owner ="tbl_owner";
$employee="employee";
$tbl_seq_control_db="tbl_seq_control_db";
$conn;

function Conn2DB()
	{
		global $conn;
		global $hostname_Connect;
		global $username_Connect;
		global $password_Connect;				
		global $pangsakcom_doe;		
		global $database_Connect;	

		$conn = mysql_connect( $hostname_Connect, $username_Connect, $password_Connect );
		if ( ! $conn )
			die( "Error 0 : Cannot connect to Database!" );
		mysql_select_db( $database_Connect, $conn )
			or die ( "ไม่สามารถเลือกใช้งานฐานข้อมูล $set_db ได้" );
			mysql_db_query($database_Connect, "SET NAMES tis620", $conn);
	}

function CloseDB()
	{	
		global $conn;
		mysql_close( $conn );
	}
	/*
$Conn = mysql_connect($ServerName,$User,$Password) or die ("????????????????????????????????");

//?????????????????? ???
mysql_select_db($DatabaseName,$Conn) or die ("??????????????????????????????");

$cs1 = "SET character_set_results=tis620";
mysql_query($cs1) or die('Error query: ' . mysql_error()); 

$cs2 = "SET character_set_client = tis620";
mysql_query($cs2) or die('Error query: ' . mysql_error()); 

$cs3 = "SET character_set_connection = tis620";
mysql_query($cs3) or die('Error query: ' . mysql_error());*/


?>
