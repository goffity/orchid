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

wp_enqueue_script( 'พันธุ์กล้วยไม้' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'media-upload' );
wp_admin_css( 'พันธุ์กล้วยไม้' );
wp_admin_css( 'plugin-install' );
add_thickbox();

$title = __('พันธุ์กล้วยไม้');
$parent_file = 'view_orchid.php';

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

?><div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">
<p>&nbsp;</p>
<?php 
	$orchidID=$_REQUEST['orchidID'];
	
	$show_query="SELECT * FROM orchid_varity WHERE orchid_id='".$orchidID."'";
	$show_result=mysql_query($show_query,$Connect)or die(mysql_error());
	$show_row=mysql_fetch_array($show_result);
	
?>
    
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="177" height="25"><div align="left"><p align="left"><a href="manage_orchid.php">&lt;&lt; กลับ</a> </p>
        </div></td>
        <td width="14" height="25"><div align="center"></div></td>
        <td width="701" height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td width="177" height="25"><div align="right"><strong>ชื่อพันธุ์ภาษาไทย</strong></div></td>
        <td width="14" height="25"><div align="center">:</div></td>
        <td width="701" height="25"><div align="left">
          <?php echo $show_row['orchid_name_th'];?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อพันธุ์ภาษาอังกฤษ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $show_row['orchid_name_eng'];?></div></td>
      </tr>

      <tr>
        <td height="25"><div align="right"><strong>ชื่ออื่นๆ</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <?php 
			$sql="SELECT * FROM search_key WHERE key_id='".$show_row['KeywordID']."' AND search_type_id = 'st004' ORDER BY key_id ASC";
			$result=mysql_query($sql,$Connect)or die(mysql_error());
			
			while($row=mysql_fetch_array($result)){
				echo $row['key_name']." ,";
		 }?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>สกุล</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
         <?php $query_family="SELECT family_name_th, family_name_eng FROM family WHERE family_id='".$show_row['family_id']."'";
		  		$result_family= mysql_query($query_family,$Connect)or die(mysql_error());
				$row_family=mysql_fetch_array($result_family);
		echo $row_family['family_name_th']." [".$row_family['family_name_eng']."]";
		?>
		</div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>เว็บไซต์ที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left" style="padding-left:5px; padding-right:5px;"><a href="<?php echo $show_row['orchid_url'];?>" target="_blank"><?php echo $show_row['orchid_url'];?></a></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>รายละเีอียด</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left" style="padding-left:5px; padding-right:5px;">
          <?php echo $show_row['orchid_content1'];?>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25"><label>&nbsp;&nbsp;&nbsp;<a href="#">แก้ไขข้อมูล</a></label></td>
      </tr>
    </table>
  <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
