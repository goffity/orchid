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

<link rel="stylesheet" type="text/css" media="all" href="themes/winxp.css" title="Calendar Theme - winxp.css" >
<script type="text/javascript" src="src/utils.js"></script>
<script type="text/javascript" src="src/calendar.js"></script>
<script type="text/javascript" src="lang/calendar-en.js"></script>
<script type="text/javascript" src="src/calendar-setup.js"></script>

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
		alert("กรุณากรอก ชื่องานวิจัย /บทความ (ภาษาไทย)" );
		window.document.form1.nameTH.focus();
		return false;
	}
	else if(window.document.form1.orchid_family.value.length == 0)
	{
		alert("กรุณาเลือก สกุล" );
		window.document.form1.orchid_family.focus();
		return false;
	}
	else if(window.document.form1.creator.value.length == 0)
	{
		alert("กรุณากรอก ชื่อผู้แต่ง / องค์กรที่จัดทำ / ผู้จัดทำงานวิจัย" );
		window.document.form1.creator.focus();
		return false;
	}
	else if(window.document.form1.rc_description.value.length == 0)
	{
		alert("กรุณากรอก รายละเอียดเอกสารงานวิจัย" );
		window.document.form1.rc_description.focus();
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
  <form action="edit_research_action.php" method="post" enctype="multipart/form-data" name="form1" onReset="resetDates()" onSubmit="return chk_submit()">
    <table width="900" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="298" height="25"><div align="right"><strong>ชื่องานวิจัย/บทความ (ภาษาไทย)</strong></div></td>
        <td width="23" height="25"><div align="center">:</div></td>
        <td width="571" height="25"><div align="left">
            <label>
            <input name="nameTH" type="text" id="nameTH" value="<?php echo $row['rc_title_th'];?>">
            </label>
            <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่องานวิจัย/บทความ (ภาษาอังกฤษ)</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="nameEN" type="text" id="nameEN" value="<?php echo $row['rc_title_eng'];?>">
        </div></td>
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
          <?php while($row_family=mysql_fetch_array($result_family)){?>
          <option <?php if($row_family['family_id'] == $row['family_id']){echo ' selected="selected" ';}?> value="<?php echo $row_family['family_id']?>"><?php echo $row_family['family_name_th']."(".$row_family['family_name_eng'].")";?></option>
          <?php }?>
        </select>
        <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชื่อผู้แต่ง / องค์กรที่จัดทำ / ผู้จัดทำงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="creator" type="text" id="creator" value="<?php echo $row['rc_creator'];?>">
          <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>หน่วยงานที่เผยแพร่  </strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="rc_publisher" type="text" id="rc_publisher" value="<?php echo $row['rc_publisher'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>คำสำคัญหรือดัชนีของเอกสาร</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <input name="rc_keyword" type="text" id="rc_keyword" value="<?php echo $row['rc_keyword'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25" valign="top"><div align="right"><strong>รายละเอียดเอกสารงานวิจัย</strong></div></td>
        <td height="25" valign="top"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <textarea name="rc_description" cols="70" rows="10" id="rc_description"><?php echo $row['rc_description'];?></textarea>
          <span class="style1">*</span></div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_contributor1" type="text" id="rc_contributor1" value="<?php echo $row['rc_contributor1'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_contributor2" type="text" id="rc_contributor2" value="<?php echo $row['rc_contributor2'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ผู้มีส่วนร่วมในงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_contributor3" type="text" id="rc_contributor3" value="<?php echo $row['rc_contributor3'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>วัน / เดือน / ปี ที่เผยแพร่งานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          	<input name="date8a" type="text" class="formpanel2" id="departure_date" value="<?php echo $row['rc_date'];?>" />
			<input type="reset" class="formpanel2" id='button8a' value=" ... "  />
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ชนิดของงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_type" type="text" id="rc_type" value="<?php echo $row['rc_type'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มาของข้อมูล  เว็บไซด์</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_identifer" type="text" id="rc_identifer" value="<?php echo $row['rc_identifer'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มา</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_source" type="text" id="rc_source" value="<?php echo $row['rc_source'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>ภาษาที่ใช้ในเอกสารงานวิจัย</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_language" type="text" id="rc_language" value="<?php echo $row['rc_language'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>แหล่งที่มาเพิ่มเติม</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_relation" type="text" id="rc_relation" value="<?php echo $row['rc_relation'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"><strong>รายละเอียดเกี่ยวกับลิขสิทธิ์ของเอกสาร</strong></div></td>
        <td height="25"><div align="center">:</div></td>
        <td height="25"><div align="left">
          <label></label>
          <input name="rc_rights" type="text" id="rc_rights" value="<?php echo $row['rc_rights'];?>">
        </div></td>
      </tr>
      <tr>
        <td height="25"><div align="right"></div></td>
        <td height="25"><div align="center"></div></td>
        <td height="25"><div align="left"></div></td>
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
          <input type="submit" name="Submit" value="แก้ไข">
        &nbsp;&nbsp;&nbsp;
        <input type="reset" name="Submit2" value="ยกเลิก">
        <input type="hidden" name="RID" value="<?php echo $RID;?>" />
        <input type="hidden" name="chk_edit" value="YES" />
        </label></td>
      </tr>
    </table>
    </form>
  <div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->
	<script type="text/javascript">
		<!--  to hide script contents from old browsers
		var startDate;
		var endDate;
		var ONEDAY = 3600 * 24;

		function resetDates() {
			startDate = endDate = null;
		}
		// end hiding contents from old browsers  -->
		
		var cal = new Zapatec.Calendar.setup({
		
			inputField     :    "departure_date",   // id of the input field
			button         :    "button8a",  // What will trigger the popup of the calendar
			ifFormat       :    "%Y-%m-%d ",       //  of the input field
			showsTime      :     false,      //no time
			//saveDate       :    2            // save for two days
			saveDate       :    0   
		});
			
	</script>

<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
