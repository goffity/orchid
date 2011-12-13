<?

 if($id=="") $id=1;
//$id=2;
$pageselect = $_GET['currentpage'];
$totalp = $_GET['totalp'];
//include "./conf/config.inc.php";


$q_Year=2010;
$q_month=10;
$q_currency=0;
$q_rand=rand();
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
require( ORCHID_DIR . '/setvariable.php'); 	
require( ORCHID_DIR . '/changevar.php'); 	

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

if($id!="") $where="where id=".$id; 
$sqlurl="select * from setvariable ".$where." order by id";
$rurl=mysql_query($sqlurl) or die(mysql_error()."<br>".$sqlurl);
while ($rowurl=mysql_fetch_array($rurl)):
//for($i=0;$i<count($urlcurl);$i++){
//for($i=2;$i<3;$i++){

	$servernm=$rowurl["urlcurl"];
	$url=convertword($word,$rowurl["urlkey"],$rowurl["encodekey"]);

	if($rowurl["typeorchid"]=="Report"||$rowurl["typeorchid"]=="Price"){

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
		if($typecurl=="POST"){
			$contentshow=postPage($servernm,$pvars,$referer,$timeout,$pages,$endpages);
			echo $contentshow;
			exit;
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
			echo htmlspecialchars($contentshowx);
			
		}elseif($typecurl=="GET"){
			$contents=file_get_contents($urlchkpage);
			echo htmlspecialchars($contents);			
		}

//}
endwhile;
?>		
