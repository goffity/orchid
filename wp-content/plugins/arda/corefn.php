<?
//*************** Convert Word for Search **************

if (!function_exists('convertword')) :
	function convertword($url,$urlkey,$encodekey){
	//echo "word:=".$url;
	$encodek=split(",",$encodekey);
		if($urlkey==1){
			if(trim($encodekey)==""){
				$word=urlencode($url);
			}else{
				$word=urlencode(iconv($encodek[0],$encodek[1],$url));
			}
		}else{
			if(trim($encodekey)==""){
				$word=$url;
			}else{
				$word=iconv($encodek[0],$encodek[1],$url);
			}	
		}
		return $word;
	}
endif;
if (!function_exists('convertdisplay')) :
	function convertdisplay($content,$encodekey){
	$encodek=split(",",$encodekey);
		if(trim($encodekey)==""){
			$word=$content;
		}else{
			$word=iconv($encodek[1],$encodek[0],$content);
		}	
		return $word;
	}
endif;

if (!function_exists('convertforquery')) :
	function convertforquery($content,$encodekey){
	$encodek=split(",",$encodekey);
		if(trim($encodekey)==""){
			$word=$content;
		}else{
			$word=iconv($encodek[0],$encodek[1],$content);
		}	
		return $word;
	}
endif;

//************* Parameter by Post ************
/*function postPage($url,$pvars,$referer,$timeout,$pages,$endpages)
$url=url for curl
$pvar=parameter for post
$timeout=Time Out
$pages=Start point
$endpages=End Point

*/
if (!function_exists('postPage')) :
	function postPage($url,$pvars,$referer,$timeout,$pages,$endpages){
	//print_r($pvars);
	//echo $url;
	if(!isset($timeout))
		$timeout=100;
		$curlx = curl_init($url);
		$post = http_build_query($pvars);
		//echo $url;
		//print_r(urldecode($post));
		if(isset($referer)){
			curl_setopt ($curl, CURLOPT_REFERER, $referer);
		}
		curl_setopt ($curlx, CURLOPT_URL, $url);
		//curl_setopt ($curlx, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($curlx, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt ($curlx, CURLOPT_HEADER, 0);
		curl_setopt ($curlx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curlx, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curlx, CURLOPT_POST, 1);
		curl_setopt ($curlx, CURLOPT_POSTFIELDS, urldecode($post));
		curl_setopt ($curlx, CURLOPT_HTTPHEADER,array("Content-type: application/x-www-form-urlencoded"));
		curl_setopt($curlx, CURLOPT_AUTOREFERER, true);
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,true); // follow redirects recursively
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,false); // follow redirects recursively
		//curl_setopt($curlx, CURLOPT_FILE, $fp);
		$contents=curl_exec($curlx);
		curl_close($curlx);
		//return iconv("tis-620","utf-8",$contents);
		return $contents;
	}
endif;

if (!function_exists('searche2t')) :
function searche2t($url,$pvars,$referer,$timeout,$pages,$endpages){
	if(!isset($timeout))
		$timeout=100;
		$curlx = curl_init($url);
		$post = $pvars;//http_build_query($pvars);
		//echo $url;
		//print_r(urldecode($post));
		if(isset($referer)){
			curl_setopt ($curl, CURLOPT_REFERER, $referer);
		}
		curl_setopt ($curlx, CURLOPT_URL, $url);
		//curl_setopt ($curlx, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($curlx, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt ($curlx, CURLOPT_HEADER, 0);
		curl_setopt ($curlx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curlx, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curlx, CURLOPT_POST, 1);
		curl_setopt ($curlx, CURLOPT_POSTFIELDS, urldecode($post));
		curl_setopt ($curlx, CURLOPT_HTTPHEADER,array("Content-type: application/x-www-form-urlencoded"));
		curl_setopt($curlx, CURLOPT_AUTOREFERER, true);
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,true); // follow redirects recursively
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,false); // follow redirects recursively
		//curl_setopt($curlx, CURLOPT_FILE, $fp);
		$contents=curl_exec($curlx);
		curl_close($curlx);
		//return iconv("tis-620","utf-8",$contents);
		return json_decode($contents);
}
endif;

