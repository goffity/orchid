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
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <div class="post" id="post-<?php the_ID(); ?>">
          <div class="posttop">
		   <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
              <?php the_title(); ?>
              </a></h2>
            
         
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
            <?php the_content('Read the rest of this entry &raquo;'); ?>			
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
        <?php endwhile; ?>
        <?php include (TEMPLATEPATH . '/navoptions.php'); ?>
        <?php else : ?>
        <h2>Not Found</h2>
        <p class="center">Sorry, but you are looking for something that isn't here.</p>
        <?php endif; ?>
      </div>
	 
    </div>
    <div class="bgbottom"></div>
  </div>
</div>
<?php get_footer(); ?>
