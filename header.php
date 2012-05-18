<?php
/**
   * @package WordPress
   * @subpackage modest2.0
   */
   ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      <?php language_attributes(); ?>>
  
  <head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type"
          content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
    <title><?php wp_title('&laquo;', true, 'right'); ?>
      <?php bloginfo('name'); ?></title>
    
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"
          type="text/css" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <style type="text/css" media="screen">
      <?php // Checks to see whether it needs a sidebar or not
            if( empty ($withcomments)  && !is_single ()  ) { ?> #page {
	    background:
		  url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg-<?php bloginfo('text_direction'); ?>.jpg")
		  repeat-y top;
	    border: none;
      }
      <?php } else { // No sidebar ?> #page { background:url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg")repeat-ytop;
	    border: none;
      }
      <?php
         }
         ?>
    </style>
      <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?> 
      <?php wp_enqueue_script('jquery'); ?>
      <?php wp_enqueue_script('thema-js', get_bloginfo('template_directory').'/js/function.js', array('jquery')); ?>
      <!--[if lt IE 9]>
      <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
      <![endif]-->
      <?php wp_head(); ?>
      <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/ga.js" async defer></script>
  </head>

  <body <?php body_class(); ?>>
    <div id="headbar">
      <div id="topline">
      </div>
      <div id="topcolumn">
        <div id="top_title">
          <a href = "<?php bloginfo('url'); ?>">
            <h1>
              <?php bloginfo('name'); ?>
            </h1>
          </a>
        </div>
        <div id="top_searchform">
    <?php get_search_form(); ?>
        </div>
      </div>
      <div id="leftcolumn">
        <h4>プロジェクト</h4>
        <ul>
	        <?php wp_list_categories('show_count=1&title_li='); ?>
        </ul>
        <h4>タグクラウド</h4>
        <?php wp_tag_cloud(); ?>
      </div>
      <div id="rightcolumn">
        <h4>プロジェクトの記事</h4>
        <ul>
          <?php wp_get_archives(); ?>
        </ul>
        <h4>月別投稿</h4>
        <ul>
          <?php wp_get_archives('type=monthly&show_post_count=1'); ?>
        </ul>
      </div>
      </div>
    <div id="header" class="uppercolumn">
      <ul id="header_images">
        <li id="payload_modest" class="headbox">
          <a href="<?php bloginfo('url'); ?>">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_logo.png" alt="modest" title="modest_top" width=88>
          </a>
        </li>

        <li id="payload_about" class="headbox">
          <?php
             $category = get_cat_ID("about");
          ?>
          <a href="<?php bloginfo('url'); ?>/aboutmodest/">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_about.png" alt="about" title="modest_about" width=88>
          </a>
          <?php  if(is_category($category)){ ?>
          
          <?php } ?>
        </li>

        <li id="payload_event" class="headbox">
          <a href="<?php echo bloginfo('url')."/?post_type=event" ?>">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_event.png" alt="event" title="modest_event" width=88>
          </a>
          <?php  if("event" == get_post_type()){ ?>
          <?php } ?>
        </li>

        <li id="payload_blog" class="headbox">
          <?php
             $category_id = get_cat_ID('projects');
             $category_link = get_category_link($category_id);
           ?>
          <a href=<?php echo $category_link ?>>    
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_blog.png" alt="blog" title="modest_blog" width=88>
          </a>
          <?php  if(is_category($category_id)){ ?>
          <?php } ?>
        </li>

        <li id="payload_projects" class="headbox">
          <?php
                     $page = get_page_by_title('プロジェクトリスト');
                     $page_link = get_page_link($page->ID);
           ?>
          <a href="<?php echo $page_link; ?>">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_projects.png" alt="projects" title="modest_projects" width=88>
          </a>
          <?php  if(is_page($page->ID)){ ?>
          <?php } ?>
        </li>

        <li id="payload_developers" class="headbox">
          <?php
                       $page = get_page_by_title('ユーザリスト');
                       $page_link = get_page_link($page->ID);
           ?>
          <a href="<?php echo $page_link; ?>">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_developer.png" alt="developer" title="modest_developer" width=88>
          </a>
          <?php if(is_page($page->ID)){ ?>
          <?php } ?>
        </li>

        <li id="payload_search" class="headbox">
          <img src="<?php bloginfo('template_directory');?>/images/icons/modest_search.png" alt="search" title="modest_search" width=88>
          <?php  if(is_search()){ ?>
          <?php } ?>
        </li>

        <li id="payload_post" class="headbox">
          <?php if(is_user_logged_in()){ ?>
          <a href="<?php bloginfo('url'); ?>/wp-admin/edit.php">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_post.png"alt="post" title="modest_post" width=88>
          </a>
          <?php }else{?>
          <a href="<?php bloginfo('url'); ?>/wp-login.php?action=register">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_join.png" alt="join" title="modest_join" width=88>
          </a>
          <?php } ?>
        </li>

        <li id="payload_dash" class="headbox">
          <?php if(is_user_logged_in()){ ?>
          <a href="<?php bloginfo('url'); ?>/wp-admin/">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_dash.png" alt="dash" title="modest_dash" width=88>
          </a>
          <?php }else{ ?>
          <a href="<?php bloginfo('url'); ?>/wp-login.php">
            <img src="<?php bloginfo('template_directory');?>/images/icons/modest_login.png" alt="login" title="modest_login" width=88>
          </a>
          <?php } ?>
        </li>

      </ul>
     </div>
  <div id="page">
<hr />
                            
