<?php
require_once("modules/classes/NewsForm.php");

class LineForm extends NewsForm {
	public function getHeadline($content) {
		return "<h3>".$content."</h3>";
	}
	
	public function getPublishInfo($author, $anon, $accepted, $date) {
		return $author.($anon ? " (accepted by ".$accepted.") " : " ").$date;
	}
	
	public function getIntro($intro, $img_url) {
		return $intro."\n";
	}
	
	public function getCSSClass() {
		return "line_news";
	}
}