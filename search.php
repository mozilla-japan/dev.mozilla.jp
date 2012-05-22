<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header(); ?>


<article id="content" role="main">
  <?php if (have_posts()) : ?>
  <h1 class="post-title">検索結果</h1>
  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>
  <?php while (have_posts()) : the_post(); ?>

	<?php
		$the_id = get_the_ID();
	?>

  	<article class="archive-post">

		<header class="archive-post_header">
			<?php
				post_icon(get_the_ID(),array(70,70));
			?>

			<?php
				/*
				* article's title
				*/
				$permaLink = get_permalink();
				$titleText = get_the_escaped_title($the_id);
				echo '<h1 class="archive-post-title"><a href="'. $permaLink .'">'. $titleText .'</a></h1>';
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

		</footer>

		<div class="entry-body">
			<?php the_content() ?>
		</div>

		<footer class="entry-footer">
			<div class="postmeta">
				<p class="postmeta-title">投稿者</p>
				<address class="postmeta-content">
					<?php
						$post = get_post($the_id);
						$userID = $post->post_author;
						echo get_avatar($userID, 15);//avatar image
						echo the_author_posts_link();//auther link
					?>
				</address>
				<p class="postmeta-title">投稿日時</p>
				<div class="postmeta-content">
					<?php
						the_time_of_the_post($the_id);
					?>
				</div>
			</div>
		</footer>

	</article>

  <?php endwhile; ?>
  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>
  <?php else : ?>
    <h1 class="post-title">残念ながら、キーワードに一致する記事は<br>見つけられませんでした。<br>別のキーワードをお試しください。</h1>
    <?php get_search_form(); ?>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
