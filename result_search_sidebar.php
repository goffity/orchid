<?php
	include("Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$chk_s=$_REQUEST['s'];
	
	$query="SELECT * FROM key_refference  WHERE Key_Desc LIKE '".$chk_s."%' ";
	$result=mysql_query($query,$Connect)or die(mysql_error());
	//$result2=mysql_query($query,$Connect)or die(mysql_error());
	
	
	$row=mysql_fetch_array($result);
	
	
	//check FamilyID
	$query_FID="SELECT * FROM orchid_varity WHERE FamilyID = '".$row['FamilyID']."' AND OrchidID != '".$row['OrchidID']."' ORDER BY OrchidID ASC ";
	$FIDresult=mysql_query($query_FID,$Connect)or die(mysql_error());
	
	
	//check DiseaseID
	$query_DID="SELECT DISTINCT(disease.DieseaseName_TH) AS disease_show 
						FROM orchid_varity
						LEFT JOIN disease 
						ON(orchid_varity.DiseaseID = disease.DiseaseID)
						WHERE orchid_varity.FamilyID = '".$row['FamilyID']."'";
	$DIDresult=mysql_query($query_DID,$Connect)or die(mysql_error());
	
	
	//check ResearchID
	$query_RID="SELECT DISTINCT(research.Title_THAI) AS research_show 
						FROM orchid_varity
						LEFT JOIN research 
						ON(orchid_varity.ResearchID = research.ResearchID)
						WHERE orchid_varity.FamilyID = '".$row['FamilyID']."'";
	$RIDresult=mysql_query($query_RID,$Connect)or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orchid Portal</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td height="30" bgcolor="#E3E9F1" style="padding-left:20px;"><strong>ผลลัพธ์ข้อมูล</strong></td>
  </tr>
  <tr>
    <td><a href="<?php bloginfo('url');?>/?s=<?php echo $chk_s;?>"><?php echo $chk_s;?></a></td>
  </tr>
<?php 
	//ตรวจสอบผลลัพธ์ข้อมูลที่อยู่ในกลุ่มเดียวกัน
	$query_result="SELECT * FROM key_refference WHERE Key_ID='".$row['Key_ID']."'";
	$show_result=mysql_query($query_result,$Connect) or die(mysql_error());
$z=1;
while($set0=mysql_fetch_array($show_result)){
?>  
  <tr>
	<td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set0['Key_Desc'];?>"><?php echo "[".$z."]  ".$set0['Key_Desc'] ;?></a></li></td>  
  </tr>
<?php $z++;}?>  
 
<tr>
   <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;"><strong>ชื่อสกุล</strong></span></td>
</tr>
<?php 

//query หาชื่อ สกุล จาก table keywordRef , orchid varity , family
$sql_1="SELECT family.FamilyName_TH AS FamName, family.FamilyID AS FamID
		FROM family
		LEFT JOIN orchid_varity
		ON(family.FamilyID=orchid_varity.FamilyID)
		WHERE
		orchid_varity.KeywordID='".$row['Key_ID']."'
";

$sql_1_result=mysql_query($sql_1,$Connect) or die(mysql_error());
$set1_result=mysql_fetch_array($sql_1_result);
?>
<tr>
   <td style="padding-left:30px;"><a href="<?php bloginfo('url');?>/?s=<?php echo $set1_result['FamName'] ;?>"><?php echo $set1_result['FamName'] ;?></a></td>
</tr>

  <tr>
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;"><strong>พันธุ์ที่เกี่ยวข้อง</strong></span></td>
  </tr>
<?php
//query หา พันธุ์ที่เกี่ยวข้อง 
 $query_ord="SELECT family.FamilyName_TH AS FamName
			FROM family 
			LEFT JOIN orchid_varity
			ON(family.OrchidID=orchid_varity.OrchidID)
			WHERE 
			orchid_varity.KeywordID='".$row['Key_ID']."'
			";
$sql_2_result=mysql_query($query_ord,$Connect) or die(mysql_error());


$a=1;
while($set2_result=mysql_fetch_array($sql_2_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set2_result['FamName'];?>"><?php echo "[".$a."]  ".$set2_result['FamName'] ;?></a></li></td>
  </tr>
<?php $a++; } ?>  
  <tr>
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;"><strong>โรคที่เกี่ยวข้อง</strong></span></td>
  </tr>
<?php 
//query หาโรคที่เกี่ยวข้อง จ่าก table disease , diseaseRef และ Family
$query_ds=" SELECT DieseaseName_TH
			FROM disease
			LEFT JOIN disease_relation
			ON(disease.DiseaseID=disease_relation.DiseaseID)
			WHERE
			disease_relation.FamilyID='".$set1_result['FamID']."'
";
$sql_3_result=mysql_query($query_ds,$Connect)or die(mysql_error());


$b=1;
while($set3_result=mysql_fetch_array($sql_3_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set3_result['DieseaseName_TH'];?>"><?php echo "[".$b."]  ".$set3_result['DieseaseName_TH'] ;?></a></li></td>
  </tr>
<?php $b++; } ?>  
  <tr>
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;"><strong>งานวิจัยที่เกี่ยวข้อง</strong></span></td>
  </tr>
<?php 

//query หางานวิจัยที่เกี่ยวข้อง
$query_Rm=" SELECT research.Title_THAI AS Rm, research.Creator AS Rm_Creator
			FROM research
			LEFT JOIN research_refference
			ON(research.ResearchID=research_refference.ResearchID)
			WHERE
			research_refference.FamilyID='".$set1_result['FamID']."'

";
$sql_4_result=mysql_query($query_Rm,$Connect)or die(mysql_error());
//query สำหรับ loop ของ นักวิจัย
$sql_5_result=mysql_query($query_Rm,$Connect)or die(mysql_error());

$c=1;
while($set4_result=mysql_fetch_array($sql_4_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set4_result['Rm'];?>"><?php echo "[".$c."]  ".$set4_result['Rm'] ;?></a></li></td>
  </tr>
<?php $c++; } ?>  

  <tr>
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;"><strong>นักวิจัยที่เกี่ยวข้อง</strong></span></td>
  </tr>
<?php
$d=1;
while($set5_result=mysql_fetch_array($sql_5_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set5_result['Rm_Creator'];?>"><?php echo "[".$d."]  ".$set5_result['Rm_Creator'] ;?></a></li></td>
  </tr>
<?php $d++; } ?>  

</table>
</body>
</html>
