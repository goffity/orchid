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

	$RID=$_REQUEST['RID'];
	
	$sql="SELECT * FROM research_content WHERE rc_content_id='".$RID."' ";
	$result=mysql_query($sql,$Connect) or die(mysql_error());
	$row=mysql_fetch_array($result);


/** Load WordPress dashboard API */

require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'เพิ่มงานวิจัยกล้วยไม้' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'media-upload' );
wp_admin_css( 'เพิ่มงานวิจัยกล้วยไม้' );
wp_admin_css( 'plugin-install' );
add_thickbox();

$title = __('เพิ่มงานวิจัยกล้วยไม้');
$parent_file = 'add_research.php';

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


<div class="wrap">
<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">
<p>&nbsp;</p>
  <form action="add_research_action.php" method="post" enctype="multipart/form-data" name="form1" onReset="resetDates()" onSubmit="return chk_submit()">
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="298" height="25"><div align="right"><strong>ชื่อเอกสาร/บทความ (ภาษาไทย)</strong></div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left"><?php echo $row['rc_title_th'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อเอกสาร/บทความ (ภาษาอังกฤษ)</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $row['rc_title_eng'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong> สกุล </strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
		<?php 
			$sql_family="SELECT family.family_name_th AS fam_th,
								family.family_name_eng as fam_en
						FROM family
						LEFT JOIN research_content
						ON(family.family_id = research_content.family_id )
						WHERE research_content.rc_content_id ='".$row['rc_content_id']."'
			";
			
			$result_family = mysql_query($sql_family,$Connect) or die(mysql_error());
			
			while($row_family=mysql_fetch_array($result_family))
			{
				echo $row_family['fam_th']."[".$row_family['fam_en']."], ";
			}
			
		?>

        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อผู้แต่ง / องค์กรที่จัดทำ / ผู้จัดทำงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $row['rc_creator'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้เผยแพร่ </strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $row['rc_publisher'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>คำสำคัญหรือดัชนีของเอกสาร</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_keyword'];?></div></td>
      </tr>
      <tr>
        <td height="97" valign="top"><div align="right"><strong>รายละเอียดเอกสารงานวิจัย</strong></div></td>
        <td height="97" valign="top"><div align="center">:</div></td>
        <td height="97" valign="top"><div align="left">
          <?php echo $row['rc_description'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_contributor1'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย 1</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_contributor2'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย 2</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_contributor3'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>วัน / เดือน / ปี ที่เผยแพร่งานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left"><?php echo $row['rc_date'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชนิดของงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_type'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มาของข้อมูล  เว็บไซด์</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_identifer'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_source'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ภาษาที่ใช้ในเอกสารงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_language'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มาเพิ่มเติม</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_relation'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>รายละเอียดเกี่ยวกับลิขสิทธิ์ของเอกสาร</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <?php echo $row['rc_rights'];?></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left">
          <label>&nbsp;&nbsp;&nbsp;<a href="edit_research.php?RID=<?php echo $RID;?> ">แก้ไขข้อมูล</a></label>
        </div></td>
      </tr>
      <tr>
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
        <td height="25"><label>&nbsp;&nbsp;&nbsp;</label></td>
      </tr>
    </table>
    </form>
  <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
