<?php
/*
 * Template Name: com-feeds
 * すべての投稿を表示するためのテンプレート
 */
get_header();
?>

<article id="content">
  <header class="entry-header">
    <h1 class="post-title">コミュニティフィード</h1>
  </header>
  <section id="communityfeed">
    <?php
       $template = get_bloginfo('template_url');
       $php_url = $template.'/mozdevfeeds.data';
       php_feed_list($php_url, 50);
     ?>
  </section>
</article>

<?php get_footer(); ?>