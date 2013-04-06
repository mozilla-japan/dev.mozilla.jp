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
      <h3 class="hottopic-item"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php
        the_title();
      ?></a></h3>
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
                     'numberposts' => 5,
                   );
      $posts = get_posts($args);
      $future = 0;
      foreach($posts as $post) :
        setup_postdata($post);
        $id = get_the_ID();
        $start = (int)get_post_meta($id, 'start_time', true);
        $now = time();
        if(($start - $now) > 0) {
          $future++;
        }
        $sortary[$start] = $id;
      endforeach;
      krsort($sortary);
      if ($posts) :
        $postcount = 0;
        $future = $future - 2;
        foreach($sortary as $post) :

          if($future <= 0) :
            $postary = get_post($post, 'ARRAY_A', 'display');
            $date_hash = get_the_time_of_the_event($post);
            //post data
            $datetime = $date_hash['datetime'];
            $year = $date_hash['year'];
            $month = $date_hash['month'];
            $day = $date_hash['day'];
            $href = get_permalink($post);
            $title_raw = $postary['post_title'];
            $title_attr = esc_attr($title_raw);
            $title_text = esc_html($title_raw);

            //start here document
            echo <<< DOC
              <section class="top-event-section">
                <time class="event-time" datetime="$datetime">
                  <span class="posted-year">$year</span>年
                  <span class="posted-month">$month</span>月
                  <span class="posted-day">$day</span>日
                </time>
                <h3 class="event-title"><a href="$href" title="$title_attr">$title_text</a></h3>
              </section>
DOC;
///end of here document
          $postcount++;
            if($postcount >= 2) {
              break;
            }
          endif;
          $future = $future - 1;
        endforeach;
      endif;
    ?>
  </section>

  <section id="blogfeed">
    <h2 class="topsection-title">最新のトピック</h2>
    <?php
      $posts = get_posts('posts_per_page=5');
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
          $the_id = get_the_ID();
    ?>
    <article class="feed-article">
      <header>
        <h1 class="feed-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php
          the_title();
        ?></a></h1>
      </header>
      <footer>
        <div class="postmeta-project">
          <?php the_project_list_of_the_post($the_id); ?>
        </div>

        <div class="postmeta">
          <p class="postmeta-title">投稿者</p>
          <address class="postmeta-content author"><?php the_author_post_link_with_avatar(); ?></address>

          <p class="postmeta-title">投稿日時</p>
          <div class="postmeta-content">
            <?php the_time_of_the_post($the_id); ?>
          </div>
        </div>

      </footer>
    </article>
    <?php
        endforeach;
      endif;
    ?>
    <nav class="navigation">
      <?php
        $allpost_link = get_all_post_url();
        $allpost_link_title = $allpost_link . '?list';
      ?>
      <ul class="navigation-list">
        <li class="navigation-list-item"><a class="navigation-list-item-link" href="<?php echo $allpost_link; ?>">すべてのトピック</a></li>
        <li class="navigation-list-item"><a class="navigation-list-item-link" href="<?php echo $allpost_link_title; ?>">すべてのトピック（タイトルのみ）</a></li>
      </ul>
    </nav>
  </section>

  <section id="communityfeed">
    <?php $rss = "http://pipes.yahoo.com/pipes/pipe.run?_id=4ca627cffb9c117406bf928791b272d4&_render=rss&itemlimit=25"; ?>
    <h2 class="topsection-title"> コミュニティフィード</h2>
    <?php
       $template = get_bloginfo('template_url');
       //$rss_url = $template.'/mozdevfeeds.xml';
       $php_url = $template.'/mozdevfeeds.data';
       //rss_feed_list($rss_url, 5);
       php_feed_list($php_url, 5);
       //include("community.php.inc"); 
     ?>
    <nav class="navigation">
      <ul class="navigation-list">
        <li class="navigation-list-item"><a class="navigation-list-item-link" href="<?php echo get_feed_url(); ?>">より古いコミュニティフィードを読む &raquo;</a></li>
      </ul>
    </nav>

  </section>
</article>

<?php get_footer(); ?>