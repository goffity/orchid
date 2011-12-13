<?
require( ORCHID_DIR . '/common.php'); 	
require( ORCHID_DIR . '/corefn.php'); 	

$id=$_GET["id"];
$page=$_GET["page"];
$modechange=$_GET["modechange"];
include( ORCHID_DIR .'/submenu.php');
if($id!=""){
	$sql="select * from  setvariable where id=".$id;
	$r=mysql_query($sql)or die(mysql_error()."<br>".$sql);
	$row=mysql_fetch_array($r);
	$encodekey=split(",",$row["encodekey"]);
	$encodekey1=$encodekey[0];
	$encodekey2=$encodekey[1];
}
?>
<!--<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Manage Content For Curl</title>
<head>-->
	<!--<script language="JavaScript" src="../js/arda.js" ></script>-->
	<script type="text/javascript" src="<? echo ORCHID_URL.'/form/syntaxhighlighter/scripts/shCore.js'?>"></script>
	<script type="text/javascript" src="<? echo ORCHID_URL.'/form/syntaxhighlighter/scripts/shBrushJScript.js'?>"></script>
	<script type="text/javascript" src="<? echo ORCHID_URL.'/form/syntaxhighlighter/scripts/shBrushPhp.js'?>"></script>
	<link type="text/css" rel="stylesheet" href="<? echo ORCHID_URL.'/form/syntaxhighlighter/styles/shCoreDefault.css'?>"/>
	
	<!--<link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/SyntaxHighlighter.css"></link> -->
	<script language="javascript" src="<? echo ORCHID_URL.'/form/syntaxhighlighter/scripts/shBrushCSharp.js'?>"></script> 
	<script language="javascript" src="<? echo ORCHID_URL.'/form/syntaxhighlighter/scripts/shBrushXml.js'?>"></script> 
	<script type="text/javascript">SyntaxHighlighter.all();</script>
<SCRIPT LANGUAGE="JavaScript">

var beginTag = 0;
var endTag = 0;
var getObj="" ;

function supx() {
var newRange="";
//var objectGet=document.getElementById("chkpage");
var objectGet=document.getElementById(getObj);
	if(document.selection!=null){
		var selectedText = document.selection;
		newRange = document.selection.createRange();
		document.getElementById(getObj).value=newRange.text;
	}else{
		newRange=supstrx();
		document.getElementById(getObj).value=newRange;
	}
}

function supstrx(){
    var userSelection;
    if(window.getSelection)
        userSelection = window.getSelection();
    else
        userSelection = document.selection.createRange();
    var range = null;
    if(userSelection.anchorNode != null) {
        range = this.getRangeObject(userSelection);
    }
	return range;
}

function getRangeObject(selectionObject) {
	if (selectionObject.getRangeAt)
		return selectionObject.getRangeAt(0);
	else {
		var range = document.createRange();
		range.setStart(selectionObject.anchorNode,selectionObject.anchorOffset);
		range.setEnd(selectionObject.focusNode,selectionObject.focusOffset);
		return range;
	}
}

function MyHighlight(textvalues,objnm)
{
	getObj=objnm;
	if(textvalues.length>3){
		var contents=document.getElementById("content").innerHTML;
		 i = contents.indexOf("<FONT",1);
		/*if (i>0){
			getContent("<?=$_GET["id"];?>",textvalues,objnm);
		}*/
        //highlightSearchTerms(textvalue,"", "", "", "",objnm); 
		textvalueA=textvalues.split(",");
		for (var i = 0; i < textvalueA.length; i++) {
			textvalue=textvalueA[i];
			replace_color(textvalue);
		}
	}	
}
function deletespace(str){
	strA=str.split(" ");
	newstr="";
	catstr="";
	for (var i = 0; i < strA.length; i++) {
		if(Trim(strA[i])==""){
			catstr="";
		}else{
			catstr=" "+Trim(strA[i]);
		}
		if(newstr==""){
			newstr=Trim(strA[i]);
		}else{
			newstr=newstr + catstr;
		}
	}
	
	if(newstr.substring(newstr.length-1,newstr.length)=="/"){
		//newstr=newstr.replace(/\//g,"");
		newstr=newstr.substring(0,newstr.length-1);
	}
	newstr=newstr.replace(/\\/g,"");
	return newstr;
}
function replace_color(searchTerm){
    highlightStartTag = "<font style='color:#FF0033;background-color:#E6FF80';>";
    highlightEndTag = "</font>";
	//alert(searchTerm);
  var newText = "";
  var i = -1;
  var bodyText = document.getElementById("content").innerHTML;
  searchTerm=searchTerm.replace(/</g,"&lt;");
  searchTerm=searchTerm.replace(/>/g,"&gt;");
  //alert(navigator.appName);
  if(navigator.appName!="Netscape"){
	//searchTerm=searchTerm.replace("  "," ");
	searchTerm=deletespace(searchTerm);
  }
  //bodyText=bodyText.replace("  ","*");
  //searchTerm=searchTerm.replace("  ","*");
  //alert(bodyText+ " " + searchTerm);
  //alert(bodyText);
  if(bodyText== searchTerm){
	//alert("checked");
  }
  var lcSearchTerm = searchTerm;//.toLowerCase();
  var lcBodyText = bodyText;//.toLowerCase();
  while (bodyText.length > 0) {
    i = lcBodyText.indexOf(lcSearchTerm, i+1);
    if (i < 0) {
      newText += bodyText;
      bodyText = "";
    } else {
      // skip anything inside an HTML tag
      if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
        // skip anything inside a <script> block
        if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
			//alert("start3"+highlightStartTag+ "  " +highlightEndTag);
          newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          i = -1;
        }
      }
    }
  }
  document.getElementById("content").innerHTML=newText;
  //return newText;
}


