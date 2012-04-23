<?php
/**
 * @package WordPress
 * @subpackage modest2.0
 */
?>

<div id="sidebar" role="complementary">


<?php if (is_category('about')) { ?>
	<div id="payload_1" class="payload">
		<div id="icon_about" class="icons"></div>
		<h1>about</h1>
		
		
		
		
   <?php } elseif (is_category('event')) { ?>
   <div id="payload_4" class="payload">
   <div id="icon_event" class="icons"></div>
   <h1>event</h1>
   <?php } elseif (is_home()) { //blogはHomeになってるからイレギュラーにis_home()を使う ?>
   <div id="payload_7" class="payload">
   <div id="icon_blog" class="icons"></div>
   <h1>blog</h1>
   <?php } elseif (is_category('projects')) { ?>
   <div id="payload_8" class="payload">
   <div id="icon_projects" class="icons"></div>
   <h1>projects</h1>
   <?php } elseif (is_page('developer')) { ?>
   <div id="payload_9" class="payload">
   <div id="icon_developer" class="icons"></div>
   <h1>developer</h1>
   <?php } elseif (is_search()) { //searchすると?s=アドレスだからイレギュラーにis_search()を使う ?>
   <div id="payload_6" class="payload">
   <div id="icon_search" class="icons"></div>
   <h1>search</h1>
	 <?php get_search_form(); ?>
   <?php } elseif (is_page('search')) { ?>
   <div id="payload_6" class="payload">
   <div id="icon_search" class="icons"></div>
   <h1>search</h1>
	 <?php get_search_form(); ?>
   <?php } elseif (is_page('post')) { ?>
   <div id="payload_3" class="payload">
   <div id="icon_post" class="icons"></div>
   <h1>post</h1>
   <?php } elseif (is_page('join')) { ?>
   <div id="payload_2" class="payload">
   <div id="icon_join" class="icons"></div>
   <h1>join</h1>
   <?php } elseif (is_404()) { ?>
   <div id="payload_1" class="payload">
   <div id="icon_404" class="icons"></div>
   <h1>404</h1>
   <?php } elseif (is_category('projects') | is_page()){ ?>
   <div id="payload_1" class="payload">
   <div id="icon_project" class="icons"></div>
   <?php $title = get_the_title();
         echo '<h1>' . $title . '</h1>'; ?>
   <?php } else { ?>
   <div id="payload_1" class="payload">
   <div id="icon_modest" class="icons"></div>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h1><?php printf(__('%s'), single_cat_title('', false)); ?></h1>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle"><?php printf(__('%s'), single_tag_title('', false) ); ?></h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle"><?php printf(_c('%s'), get_the_time(__('F jS, Y'))); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle"><?php printf(_c('%s'), get_the_time(__('F, Y'))); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle"><?php printf(_c('%s'), get_the_time(__('Y'))); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle"><?php _e('Author Archive', 'kubrick'); ?></h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle"><?php _e('Blog Archives', 'kubrick'); ?></h1>
 	  <?php } ?>
   <?php } ?>
  </div>
  <div id="side_payload">
    <ul role="navigation">
      <?php if (is_category('about')) { ?>
      <li>
        <h2>about index</h2>
      </li>
      <ul>
        <?php query_posts('category_name=about'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <li>
          <a href='<?php the_permalink() ?>'><?php the_title(); ?></a>
        </li>
        <?php endwhile;?>
        <?php wp_reset_query(); ?>
      </ul>
      <?php } elseif (is_category('event')) { ?>
      <li>
        <h2>Event information</h2>
      </li>
      <ul>
        <?php query_posts('category_name=event'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <li>
          <a href='<?php the_permalink() ?>'><?php the_title(); ?></a>
          <ul>
            <?php 
               $post_id = get_the_ID();
               $post_data = get_post($post_id);
               echo $post_data->post_date; 
            /*Todo: ATNDに対応して投稿時間ではなく、イベント時間を表示したい。*/
            ?>
          </ul>
        </li>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
      </ul>
      <?php } elseif (is_home()) { //blogはHomeになってるからイレギュラーにis_home()を使う ?>
      <li><h2><?php _e('Archives', 'kubrick'); ?></h2>
				<ul>
				  <?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
      <?php } elseif (is_category('projects')) { ?>
      <li>
        <h2>Projects</h2>
      </li>
      <ul>
          <?php
             $cat_ID = get_cat_ID('projects');
             $args=array(
             'parent' => $cat_ID,
             'orderby' => 'count',
          'order' => 'ASC'
          );
          $categories=get_categories($args);
          foreach($categories as $category) { 
          echo '<li> <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.' ('.$category->count.')</a></li>';
          } 
          ?>
      </ul>
      <?php } elseif (is_page('developer')) { ?>
      <?php } elseif (is_search()) { //searchすると?s=アドレスだからイレギュラーにis_search()を使う ?>
      <?php } elseif (is_page('search')) { ?>
      <?php } elseif (is_page('post')) { ?>
      <?php } elseif (is_page('join')) { ?>
      <?php } elseif (is_404()) { ?>
      <?php } else { ?>
		  <ul>
        <?php 
           if (is_category()) {
             $cat = get_the_category();
             {
               for($i = 0; $i < count($cat) ; $i++){
                 echo '<h2>' . $cat[$i]->cat_name . '</h2>';
               }
             }
           }
              ?>
      </ul>
    <?php } ?>
    </ul>
  </div>
</div>

