<?php
/**
   * @package WordPress
   * @subpackage modest3
   */
   ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="title" content="<?php if (is_singular()) : single_post_title(); echo ' | '; endif; bloginfo('name'); ?>">
  <meta name="description" content="<?php fc_meta_desc(); ?>">

  <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
  <meta property="og:title" content="<?php if (is_singular()) : single_post_title(); else : bloginfo('name'); endif; ?>">
  <meta property="og:url" content="<?php if (is_singular()) : the_permalink(); else : bloginfo('url'); endif; ?>">
  <meta property="og:description" content="<?php fc_meta_desc(); ?>">
<?php if (is_singular() && has_post_thumbnail()) : ?>
  <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
  <meta property="og:image" content="<?php echo $thumb['0']; ?>">
<?php elseif (get_header_image()) : ?>
  <meta property="og:image" content="<?php echo get_header_image(); ?>">
<?php endif; ?>

  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <link rel="alternate" type="application/rss+xml" title="modestの最新の投稿" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

  <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
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

  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/ga.js" async defer></script>
</head>
<body <?php body_class(); ?>>
<div id="page">
  <header id="header">
    <a id="tabzilla"
       href="http://mozilla.jp"
       class="tabzilla-closed">Mozilla Japan</a>
    <nav id="header-nav">
      <ol>
        <li><a href="<?php echo get_about_url(); ?>">このサイトについて</a></li>
        <li><a href="<?php echo get_event_url(); ?>">イベント</a></li>
        <li><a href="<?php echo get_project_url(); ?>">プロジェクト</a></li>
        <li><?php wp_loginout(); ?></li>
      </ol>
    </nav>
    <h1 id="site-title">
      <a href= "<?php bloginfo('url'); ?>">
        <img id="site-title-image"
             alt="<?php bloginfo('name'); ?>"
             src="<?php bloginfo('template_directory'); ?>/images/modest-logo.png"/>
      </a>
    </h1>
  </header>
