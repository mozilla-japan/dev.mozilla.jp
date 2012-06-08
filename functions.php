<?php
/**
 * @package WordPress
 * @subpackage modest3
 */

function getPageTitle( $url ){
	$html = file_get_contents($url); //(1)
	$html = mb_convert_encoding($html, mb_internal_encoding(), "auto" ); //(2)
	if ( preg_match( "/<title>(.*?)<\/title>/i", $html, $matches) ) {
		//(3)
		return $matches[1];
	} else {
		return false;
	}
}
/*
 * サムネイルについて
 */
add_theme_support('post-thumbnails');
set_post_thumbnail_size(102,102);

if(!current_user_can( 'administrator' )){
	function spam_delete_comment_link($id) {
		global $comment, $post;
		if ( $post->post_type == 'page' ){
			if ( !current_user_can( 'edit_page', $post->ID) )
			return;
		} else {
			if( !current_user_can( 'edit_post', $post->ID) )
			return;
		}
		$id = $comment -> comment_ID;
		if ( null === $link)
		$link = __('Edit');
		$link = '<a class="comment-edit-link" href"' . get_edit_comment_link($comment -> comment_ID ) . '" title="' . __( 'Edit comment' ) . '">' . $link . '</a>';
		$link = $link . ' | <a href="'.admin_url("comment.php?action=cdc&c=$id").'">削除</a> ';
		$link = $link . ' | <a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">スパム</a>';
		$link = $before . $link . $after;
		return $link;
	}
	add_filter('edit_comment_link', 'spam_delete_comment_link');

	function custom_admin_footer(){
		echo 'mozilla developer street';
	}
	add_filter('admin_footer_text', 'custom_admin_footer');
}

/*
 *ダッシュボードの設定
*/

/*
 *デフォルトのコンタクトフィールドを削除する
*/
function hide_profile_fields( $contactmethods ){
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;
}
add_filter('user_contactmethods','hide_profile_fields',10,1);

//Twitter IDフォームを設置する
function add_user_twitter_form($bool){
	//フォームを出す
	global $profileuser;
	if ( preg_match( '/^(profile\.php|user-edit\.php)/', basename( $_SERVER['REQUEST_URI'] ) ) ) {
		?>
<tr>
	<th scope="row">Twitter ID</th>
	<td>@<input type="text" name="twitter_id" id="twitter_id"
		value="<?php echo esc_html( $profileuser->twitter_id ); ?>" />
	</td>
</tr>

<?php
	}
	return $bool;
}
add_action('show_password_fields','add_user_twitter_form');

function update_user_twitter_form($user_id,$old_user_data){
	//登録処理
	if ( isset( $_POST['twitter_id'] ) && $old_user_data -> twitter_id != $_POST['twitter_id'] ){
		$twitter_id = sanitize_text_field( $_POST['twitter_id'] );
		$twitter_id = wp_filter_kses( $twitter_id );
		$twitter_id = _wp_specialchars( $twitter_id );
		update_user_meta( $user_id , 'twitter_id', $twitter_id );
	}
}
add_action( 'profile_update', 'update_user_twitter_form', 10, 2);

//Facebook IDフォームを設置する
function add_user_facebook_form($bool){
	//フォームを出す
	global $profileuser;
	if ( preg_match( '/^(profile\.php|user-edit\.php)/', basename( $_SERVER['REQUEST_URI'] ) ) ) {
		?>
<tr>
	<th scope="row">Facebook</th>
	<td><input type="text" name="facebook_id" id="facebook_id"
		value="<?php echo esc_html( $profileuser->facebook_id ); ?>" />
	</td>
</tr>

<?php
	}
	return $bool;
}
add_action('show_password_fields','add_user_facebook_form');

function update_user_facebook_form($user_id,$old_user_data){
	//登録処理
	if ( isset( $_POST['facebook_id'] ) && $old_user_data -> facebook_id != $_POST['facebook_id'] ){
		$facebook_id = sanitize_text_field( $_POST['facebook_id'] );
		$facebook_id = wp_filter_kses( $facebook_id );
		$facebook_id = _wp_specialchars( $facebook_id );
		update_user_meta( $user_id , 'facebook_id', $facebook_id );
	}
}
add_action( 'profile_update', 'update_user_facebook_form', 10, 3);

//SkypeIDフォームを設置する。
function add_user_skype_form($bool){
	//フォームを出す
	global $profileuser;
	if ( preg_match( '/^(profile\.php|user-edit\.php)/', basename( $_SERVER['REQUEST_URI'] ) ) ) {
		?>
<tr>
	<th scope="row">Skype</th>
	<td><input type="text" name="skype_id" id="skype_id"
		value="<?php echo esc_html( $profileuser->skype_id ); ?>" />
	</td>
</tr>

<?php
	}
	return $bool;
}
add_action('show_password_fields','add_user_skype_form');

function update_user_skype_form($user_id,$old_user_data){
	//登録処理
	if ( isset( $_POST['skype_id'] ) && $old_user_data -> skype_id != $_POST['skype_id'] ){
		$skype_id = sanitize_text_field( $_POST['skype_id'] );
		$skype_id = wp_filter_kses( $skype_id );
		$skype_id = _wp_specialchars( $skype_id );
		update_user_meta( $user_id , 'skype_id', $skype_id );
	}
}
add_action( 'profile_update', 'update_user_skype_form', 10, 3);