function LTrim(str){
    if (str==null){return null;}
    for(var i=0;str.charAt(i)==" ";i++);
    return str.substring(i,str.length);
}
function RTrim(str){
    if (str==null){return null;}
    for(var i=str.length-1;str.charAt(i)==" ";i--);
    return str.substring(0,i+1);
}
function Trim(str){
    return LTrim(RTrim(str));
} 
/*
 * This is the function that actually highlights a text string by
 * adding HTML tags before and after all occurrences of the search
 * term. You can pass your own tags if you'd like, or if the
 * highlightStartTag or highlightEndTag parameters are omitted or
 * are empty strings then the default <font> tags will be used.
 */
function doHighlight(bodyText, searchTerm, highlightStartTag, highlightEndTag) 
{
	alert("start"+highlightStartTag+ "  " +highlightEndTag);
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style='color:#FF0033;background-color:#E6FF80';>";
    highlightEndTag = "</font>";

  }
  alert("start2"+highlightStartTag+ "  " +highlightEndTag);
  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var newText = "";
  var i = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  var lcBodyText = bodyText.toLowerCase();
    
  while (bodyText.length > 0) {
    i = lcBodyText.indexOf(lcSearchTerm, i+1);
	alert(i);
    if (i < 0) {
      newText += bodyText;
      bodyText = "";
    } else {
      // skip anything inside an HTML tag
      if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
        // skip anything inside a <script> block
        if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
			alert("start3"+highlightStartTag+ "  " +highlightEndTag);
          newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
		  alert("check"+newText + highlightStartTag);
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          i = -1;
        }
      }else{
		alert("Over tag");
	  }
    }
  }
  //alert("inser color:="+newText);
  return newText;
}

 function getContent(str,textvalue,objnm)
{
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("content").innerHTML=xmlhttp.responseText;
		MyHighlight(textvalue,objnm);
		}
	}
	xmlhttp.open("GET","getContent.php?id="+str,true);
	xmlhttp.send();
}
</script>

</head> 
<body>
<table>
<tr>
	<td align="left">
		<table align="center">
		<tr>
		<!--<form name="mode" action="options-general.php">-->
		<form name="mode" action="admin.php">
			<td><input type="hidden" name="id" value="<?=$id;?>">
			<input type="hidden" name="page" value="<?=$page;?>">
			<input type="radio" name="modechange" value="show" onclick="this.form.submit();">View</td>
			<td><input type="radio" name="modechange" value="edit" onclick="this.form.submit();">Edit</td>
		</form>
		</tr>
		</table>
	</td>
