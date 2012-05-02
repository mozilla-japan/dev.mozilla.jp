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
  <label for="search_field">ŒŸõ :</label>
  <input id="s"
         class=""
         type="text"
         name="s"
         value="<?php the_search_query(); ?>" />
  <input id="searchsubmit"
         class="button-white"
         type="submit"
         value="ŒŸõ" />
</form>