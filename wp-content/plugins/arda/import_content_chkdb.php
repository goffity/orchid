<?

$id=$_REQUEST['id'];
 if($id=="") $id=1;
//$id=2;
$pageselect = $_GET['currentpage'];
$totalp = $_GET['totalp'];
//include "./conf/config.inc.php";
include( ORCHID_DIR .'/submenu.php');
//************check get value ******************
if($_GET) { //is there GET data?
        $newgetarr = array();
        foreach($_GET as $key => $value) {
            if(is_array($value)) {
                $newvalue = implode(',',$value); //if it's an array, convert it to comma separated
            } else {
                $newvalue = $value;
            }
            $newgetarr[] = $key.'='.$newvalue;
        }
        $newget = implode('&',$newgetarr);
    }
    foreach($_POST as $key => $value) {
        $this[$key] = $value;
    }
   $_SESSION['search']=$newget;
   
if($url=="")
	$url=$_GET["url"];
if($url=="")
    $url=$_GET["query"];//ในหน้ามันเอง
if($url=="")
    $url=$newget; 
	
//***************Include Parameter **********************
include "common.php";   
include"corefn.php";
//include "setvariable.php";
include"changevar.php";
//*****************************************************
   
$url=urlencode($url);

$tmp=$url;
$searchx=str_replace("%3D","=",$tmp);
$url=str_replace("%26","&",$searchx);
//if($id==1)
	//$url=str_replace(" ","+",$url);



//********Get Parameter *****************
$word="กล้วยไม้";
$type=1;
$recpage=100;
$sqlurl="select * from setvariable order by id";
$rurl=mysql_query($sqlurl) or die(mysql_error()."<br>".$sqlurl);
while ($rowurl=mysql_fetch_array($rurl)):
//for($i=0;$i<count($urlcurl);$i++){
//for($i=2;$i<3;$i++){

	$servernm=$rowurl["urlcurl"];

	$url=convertword($word,$rowurl["urlkey"],$rowurl["encodekey"]);
	//echo"<br>Word:=".$url."<br>";
	if(substr($rowurl["typeorchid"],0,strlen("Report"))=="Report"||$rowurl["typeorchid"]=="Price"){

		$urlchkpage=$servernm;
	}else{
		$urlchkpage=$servernm.$url;
	}
	if($p=="") $p=1; 
	   if($p==1){
			$urlget=$servernm.$url;
			
		}else{
			$urlget=$servernm.$url;
			$urlget=$urlget."&start=".($p-1)*$recpage[$i];
		}
	   
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
				
					//echo "<table><tr><td><a href ='".$urlget."' target='_blank'>ดูรายละเอียดเพิ่มเติม</a></td></tr><tr><td>".$contentshowx."</td></tr></table>";
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
			//echo"<br>contents=".$contents."<br>";
			if(!empty($handledirserch))
			$contentshow=preg_replace($handledirserch,$handledir,$contentshow);
			
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
			/*if(!empty($contentserch))
				$contentshow=preg_replace($contentserch,$contentreplace,$contentshow);*/
			
			$contentshowx=convertdisplay($contentshow,$rowurl["encodekey"]);
			//echo "<br>type:=".$rowurl["typeorchid"]."<br>";
			if($rowurl["parsedata"]=="displayresearch")
				displayresearch($contentshowx,$rowurl["typeorchid"]);
			elseif($rowurl["parsedata"]=="parsetodb")
				parsetodb($contentshowx,$rowurl["typeorchid"]);	 
		}elseif($typecurl=="GET"){
			//echo $urlchkpage;
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
				//echo "<br>type:=".$rowurl["typeorchid"]."<br>";
				if($rowurl["typeorchid"]!="Report" and ($rowurl["typeorchid"]=="Price")){
					parsetodb($contentshowx,$rowurl["typeorchid"]);	
				}
			}
		}

//}
endwhile;
echo "Update Data Complete";
?>		
