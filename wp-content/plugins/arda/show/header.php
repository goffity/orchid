
<?
$helparda= 'ฟังก์ชันสำหรับการกำหนดขอบเขตการการสกัดข้อมูลจากเว็บไซต์<br>';
				$sqllisturl="select urlcurl,id from arda.setvariable order by id";
				$rlisturl=mysql_query($sqllisturl)or die(mysq_error()."<br>".$sqllisturl);
				$helparda.="<ul>";
				while($rowlisturl=mysql_fetch_array($rlisturl)):
					$hostlist=split("/",$rowlisturl[0]);
					$linklist=admin_url("admin.php?page=sub-page&id".$rowlisturl[1]);
					$helparda.= "<li><a href='".$linklist."'>".$rowlisturl[0]."</li>";
				endwhile;
				$helparda.="</ul>";
?>