if (!function_exists('searchsoundex')) :
function searchsoundex($url,$pvars,$referer,$timeout,$pages,$endpages){
	if(!isset($timeout))
		$timeout=100;
		$curlx = curl_init($url);
		$post = $pvars;//http_build_query($pvars);
		//echo $url;
		//print_r(urldecode($post));
		if(isset($referer)){
			curl_setopt ($curl, CURLOPT_REFERER, $referer);
		}
		curl_setopt ($curlx, CURLOPT_URL, $url);
		//curl_setopt ($curlx, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ($curlx, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
		curl_setopt ($curlx, CURLOPT_HEADER, 0);
		curl_setopt ($curlx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curlx, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curlx, CURLOPT_POST, 1);
		curl_setopt ($curlx, CURLOPT_POSTFIELDS, urldecode($post));
		curl_setopt ($curlx, CURLOPT_HTTPHEADER,array("Content-type: application/x-www-form-urlencoded"));
		curl_setopt($curlx, CURLOPT_AUTOREFERER, true);
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,true); // follow redirects recursively
		curl_setopt($curlx, CURLOPT_FOLLOWLOCATION,false); // follow redirects recursively
		//curl_setopt($curlx, CURLOPT_FILE, $fp);
		$contents=curl_exec($curlx);
		curl_close($curlx);
		//return iconv("tis-620","utf-8",$contents);
		return ($contents);
}
endif;

if (!function_exists('parsetodb')) :
	function parsetodb($contents,$typeorchid){
		$rec=split("<tr>",$contents);
		for($r=0;$r<count($rec);$r++){
			$data[$r]=split("<td>",$rec[$r]);
		}
		/*for($r=0;$r<count($rec)-1;$r++){
			print_r($data[$r]);
		}*/
		$run=0;	
		for($m=0;$m<count($rec);$m++){
			$img="";
			$link="";
			$desc="";
			$title="";
			$tag="";
			for($n=0;$n<count($data[$m]);$n++){
				if(trim(painttext($data[$m][$n]))!="" or parsetoimg($data[$m][$n])!=""){
					if($run!=($m+1)){
						$run=$m+1;
						//echo "<hr><br>".($m+1).":=";
					}
					if($img=="")
						$img=parsetoimg($data[$m][$n]);
					if(trim($link)=="")
						$link=parsetolink($data[$m][$n]);
					if(trim($title)==""){
						$title=painttext($data[$m][$n]);
						$titles=$data[$m][$n];
					}		
					if(trim($desc)=="" and $titles!=$data[$m][$n]){
						$desc=painttext($data[$m][$n]);
					}	
					if(trim($tag)=="")
						$tag=parsetotag($data[$m][$n]);
				}
			}
			if(strlen($title)>strlen($desc) and trim($desc)!=""){
				$titletmp=$desc;
				$desctmp=$title;
				$title=$titletmp;
				$desc=$desctmp;
			}
			//echo "<br>Title:=".$title." <br>Link:=".$link." <br>Desc:=".$desc." <br>Img:=".$img." <br>Tag:=".$tag;
			updatecurl($title,$link,$desc,$img,$tag,$typeorchid);
			updatecurl_old($title,$link,$desc,$img,$tag,$typeorchid);
		}
	}
endif;

if (!function_exists('displayresearch')) :
	function displayresearch($contents,$typeorchid){
		//echo $contents;
		$rec=split("<font color=#085C96>",$contents);
		for($r=0;$r<count($rec)-1;$r++){
			$data[$r]=split("<tr>",$rec[$r]);
		}
		for($m=1;$m<count($rec);$m++){
		//for($m=1;$m<2;$m++){
			$img="";
			$link="";
			$desc="";
			$title="";
			$tag="";
			for($n=0;$n<count($data[$m]);$n++){
				//echo "<hr>".count($data[$m])."===".$data[$m][$n];
				$alink=parsetoresearch($data[$m][$n]);
				//echo "--".count($alink)."<hr>\n\r";
				if(count($alink)==2 and $alink[0]!="" and $alink[1]!=""){
					if($title=="")
						$title=$alink[0];
					if($link=="")
						$link=$alink[1];
				}else{
					$desc.=painttext($data[$m][$n]);
				}
			}
			//echo "<br>Title:=".$title." <br>Link:=".$link." <br>Desc:=".$desc." <br>Img:=".$img." <br>Tag:=".$tag;
			updatecurl($title,$link,$desc,$img,$tag,$typeorchid);
			updatecurl_old($title,$link,$desc,$img,$tag,$typeorchid);
		}
	}
