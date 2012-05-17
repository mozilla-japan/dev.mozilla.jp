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
	add_filter( 'show_admin_bar', '__return_false' ); //adminバーを見えないようにする。

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

add_action('init','create_Contact',0);
function create_Contact(){
	register_post_type(
        'contact_page',
	array(
            'label' => 'コンタクト',
            'public' => true,
            'show_ui' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'supports' => array(
                'title',
                'editor'
                )
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
	$cat = get_post_meta($post->ID, 'cat', true);
	echo wp_nonce_field('menu_meta', 'menu_cat_nonce');
	echo '<p>カテゴリのスラッグ:<input type="text" size="50" name="cat" value="'.$cat.'"></p>';
	$url = get_post_meta($post->ID, 'url', true);
	echo wp_nonce_field('menu_meta', 'menu_meta_nonce');
	echo '<p>プロジェクトのWebサイト: http://<input type="text" size="50" name="url" value="'.$url.'"></p>';
	$email = get_post_meta($post->ID, 'email', true);
	echo wp_nonce_field('menu_meta', 'menu_email_nonce');
	echo '<p>プロジェクトの公開用メールアドレス:<input type="text" size="50" name="email" value="'.$email.'"></p>';
}

/*
 * イベントのポスト画面に新たに情報フォームを追加する
 */

function event_meta_box($post){
    add_meta_box('event_meta', 'イベント情報', 'event_meta_html', 'event', 'normal', 'high');
}

function event_meta_html($post, $box){
  echo '<label for="start_time">開始日時</label>';
  echo '<input class="datepicker" type="text" name="start_time" value="'. get_post_meta($post->ID, 'start_time', true) .'" size="25" />';
  echo '<a class="clear_start_time" href="#start_time">クリア</a>';

  echo '<label for="end_time"> 〜 終了日時</label>';
  echo '<input class="datepicker" type="text" name="end_time" value="'. get_post_meta($post->ID, 'end_time', true) .'" size="25" />';
  echo '<a class="clear_end_time" href="#end_time">クリア</a>';

  $place = get_post_meta($post->ID, '会場', true);
  echo wp_nonce_field('event_meta', 'event_date_nonce');
  echo '<p>会場:<input type="text" size="50" name="place" value="'.$place.'"></p>';
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
  echo '<tr class="form-field">';
  echo '<th><label for="Cat_meta[project_id]">プロジェクトID</label></th>';
  echo '<td><input type="text" name="Cat_meta[project_id]" id="project_id" size="25" value="'. $value .'" /></td>"';
  echo '</tr>';
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
	if(wp_is_post_revision($post_id)){
	$post_id = wp_is_post_revision($post_id);
	}
	*/
	$post_info = get_post($post_id);

	if($post_info->post_type == 'project' && get_post_status($post_id) == 'publish'){
		$title = $post_info->post_title;
		$desc = $post_info->post_excerpt;

		$slug = $_POST['cat'];
		$catid = (int)get_post_meta($post_id, 'catid', true);
		$contact_id = (int)get_post_meta($post_id, 'contact_id', true);
		//コンタクトページの作成
		$contact_post = array();
		$contact_post['ID'] = $contact_id;
		$contact_post['post_type'] = 'contact_page';
		$contact_post['post_title'] = $title.'へのコンタクト';
		//コンタクトフォームはサーバにアップすると変わるかもしれない．37がmichi.mozlabs.jp用 2108がLocalhost用
		$contact_post['post_content'] = '[contact-form-7 id="37" title="Contact Form"],[contact-form-7 id="2108" title="Contact Form"]';
		$contact_post['post_status'] = 'publish';
		$contact_id = wp_update_post( $contact_post );
		update_post_meta($post_id, 'contact_id', $contact_id);
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
      $cat_meta = get_option( "cat_$t_id" );
      $cat_meta['project_id'] = $post_id;
      update_option( "cat_$t_id", $cat_meta);
		}
	}
}

add_action('before_delete_post', 'delete_project');
function delete_project($post_id){
	$post_info = get_post($post_id);
	if($post_info->post_type == 'project'){
		$catid = (int)get_post_meta($post_id, 'catid', true);
		$contact_id = (int)get_post_meta($post_id, 'contact_id', true);
		wp_delete_category( $catid );
		wp_delete_post( $contact_id );
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

    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $place = trim($_POST['place']);

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
}

add_action('save_post', 'menu_update');
function menu_update($post_id){
	if(!wp_verify_nonce( $_POST['menu_email_nonce'], 'menu_meta')){
		return $post_id;
	}
	if(!wp_verify_nonce( $_POST['menu_cat_nonce'], 'menu_meta')){
		return $post_id;
	}
	if(!wp_verify_nonce( $_POST['menu_meta_nonce'], 'menu_meta')){
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

	$cat = trim($_POST['cat']);
	$url = trim($_POST['url']);
	$email = trim($_POST['email']);

	if($email == ''){
		delete_post_meta($post_id, 'email');
	} else {
		update_post_meta($post_id, 'email', $email);
	}
	if($cat == ''){
		delete_post_meta($post_id, 'cat');
	} else {
		update_post_meta($post_id, 'cat', $cat);
	}
	if($url == ''){
		delete_post_meta($post_id, 'url');
	} else {
		update_post_meta($post_id, 'url', $url);
	}
}

add_filter('wpcf7_form_tag', 'my_form_tag_filter', 11);
function my_form_tag_filter($tag){
	if( ! is_array($tag)){
		return $tag;
	}

	$name = $tag['name'];

	if(is_user_logged_in()){
		global $current_user;
		get_currentuserinfo();

		if($name == 'your-name'){
			$tag['values'] = (array) $current_user -> display_name;
		}else if($name == 'your-email'){
			$tag['values'] = (array) $current_user -> user_email;
		}else if($name == 'the-author'){
			$email = get_post_meta(get_the_ID(), 'email', true);
			$tag['values'] = $email;
		}
	}
	return $tag;
}

/*
 * RSS読み込み
 */
include_once("./wp-load.php");
include_once(ABSPATH . WPINC . '/rss.php'); //MagpieRSS of Wordpress
//RSSのキャッシュ設定
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
define('MAGPIE_CACHE_DIR', './cache');
define('MAGPIE_FETCH_TIME_OUT', 40);
define('MAGPIE_CACHE_AGE', 15*60);

function mixed_rss($rssURL){
    foreach($rssURL as $key => $val){
        $rssObj = fetch_rss($val);
        $items[$key] = $rssObj->items;
        $btitle = $rssObj->channel['title'];
        $blink = $rssObj->channel['link'];
        foreach($items[$key] as $item){
            $item["btitle"] = $btitle;
            $item["blink"] = $blink;
            $entry[] = $item;
            if(isset($item["pubdate"])){
                $entryDate[] = strtotime($item["pubdate"]);
            }
            if(isset($item["dc"]["date"])){
                $entryDate[] = strtotime($item["bc"]["date"]);
            }
        }
    }
    array_multisort($entryDate,SORT_DESC,SORT_NUMERIC,$entry);
    return $entry;
}

/*
 *　ここまでRSSに関する記述
 */

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

/* return the url of "projects" page (string) */
function get_project_url () {
  $base = get_bloginfo('url');
  $path = '/projects/';
  return ($base . $path);
}
/* return the url of "projects" page (string) */
function get_about_url () {
  $base = get_bloginfo('url');
	$path = '/aboutmodest/';//将来的に/about/に修正？
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
	$path = '/addevent/';
	return ($base . $path);
}
/* return the url of "addproject" page (string) */
function get_add_project_url() {
  $base = get_bloginfo('url');
	$path = '/addproject/';
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
  $path = '/addpost/';
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


/* read more [...] link for the_excerpt() */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($post) {
  return '<a href="'. get_permalink($post->ID) . '">' . '続きを読む...' . '</a>';
}

/* Event Calender UI */
function my_styles(){
  wp_enqueue_style('my-jquery-ui', get_bloginfo('template_url') . '/jquery-ui/css/smoothness/jquery-ui-1.8.20.custom.css', array(), '1.7.2', 'all');
}
add_action('admin_print_styles', 'my_styles');

function my_scripts(){
  wp_enqueue_script('my-jquery-ui', get_bloginfo('template_url') . '/jquery-ui/js/jquery-ui-1.8.20.custom.min.js', array('jquery'), '1.7.2', true);
  wp_enqueue_script('my-jquery-localize', get_bloginfo('template_url') . '/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-ja.js', array('my-jquery-ui'), '1.7.2', true);
  wp_enqueue_script('my-jquery-addon', get_bloginfo('template_url') . '/jquery-ui/development-bundle/ui/jquery-ui-timepicker-addon.js', array('my-jquery-ui'), '1.7.2', true);

  wp_enqueue_script('my-admin-script', get_bloginfo('template_url') . '/js/admin-script.js', array('my-jquery-ui'), false, true);
}
add_action('admin_print_scripts', 'my_scripts');

?>
