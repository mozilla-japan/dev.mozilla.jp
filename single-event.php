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

    <div class="event-meta">

      <dl>
        <dt>開催時間</dt>
        <dd>
          <?php
            $start_time = get_post_meta($post->ID, 'start_time', true);
            if($start_time){
              echo $start_time;
            }else{
              echo "未定";
            }
          ?>
           -
          <?php
            $end_time = get_post_meta($post->ID, 'end_time', true);
            if($end_time){
              echo $end_time;
            }else{
              echo "未定";
            }
          ?>
        </dd>

        <dt>定員</dt>
        <dd>
          <?php
            $capacity = get_post_meta($post->ID, 'capacity', true);
            if($capacity){
              echo $capacity;
            }else{
              echo "未定";
            }
          ?>
        </dd>

        <dt>会場</dt>
        <dd>
          <?php
            $place = get_post_meta($post->ID, 'place', true);
            if($place){
              echo $place;
            }else{
              echo "未定";
            }
          ?>
        </dd>

        <dt>参考URL</dt>
        <dd>
          <?php
            $url = get_post_meta($post->ID, 'url', true);
            if($url){
              echo "<a href=". $url .">". $url ."</a>";
            }else{
              echo "未定";
            }
          ?>
        </dd>

        <dt>ハッシュタグ</dt>
        <dd>
          <?php
            $hashtag = get_post_meta($post->ID, 'hashtag', true);
            if($hashtag){
              echo $hashtag;
            }else{
              echo "未定";
            }
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
