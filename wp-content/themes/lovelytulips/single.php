<?php get_header(); ?>
<div id="wrap">
<div id="content-container">
	
	<div id="content">
	<div id="sidecontainer">
       <div style="float:left">
        <?php get_sidebar(); ?>
      </div>
	  
	  <div style="float:left">
        <?php include (TEMPLATEPATH . "/sidebar2.php"); ?>
      </div>
	  </div>
	<div class="post-container">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<?php include (TEMPLATEPATH . '/navoptions.php'); ?>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="posttop">
		   <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h2>
        </div>
			
			<div id="date">
            <p class="month">
              <?php the_time('M'); ?>
            </p>
            <p class="day">
              <?php the_time('d'); ?>
            </p>
			
          </div>
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>	
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>					
				<br />
			<div class="entry">
						<div class="entry-meta">
						<?php 
						 //the_meta();
						 $images=get_post_meta($post->ID, 'images',true);
						 $typeorchid=get_post_meta($post->ID, 'typeorchid',true);
						 $tagx=get_post_meta($post->ID, 'tag',true);
						 $linkx=get_post_meta($post->ID, 'link',true);
						 if($typeorchid=="KM"){
							echo"<img src='".$images."'><br>";
						 }
						 if(trim($tagx)<>""){
							echo "tag : ".trim($tagx)."<br>";
						 }
						 echo"<a href='".$linkx."' target='_blank'>อ่านเพิ่มเติม จากแหล่งที่มา</a><pre>";
						?>
					</div><!-- .entry-meta -->
			<?php comments_template(); ?>
			</div>
			<div class="postbottom">
            <div class="metainf">Filled Under:
              <?php the_category(', ') ?>
            </div>
            <div class="commentinf">
              <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
            </div>
          </div>
		</div>
		
	
	
	<?php endwhile; else: ?>
	<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	</div>
	
</div>
<div class="bgbottom"></div>
</div>
</div>
<?php get_footer(); ?>