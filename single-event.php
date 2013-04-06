<?php
/**
 * @package WordPress
 * @subpackage modest3
 * イベントページを表示するためのテンプレート
 */
get_header();
?>

<article id="content"
         role="main">
  <?php
    if (have_posts()) :
      while (have_posts()) :
        the_post();
  ?>

  <?php $the_id = get_the_ID(); ?>

  <header class="entry-header">

    <?php /* post_icon($the_id,array(120,120)); */ ?>

    <h1 class="post-title"><?php echo esc_html(get_the_title()); ?></h1>

    <?php edit_the_link($the_id); ?>

  </header>

  <footer class="eventmeta">
    <?php map_image_of_the_event($the_id); ?>
    <?php the_metadata_of_event($the_id); ?>
  </footer>

  <div class="entry-body">
    <?php the_content(); ?>
  </div>

  <?php comments_template(); ?>

  <?php
      endwhile;
    else:
      echo '<p>Sorry, no posts matched your criteria</p>';
    endif;
  ?>
</article>

<?php get_footer(); ?>