/*
 *カスタムポストタイプを増やす
*プロジェクトをポストする
*コンタクトページをポストする
*イベントの投稿をポストする
*/
add_action('init','create_Project',0);
function create_Project(){
  $labels = array(
                  'name' => 'プロジェクト',
                  'singular_name' => 'プロジェクト',
                  'add_new' => '新規追加',
                  'add_new_item' => '新規プロジェクトを追加',
                  'edit_item' => 'プロジェクトを編集',
                  'new_item' => '新規プロジェクト',
                  'view_item' => 'プロジェクトを表示',
                  'search_items' => 'プロジェクトを検索',
                  'not_found' => '投稿されたプロジェクトはありません',
                  'not_found_in_trash' => 'ゴミ箱にプロジェクトはありません。',
                  'parent_item_colon' => '');
	register_post_type(
        'project',
	array(
            'label' => 'プロジェクト',
            'labels' => $labels,
            'public' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'rewrite' => true,
            'query_var' => false,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'revisions'
                ),
            'register_meta_box_cb' => 'project_meta_box'
        )
	);
}

add_action('init','create_Event',0);
function create_Event(){
  $labels = array(
                  'name' => 'イベント',
                  'singular_name' => 'イベント',
                  'add_new' => '新規追加',
                  'add_new_item' => '新規イベントを追加',
                  'edit_item' => 'イベントを編集',
                  'new_item' => '新規イベント',
                  'view_item' => 'イベントを表示',
                  'search_items' => 'イベントを検索',
                  'not_found' => '投稿されたイベントはありません',
                  'not_found_in_trash' => 'ゴミ箱にイベントはありません。',
                  'parent_item_colon' => '');
    register_post_type(
        'event',
        array(
            'label' => 'イベント',
            'labels' => $labels,
            'public' => true,
            'menu_position' => 4,
            'has_archive' => 'event',
            'taxonomies' => array('post_tag','category'),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'except',
                'revisions',
                'comments',
                ),
            'register_meta_box_cb' => 'event_meta_box'
            )
        );
}

/*
 *プロジェクトのポスト画面に新たに情報フォームを追加する
*/
function project_meta_box($post){
	add_meta_box('menu_meta', 'プロジェクト情報', 'menu_meta_html', 'project', 'normal', 'high');
}
function menu_meta_html($post, $box){
  $id = $post->ID;
  echo wp_nonce_field('menu_meta', 'menu_meta_nonce');
  echo wp_nonce_field('menu_meta', 'menu_catid_nonce');
?>

<dl class="metadata-form-list">

  <?php
    $url = get_post_meta($id, 'url', true);
  ?>
  <dt>
    <label for="url">プロジェクトのWebサイト</label>
  </dt>
  <dd>
    <input name="url" type="url"
           value="<?php echo esc_attr($url);?>"
           placeholder="http://www.example.com/"/>
  </dd>

  <?php
    $rss = get_post_meta($id, 'rss', true);
  ?>
  <dt>
    <label for="rss">プロジェクトのRSSフィード</label>
  </dt>
  <dd>
    <input name="rss" type="url"
           value="<?php echo esc_attr($rss);?>"
           placeholder="http://www.example.com/rss.xml"/>
  </dd>

<?php
    $user = wp_get_current_user();
    if ($user->roles[0] == 'administrator') :
      $catid = (int)get_post_meta($id, 'catid', true);
      if($catid == 0) {
        $catid = '';
      }
      $catid = esc_attr($catid);
      echo <<< DOC
  <dt>
    <label for="catid">カテゴリID（変更禁止）</label>
  </dt>
  <dd>
    <input name="catid" type="text" readonly="true"
           value="$catid" />
  </dd>
DOC;
    endif;
?>

</dl>

<?php
}

/*
 * イベントのポスト画面に新たに情報フォームを追加する
 */

function event_meta_box($post){
    add_meta_box('event_meta', 'イベント情報', 'event_meta_html', 'event', 'normal', 'high');
}

