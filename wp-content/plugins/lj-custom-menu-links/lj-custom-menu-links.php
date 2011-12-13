<?php
/*
Plugin Name: LJ Custom Menu Links
Plugin URI: http://www.thelazysysadmin.net/software/wordpress-plugins/lj-custom-menu-links/
Description: LJ Custom Menu Links can be used to display custom links in your Wordpress Menu
Author: Jon Smith
Version: 2.5
Author URI: http://www.thelazysysadmin.net/
*/

class LJCustomMenuLinks {

  private $dbversion = "2.0";
  private $pluginversion = "2.5";

  private $defaults = array
    (
      'enabled' => true,
      'showlogout' => true,
      'showdynamiclinksadmin' => false,
      'showadvanced' => false,
      'custom_liclasswithsubmenu' => '',
      'custom_ulclassforsubmenu' => '',
      'use_wp_list_pages_filter' => true,
      'showdonate' => false
    );

  function LJCustomMenuLinks() {
    global $wpdb;

    $options = get_option('LJCustomMenuLinks');
    $table_name = $wpdb->prefix."ljcustommenulinks";

    if ($options === false) {
      $options = array();
    }

    foreach ($this->defaults as $key => $value) {
      if (!isset ($options[$key]))
        $options[$key] = $value;
    }

    register_activation_hook( __FILE__, array( &$this, 'db_install' ) );

    if ($options['use_wp_list_pages_filter']) {
      add_filter( 'wp_list_pages', array( &$this, 'wp_list_pages' ) );
    }    

    add_filter('_get_page_link', array( &$this, 'filter_link'), 100, 2);

    // admin menu
    add_action( 'admin_menu', array(&$this, 'admin_menu') );
    add_action( 'admin_menu', array(&$this, 'admin_menu_metabox'));
    
    add_action( 'save_post', array( &$this, 'save_post_data') );
    add_filter( 'plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
  }

  function admin_menu() {
    if ( function_exists('add_options_page') )
      add_options_page(__('LJ Custom Menu Links Configuration'), __('LJ Custom Menu Links'), 8, __FILE__, array(&$this, 'config'));
  }

  function config() {
    global $wpdb;

    $options = get_option('LJCustomMenuLinks');
    $table_name = $wpdb->prefix."ljcustommenulinks";

    if ($options === false) {
      $options = array();
    }

    foreach ($this->defaults as $key => $value) {
      if (!isset ($options[$key]))
        $options[$key] = $value;
    }

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    $link_id = isset($_GET['link_id']) ? $_GET['link_id'] : -1;

?>
<div class='wrap'>
<?php
  $displaymain = true;
  switch ($action) {
    case 'edit':
      $displaymain = false;

      $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d;", $link_id), ARRAY_A);
?>
  <h2>LJ Custom Menu Links | Edit Link</h2>
<div class="clear"></div>

<form action="" method="post" id="LJCustomMenuLinksEditForm" accept-charset="utf-8">
  <input type="hidden" name="action" value="editproc" />
  <input type="hidden" name="link_id" value="<?php echo $link_id; ?>" />
  <?php wp_nonce_field('LJCustomMenuLinks-edit'); ?>
  <table class="form-table">
      <tr class="form-field form-required">
        <th scope="row" valign="top"><label for="linktext">Link Text</label></th>

        <td><input name="linktext" id="linktext" type="text" value="<?php echo $row['text']; ?>" size="40" aria-required="true" /><br />
              <span class="description">The anchor text that is display for the link.</span></td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linkurl">URL</label></th>
        <td><input name="linkurl" id="linkurl" type="text" value="<?php echo $row['url']; ?>" size="40" /><br />
              <span class="description">The URL of the link ie. 'http://www.google.com.au'.</span></td>

      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linktarget">Parent</label></th>
        <td>
            <select name='linkparent' id='linkparent' class='postform' >
  <option value="-1">No Parent (Main Link)</option>
<?php
  echo $this->build_option($row['id'], $row['parent']);
?>
  </select>
  <br />
                  <span class="description">Defines structure within the menu links. <b>Please note. Your theme must support nested menus for this option to function.</b></span>
          </td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linktarget">Target</label></th>
        <td>
            <select name='linktarget' id='linktarget' class='postform' >
    <option value="_blank" <?php if ($row['target'] == '_blank') echo "selected='selected'"; ?>>New Blank Window</option>
    <option class="level-0" value="_self" <?php if ($row['target'] == '_self') echo "selected='selected'"; ?>>Open Link In Current Window</option>
  </select>
  <br />

                  <span class="description">Defines the behaviour of the link, choose to open a new window or stay in the current window.</span>
          </td>
      </tr>
  <tr valign="top">
  <th scope="row">Display Link</th>
  <td><fieldset><legend class="screen-reader-text"><span>Display Link</span></legend>
  <label for="linkdisplay">
  <input name="linkdisplay" type="checkbox" id="linkdisplay" value="1" <?php if ($row['display'] == 1) echo "checked='checked'"; ?> />
  Display the link in the menu.</label><br />
  </fieldset></td>
  </tr>
  <tr valign="top">
  <th scope="row">Only Logged In</th>
  <td><fieldset><legend class="screen-reader-text"><span>Only Logged In</span></legend>
  <label for="linkonlyloggedin">
  <input name="linkonlyloggedin" type="checkbox" id="linkonlyloggedin" value="1" <?php if ($row['only_logged_in'] == 1) echo "checked='checked'"; ?> />
  Use this setting to display the link only if a user is logged in.</label><br />
  </fieldset></td>
  </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linksortorder">Sort Order</label></th>
        <td><input name="linksortorder" id="linksortorder" type="text" value="<?php echo $row['sort_order']; ?>" size="40" /><br />
              <span class="description">The text entered here will be used to sort the links, can be a number or text.</span></td>

      </tr>

        </table>
  <p class="submit"><input type="submit" class="button-primary" name="submit" value="Update Link" /></p>
</form>
<?php
      break;
    case "editproc":
      check_admin_referer('LJCustomMenuLinks-edit');

      $link_id = $_REQUEST['link_id'];
      $link_text = $_REQUEST['linktext'];
      $link_url = $_REQUEST['linkurl'];
      $link_target = $_REQUEST['linktarget'];
      $link_display = isset($_REQUEST['linkdisplay']) ? $_REQUEST['linkdisplay'] : 0;
      $link_onlyloggedin = isset($_REQUEST['linkonlyloggedin']) ? $_REQUEST['linkonlyloggedin'] : 0;
      $link_sortorder = $_REQUEST['linksortorder'];
      $link_parent = $_REQUEST['linkparent'];

      $sql = "UPDATE $table_name ";
      $sql .= "SET text = %s, ";
      $sql .= "url = %s, ";
      $sql .= "target = %s, ";
      $sql .= "display = %d, ";
      $sql .= "only_logged_in = %d, ";
      $sql .= "sort_order = %s, ";
      $sql .= "parent = %d ";
      $sql .= "WHERE id = %d;";

      $wpdb->query($wpdb->prepare($sql,
                    $link_text,
                    $link_url,
                    $link_target,
                    $link_display,
                    $link_onlyloggedin,
                    $link_sortorder,
                    $link_parent,
                    $link_id));

      break;
    case "delete":
      $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

      if (!wp_verify_nonce($nonce, 'LJCustomMenuLinks-delete') ) die('Security check');

      $link_id = isset($_REQUEST['link_id']) ? $_REQUEST['link_id'] : -1;

      $this->delete_node($link_id);

      break;
    case "add":
      $displaymain = false;
?>
  <h2>LJ Custom Menu Links | Add Link</h2>
<div class="clear"></div>

<form action="" method="post" id="LJCustomMenuLinksAddForm" accept-charset="utf-8">
  <input type="hidden" name="action" value="addproc" />
  <?php wp_nonce_field('LJCustomMenuLinks-add'); ?>
  <table class="form-table">
      <tr class="form-field form-required">
        <th scope="row" valign="top"><label for="linktext">Link Text</label></th>

        <td><input name="linktext" id="linktext" type="text" size="40" aria-required="true" /><br />
              <span class="description">The anchor text that is display for the link.</span></td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linkurl">URL</label></th>
        <td><input name="linkurl" id="linkurl" type="text" size="40" /><br />
              <span class="description">The URL of the link ie. 'http://www.google.com.au'.</span></td>

      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linktarget">Parent</label></th>
        <td>
            <select name='linkparent' id='linkparent' class='postform' >
  <option value="-1">No Parent (Main Link)</option>
<?php
  echo $this->build_option();
?>
  </select>
  <br />
                  <span class="description">Defines structure within the menu links. <b>Please note. Your theme must support nested menus for this option to function.</b></span>
          </td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linktarget">Target</label></th>
        <td>
            <select name='linktarget' id='linktarget' class='postform' >
    <option value="_blank" selected="selected">New Blank Window</option>
    <option class="level-0" value="_self">Open Link In Current Window</option>
  </select>
  <br />
                  <span class="description">Defines the behaviour of the link, choose to open a new window or stay in the current window.</span>
          </td>
      </tr>
  <tr valign="top">
  <th scope="row">Display Link</th>
  <td><fieldset><legend class="screen-reader-text"><span>Display Link</span></legend>
  <label for="linkdisplay">
  <input name="linkdisplay" type="checkbox" id="linkdisplay" value="1" />
  Display the link in the menu.</label><br />
  </fieldset></td>
  </tr>
  <tr valign="top">
  <th scope="row">Only Logged In</th>
  <td><fieldset><legend class="screen-reader-text"><span>Only Logged In</span></legend>
  <label for="linkonlyloggedin">
  <input name="linkonlyloggedin" type="checkbox" id="linkonlyloggedin" value="1" />
  Use this setting to display the link only if a user is logged in.</label><br />
  </fieldset></td>
  </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="linksortorder">Sort Order</label></th>
        <td><input name="linksortorder" id="linksortorder" type="text" size="40" /><br />
              <span class="description">The text entered here will be used to sort the links, can be a number or text.</span></td>

      </tr>

        </table>
  <p class="submit"><input type="submit" class="button-primary" name="submit" value="Add Link" /></p>
</form>
<?php

      break;
    case "addproc":
      check_admin_referer('LJCustomMenuLinks-add');

      $link_text = $_REQUEST['linktext'];
      $link_url = $_REQUEST['linkurl'];
      $link_target = $_REQUEST['linktarget'];
      $link_display = isset($_REQUEST['linkdisplay']) ? $_REQUEST['linkdisplay'] : 0;
      $link_onlyloggedin = isset($_REQUEST['linkonlyloggedin']) ? $_REQUEST['linkonlyloggedin'] : 0;
      $link_sortorder = $_REQUEST['linksortorder'];
      $link_parent = $_REQUEST['linkparent'];

      $sql = "INSERT INTO $table_name (text, url, target, display, only_logged_in, sort_order, parent) ";
      $sql .= "VALUES (%s, %s, %s, %d, %d, %s, %d);";

      $wpdb->query($wpdb->prepare($sql,
                    $link_text,
                    $link_url,
                    $link_target,
                    $link_display,
                    $link_onlyloggedin,
                    $link_sortorder,
                    $link_parent));

      break;
    case "dynedit":
      $displaymain = false;
    
      $link_id = isset($_REQUEST['link_id']) ? $_REQUEST['link_id'] : -1;

      $pagedetails = get_page($link_id);

?>
<h2>LJ Custom Menu Links | Edit Dynamic Link</h2>
<div class="clear"></div>
<form action="" method="post" id="LJCustomMenuLinksEditForm" accept-charset="utf-8">
  <input type="hidden" name="action" value="dyneditproc" />
  <input type="hidden" name="link_id" value="<?php echo $link_id; ?>" />
  <?php wp_nonce_field('LJCustomMenuLinks-edit'); ?>
  <table class="form-table">
    <tr class="form-field form-required">
      <th scope="row" valign="top"><label for="pageid">Page ID</label></th>

      <td><?php echo $pagedetails->ID; ?></td>
    </tr>
    <tr class="form-field form-required">
      <th scope="row" valign="top"><label for="pagename">Page Name</label></th>

      <td><?php echo $pagedetails->post_title; ?></td>
    </tr>
    <tr class="form-field form-required">
      <th scope="row" valign="top"><label for="linkurl">URL</label></th>

      <td><input name="linkurl" id="linkurl" type="text" value="<?php echo get_post_meta($pagedetails->ID, 'ljcustommenulinks-url', true); ?>" size="40" aria-required="true" /><br />
            <span class="description">The URL of the link ie. 'http://www.google.com.au'.</span></td>
    </tr>
  </table>
  <p class="submit"><input type="submit" class="button-primary" name="submit" value="Update Link" /></p>
</form>
<?php
      
      break;
    case "dyneditproc":
      check_admin_referer('LJCustomMenuLinks-edit');

      $link_id = $_REQUEST['link_id'];
      $link_url = $_REQUEST['linkurl'];
      
      update_post_meta($link_id, 'ljcustommenulinks-url', $link_url);
    
      break;  
    case "dyndelete":
      $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

      if (!wp_verify_nonce($nonce, 'LJCustomMenuLinks-delete') ) die('Security check');

      $link_id = isset($_REQUEST['link_id']) ? $_REQUEST['link_id'] : -1;

      delete_post_meta($link_id, 'ljcustommenulinks-enabled');
      delete_post_meta($link_id, 'ljcustommenulinks-url');
    
      break;
    case "editsettings":
      check_admin_referer('LJCustomMenuLinks-editsettings');

      $links_enabled = isset($_REQUEST['linksenabled']) ? $_REQUEST['linksenabled'] : 0;
      $links_logoff = isset($_REQUEST['linkslogoff']) ? $_REQUEST['linkslogoff'] : 0;
      $links_dynamiclinksadmin = isset($_REQUEST['linksdynamiclinksadmin']) ? $_REQUEST['linksdynamiclinksadmin'] : 0;
      $links_advanced = isset($_REQUEST['linksadvanced']) ? $_REQUEST['linksadvanced'] : 0;
      $links_custom_liclasswithsubmenu = isset($_REQUEST['links_custom_liclasswithsubmenu']) ? $_REQUEST['links_custom_liclasswithsubmenu'] : '';
      $links_custom_ulclassforsubmenu = isset($_REQUEST['links_custom_ulclassforsubmenu']) ? $_REQUEST['links_custom_ulclassforsubmenu'] : '';
      $links_use_wp_list_pages_filter = isset($_REQUEST['links_use_wp_list_pages_filter']) ? $_REQUEST['links_use_wp_list_pages_filter'] : 0;
      $links_donate = isset($_REQUEST['linksdonate']) ? $_REQUEST['linksdonate'] : 0;

      $options['enabled'] = ($links_enabled == 1) ? true : false;
      $options['showlogout'] = ($links_logoff == 1) ? true : false;
      $options['showdynamiclinksadmin'] = ($links_dynamiclinksadmin == 1) ? true : false;
      $options['showadvanced'] = ($links_advanced == 1) ? true : false;
      $options['custom_liclasswithsubmenu'] = $links_custom_liclasswithsubmenu;
      $options['custom_ulclassforsubmenu'] = $links_custom_ulclassforsubmenu;
      $options['use_wp_list_pages_filter'] = ($links_use_wp_list_pages_filter == 1) ? true : false;
      $options['showdonate'] = ($links_donate == 1) ? true : false;

      break;
  }

  if ($displaymain) {
?>
  <h2>LJ Custom Menu Links</h2>
    <h3>Custom Links</h3>
<div class="clear"></div>
<table class="widefat tag fixed" cellspacing="0">
  <thead>
  <tr>
  <th scope="col" id="text" class="manage-column column-text" style="">Text</th>
  <th scope="col" id="url" class="manage-column column-url" style="">URL</th>
  <th scope="col" id="target" class="manage-column column-target" style="">Target</th>
  <th scope="col" id="display" class="manage-column column-display" style="">Display</th>
  <th scope="col" id="only_logged_in" class="manage-column column-only_logged_in" style="">Only Logged In</th>
  <th scope="col" id="sort_order" class="manage-column column-sortorder" style="">Sort Order</th>
  </tr>
  </thead>

  <tfoot>
  <tr>
  <th scope="col" id="text" class="manage-column column-text" style="">Text</th>
  <th scope="col" id="url" class="manage-column column-url" style="">URL</th>
  <th scope="col" id="target" class="manage-column column-target" style="">Target</th>
  <th scope="col" id="display" class="manage-column column-display" style="">Display</th>
  <th scope="col" id="only_logged_in" class="manage-column column-only_logged_in" style="">Only Logged In</th>
  <th scope="col" id="sort_order" class="manage-column column-sortorder" style="">Sort Order</th>
  </tr>
  </tfoot>

  <tbody id="the-list" class="list:tag">
<?php

  echo $this->build_tr();

?>
</tbody>

</table>
<p class="submit"><input type="button" class="button-primary" name="add" value="Add Link" onclick="window.location.href='options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php&amp;action=add'" /></p>
<?php
  if ($options['showdynamiclinksadmin']) {
?>
<h3>Dynamic Menu Links</h3>
<div class="clear"></div>
<table class="widefat tag fixed" cellspacing="0">
  <thead>
  <tr>
  <th scope="col" id="pageid" class="manage-column column-pageid" style="">Page ID</th>
  <th scope="col" id="pagename" class="manage-column column-pagename" style="">Page Name</th>
  <th scope="col" id="url" class="manage-column column-url" style="">URL</th>
  </tr>
  </thead>

  <tfoot>
  <tr>
  <th scope="col" id="pageid" class="manage-column column-pageid" style="">Page ID</th>
  <th scope="col" id="pagename" class="manage-column column-pagename" style="">Page Name</th>
  <th scope="col" id="url" class="manage-column column-url" style="">URL</th>
  </tr>
  </tfoot>

  <tbody id="the-list" class="list:tag">
<?php

  $pagelist = get_pages(array('meta_key' => 'ljcustommenulinks-enabled', 'meta_value' => '1', 'hierarchical' => 0));

  foreach ($pagelist as $item) {
?>
    <tr id="tag-<?php echo $item->ID; ?>" class="iedit">
      <td class="text column-pageid"><?php echo $item->ID; ?>
        <div class="row-actions">
          <span class="edit"><a href="options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php&amp;action=dynedit&amp;link_id=<?php echo $item->ID; ?>">Edit</a> | </span>
          <span class="delete"><a class='delete:the-list:tag-3 submitdelete' href='options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php&amp;action=dyndelete&amp;link_id=<?php echo $item->ID; ?>&amp;_wpnonce=<?php echo wp_create_nonce('LJCustomMenuLinks-delete'); ?>' onclick="return confirm('Are you sure you want to delete this custom link? This will make the actual page visible to the site. To do a complete delete please goto the pages admin and delete from there.');">Delete</a> | </span>
          <span class="editpage"><a href='<?php echo get_edit_post_link($item->ID); ?>'>Goto Edit Page</a></span>
        </div>
      </td>
      <td class="text column-pagename"><?php echo $item->post_title; ?></td>
      <td class="text column-url"><?php echo get_post_meta($item->ID, 'ljcustommenulinks-url', true); ?></td>
    </tr>
<?php     
  }
?>
</tbody>

</table>
<?php 
  }
?>
<h3>Settings</h3>
<div class="clear"></div>

<form action="" method="post" id="LJCustomMenuLinksEditForm" accept-charset="utf-8">
  <input type="hidden" name="action" value="editsettings" />
  <?php wp_nonce_field('LJCustomMenuLinks-editsettings'); ?>
  <table class="form-table">
  <tr valign="top">
  <th scope="row">LJ Custom Menu Links Enabled</th>
  <td><fieldset><legend class="screen-reader-text"><span>LJ Custom Menu Links Enabled</span></legend>
  <label for="linksenabled">
  <input name="linksenabled" type="checkbox" id="linksenabled" value="1" <?php if ($options['enabled'] == true) echo "checked='checked'"; ?> />
  Uncheck to disable LJ Custom Menu Links.</label><br />
  </fieldset></td>
  </tr>
  <tr valign="top">
  <th scope="row">Display Logoff</th>
  <td><fieldset><legend class="screen-reader-text"><span>Display Logoff</span></legend>
  <label for="linkslogoff">
  <input name="linkslogoff" type="checkbox" id="linkslogoff" value="1" <?php if ($options['showlogout'] == true) echo "checked='checked'"; ?> />
  Check this to display a Logoff button if a user is logged in.</label><br />
  </fieldset></td>
  </tr>
  <tr valign="top">
  <th scope="row">Display Dynamic Links in Admin Page</th>
  <td><fieldset><legend class="screen-reader-text"><span>Display Dynamic Links in Admin Page</span></legend>
  <label for="linksdynamiclinksadmin">
  <input name="linksdynamiclinksadmin" type="checkbox" id="linksdynamiclinksadmin" value="1" <?php if ($options['showdynamiclinksadmin'] == true) echo "checked='checked'"; ?> />
  Check this to display a list of Dynamic Links in the Admin Page.</label><br />
  </fieldset></td>
  </tr>
  <tr valign="top">
  <th scope="row">Show Advanced Options</th>
  <td><fieldset><legend class="screen-reader-text"><span>Show Advanced Options</span></legend>
  <label for="linksadvanced">
  <input name="linksadvanced" type="checkbox" id="linksadvanced" value="1" <?php if ($options['showadvanced'] == true) echo "checked='checked'"; ?> />
  Display advanced plugin settings.</label><br />
  </fieldset></td>
  </tr>
<?php
  if ($options['showadvanced']) {
?>
  <tr valign="top">
  <th scope="row">Advanced Options</th>
  <td><fieldset><legend class="screen-reader-text"><span>Show Advanced Options</span></legend>
  <label for="links_custom_liclasswithsubmenu">Custom class for LI elements with submenus.<br />
  <input name="links_custom_liclasswithsubmenu" type="text" id="links_custom_liclasswithsubmenu" value="<?php echo $options['custom_liclasswithsubmenu'];?>" />
  </label><br />
  <label for="links_custom_ulclassforsubmenu">Custom class for UL elements of submenus.<br />
  <input name="links_custom_ulclassforsubmenu" type="text" id="links_custom_ulclassforsubmenu" value="<?php echo $options['custom_ulclassforsubmenu'];?>" />
  </label><br />
  <label for="links_use_wp_list_pages_filter">Use wp_list_pages Filter.<br />
  <input name="links_use_wp_list_pages_filter" type="checkbox" id="links_use_wp_list_pages_filter" value="1" <?php if ($options['use_wp_list_pages_filter'] == true) echo "checked='checked'"; ?> />
  When this option is enabled you dont need to make any modifications to your theme for LJ Custom Menu Links to work.</label><br />
  </fieldset></td>
  </tr>
<?php
  } else {
?>
<?php
    echo "<input name='links_custom_liclasswithsubmenu' type='hidden' value='".$options['custom_liclasswithsubmenu']."' />\n";
    echo "<input name='links_custom_ulclassforsubmenu' type='hidden' value='".$options['custom_ulclassforsubmenu']."' />\n";
  }
?>
  <tr valign="top">
  <th scope="row">Show me the donate button</th>
  <td><fieldset><legend class="screen-reader-text"><span>Show the donate button</span></legend>
  <label for="linksdonate">
  <input name="linksdonate" type="checkbox" id="linksdonate" value="1" <?php if ($options['showdonate']) echo "checked='checked'"; ?> />
  If you like this plugin and would like to support it please turn this option on to show the donate button.</label><br />
  </fieldset></td>
  </tr>
</table>
  <p class="submit"><input type="submit" class="button-primary" name="submit" value="Update Settings" /></p>
</form>
<?php
  if ($options['showdonate']) {
?>
<div align="right">
If you would like to make a donation,<br />
please feel free to submit feature requests<br />
for this plugin via <a href="http://www.thelazysysadmin.net/software/wordpress-plugins/lj-custom-menu-links/" target="_blank">LJ Custom Menu Links</a><br />
plugin page. Submit a feature request even if<br />
you dont make a donation. Requests with donations will<br />
be given a higher priority :-).
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8087129">
<input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
<?php
  }
?>

<?php
  }

  update_option('LJCustomMenuLinks', $options);

?>
</div>
<?php

  }