endif;

if (!function_exists('updatecurl')) :
	function updatecurl($title,$link,$desc,$img,$tag,$typeorchid){
		$title=mysql_escape_string($title);
		$link=mysql_escape_string($link);
		$desc=mysql_escape_string($desc);
		$img=mysql_escape_string($img);
		if(trim($desc)!="" or $title!=""){
			if($title!=""){
				$sqltitlechk="select count(*) from orchid.wp_posts  where post_title ='".$title."'";
				$rtitlec=mysql_query($sqltitlechk) or die(mysql_error()."<br>".$sqltitlechk);
				$rowtitlec=mysql_fetch_array($rtitlec);
				$recchk=$rowtitlec[0];
				//echo "<br>==".$recchk."==";
			}
			if($link!="" and $recchk==0){
				$sqltitlelink="select count(*) from orchid.wp_postmeta where meta_key='link' and meta_value='".$link."'";
				$rlinkc=mysql_query($sqltitlelink) or die(mysql_error()."<br>".$sqltitlelink);
				$rowlinkc=mysql_fetch_array($rlinkc);
				$recchk=$rowlinkc[0];
			}
		
			if($recchk<1){
				$sqlmax="select max(id) from orchid.wp_posts";
				$rmax=mysql_query($sqlmax) or die(mysql_error()."<br>".$sqlmax);
				$rowmax=mysql_fetch_array($rmax);
				$maxid=$rowmax[0]+1;
				$postname=str_replace(" ","-",$title);
				//$clean = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $text); 
				$postname=urlencode(str_replace("/[:||*]/","-",$title));
				$hostx= admin_url("?p=".$maxid);
				$hostx= str_replace("wp-admin/","",$termlink);
				//$hostx=bloginfo( 'siteurl' )."/?p=".$maxid;
				$sql="insert into orchid.wp_posts(id,post_author ,post_title ,post_content,post_status ,comment_status,  ping_status,post_parent,guid ,post_type,post_name )values
										(".$maxid.", 1,'".$title."','".$desc."', 'publish', 'open', 'open' ,0, '".$hostx."','post','".$postname."')";
				//echo $sql."<br>";
				mysql_query($sql)or die (mysql_error()."<br>".$sql);
				
				$sqlmetalink="insert into orchid.wp_postmeta(post_id, meta_key, meta_value)values(".$maxid.", 'link','".$link."')";
				mysql_query($sqlmetalink) or die(mysql_error()."<br>".$sqlmetalink);
				
				$sqlmetaimages="insert into orchid.wp_postmeta(post_id, meta_key, meta_value)values(".$maxid.", 'images','".$img."')";
				mysql_query($sqlmetaimages) or die(mysql_error()."<br>".$sqlmetaimages);
				
				$sqlmetatag="insert into orchid.wp_postmeta(post_id, meta_key, meta_value)values(".$maxid.", 'tag','".$tag."')";
				mysql_query($sqlmetatag) or die(mysql_error()."<br>".$sqlmetatag);				
				
				$sqlmetatype="insert into orchid.wp_postmeta(post_id, meta_key, meta_value)values(".$maxid.", 'typeorchid','".$typeorchid."')";
				mysql_query($sqlmetatype) or die(mysql_error()."<br>".$sqlmetatype);
				
			}
		}
	}
endif;

