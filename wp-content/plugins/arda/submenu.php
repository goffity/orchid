<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); 
add_thickbox();
wp_enqueue_script( 'theme-preview' );
$page=$_GET["page"];
$helparda="";
$colorh1="blue";
$colorh2="blue";
$colorh3="blue";

			if ($page == 'mt-top-level-handle') {
				$colorh1="black";
				$helparda= 'ฟังก์ชันการสกัดข้อมูลจากแหล่งข้อมูลหลายแหล่ง <br>ปัจจุบันสามารถสกัดข้อมูลจากแหลงข้อมูลต่อไปนี้<br>';
				$sqllisturl="select urlcurl from arda.setvariable order by id";
				$rlisturl=mysql_query($sqllisturl)or die(mysq_error()."<br>".$sqllisturl);
				$helparda.="<ul>";
				while($rowlisturl=mysql_fetch_array($rlisturl)):
					$hostlist=split("/",$rowlisturl[0]);
					$helparda.= "<li>".$hostlist[2]."</li>";
				endwhile;
				$helparda.="</ul>";
			}elseif ($page == 'sub-page') {
				$colorh2="black";
				$helparda= 'ฟังก์ชันสำหรับการกำหนดขอบเขตการการสกัดข้อมูลจากเว็บไซต์<br>';
				$sqllisturl="select urlcurl,id from arda.setvariable order by id";
				$rlisturl=mysql_query($sqllisturl)or die(mysq_error()."<br>".$sqllisturl);
				$helparda.="<ul>";
				while($rowlisturl=mysql_fetch_array($rlisturl)):
					$hostlist=split("/",$rowlisturl[0]);
					$linklist=admin_url("admin.php?page=sub-page&id=".$rowlisturl[1]);
					$helparda.= "<li><a href='".$linklist."'>".$hostlist[2]."</li>";
				endwhile;
				$helparda.="</ul>";
			}elseif ($page == 'sub-page2') {
				$colorh3="black";
				$helparda= 'ทำการสกัดข้อมูล และนำเข้าขฐานข้อมูล<br>';				
			}
	?>
<table>
<tr >		
  <td><a href="<? echo admin_url('admin.php?page=mt-top-level-handle')?>"><font color="<?=$colorh1?>"><?php _e ('Orchid Option', 'arda') ?></a><?php echo $trail; ?>||</td>
  <td><a href="<? echo admin_url('admin.php?page=sub-page')?>&amp;TB_iframe=true" class="thickbox thickbox-preview screenshot"><font color="<?=$colorh2?>"><?php _e ('Manage Content For Curl', 'arda') ?></font></a><?php echo $trail; ?>||</td>
  <td><a href="<? echo admin_url('admin.php?page=sub-page2')?>"><font color="<?=$colorh3?>"><?php _e ('Curl Data to Database', 'arda') ?></font></a><?php echo $trail; ?></td>
</tr>
</table>
<table>
<tr>
	<td>&nbsp;</td>
	<td ><?=$helparda; ?></td>
</tr>
</table>
