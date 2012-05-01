<?php
/*
 * Template Name: projects
 */
get_header();
?>

<article id="content">
  <hgroup>
    <h1>プロジェクト</h1>
    <h2>
      <a href="<?php echo admin_url('edit.php?post_type=project'); ?>">
        新しいプロジェクトを登録する
      </a>
    </h2>
  </hgroup>

  <?php
    $category_ids = get_all_category_ids();
    foreach ($category_ids as $cat_id) :
      $catObj = get_category($cat_id, 'OBJECT', 'raw');
      $catLink = get_category_link($cat_id);
  ?>
    <section ="project_summary">
      <?php
        //categoryごとのimg要素を設定する
        //$imgSrc = get_bloginfo("template_url") . '/images/icons/modest_projects.png';
      ?>
      <img class="project_icon" src=""/>
      <h1 class="project_title">
        <a href="<?php echo($catLink) ?>"><?php echo($catObj->name) ?></a>
      </h1>
      <p class="project_description"><?php echo($catObj->description) ?></p>
    </section>
  <?php
    endforeach;
  ?>

</article>

<?php get_footer(); ?>
