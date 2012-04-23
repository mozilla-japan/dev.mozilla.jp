<?php
/**
 * @package WordPress
 * @subpackage modest2.0
 */

get_header();
?>
<div id="content" class="narrowcolumn">
	<h3 class="center">

	<?php _e('Error 404 - Not Found', 'kubrick'); ?></h3>
  <div id="notfound_cloud">
    <?php wp_tag_cloud() ?>
  </div>
  <?php get_search_form() ?>
</div>

<?php get_footer(); ?>
