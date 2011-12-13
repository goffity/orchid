<?
include"common.php";
for($n=11;$n<=11;$n++){
	$fname="C:\\AppServ\\www\\doe\\orchid\\".$n.".txt";
	$handle = @fopen($fname, "r"); 
	if ($handle) { 
		$i=0;
		$dname="";
		$pathogen="";
		$scientificName="";
		$pathogendesc="";
		$symtom="";
		$spread="";
		$prevent="";
		$endp="";
	   while (!feof($handle)) { 
		$i++;
		   $lines= fgets($handle, 4096); 
		   echo $i.".".$lines."<br>";
		   if($i==1){
				//echo"โรค";
				$dname=$lines;
		   }elseif(substr($lines,0,strlen("เชื้อสาเหตุ"))=="เชื้อสาเหตุ"){
				//echo"เชื้อสาเหตุ";
				$pathogen=substr($lines,strlen("เชื้อสาเหตุ"),strlen($lines));
		   }elseif(substr($lines,0,strlen("ชื่อวิทยาศาสตร์"))=="ชื่อวิทยาศาสตร์"){
				//echo"ชื่อวิทยาศาสตร์";
				$scientificName=substr($lines,strlen("ชื่อวิทยาศาสตร์"),strlen($lines));
		   }elseif(substr($lines,0,strlen("ชีววิทยาของเชื้อสาเหตุ"))=="ชีววิทยาของเชื้อสาเหตุ"){
				//echo"ชีววิทยาของเชื้อสาเหตุ";
				$pathogendesc=substr($lines,strlen("ชีววิทยาของเชื้อสาเหตุ"),strlen($lines));
		   }elseif(substr($lines,0,strlen("ลักษณะอาการและความเสียหาย"))=="ลักษณะอาการและความเสียหาย"){
				//echo"ลักษณะอาการและความเสียหาย";
				$symtom=substr($lines,strlen("ลักษณะอาการและความเสียหาย"),strlen($lines));
		   }elseif(substr($lines,0,strlen("การแพร่ระบาด"))=="การแพร่ระบาด"){
				//echo"การแพร่ระบาด";
				$spread=substr($lines,strlen("การแพร่ระบาด"),strlen($lines));
		   }elseif(substr($lines,0,strlen("การป้องกันกำจัด"))=="การป้องกันกำจัด" or $lines=="การป้องกันกำจัด"){
				$endp="x";
				echo"การป้องกันกำจัด1 ".$endp."<br>";
				$prevent=substr($lines,strlen("การป้องกันกำจัด"),strlen($lines));
		   }else{
				echo"<br>Another check<br>";
				if($prevent=="" and $spread!=""){
					echo"<br>Another check2<br>";
					$spread.=$lines;
				}elseif($spread=="" and $symtom!=""){
					echo"<br>Another check3<br>";
					$symtom.=$lines;
				}elseif($symtom=="" and $pathogendesc!=""){
					echo"<br>Another check4<br>";
					$pathogendesc.=$lines;
				}elseif($pathogendesc=="" and $scientificName!=""){
					echo"<br>Another check5<br>";
					$scientificName.=$lines;
				}elseif($scientificName=="" and $pathogen!=""){
					//echo"<br>Another check6<br>";
					$pathogen.=$lines;
				}elseif($endp!=""){
					//echo"<br>Another check7<br>";
					//echo"การป้องกันกำจัด2";
					$endp="x";
					$prevent.=$lines;
					echo "<hr>".$prevent."<hr>";
				}
		   }
	   }
		//echo $n."<br>";
		$sql="insert into disease(dname,pathogen,scientificName,pathogendesc,symtom,spread,prevent)values('".trim($dname)."','".trim($pathogen)."','".trim($scientificName)."','".trim($pathogendesc)."','".trim($symtom)."','".trim($spread)."','".trim($prevent)."')";
		//echo "<br>".$sql;
		mysql_query($sql) or die(mysql_error()."<br>".$sql);
	   fclose($handle); 
	}
} 
?> 
