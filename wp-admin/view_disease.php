<?php
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$disease_id=$_REQUEST['disease_id'];
	
	$show_query="SELECT * FROM disease WHERE disease_id='".$disease_id."'";
	$show_result=mysql_query($show_query,$Connect)or die(mysql_error());
	$show_row=mysql_fetch_array($show_result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Orchid</title>
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style></head>

<body>
<br />
<table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td width="298" height="25"><div align="right"><strong>ชื่อโรค( ภาษาไทย) </strong></div></td>
    <td width="23" height="25"><div align="center">:</div></td>
    <td width="571" height="25"><div align="left"><?php echo $show_row['disease_name_th'];?></div></td>
  </tr>
  <tr>
    <td width="298" height="25"><div align="right"><strong>ชื่อโรค (ภาษาอังกฤษ) </strong></div></td>
    <td width="23" height="25"><div align="center">:</div></td>
    <td width="571" height="25"><div align="left"><?php echo $show_row['disease_name_eng'];?></div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
    <td height="25"><div align="center">:</div></td>
    <td height="25"><div align="left">
      <?php 
			$sql="SELECT * FROM search_key WHERE key_id='".$show_row['key_id']."' AND search_type_id = 'st002' ORDER BY key_id ASC";
			$result=mysql_query($sql,$Connect)or die(mysql_error());
		
			while($row=mysql_fetch_array($result)){
				echo $row['key_name']." ,";
			}
		
		?>
    </div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"></div></td>
    <td height="25"><div align="center"></div></td>
    <td height="25"><div align="left"></div></td>
  </tr>
  <tr>
    <td height="25" valign="top"><div align="right"><strong>สกุลที่พบโรค </strong></div></td>
    <td height="25" valign="top"><div align="center">:</div></td>
    <td height="25"><div align="left">
            <?php 
			$sql_family="SELECT family.family_name_th AS fam_th,
								family.family_name_eng as fam_en
						FROM family
						LEFT JOIN disease_ref
						ON(family.family_id = disease_ref.family_id )
						WHERE disease_ref.disease_id ='".$show_row['disease_id']."'
			";
			
			$result_family = mysql_query($sql_family,$Connect) or die(mysql_error());
			
			while($row_family=mysql_fetch_array($result_family))
			{
				echo $row_family['fam_th']."[".$row_family['fam_en']."], ";
			}
			
		?>

    </div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"></div></td>
    <td height="25"><div align="center"></div></td>
    <td height="25"><div align="left"></div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
    <td height="25"><div align="center">:</div></td>
    <td height="25"><div align="left"><?php echo $show_row['disease_url'];?></div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"><strong>ที่มาของข้อมูล(เพิ่มเติม)</strong></div></td>
    <td height="25"><div align="center">:</div></td>
    <td height="25"><div align="left"><?php echo $show_row['disease_source'];?></div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"></div></td>
    <td height="25"><div align="center"></div></td>
    <td height="25"><div align="left"></div></td>
  </tr>
  <tr>
    <td height="25" valign="top"><div align="right"><strong>เนื้อหา</strong></div></td>
    <td height="25" valign="top"><div align="center">:</div></td>
    <td height="25" valign="top"><div align="left"><?php echo $show_row['disease_characteristic'];?></div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"></div></td>
    <td height="25"><div align="center"></div></td>
    <td height="25"><div align="left"></div></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td height="25">&nbsp;</td>
    <td height="25"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="edit_disease.php?disease_id=<?php echo $disease_id;?> ">แก้ไขข้อมูล</a></label></td>
  </tr>
</table>
</body>
</html>