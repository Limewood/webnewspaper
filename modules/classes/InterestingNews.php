<?php
require_once("modules/classes/BasicNews.php");
class InterestingNews extends BasicNews {
	public function InterestingNews($nr, $size, $include, $exclude, $show_category) {
		parent::BasicNews($nr, $size, $include, $exclude, "interesting", $show_category);
	}
}
?>