<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
Plugin Name: Tag Search
Plugin URI: http://www.themestown.com
Description: This plugin finds tags in post and autolinks them to display search results for all posts found to contain the tagged word or phrase.
Version: 1.5
Author: A Lewis
Author URI: http://www.themestown.com
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*  Copyright 2010  A. Lewis  (email : themestown@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

$wpcontenturl=WP_CONTENT_URL;
$wpcontentdir=WP_CONTENT_DIR;



$tttagsearch_plugin_path = WP_CONTENT_DIR.'/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$tttagsearch_plugin_url = WP_CONTENT_URL.'/plugins/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

$tttagsearchdb_version = "1.5";

define('TTTAGSEARCH', 'Tag Search');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add actions and filters etc
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	add_action('init', 'tttagsearchinstall');
	add_action('admin_menu', 'tttag_search_launch');	
	add_filter("the_content", "tt_linkthetag");
	add_filter("wp_footer", "ttcredit");

$tttagsearchconfigoptionsprefix="tttagsearch";
$yesnooptions=array("yes","no");
$onoffoptions=array("on","off");
$maxlinksops=range(1,100);

$def_tttag_search_config_options = array (

array("name" => "Tag Search settings",
"type" => "titles"),

array("name" => "Number of times to link same tag in single post",
"id" => $tttagsearchconfigoptionsprefix."_link_tag_how_many_times",
"std" => "1",
"type" => "select",
"options" => $maxlinksops),

array("name" => "Should tags be autolinked on static pages?",
"id" => $tttagsearchconfigoptionsprefix."_autolinkstaticpages",
"std" => "1",
"type" => "select",
"options" => $yesnooptions),

array("name" => "Tag Search On Off Switch",
"id" => $tttagsearchconfigoptionsprefix."_onoffstate",
"std" => "1",
"type" => "select",
"options" => $onoffoptions),

array("name" => "Give credit to plugin author",
"id" => $tttagsearchconfigoptionsprefix."_credit_plugin_author",
"std" => "yes",
"type" => "select",
"options" => $yesnooptions)
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// PROGRAM FUNCTIONS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function tttagsearchinstall()
{

	global $wpdb,$tttagsearchdb_version;
	
	$installed_ver = get_option( "tttagsearchdb_version" );


    	if(!isset($installed_ver) || empty($installed_ver)){add_option("tttagsearchdb_version", $tttagsearchdb_version);}
    	else{update_option("tttagsearchdb_version", $tttagsearchdb_version);}
}


function tttag_search_launch()
{
	global $tttag_search_plugin_path;
	add_menu_page(TTTAGSEARCH, 'Tag Search', 'activate_plugins', 'tt-tag-search.php', 'tttagsearch_home_screen', '');
	add_submenu_page('tt-tag-search.php', 'Manage Options ', 'Manage Options', 'activate_plugins', 'tttag_search_c1', 'tttag_search_config_admin');
	add_submenu_page('tt-tag-search.php', 'Uninstall Tag Search', 'Uninstall', 'activate_plugins', 'tttag_search_m1', 'tttag_search_uninstall');
}

function tt_linkthetag($content)
{

	global $post,$tttagsearchconfigoptionsprefix;
	$tttagsearch_options=get_tttagsearch_options();
	if(isset($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_link_tag_how_many_times']) && !empty($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_link_tag_how_many_times']))
	{
		$link_how_many=$tttagsearch_options[$tttagsearchconfigoptionsprefix.'_link_tag_how_many_times'];
	}
	
	if(isset($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_autolinkstaticpages']) && !empty($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_autolinkstaticpages']))
	{
		$autolinkstaticpages=$tttagsearch_options[$tttagsearchconfigoptionsprefix.'_autolinkstaticpages'];
	}

	if(isset($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_onoffstate']) && !empty($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_onoffstate']))
	{
		$ttagsearchonoffstate=$tttagsearch_options[$tttagsearchconfigoptionsprefix.'_onoffstate'];
	}
	
	if(!isset($link_how_many) || empty($link_how_many)){$link_how_many=1;}
	if(!isset($ttagsearchonoffstate) || empty($ttagsearchonoffstate)){$ttagsearchonoffstate="on";}
	
	$siteurl=get_option('siteurl');

	
	$tttags=get_tags('hide_empty=false');
	//print_r($tttags);
	
	if(isset($ttagsearchonoffstate) && !empty($ttagsearchonoffstate) && ($ttagsearchonoffstate == 'on'))
	{
	
		if($tttags)
		{
			foreach ($tttags as $tttag)
			{
				$thetags[]=$tttag->name;
			}
		}

		if($thetags)
		{
			foreach ($thetags as $thetag)
			{
				if( isset($autolinkstaticpages) && !empty($autolinkstaticpages) && ($autolinkstaticpages == "yes"))
				{		
					if(strstr($content," $thetag"))
					{
						$thetagfs=str_replace(" ","+",$thetag);
						$linkedtag="<a href=\"$siteurl?s=$thetagfs\">$thetag</a>";
						$content = preg_replace('/\b'.$thetag.'\b(?![^<]+>)/i', $linkedtag, $content,$link_how_many);
						


					}		
				}
				else
				{
					if(!is_page() && (strstr($content," $thetag")))
					{
						$thetagfs=str_replace(" ","+",$thetag);
						$linkedtag="<a href=\"$siteurl?s=$thetagfs\">$thetag</a>";
						$content = preg_replace('/\b'.$thetag.'\b(?![^<]+>)/i', $linkedtag, $content,$link_how_many);

					}
				}
			}
		}
	
		
	}

	return $content;
}



