<?php
require_once("lib/Page.php");
require_once("modules/classes/ArticleCollection.php");
require_once("modules/classes/NewsFilter.php");

class NewslistModule {
	private $output;
	
	public function NewslistModule($heading, $num, $orderby, $controls, $search) {
		$page = new Page("templates/list_news_template.html");
	
		$articles = new ArticleCollection($num, "LineForm", $orderby, null, null, true, $search);
		
		$page->replace_tags(array(
			"heading" => $heading,
			"controls" => '<div id="controls">'.$controls.'</div>',
			"articles" => $articles->getOutput(),
			"side_news" => "modules/congress_news.php"
		));
		
		$this->output = $page->getPage();
	}
	
	public function getOutput() {
		return $this->output;
	}
}
?>