</tr>
<tr>
<td>
<!--<form name="setvariable" action="options-general.php.php" >-->
<form name="setvariable" action="admin.php" >
<table border="1">
<tr valign="top">
	<td>
		<table>
		<tr>
			<td>Url สำหรับดึงข้อมูล</td>
			<td><textarea name="urlcurl"><?=$row["urlcurl"];?></textarea></td>
		</tr>
		<tr>
			<td >ต้องการ URLEncoding หรือไม่</td>
			<td><input type="radio" name="urlkey" value="0" <? if($row["urlkey"]=="0")echo "checked"; ?>>Don't UrlEncoding<br>
					<input type="radio" name="urlkey" value="1" <? if($row["urlkey"]=="1")echo "checked"; ?>>Yes UrlEncoding</td>
		</tr>
		<tr>
			<td>Url สำหรับดึงข้อมูล</td>
			<td>
				<table>
					<tr>
						<td>เปลี่ยน charset จาก</td>
						<td><input type="text" name="encodekey1" value="<?=$encodekey1;?>" onclick="MyHighlight(this.value,'encodekey1')"></td>
					</tr>
					<tr>
						<td>เป็น Charset</td>
						<td><input type="text" name="encodekey2" value="<?=$encodekey2;?>" onclick="MyHighlight(this.value,'encodekey2')"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td >ช่วงข้อมูลที่ต้องการ</td>
			<td>
				<table>
					<tr >
						<td >เริ่มต้นดึงเนื้อหาที่ข้อความ :</td><td><textarea name="chkpage" id="chkpage" onclick="MyHighlight(this.value,'chkpage')"><?=trim($row["chkpage"]);?></textarea></td>
					</tr>
					<tr>
						<td>สิ้นสุดการดึงเนื้อหาที่ข้อความ :</td><td><textarea name="chkEndpage" onclick="MyHighlight(this.value,'chkEndpage')"><?=$row["chkEndpage"];?></textarea></td>
					</tr>
				</table>
			</td>
		<tr>
			<td>เปลี่ยน Url เป็น Full Link</td>
			<td>
				<table>
					<tr >
						<td>เปลี่ยน Url ภายในเนื้อหา : </td><td><textarea name="handledirserch" onclick="MyHighlight(this.value,'handledirserch')"><?=$row["handledirserch"];?></textarea></td>
					</tr>
					<tr>
						<td>เป็น Url : </td><td><textarea name="handledir" onclick="MyHighlight(this.value,'handledir')"><?=$row["handledir"];?></textarea></td>
					</tr>
				</table>
			</td>
		<tr>
			<td >เปลี่ยนข้อความในเนื้อหา</td>
			<td>
				<table>
					<tr>
						<td>เปลี่ยนข้อความภายในเนื้อหาจาก : </td><td><textarea name="contentserch" onclick="MyHighlight(this.value,'contentserch')"><?=$row["contentserch"];?></textarea></td>
					</tr>
					<tr>
						<td>เป็นข้อความ : </td><td><textarea name="contentreplace" onclick="MyHighlight(this.value,'contentreplace')"><?=$row["contentreplace"];?></textarea></td>
					</tr>
				</table>
			</td>
		<tr>
			<td>ประเภทของการส่งค่า</td>
			<td><input type="radio" name="typecurl" value="GET" <? if(trim($row["typecurl"])=="GET")echo "checked"; ?>>GET<br>
					<input type="radio" name="typecurl" value="POST" <? if(trim($row["typecurl"])=="POST")echo "checked"; ?>>POST</td>
		</tr>
		<tr>
			<td>Parameter ของเว็บไซต์ที่ดึงมา</td>
			<td><textarea name="parameters" onclick="MyHighlight(this.value,'parameters')"><?=$row["parameters"];?></textarea></td>
		</tr>
		<tr>
			<td>ตัวแปรที่ใช้ส่งค่าให้ Parameter</td>
			<td><textarea name="vars" onclick="MyHighlight(this.value,'vars')"><?=$row["vars"];?></textarea></td>
		</tr>
		<tr>
			<td>Function ในการสกัดข้อมูล</td>
			<td><textarea name="parsedata" onclick="MyHighlight(this.value,'parsedata')"><?=$row["parsedata"];?></textarea></td>
		</tr>
		<tr>
			<td><input type="reset" name="cancel" value="ยกเลิก"></td>
			<td><input type="submit" name="ok" value="บันทึก"></td>
		</tr>
		</table>
	</td>
	<td>
	<?
		//echo ReadFileText($row["urlcurl"],$id);
		echo "<div id=\"content\" OnMouseUp=\"supx();\">";
		//echo "<div id=\"content\" >";
		//echo htmlspecialchars('Search   </h2>');
		//echo htmlspecialchars('<div class="archive">');
		if($modechange=="show"){
			echo "<pre class='brush: php; html-script: true'>";	
		}
		//echo htmlspecialchars('<h2><a href="http://www.mborchid.com/about_us" rel="bookmark" title="Permanent Link to เกี่ยวกับเรา">');
		require( ORCHID_DIR . '/form/show_content_chkdb.php'); 	
		//include"./show_content_chkdb.php";
		if($modechange=="show"){
			echo"</pre>";
		}
		echo"</div>";
	?>
	</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>