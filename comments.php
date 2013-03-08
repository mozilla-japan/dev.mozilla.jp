<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
?>
<?php // Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  /* This variable is for alternating comment background */
  $oddcomment = 'alt';

?><?php /* You can start editing here. */ ?>

<?php if ( have_comments() || comments_open() ) : // If there are comments OR comments are open ?>

<section id="comments">
<?php if ( post_password_required() ) : ?>
  <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'onemozilla' ); ?></p>
</section><!-- #comments -->
<?php
    /* Stop the rest of comments.php from being processed,
     * but don't kill the script entirely -- we still have
     * to fully load the template.
     */
    return;
  endif;
?>

  <header class="comments-head">
    <h2><?php comments_number('', '1 件のコメント', '% 件のコメント' );?></h2>
  </header>

<?php if ( have_comments() ) : // If there are comments ?>
  <ol id="comment-list" class="hfeed <?php if (get_option('show_avatars')) echo 'av'; // provides a style hook when avatars are enabled ?>">
    <?php wp_list_comments('type=all&style=ol&callback=onemozilla_comment'); // Comment template is in functions.php ?>
  </ol>

  <?php if ( get_comment_pages_count() > 1 ) : // If comment paging is enabled and there are enough comments to paginate, show the comment paging ?>
    <p class="pages"><?php echo '更なるコメント:'; paginate_comments_links(); ?></p>
  <?php endif; ?>

<?php endif; ?>

<?php if (comments_open()) : ?>

  <div id="respond">
  <?php if ( get_option('comment_registration') ) : // If registration is required and you're not logged in, show a message ?>  
    <p><?php printf('<a class="button-white" href="%s">ログイン</a>する必要があります.', esc_attr(wp_login_url(get_permalink())) ); ?></p>
  <?php else : // else show the form ?>
    <form id="comment-form" action="<?php echo esc_attr(get_option('siteurl')); ?>/wp-comments-post.php" method="post">
      <fieldset>
        <legend><span><?php comment_form_title( __('コメントを投稿する'), __('%s に返信' ) ); ?></span></legend>
        <p id="cancel-comment-reply"><?php cancel_comment_reply_link('返信を止める'); ?></p>
        <ol>
        <?php if ( $user_ID ) : ?>
          <li class="self"><?php printf( __( '<a href="%1$s">%2$s</a> としてログインしています. <a class="logout button-white" href="%3$s">Log out</a>', '' ), admin_url( 'profile.php' ), esc_html($user_identity), wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ); ?></li>
        <?php else : ?>
          <li id="cmt-name">
            <label for="author">名前 <?php if ($req) :echo '<span class="note">(必須)</span>'; endif; ?></label> 
            <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="25" <?php if ($req) echo "required aria-required='true'"; ?>>
          </li>
          <li id="cmt-email">
            <label for="email">メールアドレス <?php if ($req) : echo '<span class="note">(必須。実際のコメントには表示されません。)</span>'; endif; ?></label> 
            <input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="25" <?php if ($req) echo "required aria-required='true'"; ?>>
          </li>
          <li id="cmt-web">
            <label for="url">Webサイト</label>
            <input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="25">
          </li>
        <?php endif; ?>
          <li id="cmt-cmt"><label for="comment">コメント本文</label> <textarea name="comment" id="comment" cols="50" rows="10"></textarea></li>
          <li id="comment-submit"><button name="submit" class="button-blue" type="submit">コメントを送信</button>
          <?php comment_id_fields(); ?>
          <?php do_action('comment_form', $post->ID); ?></li>
        </ol>
      </fieldset>
    </form>
  <?php endif; // end if reg required and not logged in ?>
  </div><?php // end #respond ?>

<?php endif; // end if comments open ?>

</section><?php // end #comments ?>

<?php endif; // if you delete this the sky will fall on your head ?>
