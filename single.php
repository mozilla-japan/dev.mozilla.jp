<?php
/**
 * @package WordPress
 * @subpackage modest2.0
 */
get_header();
?>

<div id="content" class="widecolumn" role="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?>>
      <?php
         $the_id = get_the_ID();
         post_icon($the_id,array(120,120));?>

		<div class="breadcrumbs">
			<?php breadcrumbs($the_id); ?>
		</div>
    <div id="edit_post">
      <?php edit_post_link("編集する","<h3>","</h3>"); ?>
    </div>
		<h1><?php the_title(); ?></h1>
			<div class="singleentry">
			<?php the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'kubrick') . '</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php 
         $post_type = get_post_type($the_id);
         the_tags_post_type( '<p>' . __('Tags:', 'kubrick') . ' ', ', ', '</p>', $post_type); ?>
			</div>	
	    <div class="navigation">
      <p class="postmetadata alt">
          <small>
            <?php /* This is commented, because it requires a little adjusting sometimes.
                  You'll need to download this plugin, and follow the instructions:
					            http://binarybonsai.com/wordpress/time-since/ */
                      /* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); $time_since = sprintf(__('%s ago', 'kubrick'), time_since($entry_datetime)); */ ?>
<?php printf(__('This entry was posted %1$s on %2$s at %3$s and is filed under %4$s.', 'kubrick'), $time_since, get_the_time(__('l, F jS, Y', 'kubrick')), get_the_time(), get_the_category_list(', ')); ?>
					<?php printf(__("You can follow any responses to this entry through the <a href='%s'>RSS 2.0</a> feed.", "kubrick"), get_post_comments_feed_link()); ?>
<?php if ( comments_open() && pings_open() ) {
                                       // Both Comments and Pings are open ?>
<?php printf(__('You can <a href="#respond">leave a response</a>, or <a href="%s" rel="trackback">trackback</a> from your own site.', 'kubrick'), trackback_url(false)); ?>
<?php } elseif ( !comments_open() && pings_open() ) {
                                       // Only Pings are Open ?>
<?php printf(__('Responses are currently closed, but you can <a href="%s" rel="trackback">trackback</a> from your own site.', 'kubrick'), trackback_url(false)); ?>
<?php } elseif ( comments_open() && !pings_open() ) {
                                       // Comments are open, Pings are not ?>
<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'kubrick'); ?>
<?php } elseif ( !comments_open() && !pings_open() ) {
                                       // Neither Comments, nor Pings are open ?>
<?php _e('Both comments and pings are currently closed.', 'kubrick'); ?>
<?php } edit_post_link(__('Edit this entry', 'kubrick'),'','.'); ?>
					</small>
				</p>
		</div>
	  <?php comments_template(); ?>
	  <?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>
    <?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>
