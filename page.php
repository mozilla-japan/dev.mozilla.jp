<?php
/**
 * @package WordPress
 * @subpackage modest3
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

  <header class="entry-header">

    <h1 class="post-title"><?php the_title(); ?></h1>

  </header>


  <div class="entry-body">
    <?php
      the_content('続きを読む');
    ?>
  </div>


<?php
    endwhile;
  else:
    echo '<p>Sorry, no posts matched your criteria</p>';
  endif;
?>

</article>

<?php get_footer(); ?>
