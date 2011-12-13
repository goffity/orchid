<?php
function widget_mytheme_search() {
include (TEMPLATEPATH . "/searchform.php"); 
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_mytheme_search');

if ( function_exists('register_sidebar') )
   register_sidebars(1, array(
         'before_widget' => '<div style="clear:both"></div>',
        'after_widget' => '<div class="bottom_sidebar"></div>',
        'after_title' => '</h2>',
       ));
if ( function_exists('register_sidebar') )
   register_sidebars(2, array(
         'before_widget' => '<div style="clear:both"></div>',
        'after_widget' => '<div class="bottom_sidebar"></div>',
        'after_title' => '</h2>',
       ));
//GsL98DGtpo0W
add_action('init', 'register_custom_menu');
 
function register_custom_menu() {
register_nav_menu('custom_menu', __('Custom Menu'));
}

function orchid_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'orchid_page_menu_args' );


?>
