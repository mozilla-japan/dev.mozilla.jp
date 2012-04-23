<?php
/*
 Template Name: post
*/

get_header(); ?>

<script>
$(document).ready(function() {
        var test = "#pro_name";
        $("#send").click(function(){
                document.write(test);
            });
});
</script>

<div id="content" class="narrowcolumn" role="main">
	<table id="post_sel">
		<tr>
			<td>
				<div id="post_blog" class="select_post">Blog Post</div>
			</td>
			<td>
				<div id="post_event" class="select_post">Event Post</div>
			</td>
			<td>
				<div id="post_project" class="select_post">Project Start</div>
			</td>
		</tr>
	</table>

	<form action="postscript.php" method="post">
		<table>
			<tr>
				<td>Project Name:</td>
				<td id="title"><input type="text" name="pro_name" size="40">
				</td>
			</tr>
			<tr>
				<td>Summary:</td>
				<td id="abst"><input type="text" name="abstruct" size="80">
				</td>
			</tr>
			<tr>
				<td>About Project:</td>
				<td id="about"><textarea name="about" rows="4" cols="60"></textarea>
				</td>
				<td><input type="submit" value="send">
				</td>
			</tr>
		</table>
	</form>
</div>


<?php get_footer(); ?>
