<?php
/*
 * Template Name: event-list
 */
get_header();
?>

<article id="content">
  <header class="entry-header">
    <h1>イベント</h1>
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
        if(have_posts()) :
          foreach ($posts as $post) :
            setup_postdata($post);
      ?>
    <section class="event_summary">
      <?php
         //categoryごとのimg要素を設定する
         //$imgSrc = get_bloginfo("template_url") . '/images/icons/modest_projects.png';
         ?>
      <img class="event_icon" src=""/>
      <h1 class="event_title">
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </h1>
      <p class="event_description">
        <?php the_excerpt(); ?>
      </p>
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
