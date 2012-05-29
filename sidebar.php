<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
?>

<nav id="sidebar">

  <div id="sidebar-button-group">

    <?php if(is_user_logged_in() == false) : ?>
      <h3><a href="<?php echo get_join_modest_url(); ?>" class="button-blue join">ログインする/参加する</a></h3>
    <?php endif; ?>

    <h3><a href="<?php echo get_add_post_url(); ?>" class="button-blue join">トピックを投稿する</a></h3>

    <h3><a href="<?php echo get_add_event_url(); ?>" class="button-blue join">イベントを追加する</a></h3>

    <?php if( is_user_logged_in() ) : ?>
      <h3><a href="<?php echo get_add_project_url(); ?>" class="button-blue join">プロジェクトを作成</a></h3>

    <?php endif; ?>

  </div>

  <h3 id="sidebar-about"><a href="<?php echo get_about_url(); ?>">このサイトについて</a></h3>

  <div id="sidebar-search">
    <?php get_search_form(); ?>
  </div>

  <div id="sidebar-project">
    <h3>
      <a href="<?php echo get_project_url(); ?>">プロジェクト</a>
    </h3>
    <ul id="sidebar-project-list">
      <?php
      $args = array( 'post_type' => 'project',
                     'posts_per_page' => -1 );
      $loop = new WP_Query( $args );
      while($loop->have_posts() ) : $loop-> the_post();
      echo '<li class="project-item project-tem-';
      the_ID();
      echo '">';
          echo '<a href="';
                         the_permalink();
                         echo '" title="';
                                        the_title();
                                        echo '" > ';
            the_title();
            echo '</a>';
          echo '</li>';
      endwhile;
      ?>
    </ul>
  </div>
</nav>
