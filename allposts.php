<?php
/*
 * Template Name: all_posts
 * すべての投稿を表示するためのテンプレート
 */
get_header();
?>

<article id="content">
  <header class="entry-header">
    <h1 class="post-title">投稿されたすべてのトピック</h1>
  </header>
      <?php
         $paged = get_query_var('paged');
         $posts = query_posts(array("post_type" => array("post"),
                                    "paged" => $paged,
                                    "posts_par_page" => 5,
                                    "meta_key " => $_GET['key'],
                                    "meta_value" => $_GET['value'],
                                    "orderby" => "date"));
         $isList = isset($_GET["list"]);
      ?>

      <?php
        if(have_posts()) :
          foreach ($posts as $post) :
            setup_postdata($post);
            $the_id = get_the_ID();
         ?>
      <?php
        $class = $isList ? 'archive-post list' : 'archive-post';
      ?>
      <article class="<?php echo $class; ?>">
        
        <header class="archive-post_header">
          <?php /* post_icon(get_the_ID(),array(70,70)); */ ?>
          
          <h1 class="archive-post-title">
            <?php
              /*
               * article's title
               */
              $permaLink = get_permalink();
              $titleText = get_the_title();
              echo '<a href="'. esc_attr($permaLink) .'">'. esc_html($titleText) .'</a>';
            ?>
          </h1>

          <?php edit_the_link($the_id); ?>
        </header>
        
        <footer class="meta-container">
          
          <div class="postmeta-project">
            <?php the_project_list_of_the_post($the_id); ?>
          </div>
          
        </footer>

        <?php if(!$isList): ?>
          <div class="entry-body">
            <?php the_content() ?>
          </div>
        <?php endif; ?>

        <footer class="entry-footer">
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
      <?php navigation_bar(); ?>
    </nav>
</article>

<?php get_footer(); ?>