function event_meta_html($post, $box){
  $id = $post->ID;
?>
<dl class="metadata-form-list">

  <?php
    $date = new DateTime();
    $date->setTimestamp(get_post_meta($id, 'start_time', true));
    $year = $date->format('Y');
    $month = $date->format('m');
    $day = $date->format('d');
    $time = $date->format('H:i');
  ?>
  <dt>
    <label>開始日時</label>
  </dt>
  <dd>
    <label><input name="start_time-year" type="text" placeholder="2010"
                  maxlength="4"
                  value="<?php echo esc_attr($year); ?>"
                  style="width: 4em;"/>年</label>
    <label><input name="start_time-month" type="text" placeholder="01"
                  maxlength="2"
                  value="<?php echo esc_attr($month); ?>"
                  style="width: 2em;"/>月</label>
    <label><input name="start_time-day" type="text" placeholder="01"
                  maxlength="2"
                  value="<?php echo esc_attr($day); ?>"
                  style="width: 2em;"/>日</label>
    <input name="start_time-time" type="text" placeholder="12:00"
                  maxlength="5"
                  value="<?php echo esc_attr($time); ?>"
                  style="width: 5em;"/>
  </dd>

  <?php
    $date = new DateTime();
    $date->setTimestamp(get_post_meta($id, 'end_time', true));
    $year = $date->format('Y');
    $month = $date->format('m');
    $day = $date->format('d');
    $time = $date->format('H:i');
  ?>
  <dt>
    <label for="end_time">終了日時</label>
  </dt>
  <dd>
    <label><input name="end_time-year" type="text" placeholder="2010"
                  maxlength="4"
                  value="<?php echo esc_attr($year); ?>"
                  style="width: 4em;"/>年</label>
    <label><input name="end_time-month" type="text" placeholder="01"
                  value="<?php echo esc_attr($month); ?>"
                  maxlength="2"
                  style="width: 2em;"/>月</label>
    <label><input name="end_time-day" type="text" placeholder="01"
                  maxlength="2"
                  value="<?php echo esc_attr($day); ?>"
                  style="width: 2em;"/>日</label>
    <input name="end_time-time" type="text" placeholder="12:00"
                  maxlength="5"
                  value="<?php echo esc_attr($time); ?>"
                  style="width: 5em;"/>
  </dd>

  <?php
    $capacity = get_post_meta($id, 'capacity', true);
  ?>
  <dt>
    <label for="capacity">定員</label>
  </dt>
  <dd>
    <input name="capacity" type="number"
           value="<?php echo esc_attr($capacity); ?>"
           placeholder="10"/>
  </dd>

  <?php
    $place = get_post_meta($id, 'place', true);
  ?>
  <dt>
    <label for="place">会場</label>
  </dt>
  <dd>
    <input name="place" type="text"
          value="<?php echo esc_attr($place); ?>"
          placeholder="東京都千代田区貸会議室"/>
  </dd>

  <?php
    $website = get_post_meta($id, 'website', true);
  ?>
  <dt>
    <label for="website">詳細URL</label>
  </dt>
  <dd>
    <input name="website" type="url"
           value="<?php echo esc_attr($website); ?>"
           placeholder="http://www.example.com/"/>
  </dd>

  <?php
    $hashtag = get_post_meta($id, 'hashtag', true);
  ?>
  <dt>
    <label for="hashtag">ハッシュタグ</label>
  </dt>
  <dd>
    <input name="hashtag" type="text"
          value="<?php echo esc_attr($hashtag); ?>"
          placeholder="#example" />
  </dd>

</dl>
<?php
  echo wp_nonce_field('event_meta', 'event_date_nonce');
}

/*
 *カテゴリからプロジェクトの記事を参照するための項目を追加する
 */
add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
  $t_id = $tag->term_id;
  $cat_meta = get_option( "cat_$t_id");
  if(isset($cat_meta['project_id'])){
    $value = $cat_meta['project_id'];
  }
  $user = wp_get_current_user();
  if($user->roles[0] == 'administrator'){
    echo '<tr class="form-field">';
    echo '<th><label for="Cat_meta[project_id]">プロジェクトID</label></th>';
    echo '<td><input type="text" name="Cat_meta[project_id]" id="project_id" size="25" readonly="true" value="'. $value .'" /></td>"';
    echo '</tr>';
  }
}

add_action ( 'edited_term' , 'save_extra_category_fileds');
function save_extra_category_fileds( $term_id ){
  if(isset ($_POST['Cat_meta'] ) ){
    $t_id = $term_id;
    $cat_meta = get_option( "cat_$t_id" );
    $cat_keys = array_keys($_POST['Cat_meta']);
    foreach ($cat_keys as $key) {
      if (isset($_POST['Cat_meta'][$key])){
        $cat_meta[$key] = $_POST['Cat_meta'][$key];
      }
    }
    update_option( "cat_$t_id", $cat_meta );
  }
}

/*
 *プロジェクトをポストしたときにそのプロジェクト用にカテゴリを用意する
 */
add_action('save_post', 'project_cat_create');
function project_cat_create($post_id){
	/*
	 *このコードを入れるとリビジョンのidを使ってしまうため、カテゴリへの反映が次回の編集で行われる。
   *しかし、Wordpressのリファレンスにはwp_is_post_revisionを使わないと最新版ではないと書いてあった。
   *if(wp_is_post_revision($post_id)){
   *$post_id = wp_is_post_revision($post_id);
   *}
   */
	$post_info = get_post($post_id);

	if($post_info->post_type == 'project' && get_post_status($post_id) == 'publish'){
		$title = $post_info->post_title;
		$desc = $post_info->post_excerpt;
		$slug = $post_info->post_name;
		$catid = (int)get_post_meta($post_id, 'catid', true);
		//カテゴリの作成
		if($catid == 0){
			$procat = array(
                'cat_name' => $title,
                'category_nicename' => $slug,
                'category_parent' => get_cat_ID('projects'),
                'category_description' => $desc);
			$tempcatid = wp_insert_category($procat, false);
			if($tempcatid == 0){
				echo 'error: wp_insert_category <br>';
				return $post_id;
			} else {
				update_post_meta($post_id, 'catid', $tempcatid);
			}
      $t_id = $tempcatid;
		} else {
			$termarr = array(
                'name' => $title,
                'slug' => $slug,
                'taxonomy' => 'category',
                'description' => $desc,
                'parent' => get_cat_ID('projects')
			);

			$tempcatid = wp_update_term($catid, 'category', $termarr);
			if(is_wp_error($tempcatid)){
        if($wp_error){
          return $cat_ID;
        }else{
          return 0;
        }
      }else{
        update_post_meta($post_id, 'catid', $tempcatid['term_id']);
      }
      $t_id = $tempcatid['term_id'];
		}
    $cat_meta = get_option( "cat_$t_id" );
    $cat_meta['project_id'] = $post_id;
    update_option( "cat_$t_id", $cat_meta);
	}
}

add_action('before_delete_post', 'delete_project');
function delete_project($post_id){
	$post_info = get_post($post_id);
	if($post_info->post_type == 'project'){
		$catid = (int)get_post_meta($post_id, 'catid', true);
		wp_delete_category( $catid );
	}
}