function ttcredit()
{

	global $tttagsearchconfigoptionsprefix;
	$tttagsearch_options=get_tttagsearch_options();
	if(isset($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_credit_plugin_author']) && !empty($tttagsearch_options[$tttagsearchconfigoptionsprefix.'_credit_plugin_author'])){
	$givepluginauthorcredit=$tttagsearch_options[$tttagsearchconfigoptionsprefix.'_credit_plugin_author'];
	}

	$ttcredit="<a style=\"font-size:9px;text-decoration:none;\" href=\"http://themestown.com/groups/tag-seach-plugin/\">Tag Search</a> <font style=\"font-size:9px;text-decoration:none;\">via</font> <a style=\"font-size:9px;text-decoration:none;\" href=\"http://www.themestown.com\"> Themes Town</a>";
	$myttcredit="<div style=\"text-align:center;display:block;padding:3px;\">$ttcredit</div>";
	
	if(isset($givepluginauthorcredit) && !empty($givepluginauthorcredit) && ($givepluginauthorcredit == "no")){}else{echo $myttcredit;}
}

function tttagsearch_home_screen()
{
	global $tttagsearchdb_version;
	echo "<h3 style=\"padding:10px;\">";
	_e("Thank you for using Tag Search plugin for WordPress","ttagse");
	echo "</h3><p>";
	_e("You are using version","ttagse");
	echo " <b>$tttagsearchdb_version</b> </p>";
	tttag_search_config_admin();


}
function get_tttagsearch_options()
{
	$mytttag_search_config_options=array();
	global $tttagsearchconfigoptionsprefix;

	$pstandtttag_search_config_options=get_option($tttagsearchconfigoptionsprefix.'_settings_config');
	
	if(isset($pstandtttag_search_config_options) && !empty($pstandtttag_search_config_options))
	{
		foreach ($pstandtttag_search_config_options as $pstandoption)
		{
			if(isset($pstandoption['id']) && !empty($pstandoption['id']))
			{
				$mytttag_search_config_options[$pstandoption['id']]=$pstandoption['std'];
			}

		}
	}
	
	return $mytttag_search_config_options;
}

function tttag_search_config_check_for_tttag_search_config_options()
{
	global $tttagsearchconfigoptionsprefix,$def_tttag_search_config_options,$poststatusoptions,$yesnooptions,$categoryorderoptions,$categorysortoptions;
	$tttagsearchconfigoptions=$tttagsearchconfigoptionsprefix.'_settings_config';
	$mysavedthemetttag_search_config_options=get_option($tttagsearchconfigoptions);
		
		$tttag_search_config_options = $mysavedthemetttag_search_config_options;
		
		if (!isset($tttag_search_config_options) || empty($tttag_search_config_options) || !is_array($tttag_search_config_options)) 
		{			
			$tttag_search_config_options = $def_tttag_search_config_options;

			foreach ($tttag_search_config_options as $optionvalue)
			{			
				if(!isset($optionvalue['id']) || empty($optionvalue['id']))
				{
					$optionvalue['id']='';
				}
				if(!isset($optionvalue['tttag_search_config_options']) || empty($optionvalue['tttag_search_config_options']))
				{
					$optionvalue['tttag_search_config_options']='';
				}
				if(!isset($optionvalue['std']) || empty($optionvalue['std']))
				{
					$optionvalue['std']='';
				}
				
					$setmytttag_search_config_options[]=array("name" => $optionvalue['name'],
					"id" => $optionvalue['id'],
					"std" => $optionvalue['std'],
					"type" => $optionvalue['type'],
					"options" => $optionvalue['options']);						

			}
			
			update_option($tttagsearchconfigoptions,$setmytttag_search_config_options);
		}	
}

function tttag_search_config_reconcile_options()
{
	global $tttagsearchconfigoptionsprefix,$def_tttag_search_config_options,$poststatusoptions,$yesnooptions,$categoryorderoptions,$categorysortoptions;
	$tttagsearchconfigoptions=$tttagsearchconfigoptionsprefix.'_settings_config';
	$tttag_search_config_options=get_tttagsearch_options();

			$setmytttag_search_config_options=array();
			

				foreach ($def_tttag_search_config_options as $optionvalue)
				{
				
					if(!isset($optionvalue['id']) || empty($optionvalue['id']))
					{
						$optionvalue['id']='';
					}
					if(!isset($optionvalue['tttag_search_config_options']) || empty($optionvalue['tttag_search_config_options']))
					{
						$optionvalue['tttag_search_config_options']='';
					}
					if(!isset($optionvalue['name']) || empty($optionvalue['name']))
					{
						$optionvalue['name']='';
					}
					if(!isset($optionvalue['std']) || empty($optionvalue['std']))
					{
						$optionvalue['std']='';
					}
								
					
					if(isset($tttag_search_config_options[$optionvalue['id']]) && !empty($tttag_search_config_options[$optionvalue['id']]))
					{
						$savedoptionvalue=$tttag_search_config_options[$optionvalue['id']];
					}
					elseif(isset($optionvalue['std']) && !empty($optionvalue['std']))
					{
						$savedoptionvalue=$optionvalue['std'];
					}
					else
					{
						$savedoptionvalue='';
					}
					$setmytttag_search_config_options[]=array("name" => $optionvalue['name'],
					"id" => $optionvalue['id'],
					"std" => $savedoptionvalue,
					"type" => $optionvalue['type'],
					"options" => $optionvalue['options']);					
				}
			
				update_option($tttagsearchconfigoptions,$setmytttag_search_config_options);			
		
}

function tttag_search_config_admin() {
global $tttagsearchconfigoptionsprefix, $def_tttag_search_config_options,$yesnooptions;

tttag_search_config_reconcile_options();

//Begin the saving procedures
	$tttagsearchconfigoptions=$tttagsearchconfigoptionsprefix.'_settings_config';
	$mysavedthemetttag_search_config_options=get_option($tttagsearchconfigoptions);
		
		$tttag_search_config_options = $mysavedthemetttag_search_config_options;
		
		if (!isset($tttag_search_config_options) || empty($tttag_search_config_options) || !is_array($tttag_search_config_options)) 
		{			
			$tttag_search_config_options = $def_tttag_search_config_options;

			if($tttag_search_config_options)
			{
				foreach ($tttag_search_config_options as $optionvalue)
				{			
					if(isset($optionvalue['id']) && !empty($optionvalue['id']))
					{
						$savedoptionvalue=get_option($optionvalue['id']);	
						if(!isset($savedoptionvalue) || empty ($savedoptionvalue))
						{
							$savedoptionvalue=$optionvalue['std'];
						}

						$setmytttag_search_config_options[]=array("name" => $optionvalue['name'],
						"id" => $optionvalue['id'],
						"std" => $savedoptionvalue,
						"type" => $optionvalue['type'],
						"options" => $optionvalue['options']);						

						delete_option($optionvalue['id']);
					}
				}
			}
			
			update_option($tttagsearchconfigoptions,$setmytttag_search_config_options);
		}	

		if( isset($_REQUEST['action']) && ( 'updatetttag_search_config_options' == $_REQUEST['action'] ))
		{
			$myoptionvalue='';

			foreach ($tttag_search_config_options as $optionvalue)
			{	
			
				if(isset($optionvalue['id']) && !empty($optionvalue['id']))
				{
					if( isset( $_REQUEST[ $optionvalue['id'] ] ) )
					{				
						$myoptionvalue = $_REQUEST[ $optionvalue['id'] ];
					}
				}
				
				if(!isset($optionvalue['options']) || empty($optionvalue['options']))
				{
					$optionvalue['options']='';
				}
				
				if(!isset($optionvalue['id']) || empty($optionvalue['id']))
				{
					$optionvalue['id']='';
				}				
				
				if(!isset($optionvalue['std']) || empty($optionvalue['std'] ))
				{
					$optionvalue['std']='';
				}
				
				
				$mytttag_search_config_options[]=array("name" => $optionvalue['name'],
				"id" => $optionvalue['id'],
				"std" => $myoptionvalue,
				"type" => $optionvalue['type'],
				"options" => $optionvalue['options']);				

			}
				update_option($tttagsearchconfigoptions,$mytttag_search_config_options);
				$tttag_search_config_optionsupdated=true;	

		}
		else if( isset($_REQUEST['action']) && ( 'reset' == $_REQUEST['action'] ))
		{
			update_option($tttagsearchconfigoptions,$def_tttag_search_config_options);
			$tttag_search_config_optionsreset=true;
		}
//End the saving procedures
if( isset($_REQUEST['saved']) && !empty( $_REQUEST['saved'] )) echo '<div id="message" class="updated fade"><p><strong>'.$myasfwpname.' settings saved.</strong></p></div>';
if ( isset($_REQUEST['reset']) && !empty( $_REQUEST['reset'] )) echo '<div id="message" class="updated fade"><p><strong>'.$myasfwpname.' settings reset.</strong></p></div>';

$tttag_search_config_options=get_tttagsearch_options();
$tttag_search_config_saved_options = get_option($tttagsearchconfigoptionsprefix.'_settings_config');
		
		if (!isset($tttag_search_config_saved_options) || empty($tttag_search_config_saved_options) || !is_array($tttag_search_config_saved_options)) 
		{
			$tttag_search_config_options = $def_tttag_search_config_options;
		}
		else
		{
			$tttag_search_config_options=$tttag_search_config_saved_options;
		}
		?>
  <div class="wrap">
  <h4><?php _e('Tag Search Settings','ttagse');?></h4>
  <form method="post">
    <?php foreach ($tttag_search_config_options as $value) { 
    
if ($value['type'] == "text") { ?>
    <div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">
      <div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
      <div style="width: 680px; float: left;">
        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px;" type="<?php echo $value['type']; ?>" value="<?php if ( $tttag_search_config_options[ $value['id'] ] != "") { echo stripslashes($tttag_search_config_options[ $value['id'] ]); } else { echo $value['std']; } ?>" />
      </div>
    </div>
    <?php } elseif ($value['type'] == "text2") { ?>
    <div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">
      <div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
      <div style="width: 680px; float: left;">
        <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px; height: 200px;" type="<?php echo $value['type']; ?>"><?php if ( $tttag_search_config_options[ $value['id'] ] != "") { echo stripslashes($tttag_search_config_options[ $value['id'] ]); } else { echo $value['std']; } ?>
</textarea>
      </div>
    </div>
    <?php } elseif ($value['type'] == "select") { ?>
    <div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">
      <div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
      <div style="width: 680px; float: left;">
        <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px;">
          <?php foreach ($value['options'] as $option) { ?>
          <option<?php if ( $tttag_search_config_options[ $value['id'] ] == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <?php } elseif ($value['type'] == "titles") { ?>
    <div style="float: left; width: 870px; padding: 15px; background-color:#2583AD; border: 1px solid #2583AD; color: #fff; font-size: 16px; font-weight: bold; margin-top: 25px;"> <?php echo $value['name']; ?> </div>
    <?php 
} 
}
?>
    <div style="clear: both;"></div>
    <p style="float: left;" class="submit">
      <input name="save" type="submit" value="Save changes" />
      <input type="hidden" name="action" value="updatetttag_search_config_options" />
    </p>
  </form>
  <form method="post">
    <p style="float: left;" class="submit">
      <input name="reset" type="submit" value="Reset" />
      <input type="hidden" name="action" value="reset" />
    </p>
  </form>
  <?php
}

?>