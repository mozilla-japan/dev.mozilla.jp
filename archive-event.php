<?php
/**
 * @package WordPress
 * @subpackage modest2.0
 */
get_header();
?>
<div id="content" class="narrowcolumn" role="main">

  <div id="EventTitle">
    <h1>Events</h1>
  </div>
  <div id="event_make">
    <h3><a href="<?php echo admin_url('post-new.php?post_type=event'); ?>">新しいイベントを登録する&#187</a></h3>
  </div>
  <?php if (have_posts()) : ?>
  <?php //$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <div class="navigation">
    <?php wp_pagenavi(); ?>
  </div>
  <?php while (have_posts()) : the_post(); ?>
  <div  <?php 
            post_class();
             $flag = odd_even($flag);
             ?>>
    <?php post_icon(get_the_ID(),array(70,70)); ?>
    <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3>
             <div class="post_header">
           <small><?php the_time(__('l, F jS, Y', 'kubrick')) ?></small>
           <a href="<?php
                    /*
                    *投稿の時間の横に投稿者とアイコンを表示する
                    */
                    $post = get_post(get_the_ID());
                    $userID = $post->post_author;
                    $user = get_userdata($userID);
                    echo get_author_link($echo = false,$userID);
                   ?>">
                  <small><?php
                             echo get_avatar($userID,15);
                            the_author(); 
                             ?></small>
                  </a>
                  </div>
             <div id="event_info">
               <div id="event_date"> 開催日：<?php echo get_post_meta($post->ID, 'date', true); ?></div>
               <div id="event_place"> 開催場所：<?php echo get_post_meta($post->ID, 'place', true); ?>  </div>
             </div>
             <div class="entry">
               <?php the_content() ?>
             </div>
             
  <p class="postmetadata">
     <?php
                              $post_type = get_post_type(get_the_ID());
the_tags_post_type('タグ:', ', ', '<br />', $post_type);
printf(__('Posted in %s', 'kubrick'), get_the_category_list_post_type(', ', '', false, $post_type));　
?>
    | 
    <?php edit_post_link(__('Edit', 'kubrick'), '', ' | '); ?>
    <?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?>
  </p>
</div>
<?php endwhile; ?>
  <div class="navigation">
    <?php wp_pagenavi(); ?>
  </div>
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
</div>
<?php get_footer(); ?>
