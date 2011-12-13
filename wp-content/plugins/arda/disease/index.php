<?
include"common.php";
//********************** Header List Disease ********************
$sql="select * from disease order by id";
$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
echo "<a href=\"./index.php\" target=\"_self\">เพิ่มข้อมูล</a>|| ";
while($row=mysql_fetch_array($r)):
	echo "<a href=\"./index.php?id=".$row["id"]."\" target=\"_self\">".$row["dname"]."</a>|| ";
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
}
?>
<table>
<form name="add" action="addcmd.php" method="POST">
	<tr>
		<td>ชื่อโรค</td>
		<td>
			<input type="text" name="dname" value="<?=$dname?>" size="50">
			<input type="hidden" name="id" value="<?=$id?>">
		</td>
	</tr>
	<tr>
		<td>เชื้อสาเหตุ</td>
		<td><input type="text" name="pathogen" value="<?=$pathogen?>" size="50"></td>
	</tr>
	<tr>
		<td>ชื่อวิทยาศาสตร์</td>
		<td><input type="text" name="scientificName" value="<?=$scientificName?>" size="50"></td>
	</tr>
	<tr>
		<td>ชีววิทยาของเชื้อสาเหตุ</td>
		<td><textarea name="pathogendesc" cols="50" rows="4"><?=$pathogendesc?></textarea></td>
	</tr>
	<tr>
		<td>ลักษณะอาการและความเสียหาย</td>
		<td><textarea name="symtom" cols="50" rows="4"><?=$symtom?></textarea></td>
	</tr>
	<tr>
		<td>การแพร่ระบาด</td>
		<td><textarea name="spread" cols="50" rows="4"><?=$spread?></textarea></td>
	</tr>
	<tr>
		<td>การป้องกันกำจัด</td>
		<td><textarea name="prevent" cols="50" rows="4"><?=$prevent?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="right" ><input type="submit" value="บันทึก"><input type="reset" value="ยกเลิก"></td>
	</tr>
</form>
</table>