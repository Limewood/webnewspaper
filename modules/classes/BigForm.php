<?php
require_once("modules/classes/NewsForm.php");

class BigForm extends NewsForm {
	public function getHeadline($content) {
		return "<h1>".$content."</h1>";
	}
	
	public function getPublishInfo($author, $anon, $accepted, $date) {
		return $author.($anon ? " (accepted by ".$accepted.") " : " ").$date;
	}
	
	public function getIntro($intro, $img_url) {
		return $intro."\n"
			.($img_url != null  && $img_url != "" ?
				 "<img src=\"".$img_url."\" />\n" : "");
	}
	
	public function getCSSClass() {
		return "big_news";
	}
}
?>