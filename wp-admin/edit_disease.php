<?php
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$disease_id=$_REQUEST['disease_id'];
	
	$show_query="SELECT * FROM disease WHERE disease_id='".$disease_id."'";
	$show_result=mysql_query($show_query,$Connect)or die(mysql_error());
	$show_row=mysql_fetch_array($show_result);

	$show_result2=mysql_query($show_query,$Connect)or die(mysql_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Orchid</title>


<style type="text/css">
<!--
.style1 {color: #FF0000}
body {
	background-color: #FFF;
}
-->
</style>

<script type="text/javascript">
function chk_submit()
{
	if(window.document.form1.disease_url.value.length == 0)
	{
		alert("กรุณากรอก เว็บไซต์ที่มา" );
		window.document.form1.disease_url.focus();
		return false;
	}
	else if(window.document.form1.disease_detail.value.length == 0)
	{
		alert("กรุณากรอก เนื้อหา" );
		window.document.form1.disease_detail.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>


</head>

<body>
<form action="edit_disease_action.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return chk_submit()">
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
       
       
        <?php
		/*
		$query_family="SELECT * FROM family ORDER BY family_id ASC";
		$result_family= mysql_query($query_family,$Connect)or die(mysql_error());
		while($row_family=mysql_fetch_array($result_family)){
		*/	
			?>
        <!--div align="left"-->
          <!--input type="checkbox" name="checkbox[]" value="<?php //echo $row_family['family_id'];?>" /-->
          <?php //echo $row_family['family_name_th']."[".$row_family['family_name_eng']."]";?> <!--/div-->
        <?php //}?>
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
      <td height="25"><div align="left">
        <input name="disease_url" type="text" id="disease_url" value="<?php echo $show_row['disease_url'];?>" />
        <label></label>
        <span class="style1">*</span></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong>ที่มาของข้อมูล(เพิ่มเติม)</strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left">
        <input name="disease_url2" type="text" id="disease_url2" value="<?php echo $show_row['disease_source'];?>" />
      </div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"></div></td>
      <td height="25"><div align="center"></div></td>
      <td height="25"><div align="left"></div></td>
    </tr>
    <tr>
      <td height="25" valign="top"><div align="right"><strong>เนื้อหา</strong></div></td>
      <td height="25" valign="top"><div align="center">:</div></td>
      <td height="25" valign="top"><div align="left">
        <label>
          <textarea name="disease_detail" cols="40" rows="5" id="disease_detail"><?php echo $show_row['disease_characteristic'];?></textarea>
        </label>
        <label></label>
        <span class="style1">*</span></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"></div></td>
      <td height="25"><div align="center"></div></td>
      <td height="25"><div align="left"></div></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td height="25">&nbsp;</td>
      <td height="25"><label>
        <input type="submit" name="Submit" value="แก้ไข" />
        &nbsp;&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="ยกเลิก" />
        <input type="hidden" name="disease_id" value="<?php echo $disease_id;?>" />
        <input type="hidden" name="chk_edit" value="YES" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>