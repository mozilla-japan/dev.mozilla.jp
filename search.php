<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header(); ?>


<article id="content" role="main">
  <?php
    query_posts($query_string .'&posts_per_page=20');
    if (have_posts()) :
  ?>
  <h1 class="post-title"><?php the_search_query(); ?> の検索結果
    <small><?php
      echo " ".$wp_query->found_posts ."件";
    ?></small>
  </h1>

  <?php while (have_posts()) : the_post(); ?>

  <?php $the_id = get_the_ID(); ?>

  <article class="searchresult-article">
    <header>
      <h1 class="searchresult-article-title">
        <?php $title = get_the_title(); ?>
        <a href="<?php the_permalink() ?>" title="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></a>
      </h1>
    </header>

    <footer>
      <div class="postmeta-project">
        <?php the_project_list_of_the_post($the_id); ?>
      </div>

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

  <?php endwhile; ?>
  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>
  <?php else : ?>
    <h1 class="post-title">残念ながら、キーワードに一致する記事は<br />見つけられませんでした。<br />別のキーワードをお試しください。</h1>
    <?php get_search_form(); ?>
  <?php endif; ?>
</div>

<?php get_footer(); ?>