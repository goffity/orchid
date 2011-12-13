<?php
require 'db/Data.php';
?>

<HTML><HEAD><META http-equiv="Content-Type" content="text/html; charset=UTF-8"></HEAD>
<LINK href="js/defaultTheme.css" type="text/css" rel="stylesheet">

<?php
$id = $_GET["id"];
$data = new Data();
$result = $data->getNewsDetail($id);
$detail = $result['detail'];
$title = $result['title'];
?>

<DIV id="detail-header">
<H1><?php echo $title ?></H1>
</DIV>

<DIV id="detail-content">
<?php echo $detail ?>
</DIV>

</HTML>
