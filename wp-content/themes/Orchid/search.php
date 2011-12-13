<?php get_header(); ?>
<div id="wrap">
<div id="content-container">
	
	<div id="content">
	<div id="sidecontainer">
       <div style="float:left">
        <?php #get_sidebar(); ?>
      </div>
	  
	  <div style="float:left">
        <?php include (TEMPLATEPATH . "/sidebar2.php"); ?>
      </div>
	  </div>
	<div class="post-container">
	<?php if (have_posts()) : ?>
	<h2 class="pagetitle">Search Results : <?=$_GET["s"]; ?></h2>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
		<div class="posttop">
		   <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
              <?php the_title(); ?></a></h2>
        </div>
		<div class="entry">
		<div id="date">
            <p class="month">
              <?php the_time('M'); ?>
            </p>
            <p class="day">
              <?php the_time('d'); ?>
            </p>
			
          </div>
		<?php the_excerpt() ?>
		</div>
		<div class="postbottom">
            <div class="metainf">Filled Under:
              <?php the_category(', ') ?><?php $tags = wp_get_post_terms(get_the_ID());?>
            </div>
            <div class="commentinf">
              <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
            </div>
          </div>
		</div>
		
		<div class="post">
		<?php 
				$tags = wp_get_post_terms(get_the_ID());
				if ($tags) {
				?>
				<div class="posttop">
				<h2>เรื่องที่เกี่ยวข้อง : </h2>
				</div>
				<?php
				$first_tag = $tags[0]->term_id;
				$args=array(
				'tag__in' => array($first_tag),
				'post__not_in' => array($post->ID),
				'posts_per_page'=>5,
				'caller_get_posts'=>1
				);
				$relatedPosts = new WP_Query($args);
				if( $relatedPosts->have_posts() ) {
				//loop through related posts based on the tag
				while ($relatedPosts->have_posts()) : $relatedPosts->the_post(); ?>
					<p><li><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li></p>
				<?php
				endwhile;
				}?>
				
				<?php
				}
		?>
		</div>
		<?php endwhile; ?>
		<?php include (TEMPLATEPATH . '/navoptions.php'); ?>
		<div class="post">
		<div class="posttop"> <h2>Rss Orchid :
				
				<?php
				if($_GET["s"]!=""){
					echo " ตามคำค้น ( ".$_GET["s"].")";
				echo "</h2></div>";
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%".$_GET["s"]."%'";
					//$urlf="http://it.doa.go.th/refs/rss.php";
				}else{				
					$urlf="http://it.doa.go.th/refs/rss.php?where=title+LIKE+'%%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B9%84%E0%B8%A1%E0%B9%89%'";
				}
				RSSImport(10, $urlf); ?>

		  <div class="postbottom">
                      
            <div class="metainf">By PlugIn Orchid</div>
        </div>
		</div>
	<?php else : ?>
	<div class="post">
		<div class="posttop">
		<h2>Not Found</h2>
		</div>
		<div class="entry">
	
	<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<br /><br />
	
	</div>
	<div class="postbottom">
     
         </div>
	</div>
	
	<?php endif; ?>
	</div>
	

	
	
</div>
<div class="bgbottom"></div>
</div>
</div>
<?php get_footer(); ?>