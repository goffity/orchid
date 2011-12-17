<div id="sidebar" style="width:350px;">
	<ul>

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
			<li><h2>�к� Ontology ��������</h2>
				<ul>
				<?php getOntology_orchid(  ); ?>
				</ul>
			</li>		
			<li><h2>Rss orchid :</h2>
				
				<?php
				if($_GET["s"]!=""){
					echo "<br>��dӤ� : ".$_GET["s"]."<br>";
					 
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%".$_GET["s"]."%'";
					//$urlf="http://it.doa.go.th/refs/rss.php";
				}else{				
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B9%84%E0%B8%A1%E0%B9%89%'";
				}
				RSSImport(10, $urlf); ?>
				
			</li>
			
	<?php endif; // end primary widget area ?>	
	</ul>

<?php
	include("Connect.php");
	mysql_select_db($database_Connect,$Connect);
	
	$chk_s=$_GET['s'];
	
	$query="SELECT * FROM key_refference  WHERE Key_Desc LIKE '".$chk_s."%' ";
	$result=mysql_query($query,$Connect)or die(mysql_error());
	//$result2=mysql_query($query,$Connect)or die(mysql_error());
	
	
	$row=mysql_fetch_array($result);
	
	
?>
<li>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td height="30" bgcolor="#E3E9F1" style="padding-left:20px;">���Ѿ�������</td>
  </tr>
  <tr>
    <td><a href="<?php bloginfo('url');?>/?s=<?php echo $chk_s;?>"><?php echo $chk_s;?></a></td>
  </tr>
<?php 
	//��Ǩ�ͺ���Ѿ������ŷ������㹡�������ǡѹ
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
   <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;">����ʡ��</span></td>
</tr>
<?php 

//query �Ҫ��� ʡ�� �ҡ table keywordRef , orchid varity , family
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
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;">�ѹ���������Ǣ�ͧ</span></td>
  </tr>
<?php
//query �� �ѹ���������Ǣ�ͧ 
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
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;">�ä�������Ǣ�ͧ</span></td>
  </tr>
<?php 
//query ���ä�������Ǣ�ͧ �ҡ table disease , diseaseRef ��� Family
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
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;">�ҹ�Ԩ�·������Ǣ�ͧ</span></td>
  </tr>
<?php 

//query �ҧҹ�Ԩ�·������Ǣ�ͧ
$query_Rm=" SELECT research.Title_THAI AS Rm, research.Creator AS Rm_Creator
			FROM research
			LEFT JOIN research_refference
			ON(research.ResearchID=research_refference.ResearchID)
			WHERE
			research_refference.FamilyID='".$set1_result['FamID']."'

";
$sql_4_result=mysql_query($query_Rm,$Connect)or die(mysql_error());
//query ����Ѻ loop �ͧ �ѡ�Ԩ��
$sql_5_result=mysql_query($query_Rm,$Connect)or die(mysql_error());

$c=1;
while($set4_result=mysql_fetch_array($sql_4_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set4_result['Rm'];?>"><?php echo "[".$c."]  ".$set4_result['Rm'] ;?></a></li></td>
  </tr>
<?php $c++; } ?>  

  <tr>
    <td height="30" bgcolor="#E3E9F1"><span style="padding-left:20px;">�ѡ�Ԩ�·������Ǣ�ͧ</span></td>
  </tr>
<?php
$d=1;
while($set5_result=mysql_fetch_array($sql_5_result)){?>  
  <tr>
    <td style="padding-left:30px;"><li><a href="<?php bloginfo('url');?>/?s=<?php echo $set5_result['Rm_Creator'];?>"><?php echo "[".$d."]  ".$set5_result['Rm_Creator'] ;?></a></li></td>
  </tr>
<?php $d++; } ?>  

</table>
</li>
</div>	