add_action('save_post', 'event_update');
function event_update($post_id){
    if(!wp_verify_nonce( $_POST['event_date_nonce'], 'event_meta')){
        return $post_id;
    }
    if(defined('DOING_AUTOSAVE') &&  DOING_AUTOSAVE){
        return $post_id;
    }

    if('event' == $_POST['post_type']){
        if(!current_user_can('edit_post', $post_id)){
            return $post_id;
        }
    }else{
        return $post_id;
    }

    $start_time = getUnixTimeStamp('start_time');
    $end_time = getUnixTimeStamp('end_time');
    $place = trim($_POST['place']);
    $capacity = trim($_POST['capacity']);
    $website = trim($_POST['website']);
    $hashtag = trim($_POST['hashtag']);

    if($start_time == ''){
      delete_post_meta($post_id, 'start_time');
    } else {
      update_post_meta($post_id, 'start_time', $start_time);
    }
    if($end_time == ''){
      delete_post_meta($post_id, 'end_time');
    } else {
      update_post_meta($post_id, 'end_time', $end_time);
    }
    if($place == ''){
        delete_post_meta($post_id, 'place');
    } else {
        update_post_meta($post_id, 'place', $place);
    }
    if($capacity == ''){
      delete_post_meta($post_id, 'capacity');
    } else {
      update_post_meta($post_id, 'capacity', $capacity);
    }
    if($website == ''){
      delete_post_meta($post_id, 'website');
    } else {
      update_post_meta($post_id, 'website', $website);
    }
    if($hashtag == ''){
      delete_post_meta($post_id, 'hashtag');
    } else {
      update_post_meta($post_id, 'hashtag', $hashtag);
    }
}
function getUnixTimeStamp ($time_point) {
  $year = trim($_POST[$time_point .'-year']);
  $month = trim($_POST[$time_point .'-month']);
  $day = trim($_POST[$time_point .'-day']);
  $time = explode(':', trim($_POST[$time_point .'-time']) );
  return mktime($time[0], $time[1], 0, $month, $day, $year);
}


add_action('save_post', 'menu_update');
function menu_update($post_id){
	if(!wp_verify_nonce( $_POST['menu_meta_nonce'], 'menu_meta')){
		return $post_id;
	}

  if(!wp_verify_nonce( $_POST['menu_catid_nonce'], 'menu_meta')){
    return $post_id;
  }
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return $post_id;
	}

	if('project' == $_POST['post_type']){
		if(!current_user_can('edit_post', $post_id)){
			return $post_id;
		}
	}else{
		return $post_id;
	}

	$url = trim($_POST['url']);
  $rss = trim($_POST['rss']);
  $catid = trim($_POST['catid']);

  if($catid != '' || $catid != 0){
    update_post_meta($post_id, 'catid', $catid);
  }
	if($url == ''){
		delete_post_meta($post_id, 'url');
	} else {
		update_post_meta($post_id, 'url', $url);
	}
	if($rss == ''){
		delete_post_meta($post_id, 'rss');
	} else {
		update_post_meta($post_id, 'rss', $rss);
	}
}

/**ポストアイコン**/
function post_icon($id,$size=array(80,80)){
  echo "<div class='post_icon'>";
  $post = get_post($id,ARRAY_A);
  if( has_post_thumbnail($id)){
    the_post_thumbnail($size,$id);
  }else{
    $catid = get_the_category($id);
    $catid = $catid[0];
    $catname = "projects";
    if("event" == get_post_type()){
      echo '<img src="'. get_bloginfo("template_url").'/images/icons/modest_event.png" width="'.$size[0].'"/>';
    }else if($catname == $catid->cat_name){
      echo '<img src="'. get_bloginfo("template_url").'/images/icons/modest_projects.png" width="'.$size[0].'"/>';
    }else{
      $page = get_page_by_path($catid->category_nicename,ARRAY_N,'project');
      if(has_post_thumbnail($page[0])){
        echo get_the_post_thumbnail($page[0],$size);
      }else{
        echo '<img src="'. get_bloginfo("template_url").'/images/icons/modest_projects.png" width="'.$size[0].'"/>';
      }
    }
  }
  echo "</div>";
}

/*
 * パンくずリスト
 */
function breadcrumbs($the_id) {
  $url = get_bloginfo('url');
  $type = get_post_type($the_id);

  // rootとなるリンクを出力
  echo '<a href="' . $url . '">' . get_bloginfo('name') . '</a> &gt';

  // カテゴリに応じたリンクを出力
  switch ($type) {
    case "event":
      echo '<a href="' . $url . '/?post_type=event">Event</a> &gt;';
      break;
    case "project":
      echo '<a href="' . $url . '/projects" >Projects</a> &gt';
      break;
  }

  $cat = get_the_category();
  $cat = $cat[0];
  if ($cat != NULL) {
    echo get_category_parents($cat->cat_ID, true, ' &gt; ');
  }
}

/**
 *ポストタイプを指定したカテゴリリスト
 **/
