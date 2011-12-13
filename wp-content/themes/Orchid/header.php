<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
</head>

<body>
<script>
function sfocus() {
if (document.getElementById('s').value=='') {
document.getElementById('s').value='';
}
}
function sblur() {
if (document.getElementById('s').value=='') {
document.getElementById('s').value='';
}
}


function chk_search()
{
	if(window.document.searchform.chk_s.value.length == 0)
	{
		alert("Please input text form search");
		window.document.searchform.chk_s.focus();
		return false;
	}
	else
		return true;
}

</script>
<?php if (wp_specialchars($s, 1)!='') {
$svalue=wp_specialchars($s, 1);
} else {
$svalue='';
}?>
<div id="page">
<div id="header">

	<div id="menu_search_box">
		<form method="get" id="searchform" name="searchform" style="display:inline;" action="http://localhost:81/wordpress2/?s=" onsubmit="return chk_search()">
			<span id="searchLabel">Search:&nbsp;</span>
			<input type="text" class="s" value="<?php echo $svalue; ?>" name="s" id="s" onBlur="sblur()" onFocus="return sfocus()" />
				
		</form>
	</div>
	<br /><br /><br /><br />
	
	<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
	<div id="subtitle"><?php bloginfo('description'); ?></div>
	<div id="access" role="navigation">
		<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
	</div><!-- #access -->
		
</div>