<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
get_header();
?>

<article id="content" class="widecolumn" role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div <?php post_class(); ?>>
      <?php
         $the_id = get_the_ID();
         post_icon($the_id,array(120,120));
			?>
	</div>

		<nav>
			<div class="breadcrumbs">
				<?php breadcrumbs($the_id); ?>
			</div>
			<div id="edit_post">
				<p><?php edit_post_link("編集する","",""); ?></p>
			</div>
		</nav>

		<h1><?php the_title(); ?></h1>
			<div class="singleentry">
			<?php the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'kubrick') . '</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php 
         $post_type = get_post_type($the_id);
         the_tags_post_type( '<p>' . __('Tags:', 'kubrick') . ' ', ', ', '</p>', $post_type); ?>
			</div>

			<footer class="postmetadata">
				<dl>
					<dt>投稿日時</dt>
					<dd>
						<?php
							$datetime = get_the_time('Y-m-d H:i:s');
							$date = get_the_time('Y年n月d日 G:i:s');
							echo('<time datetime="' . $datetime . '">'. $date . '</time>');
						?>
					</dd>
					<dt>カテゴリ</dt>
					<dd><?php echo(get_the_category_list('')); ?></dd>
				</dl>
			</footer>

	  <?php comments_template(); ?>
	  <?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>
    <?php endif; ?>

</article>
<?php get_footer(); ?>
