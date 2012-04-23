<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header(); ?>

<div id="content" class="narrowcolumn" role="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
			<div class="entry">
			</div>
		</div>
		<?php endwhile; endif; ?>

	<?php the_content('<p class="serif">' . __('Read the rest of this page &raquo;', 'kubrick') . '</p>'); ?>

 	<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

	<?php/* edit_post_link(__('Edit this entry.', 'kubrick'), '<p>', '</p>');*/ ?>
	
	<?php/* comments_template();*/ ?> 
	
	</div>

	<?php/* get_sidebar();*/ ?>
	<?php get_footer(); ?>
