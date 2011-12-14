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

<script type="text/javascript">

function del(varUrl)
{
	if(window.confirm("Confirm Delete!!!")==true)
	{
		window.open(varUrl,"_self")
	}
}

</script>

<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">
    <p>
      <?php 
	$sql="SELECT 
				orchid_varity.orchid_id AS orchidID,
				orchid_varity.orchid_name_th AS orchidTH,
				orchid_varity.ochid_name_eng AS orchidEN,
				orchid_varity.orchid_url AS orchidRef,
				family.family_name_th AS famName
	 FROM orchid_varity 
			LEFT JOIN family 
	ON (orchid_varity.family_id = family.family_id)
	ORDER BY orchid_varity.orchid_id ASC
	";
	$result=mysql_query($sql,$Connect)or die(mysql_error());
?>
    </p>
    <p align="center"><a href="add_orchid.php">เพิ่มพันธุ์กล้วยไม้</a></p>
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="38" height="30" style="background-color:#C8D5E4;"><div align="center">No.</div></td>
        <td width="409" height="30" style="background-color:#C8D5E4;"><div align="center">ชื่อพันธุ์กล้วยไม้</div></td>
        <td width="372" height="30" style="background-color:#C8D5E4;"><div align="center">สกุล</div></td>
        <td width="171" height="30" style="background-color:#C8D5E4;"><div align="center">Manage</div></td>
      </tr>
<?php 
$count=1;
	while($row=mysql_fetch_array($result)){
	
	//$sql2="SELECT * FROM key_refference WHERE ";
?>
	  <tr style="background:<? if($count % 2 == 0){echo "#EAF3FF;";} else{echo "#FFFFFF;";}?>">
        <td height="25" style="padding-left:5px;"><div align="left"><?php echo $count;?></div></td>
        <td height="25" style="padding-left:5px;"><div align="left"><?php echo $row['orchidTH']."[".$row['orchidEN']."]";?></div></td>
        <td height="25" style="padding-left:5px;"><div align="left"><?php echo $row['famName'];?></div></td>
        <td height="25" style="padding-left:5px;"><div align="left"><a href="view_orchid.php?orchidID=<?php echo $row['orchidID']?>">View</a>&nbsp;|&nbsp;<a href="#" onClick= "del('action.php?do=del_orchid&orchidID=<?php echo $row['orchidID']?>&nameTH=<?php echo $row['orchidTH'];?>&nameEN=<?php echo $row['orchidEN'];?>')">Delete</a></div></td>
      </tr>
<?php $count++;}?>	  
    </table>
	<p>&nbsp;</p>
	
	<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>