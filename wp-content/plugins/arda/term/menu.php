<script src="<? echo ORCHID_URL.'/term/TreeMenu.js'?>"> language="JavaScript" type="text/javascript"></script>
	<script type="text/javascript" src="<? echo ORCHID_URL.'/term/js/ajax.js'?>"></script>
	<script type="text/javascript" src="<? echo ORCHID_URL.'/term/js/ajax-dynamic-list.js'?>">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, April 2006
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	</script>
<style>
.link{
  font-family:tahoma;
  font-size:11px;
  font-weight:bold;

  color:white;
  text-decoration:none;
}
.treeMenuDefault {
    font-style: italic;
}
        
.treeMenuBold {
    font-style: italic;
    font-weight: bold;
}
#mainContainer{
	width:175px;
	margin:0 auto;
	text-align:left;
	height:100%;
	background-color:#FFF;
	/*border-left:3px double #000;
	border-right:3px double #000;*/
}
#formContent{
	padding:5px;
}
/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #317082;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-size:1.0em;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:1.0em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#317082;
		color:#FFF;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
</style>

<?php

// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2005, Richard Heyes, Harald Radi                   |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.| 
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <http://www.phpguru.org/>                       |
// |         Harald Radi <harald.radi@nme.at>                              |
// +-----------------------------------------------------------------------+
//
// $Id: example.php,v 1.14 2005/03/02 02:16:51 richard Exp $
//error_reporting(E_ALL | E_STRICT);
    //require_once('HTML/TreeMenu.php');
if($_GET['query1']!="")
    $qterm=$_GET['query1'];
elseif($_GET['s']!=""){
    $qterm=urldecode($_GET['s']);
    $tubsub=urldecode($_GET['s']);
}
else{
    $qterm=$_GET['s'];
	$tubsub=$_GET['s'];
}
if($_GET["tubsub_en_th"]!=""){
	$tubsub_en_th=$_GET["tubsub_en_th"];
}
if($_GET["tubsub_soundex"]!=""){
	$tubsub_soundex=$_GET["tubsub_soundex"];
}	
//echo "<hr>".$qterm."<hr>";
//	if($qterm=="")
require_once(ORCHID_DIR.'/term/TreeMenu.php');
require_once(ORCHID_DIR.'/corefn.php');
$word="";

if($tubsub!="" and $tubsub_soundex=="use_tubsub"){
	if(preg_match('/^[a-z]+$/i',$tubsub)){   // เช็คว่าต้องข้อความต้องเป็นอังกฤษหรือตัวเลขเท่านั้น 
		$url="http://vivaldi.cpe.ku.ac.th/~vee/tubsube2t.php";
	}else{ 
		$url="http://vivaldi.cpe.ku.ac.th/~vasu/thairomanize.php";
	} 

	
	$pvars="input=".$tubsub;
	$words=searche2t($url,$pvars,$referer,$timeout,$pages,$endpages);
	if(is_array($words)){
		if(count($words)>1){
		$wordth=$words[1];
		}else{
			$wordth=$words[0];
		}
	}else{
		$words=str_replace("[","",$words);
		$wordth=str_replace("]","",$words);
	}	
}elseif($tubsub_soundex=="use_soundex"){
	$url="http://vivaldi.cpe.ku.ac.th/~vasu/soundexs.php";
	//$pvars="word=".iconv("tis-620","utf-8",$tubsub);
	$pvars="word=".urlencode(trim($tubsub));
	//echo $pvars;
	$wordth=searchsoundex($url,$pvars,$referer,$timeout,$pages,$endpages);
	//echo "<br>dd".$wordth."dd<br>";
}
if($qterm!=""){
	if($tubsub_soundex=="use_soundex")
		$qterm=$wordth;
	else
		$qterm.=" ".$wordth;
}else{
	if($tubsub_soundex=="use_soundex")
		$qterm=$wordth;
	else
		$qterm=$tubsub." ".$wordth;
}

//**********************สำหรับ suggrestion box ***********
function decode_unicode_url($str)
{
  $res = '';

  $i = 0;
  $max = strlen($str) - 6;
  while ($i <= $max)
  {
    $character = $str[$i];
    if ($character == '%' && $str[$i + 1] == 'u')
    {
      $value = hexdec(substr($str, $i + 2, 4));
      $i += 6;

      if ($value < 0x0080) // 1 byte: 0xxxxxxx
        $character = chr($value);
      else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
        $character =
            chr((($value & 0x07c0) >> 6) | 0xc0)
          . chr(($value & 0x3f) | 0x80);
      else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
        $character =
            chr((($value & 0xf000) >> 12) | 0xe0)
          . chr((($value & 0x0fc0) >> 6) | 0x80)
          . chr(($value & 0x3f) | 0x80);
    }
    else
      $i++;

    $res .= $character;
  }

  return $res . substr($str, $i);
}
//************finish suggesstion box *******************