function get_the_category_list_post_type( $separator = '', $parents='', $post_id = false, $post_type = 'post' ) {
  global $wp_rewrite;
  $categories = get_the_category( $post_id );
  if ( !is_object_in_taxonomy( get_post_type( $post_id ), 'category' ) )
    return apply_filters( 'the_category', '', $separator, $parents );
  if ( empty( $categories ) )
    return apply_filters( 'the_category', __( 'Uncategorized' ), $separator, $parents );
  $rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
  $thelist = '';
  if ( '' == $separator ) {
    $thelist .= '<ul class="post-categories">';
    foreach ( $categories as $category ) {
      $thelist .= "\n\t<li>";
      switch ( strtolower( $parents ) ) {
      case 'multiple':
        if ( $category->parent )
          $thelist .= get_category_parents( $category->parent, true, $separator );
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>' . $category->name.'</a></li>';
        break;
      case 'single':
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>';
        if ( $category->parent )
          $thelist .= get_category_parents( $category->parent, false, $separator );
        $thelist .= $category->name.'</a></li>';
        break;
      case '':
      default:
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>' . $category->name.'</a></li>';
      }
    }
    $thelist .= '</ul>';
  } else {
    $i = 0;
    foreach ( $categories as $category ) {
      if ( 0 < $i )
        $thelist .= $separator;
      switch ( strtolower( $parents ) ) {
      case 'multiple':
        if ( $category->parent )
          $thelist .= get_category_parents( $category->parent, true, $separator );
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>' . $category->name.'</a>';
        break;
      case 'single':
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>';
        if ( $category->parent )
          $thelist .= get_category_parents( $category->parent, false, $separator );
        $thelist .= "$category->name</a>";
        break;
      case '':
      default:
        $thelist .= '<a href="' . get_category_link( $category->term_id ) . '?post_type='.$post_type.'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>' . $category->name.'</a>';
      }
      ++$i;
    }
  }
  return apply_filters( 'the_category', $thelist, $separator, $parents );
}

function the_tags_post_type($before = null, $sep = ', ', $after = '', $post_type = 'post' ){
  if ( null === $before )
    $before = __('Tags: ');
  echo get_the_tag_list_post_type($before, $sep, $after, $post_type);
}

function get_the_tag_list_post_type($before = '', $sep = ', ', $after = '', $post_type = 'post'){
  return apply_filters( 'the_tags', get_the_term_list_post_type( 0, 'post_tag', $before, $sep, $after, $post_type), $before, $sep, $after);
}

function get_the_term_list_post_type( $id = 0, $taxonomy, $before = '', $sep = '', $after = '', $post_type = 'post' ) {
  $terms = get_the_terms( $id, $taxonomy );
  if ( is_wp_error( $terms ) )
    return $terms;
  if ( empty( $terms ) )
    return false;
  foreach ( $terms as $term ) {
    $link = get_term_link( $term, $taxonomy );
    if ( is_wp_error( $link ) )
      return $link;
    $term_links[] = '<a href="' . $link . '?post_type='. $post_type .'" rel="tag">' . $term->name . '</a>';
  }
  $term_links = apply_filters( "term_links-$taxonomy", $term_links );
  return $before . join( $sep, $term_links ) . $after;
}

/* print the link of editing the post */
function edit_the_link ($postId) {
  if (is_user_logged_in()) :
    $edit_link = get_edit_post_link($postId);
    //here document
    echo <<< DOC
      <a href="$edit_link"
         class="edit_post button-white">編集する</a>
DOC;
  endif;
}
/* print the project list which the post is releted to */
function the_project_list_of_the_post ($postId) {
  $catlist = get_the_category($postId);
  $list = '';
  foreach ($catlist as $cat) :
    $project_array = get_post(get_project_page_ID($cat->cat_ID));
    if ($project_array->post_type === 'project') :
      $link = get_permalink($project_array->ID);
      $link_text = $project_array->post_title;
      $list .= ('<li class="meta-project-list-item"><a href="'. $link .'">'. $link_text .'</a></li>');
    endif;
  endforeach;

  // here doc:
  echo <<< DOC
  <ul class="meta-project-list">
    $list
  </ul>
DOC;
}
/* print a time of the post */
function the_time_of_the_post ($postId, $format = 'Y年n月j日 G:i:s') {
  $datetime = get_the_time('Y-m-d H:i:s', false, $postId);
  $date = get_the_time($format, false, $postId);
  echo('<time datetime="' . $datetime . '">'. $date . '</time>');
}

/* return the url of "projects" page (string) */
function get_project_url () {
  $base = get_bloginfo('url');
  $path = '/projects/';
  return ($base . $path);
}
/* return the url of "projects" page (string) */
function get_about_url () {
  $base = get_bloginfo('url');
	$path = '/about/';//将来的に/about/に修正？
	return ($base . $path);
}
/* return the url of "events" page (string) */
function get_event_url () {
  $base = get_bloginfo('url');
	$path = '/events/'; //本番環境移行前にeventsスラッグの投稿のスラッグを変更しページのスラッグをeventsに変更する必要あり。(#78)
	return ($base . $path);
}
/* return the url of "addevent" page (string) */
function get_add_event_url() {
  $base = get_bloginfo('url');
	$path = '/newevent/';
	return ($base . $path);
}
/* return the url of "addproject" page (string) */
function get_add_project_url() {
  $base = get_bloginfo('url');
	$path = '/newproject/';
  return ($base . $path);
}
/* return the url of "joinmodest" page (string) */
function get_join_modest_url(){
  $base = get_bloginfo('url');
  $path = '/joinmodest/';
  return ($base . $path);
}
/* return the url of "addpost" page (string) */
function get_add_post_url(){
  $base = get_bloginfo('url');
  $path = '/newpost/';
  return ($base . $path);
}

/* return the url of "new-post-for-project" (string) */
function get_post_new_url(){
  $base = admin_url();
  $path = 'post-new.php';
  return ($base . $path);
}

