<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Validate Meta Data MOU Extraction</title>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin

var beginTag = 0;
var endTag = 0;
var getObj="" ;
function supx() {
	//alert("xxx"+getObj);
	var selectedText = document.selection;
	//if (selectedText.type == '<div>') {
		var newRange = selectedText.createRange();
		//alert(newRange);
//location.href = "./chk2.php?word=" + newRange.text; 
	var insertval ="<sup>"+newRange.text + "</sup>";
		if(newRange.text!=""){
			//theField.value=theField.value.replace(newRange.text,insertval);
			document.getElementById(getObj).value=newRange.text;
		}
	/*} else {
	alert('Alert: Select The text in the textarea then click on this button');
	}*/
}
function MyHighlight(textvalue,objnm)
{
	getObj=objnm;
	if(textvalue.length>3){
        //highlightSearchTerms(textvalue); 
		var contents=document.getElementById("content").innerHTML;
		//alert(contents);
		 i = contents.indexOf("<FONT",1);
		 //alert(i);
		if (i>0){
			getContent("<?=$_GET["id"];?>",textvalue,objnm);
		}
        highlightSearchTerms(textvalue,"", "", "", "",objnm);   
	}	
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
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style='color:#FF0033;background-color:#E6FF80';>";
    highlightEndTag = "</font>";
  }
  
  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var highlightStartTagx = "<FONT style=\"background-color: #E6FF80; color: #FF0033\" ;>";
  var highlightEndTagx = "</FONT>";
   
  var eString="";
  var e2String="";
	eString=bodyText.toLowerCase();
	//alert(highlightStartTagx.toLowerCase()+":"+highlightEndTagx.toLowerCase()+":"+eString );
	eString=eString.replace(highlightStartTagx.toLowerCase(),"");

	e2String=eString.replace(highlightEndTagx.toLowerCase(),"");
	bodyText=e2String;
  var newText = "";
  var i = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  var lcBodyText = bodyText.toLowerCase();
    
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
          newText += bodyText.substring(0, i) + highlightStartTag.toLowerCase() + bodyText.substr(i, searchTerm.length) + highlightEndTag.toLowerCase();
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          i = -1;
        }
      }
    }
  }
  
  return newText;
}

function chkPos(bodyText, searchTerm, highlightStartTag, highlightEndTag,objnm) 
{
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style=\"color:#FF0033; background-color:#E6FF80;\">";
    highlightEndTag = "</font>";
  }

  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var bodyTextReplace =bodyText;// document.getElementById("content").innerHTML;
  var highlightStartTagx = "<FONT style=\"background-color: #E6FF80; color: #FF0033\" ;>";
  var highlightEndTagx = "</FONT>";
    
   
  //var bodyTextReplace = document.getElementById("content").innerHTML;
  var eString="";
  var e2String="";
   eString=bodyTextReplace.toLowerCase();
//alert(highlightStartTagx.toLowerCase()+":"+highlightEndTagx.toLowerCase()+":"+eString );
 eString=eString.replace(highlightStartTagx.toLowerCase(),"");

  e2String=eString.replace(highlightEndTagx.toLowerCase(),"");

  bodyTextReplace=e2String;
  var newTextx = "";

  var x = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  var xcBodyText = bodyTextReplace.toLowerCase();
   
  
  
  while (bodyTextReplace.length > 0) {
  //alert("xxxx");
    x= xcBodyText.indexOf(lcSearchTerm, x+1);
    if (x< 0) {
      newTextx += bodyTextReplace;
      bodyTextReplace = "";
    } else {
			
      // skip anything inside an HTML tag
      if (bodyTextReplace.lastIndexOf(">", x) >= bodyTextReplace.lastIndexOf("<", x)) {
        if (xcBodyText.lastIndexOf("/script>", x) >= xcBodyText.lastIndexOf("<script", x)) {
			document.getElementById("pos_b_"+objnm).value=x;
			beginTag=x;
			document.getElementById("pos_e_"+objnm).value=x+ searchTerm.length;
			endTag=x+ searchTerm.length;
          newTextx += bodyTextReplace.substring(0, x) + highlightStartTag + bodyTextReplace.substr(x, searchTerm.length) + highlightEndTag;
          bodyTextReplace = bodyTextReplace.substr(x+ searchTerm.length);
          xcBodyText = bodyTextReplace.toLowerCase();
          x = -1;
        }
      }
    }
  }
  
}


