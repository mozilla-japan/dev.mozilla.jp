<?php
/*
 * modestのトップページを編集するときに必要
 */
/*
Template Name: index
 */
get_header();
?>
<article id="content">
  <section id="hottopic" class="section">
    <h2>注目トピック</h2>
    <?php
      $cat = get_query_var('hot');
      $posts = get_posts("order=desc&category=". $cat ."&numberposts=6");
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
    ?>
      <h3>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
        </a>
      </h3>
    <?php
        endforeach;
      endif;
    ?>
  </section>

  <section id="event">
    <h2>イベント</h2>
    <?php
      $args = array( 'post_type' => 'event',
                     'numberposts' => 3,
                   );
      $posts = get_posts($args);
      $latest = '';
      $old = '';
      if ($posts) :
        $postcount = 0;
        foreach ($posts as $post) :
          setup_postdata($post);

          //post data
          $datetime = get_the_time('Y-m-d');
          $year = get_the_time('Y');
          $month = get_the_time('n');
          $date = get_the_time('j');
          $href = get_permalink($post->ID);
          $title = get_the_title();

          //start here document
          $content = <<< DOC
            <section class="section">
              <time datetime="$datetime">
                <span class="posted-year">$year</span>/
                <span class="posted-month">$month</span>/
                <span class="posted-date">$date</span>/
              </time>
              <h3>
                <a href="$href" title="$title">
                  $title
                </a>
              </h3>
            </section>
DOC;
//end of here document

          if ($postcount === 0) {
            $latest = $content;
          }
          else {
            $old .= $content;
          }
          ++$postcount;
        endforeach;
      endif;
    ?>
    <div class="event-latest">
      <?php echo($latest); ?>
    </div>
    <div class="event-old">
      <?php echo($old); ?>
    </div>
  </section>

  <section id="blogfeed">
    <h2>ブログフィード</h2>
    <?php
      $posts = get_posts('posts_per_page=5');
      if($posts):
        foreach($posts as $post):
          setup_postdata($post);
    ?>
    <article class="blogfeed-article">
      <header>
        <h1>
          <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
            <?php the_title(); ?>
          </a>
        </h1>
      </header>
      <footer class="postmeta">
        <?php
          $datetime = get_the_time('Y-m-d');
          $date = get_the_time('Y年n月j日');
          echo '<time datetime="' . $datetime . '">'. $date . '</time>';
        ?>
        <ul class="meta-project-list">
            <?php
                $catlist = get_the_category();
                foreach ($catlist as $cat) :
                    $project_array = get_post(get_project_page_ID($cat->cat_ID));
                    $link = get_permalink($project_array->ID);
                    $link_text = $project_array->post_title;
                    if ($project_array->post_type == 'project') :
                        echo '<li><a href="'. $link .'">'. $link_text .'</a></li>';
                    endif;
                endforeach;
            ?>
        </ul>
      </footer>
    </article>
    <?php
        endforeach;
      endif;
    ?>

  </section>

  <?php
  /*
  <section id="communityfeed">
    <h2>コミュニティフィード</h2>
    <?php include("community.php.inc"); ?>
  </section>
  */
  ?>
</article>
<?php get_footer(); ?>