/* return the url of a specified project page (string) */
function get_the_specified_project_page ($cat_id) {
  $page_id = get_project_page_ID($cat_id);
  if($page_id === false){
    return false;
  }else{
    return (get_permalink($page_id));
  }
}
/* return the ID of a specified project page */
function get_project_page_ID ($cat_id) {
  if(isset($cat_id)){
    $t_id = $cat_id;
    $cat_meta = get_option( "cat_$t_id" );
    $project_id = $cat_meta['project_id'];
    return $project_id;
  }else{
    return false;
  }
}
/* return the url of a "all-post" page (string) */
function get_all_post_url(){
  $base = get_bloginfo('url');
  $path = '/archives/';
  return ($base . $path);
}

/* read more [...] link for the_excerpt() */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($post) {
  return '<a href="'. get_permalink($post->ID) . '">' . '続きを読む...' . '</a>';
}

/* admin page  */
function my_styles(){
  $path = get_bloginfo('template_url') . '/admin/admin.css';
  wp_enqueue_style('admin-edit', $path);
}
add_action('admin_print_styles', 'my_styles');

function my_scripts(){
}
add_action('admin_print_scripts', 'my_scripts');

  /*アドオンが見つからない場合に元のナビゲーションバーを表示する。*/
function navigation_bar(){
  if(function_exists('wp_pagenavi')){
    wp_pagenavi();
  }else{
    echo '<div class="alignleft">';
    previous_posts_link(__('&laquo; 新しい投稿へ', 'kubrick'));
    echo '</div>';
    echo '<div class="alignright">';
    next_posts_link(__('前の投稿へ &raquo;', 'kubrick'));
    echo '</div>';
  }
}

function the_author_post_link_with_avatar ($size = 24) {
    $user_id = get_the_author_meta('ID');
    $url = esc_url( get_author_posts_url($user_id) );
    $author_name = get_the_author();
    $title = esc_attr($author_name) . 'の投稿を表示';
    $avatar = get_avatar($user_id, $size);
    echo '<a href="'. $url .'" title="'. $title .'" class="author-link">'. $avatar . $author_name .'</a>';
}

/***カテゴリを指定して投稿 テンプレ版***/
add_filter( 'load-post-new.php', 'cat_set_load_post_new' );
function cat_set_load_post_new()
{
    if ( array_key_exists( 'category_id', $_REQUEST ) ) {
        add_action( 'wp_insert_post', 'cat_set_wp_insert_post' );
        return;
    }
}

function cat_set_wp_insert_post( $post_id )
{
    wp_set_post_categories( $post_id, $_REQUEST['category_id'] );
}

function project_insert_post( $cat_id )
{
  if( $cat_id != ''){
    if( is_user_logged_in() ){
      echo '<a href="'.get_post_new_url(). '?category_id[]=' . $cat_id.'" class="button-blue" style="float: right;">このプロジェクトに投稿する</a>';
    }
  }
}
/***********/

/*********
* Project metadata Template
*/
function the_metadata_of_project ($id) {
?>

<dl class="project-metadata-list">
  <?php print_metadata_as_definition_item($id, 'url', '外部 Web サイト', true); ?>
</dl>

<?php
}

/*********
* Event metadata Template
*/
function the_metadata_of_event ($id) {
?>
<dl class="event-metadata-list">
  <?php print_metadata_as_definition_item($id, 'event_time', '開催時間'); ?>

  <?php print_metadata_as_definition_item($id, 'capacity', '定員'); ?>

  <?php print_metadata_as_definition_item($id, 'place', '会場'); ?>

  <?php print_metadata_as_definition_item($id, 'website', '詳細URL'); ?>

  <?php print_metadata_as_definition_item($id, 'hashtag', 'ハッシュタグ'); ?>

  <?php print_metadata_as_definition_item($id, 'event_admin', 'イベント管理者'); ?>
</dl>
<?php
}
/*
 * print a event data
 * 
 * @param $id
 *   メタ情報を出力するプロジェクト・イベントのid
 * @param $param
 *   メタ情報の内部プロパティ名
 * @param $title
 *   <html:dt>要素のテキスト
 * @param $showEmptyItem
 *   データが存在しない場合にも、dt/dd要素を出力するか？
 * @param $emptyText
 *   $showEmptyItem が TRUE の場合、dd要素のテキストとして使う文字列
 */
