<?php
/**
 * @package WordPress
 * @subpackage modest3
 * プロジェクトページを表示するためのテンプレート
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
		<?php
			//post_icon($the_id,array(120,120));
		?>

		<h1 class="post-title"><?php the_title(); ?></h1>

		<?php
			edit_the_link($the_id);
		?>
	</header>

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

			<p class="postmeta-title">Web サイト</p>
			<address class="postmeta-content">
				<?php
					$url = get_post_meta($post->ID, 'url', true);
					if ($url) :
						echo '<a href="'. $url .'">プロジェクトのWebサイト</a>';
					else :
						echo 'なし';
					endif;
				?>
			</address>
		</div>
	</footer>

	<div class="entry-body">
		<?php
			the_content();
		?>
	</div>

	<?php
			endwhile;
		else:
			echo '<p>Sorry, no posts matched your criteria</p>';
	  endif;
	?>

	<section id="project-latest-topics-list">
		<h1>プロジェクトの最新の投稿</h1>
		<?php
			$cat_id = get_post_meta($post->ID, 'cat', true);
			$args = array('posts_per_page' => 5,
			              'category' => $cat_id);
			$posts = get_posts($args);
			if($posts):
				foreach($posts as $post):
					setup_postdata($post);
					$the_id = get_the_ID();
		?>

		<article class="archive-post">
			<header class="archive-post_header">
				<?php
					/*
					 * articles title
					 */
					$permaLink = get_permalink();
					$titleText = get_the_title();
					echo '<h1 class="archive-post-title"><a href="'. $permaLink .'">'. $titleText .'</a></h1>';
				?>

				<?php
					edit_the_link($the_id);
				?>
			</header>

		  <footer class="meta-container">
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
	<?php
			endforeach;
		endif;
	?>
	</section>
</article>

<?php
	get_footer();
?>
