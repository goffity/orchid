<?
//*************เปลี่ยนตัวแปร ***************
if($_GET['qterm']!=""){
	//***********Query1 ******************
	$strchkF="&query1=";
	$lenchkF=strlen($strchkF);
	$strchkE="&term";
	$lenchkE=strlen($strchkE);
	$posF=strpos($url,$strchkF);
	$posE=strpos($url,$strchkE);
	$posFF=$posF+$lenchkF;
	//echo "Pos ".$posFF."To".$posE;
	$supchk=substr($url,$posFF,$posE-$posFF);
	//echo "3xxx:=".strlen($supchk)."-";
	if(strlen($supchk)==0){
		if($_GET['qterm']!="")
			$url=str_replace("&query1=&","&query1=".$_GET['qterm']."&",$url);
		else
			$url=str_replace("&query1=&","&query1=".$_GET['query1']."&",$url);
	}else{
		if($_GET['qterm']!="")
			$url=str_replace("&query1=".$supchk."&","&query1=".$_GET['qterm']."&",$url);
		else
			$url=str_replace("&query1=".$supchk."&","&query1=".$_GET['query1']."&",$url);
	}
}

//***********Query1 ******************
$strchkF="&Query1=";
$lenchkF=strlen($strchkF);
$strchkE="&fulltext";
$lenchkE=strlen($strchkE);
$posF=strpos($url,$strchkF);
$posE=strpos($url,$strchkE);
$posFF=$posF+$lenchkF;
$supchk=substr($url,$posFF,$posE-$posFF);

if(strlen($supchk)==0){
	if($_GET['qterm']!="")
		$url=str_replace("&Query1=&","&Query1=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&Query1=&","&Query1=".$_GET['query1']."&",$url);
}else{
	if($_GET['qterm']!="")
		$url=str_replace("&Query1=".$supchk."&","&Query1=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&Query1=".$supchk."&","&Query1=".$_GET['query1']."&",$url);
}
//*********** FullText ******************	
$strchkF="&fulltext=";
$lenchkF=strlen($strchkF);
$strchkE="&SearchString";
$lenchkE=strlen($strchkE);
$posF=strpos($url,$strchkF);
$posE=strpos($url,$strchkE);
$posFF=$posF+$lenchkF;
$supchk=substr($url,$posFF,$posE-$posFF);

if(strlen($supchk)==0){
	if($_GET['qterm']!="")
		$url=str_replace("&fulltext=&","&fulltext=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&fulltext=&","&fulltext=".$_GET['query1']."&",$url);
}else{
	if($_GET['qterm']!="")
		$url=str_replace("&fulltext=".$supchk."&","&fulltext=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&fulltext=".$supchk."&","&fulltext=".$_GET['query1']."&",$url);
}
//*********** term ******************	
$strchkF="&term=";
$lenchkF=strlen($strchkF);
$strchkE="&Query1";
$lenchkE=strlen($strchkE);
$posF=strpos($url,$strchkF);
$posE=strpos($url,$strchkE);
$posFF=$posF+$lenchkF;
$supchk=substr($url,$posFF,$posE-$posFF);
if(strlen($supchk)==0){
	if($_GET['qterm']!="")
		$url=str_replace("&term=&","&term=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&term=&","&term=".$_GET['query1']."&",$url);
}else{
	if($_GET['qterm']!="")
		$url=str_replace("&term=".$supchk."&","&term=".$_GET['qterm']."&",$url);
	else
		$url=str_replace("&term=".$supchk."&","&term=".$_GET['query1']."&",$url);
}

//*********** SearchString ******************	
$strchkF="&SearchString=";
$lenchkF=strlen($strchkF);
$strchkE="&Query1";
$lenchkE=strlen($strchkE);
$posF=strpos($url,$strchkF);
$posE=strpos($url,$strchkE);
$posFF=$posF+$lenchkF;
$supchk=substr($url,$posFF,strlen($url)-$posFF);
if(strlen($supchk)==0){
	$url=str_replace("&SearchString=","&SearchString=".$_GET['query1'],$url);
}else{
	//echo "&SearchString=".$supchk.",&SearchString=".$_GET['query1'];
	$url=str_replace("&SearchString=".$supchk,"&SearchString=".$_GET['query1'],$url);
}
//*************จบเปลี่ยนตัวแปร ***************
?>