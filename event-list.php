<?php
/*
 * Template Name: event-list
 */
get_header();
?>

<article id="content">

  <header class="entry-header">
    <h1 class="post-title">イベント</h1>
    <p>
      <a class="button button-white"
         href="<?php echo admin_url('post-new.php?post_type=event'); ?>">
        新しいイベントを登録する
      </a>
    </p>
  </header>

  <?php
     $paged = get_query_var('paged');
     $posts = query_posts(array("post_type" => array("event"),
                                "paged" => $paged,
                                "posts_par_page" => 5,
                                "meta_key " => $_GET['key'],
                                "meta_value" => $_GET['value'],
                                "orderby" => "date"));
  ?>

  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>

  <?php
    if (have_posts()) :
      foreach ($posts as $post) :
        setup_postdata($post);
        $the_id = get_the_ID();
  ?>

    <section class="event-section">
      <header class="event-header">
        <h1 class="event-title">
          <?php
            $title = get_the_title();
          ?>
          <a href="<?php the_permalink() ?>" title="<?php echo $title; ?>">
            <?php echo $title; ?>
          </a>
        </h1>
      </header>
 
      <footer class="event-footer">

        <dl class="event-metadata-list">
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

        <div class="event-summary">
          <?php the_excerpt(); ?>
        </div>

      </footer>

    </section>

  <?php
      endforeach;
    endif;
  ?>

  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>

</article>

<?php get_footer(); ?>