  function build_option($current_selection = -1, $current_parent = 0, $level = 0, $baseid = -1) {
    global $wpdb;

    $table_name = $wpdb->prefix."ljcustommenulinks";

    $sql = "SELECT * FROM $table_name WHERE parent = %d ORDER BY sort_order;";
    $results = $wpdb->get_results($wpdb->prepare($sql, $baseid), ARRAY_A);

    $string = "";
    if (is_array($results)) {
      foreach ($results as $result) {
        if ($result['id'] != $current_selection) {
          $numchildren = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_name WHERE parent = %d;", $result['id']));

          $string .= "  <option class=\"level-$level\" value=\"".$result['id']."\"";
          if ($result['id'] == $current_parent) {
            $string .= " selected=\"selected\"";
          }
          $string .= ">";
          for ($i = 0; $i < ($level*3); $i++) {
            $string .= "&nbsp;";
          }
          $string .= $result['text'];
          $string .= "</option>\n";

          if ($numchildren > 0) {
            $string .= $this->build_option($current_selection, $current_parent, $level+1, $result['id']);
          }
        }
      }
    }

    return $string;
  }

  function build_tr($prefix = "", $baseid = -1) {
    global $wpdb;

    $table_name = $wpdb->prefix."ljcustommenulinks";

    $sql = "SELECT * FROM $table_name WHERE parent = %d ORDER BY sort_order;";
    $results = $wpdb->get_results($wpdb->prepare($sql, $baseid), ARRAY_A);

    $string = "";
    if (is_array($results)) {
      foreach ($results as $result) {
        $numchildren = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_name WHERE parent = %d;", $result['id']));

        $string .= "<tr id=\"tag-".$result['id']."\" class=\"iedit\">\n";
        $string .= "  <td class=\"text column-text\">".$prefix.$result['text']."\n";
        $string .= "    <div class=\"row-actions\"><span class=\"edit\"><a href=\"options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php&amp;action=edit&amp;link_id=".$result['id']."\">Edit</a> | </span><span class=\"delete\"><a class='delete:the-list:tag-3 submitdelete' href='options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php&amp;action=delete&amp;link_id=".$result['id']."&amp;_wpnonce=".wp_create_nonce('LJCustomMenuLinks-delete')."' onclick=\"return confirm('Are you sure you want to delete this link?');\">Delete</a></span></div></td>\n";
        $string .= "  <td class=\"url column-url\">".$result['url']."</td>\n";
        $string .= "  <td class=\"target column-target\">".$result['target']."</td>\n";
        $string .= "  <td class=\"display column-display\">";
        if ($result['display']) { $string .= "True"; } else { $string .= "False"; }
        $string .= "</td>\n";
        $string .= "  <td class=\"only_logged_in column-only_logged_in\">";
        if ($result['only_logged_in']) { $string .= "True"; } else { $string .= "False"; }
        $string .= "</td>\n";
        $string .= "  <td class=\"sort_order column-sort_order\">".$result['sort_order']."</td>\n";
        $string .= "</tr>\n";

        if ($numchildren > 0) {
          $string .= $this->build_tr($prefix."- ", $result['id']);
        }
      }
    }

    return $string;
  }

