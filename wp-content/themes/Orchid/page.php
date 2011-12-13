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
		<div class="post" id="post-<?php the_ID(); ?>">
		<div class="posttop">
		   <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h2>

        </div>
		<div class="entry">
		
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			</div>
			<div class="postbottom">
          
          </div>
		</div>
		
		<?php endwhile; endif; ?>
		<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>

</div>
<div class="bgbottom"></div>
</div>
</div>
<?php get_footer(); ?>