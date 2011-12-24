<?php
include("Connect.php");
mysql_select_db($database_Connect,$Connect);

$chk_s=$_GET['s'];

$query="SELECT * FROM search_key WHERE key_name LIKE '".$chk_s."%' ";
$result=mysql_query($query,$Connect)or die(mysql_error());

$num_row = mysql_num_rows($result);

if ($num_row == 0) {
	//finnis
	?>
<html>
<body>
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="2">
		<tr>
			<td height="30" bgcolor="#E3E9F1"
				style="text-align: center; font-size: large;">ไม่พบข้อมูลที่ค้นหา</td>
		</tr>
	</table>
</body>
</html>
	<?php
}else{



	$row=mysql_fetch_array($result);

	$_SESSION['key_word'] = $chk_s;
	$_SESSION['key_id'] = $row['key_id'];
	//echo "<BR>Key ".$row['key_id'];
	//echo "<BR>Key ".$chk_s;

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
		//echo "<BR>".$sql."<br>";
		$query_result_search_type = mysql_query($sql,$Connect) or die(mysql_error());
		$search_type_result = mysql_fetch_array($query_result_search_type);
		//echo "XXXX: ".empty($search_type_result);

		$_SESSION['src_name'] = $search_type_result['search_name'];

		//search family id
		if($_SESSION['src_name'] == "disease"){
			$sql_search_fam = "SELECT
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

			$query_disease_id = mysql_query($sql_search_fam,$Connect) or die(mysql_error());
			$search_disease_id = mysql_fetch_array($query_disease_id);

			//query disease ref
			$sql_search_fam = "SELECT
    					`disease_id`
    					,`family_id`
					FROM
    					`disease_ref`
					WHERE 
						(`disease_id` ='".$search_disease_id['disease_id']."');";

		}else if ($_SESSION['src_name'] == "family"){
			$sql_search_fam = "SELECT
    					`family_id`
    					, `family_name_th`
    					, `family_name_eng`
    					, `Status`
    					, `Update_date`
					FROM
    					`family`
					WHERE 
						(`family_name_th` = '".$_SESSION['key_word']."')
    					OR (`family_name_eng` ='".$_SESSION['key_word']."');"; 

		}else if ($_SESSION['src_name'] == "research") {
			$sql_search_fam = "SELECT
    					`family_id`
					FROM
    					`research_content`
					WHERE 
						(`rc_title_th` ='".$_SESSION['key_word']."')
    					OR (`rc_title_eng` ='".$_SESSION['key_word']."');";

		}else if ($_SESSION['src_name'] == "orchid_varity"){
			$sql_search_fam = "SELECT
    					`family_id`
					FROM
    					`orchid_varity`
    				WHERE
    					(`orchid_name_th` = '".$_SESSION['key_word']."')
    					OR (`orchid_name_eng` = '".$_SESSION['key_word']."');";
		}

		//echo "<BR> SQL: ".$sql_search_fam;
		$query_fam_id = mysql_query($sql_search_fam,$Connect) or die(mysql_error());
		$search_fam_id = mysql_fetch_array($query_fam_id);

		//echo "<BR>fam: ".$search_fam_id['family_id'];
		$_SESSION['fam_id'] = $search_fam_id['family_id'];

		//query
		?>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>ชื่อสกุล</b>
			</span></td>
		</tr>
		<?php

		//query หาชื่อ สกุล จาก table keywordRef , orchid varity , family

		$sql_1 = "SELECT `family_id` , `family_name_th` , `family_name_eng` , `family_characteristic` FROM `family` WHERE (`family_id` = '".$_SESSION['fam_id']."');";
		//echo("<BR>SQL: ".$sql_1);


		$sql_1_result=mysql_query($sql_1,$Connect) or die(mysql_error());
		$set1_result=mysql_fetch_array($sql_1_result);

		$_SESSION['fam_id'] = $set1_result['family_id'];
		//echo "<BR>ZZZZ ".$_SESSION['fam_id'];
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
    					, `orchid_name_eng`
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
		//echo "<BR> disease";
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
		<?php $b++;
		} ?>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>งานวิจัยที่เกี่ยวข้อง</b>
			</span></td>
		</tr>
		<?php

		//query หางานวิจัยที่เกี่ยวข้อง

		//FIXME FORTEST
		//$_SESSION['fam_id'] = 1;
		//$research_ref_id = 554;


		$sql_research = "SELECT
		 `rc_content_id`
		 , `rc_creator`
		 , `rc_title_th`
		 , `rc_title_eng`
		 , `family_id`
		 FROM
		 `research_content`
		 WHERE
		 `family_id` ='".$_SESSION['fam_id']."';";			

		//echo "<BR> SQL: ".$sql_research;

		$query_research=mysql_query($sql_research,$Connect)or die(mysql_error());

		while ($query_research_result = mysql_fetch_array($query_research)) {
			//	echo "<BR> loop";
			$result_research_content[] = $query_research_result;
		}

		for ($c = 0; $c < count($result_research_content); $c++) {?>
		<tr>
			<td style="padding-left: 30px;"><li><a
					href="<?php bloginfo('url');?>/?s=<?php echo $result_research_content[$c]['rc_title_th'];?>"><?php $ind = $c+1; echo "[".$ind."]  ".$result_research_content[$c]['rc_title_th'] ;?>
				</a></li></td>
		</tr>
		<?php }?>

		<tr>
			<td height="30" bgcolor="#E3E9F1"><span style="padding-left: 20px;"><b>นักวิจัยที่เกี่ยวข้อง</b>
			</span></td>
		</tr>
		<?php

		for ($i = 0; $i < count($result_research_content); $i++) {?>
		<tr>
			<td style="padding-left: 30px; color: white;"><li><?php $ind = $i+1; echo "[".$ind."]  ".$result_research_content[$i]['rc_creator'] ;?>
			</li></td>
		</tr>
		<?php
		}

		session_unset();
}
?>



	</table>
</body>
</html>
