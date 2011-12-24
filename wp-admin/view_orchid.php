<?php
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$orchidID=$_REQUEST['orchidID'];
	
	$show_query="SELECT * FROM orchid_varity WHERE orchid_id='".$orchidID."'";
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

    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="177" height="25"><div align="left">
          <p align="left">&nbsp;</p>
        </div></td>
        <td width="14" height="25"><div align="center"></div></td>
        <td width="701" height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td width="177" height="25"><div align="right"><strong>ชื่อพันธุ์ภาษาไทย</strong></div></td>
        <td width="14" height="25"><div align="center">:</div></td>
        <td width="701" height="25"><div align="left">
          <?php echo $show_row['orchid_name_th'];?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อพันธุ์ภาษาอังกฤษ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $show_row['orchid_name_eng'];?></div></td>
      </tr>

      <tr>
        <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <?php 
			$sql="SELECT * FROM search_key WHERE key_id='".$show_row['key_id']."' AND search_type_id = 'st004' ORDER BY key_id ASC";
			$result=mysql_query($sql,$Connect)or die(mysql_error());
			
			while($row=mysql_fetch_array($result)){
				echo $row['key_name']." ,";
		 }?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>สกุล</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
         <?php $query_family="SELECT family_name_th, family_name_eng FROM family WHERE family_id='".$show_row['family_id']."'";
		  		$result_family= mysql_query($query_family,$Connect)or die(mysql_error());
				$row_family=mysql_fetch_array($result_family);
		echo $row_family['family_name_th']." [".$row_family['family_name_eng']."]";
		?>
		</div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left" style="padding-left:5px; padding-right:5px;"><a href="<?php echo $show_row['orchid_url'];?>" target="_blank"><?php echo $show_row['orchid_url'];?></a></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>รายละเอียด</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left" style="padding-left:5px; padding-right:5px;">
          <?php echo $show_row['orchid_content1'];?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25"><label>&nbsp;&nbsp;&nbsp;<a href="edit_orchid.php?orchidID=<?php echo $orchidID;?> ">แก้ไขข้อมูล</a></label></td>
      </tr>
    </table>


</body>
</html>