if (!function_exists('updatecurl_old')) :
	function updatecurl_old($title,$link,$desc,$img,$tag,$typeorchid){
		$title=mysql_escape_string($title);
		$link=mysql_escape_string($link);
		$desc=mysql_escape_string($desc);
		$img=mysql_escape_string($img);
		if(trim($desc)!="" or $title!=""){
			if($title!=""){
				$sqltitlechk="select count(*) from arda.contents where title='".$title."'";
				$rtitlec=mysql_query($sqltitlechk) or die(mysql_error()."<br>".$sqltitlechk);
				$rowtitlec=mysql_fetch_array($rtitlec);
				$recchk=$rowtitlec[0];
				//echo "<br>==".$recchk."==";
			}
			if($link!="" and $recchk==0){
				$sqltitlelink="select count(*) from arda.contents where link='".$link."'";
				$rlinkc=mysql_query($sqltitlelink) or die(mysql_error()."<br>".$sqltitlelink);
				$rowlinkc=mysql_fetch_array($rlinkc);
				$recchk=$rowlinkc[0];
			}
		
			if($recchk<1){
				$sql="insert into arda.contents(title, link, description, images,tag,typeorchid)values('".$title."','".$link."','".$desc."','".$img."','".$tag."','".$typeorchid."')";
				mysql_query($sql)or die (mysql_error()."<br>".$sql);
			}
		}
	}
endif;

if (!function_exists('parsetoimg')) :
	function parsetoimg($data){
		//$data="<td width=\"25\" valign=\"top\"><img src='img/bullet_arrow.gif'>";
		preg_match_all("/<img+\s+src+[\s+=||=]+['||\"]+(.*)/",$data, $out, PREG_PATTERN_ORDER);
		preg_match_all("/['||\"]/",$out[1][0], $chklimit, PREG_OFFSET_CAPTURE);
		
		$chk=$chklimit[0][0][0];
		
		$datas=substr($out[1][0],0,strpos($out[1][0],$chk));
		//$datas="1".$out[0][0]." 2".$out[1][0]." 3".$out[2][0]."-<br>";
		return $datas;
	}
endif;

if (!function_exists('parsetolink')) :
	function parsetolink($data){
		preg_match_all("/<a+[\s||\t]+href+[\s+=||=]+['||\"]+(.*)/",trim($data), $out, PREG_PATTERN_ORDER);
		//preg_match_all('/<(a.*) href=\"(.*?)\">(.*)<\/a>/',$data,$out);
		preg_match_all("/['||\"]/",$out[1][0], $chklimit, PREG_OFFSET_CAPTURE);
		$chk=$chklimit[0][0][0];
		
		$datas=substr($out[1][0],0,strpos($out[1][0],$chk));
		//$datas=substr($out[2][0],0,strpos($out[2][0],$chk));
		//$datas=$out[2][0];
		return $datas;
	}
endif;

if (!function_exists('parsetotag')) :
	function parsetotag($data){
		preg_match_all("/<strong>Tags:<\/strong>+\s+(.*)/",trim($data), $out, PREG_PATTERN_ORDER);
		preg_match_all("/<\/div>/",$out[1][0], $chklimit, PREG_OFFSET_CAPTURE);
		
		$chk=$chklimit[0][0][0];
		
		$datas=substr($out[1][0],0,strpos($out[1][0],$chk));
		return $datas;
	}
endif;

if (!function_exists('displayresearchxx')) :
	function displayresearchxx($contents){
		//echo $contents;
		$rec=split("<font color=#085C96>",$contents);
		for($r=0;$r<count($rec);$r++){
			$alink=parsetoresearch($rec[$r]);
			if(count($alink)>0){
				$title=$alink[0];
				$link=$alink[1];
			}else{
				$desc=painttext(parsetoresearch($rec[$r]));
			}
			echo "<br>Title:=".$title." <br>Link".$link." <br>Desc:=".$desc." <br>Img:=".$img." <br>Tag".$tag;
		}
	}
endif;

if (!function_exists('parsetoresearch')) :
	function parsetoresearch($data){
		//echo $data."<br>";
		preg_match_all('/<(a.*) href=\"(.*?)\">(.*)<\/a>/',$data,$out);
		$datas[0]=trim($out[3][0]);
		$datas[1]=trim($out[2][0]);
		return $datas;
	}
