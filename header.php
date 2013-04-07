<?php
/**
   * @package WordPress
   * @subpackage modest3
   */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

<meta name="description" content="<?php fc_meta_desc(); ?>" />

<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<meta property="og:title" content="<?php if (is_singular()) : single_post_title(); else : bloginfo('name'); endif; ?>" />
<meta property="og:url" content="<?php if (is_singular()) : the_permalink(); else : bloginfo('url'); endif; ?>" />
<meta property="og:description" content="<?php fc_meta_desc(); ?>" />
<meta property="og:image" content="<?php bloginfo('template_directory'); ?>/images/page-image.png" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="alternate" type="application/rss+xml" title="modestの最新の投稿" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

<!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->

<?php
  /* We add some JavaScript to pages with the comment form
   * to support sites with threaded comments (when in use).
   */
  if ( is_singular() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  /* Always have wp_head() just before the closing </head>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to add elements to <head> such
   * as styles, scripts, and meta tags.
   */
  wp_head();
?>

<script src="<?php bloginfo('template_directory'); ?>/js/ga.js" async defer></script>
</head>


<body <?php body_class(); ?>>

<div id="page">

  <header id="header">

    <a id="tabzilla" href="http://mozilla.jp" class="tabzilla-closed">Mozilla Japan</a>

    <nav id="header-nav" role="navigation">
      <ol>
        <li class="header-nav-item"><a href="<?php echo get_about_url(); ?>">このサイトについて</a></li>
        <li class="header-nav-item"><a href="<?php echo get_event_url(); ?>">イベント</a></li>
        <li class="header-nav-item"><a href="<?php echo get_project_url(); ?>">プロジェクト</a></li>
        <li class="header-nav-item"><?php wp_loginout(); ?></li>
      </ol>
    </nav>

    <h1 id="site-title">
      <a href= "<?php bloginfo('url'); ?>">
        <img id="site-title-image"
             alt="<?php bloginfo('name'); ?>"
             src="<?php bloginfo('template_directory'); ?>/images/modest-logo.png" />
      </a>
    </h1>
  </header>
