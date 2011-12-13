<?php
/*
Plugin Name: Orchid Web Portal
Plugin URI: http://www.uknoecenter.org
Description: Plugin is Orchid Web Portal
Author: Vasuthep Khunthong 
Version: 1.0
Author URI: http://www.uknoecenter.org
*/


define( 'ORCHID_FOLDER', 'arda' );

// Mu-plugins or regular plugins ?
 if ( is_dir( WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . ORCHID_FOLDER ) ) {
	define ( 'ORCHID_DIR', WPMU_PLUGIN_DIR . DIRECTORY_SEPARATOR . ORCHID_FOLDER );
	define ( 'ORCHID_URL', WPMU_PLUGIN_URL . '/' . ORCHID_FOLDER );
} else {
	define ( 'ORCHID_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . ORCHID_FOLDER );
	define ( 'ORCHID_URL', WP_PLUGIN_URL . '/' . ORCHID_FOLDER );
}

/**
 * This function outputs the plugin options page.
 */


if (!function_exists('wporchid_options_page')) :
// Define the function
function wporchid_options_page() {
	require( ORCHID_DIR . '/form/index.php'); 		// Client class

} // End of wporchid_options_page() function definition
endif;

if (!function_exists('wporchid_curl_data')) :
// Define the function
function wporchid_curl_data() {
	echo "<h2>" . __( 'Curl Data to Database', 'arda-menu' ) . "</h2>";
	require( ORCHID_DIR . '/import_content_chkdb.php'); 		// Client class
} // End of wporchid_curl_data() function definition
endif;

if (!function_exists('wporchid_ontology')) :
// Define the function
function wporchid_ontology() {
	echo "<h2>" . __( 'Manage Ontology\'s Orchid', 'arda-menu' ) . "</h2>";
	//require( ORCHID_DIR . '/term/tree.php'); 		// Client class
	echo'<a href="'.plugins_url("/arda/term/tree.php").'"  class="wp-first-item" tabindex="1">Manage Ontology</a>';
} // End of wporchid_ontology() function definition
endif;

/**
 * This function adds the required page (only 1 at the moment).
 */
/*if (!function_exists('wporchid_menus')) :
function wporchid_menus() {
	
	if (function_exists('add_submenu_page')) {
		add_options_page("Manage Content For Curl","Config Curl",'manage_options',__FILE__,'wporchid_options_page');
		add_options_page("Curl Data to Database","Curl Data",'manage_options',__FILE__,'wporchid_curl_data');
	}
	
} // End of wporchid_menus() function definition
endif;*/


add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new top-level menu (ill-advised):
    add_menu_page(__('Orchid Option','arda-menu'), __('Orchid Option','arda-menu'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Manage Content For Curl','arda-menu'), __('Config Web','arda-menu'), 'manage_options', 'sub-page', 'wporchid_options_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Curl Data to Database','arda-menu'), __('Curl Data','arda-menu'), 'manage_options', 'sub-page2', 'wporchid_curl_data');
	
	// Add a second submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Manage Ontology\'s Orchid','arda-menu'), __('Manage Ontolgy','arda-menu'), 'manage_options', 'sub-page3', 'wporchid_ontology');
}

function mt_toplevel_page() {
    echo "<h2>" . __( 'Orchid Option', 'arda-menu' ) . "</h2>";
	require( ORCHID_DIR . '/submenu.php');
}

function wporchid_plugin_action_links( $links, $file ) {
	if ( $file != plugin_basename( __FILE__ ))
		return $links;

	$settings_link = '<a href="options.php?page=arda/arda.php">' . __( 'Settings' ) . '</a>';
	//$settings_link = '<a href="options.php?page=arda/arda.php">' . __( 'Settings' ) . '</a>';

	array_unshift( $links, $settings_link );
	/*if ( $file != plugin_basename( __FILE__ )){
		$links[]='<a href="options.php?page=arda/arda.php">' . __( 'Settings','arda' ) . '</a>';
		$links[]='<a href="options.php?page=arda/import_content_chkdb">' . __( 'Curl Data','arda' ) . '</a>';
	}*/

	return $links;
}

 
function getContent_orchid($content) {
	 //------Function knowledge_orchid -------
			//if(!function_exists('knowledge_orchid_search')){
				include ORCHID_DIR ."/show/index.php"; 	//แสดงผล
				include ORCHID_DIR ."/show/content_report_chkdb.php"; 	//แสดงผล
			//}
	//------Function knowledge_orchid -------
	preg_match_all('#\[orchid([^\]]*?)\]#i', $content, $found);
	for ($i=0; $i< count($found[0]);$i++) {
		
		$varstring=$found[0][$i];
		//echo "<br>parse".$varstring."<br>";
		//echo "<br>value".substr($varstring,1,strlen("[orchid type:")-1)."<br>";
		//if($varstring=="[orchid]"){
		if(substr($varstring,1,strlen("[orchid search:")-1)=="orchid search:"){
			$typeorchid=orchid_post_type($varstring,"[orchid search:");
			$formstr=knowledge_orchid_search($typeorchid,1);
			$content = str_replace($found[0][0],$formstr,$content);
		}elseif (substr($varstring,1,strlen("[orchid type:")-1)=="orchid type:"){
			$typeorchid=orchid_post_type($varstring,"[orchid type:");
			if($typeorchid=="KM" || $typeorchid=="Research"){
				$formstr=knowledge_orchid_search($typeorchid,2);
				$content = str_replace($found[0][0],$formstr,$content);
			}elseif(substr($typeorchid,0,strlen("Report"))=="Report"||substr($typeorchid,0,strlen("Price"))=="Price" ){
				
				$q_rand=rand();
				$typeor=split(":",$typeorchid);
				$formstr=report_curl($typeor[0],$typeor[1],$typeor[2],0,$q_rand);
				$content = str_replace($found[0][0],$formstr,$content);
			}elseif(substr($typeorchid,0,strlen("Category"))=="Category"){
				$typeorchid=orchid_post_type($varstring,"[orchid type:");
				$formstr=knowledge_orchid_search($typeorchid,1);
				$content = str_replace($found[0][0],$formstr,$content);
			}
		}else{
			$content=$content;
		}
	}	
	return $content;
}
function orchid_post_type( $typeorchids,$check ) {
		//echo "<br>type:=".$typeorchids."===".$check."<br>";
		$typeorchid = substr(trim( $typeorchids), strlen($check),strlen($typeorchids)-strlen($check)-1);
		//echo "<br>value:=".$typeorchid."<br>";
	return $typeorchid;		
}

function getOntology_orchid() {
	include ORCHID_DIR ."/term/menu.php";
}
	add_filter('widget_content', 'getOntology_orchid',1, 2);

	// Add the create pages options
	//add_action('admin_menu','wporchid_menus');
	//add_action('admin_menu','wporchid_menus1');
	// Adds "Settings" link to the plugin action page
	add_filter( 'plugin_action_links', 'wporchid_plugin_action_links',10,2);
	add_filter('the_content', 'getContent_orchid');

//*************Add button ******************
function myorchid_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_myorchid_tinymce_plugin",6);
     add_filter('mce_buttons', 'register_myorchid_button',6);
   }
}
 
function register_myorchid_button($buttons) {
   array_push($buttons, "separator", "myorchid");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_myorchid_tinymce_plugin($plugin_array) {
   $plugin_array['myorchid'] = ORCHID_URL.'/tinymce/editor_plugin.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'myorchid_addbuttons');
//********************* finish add button *******************

//load_plugin_textdomain('wp_mail_smtp', false, dirname(plugin_basename(__FILE__)) . '/langs');

?>
