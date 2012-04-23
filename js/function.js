/*jQuery(document).ready(function($) {
 
	//下のfunction内だけ$が有効
	jQuery(document).ready(function() {
		alert("サンプルコード");
	});
 
});
*/
jQuery(document).ready(function($){
  // Search を出す処理
  jQuery("#payload_search").toggle(
    function(){
      jQuery("#topcolumn, #rightcolumn, #leftcolumn").show(200);
    },
    function(){
      jQuery("#topcolumn, #rightcolumn, #leftcolumn").hide(100);
    }
  );
});