/*
 * This is sort of a wrapper function to the doHighlight function.
 * It takes the searchText that you pass, optionally splits it into
 * separate words, and transforms the text on the current web page.
 * Only the "searchText" parameter is required; all other parameters
 * are optional and can be omitted.
 */
function highlightSearchTerms(searchText, treatAsPhrase, warnOnFailure, highlightStartTag, highlightEndTag,objnm)
{
  // if the treatAsPhrase parameter is true, then we should search for 
  // the entire phrase that was entered; otherwise, we will split the
  // search string so that each word is searched for and highlighted
  // individually
  
  if (treatAsPhrase) {
    searchArray = [searchText];
  } else {
    searchArray = searchText.split(" ");
  }
  
  if (!document.body || typeof(document.body.innerHTML) == "undefined") {
    if (warnOnFailure) {
      alert("Sorry, for some reason the text of this page is unavailable. Searching will not work.");
    }
    return false;
  }
  
  var highlightStartTagx = "<FONT style=\"background-color: #E6FF80; color: #FF0033\">";
  var highlightEndTagx = "</FONT>";
    //var bodyTextReplace = document.getElementById("content").firstChild.nodeValue;
  var bodyTextReplace = document.getElementById("content").innerHTML;
  var eString="";
  var e2String="";
	eString=bodyTextReplace.toLowerCase();
	eString=eString.replace(highlightStartTagx.toLowerCase(),"");
	e2String=eString.replace(highlightEndTagx.toLowerCase(),"");
	document.getElementById("content").innerHTML=e2String;
  
  var bodyText = document.body.innerHTML;
  /*var Stringtext= bodyText.toLowerCase();
	Stringtext=Stringtext.replace(highlightStartTagx.toLowerCase(),"");
	Stringtext=Stringtext.replace(highlightEndTagx.toLowerCase(),"");*/
	//bodyText=Stringtext;
  
 	
  for (var i = 0; i < searchArray.length; i++) {
    //alert(searchArray[i].length);
	if(searchArray[i].length>2){
		//bodyText = doHighlight(bodyText, searchArray[i], highlightStartTag, highlightEndTag);
		document.getElementById("content").innerHTML=doHighlight(bodyTextReplace, searchArray[i], highlightStartTag, highlightEndTag);
		//chkPos(e2String, searchArray[i], highlightStartTag, highlightEndTag);
		//bodyText = doHighlight(bodyText, searchArray[i], highlightStartTag, highlightEndTag);
		//bodyText = doHighlight(bodyTextReplace, searchArray[i], highlightStartTag, highlightEndTag);
	}
  }
  
  
  //document.body.innerHTML = bodyText;
	for (var i = 0; i < searchArray.length; i++) {
    //alert(searchArray[i].length);
	if(searchArray[i].length>2){
		chkPos(e2String, searchArray[i], highlightStartTag, highlightEndTag,objnm);
		//alert(beginTag + ":" + endTag);
	}
  }	
  //document.getElementById("content").firstChild.nodeValue= bodyText
  return true;
}

