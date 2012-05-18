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
    <?php
       /*
       button-blueとかにすれば分かりやすいかも？
       */
       $url = get_post_meta($post->ID, 'url', true);
       echo "<a href=". $url .">プロジェクトのWebサイト</a>";
    ?>
    <div class="section">
      <ul>
        <li>
          開催時間：
          <?php 
             $start_time = get_post_meta($post->ID, 'start_time', true);
             if($start_time){
               echo $start_time;
             }else{
               echo "未定";
             }
          ?>
           〜 
          <?php
             $end_time = get_post_meta($post->ID, 'end_time', true);
          if($end_time){
            echo $end_time;
          }else{
            echo "未定";
          }
          ?>
        </li>
        <li>
          定員：<?php 
                   $capacity = get_post_meta($post->ID, 'capacity', true); 
          if($capacity){
            echo $capacity;
          }else{
            echo "未定";
          }
          ?>
        </li>
        <li>
          会場：<?php 
                   $place = get_post_meta($post->ID, 'place', true); 
          if($place){
            echo $place;
          }else{
            echo "未定";
          }
          ?>
        </li>
        <li>
          参考URL：
          <?php $url = get_post_meta($post->ID, 'url', true);
          if($url){
            echo "<a href=". $url .">". $url ."</a>";
          }else{
            echo "未定";
          }?>
        </li>
        <li>
          ハッシュタグ：<?php 
                           $hashtag = get_post_meta($post->ID, 'hashtag', true); 
          if($hashtag){
            echo $hashtag;
          }else{
            echo "未定";
          }
          ?>
        </li>
        <li>
				  <?php
					   $post = get_post($the_id);
					   $userID = $post->post_author;
					echo get_avatar($userID, 15);//avatar image
					echo the_author_posts_link();//auther link
				  ?>
        </li>
      </ul>
    </div>
	</header>

	<div class="entry-body">
		<?php
			the_content();
		?>
	</div>

	<footer class="entry-footer">
    <div class="postmeta">
			<p class="postmeta-title">投稿者</p>
			<address class="postmeta-content">
			</address>
		</div>    
	</footer>

  <?php
	  	endwhile;
	  else:
		  echo '<p>Sorry, no posts matched your criteria</p>';
	  endif;
  ?>
</article>

<?php get_footer(); ?>
