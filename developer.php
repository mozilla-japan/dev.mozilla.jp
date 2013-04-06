<?php
/*
 Template Name: developer
*/
get_header(); ?>

<div id="content" class="narrowcolumn" role="main">
    <div id="developer_title">
      <h1>Developers</h1>
    </div>
  <?php
    if(!is_user_logged_in()) {
      echo '<div id="developer_join">';
      echo '<h3><a href="'.get_bloginfo('url',false).'/wp-login.php?action=register">あなたもmodestに参加しましょう&#187</a><h3>';
      echo '</div>';
    }
       ?>
      <?php
/*
  ユーザ一覧のソート条件を最初に設定してください。
  以下の中から選べます。
  ------------------------
  * ID - ユーザID.
  * user_login - ユーザログイン名.
  * user_nicename - というのがあるみたいです。
  * user_email - メールアドレス
  * user_url - ユーザのURL
  * user_registered - 登録日
  */
  $szSort = "user_registered";
  $aUsersID = $wpdb->get_col( $wpdb->prepare("SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY %s ASC", $szSort ));
  shuffle($aUsersID);
  ?>
  <div id="developer_list">
    <ul>
      <?php
foreach ( $aUsersID as $iUserID ) {
  $user = get_userdata( $iUserID );
  echo '<li class="developerinfo">';
  echo '<table>';
  echo '<a href="'. get_author_link($echo=false,$user->ID) .'"><h3>'. get_avatar( $user->ID,50 ) .'  '. $user->display_name .'</h3></a>';
  echo '<div id="profline"></div>';
  the_author_meta( 'description' , $user->ID );
  if(is_user_logged_in()) {
    echo '<td>';
    if( $user->user_url != NULL) {
      echo '<tr>';
      echo '<td>WebSite: </td>';
      echo '<td><a href='.$user->user_url.'> ' . getPageTitle($user->user_url) . '</a></td>';
      echo '</tr>';
    }
    if( $user->twitter_id != NULL) {
      echo '<tr>';
      echo '<td>Twitter: </td>';
      echo '<td><a href="https://twitter.com/'.$user->twitter_id.'" class="twitter-follow-button" data-show-count="false">Follow '. $user->twitter_id .'</a> <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script></td>';
      echo '</tr>';
    }
    if( $user->facebook_id != NULL) {
      echo '<tr>';
      echo '<td>Facebook: </td>';
      echo '<td>' . $user->facebook_id . '</td>';
      echo '</tr>';
    }
    if( $user->skype_id != NULL) {
      echo '<tr>';
      echo '<td>Skype: </td>';
      echo '<td>' . $user->skype_id . '</td>';
      echo '</tr>';
    }
    echo '</td>';
  }
  echo '</table>';
  echo '</li>';
  /*
    The strtolower and ucwords part is to be sure
    the full names will all be capitalized.
  */
} // end the users loop.
?>
    </ul>
  </div>
</div>
<?php get_footer(); ?>
