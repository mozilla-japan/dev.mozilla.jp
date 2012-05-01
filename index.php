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
    <?php
      $posts = get_posts( array( 'post_type' => 'event' ) );
      if ($posts) :
        $postcount = 0;
        foreach ($posts as $post) :
          setup_postdata($post);
          $class = ($postcount === 0 ?) 'event-left' : 'event-right';
    ?>
    <dev class="<?php echo($class) ?>">
      <section>
        <?php
          $datetime = get_the_time('Y-m-d');
          $date = get_the_time('y-m-d (D)');
          echo '<time datetime="' . $datetime . '">'. $date . '</time>';
        ?>
        <h3>
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        <h3>
        <p><?php the_content(); ?></p>
      </section>
    </dev>
    <?php
          ++$postcount;
        endforeach;
      endif;
    ?>
  </section>

  <section id="blogfeed">
    <h2>ブログフィード</h2>
    <?php
      $posts = get_posts('posts_per_page=5');
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
    ?>
    <section>
      <header>
        <h1>
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h1>
        <?php
          $datetime = get_the_time('Y-m-d');
          $date = get_the_time('y-m-d (D)');
          echo '<time datetime="' . $datetime . '">'. $date . '</time>';
        ?>
      </header>
      <p><?php the_content(); ?></p>
      <footer>
        <?php the_category(); ?>
      </footer>
    </section>
    <?php
        endforeach;
      endif;
    ?>

  </section>

</article>
<?php get_footer(); ?>
