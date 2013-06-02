<?php
require_once("modules/classes/NewsForm.php");

class MediumForm extends NewsForm {
	public function getHeadline($content) {
		return "<h2>".$content."</h2>";
	}
	
	public function getPublishInfo($author, $anon, $accepted, $date) {
		return $author.($anon ? "<br />(accepted by ".$accepted.")<br />" : "<br />").$date;
	}
	
	public function getIntro($intro, $img_url) {
		return ($img_url != null && $img_url != "" ?
			 "<img src=\"".$img_url."\" />\n" : "")
			.$intro."\n";
	}
	
	public function getCSSClass() {
		return "medium_news";
	}
}
?>