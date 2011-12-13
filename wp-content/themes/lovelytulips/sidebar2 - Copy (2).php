
	<div id="sidebar2">
	<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
	
	<li><h2>Menu</h2>
	<div class="divClear"></div>
		<div class="accessxx">	
		<div class="menu">
		zddd
		</div>
		
		</div>
	</li>
	<?php endif; ?>	
	</ul>
	</div>

		<div class="accessxx">
		<div class="menu">
		<ul>
		<?php wp_nav_menu( ); ?>
		</ul>
		</div>
		</div>