<?
include"common.php";
//********************** Header List Disease ********************
$sql="select * from disease order by id";
$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
while($row=mysql_fetch_array($r)):
	echo "<a href=\"./show.php?id=".$row["id"]."\" target=\"_self\">".$row["dname"]."</a>|| ";
endwhile;
//********************** Header List Disease ********************
if($_GET["id"]!=""){
	$id=$_GET["id"];
}else{
	$id=$_POST["id"];
}

if($id!=""){
	$sqledit="select * from disease where id=".$id;
	$redit=mysql_query($sqledit) or die(mysql_error()."<br>".$sqledit);
	$rowedit=mysql_fetch_array($redit);
		$dname=$rowedit["dname"];
		$pathogen=$rowedit["pathogen"];
		$scientificName=$rowedit["scientificName"];
		$pathogendesc=$rowedit["pathogendesc"];
		$symtom=$rowedit["symtom"];
		$spread=$rowedit["spread"];
		$prevent=$rowedit["prevent"];
		
	$sqlimg="select * from disease where id=".$id;
	$rimg=mysql_query($sqlimg) or die(mysql_error()."<br>".$sqlimg);
	$img="";
	while ($rowimg=mysql_fetch_array($rimg)):
		$img.="<img scr=\"".$rowimg["img"]."\"><br>";
	endwhile;
}
?>
<table>
<tr valign="top">
	<td><?=$img ?></td>
	<td>
		<table>
			<tr>
				<td nowrap>ชื่อโรค</td>
				<td><?=$dname?></td>
			</tr>
			<tr>
				<td nowrap>เชื้อสาเหตุ</td>
				<td><?=$pathogen?></td>
			</tr>
			<tr>
				<td nowrap>ชื่อวิทยาศาสตร์</td>
				<td><?=$scientificName?></td>
			</tr>
			<tr>
				<td nowrap>ชีววิทยาของเชื้อสาเหตุ</td>
				<td><?=$pathogendesc?></td>
			</tr>
			<tr>
				<td nowrap>ลักษณะอาการและความเสียหาย</td>
				<td><?=$symtom?></td>
			</tr>
			<tr>
				<td nowrap>การแพร่ระบาด</td>
				<td><?=$spread?></td>
			</tr>
			<tr>
				<td nowrap>การป้องกันกำจัด</td>
				<td><?=$prevent?></td>
			</tr>
		</table>
	</td>
</tr>
</table>