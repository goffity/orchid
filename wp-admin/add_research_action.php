<?php
include("../Connect.php");
mysql_select_db($database_Connect,$Connect);

$nameTH = $_POST['nameTH'];
$nameEN = $_POST['nameEN'];
$orchid_family = $_POST['orchid_family'];
$creator = $_POST['creator'];
$rc_publisher= $_POST['rc_publisher'];
$rc_keyword = $_POST['rc_keyword'];
$rc_description=$_POST['rc_description'];
$rc_contributor1=$_POST['rc_contributor1'];
$rc_contributor2=$_POST['rc_contributor2'];
$rc_contributor3=$_POST['rc_contributor3'];
$date8a=$_POST['date8a'];
$rc_type=$_POST['rc_type'];
$rc_identifer=$_POST['rc_identifer'];
$rc_source=$_POST['rc_source'];
$rc_language=$_POST['rc_language'];
$rc_relation=$_POST['rc_relation'];
$rc_rights=$_POST['rc_rights'];

$sql="INSERT INTO research_content (rc_title_th, rc_title_eng, rc_creator,  rc_publisher,  rc_keyword, rc_description, rc_source, rc_language, rc_relation, rc_rights, rc_contributor1, rc_contributor2, rc_contributor3, rc_date, rc_type, rc_identifer, UpdateDate, Status, family_id)
	      VALUES('".$nameTH."', '".$nameEN."', '".$creator."', '".$rc_publisher."', '".$rc_keyword."', '".$rc_description."', '".$rc_source."', '".$rc_language."', '".$rc_relation."',  '".$rc_rights."', '".$rc_contributor1."', '".$rc_contributor2."', '".$rc_contributor3."', '".$date8a."', '".$rc_type."', '".$rc_identifer."', 'now()', 'Y', '".$orchid_family."')";
$result=mysql_query($sql,$Connect)or die(mysql_error());


//inset wp post
include '../wp-includes/class-IXR.php';

$client = new IXR_Client($blog_url.'/xmlrpc.php');

echo "<BR>".$select_keyword;
echo "<BR>".$orchid_family;

$note = array(
    'title'             => $nameTH.'('.$nameEN.')',
    'description'        => $detail,
    'categories'        => array('งานวิจัย')
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
<?php echo '<meta http-equiv="refresh" content="2;URL=manage_research.php">';?>