if (!function_exists('fehler')) :
function fehler() {
/* *************************** */
global $HTTP_SERVER_VARS, $db_mailto_error, $qs;

    if (mysql_errno()>0) {
            $error1=mysql_errno();
            $error2=mysql_error();
            echo "<font size=+2 color=red><b>Database Error!</b> $error1: $error2 - $qs<BR>";
            $err_msg = "WARNING: Check log file if suspected recurrent error!\n\n";
            $err_msg .= "PHPTREE\n";
            $err_msg .= "Error Occured @:\n";
            $err_msg .= date ("D M j, Y h:i:s A") . "\n\n";
            $err_msg .= "MySQL ErrNo: $error1\n";
            $err_msg .= "MySQL ErrMsg: $error2\n\n";
            $err_msg .= "Website: ".$HTTP_SERVER_VARS['HTTP_HOST']."\n";
            $err_msg .= "Query-String: ".$HTTP_SERVER_VARS['REQUEST_URI']."\n";
            $err_msg .= "Remote IP Access from: ".$HTTP_SERVER_VARS['REMOTE_ADDR']."\n";

            mail($db_mailto_error,"[mySQL] Error on ".$HTTP_SERVER_VARS['HTTP_HOST']." /phptree ",$err_msg);

            exit; break; stop;
    };

} /* end of function fehler() */
endif;


/* ---------------------------------- */
/* Change the following settings !    */
/* ---------------------------------- */
/*

// database table name we are working on ... if you don't have it setup already, doit now!
// definition of the table is shown in the documentation of the php_tree.class itself
$table = "ontology";        /* database table working on */
//$table = "php_tree";        /* database table working on */

include(ORCHID_DIR."/common.php");
if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters =decode_unicode_url($_GET['letters']);
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	if(trim($letters)!=""){
		$res = mysql_query("select term from arda.ontology where term like '%".$letters."%'") or die(mysql_error());
		while($inf = mysql_fetch_array($res)){
			echo $inf["term"]."###".$inf["term"]."|";
		}	
	}
	exit;
}

//***********Function Generate Tree for Ontology ***********************
//| 	ประกอบด้วย 2 function หลักได้ gentree สำหรับตัวที่เป็น parent ส่วน gentree2 สำหรับส่วนที่เป็น child			|


$icon         = 'folder.gif';
$expandedIcon = 'folder-expanded.gif';
    
$menu  = new HTML_TreeMenu();
if (!function_exists('gentree2')) :
function gentree2($node,$branches) {
if ($branches!="")
    $qs="SELECT * FROM    arda.ontology  WHERE     parent=".$branches." or ident=".$branches." ORDER BY ident";
else
    $qs="SELECT * FROM   arda.ontology  WHERE     parent='-1' ORDER BY ident";

        $rc=mysql_query($qs);
        $num=mysql_numrows($rc);
         
    $i=0;
    while($ar = mysql_fetch_array($rc)){
		$termlink= admin_url("?s=".str_replace("::"," ",$ar['term']));
		$termlink= str_replace("wp-admin/","",$termlink);
       if($i==0  ) { 
         //$node1   = new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?query1=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
		 $node1   = new HTML_TreeNode(array('text' => $ar['term'], 'link' => $termlink, 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => false), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
        }else{
             if ( $ar['haschild']=="1" ) {
                $node1->addItem(gentree2("node",$ar['ident']));
             }else{
                //$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?query1=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
				$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => $termlink, 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
             }
        }        
       $i++;
    }
return $node1;
}
endif;

if (!function_exists('gentree')) :
function gentree($node,$branches,$termmesh) {
if ($branches!=""){
    if($termmesh!="")
        $qs="SELECT * FROM    arda.ontology  WHERE     parent=".$branches." and term like '%".$termmesh."%' ORDER BY ident";
     else
        $qs="SELECT * FROM    arda.ontology  WHERE     parent=".$branches." ORDER BY ident";
}else{
    if($termmesh!="")
        $qs="SELECT * FROM   arda.ontology  WHERE   lower(term) like '%".strtolower($termmesh)."%'  ORDER BY ident";
    else
        $qs="SELECT * FROM   arda.ontology  WHERE     parent='-1' ORDER BY ident";
}

        $rc=mysql_query($qs);//or die(mysql_error()."<br>".$qs);
        $num=mysql_numrows($rc);//or die(mysql_error());
    $i=0;
    //$node1   = new HTML_TreeNode(array('text' => "vasuthep", 'link' => "menu.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
    $node1   = new HTML_TreeNode(array('text' => "Ontology", 'link' => ORCHID_URL."/term/menu.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), "");
    if($num>0){
		while($ar = mysql_fetch_array($rc)){
			$termlink= admin_url("?s=".str_replace("::"," ",$ar['term']));
			$termlink= str_replace("wp-admin/","",$termlink);			 
			 if ( $ar['haschild']=="1" ) {             
				$node1->addItem(gentree2("node",$ar['ident']));
			 }else{
					$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => $termlink, 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
			}
			 $i++;
		}
	}
return $node1;
}
endif;
    
    /*$menu->addItem(gentree("node","",$qterm) );
    //$menu2->addItem($node1);
   
    // Create the presentation class
   $treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => ORCHID_URL.'/term/images', 'defaultClass' => 'treeMenuDefault'));*/
?>


<script language="JavaScript" type="text/javascript">
<!--
    a = new Date();
    a = a.getTime();

function copytext(){
	//document.getElementById("s").value = document.getElementById("word").value;
}
// สำหรับฟังก์ชันการใช้งาน tubsub และ soundex
function showDivTub() { 
	if (document.getElementById) { // DOM3 = IE5, NS6 
		document.getElementById('tubsubgroup').style.display = 'block'; 
		//document.getElementById('soundexgroup').style.visibility = 'hidden'; 
	}else { 
		if (document.layers) { // Netscape 4 
			document.tubsubgroup.visibility = 'block'; 
			//document.soundexgroup.visibility = 'hidden'; 
		}else { // IE 4 
			document.all.tubsubgroup.style.display = 'block'; 
			//document.all.soundexgroup.style.visibility = 'hidden'; 
		} 
	} 
} 
function showDivSound() { 
	if (document.getElementById) { // DOM3 = IE5, NS6 
		document.getElementById('tubsubgroup').style.display = 'none'; 
		//document.getElementById('soundexgroup').style.visibility = 'visible'; 
	}else { 
		if (document.layers) { // Netscape 4 
			document.tubsubgroup.display = 'none'; 
			//document.soundexgroup.visibility = 'visible'; 
		}else { // IE 4 
			document.all.tubsubgroup.style.display = 'none'; 
			//document.all.soundexgroup.style.visibility = 'visible'; 
		} 
	} 
}
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
	}
} 
 

//-->
</script>
<div id="mainContainer">
<div id="formContent">
<table border=0 cellspacing="0" cellpadding="0">
<?
	$termact= admin_url();
	$termact =str_replace("wp-admin/","",$termact);
?>

<!--<form name="termsearch" action="<? echo ORCHID_URL."/term/menu.php"?>" method="GET">-->
<form name="termsearch" action="<? echo $termact;?>" method="GET">
<tr>
    <!--<td>key word</td>-->
    <td colspan="2">
		<?
		if(trim($qterm)!=""){?>
			<input type="text"  name="s" value="<?echo $qterm;?>" onchange="copytext();" size="24" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)">
		<?}else{?>
			<input type="text"  name="s"  onchange="copytext();" size="24" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)">
		<?}?>
	</td>

