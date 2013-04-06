<?php
/**
 * @package WordPress
 * @subpackage modest3
 * プロジェクトページを表示するためのテンプレート
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
  <?php
    $the_id = get_the_ID();
    $title = get_the_title();
  ?>

  <header class="entry-header">

    <h1 class="post-title"><?php echo esc_html($title); ?></h1>

    <?php edit_the_link($the_id); ?>
  </header>

  <footer class="projectmeta">

    <div class="project-icon">
      <?php
        if (has_post_thumbnail($post->ID)) {
          the_post_thumbnail();
        }
      ?>
    </div>

    <?php the_metadata_of_project($the_id) ?>

  </footer>

  <div class="entry-body project-description">
    <?php the_content(); ?>
  </div>

  <?php
      endwhile;
    else:
      echo '<p>Sorry, no posts matched your criteria</p>';
    endif;
  ?>

  <section id="project-latest-topics-list">
    <?php
      $cat_id = get_post_meta($post->ID, 'catid', true);
      project_insert_post( $cat_id );
    ?>
    <h2>最新のトピック</h2>
    <?php
      $args = array('posts_per_page' => 5,
                    'category' => $cat_id);
      $posts = get_posts($args);
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
          $the_id = get_the_ID();
    ?>

    <article class="feed-article">
      <header>
        <?php
          /* articles title */
          $link = get_permalink();
          $titleText = get_the_title();
          echo '<h1 class="feed-article-title"><a href="'. esc_attr($link) .'">'. esc_html($titleText) .'</h1>';
        ?>

        <?php edit_the_link($the_id); ?>
      </header>

      <footer class="meta-container">
        <div class="postmeta">
          <p class="postmeta-title">投稿者</p>
          <address class="postmeta-content author"><?php
              the_author_post_link_with_avatar();
          ?></address>
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
      <?php
        $category_link = get_category_link($cat_id);
        $category_link_title = $category_link . '?list';
      ?>
      <ul class="navigation-list">
        <li class="navigation-list-item">
          <a class="navigation-list-item-link" href="<?php echo $category_link ?>">すべてのトピック</a>
        </li>
        <li class="navigation-list-item">
          <a class="navigation-list-item-link" href="<?php echo $category_link_title ?>">すべてのトピック（タイトルのみ）</a>
        </li>
      </ul>
    </nav>
  </section>

  <section id="project_rss_feed">
      <?php
      $rss_url = get_post_meta($post->ID, 'rss', true);
      if($rss_url === '') {
        //何かやりますかね？
      } else {
        echo '<h2>プロジェクトフィード</h2>';
        echo '<a style="float: right; margin-bottom: 20px;" href="'.esc_attr($rss_url).'"> RSS </a>';
        rss_feed_list($rss_url, 5);
      }
      ?>
  </section>
</article>

<?php get_footer(); ?>