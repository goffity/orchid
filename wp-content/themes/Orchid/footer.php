<div id="footer">

<table width="620" align="right" style="background: #99ccff">
	<tr><td><hr></td></tr>
	<tr>
		<td>
			<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</td>
		<td align="right">
			<?php do_action( 'twentyten_credits' ); ?>
			<a href="<?php echo esc_url( __('http://wordpress.org/', 'twentyten') ); ?>"
				title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'twentyten'); ?>" rel="generator">
			<?php printf( __('Proudly powered by %s.', 'twentyten'), 'WordPress' ); ?>
			</a>
		</td>
	</tr>
	<tr><td colspan="2" align="right" ><img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/uknow.png" width="100" height="35"></td></tr>
</table>
</div>