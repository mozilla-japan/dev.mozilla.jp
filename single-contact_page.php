<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header();
?>

<div id="content" class="widecolumn" role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if (is_user_logged_in()): ?>
    <div <?php post_class(); ?>>
        <br />
      <h1><?php the_title(); ?></h1>
      <div class="singleentry">
      <?php the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'kubrick') . '</p>'); ?>
      </div>  
    </div>
    <?php else: ?>
    <div <?php post_class(); ?>>
    <br />
      <h1><?php the_title(); ?></h1>
    <br />
    <h2> ログインせずにコンタクトすることは出来ません。</h2>
    <br />
    <?php endif; ?>
    </div>
<?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.', 'kubrick'); ?></p>
    </div>
<?php endif; ?>

<?php get_footer(); ?>