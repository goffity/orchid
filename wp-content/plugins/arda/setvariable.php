<?
//******************** Set URL for Search ***************************
$urlcurl=array();
$urlcurl[]="http://www.mborchid.com/?s=";//0
$urlcurl[]="http://www.doae.go.th/temp.asp?gpg=newsearch&keyword=";//1
$urlcurl[]="http://www2.ops3.moc.go.th/thtrade/gy/report.asp";//2
$urlcurl[]="http://www.trf.or.th/research/search.asp";//3
$urlcurl[]="http://www.orchidcenter.org/research/search/search.php";//4
$urlcurl[]="http://www.taladsimummuang.com/dmma/Portals/PriceList.aspx?id=0802";//5

//*******************URL Encode *****************
$urlkey=array();
$urlkey[]=1;
$urlkey[]=0;
$urlkey[]=0;
$urlkey[]=0;
$urlkey[]=0;
$urlkey[]=0;


//*******************ICONV Key Search ***************
$encodekey=array();
$encodekey[]="";
$encodekey[]="utf-8,windows-874";
$encodekey[]="";
$encodekey[]="utf-8,windows-874";
$encodekey[]="utf-8,windows-874";
$encodekey[]="";


//************ check page of all record **************
$chkpage=array();
$chkpage[]='Search  </h2>';
$chkpage[]='<td><table width="500" align="center">';
$chkpage[]='';
//$chkpage[]='รายการ</font></B>';
$chkpage[]='<td bgcolor="#FFFFFF">';
$chkpage[]='<td ><div align="center">';
$chkpage[]='<script language=javascript> function loadArrayCrop()';


//************ check end page of all record **************
$chkEndpage=array();
$chkEndpage[]='<h2><a href="http://www.mborchid.com/about_us" rel="bookmark" title="Permanent Link to เกี่ยวกับเรา">';
$chkEndpage[]='<td>หน้า';
$chkEndpage[]='';
$chkEndpage[]='<TR><TD>';
$chkEndpage[]=']                                           </div></td>';
$chkEndpage[]='<script src="/dmma/';

//**********heder page*****************
$headerpage=array();
$headerpage[]="";
$headerpage[]="";
$headerpage[]="";
$headerpage[]="";
$headerpage[]="";
$headerpage[]="";


//************check finish print *******************
$chkend=array();
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';
$chkend[]="";//'<div id="PaginationNode2" class="container"><div class="numItems">';

//********** record per page *****************
$recpage=array();
$recpage[]=20;
$recpage[]=20;
$recpage[]=20;
$recpage[]=20;
$recpage[]=20;
$recpage[]=20;

//************** ignor show ********************
$noshow= array();
$noshow[]='';
$noshow[]='';
$noshow[]='';
$noshow[]='';
$noshow[]='';
$noshow[]='';

//********Array สำหรับ replace Haddle *****************
$handledirserch=array();
$handledirserch[]="";
$handledirserch[]=array("/prompt\//","/img\//");
$handledirserch[]=array("/\/thtrade\//","/\/crystalreportviewers10\//");
$handledirserch[]="/project_detail.asp/";
$handledirserch[]="/detail.php/";
$handledirserch[]="";

$handledir=array();
$handledir[]="";
$handledir[]=array("http://www.doae.go.th/prompt/","http://www.doae.go.th/img/");
$handledir[]=array("http://www2.ops3.moc.go.th/thtrade/","http://www2.ops3.moc.go.th/crystalreportviewers10/");
$handledir[]="http://www.trf.or.th/research/project_detail.asp";
$handledir[]="http://www.orchidcenter.org/research/search/detail.php";
$handledir[]="";

//********Array สำหรับ replace Content *****************
$contentserch=array();
$contentserch[]=array("/<div class=\"archive\">/","/<div class=\"archiveright right\">/","/<div class=\"postmeta\">/");
$contentserch[]="/<table width=\"500\" align=\"center\">/";
$contentserch[]="";
$contentserch[]="";
$contentserch[]=array("/<div align=\"center\">/","/<table width=\"98%\"  border=\"0\" cellspacing=\"2\" cellpadding=\"0\">/");
$contentserch[]="";

$contentreplace=array();
$contentreplace[]=array("</td></tr><tr><td>","</td><td>","</td><td>");//"http://www.ncbi.nlm.nih.gov/pubmed/";
$contentreplace[]="<table>";
$contentreplace[]="";
$contentreplace[]="";
$contentreplace[]=array("","<table>");
$contentreplace[]="";

?>