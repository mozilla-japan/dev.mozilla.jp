<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header(); ?>


<article id="content" role="main">
  <?php if (have_posts()) : ?>
  <h2 class="pagetitle">
	<?php _e('Search Results', 'kubrick'); ?></h2>
  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>
  <?php while (have_posts()) : the_post(); ?>
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
				$titleText = get_the_title();
				echo '<h1 class="archive-post-title"><a href="'. $permaLink .'">'. $titleText .'</a></h1>';
			?>

			<?php
				if (is_user_logged_in()) :
					$edit_link = get_edit_post_link($the_id);
					//here document
					echo <<< DOC
					<a href="$edit_link"
					   class="edit_post button-white">編集する</a>
DOC;
				endif;
			?>
		</header>

		<footer class="meta-container">

			<div class="postmeta-project">
				<ul class="meta-project-list">
					<?php
						$catlist = get_the_category();
						foreach ($catlist as $cat) :
							$project_array = get_post(get_project_page_ID($cat->cat_ID));
							if ($project_array->post_type == 'project') :
								$link = get_permalink($project_array->ID);
								$link_text = $project_array->post_title;
								//here doc:
								echo <<< DOC
								<li>
									<a href="$link">$link_text</a>
								</li>
DOC;
							endif;
						endforeach;
					?>
				</ul>
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
						$datetime = get_the_time('Y-m-d H:i:s');
						$date = get_the_time('Y年n月j日 G:i:s');
						echo('<time datetime="' . $datetime . '">'. $date . '</time>');
					?>
				</div>
			</div>
		</footer>

	</article>

  <?php endwhile; ?>
  <nav class="navigation">
    <?php wp_pagenavi(); ?>
  </nav>
  <?php else : ?>
  <h1 class="post-title"><p>残念ながら、キーワードに一致する記事は<br>見つけられませんでした。<br>別のキーワードをお試しください。</p></h1>
  <?php get_search_form(); ?>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
