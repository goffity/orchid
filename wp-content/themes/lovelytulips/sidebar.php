<div id="sidebar">
	<ul>

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
			<li><h2>ระบบ Ontology กล้วยไม้</h2>
				<ul>
				<?php getOntology_orchid(  ); ?>
				</ul>
			</li>		
			<li><h2>Rss orchid :</h2>
				
				<?php
				if($_GET["s"]!=""){
					echo "<br>ตามคำค้น : ".$_GET["s"]."<br>";
					 
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%".$_GET["s"]."%'";
					//$urlf="http://it.doa.go.th/refs/rss.php";
				}else{				
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B9%84%E0%B8%A1%E0%B9%89%'";
				}
				RSSImport(10, $urlf); ?>
				
			</li>
			
	<?php endif; // end primary widget area ?>	
	</ul>
</div>	