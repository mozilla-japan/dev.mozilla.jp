<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
?>

<nav id="sidebar">

  <h3><a href="<?php get_join_modest_url(); ?>" class="button-blue">modestに参加する</a></h3>

  <h3><a href="<?php get_add_event_url(); ?>" class="button-blue">イベントを追加する</a></h3>

  <h3><a href="<?php get_add_post_url(); ?>" class="button-blue">記事を投稿する</a></h3>

  <h3 id="about"><a href="<?php echo get_about_url(); ?>">About modest</a></h3>

  <div id="search">
    <h3>Search</h3>
    <?php get_search_form(); ?>
  </div>

  <div id="project">
    <h3>
      <a href="<?php echo get_project_url(); ?>">プロジェクト</a>
    </h3>
    <ul>
      <?php
         $paged = get_query_var('paged');
         $posts = query_posts(array("post_type" => array("project"),
      "paged" => $paged,
      "orderby" => "date",
      "nopaging" => true));
      if(have_posts()){
        foreach ($posts as $post):
        setup_postdata($post);
        echo '<li class="project-item project-item-';
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
        endforeach;
      }
      ?>
    </ul>
  </div>

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