function print_metadata_as_definition_item ($id, $param, $title, $showEmptyItem = false, $emptyText = 'なし') {
?>
  <?php
    $content = '';
    switch ($param) {
      case 'event_time':
        $content = get_data_of_the_meta($id, 'start_time') .' - '. get_data_of_the_meta($id, 'end_time');
        break;
      case 'event_admin':
        $content = ' '; // trick to make $isEmpty false.
        break;
      default:
        $content = get_data_of_the_meta($id, $param);
        break;
    }

    $isEmpty = (strlen($content) > 0) ? false : true;
    if ($isEmpty && $showEmptyItem) {
      $content = $emptyText;
    }
  ?>

  <?php
    if ( !$isEmpty || $showEmptyItem ) :
  ?>
    <dt class="metadata-list-title"><?php echo($title); ?></dt>
    <dd>
      <?php
        switch ($param) {
          case 'event_admin':
            the_author_post_link_with_avatar();
            break;
          default:
            echo($content);
            break;
        }
      ?>
    </dd>
  <?php endif; ?>
<?php
}
function get_data_of_the_meta ($id, $param) {
  $data = get_post_meta($id, $param, true);
  $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5);
  $str = '';
  if($data){
    switch ($param) {
      case 'start_time':// for event
      case 'end_time':// for event
        $date = new DateTime();
        $date->setTimestamp($data);
        $data = $date->format('Y年n月j日 H:i');
        $datetime = $date->format('Y-m-d H:i');
        $str = '<time datetime="'. $datetime. '">'. $data .'</time>';
        break;
      case 'website':// for event
        $str = '<a href="'. $data .'">'. $data .'</a>';
        break;
      case 'hashtag':// for event
        $url = 'http://twitter.com/search?q='. urlencode($data);
        $str = '<a href="'. $url .'">'. $data .'</a>';
        break;
      case 'url':// for project
        $str = '<a href="'. $data .'">'. $data .'</a>';
        break;
      default:
        $str = $data;
        break;
    }
  }
  else{
    $str = '';
  }
  return $str;
}
function get_the_time_of_the_event ($id) {
  $date = new DateTime();
  $date->setTimestamp(get_post_meta($id, 'start_time', true));
  $year = $date->format('Y');
  $month = $date->format('n');
  $day = $date->format('j');
  $datetime = $date->format('Y-m-d H:i');

  return array(
           'datetime' => $datetime,
           'year' => $year,
           'month' => $month,
           'day' => $day,
         );
}

function the_author_data ($user_data) {
  $content = '';
  $content .= get_item_of_the_author_data($user_data, 'Web サイト', 'user_url');
  $content .= get_item_of_the_author_data($user_data, 'Twitter', 'twitter_id');
  $content .= get_item_of_the_author_data($user_data, 'Facebook', 'facebook_id');
  $content .= get_item_of_the_author_data($user_data, 'Skype', 'skype_id');

  if (strlen($content) > 0) :
?>
    <footer class="authormeta">
      <dl class="author-metadata-list">
        <?php echo $content; ?>
      </dl>
    </footer>
<?php
  endif;
}
function get_item_of_the_author_data ($user_data, $title, $param) {
  $value = $user_data->$param;
  $str = '';

  if (strlen($value) > 0) {
    $content = '';
    switch ($param) {
      case 'user_url':
        $content = '<a href="'.esc_attr($value).'">'.esc_html($value).'</a>';
        break;
      case 'twitter_id':
        $content = '<a href="http://twitter.com/'.esc_attr($value).'">'.esc_html($value).'</a>';
        break;
      case 'facebook_id':
        $content = '<a href="	http://facebook.com/'.esc_attr($value).'">'.esc_html($value).'</a>';
        break;
      default:
        $content = esc_html($value);
        break;
    }

    $str .= <<< DOC
<dt class="metadata-list-title">$title</dt>
<dd>$content</dd>
DOC;
  }

  return $str;
}

/*********
* Comment Template
*/

if ( ! function_exists( 'onemozilla_comment' ) ) :
function onemozilla_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  $comment_type = get_comment_type();
?>

 <li id="comment-<?php comment_ID(); ?>" <?php comment_class('hentry'); ?>>
  <?php if ( $comment_type == 'trackback' ) : ?>
    <h3 class="entry-title"><?php _e( 'Trackback from ', 'onemozilla' ); ?> <cite><?php esc_html(comment_author_link()); ?></cite>
      <span class="comment-meta"><?php _e('on', 'onemozilla'); ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" rel="bookmark" title=" <?php _e('Permanent link to this comment by ','onemozilla'); comment_author(); ?>"><time class="published" datetime="<?php comment_date('Y-m-d'); ?>" title="<?php comment_date('Y-m-d'); ?>"><?php comment_date('F jS, Y'); ?> at <?php comment_time(); ?></time></a>:</span>
    </h3>
  <?php elseif ( $comment_type == 'pingback' ) : ?>
    <h3 class="entry-title"><?php _e( 'Pingback from ', 'onemozilla' ); ?> <cite><?php esc_html(comment_author_link()); ?></cite>
      <span class="comment-meta"><?php _e('on', 'onemozilla'); ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" rel="bookmark" title="<?php _e('Permanent link to this comment by ','onemozilla'); comment_author(); ?>"><time class="published" datetime="<?php comment_date('Y-m-d'); ?>" title="<?php comment_date('Y-m-d'); ?>"><?php comment_date('F jS, Y'); ?> at <?php comment_time(); ?></time></a>:</span>
    </h3>
  <?php else : ?>
    <?php if ( ( $comment->comment_author_url != "http://" ) && ( $comment->comment_author_url != "" ) ) : // if author has a link ?>
     <h3 class="entry-title vcard">
       <a href="<?php comment_author_url(); ?>" class="url" rel="nofollow external" title="<?php esc_html(comment_author_url()); ?>">
         <cite class="author fn"><?php esc_html(comment_author()); ?></cite>
         <?php if (function_exists('get_avatar')) : echo ('<span class="photo">'.get_avatar( $comment, 48 ).'</span>'); endif; ?>
       </a>
       <span class="comment-meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" rel="bookmark" ><time class="published" datetime="<?php comment_date('Y-m-d'); ?>" title="<?php comment_date('Y-m-d'); ?>"><?php comment_date('Y年n月j日'); ?> <?php comment_time(); ?></time></a>:</span>
     </h3>
    <?php else : // author has no link ?>
      <h3 class="entry-title vcard">
        <cite class="author fn"><?php esc_html(comment_author()); ?></cite>
        <?php if (function_exists('get_avatar')) : echo ('<span class="photo">'.get_avatar( $comment, 48 ).'</span>'); endif; ?>
        <span class="comment-meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" rel="bookmark"><time class="published" datetime="<?php comment_date('Y-m-d'); ?>" title="<?php comment_date('Y-m-d'); ?>"><?php comment_date('Y年n月j日'); ?> <?php comment_time(); ?></time></a>:</span>
      </h3>
    <?php endif; ?>
  <?php endif; ?>

    <?php if ($comment->comment_approved == '0') : ?>
      <p class="mod"><strong><?php echo 'あなたのコメントは承認待ちです.'; ?></strong></p>
    <?php endif; ?>

    <blockquote class="entry-content">
      <?php esc_html(comment_text()); ?>
    </blockquote>

  <?php if ( (get_option('thread_comments') == true) || (current_user_can('edit_post', $comment->comment_post_ID)) ) : ?>
    <p class="comment-util"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> <?php if ( current_user_can('edit_post', $comment->comment_post_ID) ) : ?><span class="edit"><?php edit_comment_link('コメントを編集する','',''); ?></span><?php endif; ?></p>
  <?php endif; ?>
