<?php
require_once("modules/classes/NewsForm.php");

class SmallForm extends NewsForm {
	public function getHeadline($content) {
		return "<h3>".$content."</h3>";
	}
	
	public function getPublishInfo($author, $anon, $accepted, $date) {
		return $author.($anon ? "<br />(accepted by ".$accepted.")<br />" : "<br />").$date;
	}
	
	public function getIntro($intro, $img_url) {
		return $intro."\n";
	}
	
	public function getCSSClass() {
		return "small_news";
	}
}
?>