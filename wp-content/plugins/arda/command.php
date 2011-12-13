<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-">
</head>
<body>
<?php
   // require "config.php";

    main();

    function _notEmpty($text) {
        return $text != "";
    }
  	
	function createfile($text){
		
		//echo $text;
		$word_cut = "&#8230;";
		$word_cut2 = "<br />";
		$replace = ".";
		$replace2 = " ";
		for ($i=0 ; $i<sizeof($word_cut) ; $i++) {
 		$word2 = eregi_replace($word_cut,$replace,$text);
 		$word = eregi_replace($word_cut2,$replace2,$text);
		}

		//$strFileName = "C:\AppServ\www\coppae\\realtext\\thaicreate.txt";
		$strFileName = tempnam("/tmp", "cotex_");
		///home/wanchat/public_html/querysetgen/cotex
		$objFopen = fopen("$strFileName", 'w');

		fwrite($objFopen, $word);
 
		if($objFopen)
		{
    			echo "File writed.";
		}else{
    			echo "File can not write";
		}
 
		fclose($objFopen);
		return $strFileName;
		
	}
	function HTML2TEXT($Document) {
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
                  '1',
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
  return preg_replace($Rules, $Replace, $Document);
}

	function html2text_org($inputfilename){
		//echo "555";
		$outputTextFilename = tempnam("/tmp", "text_");
		///home/wanchat/public_html/querysetgen/text
		$cmd = "html2text < $inputfilename > $outputTextFilename.txt";
		echo $cmd;
		shell_exec($cmd);
		//return $outputTextFilename;
		
	}

	function html2text2($outputTextPath, $inputfilename){
		$cmd = "LANG=th_TH.TIS-620 java -jar ".HTMLPARSER_PATH." $inputfilename > $outputTextPath";
		//$cmd = "html4text < $inputfilename > $outputTextPath";
		shell_exec($cmd);

		$tmp_file= tempnam("/tmp/kobpae","tmp_");
		if (isUTF8Encoding($outputTextPath)) {
			if (copy($outputTextPath, $tmp_file)) {
				$cmd = "python ".CLEANER_PATH."/cleaner.py UTF8 $tmp_file | iconv -c -f utf-8 -t tis-620 > $outputTextPath";
				shell_exec($cmd);
			}
		} else {
			if (copy($outputTextPath, $tmp_file)) {
				$cmd = "python ".CLEANER_PATH."/cleaner.py CP874 $tmp_file | iconv -c -f utf-8 -t tis-620 > $outputTextPath";
				#$cmd = "python ".CLEANER_PATH."/cleaner.py CP874 $tmp_file > /tmp/vee_foo && cat /tmp/vee_foo | iconv -c -f utf-8 -t tis-620 > $outputTextPath";
				shell_exec($cmd);
			}
		}
	}

	


	function commandscore($inputfilename){
		$outputTextFilename = tempnam("/tmp", "qsetgen_");
		//home/wanchat/public_html/querysetgen/qset
        	$env = "IRSTLM=" . IRSTLM_PATH;
		//echo "555";
  	       $cmd = $env . " cat $inputfilename | iconv -c -f UTF-8 -t TIS-620 | swath -b ' ' " .  //> $outputTextFilename"; //. 
               //"/usr/local/bin/libthai_segment | iconv -f TIS-620 -t UTF-8 | ./scorer 10 " . 
		" | iconv -c -f TIS-620 -t UTF-8 | ./scorer 10 " . 
               " > $outputTextFilename";
	    
		echo $cmd;
	    	shell_exec($cmd);
        	$raw = file($outputTextFilename);
        	//print_r( $raw);
        	//unlink($outputTextFilename);
		return $raw;
	}

	function toArray($file){
		echo"<br>check filename".$file."<br>";
		//print_r($file);
		for($i = 0; $i < count($file); $i++) {
			$tmpArr[] = preg_split('/\t/', $file[$i]);
			$newArr[$tmpArr[$i][0]] = $tmpArr[$i][1];
		}
		//print_r($newArr);
		return($newArr); 
	}

	function sortprob ($array) {
		$val=$array;
		$results = boss_search($val);
		foreach($results as $result):
			$url = $result->url."</br>";
			$sum.=$url;
		endforeach; 
	return $sum;
	}
	/*function sortprob ($array) {
		print_r($array);
		ksort($array);
		//echo count($fruits);
		$num=1;
		foreach ($array as $key => $val) {
			if(count($array)<11){
				if($num<=10){
					echo $val."<br/>";
					if(isset($val) && $val != ""):
					print "!!! $query <br/>";
					$results = boss_search($val);
					foreach($results as $result):
						//$url= $result->url."</br>";
						$url = $result->url."</br>";
						echo $url;
						$sum.=$url;
					endforeach; 
					endif;
				}
			} else if (count($array)>10) {
			//if($num<=ceil (count($array)*0.1)){
			if($num<=10){
			//echo $key."  ".$val."<br>";
			echo $val."<br/>";
			if(isset($val) && $val != ""):
			print "!!! $query <br/>";
			$results = boss_search($val);
			foreach($results as $result):
				//$url= $result->url."<br>"; 
				$url = $result->url."</br>";
				echo $url;
				$sum.=$url;
				endforeach; 
			endif;
			}
		}else if (count($array)>1000) {
			//if($num<=ceil (count($array)*0.06)){
			if($num<=10){
			//echo $key."  ".$val."<br>";
			echo $val."<br/>";
			if(isset($val) && $val != ""):
			print "!!! $query <br/>";
			$results = boss_search($val);
			foreach($results as $result):
				//$url= $result->url."<br>"; 
				$url = $result->url."</br>";
				echo $url;
				$sum.=$url;
				endforeach; 
			endif;
			}
		}

		$num++;
		}
		return $sum;
	}*/

	function boss_search($query) {
		echo "<br>Query:=".$query."<br>";
		$site="+site:www.doa.go.thsite:www.doae.go.thsite:www.depthai.go.thsite:www.trf.or.thsite:www.nrct.go.thsite:www.orchidcenter.orgsite:www.taladsimummuang.com";
		$searchQuery = rawurlencode(stripslashes($query));
		$site = "+site:www.mborchid.com";
		//$site = "";
    		$addId = "B1c1fQPV34E.YN9ooUj88FqtaUo3IaZHdtZB9681MI.lIwapa8afT6edp.MqKvU_EA--";
    		$results = new SimpleXMLElement('http://boss.yahooapis.com/ysearch/web/v1/' . 
        	$searchQuery . $site . '?appid=' . 
        	$addId . '&count=10&format=xml', NULL, TRUE);
        	//$addId . '&format=xml', NULL, TRUE);
			
    		return  $results->resultset_web->result;
	}


	function curl($url){
		//echo "555";
		//print_r($url);
		$urls = split("</br>",$url);
		//print_r($urls);
		$filter=array_filter($urls);
		//print_r($filter);
		$tmptext = array_unique($filter);
		$text=array_filter($tmptext);
			//echo count($tmptext)."66666666";
		
		foreach($text as $strItem){
   		 	
			$sum[] = $strItem;
		
		}
		//print_r($sum);


		
		//echo count($text)."555";
		//print_r($text);
		
		$mh = curl_multi_init();
		$handles = array();
  
		for($i=0;$i<count($text);$i++){
		// create a new single curl handle
		$ch = curl_init();
    		//echo $text[$i]."<br>";
		// setting several options like url, timeout, returntransfer
		// simulate multithreading by calling the wait.php script and sleeping for $rand seconds
		curl_setopt($ch, CURLOPT_URL, "$text[$i]?seconds=".($i+1));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		// add this handle to the multi handle
		curl_multi_add_handle($mh,$ch);
		
		// put the handles in an array to loop this later on
		$handles[] = $ch;
		}
	  
		// execute the multi handle
		$running=null;
		do {
		curl_multi_exec($mh,$running);
		// added a usleep for 0.25 seconds to reduce load
		usleep (250000);
		} while ($running > 0);
	  
		// get the content of the urls (if there is any)
		for($i=0;$i<count($handles);$i++){
		$str_rand = rand();
		$tmp_dir  = "/tmp/".$str_rand;
		mkdir($tmp_dir);
		// get the content of the urls (if there is any)
		for($i=0;$i<count($handles);$i++)
		{
			$outputTextPath = tempnam($tmp_dir, "text_");
			$mapUrl[$outputTextPath] = $text[$i];
			echo "------------------------------------------------------------>>>".$text[$i]."<br>";

			// get the content of the handle
			$output = curl_multi_getcontent($handles[$i]);
			$tmpfname = tempnam("/tmp", "url_");
			$objFopen = fopen($tmpfname, 'w');
	        fwrite($objFopen, $output);
	        fclose($objFopen);

			$content[$i]=HTML2TEXT($output);//html2text($outputTextPath,$tmpfname);
			//echo $output;//html2text($outputTextPath,$tmpfname);

		
		// remove the handle from the multi handle
		curl_multi_remove_handle($mh,$handles[$i]);
		}
  
		// echo the output to the screen
		//echo $output."555";
	
		// close the multi curl handle to free system resources
		curl_multi_close($mh);
		}
		return $content;
   }
    function main() { 
			$data = "กล้วยไม้ แคทลียา";//$_POST["data"];
			$data = "แคทลียา";//$_POST["data"];
			//$data = "orchid";//$_POST["data"];
			/*for($i=0;$i<count($data);$i++){
            $text = $data[$i];
            
			}
			
        	$filename=createfile($text);
        	
			//$sc = commandscore($filename);

          	//$scoreArr = toArray($sc);
          	$scoreArr = toArray($filename);
         	echo "<br>toArray<br>";
			print_r($scoreArr);
        	$query = sortprob($scoreArr);*/
        	//print_r($query);
			$query = sortprob($data);
        	$url = curl($query); 
			print_r($url);
			
    }
?>
</body>
</html>
