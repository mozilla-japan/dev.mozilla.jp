<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
// Do not delete these lines
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
  die ('Please do not load this page directly. Thanks!');
}
?>
<?php
  if (post_password_required()) :
?>
    <p class="nocomments">
      <?php
        _e('This post is password protected. Enter the password to view comments.', 'kubrick');
      ?>
    </p>
<?php
    return;
  endif;
?>

<!-- You can start editing here. -->
<section id="comments">
  <h3>‚±‚Ì‹L–‚Ö‚ÌƒRƒƒ“ƒg</h3>

<?php
  if ( have_comments() ) :
?>

  <ol class="commentlist">
    <?php wp_list_comments();?>
  </ol>

<?php
  else :
    // this is displayed if there are no comments so far
    if (comments_open()) :
      // If comments are open, but there are no comments.
    else :
      // If comments are closed
  ?>
      <p class="nocomments">
        <?php
            _e('Comments are closed.', 'kubrick');
        ?>
      </p>
  <?php
    endif;
  endif;
?>

<?php
  if (comments_open()) :
?>

    <div id="respond">
      <h3>
        <?php
          comment_form_title( __('Leave a Reply', 'kubrick'), __('Leave a Reply for %s' , 'kubrick') );
        ?>
      </h3>

      <div id="cancel-comment-reply">
        <small><?php cancel_comment_reply_link() ?> </small>
      </div>

      <?php
        if (get_option('comment_registration') && !is_user_logged_in()) :
      ?>
          <p>
            <?php
              printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'kubrick'),
                     wp_login_url(get_permalink())
                    );
            ?>
          </p>
      <?php
         else :
          comment_form();
        endif;
        // If registration required and not logged in
      ?>
    </div>

<?php
  endif;
  // if you delete this the sky will fall on your head
?>
</section>