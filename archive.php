<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header();
?>

<article id="content" class="narrowcolumn" role="main">

  <div id="content_title">
    <h1>modest <?php wp_title(); ?></h1>
  </div>

<?php if (have_posts()) : ?>

  <nav class="navigation">
    <?php wp_pagenavi(); ?>
  </nav>

<?php while (have_posts()) : the_post(); ?>

  <article <?php post_class();
             $flag = odd_even($flag);?>>

    <?php post_icon(get_the_ID(),array(70,70)); ?>

    <?php
      /*
       * article's title
       */
      $postID = get_the_ID();
      $permaLink = get_permalink();
      $titleText = get_the_title();
      echo('<h1 id="post-' . $postID . '"><a href="' . $permaLink . '">' . $titleText . '</a></h1>');
    ?>

    <header class="post_header">
      <?php
        /* Show the post date */
        $datetime = get_the_time('Y-m-d H:i:s');
        $date = get_the_time('Y年n月d日 G:i:s');
        echo('<time datetime="' . $datetime . '">'. $date . '</time>');
      ?>

      <address>
        <?php
          /* 投稿者とアイコンを表示する */
          $post = get_post(get_the_ID());
          $userID = $post->post_author;
          echo get_avatar($userID, 15);//avatar image
          echo get_the_author_link();//auther link
        ?>
      </address>
      <nav>
        <?php
          edit_post_link(__('編集', 'kubrick'), '', '');
        ?>
      </nav>
    </header>

    <div class="entry">
      <?php the_content() ?>
    </div>

    <footer>
      <p class="postmetadata">
      <?php 
        $post_type = get_post_type(get_the_ID());
        the_tags_post_type('タグ:', ', ', '<br />', $post_type);
        printf(__('Posted in %s', 'kubrick'), get_the_category_list_post_type(', ', '', false, $post_type));
      ?>
       | 
      <?php
        comments_popup_link(__('No Comments &#187;', 'kubrick'),
                            __('1 Comment &#187;', 'kubrick'),
                            __('% Comments &#187;', 'kubrick'),
                            '',
                            __('Comments Closed', 'kubrick') );
      ?>
      </p>
    </footer>

  </article>

<?php endwhile; ?>

<nav class="navigation">
  <?php wp_pagenavi(); ?>
</nav>

<?php else :
if ( is_category() ) { // If this is a category archive
  printf("<h2 class='center'>".__("Sorry, but there aren't any posts in the %s category yet.", 'kubrick').'</h2>', single_cat_title('',false));
} else if ( is_date() ) { // If this is a date archive
  echo('<h2>'.__("Sorry, but there aren't any posts with this date.", 'kubrick').'</h2>');
} else if ( is_author() ) { // If this is a category archive
  $userdata = get_userdatabylogin(get_query_var('author_name'));
  printf("<h2 class='center'>".__("Sorry, but there aren't any posts by %s yet.", 'kubrick')."</h2>", $userdata->display_name);
} else {
  echo("<h2 class='center'>".__('No posts found.', 'kubrick').'</h2>');
}
get_search_form();
endif;
?>

</article>

<?php get_footer(); ?>
