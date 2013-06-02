<section id="main_submit">
	<form id="submit_form" action="ajax/upload_image.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="return validate()">
		<h2>Submit an article</h2>
		<?php
		include 'config.php';
		$author = "Anonymous";
		global $logged_in, $user_id;
		if($logged_in) {
			$result = mysql_query("SELECT name FROM ".$tableprefix."authors WHERE id='".$user_id."'");
			$row = mysql_fetch_assoc($result);
			$author = $row['name'];
		}?>
		<p>Author: <span id="submit_author"><?php echo $author; ?></span>
		<?php if(!$logged_in) {?>
			<span style="font-weight: bold;"> - please log in if you are a registered author!<br>
			Anonymous submissions need to be accepted by an editor, which can take time.</span>
		<?php }?>
		</p>
		<br />
		<p><a href="javascript:show_guidelines()">Please read the submission guidelines before submitting an article! Click here to view them.</a></p>
		<br />
		<p title="The headline of your article">Headline</p>
		<input type="text" maxlength="80" name="submit_headline" id="submit_headline" />
		<p title="A short introduction of your article">Introduction (keep short)</p>
		<textarea id="submit_intro" name="submit_intro"></textarea>
		<p class="clearfix"><p id="submit_image">Image: <input type="file" id="submit_image_upload" name="submit_image_upload" size="40" accept="image/jpeg, image/png, image/gif" onchange="uploadImage()" />
		<input type="hidden" id="submit_image_path" value="" /><iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
		<button type="button" onclick="clearImage()">Clear Image</button></p>
		<br/><p id="submit_category">Category: <select id="submit_category_select" name="submit_category_select">
		<?php
		$result = mysql_query("SELECT name, id FROM ".$tableprefix."category");
		while($row = mysql_fetch_assoc($result)) {
			echo "<option id=\"submit_category_".$row['id']."\" value=\"".$row['id']."\">".$row['name']."</option>";
		}?>
		</select></p></p>
		<p title="The main text of your article">Article text</p>
		<textarea id="submit_text" name="submit_text"></textarea>
		<button type="submit">Submit article</button>
		<button type="button" onclick="preview()">Preview</button>
		<br />
	</form>
</section>
<div id="preview_div" class="clearfix"></div>
<br />
<a href="javascript:scroll(0,0)" id="scroll_to_top">^ Scroll to top ^</a>
<div id="guidelines"><?php include("submission_guidelines.html"); ?></div>
