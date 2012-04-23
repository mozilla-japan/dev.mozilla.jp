<?php
/*
Template Name: about
 */
get_header(); ?>

<div id="content" class="narrowcolumn">
  <div id="BlogTitle">
    <h1>About</h1>
  </div>
    <?php if (have_posts()) : ?>
	  <div class="navigation">
      <?php wp_pagenavi(); ?>
	  </div>
	  <?php while (have_posts()) : the_post(); ?>
 	  <div <?php post_class();
               $flag = odd_even($flag);
               ?>>
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<?php the_content() ?>
			</div>
	  </div>
	  <?php endwhile; ?>
	  <div class="navigation">
      <?php wp_pagenavi(); ?>
	    <?php else :
		        if ( is_category() ) { // If this is a category archive
			      printf("<h2 class='center'>".__("Sorry, but there aren't any posts in the %s category yet.", 'kubrick').'</h2>', single_cat_title('',false));
		        } else if ( is_date() ) { // If this is a date archive
			      echo('<h2>'.__("Sorry, but there aren't any posts with this date.", 'kubrick').'</h2>');
		        } else if ( is_author() ) { // If this is a category archive
			      $userdata = get_userdatabylogin(get_query_var('author_name'));
			      printf("<h2 class='center'>".__("Sorry, but there aren't any posts by %s yet.", 'kubrick')."</h2>", $userdata->display_name);
		  } else {
			echo("<h2 class='center'>".__('No posts found.', 'kubrick').'</h2>');
		  }
	    get_search_form();
	    endif;
      ?>
    </div>
</div>
<?php get_footer(); ?>
