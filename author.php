<?php
/**
 * @package WordPress
 * @subpackage modest3
 * authorを表示するためのテンプレート
 */
get_header();
?>

<article id="content"
         role="main">
	<?php
		if (have_posts()) :
			$user_data = get_userdata($author);
	?>

		<header class="entry-header">
			<?php
				//post_icon($the_id,array(120,120));
			?>
			<h1 class="post-title"><?php echo($author->display_name); ?></h1>
		</header>

		<footer class="authormeta">
			<dl class="author-metadata-list">
				<?php item_of_the_author_data($user_data, 'Web サイト', 'user_url'); ?>
				<?php item_of_the_author_data($user_data, 'Twitter', 'twitter_id'); ?>
				<?php item_of_the_author_data($user_data, 'Facebook', 'facebook_id'); ?>
				<?php item_of_the_author_data($user_data, 'Skype', 'skype_id'); ?>
			</dl>
		</footer>

		<div class="entry-body">
			<?php
				echo esc_html($user_data->description);
			?>
		</div>

		<section id="author-latest-topics-list">
			<?php
				$cat_id = get_post_meta($post->ID, 'catid', true);
			?>
			<h2>投稿したトピック</h2>

			<?php
				while (have_posts()) :
					the_post();
					$the_id = get_the_ID();
		  ?>

			<article class="feed-article">
				<header>
					<?php
						/*
						 * articles title
						 */
						$link = get_permalink();
						$titleText = get_the_title();
						echo '<h1 class="feed-article-title"><a href="'. $link .'">'. $titleText .'</h1>';
					?>

					<?php
						edit_the_link($the_id);
					?>
				</header>

				<footer class="meta-container">
					<div class="postmeta-project">
						<?php
							the_project_list_of_the_post($the_id);
						?>
					</div>

					<div class="postmeta">
						<p class="postmeta-title">投稿日時</p>
						<div class="postmeta-content">
							<?php
								the_time_of_the_post($the_id);
							?>
						</div>
					</div>
				</footer>
			</article>

		<?php
				endwhile;
			else:
				echo '<p>Sorry, no posts matched your criteria</p>';
			endif;
		?>

	<nav class="navigation">
		<?php navigation_bar(); ?>
	</nav>

	</section>

</article>

<?php get_footer(); ?>
