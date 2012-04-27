<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
?>

<nav id="sidebar">

  <h3><a href="" class="button">modestに参加する</a></h3>

  <h3><a href="" class="button">イベントを追加する</a></h3>

  <h3><a href="" class="button">ブログを投稿する</a></h3>

  <h3><a href="<?php bloginfo('url'); ?>/aboutmodest/">About modest</a></h3>

  <h3>Search</h3>
  <?php get_search_form(); ?>

  <h3>
    <?php
      // Output the link of "project" page.
      $category_id = get_cat_ID('projects');
      $category_link = get_category_link($category_id);
      echo '<a href="' . $category_link . '">プロジェクト</a>';
    ?>
  </h3>
  <ul>
    <?php wp_list_categories('title_li='); ?>
  </ul>

  <?php 
    /**
     * This login/out link is for debug
     */
  ?>
  <aside>
    <ul>
      <li><?php wp_register(); ?></li>
      <li><?php wp_loginout(); ?></li>
    </ul>
  </aside>
</nav>