function HighlightMeta() 
{
	
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
   var highlightStartTag = "<font style='color:#FF0033;background-color:#E6FF80';>";
    var highlightEndTag = "</font>";
  }

  var highlightStartTagx = "";
  var highlightEndTagx = "</FONT>";

  var elLength = document.appform.elements.length-12;
  var eString=document.getElementById("content").innerHTML;
  /*var e2String="";
	eString=bodyText.toLowerCase();
	//alert(highlightStartTagx.toLowerCase()+":"+highlightEndTagx.toLowerCase()+":"+eString );
	eString=eString.replace(highlightStartTagx.toLowerCase(),"");
	e2String=eString.replace(highlightEndTagx.toLowerCase(),"");*/
   var colorstr="CCFF00,00CC00,CC6600,996600,0066CC,990066,000033,CC0033,FF9900,00FFFF"; 
	colorArray = colorstr.split(",");   
  var bodyText=eString;
  var newText = "";
  //var lcSearchTerm = searchTerm.toLowerCase();
  var lcBodyText = bodyText.toLowerCase();
    
			var x=0;
			for (i=1; i<=elLength-1; i++){
			
			var type = appform.elements[i].type;
			var bpos=0;
			var epos=0;
			
				if (appform.elements[i].type=="hidden" ){
					x++;
					highlightStartTagx="<FONT style=\"background-color: #" + colorArray[x] + "; color: #FF0033\" ;>";
					bpos=appform.elements[i].value-1;
					epos=appform.elements[i+1].value-1;
					if(newText==""){
						newText = eString.substring(0,bpos) + highlightStartTagx.toLowerCase() + eString.substr(bpos,epos) + highlightEndTagx.toLowerCase()+ eString.substr(epos, eString.length);
						eString=newText;
					}else{
						//bpos=bpos+highlightStartTagx.length+highlightEndTagx.length;
						//epos=epos+highlightStartTagx.length+highlightEndTagx.length;
						newText = eString.substring(0,bpos) + highlightStartTagx.toLowerCase() + eString.substr(bpos,epos) + highlightEndTagx.toLowerCase()+ eString.substr(epos, eString.length);
						eString=newText;
					}
					i=i+1;
				}else{
					//i=i+1;
				}
			}
			alert(newText);
       document.getElementById("content").innerHTML=newText;
		
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
		MyHighlight(textvalue,objnm)
		}
	}
	xmlhttp.open("GET","getContent.php?id="+str,true);
	xmlhttp.send();
}
  




// End -->
</script>
</head> 
<body  >
<?
include"common.php";
$id=$_GET["id"];

