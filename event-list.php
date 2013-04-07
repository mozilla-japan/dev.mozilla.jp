<?php
/*
 * Template Name: event-list
 */
get_header();
?>

<article id="content">

  <header class="entry-header">
    <h1 class="post-title">イベント</h1>
    <p class="add-button">
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
          <a href="<?php the_permalink() ?>" title="<?php echo esc_attr($title); ?>">
            <?php echo esc_html($title); ?>
          </a>
        </h1>
      </header>
 
      <footer class="event-footer">

        <?php the_metadata_of_event($the_id); ?>

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