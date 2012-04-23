<?php
/*
  Template Name: projects
*/
get_header(); ?>
<div id="content" class="narrowcolumn" role="main">
  <div id="ProjectsTitle">
    <h1>Projects</h1>
  </div>
  <div id="project_make">
    <h3><a href="<?php echo admin_url('edit.php?post_type=project'); ?>">新しいプロジェクトを登録する&#187</a></h3>
  </div>
  <?php
  $paged = get_query_var('paged');
  $rand_posts = query_posts(array("post_type" => array("project"),
                                  "paged" => $paged,
                                  "posts_par_page" => 3,
                                  "meta_key " => $_GET['key'],
                                  "meta_value" => $_GET['value'],
                                  "orderby" => "date"));
  ?>
	<div class="navigation">
		<?php wp_pagenavi(); ?>
	</div>
  <?php 
    foreach ($rand_posts as $post){
        setup_postdata($post);
        $catid = (int)get_post_meta(get_the_ID(), 'catid', true);
        $theCat = get_category($catid,false);
  ?>
  <div class="project_reborn" <?php $flag = odd_even($flag); ?>>
    <div id="project_left">
      <div id="project_title">
        <?php
           $category_link = get_category_link($catid);
           echo "<h2><a href= " .$category_link. "> " .$theCat->name."</a></h2>";
?>
      </div>
      <div id="project_icon">
        <a href=" <?php the_permalink() ?> ">
        <?php
           if( has_post_thumbnail($post->ID)){
        the_post_thumbnail();
        }else{
        echo '<img src="'. get_bloginfo("template_url").'/images/icons/modest_projects.png" width="102"/>';
        }
        ?>
         </a>
       </div>
    <div id="description">
        <?php echo $theCat->description; ?>
    </div>
</div>
<div id="project_right">
    <div class="pro_icon">
      <div id="pro_payload_mail" class="projectbox">
        <?php
           if(is_user_logged_in()){
             $mail_is = get_post_meta(get_the_ID(), 'email', true);
             if($mail_is != ''){
               $contact_id = (int)get_post_meta(get_the_ID(), 'contact_id', true);
               echo "<a href=".get_permalink( $contact_id ).">";
               echo '<img src="'.get_bloginfo("template_url").'/images/icons/modest_contact.png" width="70" /></a>';
             }
           }else{
           }
         ?>
        
      </div>
      <div id="pro_payload_web" class="projectbox">      
        <?php
          $web_site = get_post_meta(get_the_ID(), 'url', true);
        if($web_site != ''){
        ?>
        <a href="<?php
                 $web_site = trim($web_site);
                 if(strpos($web_site, '//') == false){
                    echo 'http://'.$web_site;
                 }else{
                    echo str_replace('//','//',$web_site);
                 }
                 ?>">
        <?php
            echo '<img src="'.get_bloginfo("template_url").'/images/icons/modest_web.png" width="70"/>';
        ?>
      </a>
      <?php }else{
            echo '<img src="'.get_bloginfo("template_url").'/images/icons/modest_web.png" width="70" />';
      } ?>
      </div>
      <div id="pro_payload_blog" class="projectbox">
      <?php  $category_link = get_category_link($catid);?>
      <a href="<?php echo $category_link; ?>">
      <?php
        echo '<img src="'.get_bloginfo("template_url").'/images/icons/modest_blog.png" width="70"/>';
      ?>
      </a>
      </div>
    </div>

    <div id="project_cloud">
      <?php $catque = 'cat=' . $catid; ?>
      <?php my_category_tag_cloud($catque); ?>
    </div>
</div>
    <div class="clearfloat"></div>
  </div>
<?php } ?>

	<div class="navigation">
		<?php wp_pagenavi(); ?>
	</div>
</div>
<?php get_footer(); ?>
