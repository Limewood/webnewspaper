<?php
require_once("modules/classes/BasicNews.php");
class LatestNews extends BasicNews {
	public function LatestNews($nr, $size, $include, $exclude, $show_category) {
		parent::BasicNews($nr, $size, $include, $exclude, "uploaded", $show_category);
	}
}
?>