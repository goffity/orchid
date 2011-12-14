<?php
include("Connect.php");
mysql_select_db($database_Connect,$Connect);

$chk_s=$_GET['s'];

$query="SELECT * FROM search_key WHERE key_name LIKE '".$chk_s."%' ";
$result=mysql_query($query,$Connect)or die(mysql_error());
//$result2=mysql_query($query,$Connect)or die(mysql_error());

$row=mysql_fetch_array($result);

$_SESSION['key_word'] = $chk_s;
$_SESSION['key_id'] = $row['key_id'];
//echo $row['key_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orchid Portal</title>
</head>

<body>
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="2">
		<tr>
			<td height="30" bgcolor="#E3E9F1" style="padding-left: 20px;"><b>คำค้น<b />
			
			</td>
		</tr>
		<tr>
			<td><a href="<?php bloginfo('url');?>/?s=<?php echo $chk_s;?>"><?php echo $chk_s;?>
			</a></td>
		</tr>
		<?php
		//ตรวจสอบผลลัพธ์ข้อมูลที่อยู่ในกลุ่มเดียวกัน
		$query_result="SELECT * FROM search_key WHERE key_id='".$row['key_id']."'";
		$show_result=mysql_query($query_result,$Connect) or die(mysql_error());
		$z=1;
		while($set0=mysql_fetch_array($show_result)){
			?>
		<tr>
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $set0['key_name'];?>"><?php echo "[".$z."]  ".$set0['key_name'] ;?>
				</a></li></td>
		</tr>
		<?php

		$_SESSION['src_type_id'] = $set0['search_type_id'];

		$z++;
		}
		?>

		<?php
		//query search_type
		//echo "ID: ".$_SESSION['src_type_id'];
		$sql = "SELECT `search_type`.`search_type_id`, `search_type`.`search_name` FROM `search_type` WHERE (`search_type_id` = '".$_SESSION['src_type_id']."');";
		//echo $sql."<br>";
		$query_result_search_type = mysql_query($sql,$Connect) or die(mysql_errno());
		$search_type_result = mysql_fetch_array($query_result_search_type);
		//echo "XXXX: ".empty($search_type_result);

		$_SESSION['src_name'] = $search_type_result['search_name'];

		//search family id
		if($_SESSION['src_name'] == "disease"){
			$sql = "SELECT
						`disease_id`
    					, `disease_name_th`
    					, `disease_name_eng`
    					, `disease_characteristic`
    					, `disease_url`
    					, `disease_source`
    					, `disease_status`
    					, `disease_update_date`
					FROM
    					`disease`
    				WHERE 
    					(`disease_name_th` ='".$_SESSION['key_word']."')
    					OR 
    					(`disease_name_eng` ='".$_SESSION['key_word']."');";

			$query_disease_id = mysql_query($sql,$Connect) or die(mysql_errno());
			$search_disease_id = mysql_fetch_array($query_disease_id);

			//query disease ref
			$sql = "SELECT
    					`disease_id`
    					,`family_id`
					FROM
    					`disease_ref`
					WHERE 
						(`disease_id` ='".$search_disease_id['disease_id']."');";

			$query_fam_id = mysql_query($sql,$Connect) or die(mysql_errno());
			$search_fam_id = mysql_fetch_array($query_fam_id);

			$_SESSION['fam_id'] = $search_fam_id['family_id'];

			//TODO add dis to array

		}else {
			$sql = "SELECT `family_id` FROM ".$_SESSION['src_name']." WHERE `key_id` = '".$_SESSION['key_id']."'";
			//echo "SQL: ".$sql;
			$query_result_fam_id = mysql_query($sql,$Connect) or die(mysql_errno());
			$search_fam_id = mysql_fetch_array($query_result_fam_id);

			$_SESSION['fam_id'] = $search_fam_id['family_id'];
		}


		//query
		?>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>ชื่อสกุล</b>
			</span></td>
		</tr>
		<?php

		//query หาชื่อ สกุล จาก table keywordRef , orchid varity , family
		$sql_1="SELECT family.family_id,family.FamilyName_TH AS FamName, family.FamilyID AS FamID
		 FROM family
		 LEFT JOIN orchid_varity
		 ON(family.FamilyID=orchid_varity.FamilyID)
		 WHERE
		 orchid_varity.key_id='".$row['key_id']."'";

		$sql_1 = "SELECT `family_id` , `family_name_th` , `family_name_eng` , `family_characteristic` FROM `family` WHERE (`family_id` = '".$_SESSION['fam_id']."');";

		$sql_1_result=mysql_query($sql_1,$Connect) or die(mysql_error());
		$set1_result=mysql_fetch_array($sql_1_result);

		$_SESSION['fam_id'] = $set1_result['family_id'];
		//echo "ZZZZ ".$_SESSION['fam_id'];
		?>
		<tr>
			<td style="padding-left: 30px;"><a
				href="<?php bloginfo('url');?>/?s=<?php echo $set1_result['family_name_th'] ;?>"><?php echo $set1_result['family_name_th']." (". $set1_result['family_name_eng'].")" ;?>
			</a></td>
		</tr>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>พันธุ์ที่เกี่ยวข้อง</b>
			</span></td>
		</tr>
		<?php
		//query หา พันธุ์ที่เกี่ยวข้อง

		//echo "XXXX ".$_SESSION['fam_id'];
		$query_ord = "SELECT
    					`orchid_id`
    					, `orchid_name_th`
    					, `ochid_name_eng`
    					, `orchid_content1`
    					, `orchid_url`
    					, `orchid_status`
    					, `orchid_update_date`
    					, `family_id`
					FROM
    					`orchid_varity`
					WHERE (`family_id` ='".$_SESSION['fam_id']."');";

		$sql_2_result=mysql_query($query_ord,$Connect) or die(mysql_error());

		$a=1;
		while($set2_result=mysql_fetch_array($sql_2_result)){
			?>
		<tr>
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $set2_result['orchid_name_th'];?>">
					<?php // $url = bloginfo('url');					echo $url."/?s=".$set2_result['OrchidName_TH'];
					echo "[".$a."]  ".$set2_result['orchid_name_th'] ;?> </a></li></td>
		</tr>
		<?php $a++; } ?>
		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>โรคที่เกี่ยวข้อง</b>
			</span></td>
		</tr>
		<?php
		//query หาโรคที่เกี่ยวข้อง จ่าก table disease , diseaseRef และ Family
		/*$query_ds=" SELECT DieseaseName_TH
			FROM disease
			LEFT JOIN disease_relation
			ON(disease.DiseaseID=disease_relation.DiseaseID)
			WHERE
			disease_relation.FamilyID='".$set1_result['FamID']."'
			";*/

		$query_ds="SELECT
    				`disease_id`
    				, `disease_name_th`
    				, `disease_name_eng`
    				, `disease_characteristic`
    				, `disease_url`
    				, `disease_source`
    				, `disease_status`
    				, `disease_update_date`
				FROM
    				`disease`
    			WHERE 
    				(`disease_id` IN (
    					SELECT `disease_ref`.`disease_id` FROM `disease_ref` WHERE `disease_ref`.`family_id` = '".$_SESSION['fam_id']."'
    					)
    				);";

		$sql_3_result=mysql_query($query_ds,$Connect)or die(mysql_error());


		$b=1;
		while($set3_result=mysql_fetch_array($sql_3_result)){?>
		<tr>
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $set3_result['disease_name_th'];?>"><?php echo "[".$b."]  ".$set3_result['disease_name_th']." (".$set3_result['disease_name_eng'].")" ;?>
				</a></li></td>
		</tr>
		<?php $b++; } ?>
		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>งานวิจัยที่เกี่ยวข้อง</b>
			</span></td>
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
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $set4_result['Rm'];?>"><?php echo "[".$c."]  ".$set4_result['Rm'] ;?>
				</a></li></td>
		</tr>
		<?php $c++; } ?>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>นักวิจัยที่เกี่ยวข้อง</b>
			</span></td>
		</tr>
		<?php
		$d=1;
		while($set5_result=mysql_fetch_array($sql_5_result)){?>
		<tr>
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $set5_result['Rm_Creator'];?>"><?php echo "[".$d."]  ".$set5_result['Rm_Creator'] ;?>
				</a></li></td>
		</tr>
		<?php $d++; } ?>

	</table>
</body>
</html>
