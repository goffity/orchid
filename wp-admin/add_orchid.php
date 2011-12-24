<?php
/**
 * Dashboard Administration Panel
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */

require_once('./admin.php');
include("../Connect.php");
include("../Connect2.php");
mysql_select_db($database_Connect,$Connect);

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'เพิ่มพันธุ์กล้วยไม้' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'media-upload' );
wp_admin_css( 'เพิ่มพันธุ์กล้วยไม้' );
wp_admin_css( 'plugin-install' );
add_thickbox();

$title = __('เพิ่มพันธุ์กล้วยไม้');
$parent_file = 'add_orchid.php';

add_contextual_help($current_screen,

	'<p>' . __('Welcome to your WordPress Dashboard! You will find helpful tips in the Help tab of each screen to assist you as you get to know the application.') . '</p>' .
	'<p>' . __('The left-hand navigation menu provides links to the administration screens in your WordPress application. You can expand or collapse navigation sections by clicking on the arrow that appears on the right side of each navigation item when you hover over it. You can also minimize the navigation menu to a narrow icon strip by clicking on the separator lines between navigation sections that end in double arrowheads; when minimized, the submenu items will be displayed on hover.') . '</p>' .
	'<p>' . __('You can configure your dashboard by choosing which modules to display, how many columns to display them in, and where each module should be placed. You can hide/show modules and select the number of columns in the Screen Options tab. To rearrange the modules, drag and drop by clicking on the title bar of the selected module and releasing when you see a gray dotted-line box appear in the location you want to place the module. You can also expand or collapse each module by clicking once on the the module&#8217;s title bar. In addition, some modules are configurable, and will show a &#8220;Configure&#8221; link in the title bar when you hover over it.') . '</p>' .
	'<p>' . __('The modules on your Dashboard screen are:') . '</p>' .
	'<p>' . __('<strong>Right Now</strong> - Displays a summary of the content on your site and identifies which theme and version of WordPress you are using.') . '</p>' .
	'<p>' . __('<strong>Recent Comments</strong> - Shows the most recent comments on your posts (configurable, up to 30) and allows you to moderate them.') . '</p>' .
	'<p>' . __('<strong>Incoming Links</strong> - Shows links to your site found by Google Blog Search.') . '</p>' .
	'<p>' . __('<strong>QuickPress</strong> - Allows you to create a new post and either publish it or save it as a draft.') . '</p>' .
	'<p>' . __('<strong>Recent Drafts</strong> - Displays links to the 5 most recent draft posts you&#8217;ve started.') . '</p>' .
	'<p>' . __('<strong>Other WordPress News</strong> - Shows the feed from <a href="http://planet.wordpress.org" target="_blank">WordPress Planet</a>. You can configure it to show a different feed of your choosing.') . '</p>' .
	'<p>' . __('<strong>Plugins</strong> - Features the most popular, newest, and recently updated plugins from the WordPress.org Plugin Directory.') . '</p>' .
	'<p><strong>' . __('For more information:') . '</strong></p>' .
	'<p>' . __('<a href="http://codex.wordpress.org/Dashboard_SubPanel" target="_blank">Dashboard Documentation</a>') . '</p>' .
	'<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>'
);

require_once('./admin-header.php');

$today = current_time('mysql', 1);

?>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
// Count the number of times a substring is in a string.
String.prototype.substrCount =
  function(s) {
    return this.length && s ? (this.split(s)).length - 1 : 0;
  };

// Return a new string without leading and trailing whitespace
// Double spaces whithin the string are removed as well
String.prototype.trimAll =
  function() {
    return this.replace(/^\s+|(\s+(?!\S))/mg,"");
  };

//event handler
function loadContentResult(nameTH) {
	if(nameTH.substrCount(' ') > 0)
	{
		$("#actionresult").hide();
		$("#actionresult").load("user.php?msg=whitespace", '', callbackResult);
	}
	else
	{
		$("#actionresult").hide();
		$("#actionresult").load("user.php?nameTH="+nameTH.trimAll()+"", '', callbackResult);
	}	
}

//callback
function callbackResult() {
	$("#actionresult").show();
}

//ajax spinner
$(function(){
	$("#spinner").ajaxStart(function(){
		$(this).html('<img src="image/wait.gif" />');
	});
	$("#spinner").ajaxSuccess(function(){
		$(this).html('');
 	});
	$("#spinner").ajaxError(function(url){
		alert('Error: server was not respond, communication interrupt. Please try again in a few moment.');
 	});
});

//set2
function loadContentResult2(nameEN) {
	if(nameEN.substrCount(' ') > 0)
	{
		$("#actionresult2").hide();
		$("#actionresult2").load("user.php?msg2=whitespace2", '', callbackResult2);
	}
	else
	{
		$("#actionresult2").hide();
		$("#actionresult2").load("user.php?nameEN="+nameEN.trimAll()+"", '', callbackResult2);
	}	
}

