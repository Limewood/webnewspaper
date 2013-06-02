<?php
require_once("lib/Page.php");
require_once("modules/classes/LatestNews.php");
require_once("modules/classes/MediumForm.php");

$page = new Page("templates/only_news_template.html");

$news = new LatestNews(1, new MediumForm(), NULL, NULL, true);

$page->replace_tags(array(
	"news" => $news->getOutput()
));
$page->output();
?>
