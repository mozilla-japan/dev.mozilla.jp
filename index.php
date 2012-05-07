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
      $args = array( 'post_type' => 'event',
                     'numberposts' => 3,
                   );
      $posts = get_posts($args);
      $latest = '';
      $old = '';
      if ($posts) :
        $postcount = 0;
        foreach ($posts as $post) :
          setup_postdata($post);

          //post data
          $datetime = get_the_time('Y-m-d');
          $year = get_the_time('Y');
          $month = get_the_time('n');
          $date = get_the_time('j');
          $href = get_permalink($post->ID);
          $title = get_the_title();

          //start here document
          $content = <<< DOC
            <section>
              <time datetime="$datetime">
                <span class="posted-year">$year</span>/
                <span class="posted-month">$month</span>/
                <span class="posted-date">$date</span>/
              </time>
              <h3>
                <a href="$href" title="$title">
                  $title
                </a>
              </h3>
            </section>
DOC;
//end of here document

          if ($postcount === 0) {
            $latest = $content;
          }
          else {
            $old .= $content;
          }
          ++$postcount;
        endforeach;
      endif;
    ?>
    <div class="event-latest">
      <?php echo($latest); ?>
    </div>
    <div class="event-old">
      <?php echo($old); ?>
    </div>
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
      <p><?php the_excerpt(); ?></p>
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
