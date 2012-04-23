<?php
/*
 * modestのトップページを編集するときに必要
 */
/*
Template Name: index
 */
get_header();
?>
<?php
query_posts(array('post_type' => array('event','post','projects'),
                  'paged' => $paged));
?>
<div id="content" class="narrowcolumn" role="main">
  <?php if (have_posts()) :?>
	  <div class="navigation">
      <?php wp_pagenavi(); ?>
	  </div>

 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php printf(__('Archive for the &#8216;%s&#8217; Category', 'kubrick'), single_cat_title('', false)); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle"><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'kubrick'), single_tag_title('', false) ); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Daily archive page', 'kubrick'), get_the_time(__('F jS, Y', 'kubrick'))); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Monthly archive page', 'kubrick'), get_the_time(__('F, Y', 'kubrick'))); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php printf(_c('Archive for %s|Yearly archive page', 'kubrick'), get_the_time(__('Y', 'kubrick'))); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive', 'kubrick'); ?></h2>
 	  <?php } ?>

    <?php while (have_posts()) : the_post();?>
        <div 
          <?php 
            post_class();
             $flag = odd_even($flag);
             ?>>
         <?php
            post_icon(get_the_ID(),array(70,70));
            ?>
         <div class="post_title">
				 <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3> 
         </div>
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
				 <div class="entry">
					<?php the_content() ?>
				 </div>
				 <p class="postmetadata">
           <?php 
              $post_type = get_post_type(get_the_ID());
              the_tags_post_type('タグ:', ', ', '<br />', $post_type);
              printf(__('Posted in %s', 'kubrick'), get_the_category_list_post_type(', ', '', false, $post_type));
              ?>
 | <?php edit_post_link(__('Edit', 'kubrick'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?></p>
			</div>
		<?php endwhile; ?>
    <?php
       $modest_rss = get_bloginfo_rss('rss2_url');
       $modest_link = get_bloginfo('url');
       //トップページに表示するRSSのフィードはこのArrayにいれる．
       $rsslist = array("https://dev.mozilla.jp/wp-content/themes/modest/mozdevfeeds.xml");
       $rssitem = mixed_rss($rsslist);
       foreach($rssitem as $item){
       $feed++;
       if($feedmax <= $modest_post && $item["blink"] == $modest_link) {
           continue; 
       }
       if($paged >= 2 && $feed <= ($paged*5)){
           continue;
       }
       if($feedmax++ == 5) { 
           break;
       }
       echo '<div class ="post" ';
       /*
        *投稿の種類によって背景の色を変更する
        */
       if($color_flag == false){
           $color_flag = true;
           odd_even($color_flag);
       }else if($color_flag == true){
           $color_flag = false;
           odd_even($color_flag);
       }
       echo '>';
       echo '<div class="post_icon">';
       echo '<img src="'. get_bloginfo("template_url").'/images/icons/modest_rss.png" width="70"/>';
       echo '</div>';
       echo '<div class="post_title"><h3> <a href="'.$item["link"].'">'.$item["title"].'</a></h3></div>';
       echo '<div class="post_header">';
       echo '<small>'.Date("Y/M/d D, H:i:s",strtotime($item["pubdate"])).'</small>';
       echo '<small> | <a href="'.$item["blink"].'">'.$item["btitle"].'</a></small>';
       echo '</div>';
       echo '<div class="entry">'.$item["summary"].'</div>';
       echo '<p class="postmetadata">'.$item["category"].'</p>';
       echo '</div>';
       }
?>
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
