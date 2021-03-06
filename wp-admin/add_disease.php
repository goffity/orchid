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
mysql_select_db($database_Connect,$Connect);

/** Load WordPress dashboard API */

require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'เพิ่มโรคกล้วยไม้' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'media-upload' );
wp_admin_css( 'เพิ่มโรคกล้วยไม้' );
wp_admin_css( 'plugin-install' );
add_thickbox();

$title = __('เพิ่มโรคกล้วยไม้');
$parent_file = 'add_disease.php';

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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<script type="text/javascript">
function chk_submit()
{
	if(window.document.form1.nameTH.value.length == 0)
	{
		alert("กรุณากรอก ชื่อโรค( ภาษาไทย) " );
		window.document.form1.nameTH.focus();
		return false;
	}
	else if(window.document.form1.disease_detail.value.length == 0)
	{
		alert("กรุณากรอก เนื้อหา" );
		window.document.form1.disease_detail.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>


<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">
<p>&nbsp;</p>
  <form action="add_disease_action.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chk_submit()">
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="298" height="25"><div align="right"><strong>ชื่อโรค( ภาษาไทย) </strong></div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left">
            <label>
            <input name="nameTH" type="text" id="nameTH">
            </label>
            <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td width="298" height="25"><div align="right"><strong>ชื่อโรค (ภาษาอังกฤษ) </strong></div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left">
            <label>
            <input name="nameEN" type="text" id="nameEN">
            </label>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php 
			$sql="SELECT DISTINCT key_id FROM search_key WHERE key_id != '0' AND search_type_id = 'st002' ORDER BY key_id ASC";
			$result=mysql_query($sql,$Connect)or die(mysql_error());
		?>
          <select name="select_keyword" id="select_keyword">
            <option value="" selected="selected">--select--</option>
            <?php 
			
			while($row=mysql_fetch_array($result))
			{
				$set_show = "<option value=\"".$row['key_id']."\">";
				
				$keep_sql="SELECT key_id, key_name FROM search_key WHERE key_id='".$row['key_id']."' ORDER BY key_id ASC";
				$keep_result=mysql_query($keep_sql,$Connect)or die(mysql_error());
				$a=0;
				while($row2=mysql_fetch_array($keep_result))
				{
					$set_show .= $row2['key_name']." , ";
				}	
				echo $set_show.="</option>";
			}	
		?>
          </select>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
	  <tr>
        <td height="25" valign="top"><div align="right"><strong>สกุลที่พบโรค </strong></div></td>
        <td height="25" valign="top"><div align="center">:</div></td>
        <td height="25"><div align="left">
        <?php $query_family="SELECT * FROM family ORDER BY family_id ASC";
		$result_family= mysql_query($query_family,$Connect)or die(mysql_error());
		while($row_family=mysql_fetch_array($result_family)){?>
          <div align="left">
            <input type="checkbox" name="checkbox[]" value="<?php echo $row_family['family_id'];?>" /><?php echo $row_family['family_name_th']."[".$row_family['family_name_eng']."]";?>
		 </div>
		<?php }?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
	  <tr>
        <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="disease_url" type="text" id="disease_url">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ที่มาของข้อมูล(เพิ่มเติม)</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="disease_url2" type="text" id="disease_url2">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25" valign="top"><div align="right"><strong>เนื้อหา</strong></div></td>
        <td height="25" valign="top"><div align="center">:</div></td>
        <td height="25" valign="top"><div align="left">
          <label>
          <textarea name="disease_detail" cols="40" rows="5" id="disease_detail"></textarea>
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
