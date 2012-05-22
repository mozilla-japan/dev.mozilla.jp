<?php
/*
 * Template Name: about
 */
get_header(); ?>

<artcle id="content">
	<?php
		$id = get_the_ID();
	?>
	<h1><?php the_escaped_title($id); ?></h1>
	<p><?php the_content() ?></p>
</artcle>

<?php get_footer(); ?>
