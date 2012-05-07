<?php
/*
 * Template Name: projects-list
 */
get_header();
?>

<article id="content">
  <hgroup>
    <h1>プロジェクト</h1>
    <h2>
      <a class="button"
         href="<?php echo admin_url('post-new.php?post_type=project'); ?>">
        新しいプロジェクトを登録する
      </a>
    </h2>
  </hgroup>
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
      <?php
         //categoryごとのimg要素を設定する
         //$imgSrc = get_bloginfo("template_url") . '/images/icons/modest_projects.png';
         ?>
      <img class="project_icon" src=""/>
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
