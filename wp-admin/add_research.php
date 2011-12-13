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
  <form action="add_orchid_action.php" method="post" enctype="multipart/form-data" name="form1">
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="298" height="25"><div align="right">ชื่อเอกสาร/บทความ (ภาษาไทย)</div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left">
            <label>
            <input name="nameTH" type="text" id="nameTH">
            </label>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">ชื่อเอกสาร/บทความ (ภาษาอังกฤษ)</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="nameEN" type="text" id="nameEN">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">ชื่อผู้แต่ง /องค์กรที่จัดทำ</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="nameEN2" type="text" id="nameEN2">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">ผู้มีส่วนร่วมในการจัดทำเอกสาร</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="nameEN22" type="text" id="nameEN22">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">สำนักพิมพ์</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="nameEN222" type="text" id="nameEN222">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">ประเภทของเอกสาร</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <select name="select" id="select">
            <option>--select--</option>
            <option value="บทความ">บทความ</option>
            <option value="งานวิจัย">งานวิจัย</option>
            <?php while($row_family=mysql_fetch_array($result_family)){?>
            <?php }?>
                    </select>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">ชื่อวงศ์/สกุล </div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
         <?php $query_family="SELECT * FROM family ORDER BY FamilyID ASC";
		  		$result_family= mysql_query($query_family,$Connect)or die(mysql_error());
		?>
		  <select name="family_name" id="family_name">
		    <option>--select--</option>
		<?php while($row_family=mysql_fetch_array($result_family)){?>
		    <option value="<?php echo $row_family['FamilyID'];?>"><?php echo $row_family['FamilyName_TH'];?></option>
        <?php }?>  
		  </select>
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right">รายละเีอียด</div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label>
          <textarea name="detail" cols="70" rows="8" id="detail"></textarea>
          </label>
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
        <td height="25"><label>
          <input type="submit" name="Submit" value="Submit">
        &nbsp;&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="Reset">
        </label></td>
      </tr>
    </table>
    </form>
  <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
