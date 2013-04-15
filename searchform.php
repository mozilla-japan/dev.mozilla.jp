<?php
/**
 * @package WordPress
 * @subpackage modest3
 */
?>

<form id="searchform"
      class=""
      role="search"
      method="get"
      action="<?php echo home_url( '/' ); ?>">
  <label for="s">検索 :</label>
  <input id="s"
         class=""
         type="text"
         name="s"
         value="<?php the_search_query(); ?>"
         placeholder="modest を検索" />
  <input id="searchsubmit"
         class="button-white"
         type="submit"
         value="検索" />
</form>
