<?
//***************Include Parameter **********************
//require_once( ORCHID_DIR . '/common.php'); 	
//require_once( ORCHID_DIR . '/corefn.php'); 	
/*include "../common.php";   
include"../corefn.php";
include "../setvariable.php";
include"../changevar.php";*/
//*****************************************************
if(!function_exists('knowledge_orchid_search')){
function knowledge_orchid_search($typeorchid,$typesearch){
$where="";

$pos = strpos($typeorchid,"-");
//echo "<br>xx".$pos."=".$typeorchid."<br>";

if($pos==0){
	$atypeorchid=split("::",$typeorchid);
}else{
	$atypeorchid_tmp=split("-",$typeorchid);
	$sqlcat = "SELECT description  FROM orchid.wp_term_taxonomy wptt where wptt.term_taxonomy_id=".$atypeorchid_tmp[1];
	$rcat=mysql_query($sqlcat) or die(mysql_error()."<br>".$sqlcat);
	$rowcat=mysql_fetch_array($rcat);
	$atypeorchid=split("::",$rowcat[0]);
}
if($typesearch==1){
	for($a=0;$a<count($atypeorchid);$a++){
		if($where==""){
			$where.=" and  (binary(title) like '%".$atypeorchid[$a]."%'  or binary(description) like '%".$atypeorchid[$a]."%' or binary(tag) like '%".$atypeorchid[$a]."%'" ;
		}else{
			$where.=" or binary(title) like '%".$atypeorchid[$a]."%'  or binary(description) like '%".$atypeorchid[$a]."%' or binary(tag) like '%".$atypeorchid[$a]."%'" ;
		}
		if($a==count($atypeorchid)-1){
			$where.=")";
		}
	}
}elseif($typesearch==2){
	$where.=" and typeorchid='".$atypeorchid[0]."'";
}elseif($typesearch==3){
	$where.=" and typeorchid='".$atypeorchid[0]."' limit 0,5";
}

$sqlshow="select * from arda.contents where id<>'' ".$where ;
//echo "<br>sql=".$sqlshow;
$r=mysql_query($sqlshow) or die(mysql_error()."<br>".$sqlshow);
$kmcontent="<table border=1>";
	while($row=mysql_fetch_array($r)):
			if($row["images"]!=""){
				$images="<img src=\"".$row["images"]."\">";
			}else{
				if($row["typeorchid"]!="Research")
					$images="&nbsp;";
				else
					$images="<img src=\"http://www.doae.go.th/img/bullet_arrow.gif\">";
			}
			if($row["title"]!=""){
				$title="<a href=\"".$row["link"]."\">".$row["title"]."</a>";
			}else{
				$title="&nbsp;";
			}
			if($row["description"]!=""){
				$description=$row["description"];
			}else{
				$description="&nbsp;";
			}
			if($description!=""){
				//$content="<table><tr><td>".$title."</td></tr><tr><td>".$description."</td></tr></table>";
				$content="<tr><td>".$title."</td></tr><tr><td>".$description."</td></tr>";
			}else{
				//$content="<table><tr><td>".$title."</td></tr></table>";
				$content="<tr><td>".$title."</td></tr>";
			}
			//$kmcontent.="<tr rowspan=2><td >".$images."</td><td valign=\"top\">".$content."</td></tr>";
			$kmcontent.="<tr ><td rowspan='3' valign='top'>".$images."</td></tr>".$content;
	endwhile;
$kmcontent.="</table>";
return $kmcontent;
}
}
?>