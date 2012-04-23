<?php
/*
 Category Name: Projects
*/
get_header(); ?>

<div id="content" class="narrowcolumn" role="main">
  <div id="BlogTitle">
    <h1>Blog</h1>
  </div>
  <div id="blog_post">
    <h3><a href="<?php echo admin_url('edit.php?post_type=post'); ?>">新しい記事を投稿する&#187</a></h3>
  </div>
  <?php if (have_posts()) : ?>
	<div class="navigation">
    <?php wp_pagenavi(); ?>
	</div>
	<?php while (have_posts()) : the_post(); ?>
 	<div <?php post_class();
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
                  <small>
                    <?php
                      echo get_avatar($userID,15);
                      the_author(); 
                       ?>
                  </small>
                </a>
        </div>
				<div class="entry">
					<?php the_content() ?>
				</div>
				<p class="postmetadata"><?php the_tags(__('Tags:', 'kubrick'), ', ', '<br />'); ?> <?php printf(__('Posted in %s', 'kubrick'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'kubrick'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?></p>
	</div>
	<?php endwhile; ?>
	<div class="navigation">
    <?php wp_pagenavi(); ?>
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
</div>

<?php get_footer(); ?>
