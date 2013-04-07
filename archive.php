<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

get_header();
?>

<article id="content">

  <h1 class="post-title"><?php wp_title(); ?></h1>
<?php
  $isList = isset($_GET["list"]);
  if (have_posts()) :
?>


<?php
    while (have_posts()) :
      the_post();
?>

  <?php $the_id = get_the_ID(); ?>

  <?php $class = $isList ? 'archive-post list' : 'archive-post'; ?>
  <article class="<?php echo $class; ?>">

    <header class="archive-post_header">
      <?php /*post_icon(get_the_ID(),array(70,70)); */?>

      <h1 class="archive-post-title">
        <?php
          /*
          * article's title
          */
          $permaLink = get_permalink();
          $titleText = get_the_title();
          echo '<a href="'. $permaLink .'">'. esc_html($titleText) .'</a>';
        ?>
      </h1>

      <?php edit_the_link($the_id); ?>
    </header>

    <footer class="meta-container">

      <div class="postmeta-project">
        <?php the_project_list_of_the_post($the_id); ?>
      </div>

    </footer>
    <?php 
       if(!$isList): ?>
      <div class="entry-body">
        <?php the_content() ?>
      </div>
    <?php endif; ?>
    <footer class="entry-footer">
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

<?php
    endwhile;
?>

  <nav class="navigation">
    <?php navigation_bar(); ?>
  </nav>

<?php
  else :
    $string;
    if ( is_category() ) { // If this is a category archive
      $string = 'このカテゴリに関連付けられた投稿はありません。';
    } else if ( is_date() ) { // If this is a date archive
      $string = 'この日付に投稿された投稿はありません。';
    } else if ( is_author() ) { // If this is a category archive
      $userdata = get_userdatabylogin(get_query_var('author_name'));
      $string = esc_html($userdata->display_name) .'によって書かれた投稿はありません。';
    } else {
      $string = '投稿が見つかりません。';
    }
    echo <<< DOC
      <p class="postmeta">$string</p>
DOC;
  endif;
?>

</article>

<?php get_footer(); ?>