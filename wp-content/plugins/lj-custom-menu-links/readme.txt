=== Plugin Name ===
Contributors: littlejon
Tags: menu, easy, custom, dynamic, links, admin, page, placeholder, logout, plugin
Requires at least: 2.7
Tested up to: 2.8.5
Donate link: http://www.thelazysysadmin.net/software/appreciation/
Stable tag: 2.5

LJ Custom Menu Links is a plugin that allows you to put extra links in the menus of most Wordpress Themes.

== Description ==

LJ Custom Menu Links is a plugin that allows you to put extra links in the menus of most Wordpress Themes. It is unique in the way that it doesn't require any code changes to your theme as the extra links are added within Wordpress core functionality. This plugin requires no technical knowledge to administer, it is all contained within the Wordpress admin pages with a consistent look and feel for ease of use.

Functions:

* Add Extra Menu links to your theme
* Use pages as placeholders for menu links (This allows you full customization as to the location of your links)
* Control if menus items are shown based on if a user is logged in
* Shows a logout link if a user is logged in
* Provides the ability to provide a link back to your admin pages only if a user is logged in
* Full menu sorting available
* You can now take full control of how you want Custom Menu Links to operate, fully automatic integration or manual integration (modifying your theme for LJ Custom Menu Links).

If you are having compatibility issues with LJ Custom Menu Links outputting its links inside other plugins or sidebar widgets then this update is for you. Currently due to core wordpress limitations, if you use LJ Custom Menu Links there may be compatibility issues with other plugins. You now have the option (via the Advanced Options page) to turn off `Use wp_list_pages Filter` option and insert the required code to make LJ Custom Menu Links work without interruption within your own theme.

To add flexible location links (Dynamic Links) you need to create a new page as a placeholder for that link, under the edit page menu is a box to control what link to show. Please see the screenshots on the next page for a description. Links created in this way don't have the ability to choose the target window (you may still control the visibility of the link via the private or public based on the page settings, and also the ordering based on page settings).

The admin page now also contains a list of Dynamic Links, which can be deleted or edited from within the LJCustomMenuLinks admin section.

To add LJCustomMenuLinks please use the LJCustomMenuLinks item in the Admin section, these links are added to the end of the standard wordpress menu system but have full customization ability.

The plugin has also had an attribution function added. If you would like to provide attribution for the plugin then add the following code into your wordpress theme. The footer is a good place for it.

`<?php
  if (function_exists('LJCustomMenuLinksAttribution')) {
    LJCustomMenuLinksAttribution(); 
  }
?>`

== Installation ==

1. Unzip and upload the `lj-custom-menu-links` folder into your `/wp-content/plugins/` directory
2. Activate the Plugin through the Plugins menu
3. Edit the settings in the LJ Custom Menu Links Admin page
4. Enjoy

If you install the update manually, please ensure you deactivate the plugin and then reactive. If you dont do this the plugin will not function!!

= Theme Integration (optional) =

If you are having compatibility issues with other plugins, widgets or themes whereby LJ Custom Menu Links shows its links where you don't want them then you will need to make a minor modification to your theme.

Firstly you will need to turn off the `Use wp_list_pages Filter` option from within the Advanced Options screen in the LJ Custom Menu Links admin page. Next you will need to edit your theme (this will be different for every theme available). As a general rule you should find the `header.php` file of your theme the appropriate place, then find some code that references `wp_list_pages` and place the following code snippet after the `wp_list_pages` but before the `</ul>` tag

`<?php
      if (class_exists('LJCustomMenuLinks')) {
        LJCustomMenuLinks::OutputCustomMenu();
      }
?>`

== Frequently Asked Questions ==

= Can I place links within the current menu structure (ie Page 1 | LJCustomMenuLink | Page 2) =

Yes! This is now possible with Version 2.3

You will need to create a new Page as a placeholder for the link and then change the settings in the LJCustomMenuLinks box on the edit page.

= My theme changes the class of the LI and UL elements of a menu with submenus, can LJCustomMenuLinks do the same =

This feature was requested for compatibility with the Atahualpa theme, I am sure there will be more!

To use this, goto the LJCustomMenuLinks admin screen and enable Advanced Options.

The settings required for Atahualpa are:

Custom Class for LI with Submenu: `rMenu-expand`

Custom Class for UL Submenu: `rMenu-ver`

= I am having issues where your plugin is adding links where I don't expect them =

This is due to limitations of the core Wordpress code. However I now have a solution for your trouble. Disable the `Use wp_list_pages Filter` option under the advanced options then add the following code to your theme

`<?php
      if (class_exists('LJCustomMenuLinks')) {
        LJCustomMenuLinks::OutputCustomMenu();
      }
?>`

More details can be found in the Installation instructions under the Theme Integration heading.

= I really like your plugin, is there anyway I can help =

Yes. Please place the following code snippet in an appropriate place in your theme. The footer is a good place.

`<?php
  if (function_exists('LJCustomMenuLinksAttribution')) {
    LJCustomMenuLinksAttribution(); 
  }
?>`

== Changelog ==

= 2.5 =

* Fixed compatibility issues by adding the ability to disable the core wordpress override and manually add the LJ Custom Menu Links code to your theme

= 2.4 =

* Ability to track Dynamic Links via the LJCustomMenuLinks Admin Page. To use this turn on the Display Dynamic Links in Admin Page option in the admin page.
* Shamelessly added a removable donate link in the plugin admin
* Added Attribution Link function for use in themes

= 2.3 =

* New Feature: Ability to add Flexible Location links. This allows you to put links anywhere within the menu structure.

= 2.2 =

* FEATURE REQUEST: There are a few themes that inject custom classes into the menu items, you can now specify under advanced options classes to inject to Menu items for theme compatibility

= 2.1 =

* BUGFIX: When items with child nodes are deleted in Ver 2.0 the child nodes are left in the database as orphans. This behaviour is now fixed
* When the plugin is activated all previous orphan nodes are deleted to clean up the database

= 2.0 =

* Change backend storage method (Now uses database table)
* Can now have nested menus (In the same fashion as nested pages by settings parents). Please Note! For nested menus to work the theme must support this feature.

= 1.2a =

* Added confirm delete to Config Screen

= 1.1a =

* Initial Release

== Screenshots ==

1. Admin Configuration Screen
2. Page Link Settings
3. Settings Example