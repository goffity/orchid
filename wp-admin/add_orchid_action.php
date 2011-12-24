<?php
//define('WP_USE_THEMES', true);
require('../wp-blog-header.php');

include("../Connect.php");
mysql_select_db($database_Connect,$Connect);

$nameTH = $_POST['nameTH'];
$nameEN = $_POST['nameEN'];
$select_keyword = $_POST['select_keyword'];
$orchid_family= $_POST['orchid_family'];
$orchid_url = $_POST['orchid_url'];
$detail=$_POST['detail'];

$blog_url = get_bloginfo('url');

// number 0 is new keyword
if($select_keyword == 0)
{
	//select desc number
	$query_number="SELECT key_id FROM search_key ORDER BY key_id DESC";
	$result_number=mysql_query($query_number,$Connect)or die(mysql_error());
	$row_number=mysql_fetch_array($result_number);
	$set_num = $row_number['key_id']+1;

	//insert thai and eng
	$query_nameTH="INSERT INTO search_key(key_id, key_name, search_type_id) VALUES('".$set_num."', '".$nameTH."', 'st004')";
	$result_nameTH=mysql_query($query_nameTH,$Connect)or die(mysql_error());

	if($nameEN != '')
	{
		$query_nameEN="INSERT INTO search_key(key_id, key_name, search_type_id) VALUES('".$set_num."', '".$nameEN."', 'st004')";
		$result_nameEN=mysql_query($query_nameEN,$Connect)or die(mysql_error());
	}

}
else
{
	$set_num = $select_keyword;
	//insert thai and eng
	$query_nameTH="INSERT INTO search_key(key_id, key_name, search_type_id) VALUES('".$set_num."', '".$nameTH."', 'st004')";
	$result_nameTH=mysql_query($query_nameTH,$Connect)or die(mysql_error());

	if($nameEN != '')
	{
		$query_nameEN="INSERT INTO search_key(key_id, key_name, search_type_id) VALUES('".$set_num."', '".$nameEN."', 'st004')";
		$result_nameEN=mysql_query($query_nameEN,$Connect)or die(mysql_error());
	}

}


$sql="INSERT INTO orchid_varity(key_id, orchid_name_th, orchid_name_eng, family_id, Orchid_Content1,  orchid_url, UpdateDate, Status) VALUES('".$set_num."', '".$nameTH."', '".$nameEN."', '".$orchid_family."', '".$detail."', '".$orchid_url."',now(),'Y')";
$result=mysql_query($sql,$Connect)or die(mysql_error());

//inset wp post
include '../wp-includes/class-IXR.php';

$client = new IXR_Client($blog_url.'/xmlrpc.php');

echo "<BR>".$select_keyword;
echo "<BR>".$orchid_family;

$note = array(
    'title'             => $nameTH.'('.$nameEN.')',   //title
    'description'        => $detail,  //content
//'mt_text_more'      => 'tre?? wpisu',    //tag more
    'categories'        => array('พันธุ์'),   //categories of post
//    'mt_keywords'       => array($nameTH,$nameEN), // tag
//'dateCreated'       => date(DATE_RFC822, mktime(0, 0, 0, 1, 1, 2000)),   //data publikacji wpisu
//'wp_password'     => 'hasuo',    //has?o wpisu
//'mt_allow_pings'    => true,  //zezwala? na pingbacki?
//'mt_allow_comments' => true,  //a na komentarze?
);

if(!$client->query('metaWeblog.newPost', 1, 'admin', 'password', $note, true)){
	echo "<BR>".$client->getErrorCode().': '.$client->getErrorMessage();
}else{
	echo "<BR>".$client->getResponse();
}

echo "<BR>".$client->getResponse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orchid Portal</title>
<style type="text/css">
<!--
.style1 {
	color: #333333
}
-->
</style>
</head>

<body>
	<p>&nbsp;</p>
	<p align="center">
		<img src="images/indicator_medium.gif" width="32" height="32" />
	</p>
	<p align="center" class="style1">Please...Waiting</p>
</body>
</html>
<?php echo '<meta http-equiv="refresh" content="2;URL=manage_orchid.php">';?>