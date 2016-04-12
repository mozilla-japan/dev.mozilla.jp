<?php
/*
 * modestのトップページを編集するときに必要
 */
/*
Template Name: index
 */
get_header();
?>
<article id="content">

  <section id="hottopic">
    <h2 class="topsection-title">注目トピック</h2>
    <div id="hottopic-list">
      <?php
        $cat = get_category_by_slug('hot');
        $cat = $cat->term_id;
        $posts = get_posts("order=desc&category=". $cat ."&numberposts=3");
        if($posts):
          foreach($posts as $post):
            setup_postdata($post);
      ?>
        <h3 class="hottopic-item">
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h3>
      <?php
          endforeach;
        endif;
      ?>
    </div>
  </section>

  <section id="blogfeed">
    <h2 class="topsection-title">最新のトピック</h2>
    <?php
      $posts = get_posts('posts_per_page=5');
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
          $the_id = get_the_ID();
    ?>
    <article class="feed-article">
      <header>
        <h1 class="feed-article-title">
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h1>
      </header>
      <footer>
        <div class="postmeta-project">
          <?php
            the_project_list_of_the_post($the_id);
          ?>
        </div>

        <div class="postmeta">
          <p class="postmeta-title">投稿者</p>
          <address class="postmeta-content author">
            <?php
              the_author_post_link_with_avatar();
            ?>
          </address>

          <p class="postmeta-title">投稿日時</p>
          <div class="postmeta-content">
            <?php
              the_time_of_the_post($the_id);
            ?>
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
        $allpost_link = get_all_post_url();
        $allpost_link_title = $allpost_link . '?list';
      ?>
      <ul class="navigation-list">
        <li class="navigation-list-item">
          <a class="navigation-list-item-link" href="<?php echo $allpost_link; ?>">すべてのトピック</a>
        </li>
        <li class="navigation-list-item">
          <a class="navigation-list-item-link" href="<?php echo $allpost_link_title; ?>">すべてのトピック（タイトルのみ）</a>
        </li>
      </ul>
    </nav>
  </section>
</article>
<?php get_footer(); ?>
