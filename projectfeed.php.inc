<?php
/**
 * @package WordPress
 * @subpackage modest
 */
?>

<?php

 // 外部RSSを読み込んで出力するルーチン
//$rss_url = "http://pipes.yahoo.com/pipes/pipe.run?_id=4ca627cffb9c117406bf928791b272d4&_render=rss&itemlimit=10";

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

foreach ($values as $value) {
    $tag  = $value["tag"];
    $type = $value["type"];
    $value = $value["value"];
    
    $tag = strtolower($tag);
    if ($tag == "item" && $type == "open") {
        $in_item = 1;
    } else if ($tag == "item" && $type == "close") {

		// community feedsの表示
        echo <<<EOM
			<div class = "post_row_com table-row">
				<div class = "post_datetime table-cell">
					$com_date
				</div>
				<div class = "post_container_com table-cell">
					<div class = "post_title_com">
						<a href = "$com_link">$com_title</a>
					</div>
					<div class = "post_description_space post_description">
						$com_description
					</div>
					<div class="post_gradient_space post_gradient_com"></div>
				</div>
				<div class="post_blind_space"></div>
			</div><!-- row_com -->
EOM;
        $in_item = 0;
		$lp++;
    }
    if ($in_item) {
        switch ($tag) {
            case "pubdate":
                $com_date = $value;
				$com_date = strtotime($com_date);
				$com_date_number = date('YmdHi',$com_date);
				$com_date = date('Y/m/d',$com_date);
                break;
            case "title":
                // UTF-8ドキュメントの場合ここで
                // $value = mb_convert_encoding($value, "EUC-JP", "UTF-8"); などする必要あり
                $com_title = $value;
                break;
            case "link":
                $com_link = $value;
                break;
            case "description":
                // UTF-8ドキュメントの場合ここで
                // $value = mb_convert_encoding($value, "EUC-JP", "UTF-8"); などする必要あり
                $com_description = $value;
                break;
        }
    }
}

?>

