<?php
/*
 * modestのトップページを編集するときに必要
 */
/*
Template Name: index
 */
get_header();
?>
<article id="content">
  <section id="hottopic">
    <h2>注目トピック</h2>
    <?php
      $cat = get_query_var('hot');
      $posts = get_posts("order=desc&category=". $cat ."&numberposts=6");
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
    ?>
      <h3>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </h3>
    <?php
        endforeach;
      endif;
    ?>
  </section>

  <section id="event">
    <h2>イベント</h2>
    <div id="event-contents">
      <?php 
         $posts = get_posts( array( 'post_type' => 'event' ) );
         $postcount = 0;
         ?>
      <?php if($posts): foreach($posts as $post): setup_postdata($post); ?>
      <?php if($postcount == 0){ ?>
      <dev id="event-left">
        <?php
          $datetime = get_the_time('Y-m-d');
          $date = get_the_time('y-m-d (D)');
          echo '<time datetime="' . $datetime . '">'. $date . '</time> : ';
        ?>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
        <p> <?php the_content(); ?> </p>
      </dev>
      <?php } else { ?>
      <dev id="event-right">
        <?php
          $datetime = get_the_time('Y-m-d');
          $date = get_the_time('y-m-d (D)');
          echo '<time datetime="' . $datetime . '">'. $date . '</time> : ';
        ?>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </dev>
      <?php } ?>
      <?php $postcount++; endforeach; endif;?>
    </div>
  </section>

  <section id="blogfeed">
    <h2>ブログフィード</h2>
    <div id="blog-contents">
      <?php $posts = get_posts('posts_per_page=5'); ?>
      <?php if($posts): foreach($posts as $post): setup_postdata($post); ?>
      <div id="blogpost-<?php the_ID()?>">
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
        <?php the_time('y-m-d (D)');?>
        <?php the_author();?>
        <p> <?php the_content(); ?> </p>
        <p> <?php the_category(); the_tags(); ?> </p>
        <?php edit_post_link('編集する','<p>','</p>'); ?>
      </div>
      <?php endforeach; endif; ?>
    </div>

  </section>

</article>
<?php get_footer(); ?>
