<?$q_rand=rand();
if(!function_exists('report_curl')){
function report_curl($typeorchid,$q_Year,$q_month,$q_currency,$q_rand){	
//***************Include Parameter **********************
include  ORCHID_DIR."/common.php";   
include  ORCHID_DIR."/corefn.php";
//include "setvariable.php";
//include"changevar.php";
//*****************************************************

$type=1;
$recpage=100;
$sqlurl="select * from setvariable where typeorchid like '".$typeorchid."%'";
//echo $sqlurl;
$rurl=mysql_query($sqlurl) or die(mysql_error()."<br>".$sqlurl);
$contentshowx="";
$r=1;
while ($rowurl=mysql_fetch_array($rurl)):
//for($i=0;$i<count($urlcurl);$i++){
//for($i=2;$i<3;$i++){

	$servernm=$rowurl["urlcurl"];

	$url=convertword($word,$rowurl["urlkey"],$rowurl["encodekey"]);
  
		$databegin="";
		$buffer="";
	//*************start show ***************
		$pages=convertforquery($rowurl["chkpage"],$rowurl["encodekey"]);
		$pageln=strlen($rowurl["chkpage"]);
	//*************end show ***************    
		$endpages=convertforquery($rowurl["chkEndpage"],$rowurl["encodekey"]);
		$endpageln=strlen( $endpages);
		
	//*************ignor show *************
		$ignorpage=$rowurl["noshow"];
		$ignorpageln=strlen( $ignorpage);
		
	//********** Check Full Link*************
		$handledirserch=split(",",$rowurl["handledirserch"]);
		$handledir=split(",",$rowurl["handledir"]);
	
	//********** Change Contents **********
		$contentserch=split(",",$rowurl["contentserch"]);
		$contentreplace=split(",",$rowurl["contentreplace"]);
	
	//********** Type Method For Curl **********
		$typecurl=$rowurl["typecurl"];
	
	
	//********** Set Parameters For Method Post*************
		$parameters=split(",",$rowurl["parameters"]);
	
	//********** Set Value Parameters For Method Post*************
		$vars=split(",",$rowurl["vars"]);

		if(trim($rowurl["parameters"])!=""){
			$pvars="";
			for($av=0;$av<count($parameters);$av++){
				$values=$$vars[$av];
				$pvars[$parameters[$av]]=$values;
			}
		}
		/*$pvars=array("detail"=>$url);
		echo"2<hr>";
		print_r($pvars);
		echo"<hr>";*/
		//echo $urlchkpage."<br>";
		/*if($i==2 or $i==4){
			if($i==2){
				$pvars=array("q_Year"=>2009,"q_month"=>5,"q_currency"=>0,"q_rand"=>rand());
			}elseif($i==4){
				$pvars=array("type"=>1,"data"=>$url,"Pagesize"=>100);
			}
			$contentshow=postPage($servernm,$pvars,$referer,$timeout,$pages,$endpages);
			if(trim($pages)!=""){
				$contentshow=substr(trim($contentshow),strpos(trim($contentshow),$pages),strpos(trim($contentshow),$endpages)-strpos(trim($contentshow),$pages)+$endpageln);
			}
			//echo"<br>contents=".$contents."<br>";
			if(!empty($handledirserch))
			$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
			
			if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
			}
			if(!empty($contentserch))
				$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
			
			$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
			echo $contentshowx;
			 //displayresearch($contentshowx);

		}elseif($i==3){
			$pvars=array("detail"=>$url);
			$contents=postPage($servernm,$pvars,$referer,$timeout,$pages,$endpages);
				$contentshow=substr(trim($contents),strpos(trim($contents),$pages),strpos(trim($contents),$endpages)-strpos(trim($contents),$pages)+$endpageln);
				
			if(!empty($handledirserch))
				$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
			
			if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
			}
			
			if(!empty($contentserch))
				$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
				
				$contentshow="<table><tr>".$contentshow."</tr></table>";
				$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
				//echo $contentshowx;
				parsetodb($contentshowx);			
		}elseif($i==5){
			$contents=file_get_contents($urlchkpage);	

			 if(substr(trim($contents),strpos(trim($contents),$pages),$pageln)==$pages){
				$contentshow=substr(trim($contents),strpos(trim($contents),$pages),strpos(trim($contents),$endpages)-strpos(trim($contents),$pages)+$endpageln);
				//$contentshow=str_replace($handledirserch,$handledir,$contentshow);
				if(!empty($handledirserch)){
					if(count($handledirserch)>1){
						$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
					}elseif(trim($handledirserch)!=""){
						$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
					}
				}	
					
				if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
				}
				
				if(!empty($contentserch)){
					$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
				}	
				$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
				$price=split("new makeCrop",$contentshowx);
				for($a=1;$a<count($price)-1;$a++){
					$strprice=trim($price[$a]);
					echo substr($strprice,1,strpos($strprice,")")-1)."<br>";
				}
				
					//echo "<table><tr><td><a href ='".$urlget."' target='_blank'>เธ”เธนเธฃเธฒเธขเธฅเธฐเน€เธญเธตเธขเธ”เน€เธเธดเนเธกเน€เธ•เธดเธก</a></td></tr><tr><td>".$contentshowx."</td></tr></table>";
			}			
		}else{
			$contents=file_get_contents($urlchkpage);	

			 if(substr(trim($contents),strpos(trim($contents),$pages),$pageln)==$pages){
				$contentshow=substr(trim($contents),strpos(trim($contents),$pages),strpos(trim($contents),$endpages)-strpos(trim($contents),$pages)+$endpageln);
				//$contentshow=str_replace($handledirserch,$handledir,$contentshow);
				if(!empty($handledirserch)){
					if(count($handledirserch)>1){
						$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
					}elseif(trim($handledirserch[0])!="" ){
						$contentshow=preg_replace($handledirserch[0],$handledir[0],$contentshow);
					}
				}	
					
				if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
				}
				
				if(!empty($contentserch)){
					$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
				}	
				$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
				$contentshowx=trim($contentshowx);
				$contentshowx=trim(substr($contentshowx,strlen("Search  </h2>"),strlen($contentshowx)));
				$contentshowx=substr($contentshowx,strlen("</td></tr>"),strlen($contentshowx));
				echo $contentshowx;
				//parsetodb($contentshowx);
			}
		}*/
		if($typecurl=="POST"){
			
			$contentshow=postPage($servernm,$pvars,$referer,$timeout,$pages,$endpages);
			if(trim($pages)!=""){
				$contentshow=substr(trim($contentshow),strpos(trim($contentshow),$pages),strpos(trim($contentshow),$endpages)-strpos(trim($contentshow),$pages)+$endpageln);
			}
			
			if(!empty($handledirserch)){	
				//echo "<hr>xxx".$handledirserch[0]."=>".$handledir[0]."xxx<hr>";
					if(count($handledirserch)>1){
						$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
					}elseif(trim($handledirserch[0])!="" ){
						$contentshow=preg_replace($handledirserch[0],$handledir[0],$contentshow);
					}
			}
			if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
			}
			if(!empty($contentserch)){				
					if(count($contentserch)>1){
						$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
					}elseif(trim($contentserch[0])!="" ){
						$contentshow=preg_replace($contentserch[0],$contentreplace[0],$contentshow);
					}
			}	

			if(substr($rowurl["typeorchid"],0,strlen("Report"))=="Report"){
				$contentshowx.=createhtml($contentshow,$rowurl["encodekey"],$r);
				//$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
				//echo $contentshowx;
			}
			//echo"<br>contents=".$contentshowx."<br>";
			//exit();
		}elseif($typecurl=="GET"){
			$contents=file_get_contents($servernm);	

			 if(substr(trim($contents),strpos(trim($contents),$pages),$pageln)==$pages){
				$contentshow=substr(trim($contents),strpos(trim($contents),$pages),strpos(trim($contents),$endpages)-strpos(trim($contents),$pages)+$endpageln);
				//$contentshow=str_replace($handledirserch,$handledir,$contentshow);
				if(!empty($handledirserch)){
					if(count($handledirserch)>1){
						$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
					}elseif(trim($handledirserch[0])!="" ){
						$contentshow=preg_replace($handledirserch[0],$handledir[0],$contentshow);
					}
				}	
					
				if(trim($ignorpage)!=""){
					$contentshow=str_replace($ignorpage,"",$contentshow);
				}
				
				if(!empty($contentserch)){				
					if(count($contentserch)>1){
						$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);
					}elseif(trim($contentserch[0])!="" ){
						$contentshow=preg_replace($contentserch[0],$contentreplace[0],$contentshow);
					}
				}		
				$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
				$contentshowx=trim($contentshowx);
				$contentshowx=trim(substr($contentshowx,strlen("Search  </h2>"),strlen($contentshowx)));
				$contentshowx=substr($contentshowx,strlen("</td></tr>"),strlen($contentshowx));
				
				if($rowurl["typeorchid"]=="Price"){
					$price=split("new makeCrop",$contentshowx);
					echo"<table>";
					echo "<tr><td colspan='2' align='right'>ราคาวันนี้ ณ ตลาดกลางสี่มุมเมือง</td></tr>";
					echo "<tr><td>พันธุ์กล้วยไม้</td><td>ราคา</td></tr>";
					for($a=1;$a<count($price)-1;$a++){
						$strprice=trim($price[$a]);
						
						echo "<tr>";
						$prct=split(",",substr($strprice,1,strpos($strprice,")")-1));
						for($p=0;$p<count($prct);$p++){
							if($p!=1)
								echo "<td>".str_replace("'","",$prct[$p])."</td>";
						}
						//$pricestr.= str_replace(",","</td><td>",str_replace("'","",substr($strprice,1,strpos($strprice,")")-1)));
						echo "</tr>";
					}
					echo"</table>";
					//$contentshowx.=$pricestr;
					
				}
			}
		}
$r++;
//}
endwhile;
//return $contentshowx;
}
}
?>