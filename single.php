<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
get_header(); ?>

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

    <h1 class="post-title"><?php the_title(); ?></h1>

    <?php edit_the_link($the_id); ?>

  </header>

  <footer class="meta-container">
    <div class="postmeta-project">
      <?php the_project_list_of_the_post($the_id); ?>
    </div>
  </footer>

  <div class="entry-body">
    <?php the_content('続きを読む'); ?>
  </div>

  <footer class="entry-footer">
    <div class="postmeta">
      <p class="postmeta-title">投稿者</p>
      <address class="postmeta-content author"><?php the_author_post_link_with_avatar(48); ?></address>
      
      <p class="postmeta-title">投稿日</p>
      <div class="postmeta-content">
        投稿日時
         <?php the_time_of_the_post($the_id); ?>
      </div>
      
      <?php if (get_the_modified_date('Y年n月j日') != get_the_time('Y年n月j日')) : ?>
      <p class="postmeta-title">更新日</p>
      <div class="postmeta-content">
        更新日時
         <?php the_time_of_final_edit(); ?>
      </div>
      <?php endif; ?>
    </div>

    <?php
      //wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

      //$post_type = get_post_type($the_id);
      //the_tags_post_type( '<p>' . __('Tags:', 'kubrick') . ' ', ', ', '</p>', $post_type);
    ?>
  </footer>

  <?php comments_template(); ?>

<?php
    endwhile;
  else:
    echo '<p>Sorry, no posts matched your criteria</p>';
  endif;
?>

</article>

<?php get_footer(); ?>