//callback
function callbackResult2() {
	$("#actionresult2").show();
}

//ajax spinner
$(function(){
	$("#sp_v2").ajaxStart(function(){
		$(this).html('<img src="images/ajax-loader.gif" />');
	});
	$("#sp_v2").ajaxSuccess(function(){
		$(this).html('');
 	});
	$("#sp_v2").ajaxError(function(url){
		alert('Error: server was not respond, communication interrupt. Please try again in a few moment.');
 	});
});

function chk_submit()
{
	if(window.document.form1.select_keyword.value.length == 0)
	{
		alert("กรุณาเลือก ชื่ออื่นๆ" );
		window.document.form1.select_keyword.focus();
		return false;
	}
	else if(window.document.form1.orchid_family.value.length == 0)
	{
		alert("กรุณาเลือก สกุล" );
		window.document.form1.orchid_family.focus();
		return false;
	}
	else if(window.document.form1.orchid_url.value.length == 0)
	{
		alert("กรุณากรอก เว็บไซต์ที่มา" );
		window.document.form1.orchid_url.focus();
		return false;
	}
	else if(window.document.form1.detail.value.length == 0)
	{
		alert("กรุณากรอก เนื้อหา" );
		window.document.form1.detail.focus();
		return false;
	}
	else
	{
		return true;
	}
}


</script>


<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>


<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">
<p>&nbsp;</p>
  <form action="add_orchid_action.php" method="post" enctype="multipart/form-data" name="form1" onsubmit="return chk_submit();" >
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="298" height="25"><div align="right"><strong>ชื่อพันธุ์ (ภาษาไทย)</strong></div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left">
            <label>
            <input name="nameTH" type="text" id="nameTH" onchange="loadContentResult(this.value)" />
            </label>
            <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25">
			<div id="spinner"></div>
			<div id="actionresult"></div>
			<div class="clear"></div>
		</td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อพันธุ์ (ภาษาอังกฤษ)</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="nameEN" type="text" id="nameEN"  onchange="loadContentResult2(this.value)" />
        </div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25" align="left">
			<div id="sp_v2"></div>
			<div id="actionresult2"></div>
			<div class="clear"></div>
		</td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php 
			$sql="SELECT DISTINCT key_id FROM search_key WHERE key_id != '-1' AND search_type_id = 'st004' ORDER BY key_id ASC";
			$result=mysql_query($sql,$Connect)or die(mysql_error());
		?>
          <select name="select_keyword" id="select_keyword">
            <option value="" selected="selected">--select--</option>
            <?php 
			//$x=0;
				//$keepData = array();
				//$keepID = array();
			
			while($row=mysql_fetch_array($result)){
			$set_show = "<option value=\"".$row['key_id']."\">";
			//print_r($keepData);
				$keep_sql="SELECT key_id, key_name FROM search_key WHERE key_id='".$row['key_id']."' ORDER BY key_id ASC";
				$keep_result=mysql_query($keep_sql,$Connect)or die(mysql_error());
				$a=0;
				while($row2=mysql_fetch_array($keep_result)){
					//$keepData[$x][$a]=$row2['key_name'];
					//$keepID[$x]=$row2['key_id'];
					$set_show .= $row2['key_name']." , ";
					//$a++;
				}	
				echo $set_show.="</option>";
				//print($set_show);
				//echo "<option value=\"".$keepID[$x]."\">".$keepData[$x][0]."</option>"; //$row2['Key_Desc'].",";
		?>
        <?php $x++;}?>
          </select>
          <span class="style1">*</span></div></td>
      </tr>
	  
      <tr>
        <td height="25"><div align="right"><strong> สกุล </strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
		<?php 
			//Select Family
			$query_family = "SELECT family_id, family_name_th, family_name_eng FROM family WHERE Status='Y' ORDER BY family_id ASC";
			$result_family = mysql_query($query_family,$Connect)or die(mysql_error());
		?>
        <select name="orchid_family" id="orchid_family">
          <option value="" selected="selected">--select--</option>
          <?php while($row_family=mysql_fetch_array($result_family)){?>
          <option value="<?php echo $row_family['family_id']?>"><?php echo $row_family['family_name_th']."(".$row_family['family_name_eng'].")";?></option>
          <?php }?>
        </select>
        <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="orchid_url" type="text" id="orchid_url">
          <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>เนื้อหา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label>
          <textarea name="detail" cols="50" rows="8" id="detail"></textarea>
          </label>
          <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25"><label>
          <input type="submit" name="Submit" value="บันทึก">
        &nbsp;&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="ยกเลิก">
        </label></td>
      </tr>
    </table>
    </form>
  <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
