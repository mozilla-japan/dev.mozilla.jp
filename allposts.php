<?php
/*
 * Template Name: all_posts
 * すべての投稿を表示するためのテンプレート
 */
get_header();
?>

<article id="content">
  <header class="entry-header">
    <p>
      <a class="button button-white"
         href="<?php echo admin_url('post-new.php'); ?>">
        新しいトピックを投稿する
      </a>
    </p>
  </header>
      <?php
         $paged = get_query_var('paged');
         $posts = query_posts(array("post_type" => array("post"),
                                    "paged" => $paged,
                                    "posts_par_page" => 5,
                                    "meta_key " => $_GET['key'],
                                    "meta_value" => $_GET['value'],
                                    "orderby" => "date"));
      ?>
      <nav class="navigation">
        <?php navigation_bar(); ?>
      </nav>
      <?php
        if(have_posts()) :
          foreach ($posts as $post) :
            setup_postdata($post);
         ?>
      <article class="archive-post">
        
		    <header class="archive-post_header">
			    <?php
				     //post_icon(get_the_ID(),array(70,70));
			       ?>
          
			    <?php
				     /*
				     * article's title
				               */
				               $permaLink = get_permalink();
				               $titleText = get_the_title();
				               echo '<h1 class="archive-post-title"><a href="'. $permaLink .'">'. $titleText .'</a></h1>';
			                                                                                                           ?>
                                                                                                                 
			                                                                                                           <?php
				                                                                                                            edit_the_link($the_id);
			                                                                                                              ?>
		    </header>
        
		    <footer class="meta-container">
          
			    <div class="postmeta-project">
				    <?php
					     the_project_list_of_the_post($the_id);
				       ?>
			    </div>
          
		    </footer>
        
		    <div class="entry-body">
			    <?php the_content() ?>
		    </div>
        
		    <footer class="entry-footer">
			    <div class="postmeta">
				    <p class="postmeta-title">投稿者</p>
				    <address class="postmeta-content">
					    <?php
						     $post = get_post($the_id);
						     $userID = $post->post_author;
						  echo get_avatar($userID, 15);//avatar image
						  echo the_author_posts_link();//auther link
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
      <?php navigation_bar(); ?>
    </nav>
</article>

<?php get_footer(); ?>
