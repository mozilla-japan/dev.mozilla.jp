<?php
/*
 * Template Name: projects-list
 */
get_header();
?>

<article id="content">

  <header class="entry-header">
    <h1 class="post-title">プロジェクト</h1>
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
    <?php navigation_bar(); ?>
  </nav>

  <?php
    if (have_posts()) :
      foreach ($posts as $post) :
        setup_postdata($post);
  ?>

    <section class="project-section">

      <div class="project-icon">
        <?php
          if (has_post_thumbnail($post->ID)) {
           the_post_thumbnail();
          }
        ?>
      </div>

      <h1 class="project-title">
        <?php
          $title = get_the_title();
        ?>
        <a href="<?php the_permalink() ?>" title="<?php echo $title; ?>">
          <?php echo $title; ?>
        </a>
      </h1>
 
      <p class="project-summary">
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

<?php
  get_footer();
?>
