<?php
	include("../Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$orchidID=$_REQUEST['orchidID'];
	
	$show_query="SELECT * FROM orchid_varity WHERE orchid_id='".$orchidID."'";
	$show_result=mysql_query($show_query,$Connect)or die(mysql_error());
	$show_row=mysql_fetch_array($show_result);

	$show_result2=mysql_query($show_query,$Connect)or die(mysql_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Orchid</title>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
// Count the number of times a substring is in a string.
String.prototype.substrCount =
  function(s) {
    return this.length && s ? (this.split(s)).length - 1 : 0;
  };

// Return a new string without leading and trailing whitespace
// Double spaces whithin the string are removed as well
String.prototype.trimAll =
  function() {
    return this.replace(/^\s+|(\s+(?!\S))/mg,"");
  };

//event handler
function loadContentResult(nameTH) {
	if(nameTH.substrCount(' ') > 0)
	{
		$("#actionresult").hide();
		$("#actionresult").load("user.php?msg=whitespace", '', callbackResult);
	}
	else
	{
		$("#actionresult").hide();
		$("#actionresult").load("user.php?nameTH="+nameTH.trimAll()+"", '', callbackResult);
	}	
}

//callback
function callbackResult() {
	$("#actionresult").show();
}

//ajax spinner
$(function(){
	$("#spinner").ajaxStart(function(){
		$(this).html('<img src="image/wait.gif" />');
	});
	$("#spinner").ajaxSuccess(function(){
		$(this).html('');
 	});
	$("#spinner").ajaxError(function(url){
		alert('Error: server was not respond, communication interrupt. Please try again in a few moment.');
 	});
});

//set2
function loadContentResult2(nameEN) {
	if(nameEN.substrCount(' ') > 0)
	{
		$("#actionresult2").hide();
		$("#actionresult2").load("user.php?msg2=whitespace2", '', callbackResult2);
	}
	else
	{
		$("#actionresult2").hide();
		$("#actionresult2").load("user.php?nameEN="+nameEN.trimAll()+"", '', callbackResult2);
	}	
}

//callback
function callbackResult2() {
	$("#actionresult2").show();
}

//ajax spinner
$(function(){
	$("#sp_v2").ajaxStart(function(){
		$(this).html('<img src="images/ajax-loader.gif" />');
	});
	$("#sp_v2").ajaxSuccess(function(){
		$(this).html('');
 	});
	$("#sp_v2").ajaxError(function(url){
		alert('Error: server was not respond, communication interrupt. Please try again in a few moment.');
 	});
});


function chk_submit()
{
	if(window.document.form1.orchid_family.value.length == 0)
	{
		alert("กรุณาเลือก สกุล" );
		window.document.form1.orchid_family.focus();
		return false;
	}
	else if(window.document.form1.orchid_url.value.length == 0)
	{
		alert("กรุณากรอก เว็บไซต์ที่มา" );
		window.document.form1.orchid_url.focus();
		return false;
	}
	else if(window.document.form1.detail.value.length == 0)
	{
		alert("กรุณากรอก เนื้อหา" );
		window.document.form1.detail.focus();
		return false;
	}
	else
	{
		return true;
	}
}

</script>


<style type="text/css">
<!--
.style1 {color: #FF0000}
body {
	background-color: #FFF;
}
-->
</style>
</head>

<body>
<form action="edit_orchid_action.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return chk_submit();">
  <br />
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td width="298" height="25"><div align="right"><strong>ชื่อพันธุ์ (ภาษาไทย)</strong></div></td>
      <td width="23" height="25"><div align="center">:</div></td>
      <td width="571" height="25"><div align="left"><?php echo $show_row['orchid_name_th']; ?></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"></div></td>
      <td height="25"><div align="center"></div></td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong>ชื่อพันธุ์ (ภาษาอังกฤษ)</strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left"><?php echo $show_row['orchid_name_eng']; ?></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"></div></td>
      <td height="25"><div align="center"></div></td>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left">
          <?php 
			while($row_get = mysql_fetch_array($show_result2)){
				$keep_sql_get="SELECT key_id, key_name FROM search_key WHERE key_id='".$row_get['key_id']."' ORDER BY key_id ASC";
				$keep_result_get=mysql_query($keep_sql_get,$Connect)or die(mysql_error());
				$a=0;
				while($row_name_get=mysql_fetch_array($keep_result_get)){
					echo $row_name_get['key_name']." , ";
				}	
			}
		  ?>
          
        </div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong> สกุล </strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left">
        <?php 
			//Select Family
			$query_family = "SELECT family_id, family_name_th, family_name_eng FROM family WHERE Status='Y' ORDER BY family_id ASC";
			$result_family = mysql_query($query_family,$Connect)or die(mysql_error());
		
			//Get Family
			$query_family_get = "SELECT family_id, family_name_th, family_name_eng FROM family WHERE family_id='".$show_row['family_id']."' AND Status='Y' ORDER BY family_id ASC";
			$result_family_get = mysql_query($query_family_get,$Connect)or die(mysql_error());
		?>
        <select name="orchid_family" id="orchid_family">
          <?php while($row_family_get=mysql_fetch_array($result_family_get)){?>
          <option selected="selected" value="<?php echo $row_family_get['family_id']?>"><?php echo $row_family_get['family_name_th']."(".$row_family_get['family_name_eng'].")";?></option>
          <?php }?>
          <option>---------------</option>
          <?php while($row_family=mysql_fetch_array($result_family)){?>
          <option value="<?php echo $row_family['family_id']?>"><?php echo $row_family['family_name_th']."(".$row_family['family_name_eng'].")";?></option>
          <?php }?>
        </select>
        <span class="style1">*</span></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left">
        <input name="orchid_url" type="text" id="orchid_url" value="<?php echo $show_row['orchid_url']; ?>" />
        <span class="style1">*</span></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"></div></td>
      <td height="25"><div align="center"></div></td>
      <td height="25"><div align="left"></div></td>
    </tr>
    <tr>
      <td height="25"><div align="right"><strong>เนื้อหา</strong></div></td>
      <td height="25"><div align="center">:</div></td>
      <td height="25"><div align="left">
        <label>
          <textarea name="detail" cols="50" rows="8" id="detail"><?php echo $show_row['orchid_content1']; ?></textarea>
        </label>
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
        <input type="hidden" name="orchidID" value="<?php echo $orchidID;?>" />
        <input type="hidden" name="chk_edit" value="YES" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>