endif;

if (!function_exists('painttext')) :
	function painttext($data) {
		//echo $Document;
	$Rules = array ('@<script[^>]*?>.*?</script>@si', // Strip out javascript
					'@<[\/\!]*?[^<>]*?>@si',          // Strip out HTML tags
					'@([\r\n])[\s]+@',                // Strip out white space
					'@&(quot|#34);@i',                // Replace HTML entities
					'@&(amp|#38);@i',                 //   Ampersand &
					'@&(lt|#60);@i',                  //   Less Than <
					'@&(gt|#62);@i',                  //   Greater Than >
					'@&(nbsp|#160);@i',               //   Non Breaking Space
					'@&(iexcl|#161);@i',              //   Inverted Exclamation point
					'@&(cent|#162);@i',               //   Cent 
					'@&(pound|#163);@i',              //   Pound
					'@&(copy|#169);@i',               //   Copyright
					'@&(reg|#174);@i',                //   Registered
					'@&#(d+);@e');                   // Evaluate as php
	$Replace = array ('',
					  '',
					  '',
					  '"',
					  '&',
					  '<',
					  '>',
					  ' ',
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169),
					  chr(174),
					  'chr()');
	  return preg_replace($Rules, $Replace, $data);
	}
endif;

if (!function_exists('ReadFileText')) :
	function ReadFileText($path,$id){
	$colorstr="CCFF00,00CC00,CC6600,996600,0066CC,990066,000033,CC0033,FF9900,00FFFF"; 
	$colorArray=split(",",$colorstr);

		$data = file_get_contents($path);
		$sql="SELECT * FROM setvariable WHERE  id=".$id;

		$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
		$row=mysql_fetch_array($r);
		$i=0;
		$x=0;
		while ($i < mysql_num_fields($r)) {
			$meta = mysql_field_name($r, $i);
			if (!$meta) {
				echo "No information available<br />\n";
			}else{
				if(substr($meta,0,3)=="pos"){
					$x++;
					//echo"<tr><td><input type=\"hidden\" id=\"".$meta."x\"  name=\"".$meta."x\" value=\"".$row[$i]."\"></td></tr>"; 
					$highlightStartTagx="<FONT style=\"background-color: #".$colorArray[$x]."; color: #FF0033\" ;>";
					$highlightEndTagx="</FONT>";
					$strcontent=$highlightStartTagx.$row[$i-1].$highlightEndTagx;
					$data=str_replace($row[$i-1],$strcontent,$data);
					$i=$i+1;
				}
			}
		   
			$i++;
		}

		return $data;
	}
endif;
if (!function_exists('createhtml')) :
	function createhtml($content,$encodekey,$r){
	$encodek=split(",",$encodekey);
		if(trim($encodekey)==""){
			$word=$content;
		}else{
			$word=iconv($encodek[1],$encodek[0],$content);
		}
		$file=ORCHID_DIR ."/tmp/report".$r.".php";
		$fileurl=ORCHID_URL ."/tmp/report".$r.".php";
		$handle = fopen($file, "wb");
		fwrite($handle,$word); 
		fclose($handle);
		
		/*$test = '<script src="'.ORCHID_URL.'/colorbox/jquery.colorbox.js" language="JavaScript" type="text/javascript"></script>';
		$test.='<script>
				$(document).ready(function(){$("a[rel=\'example1\']").colorbox();});
		</script>';*/
		if($r==1){
			$test='<link media="screen" rel="stylesheet" href="'.ORCHID_URL.'/colorbox.css" />
					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
					<script src="'.ORCHID_URL.'/colorbox/jquery.colorbox.js"></script>';
			$test .='<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$(".example7").colorbox({width:"80%", height:"80%", iframe:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$(\'#click\').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
			</script>';
		}
		$test .="<p><a class='example7' href='".$fileurl."'>Report</a></p>";
		/*$test ="<script langquage='javascript'>
				//window.location=\"c\";
				window.open(\"http://localhost:81/wordpress/wp-content/plugins/arda/tmp/report.php\");
			</script>";*/


		echo $test;
	}
endif;
?>