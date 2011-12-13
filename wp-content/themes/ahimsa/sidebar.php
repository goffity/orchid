<?php global $options, $sectprefix; ?>

<?php if( $options['showauthors'] == 1 ) : ?>

    <fieldset class='sidebarlist'>
        <legend><?php print $sectprefix; ?>Authors</legend>
        <ul>
        <?php wp_list_authors("optioncount=0&exclude_admin=0&feed=1&feed_image=" .
                                get_bloginfo('template_url').
                                "/images/rss-icon.gif"); ?> 
        </ul>
    </fieldset>

<?php endif; ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

    <fieldset class='sidebarlist'>
        <legend><?php print $sectprefix; ?>Categories</legend>
        <ul>
        <?php wp_list_categories('title_li=&hierarchical=0'); ?>
        </ul>
    </fieldset>

    <fieldset class='sidebarlist'>
        <legend><?php print $sectprefix; ?>Archives</legend>
        <ul>
        <?php wp_get_archives('type=monthly'); ?>
        </ul>
    </fieldset>
	<fieldset class='sidebarlist'>
        <legend>ระบบจัดการ Ontology กล้วยไม้</legend>
        <ul>
		<?php getOntology_orchid(  ); ?>
		</ul>
	</fieldset>	
	<fieldset class='sidebarlist'>		
		<legend>Rss orchid :</legend>
		<ul>
		<?php
		echo get_search_query();
		if($_GET["s"]!=""){
			echo "<br>ตามคำค้น : ".$_GET["s"]."<br>";
					 
			$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%".$_GET["s"]."%'";
					//$urlf="http://it.doa.go.th/refs/rss.php";
		}else{				
			$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B9%84%E0%B8%A1%E0%B9%89%'";
		}
		RSSImport(10, $urlf); ?>
		</ul>
    </fieldset>

<?php endif; ?>

