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
    <div id="hottopic-contents">
      <?php
         $cat = get_query_var('hot');
         $posts = get_posts("order=desc&category=$cat&numberposts=6");
         ?>
      <ul> 
        <?php
           if($posts): foreach($posts as $post): setup_postdata($post); ?>
        <li id="catpost-<?php the_ID(); ?>">
          <?php the_time('y-m-d (D)'); ?> :
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </li>
        <?php endforeach; endif;?>
      </ul>
    </div>
  </section>

  <section id="event">
    <h2>イベント</h2>
  </section>

  <section id="blogfeed">
    <h2>ブログフィード</h2>
  </section>

</article>
<?php get_footer(); ?>