</tr>
<tr>
	<td colspan="2">
		<div class="tubsubframe">
		<table>
		<tr>
			<td >
				<input type="radio" id="tubsub_soundex" name="tubsub_soundex" value="use_tubsub" onclick="showDivTub();">คำทับศัพ์<br>
			</td>

		</tr>
		<tr>
		 <td >
		 <div id="tubsubgroup" style="display: none" class="tubsub">
		 <table>
			<tr>
				<td >
					<input type="radio" id="tubsub_en_th" name="tubsub_en_th" value="tubsub_en_th" >เชคคำทับศัพ์อัตโนมัติ<br>
				</td>

			</tr>
			<tr>
				<td>
					<input type="radio" id="tubsub_en_th" name="tubsub_en_th" value="tubsub_en" >คำทับศัพ์อังกฤษเป็นไทย<br>
				</td>

			</tr>
			<tr>
				<td >
					<input type="radio" id="tubsub_en_th" name="tubsub_en_th" value="tubsub_th" >คำทับศัพ์ไทยเป็นอังกฤษ<br>
				</td>

			</tr>
		 </table>
		 </div>
		 </td>
		</tr>
		<tr>
			<td >
				<input type="radio" id="tubsub_soundex" name="tubsub_soundex" value="use_soundex" onclick="showDivSound();">คำฟ้องเสียง<br>
			</td>

		</tr>
		</table>
		</div>
	</td>
</tr>
<tr>
    <td>
		<input type="submit" value="Search">
	</td>
    <td><input type="reset" value="cancel"></td>
</tr>
<!--<tr><td><a href='<? echo ORCHID_URL."/term/tree.php"?>' target='_blank'>เพิ่มข้อมูล</a></td></tr>-->
</form>
</table>
</div>
</div>
<br>


<script language="JavaScript" type="text/javascript">
<!--
    b = new Date();
    b = b.getTime();
   
   // document.write("Time to render tree: " + ((b - a) / 1000) + "s");
//-->
</script>
<?

	
  $menu->addItem(gentree("node","",trim($qterm)) );
  //$menu2->addItem($node1);
   
  // Create the presentation class
   $treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => ORCHID_URL.'/term/images', 'defaultClass' => 'treeMenuDefault'));
  
?>
<font size=2 color=red>
<?$treeMenu->printMenu()?><br /><br />
<?//$listBox->printMenu()?>
</font>
