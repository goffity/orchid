<?
include"common.php";
		$id=$_POST["id"];
		$dname=$_POST["dname"];
		$pathogen=$_POST["pathogen"];
		$scientificName=$_POST["scientificName"];
		$pathogendesc=$_POST["pathogendesc"];
		$symtom=$_POST["symtom"];
		$spread=$_POST["spread"];
		$prevent=$_POST["prevent"];
	if($id==""){
		$sql="insert into disease(dname,pathogen,scientificName,pathogendesc,symtom,spread,prevent)values('".trim($dname)."','".trim($pathogen)."','".trim($scientificName)."','".trim($pathogendesc)."','".trim($symtom)."','".trim($spread)."','".trim($prevent)."')";		
	}else{
		$sql="update disease set dname='".trim($dname)."',pathogen='".trim($pathogen)."',scientificName='".trim($scientificName)."',pathogendesc='".trim($pathogendesc)."',symtom='".trim($symtom)."',spread='".trim($spread)."',prevent='".trim($prevent)."' where id=".$id;
	}
	//echo "<br>".$sql;
	mysql_query($sql) or die(mysql_error()."<br>".$sql);
	#header("Location:index.php");
	$hostredirect="index.php?id=".$id;
?>
	<script langquage='javascript'>
		window.location="<?=$hostredirect?>";
	</script>