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
    <div class="section">
      <?php
        $cat = get_query_var('hot');
        $posts = get_posts("order=desc&category=". $cat ."&numberposts=3");
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
    </div>
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
            <section class="section">
              <time datetime="$datetime">
                <span class="posted-year">$year</span>
                <span class="posted-month">$month</span>
                <span class="posted-date">$date</span>
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
    <h2>
      <a href="<?php echo get_all_post_url(); ?>">最新の投稿</a>
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
        <h1>
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