  function delete_node($varid) {
    global $wpdb;

    $table_name = $wpdb->prefix."ljcustommenulinks";

    $sql = "SELECT * FROM $table_name WHERE parent = %d ORDER BY sort_order;";
    $results = $wpdb->get_results($wpdb->prepare($sql, $varid), ARRAY_A);

    if (is_array($results)) {
      foreach ($results as $result) {
        $this->delete_node($result['id']);
      }
    }

    $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $varid));
  }

  function valid_list($baseid = -1) {
    global $wpdb;

    $table_name = $wpdb->prefix."ljcustommenulinks";

    $sql = "SELECT * FROM $table_name WHERE parent = %d ORDER BY sort_order;";
    $results = $wpdb->get_results($wpdb->prepare($sql, $baseid), ARRAY_A);

    $string = "";
    if (is_array($results)) {
      foreach ($results as $result) {
        $numchildren = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_name WHERE parent = %d;", $result['id']));

        $string .= $result['id'].",";

        if ($numchildren > 0) {
          $string .= $this->valid_list($result['id']);
        }
      }
    }

    return $string;
  }

  function wp_list_pages($html) {
    $options = get_option('LJCustomMenuLinks');

    if ($options === false) {
      $options = array();
    }

    foreach ($this->defaults as $key => $value) {
      if (!isset ($options[$key]))
        $options[$key] = $value;
    }

    if ($options['enabled']) {
      $html .= "<!-- Start LJCustomMenuLinks Ver ".$this->pluginversion." -->\n";
      $html .= LJCustomMenuLinks::build_li(-1, $options['custom_liclasswithsubmenu'], $options['custom_ulclassforsubmenu']);
    }

    if (isset($options['showlogout']) && $options['showlogout'] && is_user_logged_in() && $options['enabled']) {
      $html .= '<li class="page_item"><a href="'.wp_logout_url(site_url()).'" title="Logout">Logout</a></li>';
    }

    if ($options['enabled']) {
      $html .= "\n<!-- End LJCustomMenuLinks -->\n";
    }

    return $html;
  }

  static function OutputCustomMenu() {
    $options = get_option('LJCustomMenuLinks');

    $html = "";
    
    if ($options['enabled']) {
      $html .= "<!-- Start LJCustomMenuLinks Ver Static -->\n";
      $html .= LJCustomMenuLinks::build_li(-1, $options['custom_liclasswithsubmenu'], $options['custom_ulclassforsubmenu']);
    }

    if (isset($options['showlogout']) && $options['showlogout'] && is_user_logged_in() && $options['enabled']) {
      $html .= '<li class="page_item"><a href="'.wp_logout_url(site_url()).'" title="Logout">Logout</a></li>';
    }

    if ($options['enabled']) {
      $html .= "\n<!-- End LJCustomMenuLinks -->\n";
    }
    
    echo $html;
  }
  
  static function build_li($baseid = -1, $liclasswithsub = '', $ulclassforsub = '') {
    global $wpdb;

    $table_name = $wpdb->prefix."ljcustommenulinks";

    $sql = "SELECT * FROM $table_name WHERE parent = %d ORDER BY sort_order;";
    $results = $wpdb->get_results($wpdb->prepare($sql, $baseid), ARRAY_A);

    $string = "";
    if (is_array($results)) {
      foreach ($results as $result) {
        $numchildren = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM $table_name WHERE parent = %d;", $result['id']));

        if (($result['display'] == 1) && (is_user_logged_in() || $result['only_logged_in'] == 0)) {
          $string .= '<li class="';

          if (($numchildren > 0) && ($liclasswithsub != '')) {
            $string .= $liclasswithsub.' ';
          }

          $string .= 'page_item"><a href="'.$result['url'].'" title="'.$result['text'].'" target="'.$result['target'].'">'.$result['text'].'</a>';
          if ($numchildren == 0) {
            $string .= '</li>';
          } else {
            $string .= '<ul';

            if ($ulclassforsub != '') {
              $string .= ' class="'.$ulclassforsub.'"';
            }

            $string .= '>';
            $string .= LJCustomMenuLinks::build_li($result['id'], $liclasswithsub, $ulclassforsub);
            $string .= '</ul></li>';
          }
        }
      }
    }

    return $string;
  }

  function db_install() {
    global $wpdb;

    $currentdbversion = get_option('ljcustommenulinks-dbversion');

    $table_name = $wpdb->prefix."ljcustommenulinks";

    if ( ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) || ($currentdbversion != $this->dbversion)) {
      $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY ,
        text VARCHAR(255) NOT NULL ,
        url VARCHAR(255) NOT NULL ,
        target ENUM('_blank', '_self') NOT NULL ,
        display TINYINT NOT NULL ,
        only_logged_in TINYINT NOT NULL ,
        sort_order VARCHAR(50) NOT NULL ,
        parent INT NOT NULL
      );";

      require_once(ABSPATH.'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      update_option("ljcustommenulinks-dbversion", $this->dbversion);
    }

    $options = get_option('LJCustomMenuLinks');

    if ($options === false) {
      $options = array();
    }

    foreach ($this->defaults as $key => $value) {
      if (!isset ($options[$key]))
        $options[$key] = $value;
    }

    if (isset($options['links'])) {
      foreach ($options['links'] as $link) {
        $sql = "INSERT INTO $table_name (text, url, target, display, only_logged_in, sort_order, parent) ";
        $sql .= "VALUE (%s, %s, %s, %d, %d, %s, -1);";

        $wpdb->query($wpdb->prepare($sql,
                      $link['text'],
                      $link['url'],
                      $link['target'],
                      $link['display'] ? 1 : 0,
                      $link['only_logged_in'] ? 1 : 0,
                      $link['sort_order']));
      }
    }

    unset($options['links']);
    unset($options['nextid']);

    // Clean up orphans from older versions
    $validlist = $this->valid_list();
    $validlist = substr($validlist, 0, strlen($validlist)-1);
    $sql = "DELETE FROM $table_name WHERE id NOT IN ($validlist);";
    $wpdb->query($sql);

    update_option('LJCustomMenuLinks', $options);
  }
  
  function filter_link($varurl, $varpageid) {
    $enabled = get_post_meta($varpageid, 'ljcustommenulinks-enabled', true);
    
    if ($enabled == 1) {
      $url = get_post_meta($varpageid, 'ljcustommenulinks-url', true);
      return $url;
    } else {
      return $varurl;
    }
  }
  
  function admin_menu_metabox() {
    if (function_exists('add_meta_box')) {
      add_meta_box("ljcustommenulinks-meta", "LJCustomMenuLinks - Dynamic Links", array( &$this, 'page_based_options'), 'page');
    }
  }
  
  function page_based_options() {
    global $post;

    $enabled = get_post_meta($post->ID, 'ljcustommenulinks-enabled', true);
    $url = get_post_meta($post->ID, 'ljcustommenulinks-url', true);
    
    echo "<input type='hidden' name='LJCustomMenuLinks-metabox-nonce' id='LJCustomMenuLinks-metabox-nonce' value='".wp_create_nonce('LJCustomMenuLinks-metabox')."' />";
?>
  <table class="form-table">
  <tr valign="top">
  <th scope="row">Use this page as a Link Placeholder?</th>
  <td><fieldset><legend class="screen-reader-text"><span>Use this page as a Link Placeholder?</span></legend>
  <label for="LJCustomMenuLinks-metabox-enabled">
  <input name="LJCustomMenuLinks-metabox-enabled" type="checkbox" id="LJCustomMenuLinks-metabox-enabled" value="1" <?php if ($enabled == 1) { echo "checked='checked'"; } ?> />
  Check this to replace the Wordpress generated link for a custom link</label>
  </fieldset></td>
  </tr>
      <tr class="form-field form-required">
        <th scope="row" valign="top"><label for="LJCustomMenuLinks-metabox-url">URL</label></th>

        <td><input name="LJCustomMenuLinks-metabox-url" id="LJCustomMenuLinks-metabox-url" type="text" size="40" aria-required="true" value="<?php echo $url; ?>" /><br />
              <span class="description">The URL for the link.</span></td>
      </tr>
</table>
<?php    
  }
  
  function save_post_data($post_id) {
    if (!wp_verify_nonce($_POST['LJCustomMenuLinks-metabox-nonce'], 'LJCustomMenuLinks-metabox')) {
      return $post_id; 
    }
    
    if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      } 
    } else {
      if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
      } 
    }
    
    update_post_meta($post_id, 'ljcustommenulinks-enabled', ($_POST['LJCustomMenuLinks-metabox-enabled'] == 1) ? true : false);
    update_post_meta($post_id, 'ljcustommenulinks-url', $_POST['LJCustomMenuLinks-metabox-url']);
    
    return $post_id;
  }
  
  function plugin_action_links( $links, $file ) {
    static $this_plugin;
    
    if( empty($this_plugin) )
      $this_plugin = plugin_basename(__FILE__);

    if ( $file == $this_plugin )
      $links[] = '<a href="' . admin_url( 'options-general.php?page=lj-custom-menu-links/lj-custom-menu-links.php' ) . '">Settings</a>';

    return $links;
  }

}

$LJCustomMenuLinks = new LJCustomMenuLinks();

function LJCustomMenuLinksAttribution() {
  echo "<a href=\"http://www.thelazysysadmin.net/\">Custom Links by LJCustomMenuLinks</a>";
}

?>