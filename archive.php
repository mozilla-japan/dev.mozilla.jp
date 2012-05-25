<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header();
?>

<article id="content">

	<h1 class="post-title"><?php wp_title(); ?></h1>

<?php
	if (have_posts()) :
?>

	<nav class="navigation">
		<?php navigation_bar(); ?>
	</nav>

<?php
		while (have_posts()) :
			the_post();
?>

	<?php
		$the_id = get_the_ID();
	?>

	<article class="archive-post">

		<header class="archive-post_header">
			<?php
				//post_icon(get_the_ID(),array(70,70));
			?>

			<?php
				/*
				* article's title
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

<?php
		endwhile;
?>

	<nav class="navigation">
		<?php navigation_bar(); ?>
	</nav>

<?php
	else :
		$string;
		if ( is_category() ) { // If this is a category archive
			$string = 'このカテゴリに関連付けられた投稿はありません。';
		} else if ( is_date() ) { // If this is a date archive
			$string = 'この日付に投稿された投稿はありません。';
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			$string = $userdata->display_name .'によって書かれた投稿はありません。';
		} else {
			$string = '投稿が見つかりません。';
		}
		echo <<< DOC
			<p class="postmeta">$string</p>
DOC;
			get_search_form();
	endif;
?>

</article>

<?php
	get_footer();
?>
