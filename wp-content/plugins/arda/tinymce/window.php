<?php


require_once('../../../../wp-config.php');
require_once('../../../../wp-includes/functions.php');	


// check for rights
if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));

//global $wpdb, $nggdb;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>My Orchid</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo ORCHID_URL ?>/tinymce/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="MyOrchid" action="#">
	<!--<div class="tabs">
		<ul>
			<li id="search_tab" class="current"><span><a href="javascript:mcTabs.displayTab('search_tab','search_panel');" onmousedown="return false;"><?php echo _n( 'Gallery', 'Galleries', 1, 'nggallery' ) ?></a></span></li>
			<li id="album_tab"><span><a href="javascript:mcTabs.displayTab('album_tab','album_panel');" onmousedown="return false;"><?php echo _n( 'Album', 'Albums', 1, 'nggallery' ) ?></a></span></li>
		</ul>
	</div>-->
	
	<div >
		
		<!-- single pic panel -->
		<div>
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="orchidtag"><?php _e("Select Type", 'myorchid'); ?></label></td>
            <td><select id="orchidtag" name="orchidtag" style="width: 200px">
                <option value="0"><?php _e(" ", 'myorchid'); ?></option>
				<?php
					//$typeorchid = $wpdb->get_results("SELECT distinct typeorchid FROM arda.contents ORDER BY typeorchid");
					$typeorchid = $wpdb->get_results("SELECT distinct typeorchid FROM arda.setvariable ORDER BY typeorchid");
					if(is_array($typeorchid)) {
						foreach($typeorchid as $typeor) {
							echo '<option value="' . $typeor->typeorchid . '" >'. $typeor->typeorchid . ' - ' . $typeor->typeorchid.'</option>'."\n";
						}
					}
					$cate = $wpdb->get_results("SELECT distinct name as cate,term_taxonomy_id FROM orchid.wp_terms wpt,orchid.wp_term_taxonomy wptt 
									where wpt.term_id=wptt.term_id and  wptt.taxonomy ='category'  ORDER BY wpt.term_id");
					if(is_array($cate)) {
						foreach($cate as $catelog) {
							echo '<option value="Category-' . $catelog->term_taxonomy_id . '" >'. $catelog->term_taxonomy_id . ' - ' . $catelog->cate.'</option>'."\n";
						}
					}
				?>
            </select></td>
          </tr>
        </table>
		</div>
		<!-- single pic panel -->
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'myorchid'); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'myorchid'); ?>" onclick="insertOrchidLink();" />
		</div>
	</div>
</form>
</body>
</html>