//********** Function read File **************
function ReadFileText($path,$chk){
$colorstr="CCFF00,00CC00,CC6600,996600,0066CC,990066,000033,CC0033,FF9900,00FFFF"; 
$colorArray=split(",",$colorstr);

	$data = file_get_contents($path);
	$sql="SELECT id,mou_nm,pos_b_mou_nm,pos_e_mou_nm,mou_type,pos_b_mou_type,pos_e_mou_type,act_type,pos_b_act_type,pos_e_act_type,country_nm,pos_b_country_nm,pos_e_country_nm,org_nm,pos_b_org_nm,pos_e_org_nm,orgth_nm,pos_b_orgth_nm,pos_e_orgth_nm,research_nm,pos_b_research_nm,pos_e_research_nm,startdate,pos_b_startdate,pos_e_startdate,enddate,pos_b_enddate,pos_e_enddate,datesign,pos_b_datesign,pos_e_datesign,path_text,path_file,flag FROM meta_mou WHERE flag='N' and id=".$chk;

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
function CountLineText($path){
	$lines = count(file($path));
	return $lines;
}

$sql="SELECT id,mou_nm,pos_b_mou_nm,pos_e_mou_nm,mou_type,pos_b_mou_type,pos_e_mou_type,act_type,pos_b_act_type,pos_e_act_type,country_nm,pos_b_country_nm,pos_e_country_nm,org_nm,pos_b_org_nm,pos_e_org_nm,orgth_nm,pos_b_orgth_nm,pos_e_orgth_nm,research_nm,pos_b_research_nm,pos_e_research_nm,startdate,pos_b_startdate,pos_e_startdate,enddate,pos_b_enddate,pos_e_enddate,datesign,pos_b_datesign,pos_e_datesign,path_text,path_file,flag FROM meta_mou WHERE flag='N' and id=".$id;

$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
$row=mysql_fetch_array($r);
$nfield=mysql_num_fields ($r);

echo"<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr><td width=\"20%\">Meta Data <br>From Extractoon</td><td>Text File</td><td>Validate</td></tr>";
//************ Meta Data For MOU *******************
echo"<tr valign=\"top\"><td>";
echo"<table cellpadding=\"0\" cellspacing=\"0\">";
$i=0;
$colorstr="CCFF00,00CC00,CC6600,996600,0066CC,990066,000033,CC0033,FF9900,00FFFF"; 
$colorArray=split(",",$colorstr);
$x=0;
while ($i < mysql_num_fields($r)-3) {
    $meta = mysql_field_name($r, $i);
    if (!$meta) {
        echo "No information available<br />\n";
    }else{
		//echo "<tr><td><input type=\"text\" name=\"".$meta."\" value=\"".$row[$i]."\"></td></tr>";
		if(substr($meta,0,3)=="pos" or $meta=="id"){
			//echo"<tr><td><input type=\"hidden\" id=\"".$meta."x\"  name=\"".$meta."x\" value=\"".$row[$i]."\"></td></tr>"; 
		}else{
			$x=$x+1;
			//echo"<tr><td bgcolor=\"#".$colorArray[$x]."\"><textarea id=\"".$meta."x\"  name=\"".$meta."x\" >".$row[$i]."</textarea></td></tr>"; 
			echo"<tr><td >".$meta." :<br><div style=\"margin: 10px;background-color:#".$colorArray[$x]."\"; ><font size=\"2.5\">".$row[$i]."</font></div></td></tr>"; 
		}
	}
   
    $i++;
}
echo"</table></td>";
//**************** Content text file ***************
echo"<td idth=\"40%\">";
//$data = file_get_contents($row["path_text"]);
	//echo"<textarea name=\"content\" cols=\"80\" rows=\"".CountLineText($row["path_text"])."\">".ReadFileText($row["path_text"]).	"</textarea>"; 
	echo "<div id=\"content\" OnMouseUp=\"supx();\">".ReadFileText($row["path_text"],$id)."</div>";
echo"</td>";
//*************** Value Extraction ****************
//************Edit  Meta Data For MOU *******************
$r=mysql_query($sql) or die(mysql_error()."<br>".$sql);
$row=mysql_fetch_array($r);
$nfield=mysql_num_fields ($r);
echo"<td>";
echo "<form id=\"appform\" name=\"appform\" method=\"POST\" action=\"approvecmd.php\">";
echo"<table cellpadding=\"0\" cellspacing=\"0\">";
$i=0;
while ($i < mysql_num_fields($r)-3) {
    $meta = mysql_field_name($r, $i);
    if (!$meta) {
        echo "No information available<br />\n";
    }else{
		//echo "<tr><td><input type=\"text\" name=\"".$meta."\" value=\"".$row[$i]."\"></td></tr>";
		if(substr($meta,0,3)=="pos" or $meta=="id"){
			echo"<tr><td><input type=\"hidden\" id=\"".$meta."\"  name=\"".$meta."\" value=\"".$row[$i]."\"></td></tr>"; 
		}else{
			//echo"<tr><td><textarea id=\"".$meta."\" onDblClick=\"MyHighlight(this.value,'".$meta."')\">".$row[$i]."</textarea></td></tr>"; 
			echo"<tr><td>".$meta." :<br><div style=\"margin: 10px;\"><textarea id=\"".$meta."\"  name=\"".$meta."\" onclick=\"MyHighlight(this.value,'".$meta."')\">".$row[$i]."</textarea></div></td></tr>"; 
		}
	}
   
    $i++;
}
echo"</table></td>";
echo"</tr>";
echo "<tr><td>Approve Data<br><input type=\"checkbox\" id=\"flag\"></td><td><input type=\"submit\" value=\"Approve\"><input type=\"reset\" value=\"cancel\"></td></tr>";
echo"</table>";
echo "</form>";

?>
</body>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
//HighlightMeta();
//-->
</script>
</html>