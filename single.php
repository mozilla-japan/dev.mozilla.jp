<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
get_header();
?>

<article id="content"
         role="main">

	<?php
		if (have_posts()) :
			while (have_posts()) :
				the_post();
	?>

	<?php
		$the_id = get_the_ID();
	?>
	<header class="entry-header">
		<div class="breadcrumbs">
			<?php breadcrumbs($the_id); ?>
		</div>

		<?php
			post_icon($the_id,array(120,120));
		?>

		<h1><?php the_title(); ?></h1>

		<ul class="postmeta-project">
			<?php
				$catlist = get_the_category();
				foreach ($catlist as $cat) :
					$project_array = get_post(get_project_page_ID($cat->cat_ID));
					if ($project_array->post_type == 'project') :
						echo '<li><a href="'. get_permalink($project_array->ID) .'">';
						echo $project_array->post_title;
						echo '</a></li>';
					endif;
				endforeach;
			?>
		</ul>

		<dl class="postmeta">
			<dt>投稿者</dt>
			<dd>
				<address>
					<?php
						$post = get_post($the_id);
						$userID = $post->post_author;
						echo get_avatar($userID, 15);//avatar image
						echo the_author_posts_link();//auther link
					?>
				</address>
			</dd>
			<dt>投稿日時</dt>
			<dd>
				<?php
					$datetime = get_the_time('Y-m-d H:i:s');
					$date = get_the_time('Y年n月d日 G:i:s');
					echo('<time datetime="' . $datetime . '">'. $date . '</time>');
				?>
			</dd>
		</dl>

		<div id="edit_post button-blue">
			<?php
				edit_post_link("編集する","","");
			?>
		</div>
	</header>

	<div class="entry-body">
		<?php
			the_content('続きを読む');
		?>
	</div>

	<footer class="entry-footer">
		<?php
			//wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

			//$post_type = get_post_type($the_id);
			//the_tags_post_type( '<p>' . __('Tags:', 'kubrick') . ' ', ', ', '</p>', $post_type);
		?>
	</footer>

	<?php comments_template(); ?>

	<?php
			endwhile;
		else:
	?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>
	<?php
		endif;
	?>

</article>

<?php get_footer(); ?>
