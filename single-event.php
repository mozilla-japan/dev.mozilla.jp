<?php
/**
 * @package WordPress
 * @subpackage modest3
 * イベントページを表示するためのテンプレート
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

  <footer>

    <div class="postmeta-project">
      <?php
        the_project_list_of_the_post($the_id);
      ?>
    </div>

    <div class="eventmeta">

      <dl>
        <dt>開催時間</dt>
        <dd>
          <?php
            data_of_the_event($the_id, 'start_time');
          ?>
           -
          <?php
            data_of_the_event($the_id, 'end_time');
          ?>
        </dd>

        <dt>定員</dt>
        <dd>
          <?php
            data_of_the_event($the_id, 'capacity');
          ?>
        </dd>

        <dt>会場</dt>
        <dd>
          <?php
            data_of_the_event($the_id, 'place');
          ?>
        </dd>

        <dt>参考URL</dt>
        <dd>
          <?php
            data_of_the_event($the_id, 'url');
          ?>
        </dd>

        <dt>ハッシュタグ</dt>
        <dd>
          <?php
            data_of_the_event($the_id, 'hashtag');
          ?>
        </dd>

        <dt>イベント管理者</dt>
        <dd>
				  <?php
					  $post = get_post($the_id);
					  $userID = $post->post_author;
  					echo get_avatar($userID, 15);//avatar image
  					echo the_author_posts_link();//auther link
				  ?>
        </dd>
      </dl>

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
</article>

<?php get_footer(); ?>
