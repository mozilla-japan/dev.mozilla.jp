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
    <h2 class="topsection-title">注目トピック</h2>
    <div id="hottopic-list">
      <?php
        $cat = get_category_by_slug('hot');
        $cat = $cat->term_id;
        $posts = get_posts("order=desc&category=". $cat ."&numberposts=3");
        if($posts):
          foreach($posts as $post):
            setup_postdata($post);
      ?>
        <h3 class="hottopic-item">
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h3>
      <?php
          endforeach;
        endif;
      ?>
    </div>
  </section>

  <section id="event">
    <h2 class="topsection-title">イベント</h2>
    <?php
      $args = array( 'post_type' => 'event',
                     'numberposts' => 2,
                   );
      $posts = get_posts($args);
      $latest = '';
      $old = '';
      if ($posts) :
        $postcount = 0;
        foreach ($posts as $post) :
          setup_postdata($post);
          $date_hash = get_the_date_of_the_event(get_the_ID());

          //post data
          $datetime = $date_hash['datetime'];
          $year = $date_hash['year'];
          $month = $date_hash['month'];
          $day = $date_hash['day'];
          $href = get_permalink($post->ID);
          $title = get_the_title();

          //start here document
          echo <<< DOC
            <section class="top-event-section">
              <time class="event-time" datetime="$datetime">
                <span class="posted-year">$year</span>年
                <span class="posted-month">$month</span>月
                <span class="posted-date">$day</span>日
              </time>
              <h3 class="event-title">
                <a href="$href" title="$title">
                  $title
                </a>
              </h3>
            </section>
DOC;
//end of here document

        endforeach;
      endif;
    ?>
  </section>

  <section id="blogfeed">
    <h2 class="topsection-title">
      <a href="<?php echo get_all_post_url(); ?>">最新のトピック</a>
    </h2>
    <?php
      $posts = get_posts('posts_per_page=5');
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
          $the_id = get_the_ID();
    ?>
    <article class="feed-article">
      <header>
        <h1 class="feed-article-title">
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h1>
      </header>
      <footer>
        <div class="postmeta-project">
          <?php
            the_project_list_of_the_post($the_id);
          ?>
        </div>

        <div class="postmeta">
          <p class="postmeta-title">投稿者</p>
          <address class="postmeta-content author">
            <?php
              the_author_post_link_with_avatar();
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

  <?php
  /*
  <section id="communityfeed">
    <h2>コミュニティフィード</h2>
    <?php include("community.php.inc"); ?>
  </section>
  */
  ?>
</article>
<?php get_footer(); ?>
