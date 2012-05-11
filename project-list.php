<?php
/*
 * Template Name: projects-list
 */
get_header();
?>

<article id="content">
  <header class="entry-header">
    <h1>プロジェクト</h1>
    <p>
      <a class="button button-white"
         href="<?php echo admin_url('post-new.php?post_type=project'); ?>">
        新しいプロジェクトを登録する
      </a>
    </p>
  </header>
      <?php
         $paged = get_query_var('paged');
         $posts = query_posts(array("post_type" => array("project"),
                                    "paged" => $paged,
                                    "posts_par_page" => 5,
                                    "meta_key " => $_GET['key'],
                                    "meta_value" => $_GET['value'],
                                    "orderby" => "date"));
      ?>
      <nav class="navigation">
        <?php wp_pagenavi(); ?>
      </nav>
      <?php
        if(have_posts()) :
          foreach ($posts as $post) :
            setup_postdata($post);
      ?>
    <section class="project_summary">
      <div class="project_icon">
        <?php
         if( has_post_thumbnail($post->ID)){
           the_post_thumbnail();
         }
         //サムネイルがない場合はない場合で表示する必要はないのでは。
         ?>
      </div>
      <h1 class="project_title">
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </h1>
      <p class="project_description">
        <?php the_excerpt(); ?>
      </p>
    </section>
    <?php
       endforeach;
       endif;
    ?>
    <nav class="navigation">
      <?php wp_pagenavi(); ?>
    </nav>
</article>

<?php get_footer(); ?>