<?php
} /* end onemozilla_comment */
endif;

/*********
* Use auto-excerpts for meta description if hand-crafted exerpt is missing
*/
function fc_meta_desc() {
	$post_desc_length  = 25; // auto-excerpt length in number of words

	global $cat, $cache_categories, $wp_query, $wp_version;
	if(is_single() || is_page()) {
		$post = $wp_query->post;
		$post_custom = get_post_custom($post->ID);

    if(!empty($post->post_excerpt)) {
			$text = $post->post_excerpt;
		} else {
			$text = $post->post_content;
		}
		$text = str_replace(array("\r\n", "\r", "\n", "  "), " ", $text);
		$text = str_replace(array("\""), "", $text);
		$text = trim(strip_tags($text));
		$text = explode(' ', $text);
		if(count($text) > $post_desc_length) {
			$l = $post_desc_length;
			$ellipsis = '...';
		} else {
			$l = count($text);
			$ellipsis = '';
		}
		$description = '';
		for ($i=0; $i<$l; $i++)
			$description .= $text[$i] . ' ';

		$description .= $ellipsis;
	} 
	elseif(is_category()) {
	  $category = $wp_query->get_queried_object();
	  if (!empty($category->category_description)) {
	    $description = trim(strip_tags($category->category_description));
	  } else {
	    $description = single_cat_title('Articles posted in ');
	  }
  } 
	else {
		$description = trim(strip_tags(get_bloginfo('description')));
	}

	if($description) {
		echo $description;
	}
}

function rss_feed_list($rss_url, $count_limit) {
  $buff = "";
  $fp = fopen($rss_url,"r");
  while (!feof($fp)) {
    $buff .= fgets($fp,4096);
  }
  fclose($fp);
   
  // パーサ作成
  $parser = xml_parser_create();
  // パーサオプションを指定
  xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
  // パース実行、連想配列にパース結果代入
  xml_parse_into_struct($parser,$buff,$values,$idx);
  // パーサ開放
  xml_parser_free($parser);
  // パースして得た連想配列をまわす
  $in_item = 0;
  // トップページ用のカウンタ
  $counter = 0;

  foreach ($values as $value) {
    
    $tag  = $value["tag"];
    $type = $value["type"];
    $value = $value["value"];
    
    $tag = strtolower($tag);
    if ($tag == "item" && $type == "open") {
      $in_item = 1;
    } else if ($tag == "item" && $type == "close") {
      //Feedsの行数制限
      if($counter >= $count_limit){
        $counter = 0;
        break;
      }else{
        $counter++;
      }
     
      // community feedsの表示
  ?>
      <article class="feed-article">
         <header>
           <h1 class="feed-article-title">
             <a href="<?php echo $com_link; ?>" title="<? echo $com_title; ?>">
         <?php echo $com_title; ?>
             </a>
           </h1>
         </header>
         <footer>
           <div class="postmeta">
             <?php
         if($com_author != ''){
           echo '<p class="postmeta-title">投稿者</p>
                   <div class="postmeta-content">'
                   . $com_author .
                '</div>';
         }
         if($com_sitetitle != '' && $com_siteurl != ''){
           echo '<p class="postmeta-title">投稿サイト</p>
                   <div class="postmeta-content">
                   <a href="'.$com_siteurl.'">'
                   . $com_sitetitle .
                '</a></div>';
         }
         $com_author = '';
         $com_sitetitle = '';
         $com_siteurl ='';
         ?>
             <p class="postmeta-title">投稿日時</p>
             <div class="postmeta-content">
               <?php echo $com_date; ?>
             </div>
           </div>
         </footer>
      </article>
      <?php 
      $in_item = 0;
		  $lp++;
    }
    if ($in_item) {
      switch ($tag) {
      case "pubdate":
      case "pubDate":
        $com_date = $value;
				$com_date = strtotime($com_date);
				$com_date_number = date('YmdHi',$com_date);
				$com_date = date('Y年m月d日',$com_date);
        break;
      case "title":
        // UTF-8ドキュメントの場合ここで
        // $value = mb_convert_encoding($value, "EUC-JP", "UTF-8"); などする必要あり
        $com_title = $value;
        break;
      case "link":
        $com_link = $value;
        break;
      case "author":
        $com_author = $value;
        break;
      case "sitetitle":
        $com_sitetitle = $value;
        break;
      case "siteurl":
        $com_siteurl = $value;
        break;
      }
    }
  }
}  

?>
